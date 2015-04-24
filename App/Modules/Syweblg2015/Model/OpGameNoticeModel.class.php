<?php

class OpGameNoticeModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id', 'title', 'content', 'input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
