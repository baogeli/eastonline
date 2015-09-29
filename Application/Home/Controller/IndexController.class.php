<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{
    public function index(){
        $epg_list = M('epg_list');
        $epg_list = $epg_list->select();
        $this->assign('l',$epg_list);
        $this->display('Public/index.html');
    }

    public function test(){
        $this->display('Public/test.html');
    }

    //  ajax return detail result type:json
    public function ajaxDetail() {
        $channel_id = I('id');
        $epg_view = M('epg_view');
        $condition['list_id'] = $channel_id;
        $epg_view = $epg_view->where($condition)->select();
        $html = "<div class='ajax_content' style='color: #ffffff;'>";
        foreach ($epg_view as $e) {
            $html.= 'id:'.$e['list_id'].'<br>节目名称:'
                         .$e['view_name'].'<br>播出时间'
                         .$e['view_begintime'];

        }
        $html .= "</div>";
        echo $html;
    }
}