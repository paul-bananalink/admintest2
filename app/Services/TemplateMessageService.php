<?php

namespace App\Services;

use App\Models\TemplateMessage;
use App\Repositories\TemplateMessageRepository;

class TemplateMessageService extends BaseService
{
    public function __construct(
        private TemplateMessageRepository $templateMessageRepo,
    ) {
    }
    public function getTemplates()
    {
        return $this->templateMessageRepo->getListWithConditions();
    }

    public function getAll($type = \App\Models\TemplateMessage::TYPE_CONSULTATION)
    {
        $per_page = request('per_page', self::COUNT_PER_PAGE);
        return $this->templateMessageRepo->getPaginate($per_page, ['type', $type]);
    }

    public function createWithNote(array $data)
    {
        $data['type'] = TemplateMessage::TYPE_NOTE;
        return $this->templateMessageRepo->create($data);
    }

    public function createOrUpdate(array $data)
    {
        $note_type = TemplateMessage::TYPE_CONSULTATION;
        $ids = [];

        foreach ($data['data'] as $item) {
            $item['type'] = $note_type;
            $id = $item['id'] ?? null;
            $template = $this->templateMessageRepo->updateOrCreate(['id' => $id], $item);

            $ids[] = $template->id;
        }

        $this->templateMessageRepo->deleteByIds($ids);
    }
}
