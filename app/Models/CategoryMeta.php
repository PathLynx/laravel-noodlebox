<?php

namespace App\Models;

use App\Models\Traits\HasMetaValueAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryMeta
 *
 * @property int $meta_id
 * @property int $category_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaValue($value)
 * @mixin \Eloquent
 */
class CategoryMeta extends Model
{
    use HasMetaValueAttribute;

    protected $table = 'category_meta';
    protected $primaryKey = 'meta_id';
    protected $fillable = ['cate_id', 'meta_key', 'meta_value'];

    public $timestamps = false;
}
