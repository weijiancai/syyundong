<?php

class DbUserModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'user_head', 'nick_name', 'password', 'gender', 'blood_type', 'birthday', 'company', 'certificate_type', 'certificate_num',
        'height', 'weight', 'mobile', 'email', 'postal_code', 'address', 'signature', 'interest', 'verify_code', 'input_date','status',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
