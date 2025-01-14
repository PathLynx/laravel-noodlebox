<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Express
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property string|null $regular
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|Express newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Express newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Express query()
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereRegular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereSortNum($value)
 * @mixin \Eloquent
 */
class Express extends Model
{
    protected $table = 'express';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'code', 'regular', 'sort_num'];

    public $timestamps = false;
}
