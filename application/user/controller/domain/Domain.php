<?php

namespace app\user\controller\domain;

use app\common\controller\Userend;
use app\common\library\Auth;

/**
 * 域名管理
 */
class Domain extends Userend
{

    protected $model;
    protected $dataLimit = true;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = model('common/domain/Domain');
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
                ->with(['domainGroup', 'user'])
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

}
