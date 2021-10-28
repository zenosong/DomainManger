<?php

namespace app\common\model;

use think\Model;

class ProductModel Extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    
    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
