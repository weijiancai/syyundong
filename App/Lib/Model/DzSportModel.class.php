<?php

	/**
	*@DzSport Model function
	*@time 20150316
	*/
class DzSportModel extends Model
{
    /*
     * @功能：网站顶部赛事
     * @时间：20150316
     */
    public function sport_top()
    {
        $category = $this ->where('pid=0 and sport_type=1')->field('id,name')->order('id asc')->select();
            if (!empty($category)) {
                foreach ($category as $key => $val) {
                    $id = $val['id'];
                    $category [$key]['child'] = $this->where(array('pid' => $id))->select();
                }
            }

		return $category;
    }
}
?>