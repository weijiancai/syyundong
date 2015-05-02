<?php

/**
 * @时间:20150422
 * @功能:会员管理
 * @VIEW:db_user
 * @Author：liuliting
 */
class DbUserAction extends CommonAction
{

    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $model = D('DbUser');
        if (!empty ($model)) {
            $order = "";
            $order .= "input_date desc,";
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
        $model = D('DbUser');
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
     * @功能：用户信息编辑页面
     * @时间：20150422
     */
    public function edit()
    {
        $model = D('DbUser');
        $vo = $model->where('id=' . $_GET['id'])->find();
        $this->assign('vo', $vo);
    //    $this->assign('dzSport', $this->DzSport());
        $this->display();
    }

    /*
     * @功能：用户信息更新
     * @时间：20150422
     */
    function update()
    {
        $name = 'DbUser';
        $model = D('DbUser');
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
     * @功能：用户删除
     * @时间：20150422
     */
    public function delAll(){
        $model = D('DbGame');
        $pk=$model->getPk ();
        $data[$pk]=array('in', $_POST['ids']);
        $model->where($data)->delete();
        echo $this->ajax('1',"删除成功",$name,"","");
    }
    /*
    * @功能：赛事其他详细信息
    * @时间：20150422
    */
    public function detail(){
        $id =$_GET['id'];
        $list =  D('DbGame')->where('id='.$id)->find();
        $this->assign('vo',$list);
        $this->display();
    }
    /*
    * @功能：赛事其他详细信息编辑页面
    * @时间：20150422
    */
    public function other_edit(){
        $id =$_GET['id'];
        $field =$_GET['field'];
        $list =  D('DbGame')->where('id='.$id)->find();
        $this->assign('vo',$list);
        $this->assign('field',$field);
        $this->display();
    }
    /*
    * @功能：赛事其他详细信息编辑页面
    * @时间：20150422
    */
    public function other_update(){
        $name="detail";
        $model = D('DbGame');
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
     * @功能：禁用赛事
     * @时间：20150422
     */
    public function forbid()
    {
        $name = "DbGame";
        $model = D('DbGame');
        $date['id'] = array('eq', $_GET['id']);
        $date['is_verify'] = 'F';
        $date['verify_date'] = date("Y-m-d H:i:s");
        $list = $model->save($date);
        if (false !== $list) {
            echo $this->ajax('1', "赛事禁止成功", $name, "", "");
        } else {
            echo $this->ajax('0', "赛事禁止失败", $name, "", "");
        }
    }

    /*
     * @功能：禁用恢复
     * @时间：20150422
     */
    public function resume()
    {
        $name = "DbGame";
        $model = D('DbGame');
        $date['id'] = array('eq', $_GET['id']);
        $date['is_verify'] = 'T';
        $date['verify_date'] = date("Y-m-d H:i:s");
        $list = $model->save($date);
        if (false !== $list) {
            echo $this->ajax('1', "赛事恢复成功", $name, "", "");
        } else {
            echo $this->ajax('0', "赛事恢复失败", $name, "", "");
        }
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

    /*
     *	推送信息
     */
    public function  pull()
    {
        $name = $this->getActionName();
        $model = M($name);
        $list = $model->where('ID=' . $_GET['ID'])->setField($_GET['item'], 0);
        if ($list) {
            echo $this->ajax('1', "滞留成功", $name, "", "");
        } else {
            echo $this->ajax('0', "滞留失败", $name, "", "");
        }
    }

    public function  push()
    {
        $name = $this->getActionName();
        $model = M($name);
        $list = $model->where('ID=' . $_GET['ID'])->setField($_GET['item'], 1);
        if ($list) {
            echo $this->ajax('1', "顶贴成功", $name, "", "");
        } else {
            echo $this->ajax('0', "顶贴失败", $name, "", "");
        }
    }
}

?>