<?php

namespace app\user\controller;

use app\common\controller\Userend;
use app\common\library\Auth;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\exception\ValidateException;
use think\Model;

/**
 * 产品管理
 */
class Product extends Userend
{

    /** @var Model */
    protected $model;
    protected $dataLimit = true;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new \app\common\model\user\Product();
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
                ->with(['user'])
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);

            foreach ($list as $row) {


            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }

        $productList = \app\common\model\Product::with(['models'])->where('status', 1)->select();
        $productList = collection($productList)->toArray();
        $productList = array_column($productList, null, 'code');
        foreach ($productList as &$item) {
            $item['models'] && $item['models'] = array_column($item['models'], null, 'code');
        }

        // 已有产品
        $userProductList = \app\common\model\user\Product::with(['product', 'product_model'])
            ->where($this->dataLimitField, $this->auth->id)
            ->select();
        $currentPackage = $singlePackage = null;
        foreach ($userProductList as $item) {
            // 当前套餐
            if ($item->product->code == 'single') {
                $singlePackage = $item;
            } else {
                $currentPackage = $item;
            }
        }
        $this->view->assign('currentPackage', $currentPackage);
        $this->view->assign('singlePackage', $singlePackage);
        $this->view->assign('productList', $productList);

        return $this->view->fetch();
    }

    public function order()
    {
        $data = $this->request->request();


    }

}
