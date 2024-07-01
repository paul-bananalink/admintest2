<?php

namespace App\Services;

use App\Repositories\NewsletterRepository;

class NewsBoardService extends BaseService
{
    public function __construct(
        private NewsletterRepository $newsletterRepo,
    ) {
    }

    public function toggleField(int $id): bool
    {
        $res = $this->newsletterRepo->getByPK($id);

        if (empty($res)) {
            return false;
        }

        $data = [];
        $data['show_ui'] = data_get($res, 'show_ui') ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($res, $data) {
            $this->newsletterRepo->updateByPK($res, $data);
        });
    }
}
