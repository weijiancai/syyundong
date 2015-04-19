<?php
	import('ORG.Net.UploadFile');
	import('ORG.Util.Image');
class CommonAction extends Action {	 
	function _initialize() {
        import('ORG.Util.Cookie');
		// 用户权限检查
		if (C ( 'USER_AUTH_ON' ) && !in_array(MODULE_NAME,explode(',',C('NOT_AUTH_MODULE')))) {
            import('ORG.Util.RBAC');
		//	dump(RBAC::AccessDecision ());
			if (! RBAC::AccessDecision (GROUP_NAME)) {
				//检查认证识别号
				if (! $_SESSION [C ( 'USER_AUTH_KEY' )]) {
					if ($this->isAjax()){ // zhanghuihua@msn.com
						$this->ajaxReturn(true, "", 0);
					} else {
						//跳转到认证网关
						redirect ( PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
					}
				}
				// 没有权限 抛出错误
				if (C ( 'RBAC_ERROR_PAGE' )) {
					// 定义权限错误页面
					redirect ( C ( 'RBAC_ERROR_PAGE' ) );
				} else {
					if (C ( 'GUEST_AUTH_ON' )) {
						$this->assign ( 'jumpUrl', PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
					}
                    // 提示错误信息  
                    if(isset($_SESSION[C('USER_AUTH_KEY')])) {
                       /*  unset($_SESSION[C('USER_AUTH_KEY')]);  
                        unset($_SESSION);  
                        session_destroy();   */
                    } 
					// 提示错误信息
					$this->error ( L ( '_VALID_ACCESS_' ) );
				}
			}
		}
		
	}
/*      function __construct(){  
        parent::__construct();  
        $this->checkAdminSession(); 
    }  */
/*    public function checkAdminSession() {
        //設置超時为10分
        $nowtime = time();
        $s_time = $_SESSION['logintime'];
        if (($nowtime - $s_time) > 600) {
             unset($_SESSION['logintime']);
            $this->error('登录超超时，请重新登录', U('Public/login'));
        } else {
            $_SESSION['logintime'] = $nowtime;
        }
    } */
 
	//ajax赋值扩展
 	protected function ajaxAssign(&$result){
		$result['statusCode']  =  $result['status'];
		$result['navTabId']  =  $_REQUEST['navTabId'];
		$result['message']=$result['info'];
	} 
	public function index(){
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		$this->assign('map',$map);
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D($name);
		if (! empty ( $model )) {
		$order="";
		if(in_array("sort", $dbArray)){
			$order.="sort asc,";
		}
			$this->_list ($model,$map,$order);
		}
		$this->display ();
		return;
	}
	/**
     +----------------------------------------------------------
	 * 取得操作成功后要返回的URL地址
	 * 默认返回当前模块的默认操作
	 * 可以在action控制器中重载
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	function getReturnUrl() {
		return __URL__ . '?' . C ( 'VAR_MODULE' ) . '=' . MODULE_NAME . '&' . C ( 'VAR_ACTION' ) . '=' . C ( 'DEFAULT_ACTION' );
	}

	/**
     +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param string $name 数据对象名称
     +----------------------------------------------------------
	 * @return HashMap
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	protected function _search($name = '') {
		//生成查询条件
		if (empty ( $name )) {
			$name = $this->getActionName();
		}
        $name = $this->getActionName();
		$model = D($name);
		$map = array ();
		$temp = $model->getDbFields ();
		foreach ( $temp as $key => $val ) {
			if (isset ( $_REQUEST [$val] ) && $_REQUEST [$val] != '') {
				$_REQUEST [$val] = $_REQUEST[$val];
				$map[$val] = array('like',"%{$_REQUEST[$val]}%");
			}
		}
		return $map; 
	}
	/**
     +----------------------------------------------------------
	 * 根据表单生成查询条件
	 * 进行列表过滤
     +----------------------------------------------------------
	 * @access protected
     +----------------------------------------------------------
	 * @param Model $model 数据对象
	 * @param HashMap $map 过滤条件
	 * @param string $sortBy 排序
	 * @param boolean $asc 是否正序
     +----------------------------------------------------------
	 * @return void
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 */
	protected function _list($model, $map, $order, $sortBy = '', $asc = true) {
		$pk=$model->getPk ();
		$order.=$pk." desc";
		$dbArray=$model->getDbFields ();
		unset($dbArray['_autoinc']);			// _autoinc 表示主键是否自动增长类型
		unset($dbArray['_pk']);					//_pk 表示主键字段名称 
		//取得满足条件的记录数
		$count = $model->where ( $map )->count($pk);
		if ($count > 0) {
			import ( "ORG.Util.Page" );
			//创建分页对象
			if (! empty ( $_REQUEST ['listRows'] )){
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $count, $listRows );
			$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
			//分页查询数据
			 $voList = $model->relation(true)->where($map)->order($order)->limit($pageNum)->page($_REQUEST[C('VAR_PAGE')])->select();
			//分页跳转的时候保证查询条件
			foreach ( $map as $key => $val ) {
				if (! is_array ( $val )) {
					$p->parameter .= "$key=" . urlencode ( $val ) . "&";
				}
			}
			//分页显示
			$page = $p->show ();
			//模板赋值显示
			$this->assign ( 'list', $voList );
			$this->assign ( 'sort', $sort );
			$this->assign ( 'order', $order );
			$this->assign ( 'sortImg', $sortImg );
			$this->assign ( 'sortType', $sortAlt );
			$this->assign ( "page", $page );
			
		}
		//dump($count);
		$this->assign ( 'totalCount', $count );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		Cookie::set ( '_currentUrl_', __SELF__ );
		return;
	}
	/*普通新增*/
	function insert() {
		$name=$this->getActionName();
		$model = D($name);
		if (false === $model->create()) {
			$this->error ( $model->getError () );
		}
		$list=$model->add ();
		if ($list!==false) { 
			echo $this->ajax('1', "新增成功！！！",$name,"","closeCurrent");
		} else {
			echo $this->ajax('0', "新增失败！！！",$name,"","closeCurrent");
		}
	}
	/*带图片新增*/
	public function sinsert($path) {
		$name=$this->getActionName();
		$model = D($name);
		$up=$this->upload($path);
		$con = $model->create();
		if (false === $con) {
			$this->error($model->getError ());
		}
		$model->ico = $up[1]; 
		$list = $model->add();		
		if ($list!==false) {
			echo $this->ajax("1","新增成功",$name,"","closeCurrent");
		} else {
			echo $this->ajax("0","新增失败",$name,"","closeCurrent");
		}
	} 
	/*记录ip新增*/
	function iinsert() {
		$name=$this->getActionName();
		$model = D($name);
		if (false === $model->create()) {
			$this->error ( $model->getError () );
		}
		$model->uip = $_SESSION['ip'];
		$model->uname = $_SESSION['account'];

		$list=$model->add ();
		if ($list!==false) { 
			echo $this->ajax('1', "新增成功！！！",$name,"","closeCurrent");
		} else {
			echo $this->ajax('0', "新增失败！！！",$name,"","closeCurrent");
		}
	}
	 public function add() {
		$this->display ();
	} 

	function read() {
		$this->edit();
	}
	function edit(){
		$name=$this->getActionName();
		$model = D($name );
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
		$this->assign ('vo',$vo);
		$this->display ();
	}
	/*普通修改*/
	function update(){
		$name=$this->getActionName();
		$model = D($name);
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		// 更新数据
		$list=$model->save();
		if (false!== $list) {
			echo $this->ajax('1', "编辑成功",$name,"","closeCurrent");
		} else {
			echo $this->ajax('0', "编辑失败",$name,"","closeCurrent");
		}
	} 
	/*记录ip修改*/
	function iupdate() {
		$name=$this->getActionName();
		$model = D($name);
		if (false === $model->create()) {
			$this->error ( $model->getError() );
		}
		$model->uip = $_SESSION['ip'];
		$model->uname = $_SESSION['account'];
		$list=$model->save ();
		if ($list!==false) { 
			echo $this->ajax('1', "编辑成功！！！",$name,"","closeCurrent");
		} else {
			echo $this->ajax('0', "编辑失败！！！",$name,"","closeCurrent");
		}
	}
	/*图片修改*/
	public function supdate($path) {
		$name=$this->getActionName();
		$model = D($name);
		$up=$this->upload($path);
		if (false === $model->create()) {
			$this->error ( $model->getError () );
		}
		if($up[0]){
			$model->ico = $up[1];  
		}else{
			$model->ico = $_POST['default']; 
		}
		$list=$model->save();
		if (false!==$list) {
			echo $this->ajax("1","编辑成功",$name,"","closeCurrent");
		} else {
			echo $this->ajax("0","编辑失败",$name,"","closeCurrent");
		}
	} 
	/**
     +----------------------------------------------------------
	 * 默认删除操作
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws ThinkExecption
     +----------------------------------------------------------
	 * 删除记录同时删除图片
     +----------------------------------------------------------
	 */
	public function delete() {
		//删除指定记录
		$name=$this->getActionName();
		$model = M ($name);
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				$list=$model->where ( $condition )->setField ( 'status', - 1 );
				if ($list!==false) {
					echo $this->ajax('1', "删除成功！！！",$name,"","");
				} else {
					echo $this->ajax('0', "删除失败！！！",$name,"","");
				}
			} else {
				$this->error ('非法操作' );
			}
		}
	}
	public function foreverdelete() {
		//删除指定记录
		$name=$this->getActionName();
		$model = D($name);
		if (! empty ( $model )) {
			
		$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
			$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				if (false !== $model->where ( $condition )->delete ()) {
					echo $this->ajax('1', "删除成功！！！",$name,"","");
				} else {
					echo $this->ajax('0', "删除失败！！！",$name,"","");
				} 
			} else {
				$this->error ( '非法操作' );
			} 
		}
	}
	/*删除广告后图片删除*/
	public function deleteimg() {
		$name=$this->getActionName();
		$model = D($name);
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('in', explode ( ',', $id ) ) );
				$arr=$model->find($id);
				$this->delpic($arr['ico']);
				if (false !== $model->where ( $condition )->delete ()) {
					echo $this->ajax('1', "删除成功！！！",$name,"","");
				} else {
					echo $this->ajax('0', "删除失败！！！",$name,"","");
				}
			} else {
				$this->error ( '非法操作' );
			}
		}
	}


	/**
	+----------------------------------------------------------
	* 添加删除操作  (多个删除)
	+----------------------------------------------------------
	* @access public
	+----------------------------------------------------------
	* @return string
	+----------------------------------------------------------
	* @throws ThinkExecption
	+----------------------------------------------------------
	*/

    public function delAll(){
    	$name=$this->getActionName();
		$model = CM ($name);
    	$pk=$model->getPk ();  
		$data[$pk]=array('in', $_POST['ids']);
		$model->where($data)->delete();
		echo $this->ajax('1',"批量删除成功",$name,"","");
	}

	public function clear() {
		//删除指定记录
		$name=$this->getActionName();
		$model = CM($name);
		if (! empty ( $model )) {
			if (false !== $model->where ( 'status=-1' )->delete ()) { // zhanghuihua@msn.com change status=1 to status=-1
				$this->assign ( "jumpUrl", $this->getReturnUrl () );
				$this->success ( L ( '_DELETE_SUCCESS_' ) );
			} else {
				$this->error ( L ( '_DELETE_FAIL_' ) );
			}
		}
		$this->forward ();
	}
	/**
	+----------------------------------------------------------
	* 添加审核操作  (多个审核)
	+----------------------------------------------------------
	* @access public
	+----------------------------------------------------------
	* @return string
	+----------------------------------------------------------
	* @throws ThinkExecption
	+----------------------------------------------------------
	*/

    public function statusAll(){
    	$name=$this->getActionName();
		$model = CM ($name);
    	$pk=$model->getPk ();  
		$data[$pk]=array('in', $_POST['ids']);
		$model->where($data)->setField('State',1);
		echo $this->ajax('1', "批量审核成功！！！",$name,"","");
	}
	/**
     +----------------------------------------------------------
	 * 默认禁用操作
	 *
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws FcsException
     +----------------------------------------------------------
	 */
	public function forbid() {
		$name=$this->getActionName();
		$model = CM($name);
		$pk = $model->getPk ();
		$id = $_REQUEST [$pk];
		$condition = array ($pk => array ('in', $id ) );
		$list=$model->forbid ( $condition );
		if ($list!==false) {
			echo $this->ajax('1',"状态禁用成功！！",$name,"","");
		} else {
			echo $this->ajax('0',"状态禁用失败！！",$name,"","");
		}
	}

	public function checkPass() {
		$name=$this->getActionName();
		$model = CM($name);
		$pk = $model->getPk ();
		$id = $_GET [$pk];
		$condition = array ($pk => array ('in', $id ) );
		if (false !== $model->checkPass( $condition )) {
			echo $this->ajax('1', "状态批准成功！！",$name,"","");
		} else {
			echo $this->ajax('0', "状态批准失败！！",$name,"","");
		}
	}

	public function recycle() {
		$name=$this->getActionName();
		$model = M($name);
		$pk = $model->getPk ();
		$id = $_GET [$pk];
		$condition = array ($pk => array ('in', $id ) );
		if (false !== $model->recycle ( $condition )) {
		echo $this->ajax('1', "状态还原成功！！",$name,"","");

		} else {
		echo $this->ajax('0', "状态还原失败！！",$name,"","");
		}
	}
	public function recycleBin() {
		$map = $this->_search ();
		$map ['status'] = - 1;
		$name=$this->getActionName();
		$model = CM($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ();
	}

	/**
     +----------------------------------------------------------
	 * 默认恢复操作
	 *
     +----------------------------------------------------------
	 * @access public
     +----------------------------------------------------------
	 * @return string
     +----------------------------------------------------------
	 * @throws FcsException
     +----------------------------------------------------------
	 */

	function resume() {
		//恢复指定记录
		$name=$this->getActionName();
		$model = D($name);
		$pk = $model->getPk ();
		$id = $_GET [$pk];		
		$condition = array ($pk => array ('in', $id ) );
		if (false !== $model->resume ( $condition )) {
		echo $this->ajax('1', "状态恢复成功！！",$name,"","");
		} else {
		echo $this->ajax('0', "状态恢复失败！！",$name,"","");
		}
	}

function saveSort() {
		$seqNoList = $_POST ['seqNoList'];
		if (! empty ( $seqNoList )) {
			//更新数据对象
		$name=$this->getActionName();
		$model = CM($name);
			$col = explode ( ',', $seqNoList );
			//启动事务
			$model->startTrans ();
			foreach ( $col as $val ) {
				$val = explode ( ':', $val );
				$model->id = $val [0];
				$model->sort = $val [1];
				$result = $model->save ();
				if (! $result) {
					break;
				}
			}
			//提交事务
			$model->commit ();
			if ($result!==false) {
				//采用普通方式跳转刷新页面
				$this->success ( '更新成功' );
			} else {
				$this->error ( $model->getError () );
			}
		}
	}
	/*类型返回*/
	function backtype($key){
		$model = D('ZjTypes');
		$where['lx'] =$key;
		$list=$model ->where($where)->select();
		return $list;
	}
	/*状态返回*/
	function backstate($key){
		$model = D('ZjboeeDatatict');
		$where['TYPE'] =$key;
		$list=$model ->where($where)->select();
		return $list;
	}
	/*
	 *@生活信息跳转页面
	 */
function jump($Class1) {
	switch ($Class1) {
		case 117 :
			$info = 'hedit';
			break;
		case 109 :
			$info = 'cedit';
			break;
		case 101 :
		case 102 :
		case 111 :
			$info = 'qedit';
			break;
		case 126 :
		case 107 :
		case 108 :
		case 110 :
		case 118 :
			$info = 'wedit';
			break;
		case 104 :
			$info = 'zedit';
			break;
		case 116 :
			$info = 'medit';
			break;
	}
	return $info;
}
function jumpt($Class1) {
	switch ($Class1) {
		case 117 :
			$info = 'hedit';
			break;
		case 109 :
			$info = 'cedit';
			break;
		case 126 :
		case 101 :
		case 102 :
		case 107 :
		case 108 :
		case 110 :
		case 111 :
		case 118 :
		case 116 :
			$info = 'qedit';
			break;
		case 104 :
			$info = 'zedit';
			break;
	}
	return $info;
}
		/*dwz返回提示信息*/
	public function ajax($status="",$message="",&$name,$rel="",$type="",$forwardUrl=""){
        $arr=array(
                "statusCode"=>$status, 
                "message"=>$message,
                "navTabId"=>$name, 
				"rel"=>$rel,
				"callbackType"=>$type,
                "forwardUrl"=>$forwardUrl,
        );
        return json_encode($arr);
    }
	/*单图片上传文件*/
	public function upload($path){
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','doc');// 设置附件上传类型
		$upload->savePath =  './Public/Upload/'.$path.'/';// 设置附件上传目录
		$upload->thumb = true;
/* 		$upload->thumbMaxWidth = '160';
		$upload->thumbMaxHeight = '160';  */
		$upload->autoSub=true;
		$upload->subType=date;
		if(!$upload->upload()) {// 上传错误提示错误信息
			if($upload->getErrorMsg() !="没有选择上传文件") {//不上传文件通过
				$e=$this->error($upload->getErrorMsg());
				return array(false,$e);}
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
				return array(true,$info[0]['savename']);
			}
		}
	/*多图片上传文件*/
	public function uploads($path){
		$upload = new UploadFile();// 实例化上传类
	//	$upload->maxSize  = 1.5*1000*1000 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','doc','swf');// 设置附件上传类型
		$upload->savePath =  './public/upload/'.$path.'/';;// 设置附件上传目录
		$upload->thumb = true;
/* 		$upload->thumbMaxWidth = '60';
		$upload->thumbMaxHeight = '60';  */
		$upload->autoSub=true;
		$upload->subType=date;
		if(!$upload->upload()) {// 上传错误提示错误信息
			if($upload->getErrorMsg() !="没有选择上传文件") {//不上传文件通过
				$e=$this->error($upload->getErrorMsg());
				return array(false,$e);}
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
				return array(true,$info);
			}
		}
	/*删除图片*/
	function delpic($picname,$val){
		$path='Public/Upload/'.$val.'/';
		unlink($path.$picname);	
	//删除原图
	//	@unlink($path.'icon_'.$picname);				//删除图标
	//	@unlink($path.'thumb_'.$picname);				//删除水印图片
	}
	
			/*会员操作记录*/
	public function recordLog($opera,$uid){
			$log = M('ZjBmsLog');
			$data['id'] = $this->guid();
			$data['LOGINNAME'] = $_SESSION['account'];
			$data['CREATETM'] = date('Y-m-d H:i:s');
			$data['LOGINIP'] =  get_client_ip();
			$data['REMARK'] =  $opera;					//操作
			$data['REMARK2'] =  $uid;					//被操作用户
			$log->data($data)->add();
		}	
		
	public  function guid(){
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			$uuid = chr(123)
					.substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12)
					.chr(125);
			return $uuid;
		}
	}
}
?>