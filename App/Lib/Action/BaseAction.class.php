<?php

/**
 * Created by PhpStorm.
 * User: liuliting
 * Date: 15-5-2
 * Time: 下午8:59
 */
Class BaseAction extends Action
{
    public function _initialize()
    {

    }

    public function CommentReply()
    {
        $model = D('OpComment');
        $date['content'] = $_POST['content'];
        $date['replay_to'] = $_POST['replay_to'];
        $date['user_id'] = deCode(I('session.mark_id'));
        $date['source_id'] = $_POST['source_id'];
        $date['source_type'] = 4;
        $date['input_date'] = date('Y-m-d H:i:s');
        $result = $model->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 0;
        }
    }
    /*
     * @功能：时间轴
     * @时间: 20150512
     */
    function  TimeLine($line_id, $name, $des, $type)
    {
        $date['source_id'] = $line_id;
        $date['source_name'] = $name;
        $date['source_type'] = $type;
        $date['source_des'] = $des;
        $date['input_date'] = date('Y-m-d H:i:s');
        $date['input_user'] = deCode(I('session.mark_id'));
        D('DbTimeLine')->add($date);
    }

    /*
    * 功能：活动项目
    * 时间：20150407
    */
    public function activity_sport()
    {
        return D('DzSport')->where('sport_type=2')->select();
    }

    /*
     * 功能：场馆信息
     * 时间：20150407
     */
    public function venue_sport()
    {
        return D('DzSport')->where('sport_type=3')->select();
    }



}

?>