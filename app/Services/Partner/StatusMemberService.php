<?php

namespace App\Services\Partner;

use App\Repositories\ConsultationRepository;
use App\Repositories\GameProviderRepository;
use App\Repositories\GameRepository;
use App\Repositories\MemberConfigRepository;
use App\Repositories\MemberEnvironmentRepository;
use App\Repositories\Partner\MemberRepository;
use App\Repositories\Partner\MembersLoginRepository;
use App\Repositories\PartnerRepository;
use App\Services\GraphQL\NoteService;
use App\Services\MemberAccessService;
use App\Services\StatusMemberService as AdminStatusMemberService;

class StatusMemberService extends AdminStatusMemberService
{
    public function __construct(
        private MembersLoginRepository $memLoginRepo,
        private MemberRepository $memRepo,
        private MemberAccessService $memAccessService,
        private MoneyInfoService $moneyInfoService,
        private GameProviderRepository $gameProviderRepo,
        private GameRepository $gameRepo,
        private MemberConfigRepository $memberConfigRepository,
        private NoteService $noteService,
        private PartnerRepository $partnerRepository,
        private MemberEnvironmentRepository $memberEnvironmentRepository,
        private ConsultationRepository $consultationRepo,
    ) {
        parent::__construct(
            $memLoginRepo,
            $memRepo,
            $memAccessService,
            $moneyInfoService,
            $gameProviderRepo,
            $gameRepo,
            $memberConfigRepository,
            $noteService,
            $partnerRepository,
            $memberEnvironmentRepository,
            $consultationRepo,
        );
    }
}
