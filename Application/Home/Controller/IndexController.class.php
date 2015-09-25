<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{
    public function index(){
        $this->display('Public/index.html');
    }

    public function test(){
        $this->display('Public/test.html');
    }
}