<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\UserAccount
 *
 * @property int $id
 * @property int $user_id 会员ID
 * @property string|null $password 支付密码
 * @property string $balance 账户余额
 * @property string $freeze 冻结金额
 * @property string $total_income 累计收入
 * @property string $total_cost 累计支出
 * @property int $points 积分
 * @property int $coins 金币
 * @property int $freeze_coins 冻结金币
 * @property string $commission 佣金
 * @property string $cumulative_commission 累计佣金
 * @property string $withdrawal_commission 成功提现佣金
 * @property float $reward 奖励
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereCumulativeCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereFreezeCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereWithdrawalCommission($value)
 * @mixin \Eloquent
 */
class UserAccount extends Model
{
    protected $table = 'user_account';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'password', 'balance', 'freeze', 'total_income', 'total_cost',
        'points', 'coins', 'freeze_coins', 'commission', 'cumulative_commission'
    ];
    protected $hidden = ['password'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (UserAccount $account) {
            if (!$account->user_id) $account->user_id = Auth::id();
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
     * @return mixed|null
     */
    public function getPaymentPassword()
    {
        return $this->password;
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function incrementBalance($amount)
    {
        return app(AccountServiceInterface::class)->incrementBalance($this, $amount);
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function decrementBalance($amount)
    {
        return app(AccountServiceInterface::class)->decrementBalance($this, $amount);
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function incrementFreeze($amount)
    {
        return app(AccountServiceInterface::class)->incrementFreeze($this, $amount);
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function decrementFreeze($amount)
    {
        return app(AccountServiceInterface::class)->decrementFreeze($this, $amount);
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function freeze($amount)
    {
        return app(AccountServiceInterface::class)->freeze($this, $amount);
    }

    /**
     * @param $amount
     * @return mixed
     */
    public function unFreeze($amount)
    {
        return app(AccountServiceInterface::class)->unFreeze($this, $amount);
    }
}
