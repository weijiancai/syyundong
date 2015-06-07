<?php

class OpGameTopicModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id', 'user_id', 'content','laud_count','input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
