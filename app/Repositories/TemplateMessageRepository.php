<?php

namespace App\Repositories;

class TemplateMessageRepository extends BaseRepository
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
        return \App\Models\TemplateMessage::class;
    }

    public function deleteByIds($ids)
    {
        $this->model->whereNotIn('id', $ids)->delete();
    }
}
