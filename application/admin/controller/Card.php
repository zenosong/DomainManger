<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use fast\Random;
use think\Exception;
use think\exception\ValidateException;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Card extends Backend
{

    /**
     * Card模型对象
     * @var \app\common\model\Card
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\Card;

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function generate()
    {
        if ($this->request->isPost()) {
            $num = $this->request->request('num/d');
            $amount = $this->request->request('amount');

            $data = [
                'num'    => $num,
                'amount' => $amount
            ];
            try {
                $this->validateFailException(true)->validate($data, [
                    ['num', 'between:1,500', '请输入1-500之间的数字'],
                    ['amount', 'number', '请输入数字']
                ]);

                $insertData = [];
                for ($i = 0; $i < $num; $i++) {
                    $insertData[] = [
                        'number'   => Random::alnum(16),
                        'password' => Random::alnum(16),
                        'amount'   => $amount,
                        'status'   => 1
                    ];
                }

                $this->model->saveAll($insertData);

            } catch (ValidateException $exception) {
                $this->error($exception->getMessage());
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }

            $this->success('', null, $insertData);
        }

        return $this->view->fetch();
    }
}
