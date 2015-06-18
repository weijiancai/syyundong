<?php

class OpGameNewsModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id', 'title', 'content', 'input_date', 'input_user','key',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
