<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SiteInfo extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'siNo';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_info';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siNo',
        'siOpenUserJoin',
        'siTimeOUt',
        'siName',
        'siEmail',
        'siTel',
        'siBank',
        'siBankAccount',
        'siOwner',
        'siDescription',
        'siKeywords',
        'siOpenType',
        'siOptionMinDeposit',
        'siOptionDepositText',
        'siOptionMinWithraw',
        'siOptionWithrawText',
        'siIsGameProviderCasino',
        'siIsGameProviderSlot',
        'siMaxHoursHistories',
        'siSMSPhone',
        'siSMSApiKey',
        'siSMSId',
        'siConsultationContents',
        'siMemberFirstTimeLoginContents',
        'siSMSContents',
        'siMemberNoteContents',
        'siWarningMaxBetValues',
        'siPartners',
        'siPartnersMode',
        'siBlackList',
        'siLogo1',
        'siLogo2',
        'siLogo3',
        'siLogoFavicon',
        'siSolutionName',
        'siIsTransferMoney',
        'siIsDuplicateIP',
        'siIsAlbagiIP',
        'siIsPokerRechargeRolling',
        'siIsClientAlertSound',
        'siIsUseNotificationBoard',
        'siIsAutoWithdrawalNewUser',
        'siIsPartnerMemberInfoVisibility',
        'siPartnerMemberInfoVisibilityLevel',
        'siLowOddsLimit',
        'siReinquiryTimeInterval',
        'siSportsRollbackNotifyInterval',
        'siFeedTitle',
        'siFeedCommentCharLimit',
        'siClientMessageRetentionTime',
        'siBlockedMemberLoginMessage',
        'siAdminAccessIP',
        'siManualBlockIP',
        'siAutomationBlockIP',
        'siIsUseOTP',
        'siOTPAdminID',
        'siIsOpenUserRejoin',
        'siEnableGamesConfig',
        'siSportsBettingRate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'siOpenUserJoin' => 'boolean',
            'siOpenType' => 'boolean',
            'siIsGameProviderCasino' => 'boolean',
            'siIsGameProviderSlot' => 'boolean',
            'siWarningMaxBetValues' => 'array',
            'siPartners' => 'array',
            'siBlackList' => 'array',
            'siSportsBettingRate' => 'float',
        ];
    }

    /**
     * Mutators & Casting
     */
    protected function getInfoBankAttribute()
    {
        return "{$this->siBank}/{$this->siBankAccount}/{$this->siOwner}";
    }
}
