<?php

class DbTourismModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'image','unit','content', 'province','city','input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
