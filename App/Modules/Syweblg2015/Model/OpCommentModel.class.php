<?php

class OpCommentModel extends CommonModel
{
    protected $fields = array(
        'id', 'source_id', 'user_id','replay_to','source_type','content','star_count','input_date',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
