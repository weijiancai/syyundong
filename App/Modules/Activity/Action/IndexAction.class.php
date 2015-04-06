<?php

/**
 *@时间:20150316
 *@功能:显示首页
 */
class IndexAction extends Action
{
    //首页内容
    public function index()
    {
        $this->display();
    }

    /*
     * @时间:20150406
     * @功能：发起活动
     */
    public function publish()
    {
        //首先判断用户是否登录
        /*$mark = I('session.mark');
        if ($mark) {
            $this->display();
        } else {
            $this->redirect('/login/login');
        }*/
        $this->display();
    }

    /*
   * @时间:20150402
   * @功能：热门活动推荐
   */
    public function hotactivity()
    {
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num,v.name,v.province,v.image,v.join_count,v.interested from v_game_activity v,op_recommend o where v.id = o.gc_id and o.recommend_type = "activity" order by o.sort_num');
        $this->assign('recommend', $list);
    }
}