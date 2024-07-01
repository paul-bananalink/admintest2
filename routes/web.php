<?php

use Illuminate\Support\Facades\Route;

//redirct to page login
Route::get('/', fn () => redirect()->route('admin.page-login'));


Route::namespace('App\Http\Controllers')->group(function () {

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['login_admin', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        /**
         * prefix: /admin
         * route name: admin.
         * namespace: App\Http\Controllers\Admin
         */
        Route::get('/reload-captcha', 'AdminController@reloadCaptcha')->name('reload-captcha');

        Route::get('/page-login', 'AdminController@pageLogin')->name('page-login');
        Route::post('/login', 'AdminController@login')->name('login');

        Route::group(['middleware' => ['auth']], function () {
            Route::group(['middleware' => ['login_admin']], function () {
                //redirect to dashboard page
                Route::get('/', fn () => redirect()->route('admin.dashboard.index'));

                Route::post('/export-excel', 'AdminController@exportExcel')->name('export-excel');
                Route::get('/ajax-get-member-config-game-provider/{mID}/{gpType}', 'AdminController@ajaxGetConfigGameProviderByMemberID')->name('ajax-get-member-config-game-provider');
                Route::get('/ajax-get-transaction-detail/{uuid}', 'AdminController@ajaxGetTransactionDetail')->name('ajax-get-transaction-detail');

                Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard'], function () {
                    /**
                     * prefix: /admin/dashboard
                     * route name: admin.dashboard.
                     * namespace: App\Http\Controllers\Admin\AdminController
                     */

                    Route::get('/index', 'DashboardController@index')->name('index');
                });

                Route::group(['namespace' => 'PageSetting', 'as' => 'page-setting.', 'prefix' => 'page-setting'], function () {
                    /**
                     * prefix: /admin/page-setting
                     * route name: admin.page-setting.
                     * namespace: App\Http\Controllers\Admin\PageSetting
                     */
                    Route::get('/index', 'PageController@index')->name('index');
                    Route::post('/index-save', 'PageController@indexSave')->name('index-save');
                    Route::post('/index-save-config', 'PageController@indexSaveConfig')->name('index-save-config');

                    Route::get('/block-ip', 'PageController@blockIp')->name('block-ip');
                    Route::post('/block-ip-save', 'PageController@blockIpSave')->name('block-ip-save');
                    Route::post('/block-ip-delete', 'PageController@blockIpDelete')->name('block-ip-delete');

                    Route::get('setting-{category}', 'PageController@settingCategory')->name('setting-category');

                    Route::post('/enable-disable-{category}', 'PageController@enableDisableCategory')->name('enable-disable-category');
                    Route::post('/enable-disable/{gpNo}', 'PageController@enableDisableGameProvider')->name('enable-disable-game-provider');
                    Route::post('/toggle-maintenance/{gpNo}/{type}', 'PageController@toggleMaintenanceGameProvider')->name('toggle-maintenance-game-provider');
                    Route::post('/games/{gpCode}', 'PageController@getGames')->name('get-games');
                    Route::get('/games/{gpCode}', 'PageController@getGameInfo')->name('get-game-info');

                    Route::post('/enable-disable/game/{gNo}', 'PageController@enableDisableGame')->name('enable-disable-game');

                    Route::post('/toggle-field/{field}', 'PageController@toggleField')->name('toggle-field');

                    Route::group(['prefix' => 'bonus-config', 'as' => 'bonus-config.'], function () {
                        Route::get('/bonus', 'BonusConfigController@indexBonus')->name('indexBonus');
                        Route::get('/bonus-recharge', 'BonusConfigController@indexBonusRecharge')->name('indexBonusRecharge');
                        Route::get('/bonus-signup', 'BonusConfigController@indexBonusSignup')->name('indexBonusSignup');
                        Route::get('/bonus-participate', 'BonusConfigController@indexBonusParticipate')->name('indexBonusParticipate');
                        Route::get('/bonus-new-member', 'BonusConfigController@indexBonusNewMember')->name('indexBonusNewMember');
                        Route::get('/bonus-attendance', 'BonusConfigController@indexBonusAttendance')->name('indexBonusAttendance');
                        Route::get('/bonus-referral', 'BonusConfigController@indexBonusReferral')->name('indexBonusReferral');
                        Route::get('/bonus-hall-of-fame', 'BonusConfigController@indexBonusHallOfFame')->name('indexBonusHallOfFame');
                        Route::get('/bonus-consolation-prize', 'BonusConfigController@indexBonusConsolationPrize')->name('indexBonusConsolationPrize');
                        Route::get('/bonus-payback', 'BonusConfigController@indexBonusPayback')->name('indexBonusPayback');
                        Route::get('/bonus-level-up', 'BonusConfigController@indexBonusLevelUp')->name('indexBonusLevelUp');
                        Route::get('/bonus-rolling', 'BonusConfigController@indexBonusRolling')->name('indexBonusRolling');
                        Route::get('/bonus-losing', 'BonusConfigController@indexBonusLosing')->name('indexBonusLosing');
                        Route::get('/bonus-coupon', 'BonusConfigController@indexBonusCoupon')->name('indexBonusCoupon');
                        Route::get('/bonus-sudden', 'BonusConfigController@indexBonusSudden')->name('indexBonusSudden');
                        Route::post('/toggle-field/{field}/{bonusType?}', 'BonusConfigController@toggleField')->name('toggle-field-bonus-config');
                        Route::post('/toggle-json-field/{field}/{bonusType?}', 'BonusConfigController@toggleJSONField')->name('toggle-json-field-bonus-config');
                        Route::post('/bonus/update', 'BonusConfigController@updateBonus')->name('updateBonus');
                        Route::post('/bonus-recharge/update', 'BonusConfigController@updateBonusRecharge')->name('updateBonusRecharge');
                        Route::post('/bonus-signup/update', 'BonusConfigController@updateBonusSignup')->name('updateBonusSignup');
                        Route::post('/bonus-participate/update', 'BonusConfigController@updateBonusParticipate')->name('updateBonusParticipate');
                        Route::post('/bonus-new-member/update', 'BonusConfigController@updateBonusNewMember')->name('updateBonusNewMember');
                        Route::post('/bonus-attendance/update', 'BonusConfigController@updateBonusAttendance')->name('updateBonusAttendance');
                        Route::post('/bonus-referral/update', 'BonusConfigController@updateBonusReferral')->name('updateBonusReferral');
                        Route::post('/bonus-hall-of-fame/update', 'BonusConfigController@updateBonusHallOfFame')->name('updateBonusHallOfFame');
                        Route::post('/bonus-consolation-prize/update', 'BonusConfigController@updateBonusConsolationPrize')->name('updateBonusConsolationPrize');
                        Route::post('/bonus-payback/update', 'BonusConfigController@updateBonusPayback')->name('updateBonusPayback');
                        Route::post('/bonus-level-up/update', 'BonusConfigController@updateBonusLevelUp')->name('updateBonusLevelUp');
                        Route::post('/bonus-rolling/update', 'BonusConfigController@updateBonusRolling')->name('updateBonusRolling');
                        Route::post('/bonus-losing/update', 'BonusConfigController@updateBonusLosing')->name('updateBonusLosing');
                        Route::post('/bonus-coupon/update', 'BonusConfigController@updateBonusCoupon')->name('updateBonusCoupon');
                        Route::post('/bonus-sudden/update', 'BonusConfigController@updateBonusSudden')->name('updateBonusSudden');
                        Route::post('/bonus-recharge/toggle-field/{level}/{group}/{field}', 'BonusConfigController@toggleFieldBonusRecharge')->name('toggleFieldBonusRecharge');
                        Route::post('/bonus-sudden/toggle-field/{level}/{group}/{field}', 'BonusConfigController@toggleFieldBonusSudden')->name('toggleFieldBonusSudden');
                    });

                    Route::group(['prefix' => 'sport-config', 'as' => 'sport-config.'], function () {
                        Route::get('/index', 'SportsController@index')->name('index');
                        Route::post('/update', 'SportsController@update')->name('update');
                        Route::post('/toggle-field/{field}', 'SportsController@toggleField')->name('toggleField');
                    });

                    Route::group(['prefix' => 'virtual-sport-config', 'as' => 'virtual-sport-config.'], function () {
                        Route::get('/index', 'VirtualSportsConfigController@index')->name('index');
                        Route::post('/update', 'VirtualSportsConfigController@update')->name('update');
                        Route::post('/toggle-field/{field}', 'VirtualSportsConfigController@toggleField')->name('toggleField');
                    });

                    Route::group(['prefix' => 'realtime-config', 'as' => 'realtime-config.'], function () {
                        Route::get('/index', 'RealtimeController@index')->name('index');
                        Route::post('/update', 'RealtimeController@update')->name('update');
                        Route::post('/toggle-field/{field}', 'RealtimeController@toggleField')->name('toggleField');
                    });

                    Route::group(['prefix' => 'game-config', 'as' => 'game-config.'], function () {
                        Route::get('/{gcType}/index', 'MiniGameController@index')->name('index');
                        Route::post('/update/{gcType}', 'MiniGameController@update')->name('update');
                        Route::post('/toggle-field/{field}/{gcType}', 'MiniGameController@toggleField')->name('toggleField');
                    });

                    Route::group(['prefix' => 'casino-config', 'as' => 'casino-config.'], function () {
                        /**
                         * prefix: /admin/page-setting/casino-config
                         * route name: admin.page-setting.casino-config.
                         * namespace: App\Http\Controllers\Admin\PageSetting
                         */
                        Route::get('/{ccType}/index', 'CasinoController@index')->name('index');
                        Route::post('/update/{ccType}', 'CasinoController@update')->name('update');
                        Route::post('/toggle-field-config/{field}/{ccType}', 'CasinoController@toggleFieldConfig')->name('toggleFieldConfig');
                        Route::post('/toggle-field/{field}/{gNo}', 'CasinoController@toggleField')->name('toggleField');
                        Route::post('/update-game/{ccType}', 'CasinoController@updateGame')->name('update-game');
                    });

                    Route::group(['prefix' => 'recharge-config', 'as' => 'recharge-config.'], function () {
                        /**
                         * prefix: /admin/page-setting/recharge-config
                         * route name: admin.page-setting.recharge-config.
                         * namespace: App\Http\Controllers\Admin\PageSetting
                         */
                        Route::get('/index', 'RechargeConfigController@index')->name('index');
                        Route::post('/store', 'RechargeConfigController@store')->name('store');
                        Route::post('/toggle-field/{field}', 'RechargeConfigController@toggleField')->name('toggle-field');
                    });

                    Route::group(['prefix' => 'auto-reply', 'as' => 'auto-reply.'], function () {
                        Route::get('/index', 'AutoReplyController@index')->name('index');
                        Route::post('/store', 'AutoReplyController@store')->name('store');
                        Route::get('/get-form/{form}', 'AutoReplyController@getForm')->name('get-form');
                    });

                    Route::group(['prefix' => 'template', 'as' => 'template.'], function () {
                        Route::get('/index', 'TemplateController@index')->name('index');
                        Route::post('/store', 'TemplateController@store')->name('store');
                    });

                    Route::group(['prefix' => 'manager-banner', 'as' => 'manager-banner.'], function () {
                        /**
                         * prefix: /admin/page-setting/manager-banner
                         * route name: admin.page-setting.manager-banner.
                         * namespace: App\Http\Controllers\Admin\PageSetting
                         */
                        Route::get('/{type}', 'ManagerBannerController@index')->name('index');
                        Route::post('/update-logo', 'ManagerBannerController@updateLogo')->name('update-logo');
                        Route::post('/update', 'ManagerBannerController@updateBanner')->name('update');
                        Route::delete('/delete/{id}', 'ManagerBannerController@delete')->name('delete');
                        Route::post('/ajax-get-banner-item', 'ManagerBannerController@ajaxGetBannerItem')->name('ajaxGetBannerItem');
                    });

                    Route::group(['prefix' => 'withdraw-config', 'as' => 'withdraw-config.'], function () {
                        Route::get('/index', 'WithdrawConfigController@index')->name('index');
                        Route::post('/store', 'WithdrawConfigController@store')->name('store');
                        Route::post('/toggle-field/{field}', 'WithdrawConfigController@toggleField')->name('toggle-field');
                    });

                    /**
                     * prefix: /admin/page-setting/domain
                     * route name: admin.page-setting.domain.
                     * namespace: App\Http\Controllers\Admin\PageSetting
                     */
                    Route::group(['prefix' => 'domain', 'as' => 'domain.'], function () {
                        Route::get('/index', 'DomainController@index')->name('indexDomain');
                        Route::post('/create', 'DomainController@create')->name('createDomain');
                        Route::post('/update/{id}', 'DomainController@update')->name('updateDomain');
                        Route::post('/delete/{id}', 'DomainController@delete')->name('deleteDomain');
                        Route::post('/toggle-field/{field}/{id}', 'DomainController@toggleField')->name('toggleField');
                    });

                    Route::group(['prefix' => 'exchange-rate', 'as' => 'exchange-rate.'], function () {
                        Route::get('/index', 'ExchangeRateController@index')->name('indexExchangeRate');
                        Route::post('/update', 'ExchangeRateController@update')->name('updateExchangeRate');
                    });

                    Route::group(['prefix' => 'display', 'as' => 'display.'], function () {
                        Route::get('/index', 'DisplayController@index')->name('index');
                        Route::post('/store', 'DisplayController@store')->name('store');
                        Route::post('render/{form}', 'DisplayController@render')->name('render');
                    });
                });

                Route::group(['as' => 'manager-account-setting.', 'prefix' => 'manager-account-setting'], function () {
                    /**
                     * prefix: /admin/manager-account-setting
                     * route name: admin.manager-account-setting.
                     * namespace: App\Http\Controllers\Admin\
                     */
                    Route::get('/index', 'ManagerAdminController@index')->name('index');
                    Route::post('/add-admin', 'ManagerAdminController@addAdmin')->name('add-admin');
                    Route::post('/update-password-admin', 'ManagerAdminController@updatePasswordAdmin')->name('update-password-admin');
                    Route::get('/change-status/{id}/{is_unlock}', 'ManagerAdminController@changeStatus')->name('change-status');

                    Route::post('/allow-ip-save/{m_id}', 'ManagerAdminController@allowIpSave')->name('allow-ip-save');
                    Route::post('/allow-ip-delete', 'ManagerAdminController@allowIpDelete')->name('allow-ip-delete');
                });

                Route::group(['namespace' => 'Note', 'prefix' => 'note', 'as' => 'note.'], function () {
                    Route::get('/index', 'NoteController@index')->name('index');
                    Route::get('/view/{id}', 'NoteController@view')->name('view');
                    Route::get('/create-note', 'NoteController@viewCreate')->name('viewCreate');
                    Route::get('/create-note-send-user/{mNo}', 'NoteController@viewCreateNoteSendUser')->name('viewCreateNoteSendUser');
                    Route::delete('/delete/{id}', 'NoteController@delete')->name('delete');
                    Route::post('/add-note', 'NoteController@addNote')->name('addNote');
                    Route::post('/send-note/{id}', 'NoteController@sendNoteAll')->name('sendNoteAll');
                    Route::post('/send-note-to-user', 'NoteController@sendNoteToUser')->name('sendNoteToUser');
                    Route::get('/delete-all-note', 'NoteController@deleteAllNote')->name('deleteAllNote');
                    Route::get('/delete-all-note-is-read', 'NoteController@deleteAllNoteIsRead')->name('deleteAllNoteIsRead');
                    Route::get('/{id}/edit', 'NoteController@edit')->name('edit');
                    Route::post('/update/{id}', 'NoteController@update')->name('update');
                    Route::post('/recall', 'NoteController@recall')->name('recall');

                    // Ajax
                    Route::post('/ajax-get-textarea-list-user', 'NoteController@ajaxGetTextAreaListUser')->name('ajaxGetTextAreaListUser');
                    Route::post('/ajax-get-select-level', 'NoteController@ajaxGetSelectLevel')->name('ajaxGetSelectLevel');
                    Route::post('/ajax-get-checkbox-partner', 'NoteController@ajaxGetCheckboxPartner')->name('ajaxGetCheckboxPartner');

                    Route::get('/template/index', 'TemplateMessageController@index')->name('indexTemplate');
                    Route::get('/template/create', 'TemplateMessageController@viewCreate')->name('viewCreateTemplate');
                    Route::post('/template/add', 'TemplateMessageController@create')->name('createTemplate');
                    Route::get('/template/{id}/edit', 'TemplateMessageController@edit')->name('editTemplate');
                    Route::post('/template/update/{id}', 'TemplateMessageController@update')->name('updateTemplate');
                    Route::delete('/template/delete/{id}', 'TemplateMessageController@delete')->name('deleteTemplate');
                    Route::get('/template/ajax-get-content/{id}', 'TemplateMessageController@ajaxGetContentNote')->name('ajaxGetContentTemplate');
                    Route::get('/template/ajax-get-content-consultation/{id}', 'TemplateMessageController@ajaxGetContent')->name('ajaxGetContentConsultation');
                });

                Route::group(['namespace' => 'Consultation', 'prefix' => 'consultation', 'as' => 'consultation.'], function () {
                    Route::get('/index', 'ConsultationController@index')->name('index');
                    Route::get('/modal-reply/{id}', 'ConsultationController@showModalReply')->name('showModalReply');
                    Route::post('/reply/{id}', 'ConsultationController@reply')->name('reply');
                    Route::delete('/delete/{id}', 'ConsultationController@delete')->name('delete');
                    Route::post('/ajax-show-reply', 'ConsultationController@ajaxShowReply')->name('ajaxShowReply');
                });

                Route::group(['namespace' => 'Consultation', 'prefix' => 'template-message', 'as' => 'template-message.'], function () {
                    Route::get('/index', 'TemplateMessageController@index')->name('index');
                    Route::get('/create', 'TemplateMessageController@viewCreate')->name('viewCreate');
                    Route::post('/add', 'TemplateMessageController@create')->name('create');
                    Route::get('/{id}/edit', 'TemplateMessageController@edit')->name('edit');
                    Route::post('/update/{id}', 'TemplateMessageController@update')->name('update');
                    Route::delete('/delete/{id}', 'TemplateMessageController@delete')->name('delete');
                    Route::get('/ajax-get-content/{id}', 'TemplateMessageController@ajaxGetContent')->name('ajaxGetContent');
                });

                Route::group(['namespace' => 'Newsletter', 'prefix' => 'news-board', 'as' => 'news-board.'], function () {
                    Route::get('/index', 'NewsBoardController@index')->name('index');
                    Route::get('/create', 'NewsBoardController@viewCreate')->name('viewCreate');
                    Route::post('/add', 'NewsBoardController@create')->name('create');
                    Route::delete('/delete/{id}', 'NewsBoardController@delete')->name('delete');
                    Route::get('/{id}/edit', 'NewsBoardController@edit')->name('edit');
                    Route::post('/update/{id}', 'NewsBoardController@update')->name('update');
                    Route::post('/show-ui/{id}', 'NewsBoardController@updateStatus')->name('updateStatus');
                    Route::post('/toggle-field/{id}', 'NewsBoardController@toggleField')->name('toggleField');
                });

                Route::group(['namespace' => 'Newsletter', 'prefix' => 'event', 'as' => 'event.'], function () {
                    Route::get('/index', 'EventController@index')->name('index');
                    Route::get('/create', 'EventController@viewCreate')->name('viewCreate');
                    Route::post('/add', 'EventController@create')->name('create');
                    Route::get('/{id}/edit', 'EventController@edit')->name('edit');
                    Route::delete('/delete/{id}', 'EventController@delete')->name('delete');
                    Route::post('/update/{id}', 'EventController@update')->name('update');
                    Route::post('/show-ui/{id}', 'EventController@updateStatus')->name('updateStatus');
                    Route::post('/toggle-field/{id}', 'EventController@toggleField')->name('toggleField');
                });

                Route::group(['prefix' => 'partner', 'as' => 'partner.'], function () {
                    Route::get('/index', 'PartnerController@index')->name('index');
                    Route::get('/{level_type}/index', 'PartnerController@indexLevel')->name('indexLevel');
                    Route::post('/create', 'PartnerController@create')->name('create');
                    Route::post('/update/{pNo}', 'PartnerController@update')->name('update');

                    // Ajax
                    Route::post('/ajax-require-data', 'PartnerController@ajaxValidData')->name('ajaxValidData');
                    Route::get('/ajax-get-form-update/{pNo}', 'PartnerController@ajaxGetFormData')->name('ajax-get-form-update');
                    Route::post('/toggle-field/{field}/{pNo}', 'PartnerController@toggleField')->name('toggle-field');

                    Route::get('/get-data-partner', 'PartnerController@ajaxGetDataPartner')->name('get-data-partner');
                    Route::post('/update-tree-partner', 'PartnerController@updateTreePartner')->name('update-tree-partner');
                });

                Route::group(['as' => 'info-member-access.', 'prefix' => 'info-member-access'], function () {
                    /**
                     * prefix: /admin/info-member-access
                     * route name: admin.info-member-access.
                     * namespace: App\Http\Controllers\Admin\
                     */
                    Route::get('/index', 'MemberAccessController@index')->name('index');
                    Route::post('/member-logout', 'MemberAccessController@memberLogout')->name('member-logout');
                });

                Route::group(['as' => 'info-member-block.', 'prefix' => 'info-member-block'], function () {
                    /**
                     * prefix: /admin/info-member-block
                     * route name: admin.info-member-block.
                     * namespace: App\Http\Controllers\Admin\
                     */
                    Route::get('/index', 'MemberBlockController@index')->name('index');
                });

                Route::group(['as' => 'members-ip-infect.', 'prefix' => 'members-ip-infect'], function () {
                    /**
                     * prefix: /admin/members-ip-infect
                     * route name: admin.members-ip-infect.
                     * namespace: App\Http\Controllers\Admin\
                     */
                    Route::get('/index', 'MemberIpInfectController@index')->name('index');
                });

                Route::group(['as' => 'blacklist.', 'prefix' => 'blacklist'], function () {
                    /**
                     * prefix: /admin/blacklist
                     * route name: admin.blacklist.
                     * namespace: App\Http\Controllers\Admin\
                     */
                    Route::get('/index', 'BlackListController@index')->name('index');
                });

                Route::group(['namespace' => 'Member', 'as' => 'status-members.', 'prefix' => 'status-members'], function () {
                    /**
                     * prefix: /admin/status-members
                     * route name: admin.status-members.
                     * namespace: App\Http\Controllers\Admin\
                     */
                    Route::get('/index', 'StatusMemberController@index')->name('index');
                    Route::get('/reset-pass/{id}', 'StatusMemberController@resetPass')->name('reset-pass');
                    Route::get('/status-member-normal/{id}', 'StatusMemberController@statusMembernormal')->name('status-member-normal');
                    Route::get('/status-member-stop/{id}', 'StatusMemberController@statusMemberStop')->name('status-member-stop');
                    Route::post('/update-status-member/{id}/{type}/{value?}', 'StatusMemberController@updateStatusMember')->name('update-status-member');
                    Route::post('/delete-member', 'StatusMemberController@deleteMember')->name('delete-member');
                    Route::get('/create', 'StatusMemberController@create')->name('create');
                    Route::post('/create-member', 'StatusMemberController@createMember')->name('create-member');
                    Route::get('/update/{id}', 'StatusMemberController@update')->name('update');
                    Route::post('/\/{id}', 'StatusMemberController@updateMember')->name('update-member');
                    Route::get('/member-row/{id}', 'StatusMemberController@getMemberRow')->name('member-row');
                    Route::get('/action/{name}', 'StatusMemberController@actionButton')->name('action-button');
                    Route::post('{field}/{mNo}', 'StatusMemberController@updateToggleField')->name('update-toggle-field');

                    //create api for axios call checkdata
                    Route::post('/check-member-id', 'StatusMemberController@checkPartnerCode')->name('check-member-id');
                    Route::post('/check-unique-member-id', 'StatusMemberController@checkUniqueMemberId')->name('check-unique-member-id');
                    Route::post('/check-member-nick', 'StatusMemberController@checkMemberNick')->name('check-member-nick');
                    Route::post('/update-provider-list/{provider}/{id}', 'StatusMemberController@updateProviderList')->name('update-provider-list');
                    Route::post('/update-game-list/{game}/{id}', 'StatusMemberController@updateGameList')->name('update-game-list');
                    Route::get('/info/{id}', 'StatusMemberController@info')->name('info');
                    Route::post('/ban-by-field/{field}/{id}', 'StatusMemberController@banByField')->name('ban-by-field');
                    Route::post('/force-logout/{id}', 'StatusMemberController@forceLogout')->name('force-logout');
                    // Route::post('/update-member-config', 'StatusMemberController@updateMemberConfig')->name('update-member-config');
                    Route::post('/reset-pw/{id}', 'StatusMemberController@resetPassword')->name('reset-pw');
                    Route::post('/create-or-update-member', 'StatusMemberController@createOrUpdateMember')->name('create-or-update-member');
                    Route::get('/detail/{id}', 'StatusMemberController@detail')->name('detail');
                });

                Route::group([
                    'namespace' => 'Member',
                    'as' => 'member-config.',
                    'prefix' => 'member-config',
                ], function () {
                    Route::post('{field}/{mcNo}', 'MemberConfigController@update')->name('update');
                    Route::post('/update-game-provider-by-member/{mID}/{gpType}/{gpCode}', 'MemberConfigController@updateGameProviderByMemberID')->name('update-game-provider-by-member');

                    //ajax
                    Route::get('/ajax-get-mc-event-restrictions/{mID}', 'MemberConfigController@ajaxGetMCEventRestrictions')->name('ajax-get-mc-event-restrictions');
                    Route::post('/update-mc-event-restrictions-item/{mID}/{field}', 'MemberConfigController@toggleMCEventRestrictionsItem')->name('update-mc-event-restrictions-item');
                });

                Route::get('/logout', 'AdminController@logout')->name('logout');

                Route::group(['namespace' => 'MoneyInfo', 'prefix' => 'money-info', 'as' => 'money-info.', 'where' => ['type' => 'recharge|withdraw']], function () {
                    Route::get('/{type}/index', 'MoneyInfoController@index')->name('index');
                    Route::post('/{type}/update/{id}', 'MoneyInfoController@update')->name('update');
                    Route::post('/{type}/update-ids', 'MoneyInfoController@updateIds')->name('update-ids');
                    Route::post('/direct-recharge-or-withdraw/{mID}', 'MoneyInfoController@directRechargeOrWithdraw')->name('direct-recharge-or-withdraw');
                    Route::get('/{type}/histories/{id}', 'MoneyInfoController@histories')->name('histories');
                    Route::delete('/{type}/delete/{id}', 'MoneyInfoController@destroy')->name('delete');
                    Route::get('/{type}/export/', 'MoneyInfoController@export')->name('export');
                });

                Route::group(['namespace' => 'Casino'], function () {
                    Route::get('/get-game-provider', 'GameProviderController@handleGameProvider')->name('handleGameProvider');
                    Route::get('/get-game', 'GameController@handleGame')->name('handleGame');

                    Route::group(['prefix' => 'game-provider', 'as' => 'game-provider.'], function () {
                        Route::get('/index', 'GameProviderController@index')->name('index');
                        Route::get('/edit/{id}', 'GameProviderController@edit')->name('edit');
                        Route::get('/update/{id}', 'GameProviderController@update')->name('update');
                        Route::get('/ajax-update/{id}', 'GameProviderController@ajaxUpdate')->name('ajaxUpdate');
                    });
                });

                Route::group(['namespace' => 'Popup', 'prefix' => 'popup', 'as' => 'popup.'], function () {
                    Route::get('/index', 'PopupController@index')->name('index');
                    Route::post('/update/{id}', 'PopupController@update')->name('update');
                    Route::post('/enable-disable/{poNo}/{field}', 'PopupController@enableDisable')->name('enable-disable');
                    Route::post('/reset/{poNo}', 'PopupController@reset')->name('reset');
                    Route::post('/delete/{poNo}', 'PopupController@destroy')->name('delete');
                });

                Route::group(['namespace' => 'Member', 'prefix' => 'settlement', 'as' => 'settlement.'], function () {
                    Route::get('/', 'SettlementController@index')->name('index');
                    Route::get('/detail/{group}/{id}/{level}', 'SettlementController@detail')->name('detail');
                    Route::get('/web', 'SettlementController@web')->name('web');
                    Route::get('/web/detail', 'SettlementController@webDetail')->name('webDetail');
                    Route::get('/user', 'SettlementController@user')->name('user');
                });

                Route::group(['namespace' => 'Bonus', 'prefix' => 'bonus', 'as' => 'bonus.'], function () {
                    Route::get('/index', 'BonusController@index')->name('index');
                    Route::get('/info/{id}', 'BonusController@info')->name('info');
                });

                Route::group(['namespace' => 'Sport', 'prefix' => 'sport', 'as' => 'sport.'], function () {
                    Route::get('/{type}/index', 'SportController@index')->name('index');
                    Route::post('/toggle-show/{type}/{idx}', 'SportController@toggleShow')->name('toggle-show');
                    Route::post('/update-table/{type}', 'SportController@updateTable')->name('update-table');
                    Route::post('/update-row-table/{idx}', 'SportController@updateRowTableTeam')->name('update-row-table-team');
                });

                Route::group(['namespace' => 'Cash', 'prefix' => 'cash', 'as' => 'cash.'], function () {
                    Route::get('/index', 'CashController@index')->name('index');
                });

                Route::group(['namespace' => 'PointHistory', 'prefix' => 'point-history', 'as' => 'point-history.'], function () {
                    Route::get('/index', 'PointHistoryController@index')->name('index');
                });

                Route::group(['prefix' => 'betting-histories', 'as' => 'betting-histories.'], function () {
                    Route::get('/sports', 'BettingHistoryController@sports')->name('sports');
                    Route::get('/realtime', 'BettingHistoryController@realtime')->name('realtime');
                    Route::get('/mini-game', 'BettingHistoryController@miniGame')->name('miniGame');
                    Route::get('/virtual-sports', 'BettingHistoryController@virtualSports')->name('virtualSports');
                    Route::get('/parsing-casino', 'BettingHistoryController@parsingCasino')->name('parsingCasino');
                    Route::get('/casino', 'BettingHistoryController@casino')->name('casino');
                });

                Route::group(['namespace' => 'Notice', 'prefix' => 'notice', 'as' => 'notice.'], function () {
                    Route::group(['prefix' => 'rule', 'as' => 'rule.'], function () {
                        Route::get('/', 'NoticeRuleController@index')->name('index');
                        Route::match(['post', 'get'], '/edit/{id}', 'NoticeRuleController@edit')->name('edit');
                        Route::post('/store', 'NoticeRuleController@store')->name('store');
                        Route::post('/in-active/{id}', 'NoticeRuleController@inActive')->name('in-active');
                    });

                    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
                        Route::get('/', 'NoticeEventController@index')->name('index');
                        Route::match(['post', 'get'], '/edit/{id}', 'NoticeEventController@edit')->name('edit');
                        Route::post('/store', 'NoticeEventController@store')->name('store');
                        Route::post('/in-active/{id}', 'NoticeEventController@inActive')->name('in-active');
                    });

                    Route::group(['prefix' => 'partner', 'as' => 'partner.'], function () {
                        Route::get('/', 'NoticePartnerController@index')->name('index');
                        Route::match(['post', 'get'], '/edit/{id}', 'NoticePartnerController@edit')->name('edit');
                        Route::post('/store', 'NoticePartnerController@store')->name('store');
                        Route::post('/in-active/{id}', 'NoticePartnerController@inActive')->name('in-active');
                    });

                    Route::group(['prefix' => 'vote', 'as' => 'vote.'], function () {
                        Route::get('/', 'NoticeVoteController@index')->name('index');
                        Route::match(['post', 'get'], '/edit/{id}', 'NoticeVoteController@edit')->name('edit');
                        Route::post('/store', 'NoticeVoteController@store')->name('store');
                        Route::post('/in-active/{id}', 'NoticeVoteController@inActive')->name('in-active');
                    });
                });
            });
        });
    });
});
