<?php

namespace App\Models;

use App\Models\Traits\HasImageAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Link
 *
 * @property int $id 主键
 * @property int $cate_id 分类ID
 * @property string $type 类型
 * @property string|null $title 标题
 * @property string|null $url 链接
 * @property string $image 图片
 * @property string|null $description 描述
 * @property int $sort_num 排序
 * @property-read Link|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Link> $links
 * @property-read int|null $links_count
 * @method static Builder|Link newModelQuery()
 * @method static Builder|Link newQuery()
 * @method static Builder|Link onlyCategory()
 * @method static Builder|Link onlyLink()
 * @method static Builder|Link query()
 * @method static Builder|Link whereCateId($value)
 * @method static Builder|Link whereDescription($value)
 * @method static Builder|Link whereId($value)
 * @method static Builder|Link whereImage($value)
 * @method static Builder|Link whereSortNum($value)
 * @method static Builder|Link whereTitle($value)
 * @method static Builder|Link whereType($value)
 * @method static Builder|Link whereUrl($value)
 * @mixin \Eloquent
 */
class Link extends Model
{
    use HasImageAttribute;

    protected $table = 'link';
    protected $primaryKey = 'id';
    protected $fillable = ['cate_id', 'type', 'title', 'url', 'image', 'description', 'sort_num'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('sort', function (Builder $builder) {
            return $builder->orderBy('sort_num')->orderBy('id');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany(Link::class, 'cate_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Link::class, 'cate_id', 'id');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyCategory(Builder $builder)
    {
        return $builder->where('type', 'category');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyLink(Builder $builder)
    {
        return $builder->where('type', 'item');
    }
}