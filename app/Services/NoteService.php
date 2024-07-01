<?php

namespace App\Services;

use App\Events\Client\CountNoteNoReadEvent;
use App\Models\Member;
use App\Repositories\NoteRepository;
use App\Repositories\PartnerRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MemberRepository;
use Illuminate\Support\Str;

class NoteService extends BaseService
{
    protected $noteRepo;
    protected $partnerRepo;
    protected $memberRepo;

    public function __construct()
    {
        $this->noteRepo = new NoteRepository();
        $this->partnerRepo = new PartnerRepository();
        $this->memberRepo = new MemberRepository();
    }

    public function addNote(array $attributes = [])
    {
        $attributes['mNo'] = Auth::user()->mNo ?? $this->memberRepo->getMemberByMID('superadmin')->mNo;
        $attributes['type'] = data_get($attributes, 'type');
        $attributes['uuid'] = Str::uuid()->toString();
        $mNo_receive_list = null;

        if ($attributes['type'] == \App\Models\Note::TYPE_SEND_LIST_USER && isset($attributes['member_list'])) {
            $mNo_receive_list = $this->handelCaseSendListUser($attributes['member_list']);
        } elseif ($attributes['type'] == \App\Models\Note::TYPE_SEND_USER_LEVEL && isset($attributes['level'])) {

            $mNo_receive_list = $this->handelCaseSendListMemberLevel($attributes['level']);
        } elseif ($attributes['type'] == \App\Models\Note::TYPE_SEND_PARTNER && isset($attributes['partner'])) {

            $mNo_receive_list = $this->handelCaseSendPartner($attributes['partner']);
        } elseif ($attributes['type'] == \App\Models\Note::TYPE_ALL_USER) {

            $mNo_receive_list = $this->endcodeUserReceive(
                $this->listUserSendNote()->pluck(['mNo'])
            );
        }

        if ($mNo_receive_list == "[]" || $mNo_receive_list == null) {
            return false;
        }

        $attributes['mNo_receive_list'] = $mNo_receive_list;

        return $this->tryCatchFuncDB(function () use ($attributes) {
            $created = $this->noteRepo->create($attributes);
            $this->sendNote($created->id);
        });
    }

    public function handelCaseSendListUser(string $member_list)
    {
        $mIDs = explode("\r\n", $member_list);
        $uniqueMIDs = array_unique($mIDs);
        $members = \App\Models\Member::whereIn('mID', $uniqueMIDs)
            ->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->where('mStatus', Member::M_STATUS_NINE)
            ->pluck('mNo');

        return $this->endcodeUserReceive($members);
    }

    public function handelCaseSendListMemberLevel($level)
    {
        $members = \App\Models\Member::where('mLevel', $level)
            ->where('mStatus', Member::M_STATUS_NINE)
            ->pluck('mNo');

        if ($members->isEmpty()) return null;

        return $this->endcodeUserReceive($members);
    }

    public function handelCaseSendPartner(array $partner_type)
    {
        $partners = $this->partnerRepo->getPartnersByListType($partner_type);

        if (!$partners) return null;

        $mIDs = $partners->pluck('mID')->toArray();

        $members = \App\Models\Member::whereIn('mID', $mIDs)
            ->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->where('mStatus', Member::M_STATUS_NINE)
            ->pluck('mNo');

        if ($members->isEmpty()) return null;

        return $this->endcodeUserReceive($members);
    }

    public function sendNoteToUser(array $attrs = [])
    {
        $attrs['mNo'] = Auth::user()->mNo;
        $attrs['type'] = \App\Models\Note::TYPE_ONLY_USER;
        $attrs['status'] = 1;

        $created = $this->noteRepo->create($attrs);

        if ($created) {
            event(new CountNoteNoReadEvent(data_get($attrs, 'mNo_receive')));
        }

        return $created;
    }

    public function getAll()
    {
        $search['field'] = request('search_by', null);
        $search['value'] = request('search_input');

        if ($search_by = request('search_by')) {
            if ($search_by == 'member_id' && request('search_input')) {
                $member = $this->memberRepo->getMemberByMID(request('search_input'));
                if ($member) {
                    $search['value'] = $member->mNo;
                }
            }
        }

        $per_page = request('per_page', self::COUNT_PER_PAGE);

        return $this->noteRepo->getAll($per_page, $search);
    }

    public function listUserSendNote()
    {
        return \App\Models\Member::where('mStatus', \App\Models\Member::M_STATUS_NINE)
            ->whereNotIn('mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE)
            ->get();
    }

    private function endcodeUserReceive($data)
    {
        $resultArr = $data->mapWithKeys(function ($item) {
            return [$item => 0];
        });

        return json_encode($resultArr);
    }

    public function sendNote($id)
    {
        $note = $this->noteRepo->getByPK($id);

        if (!$note) return false;
        switch ($note->type) {
            case \App\Models\Note::TYPE_SEND_LIST_USER:
                $this->handleActionSendNoteToListUser($note);
                break;

            case \App\Models\Note::TYPE_SEND_USER_LEVEL:
                $this->handleActionSendNoteToListMemberLevel($note);
                break;

            case \App\Models\Note::TYPE_ALL_USER:
                $this->handleActionSendNoteToAllUser($note);
                break;

            case \App\Models\Note::TYPE_SEND_PARTNER:
                $this->handleActionSendNoteToListUser($note);
                break;
        }
    }

    public function handleActionSendNoteToListUser($note)
    {
        if (!$note->mNo_receive_list) return false;

        $decodedData = json_decode($note->mNo_receive_list, true);

        $mIDs = array_keys($decodedData);

        if (!$mIDs) return false;

        $note->status = 1; // status = 1 is send

        if ($note->save()) {
            foreach ($mIDs as $mID) {
                event(new CountNoteNoReadEvent($mID));
            }
        }
    }

    public function handleActionSendNoteToAllUser($note)
    {
        $note->status = 1; // status = 1 is send

        if ($note->save()) {
            event(new CountNoteNoReadEvent('all'));
            return true;
        }
    }

    public function handleActionSendNoteToListMemberLevel($note)
    {
        if (!$note->mNo_receive_list) return false;

        $decodedData = json_decode($note->mNo_receive_list, true);

        $mIDs = array_keys($decodedData);

        if (!$mIDs) return false;

        $mLevels = \App\Models\Member::whereIn('mNo', $mIDs)
            ->where('mStatus', Member::M_STATUS_NINE)
            ->pluck('mLevel')->toArray();

        $mLevels = array_unique($mLevels);

        $note->status = 1; // status = 1 is send

        if ($note->save()) {
            foreach ($mLevels as $mLevels) {
                $chanel_name = 'level-' . $mLevels;
                event(new CountNoteNoReadEvent($chanel_name));
            }
        }
    }

    public function deleteAllNote()
    {
        return $this->noteRepo->deleteAllNote(Auth::user()->mNo);
    }

    public function deleteAllNoteIsRead()
    {
        return $this->noteRepo->deleteAllNoteIsRead(Auth::user()->mNo);
    }

    public function recall(string $uuid): array
    {
        $note = $this->noteRepo->getFirstWithConditions([['uuid', $uuid]]);

        if (!$note) return ['status' => false, 'message' => '찾을 수없습니다.'];

        if (!$note->show_ui) return ['status' => false, 'message' => '이 쪽지가 회수되였습니다.'];

        $note->show_ui = 0;

        if ($note->save()) {
            return ['status' => true, 'message' => '회수되였습니다.'];
        } else {
            return ['status' => false, 'message' => '회수가 실패되였습니다.'];
        }
    }
}
