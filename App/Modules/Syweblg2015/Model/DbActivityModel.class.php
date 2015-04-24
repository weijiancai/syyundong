<?php

class DbActivityModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'sport_id', 'image', 'reg_begin_date', 'reg_end_date', 'start_date', 'end_date',
        'limit_count', 'join_need_info','is_need_verify','cost_type','cost', 'province','city','region','address', 'content',
        'input_date', 'input_user', 'interest_count',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
