<?php
	class DzSportModel extends CommonModel{
        protected $fields = array(
            'id', 'name', 'sport_type','level','pid','input_date','input_user','sport_show','_pk' => 'id', '_autoinc' => true 
        );
	}
?>
