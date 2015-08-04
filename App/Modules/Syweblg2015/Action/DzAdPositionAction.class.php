<?php
/**
 * @时间:20150421
 * @功能:广告位置
 * @VIEW:dz_ad_posotion
 * @Author：liuliting
 */
import('ORG.Util.Page');

class DzAdPositionAction extends CommonAction
{
    public function index()
    {
        $map = $this->_search();
        $this->assign('map', $map);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $name = $this->getActionName();
        $model = D($name);
        if (!empty ($model)) {
            $order = "id asc,";
            $this->_list($model, $map, $order);
        }
        $this->display();
        return;
    }

    /*
     * @功能：返回查询条件
     * @时间：20150421
     */
    protected function _search()
    {
        $name = $this->getActionName();
        $model = D($name);
        $map = array();
        $temp = $model->getDbFields();
        foreach ($temp as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $_REQUEST [$val] = $_REQUEST[$val];
                $map[$val] = array('like', "%{$_REQUEST[$val]}%");
            }
        }
        $map['pid'] = array('eq', 0);
        return $map;
    }
    /*
    * @功能：新增赛事页面
    * @时间：20150421
   */
    function add(){
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from dz_sport');
        $this->assign('max_id', $max_id[0]['max_id']+1);
        $this->display();
    }

    /*
     * @功能：新增赛事方法
     * @时间：20150421
    */
    function insert()
    {
        $name = $this->getActionName();
        $model = D($name);
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
     * @功能：详细赛事新增页面
     * @时间：201504021
     */
    public function second()
    {
        $sid = $_GET['sid'];
        $list = D('DzSport')->where('pid=' . $sid . ' and sport_type=1')->select();
        $model = New Model();
        $max_id = $model->query('select max(id) max_id from dz_sport');
        $this->assign('list', $list);
        $this->assign('sid', $sid);
        $this->assign('max_id', $max_id[0]['max_id']);
        $this->display();
    }

    /*
     * @功能：详细赛事新增方法
     * @时间：201504021
     */
    public function insert_second()
    {
        $model = D('DzSport');
        $where['pid'] = $_GET['sid'];
        //删除之前的赛事,插入新内容
        $model->where($where)->delete();
        foreach ($_POST['id'] as $key => $val) {
            $dataNode['id'] = $val;
            $dataNode['name'] = $_POST['name'][$key];
            $dataNode['sport_show'] = $_POST['sport_show'][$key];
            $dataNode['image'] = $_POST['image'][$key];
            $dataNode['sport_type'] = 1;
            $dataNode['input_date'] = date('Y-m-d H:i:s');
            $dataNode['input_user'] = $_SESSION[C('USER_AUTH_KEY')];
            $dataNode['level'] = 2;
            $dataNode['pid'] = $_GET['sid'];
            $data[$key] = $dataNode;
        }
        $list = $model->addAll($data);
        if ($list !== false) {
            echo $this->ajax('1', "更新成功", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "更新失败", $rel, "", "closeCurrent");
        }
    }

    /*
     * @功能：删除大赛事,详细赛事关联删除
     * @时间：20150421
    */
    public function delAll()
    {
        $model = D('DzSport');
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        if (false !== $model->where($data)->delete()) {
            $where['pid'] = array('in', $_POST['ids']);
            $model->where($where)->delete();
            echo $this->ajax('1', "删除成功", $name, "", "");
        }
    }

    /*
     * @功能：修改赛事
     * @时间：20150421
     */
    function edit()
    {
        $name = $this->getActionName();
        $model = D($name);
        $vo = $model->find($_GET['id']);
        $this->assign('vo', $vo);
        $this->display();
    }
    /*
     * @功能：赛事图片
     * @时间：20150421
     */
    function lookup(){
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
        $path = 'sport';
        $upload = new UploadFile(); // 实例化上传类
        $upload->maxSize = 6291456; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->savePath = './Public/upload/'.$path.'/'; // 设置附件上传目录
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
                'savename' => $info[0]['savename'],
                'image[]' => $result,
                'pic' => $info[0]['savepath'],
                'size' => $info[0]['size'],
                'ext' => $info[0]['extension'],
                'path' => $path,
            );
         //   dump(array(true,$arr));
         //  return $arr;
            echo json_encode($arr);
        }
    }
}

?>