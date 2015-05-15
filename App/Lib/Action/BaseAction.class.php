<?php
/**
 * Created by PhpStorm.
 * User: liuliting
 * Date: 15-5-2
 * Time: 下午8:59
 */
Class BaseAction extends Action{
    public function _initialize(){

    }
    /*
     * @功能：时间轴
     * @时间: 20150512
     */
    function  TimeLine($line_id,$name,$des,$type)
    {
        $date['line_id'] =$line_id;
        $date['name'] =$name;
        $date['description'] =$des;
        $date['type'] =$type;
        $date['input_date'] =date('Y-m-d H:i:s');
        $date['input_user'] =deCode(I('session.mark_id'));
        D('DBTimeLine')->save($date);
    }
}


?>