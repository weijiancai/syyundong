<?php
/**
*@时间:20150316
*@功能:显示首页
*/
class IndexAction extends Action {
	//首页内容
	public function index(){
        if($_GET['statusReg']=='T'){
            $status= ',1';
        }
        if($_GET['statusIn']=='T'){
            $status.=',3';
        }
        if($_GET['statusOver']=='T'){
            $status.=',4';
        }
        $status = ltrim($status,',');
        //默认排序
        if($_GET['orderByNew']=='S'){
            $order ='reg_begin_date desc';
        }
        //最新赛事
        if($_GET['orderByNew']=='C'){
            $order ='start_date desc';
        }
        //最热赛事
        if($_GET['orderByNew']=='F'){
            $order  = 'focus_count desc';
        }
        //关键字
        /*if(){

        }*/
        import('ORG.Util.Page');
        $model = D('VGameActivity');
        if($status){
            $map['status'] = $status;
        }
        $map['type'] = array('eq','activity');
        $count = $model->where($map)->count();
        $Page  = new Page($count,3);
        $Page->setConfig("theme","%first% %upPage%  %linkPage%  %downPage% %end% 共%totalPage% 页");
        //  $Page->url = '__APP_/Game?statusReg='.$_GET['statusReg'].'&statusIn='.$_GET['statusIn'].'&statusOver='.$_GET['statusIn'].'&orderByNew='.$_GET['orderByNew'].'&order='.$_GET['orderByNew'].'&page'.$page;
        $Page->rollPage = 10;
        $list = $model->limit($Page->firstRow.','.$Page->listRows)->where($map)->order($order)->select();
        $show = $Page->show();
        $this->assign('page',$show);
        $this->assign('game',$list);
        $this->assign('count',$count);
        $this->hotactivity();
        $this->display();
	}
    /*
   * @时间:20150402
   * @功能：热门活动推荐
   */
    public function hotactivity(){
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num,v.name,v.province,v.image,v.join_count,v.interested from v_game_activity v,op_recommend o where v.id = o.gc_id and o.recommend_type = "activity" order by o.sort_num');
        $this->assign('recommend', $list);
    }
}