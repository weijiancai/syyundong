<?php

class DbSportAssociationModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'image','approval_time','member_count','activity_count','legal_person','mobile','address','description', 'input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
