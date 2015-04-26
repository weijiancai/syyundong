<?php

/**
 * @时间:20150422
 * @功能:场馆管理
 * @VIEW:db_game
 * @Author：liuliting
 */
class DbVenueAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbVenue');
        if (!empty ($model)) {
            $order = "";
            $order .= "input_date desc,";
            $this->_list($model, $map, $order);
        }
        $this->assign('dzSport', $this->DzSport());
        $this->display();
    }

    /*
     * @功能：查询条件返回
     * @时间：20150422
     */
    protected function _search()
    {
        $model = D('DbVenue');
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        return $map;
    }

    /*
     * @功能：场馆新增页面
     * @时间：20150422
     */
    function add()
    {
        $this->assign('province', $this->getProvince());
        $this->assign('dzSport', $this->dzSport());
        $this->display();
    }

    /*
     * @功能：场馆新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('DbVenue');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败", $name, "", "closeCurrent");
        }
    }

    /*
     * @功能：场馆编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DbVenue');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        //活动城市
        $where['pid'] = $vo['province'];
        $city = D('DbRegion')->where($where)->select();
        $this->assign('city', $city);
        //活动区域
        $where['pid'] = $vo['city'];
        $venue = D('DbRegion')->where($where)->select();
        $this->assign('venue', $venue);
        $this->assign('province', $this->getProvince());
        $this->assign('dzSport', $this->dzSport());
        $this->display();
    }

    /*
     * @功能：活动更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DbActivity';
        $model = D('DbActivity');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->save();
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $name, "", "closeCurrent");
        }
    }
    /*
     * @功能：活动删除
     * @时间：20150422
     */
    public function delAll(){
        $model = D('DbActivity');
        $pk=$model->getPk ();
        $data[$pk]=array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1',"删除成功",$name,"","");
    }
    /*
     * @功能：场馆分类
     * @时间：20150422
     */
    public function DzSport()
    {
        return D('DzSport')->field('id,name')->where('pid=0 and sport_type=3')->select();
    }
    /*
     * @功能：场馆省份
     * @时间：20150422
     */
    public function getProvince(){
        return D('DbRegion')->field('id,name')->where('pid=0 and level=1')->select();
    }
    /*
     * @功能：场馆城市
     * @时间：20150422
     */
    public function getActivityCity()
    {
        $where['pid'] = $_GET['id'];
        $data = D('DbRegion')->field('id,name')->where($where)->select();
        echo json_encode($data);
    }
    /*
     * @功能：活动报名填写信息
     * @时间：20150422
     */
    public function getCheck(){
        $model = D('DbActivity');
        $where['id'] =$_GET['id'];
        $vo = $model->where($where)->find();
        $code = explode(",",$vo['join_need_info']);
        echo json_encode($code);
    }

    /*
     * @功能：ajax上传图片
     * @时间：20150422
     */
    public function upimg()
    {
        import('ORG.Util.Image');
        import('ORG.Net.UploadFile');
        $path = $_POST['path'];
        $upload = new UploadFile(); // 实例化上传类
        $upload->maxSize = 6291456; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->savePath = './Public/upload/' . $path . '/'; // 设置附件上传目录
        $upload->thumb = true;
        $upload->thumbPrefix = '';
        $upload->thumbMaxWidth = '600';
        $upload->thumbMaxHeight = '400';
        $upload->thumbType = 0;
        $upload->zipImages = true;
        $upload->autoSub = true;
        $upload->subType = date;
        if (!$upload->upload()) { // 上传错误提示错误信息
            if ($upload->getErrorMsg() != "没有选择上传文件") { //不上传文件通过
                $e = $this->error($upload->getErrorMsg());
                echo $e;
            }
        } else { // 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();

            //存储图片
            $date['local_url'] = '/Public/upload/' . $path . '/' . $info[0]['savename'];
            $result = D('DbImages')->add($date);
            //打水印
            /* $Image = new Image();
             foreach ($info as $value) {
                 $$value['key'] = $value['savename'];
                 $Image->water('./Public/Upload/game/' . $value['savename'], './Public/images/common/logo1.png'); //打水印
             }*/
            $arr = array(
                'name' => $info[0]['savename'],
                'pic' => $info[0]['savename'],
                'size' => $info[0]['size'],
                'ext' => $info[0]['extension'],
                'size' => $info[0],
                'path' => $path,
                'label' => $result
            );
            echo json_encode($arr);
        }
    }
}

?>