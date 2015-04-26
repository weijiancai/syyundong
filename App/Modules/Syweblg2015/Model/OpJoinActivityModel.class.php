<?php

class OpJoinActivityModel extends CommonModel
{
    protected $fields = array(
        'id', 'activity_id', 'user_id', 'true_name', 'gender', 'mobile', 'certificate_num', 'verify_state',
        'input_date', 'verify_date','_pk' => 'id', '_autoinc' => true
    );
}

?>
