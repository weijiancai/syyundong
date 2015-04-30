<?php

/**
 *@时间:20150325
 *@功能:显示首页
 */
class IndexAction extends Action
{
    public function index()
    {
        $this->hotgame();
        $this->hot_activity();
        $this->assign('city',$this->getCity());
        $this->display();
    }

    /*
     * @功能:热门赛事排行
     * @时间：20150405
     */
    public function hotgame()
    {
        $model = D('VHotGameRanking');
        $hot = $model->limit(10)->select();
        $this->assign('hot', $hot);
    }

    /*
     * @功能:热门活动
     * @时间：20150405
     */
    public function hot_activity()
    {
        $hot = D('VHotActivity')->select();
        $this->assign('hot_activity', $hot);
    }

    /*
     * @功能注册图片验证码
     * @时间：20150328
     */
    Public function verify()
    {
        import('ORG.Util.Image');
        Image::buildImageVerify(4, 1, png, 90, 30, 'verify');
    }

    /*
    * @获得城市信息
    * @时间：20150422
    */
    Public function getCity()
    {
       return D('DbRegion')->where('pid =2 and level =3')->select();

    }


}