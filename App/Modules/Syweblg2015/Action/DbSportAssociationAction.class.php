<?php

/**
 * @时间:20150422
 * @功能:体育协会
 * @VIEW:db_sort_association
 * @Author：liuliting
 */
class DbSportAssociationAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbSportAssociation');
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
        $model = D('DbSportAssociation');
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
     * @功能：新增体育协会
     * @时间：20150422
     */
    function add()
    {
        $this->display();
    }

    /*
     * @功能：体育协会新增方法
     * @时间：20150422
     */
    function insert()
    {
        $model = D('DbSportAssociation');
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
     * @功能：体育协会编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DbSportAssociation');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     * @功能：体育协会更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DbSportAssociation';
        $model = D('DbSportAssociation');
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
     * @功能：体育协会删除
     * @时间：20150422
     */
    public function delAll()
    {
        $model = D('DbSportAssociation');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1', "删除成功", $name, "", "");
    }
    /*
     * @功能：体育协会图片预览
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