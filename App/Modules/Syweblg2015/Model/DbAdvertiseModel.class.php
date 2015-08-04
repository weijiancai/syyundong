<?php
	class DbAdvertiseModel extends CommonModel{
	    protected $fields = array(
            'ID','tstation','adstypes','tname','clientmanger','clienttel','adsname','adslink','adslink1','adstype','adsimg','adsremark','activetime','adskey','adsstime','adsetime','puttime',
			'adsclick','alid','ashow','adspx','uip','uname','ustime','uetime','insite','seo','area','chargeman','chargetel','wtype1','wtype2','bigtype','adstime','company','ticket_number','_pk' => 'ID','_autoinc' => true
        );
	    protected $_auto = array(
 			array('adsname','htmlspecialchars', 3, 'function'),
			array('adsremark','htmlspecialchars', 3, 'function'),
			array('clientmanger','htmlspecialchars', 3, 'function'),
			array('clienttel','htmlspecialchars', 3, 'function'),
 			array('adslink','htmlspecialchars', 3, 'function'),
			array('adslink1','htmlspecialchars', 3, 'function'),
			array('insite','htmlspecialchars', 3, 'function'),
			array('seo','htmlspecialchars', 3, 'function'),
			array('adspx','htmlspecialchars', 3, 'function'),
			array('adsclick','htmlspecialchars', 3, 'function'),
			array('ustime','time',1,'function'),
			array('uetime','time',2,'function'),
			array('adslink','trim',3,'function'),
			array('adslink1','trim',3,'function'),
		);
	}
?>