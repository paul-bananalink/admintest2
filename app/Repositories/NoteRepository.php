<?php

namespace App\Repositories;

use Carbon\Carbon;

class NoteRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Abstract Function's serve for initialize model transmission
     */
    protected function getModel(): string
    {
        return \App\Models\Note::class;
    }

    public function getAllNoteByMemberId($page, $limit, int $memberId)
    {
        $time = app('site_info')->siClientMessageRetentionTime ?? null;
        $fromTime = $time ? Carbon::now()->subMinutes($time) : null;

        return $this->model
            ->where(function ($query) use ($memberId) {
                $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                    ->where('mNo_receive', $memberId)
                    ->orWhere(function ($query) use ($memberId) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereJsonContains('mNo_receive_list', [$memberId => 0])
                            ->orWhereJsonContains('mNo_receive_list', [$memberId => 1]);
                    });
            })
            ->where(function ($query) use ($memberId) {
                $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                    ->whereJsonDoesntContain('deleted_by_list', $memberId)
                    ->orWhereNull('deleted_by_list');
            })
            ->when($fromTime, function ($query) use ($fromTime) {
                $query->where('updated_at', '>=', $fromTime);
            })
            ->where('status', 1)
            ->where('show_ui', 1) // has not been revoked
            ->orderBy('id', 'DESC')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function updateReadAll(int $memberId)
    {
        $res = $this->model
            ->select('id', 'type', 'mNo_receive_list', 'mNo_receive', 'is_read', 'date_read')
            ->where(function ($query) use ($memberId) {
                $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                    ->where('mNo_receive', $memberId)
                    ->where('is_read', 0)
                    ->orWhere(function ($query) use ($memberId) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereJsonContains('mNo_receive_list', [$memberId => 0]);
                    });
            })
            ->where(function ($query) use ($memberId) {
                $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                    ->whereJsonDoesntContain('deleted_by_list', $memberId)
                    ->orWhereNull('deleted_by_list');
            })
            ->where('status', 1)
            ->get();


        foreach ($res as $item) {
            if ($item->type == \App\Models\Note::TYPE_ONLY_USER) {
                $item->is_read = 1;
            } else {
                if ($item->mNo_receive_list) {
                    $decode = json_decode($item->mNo_receive_list, true);
                    if ($decode[$memberId] === 0) {
                        $decode[$memberId] = 1;
                        $item->mNo_receive_list = json_encode($decode);
                    }
                }
            }

            $item->date_read = date('Y-m-d H:i:s');
            $item->save();
        }

        return true;
    }

    public function countNoteNoReadBell(int $memberId)
    {
        $time = app('site_info')->siClientMessageRetentionTime ?? null;
        $fromTime = $time ? Carbon::now()->subMinutes($time) : null;

        $res = $this->model
            ->select('id', 'noticed')
            ->where(function ($query) use ($memberId) {
                $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                    ->where('mNo_receive', $memberId)
                    ->where('noticed', null)
                    ->orWhere(function ($query) use ($memberId) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereJsonContains('mNo_receive_list', [$memberId => 0])
                            ->orWhereJsonContains('mNo_receive_list', [$memberId => 1]);
                    });
            })
            ->where(function ($query) use ($memberId) {
                $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                    ->whereJsonDoesntContain('deleted_by_list', $memberId)
                    ->orWhereNull('deleted_by_list');
            })
            // page setting time
            ->when($fromTime, function ($query) use ($fromTime) {
                $query->where('updated_at', '>=', $fromTime);
            })
            ->where('status', 1)
            ->where('show_ui', 1) // has not been revoked
            ->get();


        foreach ($res as $key => $item) {
            if ($item->noticed) {
                $decode = json_decode($item->noticed, true);
                if (in_array($memberId, $decode)) {
                    unset($res[$key]);
                }
            }
        }

        return $res->count();
    }

    public function updateNoticedisReadAll(int $memberId)
    {
        $res = $this->model
            ->select('id', 'type', 'noticed')
            ->where(function ($query) use ($memberId) {
                $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                    ->where('mNo_receive', $memberId)
                    ->where('noticed', null)
                    ->orWhere(function ($query) use ($memberId) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereJsonContains('mNo_receive_list', [$memberId => 0])
                            ->orWhereJsonContains('mNo_receive_list', [$memberId => 1]);
                    });
            })->where('status', 1)->get();

        foreach ($res as $item) {
            if ($item->type == \App\Models\Note::TYPE_ONLY_USER) {
                $item->noticed = 1;
            } else {
                // Case type all user
                if ($item->noticed) {
                    $decode = json_decode($item->noticed, true);
                    if (!in_array($memberId, $decode)) {
                        $decode[] = $memberId;
                        $item->noticed = json_encode($decode);
                    }
                } else {
                    $item->noticed = json_encode([$memberId]);
                }
            }

            $item->save();
        }

        return true;
    }

    public function deleteAllNoteIsRead(int $adminID)
    {

        $res = $this->model
            ->select('id', 'type', 'mNo_receive_list', 'is_read')
            ->where('mNo', $adminID)
            ->get();

        foreach ($res as $item) {
            if ($item->isRead()) {
                $item->delete();
            }
        }

        return true;
    }

    public function deleteAllNote(int $adminID)
    {
        return $this->model::query()->delete();
    }

    public function updateRead(int $id, int $memberId)
    {
        $note = $this->model->find($id);

        if ($note) {

            $note->date_read = now();

            if ($note->type == \App\Models\Note::TYPE_ONLY_USER && $note->is_read == 0) {
                $note->is_read = 1;
            } else {
                $arr = json_decode($note->mNo_receive_list, true);
                if (isset($arr[$memberId]) && $arr[$memberId] == 0) {
                    $arr[$memberId] = 1;
                    $note->mNo_receive_list = json_encode($arr);
                }
            }

            if ($note->save()) {
                return true;
            }
        }

        return false;
    }

    public function countNoteNoRead(int $memberId)
    {
        $time = app('site_info')->siClientMessageRetentionTime ?? null;
        $fromTime = $time ? Carbon::now()->subMinutes($time) : null;

        $res = $this->model
            ->where(function ($query) use ($memberId) {
                $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                    ->where('mNo_receive', $memberId)
                    ->where('is_read', 0)
                    ->orWhere(function ($query) use ($memberId) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereJsonContains('mNo_receive_list', [$memberId => 0]);
                    });
            })
            ->where(function ($query) use ($memberId) {
                $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                    ->whereJsonDoesntContain('deleted_by_list', $memberId)
                    ->orWhereNull('deleted_by_list');
            })
            // page setting time
            ->when($fromTime, function ($query) use ($fromTime) {
                $query->where('updated_at', '>=', $fromTime);
            })
            ->where('status', 1)
            ->where('show_ui', 1) // has not been revoked
            ->get();

        return $res->count();
    }

    public function getAll($per_page, array $search)
    {
        $query = $this->model->where('show_ui', 1);

        if ($search['field'] && $search['value']) {
            if ($search['field'] === 'member_id') {
                $memberId = $search['value'];
                $query = $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                    ->where('mNo_receive', $memberId)
                    ->orWhere(function ($query) use ($memberId) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereJsonContains('mNo_receive_list', [$memberId => 0])
                            ->orWhereJsonContains('mNo_receive_list', [$memberId => 1]);
                    });
            }

            if ($search['field'] === 'content') {
                $query = $query->where('content', 'like', '%' . $search['value'] . '%');
            }
        }

        if ($status = request('status')) {

            if ($status === 'read') {
                $query = $query->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                            ->where('is_read', 1);
                    })->orWhere(function ($query) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereRaw('JSON_SEARCH(mNo_receive_list, "one", "0") IS NULL');
                    });
                });
            }

            if ($status === 'no_read') {
                $query = $query->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('type', \App\Models\Note::TYPE_ONLY_USER)
                            ->where('is_read', 0);
                    })->orWhere(function ($query) {
                        $query->where('type', '!=', \App\Models\Note::TYPE_ONLY_USER)
                            ->whereRaw('JSON_SEARCH(mNo_receive_list, "one", "0") IS NOT NULL');
                    });
                });
            }
        }

        return $query->orderBy('created_at', 'DESC')->paginate($per_page);
    }
}
