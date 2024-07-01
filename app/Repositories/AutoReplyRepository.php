<?php

namespace App\Repositories;

class AutoReplyRepository extends BaseRepository
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
        return \App\Models\AutoReply::class;
    }

    public function deleteByIds($ids)
    {
        $this->model->whereNotIn('arNo', $ids)->delete();
    }

    public function firstAutoReplyByLevel($level)
    {
        return $this->model->where('arType', \App\Models\AutoReply::QUICK_TYPE)->where('arLevel', $level)->first();
    }
}
