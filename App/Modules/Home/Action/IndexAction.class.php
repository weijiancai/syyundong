<?php

/**
 *@时间:20150325
 *@功能:显示首页
 */
class IndexAction extends BaseAction
{
    public function index()
    {
        $this->hotgame();
        $this->hot_activity();
        $this->assign('city', $this->getCity());
        $this->assign('hot_activity', $this->getHotActivity());
        $this->assign('doyen_user', $this->getDoyenUser());
        $this->assign('game_sport',$this->getGameSport());
        $this->doyen();
        $this->association();
        $this->friend_recommend();
        $this->BannerImage();
        $this->assign('sport_game',D('Public/Index')->sport_top());
        $this->assign('activity_sport', $this->activity_sport());
        $this->assign('venue_sport', $this->venue_sport());
        $this->assign('region', D('Public/Index')->region());
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

    /*
    * @功能：热门活动
    * @时间：20150501
    */
    Public function getHotActivity()
    {
        return D('VHotActivity')->select();
    }

    /*
    * @功能：赛友达人堂
    * @时间：20150501
    */
    Public function getDoyenUser()
    {
        return D('v_doyen_user')->select();
    }

    /*
    * @功能：赛友达人堂
    * @时间：20150501
    */
    Public function getGameSport()
    {
        return D('DzSport')->where('pid=0 and level =1 and sport_type=1')->select();
    }

    /*
     * @功能：热门赛友圈
     * @时间:20150418
     */
    public function friend_recommend(){
        $model = New Model();
        $list = $model->query('select v.id,o.sort_num, v.name,v.province,v.image,v.province,v.join_count from v_game_activity v,op_recommend o
                                where v.id = o.gc_id and o.recommend_type = "game" and v.type="game" order by o.sort_num limit 9');
        $this->assign('recommend', $list);
    }

    /*
     * @功能：首页轮播图
     * @时间:20150418
     */
    public function BannerImage(){
        $model= new Model();
        $banner = $model->query('SELECT id,name,image FROM v_recommend_game ORDER BY input_date DESC, join_count DESC  LIMIT 0, 6');
        $this->assign('banner',$banner);
    }
    /*
     * @功能：达仁堂
     * @时间:20150418
     */
    public function doyen(){
        $doyen = M('VDoyenHall')->order('input_date desc')->limit(2)->select();
        $this->assign('doyen',$doyen);
    }
    /*
     * @功能：体育协会
     * @时间:20150418
     */
    public function association(){
        $association = M('VSportAssociation')->order('input_date desc')->limit(2)->select();
        $this->assign('association',$association);
    }

}