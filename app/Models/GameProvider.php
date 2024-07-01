<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameProvider extends Model
{
    use HasFactory;

    protected $table = 'game_provider';

    protected $primaryKey = 'gpNo';

    const CATEGORY_CASINO_AND_SLOT = [
        "Slot",
        "Live Casino",
        "Slot + Live Casino"
    ];

    const NAME_CASINO = 'casino';

    const NAME_SLOT = 'slot';

    const CATEGORY_CASINO = [
        "Live Casino",
        "Slot + Live Casino"
    ];

    const CATEGORY_SLOT = [
        "Slot",
        "Slot + Live Casino"
    ];

    public static $categories = [
        self::NAME_CASINO => self::CATEGORY_CASINO,
        self::NAME_SLOT => self::CATEGORY_SLOT
    ];

    const TYPE_CASINO = "Live Casino";
    const TYPE_SLOT = "Slot";
    const TYPE_SLOT_AND_CASINO = "Slot + Live Casino";

    const IMAGE_LOGO = "logo";
    const IMAGE_AVATAR = "avatar";
    const IMAGE_BACKGROUND = "background";

    public $timestamps = false;

    protected $fillable = [
        'gpNo',
        'gpLogo',
        'gpAvatar',
        'gpImgBackground',
        'gpCode',
        'gpName',
        'gpNameEn',
        'gpCategory',
        'gpCode',
        'gpIsGameProvider',
        'gpIsMaintenance',
        'gpMaintainSchedule',
        'gpMaintenance',
        'gpImages',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gpIsGameProvider' => 'boolean',
            'gpIsMaintenance' => 'boolean',
            'gpMaintenance' => 'array',
            'gpImages' => 'array',
        ];
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'gpCode', 'gpCode');
    }

    public function getImage()
    {
        $siteUrl = env('APP_URL');

        if (substr($siteUrl, -1) !== '/') {
            $siteUrl .= '/';
        }

        return $siteUrl . $this->gpAvatar;
    }

    public function getImageApi()
    {
        $siteUrl = env('API_URL');

        if (substr($siteUrl, -1) !== '/') {
            $siteUrl .= '/';
        }

        return $siteUrl . $this->gpAvatar;
    }

    public function jsonImagesByType(string $type)
    {
        $data = [];

        if (data_get($this->gpImages, 'slot')) {
            $data['slot'] = data_get($this->gpImages, 'slot.' . $type) ? getImageUrl(data_get($this->gpImages, 'slot.' . $type)) : '';
        }

        if (data_get($this->gpImages, 'casino')) {
            $data['casino'] = data_get($this->gpImages, 'casino.' . $type) ? getImageUrl(data_get($this->gpImages, 'casino.' . $type)) : '';
        }

        return json_encode($data);
    }

    public function getTypeAttribute()
    {
        $type = '';

        if (in_array($this->gpCategory, self::CATEGORY_CASINO)) {
            $type = self::NAME_CASINO;
        }
        if (in_array($this->gpCategory, self::CATEGORY_SLOT)) {
            $type = self::NAME_SLOT;
        }

        return $type;
    }

    public function checkIsMaintenance()
    {
        if (!$this->gpMaintenance) return false;

        $slot = $this->handleMaintain('slot');
        $casino = $this->handleMaintain('casino');

        return json_encode(array_merge($slot, $casino));
    }

    private function checkTime(string $time): bool
    {
        $time = explode(' - ', $time);

        if (count($time) !== 2) return false;

        $currentDate = strtotime(date("Y-m-d H:i"));
        $startDate = strtotime($time[0]);
        $endDate = strtotime($time[1]);

        return $currentDate >= $startDate && $currentDate <= $endDate;
    }

    private function handleMaintain(string $type)
    {
        $data = $this->gpMaintenance[$type] ?? false;

        if (!$data) return [];

        $maintain = [];

        if ($data['enable']) {
            $maintain[$type]['enable'] = true;
        } else {
            $maintain[$type]['enable'] = false;
            if ($this->checkTime($data['time'])) $maintain[$type]['enable'] = true;
        }
        $maintain[$type]['time'] = $data['time'];

        return $maintain;
    }
}
