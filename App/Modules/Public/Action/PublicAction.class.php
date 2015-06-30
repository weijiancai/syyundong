<?php

/**
 *@时间:20150320
 *@功能:公共页面
 */
class PublicAction extends Action
{
    /*
    *调用头部导航以及面包屑
    */
    public function top()
    {
        $this->display();
    }
    /*
     * 功能：ajax上传图片
     * 时间：20150501
     */
    public function upimg()
    {
        import('ORG.Util.Image');
        import('ORG.Net.UploadFile');
        $path = $_POST['path'];
        $upload = new UploadFile(); // 实例化上传类
        $upload->maxSize = 6291456; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->savePath = './Public/Upload/' . $path . '/'; // 设置附件上传目录
        $upload->thumb = true;
        $upload->thumbPrefix = 'm_,s_';
        $upload->thumbMaxWidth = '800,150';
        $upload->thumbMaxHeight = '600,150';
        $upload->thumbType = 0;
        $upload->zipImages = true;
        $upload->autoSub = true;
        $upload->subType = date;
        $upload->thumbRemoveOrigin=true;
        if (!$upload->upload()) { // 上传错误提示错误信息
            if ($upload->getErrorMsg() != "没有选择上传文件") { //不上传文件通过
                $e = $this->error($upload->getErrorMsg());
                echo $e;
        }
        } else { // 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();

            //存储图片
        //    $date['local_url'] = '/Public/upload/' . $path . '/' . $info[0]['savename'];

            list($day,$name) = split ('[/]', $info[0]['savename']);
            $date['local_url'] = '/Public/Upload/' . $path . '/'.$day.'/m_' . $name;

            $date['size2_url'] = '/Public/Upload/' . $path . '/'.$day.'/s_' . $name;
            $result = D('DbImages')->add($date);
            //打水印
            $Image = new Image();
            foreach ($info as $value) {
                // $Image->water('./Public/Upload/' . $path.'/' . $value['savename'], './Public/images/default/water.png'); //打水印
                list($w_day,$w_name) = split ('[/]', $value['savename']);
                $Image->water('./Public/Upload/' . $path.  '/' . $w_day.'/m_' . $w_name, './Public/images/default/water.png');
            }
            $arr = array(
                'savename' => $info[0]['savename'],
                'name' => $info[0]['name'],
                'pic' => $info[0]['savepath'],
                'size' => $info[0]['size'],
                'ext' => $info[0]['extension'],
                'path' => $path,
                'label' => $result
            );
            echo json_encode($arr);
        }
    }

    /*
    * @时间: 20150415
    * @功能:评论回复
    */
    public function CommentReply()
    {
        $model = D('OpComment');
        $date['content'] = $_POST['content'];
        $date['replay_to'] = $_POST['replay_to'];
        $date['user_id'] = deCode(I('session.mark_id'));
        $date['source_id'] = $_POST['source_id'];
        $date['source_type'] = $_POST['source_type'];
        $date['input_date'] = date('Y-m-d H:i:s');
        $result = $model->add($date);
        if (false !== $result) {
            echo 1;
        } else {
            echo 0;
        }
    }
    /*
     * @功能：网站顶部赛事
     * @时间：
     */
    public function sport_top()
    {
        $model = D('DzSport');
        $category = $model ->where('pid=0 and sport_type=1')->field('id,name')->order('id asc')->select();
        if (!empty($category)) {
            foreach ($category as $key => $val) {
                $id = $val['id'];
                $category [$key]['child'] = $model->where(array('pid' => $id))->select();
            }
        }

        return $category;
    }
    /*
     * @功能：kindeditor 编辑器图片上传
     * @时间：20150621
     */
    public function kind_img(){
        import('ORG.Net.UploadFile');
        import('ORG.Util.Image');
        $upload = new UploadFile(); // 实例化上传类
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->savePath = './Public/Upload/attached/'; // 设置附件上传目录
        $upload->thumb = true;
        $upload->thumbPrefix = 'm_';
        $upload->thumbMaxWidth = '800';
        $upload->thumbMaxHeight = '600';
        $upload->thumbType = 0;
        $upload->zipImages = true;
        $upload->autoSub = true;
        $upload->subType = date;
        $upload->thumbRemoveOrigin=true;
        if (!$upload->upload()) { // 上传错误提示错误信息
            $data['error'] = 1;
            $data['message'] = $upload->getErrorMsg();
            $this->ajaxReturn($data, 'JSON');
        } else { // 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
            $Image = new Image();
            foreach ($info as $value) {
                // $Image->water('./Public/Upload/' . $path.'/' . $value['savename'], './Public/images/default/water.png'); //打水印
                list($w_day,$w_name) = split ('[/]', $value['savename']);
                $Image->water('./Public/Upload/attached/' . $w_day.'/m_' . $w_name, './Public/images/default/water.png');
            }
            //打水印
            /*$Image = new Image();
            $Image->water('./Public/Upload/attached/' . $info[0]['savename'], './Public/images/common/logo1.png'); //打水印*/
            list($day,$name) = split ('[/]', $info[0]['savename']);
            $info[0]['savename']=$day.'/m_' . $name;

            $url = '../../../Public/Upload/attached/' . $info[0]['savename'];
            $data['error'] = 0;
            $data['url'] = $url;
            $this->ajaxReturn($data, 'JSON');
        }
    }

}