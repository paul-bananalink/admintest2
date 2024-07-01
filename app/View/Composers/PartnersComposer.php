<?php

namespace App\View\Composers;

use App\Services\PartnerService;
use Illuminate\View\View;

class PartnersComposer
{
    public function __construct(
        private PartnerService $partnerService,
    ) {
    }

    public function compose(View $view)
    {
        $partner['all'] = $this->partnerService->countByType('all');

        if (app('site_info')->siPartners) {
            $types = array_keys(app('site_info')->siPartners);
        }

        foreach ($types as $type) {
            $partner[$type] = $this->partnerService->countByType($type);
        }

        $view->with($partner);
    }
}
