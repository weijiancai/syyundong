<?php
	class DbAdvertiseModel extends CommonModel{
	    protected $fields = array(
            'id','name','station1','station2','type','link1','link2','img1','img2','stoptime','seo','status','sort','input_user','input_date','remark','chargeman','chargetel',
			'click','_pk' => 'id','_autoinc' => true
        );
	}
?>