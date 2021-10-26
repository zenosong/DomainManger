<?php

namespace app\common\model;

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

}
