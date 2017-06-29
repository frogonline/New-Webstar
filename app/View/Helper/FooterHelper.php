<?php
class FooterHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	
	public function footerBlock(){
		App::import('Model', 'FooterRow');
		$frows = new FooterRow();
		$frows->bindModel(
			array(
				'hasMany'=>array(
					'FooterColumn'=>array(
						'className'=>'FooterColumn',
						'foreignKey'=>'row_id',
						'order'=>array('FooterColumn.sort_order ASC')
					)
				)
			)
		);
		$footer = $frows->find('first');
		return $footer;
		
	}
	
	public function socialWidget(){
		App::import('Model', 'SocialWidget');
		$sw = new SocialWidget();
		
		$swArray = $sw->find('all', array(
				'conditions'=>array(
					'SocialWidget.isdel'=>0,
					'SocialWidget.status'=>'Y'
				),
				'order'=>array('SocialWidget.sort_order'=>'ASC')
			)
		);
		return $swArray;
	}
}
?>

