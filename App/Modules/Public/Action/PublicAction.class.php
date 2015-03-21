<?php
	/**
	*@时间:20150320
	*@功能:公共页面
	*/
class PublicAction extends Action {
		/**
		*调用头部导航以及面包屑
		*/
		public function top(){
			dump('$4');
			$this->display();
		}
	
}