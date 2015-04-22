<?php
	class DzActivityVenueModel extends CommonModel{
        /*
        * 功能：活动、场馆类别
        * 时间：20150408
        * */
        public function getSportName($type){
            $list =D('DzSport')->where('sport_type='.$type)->getField('name',true);
            return implode(' | ',$list);
        }
	}
?>
