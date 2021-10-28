<?php


namespace app\common\model\user;


use think\Model;

class Product extends Model
{
    protected $name = 'user_product';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'expire_time' => 'timestamp',
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    public function product()
    {
        return $this->belongsTo(\app\common\model\Product::class, 'product_id', 'id');
    }

    public function productModel()
    {
        return $this->belongsTo(\app\common\model\ProductModel::class, 'product_model_id', 'id');
    }
}