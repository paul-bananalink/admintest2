<?php

namespace App\Services;

use App\Models\Consultation;
use App\Repositories\ConsultationRepository;
use Illuminate\Support\Facades\Auth;
use DateTime;

class ConsultationService extends BaseService
{
    public function __construct(
        private ConsultationRepository $consultationRepo,
    ) {
    }

    public function getAll()
    {
        return $this->consultationRepo->getAll();
    }

    public function reply($id, array $data)
    {
        $data['mNo_receive'] = Auth::user()->mNo;
        $data['date_feedback'] = now();
        $data['status'] = Consultation::STATUS_REPLIED;

        $updated = $this->consultationRepo->updateByPK($id, $data);

        if ($updated) {
            $consultation = $this->consultationRepo->getByPK($id);
            if ($consultation->mNo) event(new \App\Events\Client\ReplyConsultationEvent($consultation->mNo));
        }

        return $updated;
    }

    public function getTotalNotify(): int
    {
        return $this->consultationRepo->GetUnansweredCount();
    }

    public function totalItemByStatus(int $status): int
    {
        return $this->consultationRepo->totalItemByStatus($status);
    }
}
