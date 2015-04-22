<?php

	/**
	*@Index Model function
	*@time 20150316
	*/
	
	class IndexModel extends Model{
        /*
         * 功能：比赛时间、开始时间
         * 时间：20150408
         * */
        public function game_time($date){
            if($date=='today'){
                $timeType =  array('like',date('Y-m-d').'%');
            }
            return $timeType;
        }
	
	}

?>