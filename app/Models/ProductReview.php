<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\ProductReview
 *
 * @property int $id 主键
 * @property int $user_id 用户
 * @property int $order_id 关联订单
 * @property int $product_id 关联商品
 * @property string|null $message 评论内容
 * @property int $product_scores 商品评分
 * @property int $service_scores 服务评分
 * @property int $logistics_scores 物流评分
 * @property int $anony 匿名评论
 * @property \Illuminate\Support\Carbon|null $created_at 评论时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReviewImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereAnony($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereLogisticsScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereProductScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereServiceScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereUserId($value)
 * @mixin \Eloquent
 */
class ProductReview extends Model
{
    use HasDates;

    protected $table = 'product_review';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'product_id', 'order_id', 'message', 'product_scores', 'service_scores', 'logistics_scores', 'anony'
    ];
    protected $hidden = ['logistics_scores'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::deleting(function (ProductReview $review) {
            $review->images()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductReviewImage::class, 'review_id', 'id');
    }
}
