<?php

class DbSportAssociationModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'image', 'description', 'input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
