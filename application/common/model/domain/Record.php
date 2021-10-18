<?php

namespace app\common\model\domain;

use think\Model;

class Record extends Model
{
    protected $name = 'domain_record';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义字段类型
    protected $type = [
    ];
}
