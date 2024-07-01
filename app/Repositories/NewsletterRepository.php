<?php

namespace App\Repositories;

class NewsletterRepository extends BaseRepository
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
        return \App\Models\Newsletter::class;
    }

    public function getAllEvent(): object
    {
        $conditions = [
            ['type', \App\Models\Newsletter::TYPE_EVENT],
        ];

        $per_page = request('per_page', \App\Services\BaseService::COUNT_PER_PAGE);

        return $this->getPaginate($per_page, $conditions);
    }

    public function getAllNewsBoard(): object
    {
        if (request('category')) {
            $conditions[] = ['category', request('category')];
        }

        $conditions[] = ['type', \App\Models\Newsletter::TYPE_NEWSBOARD];

        $per_page = request('per_page', \App\Services\BaseService::COUNT_PER_PAGE);

        return $this->getPaginate($per_page, $conditions);
    }

    public function createNewsBoard(array $data): object
    {
        $data = $this->setAttr($data, \App\Models\Newsletter::TYPE_NEWSBOARD);

        return $this->model->create($data);
    }

    public function createEvent(array $data): object
    {
        $data = $this->setAttr($data, \App\Models\Newsletter::TYPE_EVENT);

        return $this->model->create($data);
    }

    private function setAttr(array $data, $type): array
    {
        $data['mNo_writer'] = auth()->user()->mNo;
        $data['status'] = 1;
        $data['views'] = 0;
        $data['type'] = $type;
        $data['data'] = data_get($data, 'category', null);
        $data['show_ui'] = \App\Models\Newsletter::STATUS_ACTIVE;

        return $data;
    }

    public function updateById(int $id, array $update = [])
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->update($update);
        }

        return false;
    }

    public function updateShowUI(int $id, array $attrs = [])
    {
        $model = $this->model->find($id);
        if ($model) {
            $model->show_ui = data_get($attrs, 'data');

            return $model->update($attrs);
        }

        return false;
    }

    public function countNoticed(int $memberId, int $type)
    {
        $count = $this->model
            ->where('type', $type)
            ->whereJsonDoesntContain('noticed', $memberId)
            ->orWhere(function ($query) use ($type) {
                $query->where('type', $type)
                    ->whereNull('noticed');
            })
            ->where('show_ui', \App\Models\Newsletter::STATUS_ACTIVE)
            ->count();

        return $count;
    }

    public function updateNoticedisReadAll(int $memberId, int $type)
    {
        $res = $this->model
            ->select('id', 'type', 'noticed')
            ->where('type', $type)
            ->where('show_ui', \App\Models\Newsletter::STATUS_ACTIVE)
            ->get();

        foreach ($res as $item) {
            if ($item->noticed) {
                $decode = json_decode($item->noticed, true);
                if (!in_array($memberId, $decode)) {
                    $decode[] = $memberId;
                    $item->noticed = json_encode($decode);
                }
            } else {
                $item->noticed = json_encode([$memberId]);
            }

            $item->save();
        }

        return true;
    }

    private function countNewsBoardByCategory($category = null)
    {
        if ($category) {
            return $this->model
                ->where('type', \App\Models\Newsletter::TYPE_NEWSBOARD)
                ->where('category', $category)
                ->count();
        } else {
            return $this->model
                ->where('type', \App\Models\Newsletter::TYPE_NEWSBOARD)
                ->count();
        }
    }

    public function listCountNewsBoardByCategory()
    {
        return [
            'all' => $this->countNewsBoardByCategory(),
            $this->model::CATEGORY_NOTICES => $this->countNewsBoardByCategory($this->model::CATEGORY_NOTICES),
            $this->model::CATEGORY_BETTING_RULES => $this->countNewsBoardByCategory($this->model::CATEGORY_BETTING_RULES),
            $this->model::CATEGORY_USAGE_INQUIRIES => $this->countNewsBoardByCategory($this->model::CATEGORY_USAGE_INQUIRIES),
            $this->model::CATEGORY_FREQUENTLY_ASKED_QUESTIONS => $this->countNewsBoardByCategory($this->model::CATEGORY_FREQUENTLY_ASKED_QUESTIONS),
        ];
    }
}
