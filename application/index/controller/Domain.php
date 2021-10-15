<?php

namespace app\index\controller;

use app\common\controller\Frontend;

class Domain extends Frontend
{

    protected $noNeedLogin = [];
    protected $noNeedRight = '*';
    protected $layout = 'default';


    public function index()
    {
        return $this->view->fetch();
    }

    public function group()
    {
        return $this->view->fetch();
    }

    public function single()
    {
        return $this->view->fetch();
    }

}
