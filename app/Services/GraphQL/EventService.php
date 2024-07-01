<?php

namespace App\Services\GraphQL;

use App\Repositories\NewsletterRepository;
use Illuminate\Support\Facades\Auth;

class EventService
{
    public function __construct(
        private NewsletterRepository $newsletterRepo
    ) {
    }

    public function paginate(array $attributes = [])
    {
        $page = $attributes['page'];
        $limit = $attributes['limit'];

        return $this->newsletterRepo->paginateWithConditions($page, $limit, [['id', 'desc']], ['where' => [
            ['show_ui', \App\Models\Newsletter::STATUS_ACTIVE],
            ['type', \App\Models\Newsletter::TYPE_EVENT]
        ]]);
    }

    public function updateViewCount(array $attributes = [])
    {
        $id = $attributes['id'];

        $newsletter = $this->newsletterRepo->getByPK($id);

        if (!$newsletter) {
            return ['status' => false];
        }

        $newsletter->views += 1;
        $newsletter->save();

        return ['status' => true];
    }

    public function countEventNoticed()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->newsletterRepo->countNoticed($member->mNo, \App\Models\Newsletter::TYPE_EVENT);
    }

    public function updateNoticedisReadAll()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->newsletterRepo->updateNoticedisReadAll($member->mNo, \App\Models\Newsletter::TYPE_EVENT);
    }
}
