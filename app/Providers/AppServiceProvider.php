<?php

namespace App\Providers;

use App\View\Composers\NotificationsComposer;
use App\View\Composers\PartnersComposer;
use App\View\Composers\ModalComposer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Listeners\MemberEventSubscriber;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('site_info', function ($app) {
            $siteInfoService = new \App\Services\SiteInfoService();
            return $siteInfoService->getSiteConfig();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::subscribe(MemberEventSubscriber::class);

        if ($domain = request()->getSchemeAndHttpHost()) {
            $domain = $domain == env('PARTNER_URL') ? env('PARTNER_URL') : env('APP_URL');
            \URL::forceRootUrl($domain);
        }

        if (env('APP_ENV') == 'production') {
            \URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        view()->composer(['Admin.Common.Modal.modal_member_config', 'Admin.Common.Modal.modal_member_ban_provider', 'Admin.Common.Modal.modal_member_ban_game', 'Admin.Common.Modal.modal_create_member'], ModalComposer::class);

        view()->composer(['Partner.Common.breadcrumb', 'Admin.MemberPartner.form_search', 'Partner.Manager.form_search'], PartnersComposer::class);

        view()->composer('Admin.Common.navbar', NotificationsComposer::class);

        $bonusConfigs = \App\Models\BonusConfig::all();
        foreach ($bonusConfigs as $bonusConfig) {
            $this->app->singleton($bonusConfig->bcKey, function ($app) use ($bonusConfig) {
                return $bonusConfig;
            });
        }
    }
}
