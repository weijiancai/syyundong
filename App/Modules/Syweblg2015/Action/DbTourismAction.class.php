<?php

/**
 * @时间:20150422
 * @功能:旅游管理
 * @VIEW:db_tourism
 * @Author：liuliting
 */
class DbTourismAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbTourism');
        if (!empty ($model)) {
            $order = "input_date desc,";
            $this->_list($model, $map, $order);
        }

        $this->display();
    }

    /*
     * @功能：查询条件返回
     * @时间：20150422
     */
    protected function _search()
    {
        $model = D('DbTourism');
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
     * @功能：新增旅游场地
     * @时间：20150422
     */
    function add()
    {
        $this->assign('province', $this->getProvince());
        $this->display();
    }

    /*
     * @功能：旅游场地新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('DbTourism');
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
     * @功能：旅游编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DbTourism');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        //活动城市
        $where['pid'] = $vo['province'];
        $city = D('DbRegion')->where($where)->select();
        $this->assign('city', $city);
        $this->assign('province', $this->getProvince());
        $this->display();
    }

    /*
     * @功能：旅游场地更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DbTourism';
        $model = D('DbTourism');
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
     * @功能：旅游场地删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('DbTourism');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }
    /*
     * @功能：旅游场地图片预览
     * @时间：20150422
     */
    public function show()
    {
        /*$id = $_GET['id'];
        $image = D('DbDoyenHall')->where('id='.$id)->getField('image');
        $local_url=D('DbImages')->where('id='.$image)->getField('local_url');
        $this->assign('local_url',$local_url);*/
        $this->assign('local_url',$_GET['img']);
        $this->display();
    }
    /*
     * @功能：旅游场地省份
     * @时间：20150422
     */
    public function getProvince(){
        return D('DbRegion')->field('id,name')->where('pid=0 and level=1')->select();
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
        $upload->thumbPrefix = 's_';
        $upload->thumbMaxWidth = '150';
        $upload->thumbMaxHeight = '150';
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
            $date['size2_url'] = '/Public/upload/' . $path . '/s_' . $info[0]['savename'];
            $result = D('DbImages')->add($date);
            //打水印
            /* $Image = new Image();
             foreach ($info as $value) {
                 $$value['key'] = $value['savename'];
                 $Image->water('./Public/Upload/game/' . $value['savename'], './Public/images/common/logo1.png'); //打水印
             }*/
            $arr = array(
                'savename' => $info[0]['savename'],
                'name' => $info[0]['name'],
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