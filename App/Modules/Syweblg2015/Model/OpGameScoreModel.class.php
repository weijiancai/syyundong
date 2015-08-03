<?php

class OpGameScoreModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id','user_id','score', 'game_number','group_id','user_name','ranking','input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
