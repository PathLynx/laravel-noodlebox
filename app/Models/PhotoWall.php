<?php

namespace App\Models;

use App\Models\Traits\HasMetas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PhotoWall
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $thumb
 * @property string|null $image
 * @property int|null $sort_num
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Collection $meta_data
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PhotoWall extends Model
{
    use HasFactory, HasMetas;

    protected $table = 'photo_wall';
    protected $fillable = ['title', 'description', 'thumb', 'image', 'sort_num'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('sort', function ($builder) {
            return $builder->orderBy('sort_num', 'asc');
        });
    }
}