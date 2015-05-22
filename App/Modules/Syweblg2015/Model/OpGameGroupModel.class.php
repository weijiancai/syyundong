<?php

class OpGameGroupModel extends CommonModel
{
    protected $fields = array(
        'id', 'game_id', 'group_name','input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
