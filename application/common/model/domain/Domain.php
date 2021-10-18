<?php

namespace app\common\model\domain;

use app\common\model\User;
use think\Model;

class Domain extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'latest_time' => 'timestamp',
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    public function domainGroup()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
