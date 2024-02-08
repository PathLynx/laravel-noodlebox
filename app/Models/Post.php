<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasImageAttribute;
use App\Models\Traits\HasMetas;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelPinyin\Facades\Pinyin;


/**
 * App\Models\Post
 *
 * @property int $id 文章ID
 * @property int $user_id 会员ID
 * @property string|null $author 作者
 * @property string|null $format 文章格式
 * @property string|null $type 文章类型
 * @property string|null $title 文章标题
 * @property string|null $slug 别名
 * @property string|null $keywords 标签
 * @property string|null $description 摘要
 * @property string $image 图片
 * @property int $allow_comment 允许评论
 * @property int $comment_num 评论数
 * @property int $collect_num 被收藏数
 * @property int $like_num 点赞数
 * @property int $views 浏览数
 * @property string|null $from 来源
 * @property string|null $fromurl 来源地址
 * @property float $price 阅读价格
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $collectedUsers
 * @property-read int|null $collected_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\PostContent|null $content
 * @property-read mixed $format_des
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read mixed $status_des
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostLog> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \App\Models\User|null $user
 * @method static Builder|Post filter(array $input = [], $filter = null)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Post query()
 * @method static Builder|Post simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Post whereAllowComment($value)
 * @method static Builder|Post whereAuthor($value)
 * @method static Builder|Post whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Post whereCollectNum($value)
 * @method static Builder|Post whereCommentNum($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDescription($value)
 * @method static Builder|Post whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Post whereFormat($value)
 * @method static Builder|Post whereFrom($value)
 * @method static Builder|Post whereFromurl($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereImage($value)
 * @method static Builder|Post whereKeywords($value)
 * @method static Builder|Post whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Post whereLikeNum($value)
 * @method static Builder|Post wherePrice($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereStatus($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereType($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 * @method static Builder|Post whereViews($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use Filterable, HasImageAttribute, HasDates, HasMetas;

    const STATUS_PUBLISH = 'publish';
    const STATUS_DRAFT = 'draft';
    const STATUS_INHERIT = 'inherit';
    const STATUS_PENDING = 'pending';

    protected $table = 'post';
    protected $primaryKey = 'id';
    protected $casts = [
        'tags' => 'array'
    ];
    protected $appends = [
        'status_des',
        'url',
    ];
    protected $fillable = [
        'id', 'user_id', 'author', 'format', 'type', 'title', 'slug',
        'keywords', 'description', 'image', 'allow_comment', 'comment_num',
        'collect_num', 'like_num', 'views', 'from', 'fromurl',
        'price', 'status', 'created_at', 'updated_at'
    ];

    protected $with = ['user', 'images', 'categories', 'metas'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::saving(function (Post $post) {
            if (!$post->user_id) {
                $post->user()->associate(Auth::user());
            }

            if (!$post->slug) {
                $post->slug = strtolower(Pinyin::permalink($post->title));
            }
        });

        static::created(function (Post $post) {
            $post->content()->create();
        });

        static::deleting(function (Post $post) {
            $post->categories()->sync([]);
            $post->content()->delete();
            $post->images()->delete();
            $post->comments()->delete();
            $post->logs()->delete();
            $post->metas()->delete();
        });
    }

    public function __construct(array $attributes = [])
    {
        if (empty($attributes)) {
            $attributes = [
                'price' => '0',
                'from' => env('APP_NAME'),
                'fromurl' => env('APP_URL'),
                'excerpt' => '',
                'format' => 'standard',
                'status' => 'draft',
                'author' => Auth::check() ? Auth::user()->nickname : '',
                'created_at' => now(),
                'allow_comment' => 1
            ];
        }
        parent::__construct($attributes);
    }

    /**
     * @return mixed
     */
    public function getStatusDesAttribute()
    {
        return $this->status ? trans('post.statuses.' . $this->status) : null;
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlAttribute()
    {
        return $this->slug ? url($this->type . '/' . $this->slug) : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Category
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_relationship',
            'object_id',
            'category_id',
            'id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|PostContent
     */
    public function content()
    {
        return $this->hasOne(PostContent::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(PostLog::class, 'post_id', 'id');
    }

    public function metas()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|User
     */
    public function collectedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'post_collect',
            'post_id',
            'user_id',
            'id',
            'id'
        )->as('subscribe')->withTimestamps()->orderBy('post_collect.created_at', 'desc');;
    }

    public function incrementViews($amount = 1)
    {
        return $this->increment('views', $amount);
    }

    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISH;
    }

    public function markAsPublished()
    {
        $this->forceFill(['status' => self::STATUS_PUBLISH])->save();
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function markAsPending()
    {
        $this->forceFill(['status' => self::STATUS_PENDING])->save();
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function markAsDraft()
    {
        $this->forceFill(['status' => self::STATUS_DRAFT])->save();
    }
}
