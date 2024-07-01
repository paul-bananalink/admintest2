<?php

namespace App\Services;

use App\Repositories\DomainRepository;

class DomainService extends BaseService
{
    public function __construct(
        private DomainRepository $domainRepository,
    ) {
    }

    /**
     * Get all domains
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllDomains()
    {
        return $this->domainRepository->get();
    }

    public function create(array $data = []): mixed
    {
        return $this->tryCatchFuncDB(fn () => $this->domainRepository->create($data));
    }

    public function getById($id)
    {
        return $this->domainRepository->getByPK($id);
    }

    public function toggleField(int $id, string $field): bool
    {
        $domain = $this->domainRepository->getByPK($id);

        if (empty($domain)) {
            return false;
        }

        $data = [];
        $data[$field] = !data_get($domain, $field, false);

        return $this->tryCatchFuncDB(function () use ($domain, $data) {
            $this->domainRepository->updateByPK($domain, $data);
        });
    }

    public function update($domain, $data)
    {
        return $this->tryCatchFuncDB(fn () => $this->domainRepository->updateByPK($domain, $data));
    }
    public function delete($id)
    {
        return $this->tryCatchFuncDB(fn () => $this->domainRepository->deleteByPK($id));
    }
}
