<?php

namespace app\common\model;

use think\Model;

class Product Extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
        'extend'      => 'array'
    ];

    public function models()
    {
        return $this->hasMany(ProductModel::class, 'product_id', 'id');
    }

    public function getExtendAttr($value)
    {
        $value = is_string($value) ? json_decode($value, true) : $value;
        return !empty($value) ? array_column($value, null, 'code') : [];
    }
}
