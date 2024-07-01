<?php

namespace App\View\Composers;

use App\Services\BaseService;
use Illuminate\View\View;

class ModalComposer
{
    public function __construct(
        private BaseService $baseService
    ) {
    }

    public function compose(View $view)
    {
        $config = $this->baseService->initConfig();

        $view->with(['config' => $config]);
    }
}
