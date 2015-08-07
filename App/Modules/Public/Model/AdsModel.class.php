<?php

	class AdsModel{
	
		
		/**
		*@功能:查询广告类型
		*/
		
		public function adstype($id){
			
			$id = (int)($id);
			$data['ID'] = $id;
			$ads = M('m_ads')->field('adstype')->where($data)->find();
			return $ads;
		}
		
		/**
		*@功能:查询广告
		*/
		
		public function ads_list($id){
			$model = New model();
			$ads = $model->table('db_advertise ads,dz_ad_type type')
						 ->field('ads.id,ads.name,ads.stoptime,ads.img1,ads.img2,ads.link1,ads.type,ads.status,ads.station2')
						 ->where("ads.type=type.id AND ads.station2=$id and ads.status=1")
						 ->order('ads.sort ASC')
						 ->query('select %FIELD% from %TABLE% %WHERE% %ORDER%',true);
			return $ads;
		}
		
	}