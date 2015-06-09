<?php

class DbDoyenHallModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'image','unit','description', 'input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
