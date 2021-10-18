<?php

namespace app\common\model\domain;

use app\common\model\User;
use think\Model;
use traits\model\SoftDelete;

class Group extends Model
{
    use SoftDelete;

    protected $name = 'domain_group';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段类型
    protected $type = [
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];

    public function domains()
    {
        return $this->belongsTo(Domain::class, 'id', 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
