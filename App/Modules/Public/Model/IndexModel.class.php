<?php

	/**
	*@Index Model function
	*@time 20150316
	*/
class IndexModel extends Model
{
    /*
     * @功能：网站顶部赛事
     * @时间：
     */
    public function sport_top()
    {
        $model = D('DzSport');
        $category = $model ->where('pid=0 and sport_type=1')->field('id,name')->order('id asc')->select();
            if (!empty($category)) {
                foreach ($category as $key => $val) {
                    $id = $val['id'];
                    $category [$key]['child'] = $model->where(array('pid' => $id))->select();
                }
            }

		return $category;
    }
    /*
     * @功能：查询区域
     * @时间：20150412
     */
    public function region()
    {
       return  D('DbRegion')->where('level=3')->select();

    }

}
?>