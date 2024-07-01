<?php

namespace App\Services;

use App\Models\AutoReply;
use App\Repositories\AutoReplyRepository;

class AutoReplyService extends BaseService
{
    public function __construct(
        private AutoReplyRepository $autoReplyRepository,
    ) {
    }
    public function getAutoReplies()
    {
        $quick_types = $this->autoReplyRepository->getListWithConditions(['where' => [['arType', '=', AutoReply::QUICK_TYPE]]]);

        $normal_types = $this->autoReplyRepository->getListWithConditions(['where' => [['arType', '=', AutoReply::NORMAL_TYPE]]]);

        return compact('quick_types', 'normal_types');
    }

    public function createOrUpdate(array $data)
    {
        $ids = [];
        foreach ($data['data'] as $item) {
            $id = $item['arNo'] ?? null;
            $form = $this->autoReplyRepository->updateOrCreate(['arNo' => $id], $item);

            $ids[] = $form->arNo;
        }

        $this->autoReplyRepository->deleteByIds($ids);
    }
}
