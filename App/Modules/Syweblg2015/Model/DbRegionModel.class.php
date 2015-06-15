<?php

class DbRegionModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'pid', 'level','sort', '_pk' => 'id', '_autoinc' => true
    );

}

?>
