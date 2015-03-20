<?php
/**
*@时间:20150316
*@功能:显示首页
*/
class IndexAction extends Action {
	//首页内容
	public function index(){
            M('Sport')->slect();
		$this->display();
	}
}