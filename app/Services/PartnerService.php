<?php

namespace App\Services;

use App\Events\Admin\CountMemberRegist;
use App\Events\Client\StatisticMoneyEvent;
use App\Models\Member;
use App\Models\Partner;
use App\Repositories\PartnerRepository;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class PartnerService extends BaseService
{
    public function __construct(
        private PartnerRepository $partnerRepo,
        private MemberRepository $memRepo,
        private MoneyInfoService $moneyInfoService,
    ) {
    }

    public function getRepo(): PartnerRepository
    {
        return $this->partnerRepo;
    }

    public function getTreeView(): Collection
    {
        $deputy_headquarters = $this->partnerRepo->getDeputyHeadquarters();
        foreach ($deputy_headquarters as $item) {
            /** @var Partner $item */
            $item->childs = $item->getDistributors();
        }

        return $deputy_headquarters;
    }

    public function getTreeViewPartner(): ?Partner
    {
        /** @var Member */
        $member = auth('partner')->user();
        /** @var Partner */
        $partner  = $member->partner;

        $currentPartner = $this->partnerRepo->getCurrentPartner($member, $partner?->pType);

        if ($currentPartner?->pType == 'deputy_headquarters') {
            $currentPartner->childs = $currentPartner->getDistributors();
        }

        if ($currentPartner?->pType == 'distributor') {
            $currentPartner->childs = $currentPartner->getAgency();
        }

        return $currentPartner;
    }

    public function create(array $attributes): bool
    {
        $attributes = $this->convertSwitch($attributes);
        return $this->createPartner($attributes);
    }

    public function createPartner(array $attributes = []): bool
    {
        if (empty($attributes)) {
            return false;
        }

        $data_member = $this->initDataCreateMember($attributes);
        $data_partner = $this->initDataCreatePartner($attributes);

        return $this->tryCatchFuncDB(function () use ($data_member, $data_partner) {
            $member = $this->memRepo->create($data_member);
            $partner = $this->partnerRepo->create($data_partner);

            if ($member && $partner) {
                $this->runEvent(new CountMemberRegist());
                $this->runEvent(new StatisticMoneyEvent($this->moneyInfoService->getAllTotalMoney()));
            }
        });
    }

    private function initDataCreateMember(array $attributes = []): array
    {
        return [
            'mMemberID' => data_get($attributes, 'mMemberID'),
            'mID' => data_get($attributes, 'mID'),
            'mPW' => data_get($attributes, 'mPW'),
            'mNick' => data_get($attributes, 'mNick'),
            'mStatus' => data_get($attributes, 'mStatus'),
            'mPhone' => data_get($attributes, 'mPhone'),
            'mBankName' => data_get($attributes, 'mBankName'),
            'mBankNumber' => data_get($attributes, 'mBankNumber'),
            'mBankOwner' => data_get($attributes, 'mBankOwner'),
            'mRegDate' => now(),
            'mLevel' => \App\Models\Member::M_LEVEL_MEMBER,
        ];
    }

    private function initDataCreatePartner(array $attributes = []): array
    {
        return [
            'pType' => data_get($attributes, 'pType'),
            'pProfitType' => data_get($attributes, 'pProfitType'),
            'mID' => data_get($attributes, 'mID'),
            'pName' => data_get($attributes, 'pName'),
            'pCommissions' => data_get($attributes, 'pCommissions'),
            'pIsCoupon' => data_get($attributes, 'pIsCoupon'),
            'pIsAutoPayRoulette' => data_get($attributes, 'pIsAutoPayRoulette'),
            'pIsSubRateConfig' => data_get($attributes, 'pIsSubRateConfig'),
            'pNote' => data_get($attributes, 'pNote'),
        ];
    }

    private function convertSwitch(array $attributes): array
    {
        $pIsSubRateConfig = 0;
        $pIsAutoPayRoulette = 0;
        $pIsCoupon = 0;

        if (request()->has('pIsAutoPayRoulette')) {
            $pIsAutoPayRoulette = 1;
        }

        if (request()->has('pIsCoupon')) {
            $pIsCoupon = 1;
        }

        if (request()->has('pIsSubRateConfig')) {
            $pIsSubRateConfig = 1;
        }

        $attributes['pIsAutoPayRoulette'] = $pIsAutoPayRoulette;
        $attributes['pIsCoupon'] = $pIsCoupon;
        $attributes['pIsSubRateConfig'] = $pIsSubRateConfig;

        return $attributes;
    }

    public function paginatePartners($level_type)
    {
        $parameters = [];
        if ($level_type != 'all') {
            $parameters['where'][] = ['pType', '=', $level_type];
        }

        if (request('date_search')) {
            $date_range = parseStringToDateRange(request('date_search'));

            $parameters['whereBetween'][] = ['pRegDate', $date_range];
        }

        if ($search = request('input_search')) {
            $parameters['whereHas'][] = ['member', function ($query) use ($search) {
                return $query->where('mID', 'like', '%' . $search . '%')->orWhere('mNick', 'like', '%' . $search . '%');
            }];
        }

        $orders = [['pRegDate', config('constant_view.QUERY_DATABASE.DESC')]];

        return $this->partnerRepo->paginate($parameters, $orders, ['member'], $per_page = self::COUNT_PER_PAGE);
    }

    public function validData($data)
    {
        $rule = [];
        $rule_field = [];
        $rule_form = [];
        $message = [];

        if (array_key_exists('pNo', $data)) {
            $item_partner = $this->partnerRepo->getByPK(data_get($data, 'pNo', null));
        }

        if (array_key_exists('mID', $data)) {

            $rule_field['mID'] = 'required|unique:member,mID|min:6|regex:/^[^\W_]+$/';

            if (isset($item_partner)) $rule_field['mID'] = '';
        }

        if (array_key_exists('mNick', $data)) {

            $rule_field['mNick'] = [
                'required',
                'unique:member,mNick',
                'check_mNick' => new \App\Rules\CheckMemberValid // Use the custom rule
            ];

            if (isset($item_partner)) {
                $rule_field['mNick'] = [
                    'required',
                    'unique:member,mNick,' . $item_partner->member->mNick . ',mNick',
                    'check_mNick' => new \App\Rules\CheckMemberValid // Use the custom rule
                ];
            }
        }

        if (array_key_exists('pType', $data)) {
            $rule_field['pType'] = 'required';

            if (in_array($data['pType'], ['distributor', 'agency'])) {

                Validator::extend('required_partner', function ($attribute, $value, $parameters, $validator) {
                    $data = $validator->getData();
                    if ($data['pType'] == 'distributor' || $data['pType'] == 'agency') {
                        return $this->partnerRepo->isExistsMemberIDByType($data['mMemberID'], $data['pType']);
                    }
                    return true;
                });

                $rule_field['mMemberID'] = 'required|required_partner';

                if (isset($item_partner)) $rule_field['mMemberID'] = 'required|not_in:' . $item_partner->mID . '|required_partner';
            }
        }

        if (array_key_exists('form', $data)) {
            $rule_form = [
                'pProfitType' => 'required',
                'mPW' => 'required|between:8,16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&)(]).+$/',
                'pName' => 'required',
                'mStatus' => 'required',
                'pCommissions' => 'required|numeric',
                'mPhone' => 'required',
                'mBankName' => 'required',
                'mBankOwner' => 'required',
                'mBankNumber' => 'required|numeric',
                'pNote' => 'max:100',
            ];
        }

        if (array_key_exists('form_update', $data)) {
            $rule_form = [
                'pProfitType' => 'required',
                'mPW' => 'nullable|between:8,16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&)(]).+$/',
                'pName' => 'required',
                'mStatus' => 'required',
                'pCommissions' => 'required|numeric',
                'mPhone' => 'required',
                'mBankName' => 'required',
                'mBankOwner' => 'required',
                'mBankNumber' => 'required|numeric',
                'pNote' => 'max:100',
            ];
        }

        $rule = array_merge($rule_field, $rule_form);

        $message = [
            'mID.required' => '아이디를 입력해주세요.',
            'mID.unique' => '아이디가 이미 존재합니다.',
            'mID.min' => '아이디는 문자, 숫자를 포함하여 6자 이상이어야 합니다.',
            'mID.regex' => '아이디는 문자, 숫자를 포함하여 6자 이상이어야 합니다.',

            'mNick.required' => '닉네임을 입력해주세요.',
            'mNick.unique' => '닉네임이 이미 존재합니다.',

            'pType.required' => '구분을 선택해주세요.',

            'mMemberID.required' => '추천인을 선택해주세요.',
            'mMemberID.required_partner' => '추천인은 선택한 구분에 따라야 합니다.',
            'mMemberID.not_in' => '추천인이 파트너 리스트에 없습니다.',

            'pProfitType.required' => '수익배분을 선택해주세요.',

            'mPW.required' => '비밀번호를 입력해주세요.',
            'mPW.between' => '비밀번호는 8~16자 이상이어야 하며, 소문자, 대문자, 숫자, 특수문자를 하나 이상 포함해야 합니다.',
            'mPW.regex' => '비밀번호는 8~16자 이상이어야 하며, 소문자, 대문자, 숫자, 특수문자를 하나 이상 포함해야 합니다.',

            'pName.required' => '파트너명을 입력해주세요.',
            'mStatus.required' => '상태을 선택해주세요.',

            'pCommissions.required' => '커미션을 입력해주세요.',
            'pCommissions.numeric' => '커미션은 숫자로 입력해야 합니다.',

            'mPhone.required' => '전화번호를 입력해주세요.',
            'mBankName.required' => '은행명을 입력해주세요.',
            'mBankOwner.required' => '예금주를 입력해주세요.',

            'mBankNumber.required' => '계좌번호를 입력해주세요.',
            'mBankNumber.numeric' => '계좌번호를 숫자로 입력해야 합니다.',

            'pNote.max' => '파트너정보를 최대 100자까지 입력하세요.',
        ];

        $rule = $this->sortRules($rule);

        $validator = Validator::make($data, $rule, $message);

        if ($validator->stopOnFirstFailure()->fails()) {
            $errors = $validator->errors();
            return ['success' => false, 'message' => $errors->first()];
        }

        return ['success' => true, 'message' => '확인되었습니다.'];
    }

    public function getDataItem($pNo)
    {
        $res = $this->partnerRepo->getByPK($pNo);

        $data = [
            'pNo' => $res->pNo,
            'pType' => $res->pType,
            'pProfitType' => $res->pProfitType,
            'mMemberID' => $res->member->mMemberID,
            'mID' => $res->mID,
            'mNick' => $res->member->mNick,
            'pName' => $res->pName,
            'mStatus' => $res->member->mStatus,
            'pCommissions' => $res->pCommissions,
            'pIsCoupon' => $res->pIsCoupon,
            'pIsAutoPayRoulette' => $res->pIsAutoPayRoulette,
            'mPhone' => $res->member->mPhone,
            'mBankName' => $res->member->mBankName,
            'mBankNumber' => $res->member->mBankNumber,
            'mBankOwner' => $res->member->mBankOwner,
            'pNote' => $res->pNote,
        ];

        return $data ?? [];
    }

    public function update($pNo, $data)
    {
        $data_member = $this->initDataUpdateMember($data, $pNo);
        $data_partner = $this->initDataUpdatePartner($data);

        return $this->tryCatchFuncDB(function () use ($data_member, $data_partner, $pNo) {
            $partner = $this->partnerRepo->getByPK($pNo);
            $this->memRepo->updateByPK($partner->member->mNo, $data_member);
            $this->partnerRepo->updateByPK($partner->pNo, $data_partner);
        });
    }

    private function initDataUpdateMember(array $attributes = [], $pNo): array
    {
        $data = [
            'mMemberID' => data_get($attributes, 'mMemberID'),
            'mNick' => data_get($attributes, 'mNick'),
            'mStatus' => data_get($attributes, 'mStatus'),
            'mPhone' => data_get($attributes, 'mPhone'),
            'mBankName' => data_get($attributes, 'mBankName'),
            'mBankNumber' => data_get($attributes, 'mBankNumber'),
            'mBankOwner' => data_get($attributes, 'mBankOwner')
        ];

        $partner = $this->partnerRepo->getByPK($pNo);

        $mPhone = data_get($attributes, 'mPhone');
        $check = $mPhone == hashString($partner->member->mPhone);
        $data['mPhone'] = $check ? $partner->member->mPhone : $mPhone;
        if (!$check) {
            $data['mPhoneCom'] = null;
        }

        if ($password = data_get($attributes, 'mPW')) {
            $data['mPW'] = $password;
        }
        return $data;
    }

    private function initDataUpdatePartner(array $attributes = []): array
    {
        return [
            'pType' => data_get($attributes, 'pType'),
            'pProfitType' => data_get($attributes, 'pProfitType'),
            'pName' => data_get($attributes, 'pName'),
            'pCommissions' => data_get($attributes, 'pCommissions'),
            'pNote' => data_get($attributes, 'pNote'),
        ];
    }

    public function countByType($level_type)
    {
        $parameters = [];
        if ($level_type != 'all') {
            $parameters['where'][] = ['pType', '=', $level_type];
        }

        return $this->partnerRepo->countWithConditions($parameters);
    }

    private function sortRules(array $rules): array
    {
        $order = [
            'pType',
            'pProfitType',
            'mMemberID',
            'mID',
            'mPW',
            'pName',
            'mNick',
            'mStatus',
            'pCommissions',
            'mPhone',
            'mBankName',
            'mBankOwner',
            'mBankNumber',
            'pIsCoupon',
            'pIsAutoPayRoulette',
            'pNote',
        ];

        uksort($rules, function ($key1, $key2) use ($order) {
            return array_search($key1, $order) - array_search($key2, $order);
        });

        return $rules;
    }

    public function toggleField(string $field, $pNo): bool
    {
        $config = $this->partnerRepo->getByPK($pNo);

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($config, $data) {
            $this->partnerRepo->updateByPK($config, $data);
        });
    }

    public function getDataTreeview()
    {
        $arr_open = !empty(json_decode(request('data_show'), true)) ? $this->setDataShowPartners(json_decode(request('data_show'), true)) : [];
        $partners = $this->memRepo->getPartners();
        $data = [];

        foreach ($partners as $partner) {

            if ($partner->mIsPartner) {
                $icon = in_array($partner->mID, $arr_open ?? []) ? '<i class="ion-android-remove-circle text-warning f-s-20 pointer-events-none"></i>' : '<i class="ion-android-add-circle text-warning f-s-20 pointer-events-none"></i>';
                $title = $partner->mID . ' / ' . $partner->mNick . ' (' . $partner->mPartnerName . ')';
                $toggle_button = $partner->children->isNotEmpty() ? '<a data-mID="' . $partner->mID . '" data-route="' . route('admin.partner.get-data-partner', ['parent_id' => $partner->mID]) . '" class="toggle-parent p-8">' . $icon . '</a>' : '';
                $data[] = [
                    'id' => $partner->mNo,
                    'level' => 1,
                    'parent_id' => 0,
                    'title' => $partner->mMemberID ? $title . ' (' . $partner->mMemberID . ')' : $title,
                    'count_childs' => $partner->countAllDescendants(),
                    'mRateCasino' => !empty($partner->memberConfig) && $partner->memberConfig->mcRollingCasinoRate ? $partner->memberConfig->mcRollingCasinoRate : '0.00',
                    'mMoneyCasino' => !empty($partner->memberConfig) && $partner->memberConfig->mcLossCasinoRate ? $partner->memberConfig->mcLossCasinoRate : '0.00',
                    'mRateSlot' => !empty($partner->memberConfig) && $partner->memberConfig->mcRollingSlotRate ? $partner->memberConfig->mcRollingSlotRate : '0.00',
                    'mMoneySlot' => !empty($partner->memberConfig) && $partner->memberConfig->mcLossSlotRate ? $partner->memberConfig->mcLossSlotRate : '0.00',
                    'redirect_link' => route('admin.status-members.index', ['select_field_search' => 'm_id', 'search' => $partner->mID, 'type_s' => 'equal', 'btn_submit' => 'click']),
                    'icon_is_partner' => $partner->mIsPartner ? '<i class="fa ion-person-add text-warning f-s-16 mr-5"></i>' : '',
                    'link_toggle' => $toggle_button,
                    'position' => $partner->mPartnerPosition,
                    'is_partner' => $partner->mIsPartner,
                    'hidden' => false,
                ];

                $data = array_merge($data, $this->getPartnerChildren($partner, 2));
            }
        }

        return $data;
    }

    public function getPartnerChildren($partner, $level = 1)
    {
        $arr_open = !empty(json_decode(request('data_show'), true)) ? $this->setDataShowPartners(json_decode(request('data_show'), true)) : [];
        $children = $partner->children->sortByDesc('mIsPartner');
        $data = [];

        foreach ($children as $child) {
            $title = $child->mIsPartner ? $child->mID . ' / ' . $child->mNick . ' (' . $child->mPartnerName . ')' : $child->mID . ' / ' . $child->mNick;
            $icon = in_array($child->mID, $arr_open ?? []) ? '<i class="ion-android-remove-circle text-warning f-s-20 pointer-events-none"></i>' : '<i class="ion-android-add-circle text-warning f-s-20 pointer-events-none"></i>';
            $toggle_button = $child->children->isNotEmpty() ? '<a data-mID="' . $child->mID . '" data-route="' . route('admin.partner.get-data-partner', ['parent_id' => $child->mID]) . '" class="toggle-parent p-8">' . $icon . '</a>' : '';
            $data[] = [
                'id' => $child->mNo,
                'level' => $level,
                'parent_id' => $partner->mNo,
                'title' => $title,
                'count_childs' => $child->countAllDescendants(),
                'mRateCasino' => !empty($child->memberConfig) && $child->memberConfig->mcRollingCasinoRate ? $child->memberConfig->mcRollingCasinoRate : '0.00',
                'mMoneyCasino' => !empty($child->memberConfig) && $child->memberConfig->mcLossCasinoRate ? $child->memberConfig->mcLossCasinoRate : '0.00',
                'mRateSlot' => !empty($child->memberConfig) && $child->memberConfig->mcRollingSlotRate ? $child->memberConfig->mcRollingSlotRate : '0.00',
                'mMoneySlot' => !empty($child->memberConfig) && $child->memberConfig->mcLossSlotRate ? $child->memberConfig->mcLossSlotRate : '0.00',
                'redirect_link' => route('admin.status-members.index', ['select_field_search' => 'm_id', 'search' => $child->mID, 'type_s' => 'equal', 'btn_submit' => 'click']),
                'icon_is_partner' => $child->mIsPartner ? '<i class="fa ion-person-add text-warning f-s-16 mr-5"></i>' : '',
                'link_toggle' => $toggle_button,
                'is_partner' => $child->mIsPartner,
                'hidden' => in_array($child->mMemberID, $arr_open ?? []) ? false : true
                // 'hidden' => false,
            ];

            $data = array_merge($data, $this->getPartnerChildren($child, $level + 1));
        }

        return $data;
    }

    public function setDataShowPartners(array $data): array
    {
        $member = $this->memRepo->getMemberByMID(request('parent_id'));

        $data = array_diff($data, $member->getAllChildrenMemberID());
        return array_values($data);
    }

    public function updateTreePartner(string $data)
    {
        $data = json_decode($data, true);

        $level_parents = array_filter($data, function ($item) {
            return $item['level'] == 1;
        }, ARRAY_FILTER_USE_BOTH);

        $levels = array_filter($data, function ($item) {
            return $item['level'] > 1;
        }, ARRAY_FILTER_USE_BOTH);

        if (!empty($this->validUpdateTreeview($levels)) || !empty($this->validPartnerParent($level_parents))) {
            return ['status' => false, 'message' => array_merge($this->validUpdateTreeview($levels), $this->validPartnerParent($level_parents))];
        }

        $status = $this->tryCatchFuncDB(function () use ($data) {
            $previousLevelId = [];

            foreach ($data as $item) {
                $level = $item['level'];
                $id = $item['id'];
                $position = $item['position'];

                if ($level == 1) {
                    $this->memRepo->updateByPK($id, ['mMemberID' => null, 'mPartnerPosition' => $position]);
                    $previousLevelId[$level] = $id;
                } else {
                    $parentLevel = $level - 1;
                    $parentId = $previousLevelId[$parentLevel];
                    $member_parent = $this->memRepo->getByPK($parentId);

                    $this->memRepo->updateByPK($id, ['mMemberID' => $member_parent->mID, 'mPartnerPosition' => null]);
                    $previousLevelId[$level] = $id;
                }
            }
        });

        return ['status' => $status];
    }

    private function validPartnerParent(array $levels): array
    {
        $errors = [];
        foreach ($levels as $item) {
            $member = $this->memRepo->getByPK($item['id']);

            if ($member->mIsPartner < 1) {
                $errors[] = ['message' => '파트나가 아닙니다.'];
            }
        }
        return $errors;
    }

    private function validUpdateTreeview(array $levels): array
    {
        $errors = [];

        foreach ($levels as $item) {

            $member_parent = $this->memRepo->getByPK($item['parent_id']);
            $member = $this->memRepo->getByPK($item['id']);

            $mcRollingCasinoRate_member = $member->memberConfig->mcRollingCasinoRate ?? 0;
            $mcRollingCasinoRate_partner = $member_parent->memberConfig->mcRollingCasinoRate ?? 0;

            if ($mcRollingCasinoRate_member > $mcRollingCasinoRate_partner) {
                $errors[] = ['message' => __('validation.mcRollingCasinoRate')];
            }

            $mcRollingSlotRate_member = $member->memberConfig->mcRollingSlotRate ?? 0;
            $mcRollingSlotRate_partner = $member_parent->memberConfig->mcRollingSlotRate ?? 0;

            if ($mcRollingSlotRate_member > $mcRollingSlotRate_partner) {
                $errors[] = ['message' => __('validation.mcRollingSlotRate')];
            }

            $mcLossCasionRate_member = $member->memberConfig->mcLossCasionRate ?? 0;
            $mcLossCasionRate_partner = $member_parent->memberConfig->mcLossCasionRate ?? 0;

            if ($mcLossCasionRate_member > $mcLossCasionRate_partner) {
                $errors[] = ['message' => __('validation.mcLossCasionRate')];
            }

            $mcLossSlotRate_member = $member->memberConfig->mcLossSlotRate ?? 0;
            $mcLossSlotRate_partner = $member_parent->memberConfig->mcLossSlotRate ?? 0;

            if ($mcLossSlotRate_member > $mcLossSlotRate_partner) {
                $errors[] = ['message' => __('validation.mcLossSlotRate')];
            }
        }

        return $errors;
    }
}
