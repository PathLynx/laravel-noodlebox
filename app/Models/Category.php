<?php

namespace App\Models;

use App\Models\Traits\HasImageAttribute;
use App\Models\Traits\HasMetas;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelPinyin\Facades\Pinyin;

/**
 * App\Models\Category
 *
 * @property int $cate_id 分类ID
 * @property int $parent_id 父级分类
 * @property string|null $name 分类名称
 * @property string|null $slug 别名
 * @property string $image 图标
 * @property string|null $description 描述
 * @property string|null $taxonomy 分类法
 * @property int|null $sort_num 排序
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CategoryMeta> $metas
 * @property-read int|null $metas_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $siblings
 * @property-read int|null $siblings_count
 * @method static Builder|Category filter(array $input = [], $filter = null)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Category query()
 * @method static Builder|Category simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Category whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Category whereCateId($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Category whereImage($value)
 * @method static Builder|Category whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereSortNum($value)
 * @method static Builder|Category whereTaxonomy($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasImageAttribute, HasMetas, Filterable;

    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    protected $fillable = ['parent_id', 'name', 'slug', 'image', 'description', 'taxonomy', 'sort_num'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('sort', function (Builder $builder) {
            return $builder->orderBy('sort_num')->orderBy('cate_id');
        });

        static::saving(function (Category $category) {
            if (!$category->slug) {
                $category->slug = strtolower(Pinyin::permalink($category->name));
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'cate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Category
     */
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'cate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Category
     */
    public function children()
    {
        return $this->childs()->with('children');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Category
     */
    public function siblings()
    {
        return $this->hasMany(Category::class, 'parent_id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metas()
    {
        return $this->hasMany(CategoryMeta::class, 'cate_id', 'cate_id');
    }
}