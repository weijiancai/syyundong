<?php

class DbVenueModel extends CommonModel
{
    protected $fields = array(
        'id', 'name', 'sport_id', 'image','province','city','region','business','address', 'phone',
        'person_cost', 'input_user', 'input_Date',
        '_pk' => 'id', '_autoinc' => true
    );
}

?>
