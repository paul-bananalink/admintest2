<?php

namespace App\Services\GraphQL;

use App\Repositories\NewsletterRepository;
use Illuminate\Support\Facades\Auth;

class NewsBoardService
{
    public function __construct(
        private NewsletterRepository $newsletterRepo
    ) {
    }

    public function paginate(array $attributes = [])
    {
        $page = $attributes['page'];
        $limit = $attributes['limit'];
        $conditions = [];

        if (isset($attributes['filter'])) {
            $filter = json_decode($attributes['filter'], true);

            if (isset($filter['name']) && isset($filter['value'])) {
                $conditions[] = [$filter['name'], $filter['value']];
            }
        }

        $conditions[] = ['show_ui', \App\Models\Newsletter::STATUS_ACTIVE];
        $conditions[] = ['type', \App\Models\Newsletter::TYPE_NEWSBOARD];

        return $this->newsletterRepo->paginateWithConditions($page, $limit, [['created_date', 'desc']], ['where' => $conditions]);
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

    public function countNoticed()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->newsletterRepo->countNoticed($member->mNo, \App\Models\Newsletter::TYPE_NEWSBOARD);
    }

    public function updateNoticedisReadAll()
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = Auth::guard($guard)->user();

        return $this->newsletterRepo->updateNoticedisReadAll($member->mNo, \App\Models\Newsletter::TYPE_NEWSBOARD);
    }

    public function categoryList()
    {
        $categories_newboard = \App\Models\Newsletter::$categories_newboard;

        foreach ($categories_newboard as $key => $value) {
            $categories[] = [
                'category_id' => $key,
                'category_name' => $value
            ];
        }

        return $categories ?? [];
    }
}
