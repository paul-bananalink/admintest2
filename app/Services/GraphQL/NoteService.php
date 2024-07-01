<?php

namespace App\Services\GraphQL;

use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use App\Events\Client\CountNoteNoReadEvent;
use Illuminate\Support\Str;

class NoteService
{
    public function __construct(
        private NoteRepository $noteRepo
    ) {
    }

    public function paginate(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $page = $attributes['page'] ?? 1;
        $limit = $attributes['limit'] ?? 10;

        return $this->noteRepo->getAllNoteByMemberId($page, $limit, $member->mNo);
    }

    public function updateReadAll()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->noteRepo->updateReadAll($member->mNo);
    }

    public function delete(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $res = [];
        $ids = explode(',', $attributes['ids']);

        foreach ($ids as $id) {
            $is_deleted = true;
            $note = $this->noteRepo->getByPK($id);

            if ($note) {
                if ($note->type == \App\Models\Note::TYPE_ONLY_USER) {
                    $is_deleted = $note->delete();
                } else {
                    if ($note->deleted_by_list) {
                        $decode = json_decode($note->deleted_by_list, true);
                        if (!in_array($member->mNo, $decode)) {
                            $decode[] = $member->mNo;
                            $note->deleted_by_list = json_encode($decode);
                        }
                    } else {
                        $note->deleted_by_list = json_encode([$member->mNo]);
                    }

                    if ($note->save()) {
                        $is_deleted = true;
                    }
                }
            } else {
                $is_deleted = false;
            }

            $res[] = ['id' => (int) $id, 'is_deleted' => (bool) $is_deleted];
        }

        return $res;
    }

    public function countNote()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return [
            'count' => $this->noteRepo->countNoteNoReadBell($member->mNo),
            'count_no_read' => $this->noteRepo->countNoteNoRead($member->mNo)
        ];
    }

    public function updateNoticedisReadAll()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->noteRepo->updateNoticedisReadAll($member->mNo);
    }

    public function updateRead(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->noteRepo->updateRead($attributes['id'], $member->mNo);
    }

    public function sendNoteToUser($mNo_receive): void
    {
        $content = data_get(app('site_info'), 'siMemberNoteContents', '');

        if ($content !== '') {
            $attrs['mNo'] = Auth::user()->mNo;
            $attrs['uuid'] = Str::uuid()->toString();
            $attrs['type'] = \App\Models\Note::TYPE_ONLY_USER;
            $attrs['title'] = $this->getTitleByContent($content);
            $attrs['content'] = $content;
            $attrs['mNo_receive'] = $mNo_receive;
            $attrs['status'] = 1;

            $created = $this->noteRepo->create($attrs);

            if ($created) {
                event(new CountNoteNoReadEvent(data_get($attrs, 'mNo_receive')));
            }
        }
    }

    private function getTitleByContent(string $content)
    {
        if ($content) {

            $parts = preg_split('/\r\n/', trim($content));
            $firstLine = trim(strip_tags($parts[0]));
            if (mb_strlen($firstLine) > 100) {
                $firstLine = mb_substr($firstLine, 0, 100);
            }

            return $firstLine;
        }

        return '';
    }
}
