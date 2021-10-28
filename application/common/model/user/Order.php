<?php


namespace app\common\model\user;


use app\common\model\User;
use fast\Random;
use think\Model;

class Order extends Model
{
    protected $name = 'user_order';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $insert = ['order_no'];

    // 定义字段类型
    protected $type = [
        'product_expire_time' => 'timestamp',
        'expire_time'         => 'timestamp',
        'pay_time'            => 'timestamp',
        'create_time'         => 'timestamp',
        'update_time'         => 'timestamp',
    ];

    const STATUS_PENDING = 0;
    const STATUS_PAID = 1;
    const STATUS_INVALID = 2;

    const PAY_TYPE_CARD = 'card';
    const PAY_TYPE_RECHARGE = 'recharge';

    public function setOrderNoAttr()
    {
        return date('YmdHis') . Random::alnum();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(\app\common\model\Product::class, 'product_id', 'id');
    }

    public function productModel()
    {
        return $this->belongsTo(\app\common\model\ProductModel::class, 'product_model_id', 'id');
    }
}