<?php

namespace App\GraphQL\Queries\Auth;

use App\Services\RechargeConfigService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PageSiteQuery extends Query
{

    public function __construct(
        private RechargeConfigService $rechargeConfigService
    ) {
    }

    protected $attributes = [
        'name' => 'PageSiteQuery',
        'description' => 'Page site query',
    ];

    public function type(): Type
    {
        return GraphQL::type('PageSiteType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $site = app('site_info');

        return [
            'title' => data_get($site, 'siName'),
            'solution_name' => data_get($site, 'siSolutionName'),
            'description' => data_get($site, 'siDescription'),
            'keywords' => data_get($site, 'siKeywords'),
            'author' => data_get($site, 'siAuthor'),
            'captcha' => (bool)data_get($site, 'siEnableCaptcha'),
            'enable_consultation' => (bool)data_get($site, 'siEnableConsultation'),
            'require_read_note' => data_get($site, 'siRequireReadNote', false),
            'is_user_join' => data_get($site, 'siOpenUserJoin', false),
            'is_open_type' => data_get($site, 'siOpenType', false),
            'is_required_reply' => data_get($site, 'siRequiredReply', false),
            'banks' => $this->rechargeConfigService->getBanks(),
            'siLogo1' => ($path = data_get($site, 'siLogo1')) ? $path : '',
            'siLogo2' => ($path = data_get($site, 'siLogo2')) ? $path : '',
            'siLogo3' => ($path = data_get($site, 'siLogo3')) ? $path : '',
            'siLogoFavicon' => ($path = data_get($site, 'siLogoFavicon')) ? $path : '',
            'siIsClientAlertSound' => data_get($site, 'siIsClientAlertSound', false),
        ];
    }
}
