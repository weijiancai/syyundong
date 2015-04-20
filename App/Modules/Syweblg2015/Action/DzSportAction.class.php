<?php
/*
 * 生活信息大类
 * @Author liuliting
 * */
import('ORG.Util.Page');

/*
 *  生活信息类别管理
*/

class DzSportAction extends CommonAction
{
    public function index()
    {
        parent::index();
    }

    /*
     *  新增页面
    */
    public function add()
    {
        $this->class1();
        $this->display();
    }

    public function add3()
    {
        $this->class1();
        $this->display();
    }

    /*
     * 新增一级分类
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
            echo $this->ajax('1', "新增成功！！！", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败！！！", $name, "", "closeCurrent");
        }
    }

    /*
     * 新增一级分类
    */
    function insert2()
    {
        $name = "Class1";
        $model = D('Class2');
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $list = $model->add();
        if ($list !== false) {
            echo $this->ajax('1', "新增成功！！！", $name, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "新增失败！！！", $name, "", "closeCurrent");
        }
    }

    /*
     *  新增二级分类页面
    */
    public function add2()
    {
        $Class1 = $_GET['cid'];
        $model = D('Class2');
        $list = $model->where('Class1=' . $Class1)->select();
        $this->assign('list', $list);
        $this->assign('Class1', $Class1);
        $this->display();
    }

    /*
     *  新增二级分类
    */
    public function insclass2()
    {
        $model = D('Class2');
        $where['Class1'] = $_GET['Class1'];
        $count = $model->where($where)->count('ID');
        $len = count($_POST['Class2Name']);
        if ($len > 0) {
            if ($count == $len) {
                //管理员进行了修改分类操作
                foreach ($_POST['Class2Name'] as $key => $val) {
                    $dataNode['ID'] = $_POST['ID'][$key];
                    $dataNode['Class2Name'] = $val;
                    $dataNode['Class2Sort'] = $_POST['Class2Sort'][$key];
                    $dataNode['state'] = $_POST['state'][$key];
                    $list = $model->save($dataNode);
                }
            } elseif ($count > $len) {
                //管理员进行了删除分类操作
                foreach ($_POST['Class2Name'] as $key => $val) {
                    $dataNode['ID'][$key] = $_POST['ID'][$key];
                }
                $map['ID'] = array('not in', $dataNode['ID']);
                $map['Class1'] = $_GET['Class1'];
                $list = $model->where($map)->delete();
            } else {
                //管理员进行了分类增加操作
                $model->where('Class1=' . $_GET['Class1'])->delete();
                foreach ($_POST['Class2Name'] as $key => $val) {
                    $dataNode['Class1'] = $_GET['Class1'];
                    $dataNode['Class2Name'] = $val;
                    $dataNode['Class2Sort'] = $_POST['Class2Sort'][$key];
                    $dataNode['state'] = $_POST['state'][$key];
                    $list = $model->add($dataNode);
                }
            }
        } else {
            //管理员进行了分类全部删除操作
            $list = $model->where('Class1=' . $_GET['Class1'])->delete();
        }
        if ($list !== false) {
            echo $this->ajax('1', "编辑成功！！", $rel, "", "closeCurrent");
        } else {
            echo $this->ajax('0', "编辑失败！！！", $rel, "", "closeCurrent");
        }
    }

    /*
     * 删除一级导航菜单，管理二级菜单一并删除
    */
    public function delete()
    {
        $name = $this->getActionName();
        $model = D($name);
        $class2 = D('Class2');
        if (!empty ($model)) {
            //	$pk = $model->getPk ();
            $id = $_REQUEST ['ID'];
            if (isset ($id)) {
                $condition['ID'] = $id;
                if (false !== $model->where($condition)->delete()) {
                    $class2->where('Class1 =' . $id)->delete();
                    echo $this->ajax('1', "删除成功！！！", $name, "", "");
                } else {
                    echo $this->ajax('0', "删除失败！！！", $name, "", "");
                }
            } else {
                $this->error('非法操作');
            }
        }
    }

    /*
     *  批量删除
    */
    public function delAll()
    {
        $name = $this->getActionName();
        $model = CM($name);
        $pk = $model->getPk();
        $data[$pk] = array('in', $_POST['ids']);
        if (false !== $model->where($data)->delete()) {
            $where['navpid'] = array('in', $_POST['ids']);
            $model->where($where)->delete();
            echo $this->ajax('1', "批量删除成功！！！", $name, "", "");
        }
    }

    /*
     *	一级导航编辑页面
     */
    function edit()
    {
        $name = $this->getActionName();
        $model = D($name);
        $id = $_GET['id'];
        $vo = $model->find($id);
        $this->assign('vo', $vo);
        $this->display();
    }

    /*
     *	状态禁用
     */
    public function forbid($temp)
    {
        if ('class1' == $_GET['temp']) {
            $name = "Class1";
            $model = M('Class1');
            $class1 = $model->where('ID=' . $_GET['ID'])->setField('State', 0);
            $model2 = M('Class2');
            $class2 = $model2->where('Class1=' . $_GET['ID'])->setField('State', 0);
        } else {
            $model2 = M('Class2');
            $class2 = $model2->where('ID=' . $_GET['ID'])->setField('State', 0);
        }
        if ($class2) {
            echo $this->ajax('1', "状态禁用成功", $name, "", "");
        } else {
            echo $this->ajax('0', "状态禁用失败", $name, "", "");
        }
    }

    /*
     *	状态恢复
     */
    public function resume()
    {
        if ('class1' == $_GET['temp']) {
            $name = "Class1";
            $model = M('Class1');
            $class1 = $model->where('ID=' . $_GET['ID'])->setField('State', 1);
            $model2 = M('Class2');
            $class2 = $model2->where('Class1=' . $_GET['ID'])->setField('State', 1);
        } else {
            $model2 = M('Class2');
            $class2 = $model2->where('ID=' . $_GET['ID'])->setField('State', 1);
        }
        if ($class2) {
            echo $this->ajax('1', "状态恢复成功", $name, "", "");
        } else {
            echo $this->ajax('0', "状态恢复失败", $name, "", "");
        }
    }

    /*
     *	一级导航
     */
    public function class1()
    {
        $model = M('Class1');
        $class1 = $model->select();
        $this->assign('class1', $class1);
    }
}

?>