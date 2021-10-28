<?php

namespace app\common\model;

use app\common\library\UserAuth;
use think\Exception;
use think\Model;


class Card extends Model
{
    // 表名
    protected $name = 'card';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'use_time'    => 'timestamp',
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    const STATUS_INVALID = 0;
    const STATUS_VALID = 1;
    const STATUS_USED = 2;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 消费
     */
    public function consume($orderId, $number, $password, $amount)
    {
        $row = $this->where('status', 1)
            ->where('number', $number)
            ->where('password', $password)
            ->find();

        if ($row) {
            if ($row->amount >= $amount) {
                $user = UserAuth::instance()->getUser();
                $row->status = self::STATUS_USED;
                $row->user_id = $user->id;
                $row->use_time = time();
                $r = $row->save();
                if ($r) {
                    $surplusAmount = $row->amount - $amount;
                    $moneyLog = MoneyLog::create([
                        'user_id'  => $row->user_id,
                        'order_id' => $orderId,
                        'money'    => $surplusAmount,
                        'before'   => $user->money,
                        'after'    => $user->money + $surplusAmount,
                        'memo'     => '卡密余额'
                    ]);
                    $user->money = $moneyLog->after;
                    $user->save();

                    return true;
                } else {
                    throw new Exception('支付异常，请联系管理员');
                }
            } else {
                throw new Exception('卡密余额不足');
            }
        }

        throw new Exception('无效卡密');
    }
}
