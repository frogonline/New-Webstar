<?php

class Product extends AppModel {

	

	public $name = 'Product'; 

	

	var $validate = array(

		'product_name' => array(

			'product_name_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		

		

		'product_categoryid' => array(

			'product_categoryid_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		'product_taxclass' => array(

			'product_taxclass_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		'product_status' => array(

			'product_status_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		'product_price' => array(

			'product_price_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		'product_discount' => array(

			'product_discount_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		'product_quantity' => array(

			'product_quantity_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),
		
		/*'product_weight' => array(

			'product_weight_not_empty' => array(

				'rule' => 'Empty',

				'message' => 'This field is not required'

			)

		),*/

		
		'meta_title' => array(

			'meta_title_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		),

		

	

	


		/* 'product_image' => array(

			'product_image_not_empty' => array(

				'rule' => 'notEmpty',

				'message' => 'This field is required'

			)

		) */

	);

	



}



?>