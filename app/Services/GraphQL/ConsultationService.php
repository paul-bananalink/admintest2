<?php

namespace App\Services\GraphQL;

use App\Events\Client\CountNotificationEvent;
use App\Repositories\ConsultationRepository;
use Illuminate\Support\Facades\Auth;
use App\Events\Client\RenderRowConsultationEvent;
use App\Repositories\AutoReplyRepository;

class ConsultationService
{
    public function __construct(
        private ConsultationRepository $consultationRepo,
        private AutoReplyRepository $autoReplyRepo,
    ) {
    }

    public function create(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $model = $this->consultationRepo->create(
            array_merge($attributes, [
                'mNo' => $member->mNo,
                'status' => 1,
            ])
        );
        if ($model) {
            event(new CountNotificationEvent('consultation'));
            event(new RenderRowConsultationEvent($model, 'consultation'));
        }

        return $model;
    }

    public function getList(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $page = $attributes['page'];
        $limit = $attributes['limit'];

        return $this->consultationRepo->paginateWithConditions($page, $limit, [['id', 'desc']], ['where' => [['mNo', $member->mNo], ['show_ui', 1]]]);
    }

    public function createByAutoSend(array $attributes = [])
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $model = $this->consultationRepo->create(
            array_merge($attributes, [
                'mNo' => $member->mNo,
                'status' => 1,
                'type' => \App\Models\Consultation::TYPE_AUTO_SEND,
            ])
        );
        if ($model) {
            $update_record = $this->autoReply($model->id, $member->mLevel);
            event(new CountNotificationEvent('consultation'));
            event(new RenderRowConsultationEvent($update_record, 'consultation'));
        }

        return $model;
    }

    private function autoReply($id, $mLevel)
    {
        $model = $this->consultationRepo->getByPK($id);

        if (app('site_info')->siAutoReplyConsultation) {
            $content_reply_by_level = $this->autoReplyRepo->firstAutoReplyByLevel($mLevel)->arContent ?? null;
            if ($content_reply_by_level) {

                $model->content_reply = $content_reply_by_level;
                $model->date_feedback = now();
                $model->status = \App\Models\Consultation::STATUS_REPLIED;

                if ($model->save()) {
                    return $model;
                }
            }
        }
        return $model;
    }

    public function checkRequireReply()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->consultationRepo->checkRequireReply($member->mNo);
    }

    public function getNextTimeConsultation()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        $siReinquiryTimeInterval = app('site_info')->siReinquiryTimeInterval ?? null;

        return $siReinquiryTimeInterval ? $this->consultationRepo->getLatest($member->mNo)?->created_at->addMinutes($siReinquiryTimeInterval) : now();
    }

    public function deleteByListId(array $attributes = [])
    {
        $ids = explode(',', $attributes['ids']);

        $deleted = $this->consultationRepo->deleteByListId($ids);

        return ['status' => $deleted ? true : false];
    }
}
