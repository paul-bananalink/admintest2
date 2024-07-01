<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    const TYPE_LOGO = 'logo';
    const TYPE_CENTER = 'center';
    const TYPE_CENTER_BELOW = 'centerBelow';
    const TYPE_RIGHT = 'right';
    const TYPE_LEFT = 'left';
    const TYPES = [
        self::TYPE_LOGO,
        self::TYPE_CENTER,
        self::TYPE_CENTER_BELOW,
        self::TYPE_RIGHT,
        self::TYPE_LEFT,
    ];

    protected $table = 'banners';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'bNo';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const CREATED_AT = 'bRegDate';

    /**
     * Customize the names of the columns used to store the timestamps
     */
    const UPDATED_AT = 'bUpdateDate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bImage',
        'bLink',
        'bTarget',
        'bStatus',
        'bPosition',
        'bOrder'
    ];

    public function getImage()
    {
        $siteUrl = env('APP_URL');

        if (substr($siteUrl, -1) !== '/') {
            $siteUrl .= '/';
        }

        return $siteUrl . $this->bImage;
    }
}
