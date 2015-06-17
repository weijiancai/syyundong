<?php

class OpRecommendModel extends CommonModel
{
    protected $fields = array(
        'id', 'gc_id', 'recommend_type', 'sort_num','category','input_date', 'input_user',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
