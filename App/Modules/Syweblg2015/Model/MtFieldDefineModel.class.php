<?php

class MtFieldDefineModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'code', 'field_type', 'regex', 'tip','required','memo','category',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
