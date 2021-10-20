<?php

namespace app\common\model\domain;

use app\common\model\User;
use think\Model;

class Record extends Model
{
    protected $name = 'domain_record';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    public function domain()
    {
        return $this->belongsTo(User::class, 'domain_id', 'id');
    }
}
