<?php

namespace app\user\controller;

use app\common\controller\Userend;
use app\common\library\Auth;
use app\common\model\ProductModel;
use fast\Arr;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\exception\ValidateException;
use think\Model;

/**
 * 订单管理
 */
class Order extends Userend
{

    /** @var Model */
    protected $model;
    protected $dataLimit = true;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new \app\common\model\user\Order;
    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
                ->with(['user', 'product', 'productModel'])
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);

            foreach ($list as $row) {


            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

    public function detail($id = null)
    {
        $row = $this->model->where('id', $id)
            ->where($this->dataLimitField, $this->auth->id)
            ->where('status', \app\common\model\user\Order::STATUS_PENDING)
            ->find();
        if (!$row) {
            $this->error('找不到订单，请确认');
        }

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function create()
    {
        $data = $this->request->request();
        try {
            $this->validateFailException(true)->validate($data, [
                ['product_model_id', 'require', '请选择支付产品'],
                ['product_num', 'number', '请填写数字'],
            ]);
        } catch (ValidateException $e) {
            $this->error($e->getMessage());
        }

        $row = $this->model->where($this->dataLimitField, $this->auth->id)
            ->where('product_model_id', $data['product_model_id'])
            ->where('product_num', $data['product_num'])
            ->where('expire_time', '>', time())
            ->find();

        if (!$row) {
            $productModel = ProductModel::with(['product'])
                ->where('id', $data['product_model_id'])
                ->where('status', ProductModel::STATUS_ENABLED)
                ->find();
            if (!$productModel) {
                $this->error('无效产品，请重新选择');
            }

            // 已存在有效产品时，折算应付金额
            $userProductList = \app\common\model\user\Product::with(['product', 'product_model'])
                ->where($this->dataLimitField, $this->auth->id)
                ->where('status', 1)
                ->where('expire_time', '>', time())
                ->select();

            // 原价
            $amount = $originAmount = floor(bcmul($productModel->price, (int)$data['product_num']));
            $expireTime = $originExpireTime = time() + 86400 * 30;

            if ($userProductList) {
                $currentPackage = [];
                foreach ($userProductList as $item) {
                    // 当前套餐
                    if ($item->product->code != 'single') {
                        $currentPackage = $item;
                        break;
                    }
                }

                if ($currentPackage) {
                    $surplusTime = strtotime($currentPackage->expire_time) - time();
                    if ($surplusTime > 0) {
                        // 剩余时间占比
                        $surplusRate = floor(1 - ($surplusTime / 30 * 86400));
                        // 单条产品
                        if ($productModel->product->code == 'single') {
                            $amount = $originAmount * $surplusRate;
                            $expireTime = $currentPackage->expire_time;
                        } else {    // 套餐产品
                            $amount = $originAmount - ($currentPackage->product_model->price * $surplusRate);
                            $expireTime = $currentPackage->expire_time;
                        }
                    }
                }
            }

            $row = $this->model::create([
                'user_id'             => $this->auth->id,
                'product_id'          => $productModel->product_id,
                'product_model_id'    => $productModel->id,
                'product_num'         => $data['product_num'],
                'amount'              => $amount,
                'real_amount'         => floor($productModel->discount > 0 ? bcmul($amount, $productModel->discount) : $amount),
                'product_expire_time' => $expireTime,
                'expire_time'         => time() + 7200
            ]);

            if (!$row) {
                $this->error('订单创建失败，请重试');
            }
        }

        $this->success('', null, $row);
    }

    public function pay($ids = null)
    {
        $row = $this->model->with(['product', 'product_model'])
            ->where('id', $ids)
            ->where($this->dataLimitField, $this->auth->id)
            ->where('status', \app\common\model\user\Order::STATUS_PENDING)
            ->find();
        if (!$row) {
            $this->error('未找到待支付订单');
        }

        if ($this->request->isPost()) {
            $data = $this->request->post();

            try {
                $cardValidator = function ($value, $data) {
                    if ($data['pay_type'] == 'card') {
                        if (!$value) {
                            throw new ValidateException('请填写卡密信息');
                        }
                    }
                    return true;
                };
                $this->validateFailException(true)->validate($data, [
                    ['pay_type', 'require', '请选择支付方式'],
                    ['card.number', $cardValidator, '请选择支付产品'],
                    ['card.password', $cardValidator, '请填写数字'],
                ]);
            } catch (ValidateException $e) {
                $this->error($e->getMessage());
            }

            dump($data);
            exit;
        }

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

}
