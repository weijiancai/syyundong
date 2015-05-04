<?php

class OpGameNewsModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id', 'title','sport_sid', 'content', 'input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
