<?php
	class DbNodeModel extends CommonModel{
        protected $fields = array(
            'id', 'name', 'link', 'title', 'status','remark','sort','pid','level','group_id','show','_pk' => 'id', '_autoinc' => true
        );
	    protected $_auto = array(
 			array('name','htmlspecialchars', 3, 'function'),
			array('link','htmlspecialchars', 3, 'function'), 
			array('title','htmlspecialchars', 3, 'function'), 
			array('remark','htmlspecialchars', 3, 'function'),
			array('sort','htmlspecialchars', 3, 'function'),			
		);		
	}
?>
