<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LotteryPrize
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $title
 * @property string|null $image
 * @property int|null $points
 * @property int $stock
 * @property float $percent
 * @property int $sort_num
 * @property int $product_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize query()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryPrize whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LotteryPrize extends Model
{
    use HasFactory, HasDates;

    protected $table = 'lottery_prize';
    protected $fillable = ['type', 'title', 'image', 'sort_num', 'percent', 'status', 'quantity', 'product_id'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('sort', function ($builder) {
            return $builder->orderBy('sort_num', 'asc');
        });
    }
}
