<?php

namespace App\Services;

use App\Repositories\PopupRepository;

class PopupService extends BaseService
{
    public function __construct(
        private PopupRepository $popupRepo
    ) {
    }

    public function getRepo(): PopupRepository
    {
        return $this->popupRepo;
    }

    public function getData()
    {
        return $this->popupRepo->getData();
    }

    public function update(int $id, array $attrs)
    {
        $res = $this->popupRepo->getByPK($id);
        if (empty($res)) {
            return false;
        }

        $updated = $this->popupRepo->updateByPK($res, $attrs);

        return $updated ? $res : false;
    }

    public function change(int $poNo = null, string $field): bool
    {
        if (empty($poNo) || empty($field)) {
            return false;
        }

        $res = $this->popupRepo->getByPK($poNo);
        if (empty($res)) {
            return false;
        }

        return $this->tryCatchFuncDB(function () use ($res, $field) {
            $this->popupRepo->updateByPK($res, [
                $field => !data_get($res, $field, true),
            ]);
        });
    }

    public function getDataApi()
    {
        return $this->popupRepo->getDataApi();
    }

    public function reset(int $poNo)
    {
        $attrs = [
            'poLink' => null,
            'poContent' => null,
            'poUsed' => 0,
            'poLoggined' => 0,
            'poOpenNewWindow' => 0,
        ];

        return $this->popupRepo->updateByPK($poNo, $attrs);
    }
}
