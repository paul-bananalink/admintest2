<?php

namespace App\Services\GraphQL;

use App\Repositories\NoticeRepository;

class NoticeService
{
    public function __construct(
        private NoticeRepository $noticeRepo
    ) {
    }

    public function paginate(array $attributes = [])
    {
        $page = $attributes['page'] ?? 1;
        $limit = $attributes['limit'] ?? 10;

        $ntType = $attributes['ntType'];
        $conditions = [];

        if ($ntType === 'event') {
            $categories = array_keys(config('constant_view.NOTICE_CATEGORY.EVENTS'));
        }elseif ($ntType === 'rule') {
            $categories = array_keys(config('constant_view.NOTICE_CATEGORY.RULES'));
        }

        if (isset($attributes['filter'])) {
            if (in_array($attributes['filter'], $categories)) {
                $conditions[] = ['ntCategory', '=', $attributes['filter']];
            }
        }

        return $this->noticeRepo->getAllNotice($attributes, $page, $limit, $conditions);
    }

    public function categoryList(array $attributes = [])
    {
        $ntType = $attributes['ntType'];

        if ($ntType === 'event') {
            $category = config('constant_view.NOTICE_CATEGORY.EVENTS');
        } elseif ($ntType === 'rule') {
            $category = config('constant_view.NOTICE_CATEGORY.RULES');
        }

        foreach ($category as $key => $value) {
            $data[] = [
                'category_id' => $key,
                'category_name' => $value,
            ];
        }
            
        return $data;
        }
}
