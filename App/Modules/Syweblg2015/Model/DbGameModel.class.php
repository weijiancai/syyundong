<?php

class DbGameModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'sport_id','sport_sid', 'image', 'reg_begin_date', 'reg_end_date', 'start_date', 'end_date',
        'limit_count', 'cost', 'province', 'address', 'sponsor', 'phone', 'apply_name', 'apply_phone',
        'apply_email', 'description', 'game_declare', 'content', 'content', 'member_right', 'aout_route', 'about_cost',
        'about_trip', 'about_hotal', 'input_date', 'input_user', 'is_verify', 'verify_date',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
