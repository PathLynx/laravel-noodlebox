<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\UserAddress
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property string|null $tag 标签
 * @property string|null $first_name 姓名
 * @property string|null $last_name
 * @property string|null $phone 电话
 * @property string|null $country
 * @property string|null $state 省
 * @property string|null $city 市
 * @property string|null $county 区县
 * @property string|null $address_line_1 详细地址
 * @property string|null $address_line_2 详细地址
 * @property float $latitude 纬度
 * @property float $longitude 经度
 * @property string|null $postalcode 邮编
 * @property int $isdefault 是否默认地址
 * @property-read string $formatted_address
 * @property-read \App\Models\User|null $user
 * @method static Builder|UserAddress newModelQuery()
 * @method static Builder|UserAddress newQuery()
 * @method static Builder|UserAddress query()
 * @method static Builder|UserAddress whereAddressLine1($value)
 * @method static Builder|UserAddress whereAddressLine2($value)
 * @method static Builder|UserAddress whereCity($value)
 * @method static Builder|UserAddress whereCountry($value)
 * @method static Builder|UserAddress whereCounty($value)
 * @method static Builder|UserAddress whereFirstName($value)
 * @method static Builder|UserAddress whereId($value)
 * @method static Builder|UserAddress whereIsdefault($value)
 * @method static Builder|UserAddress whereLastName($value)
 * @method static Builder|UserAddress whereLatitude($value)
 * @method static Builder|UserAddress whereLongitude($value)
 * @method static Builder|UserAddress wherePhone($value)
 * @method static Builder|UserAddress wherePostalcode($value)
 * @method static Builder|UserAddress whereState($value)
 * @method static Builder|UserAddress whereTag($value)
 * @method static Builder|UserAddress whereUserId($value)
 * @mixin \Eloquent
 */
class UserAddress extends Model
{
    protected $table = 'user_address';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'first_name', 'last_name',
        'phone', 'state', 'city', 'county',
        'address_line_1', 'address_line_2',
        'postalcode', 'isdefault', 'tag',
        'latitude', 'longitude'
    ];
    protected $appends = ['formatted_address'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function (UserAddress $address) {
            if (!$address->user_id) $address->user_id = Auth::id();
        });
        static::addGlobalScope('sort', function (Builder $builder) {
            return $builder->orderByDesc('isdefault')->orderBy('id');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return string
     */
    public function getFormattedAddressAttribute()
    {
        $address = $this->address_line_1;
        if ($this->address_line_2) {
            $address .= ' ' . $this->address_line_2;
        }

        if ($this->county) {
            $address .= ',' . $this->county;
        }

        if ($this->city) {
            $address .= ',' . $this->city;
        }

        if ($this->state) {
            $address .= ',' . $this->state;
        }

        if ($this->postalcode) {
            $address .= ',' . $this->postalcode;
        }

        return $address;
    }
}
