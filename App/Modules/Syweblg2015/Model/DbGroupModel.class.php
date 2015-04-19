<?php
	class DbGroupModel extends CommonModel{
        protected $fields = array(
            'id', 'name', 'title', 'create_time', 'update_time','status','sort','show','_pk' => 'id', '_autoinc' => true
        );
	    protected $_auto = array(
 			array('name','htmlspecialchars', 3, 'function'),
			array('title','htmlspecialchars', 3, 'function'), 
			array('sort','htmlspecialchars', 3, 'function'), 
		);			
	}
?>
