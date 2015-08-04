<?php

class DbTourismModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'image','content', 'province','city','region','input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
