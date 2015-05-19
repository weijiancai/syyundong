<?php

class OpJoinGameModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id','group_id', 'user_id', 'true_name', 'gender', 'mobile','em_contact','em_tel', 'certificate_num', 'verify_state',
        'input_date', 'verify_date','_pk' => 'id', '_autoinc' => true
    );
}

?>
