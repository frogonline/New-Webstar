<?php
class SidebarsHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	public function sidebarOptions($id){
		App::import('Model', 'SidebarOption');
		$sidebarOpt = new SidebarOption();
		
		$data = $sidebarOpt->find('all',
			array(
				'conditions'=>array(
					'sidebar_id'=>$id
				),
				'order'=>('SidebarOption.sort_order ASC')
			)
		);
		
		return $data;
	}
	
	public function latestPosts() {
        App::import('Model', 'Page');
		$post = new Page();
		$posts = $post->find('all',
			array(
				'conditions'=>array('Page.type'=>'Post','Page.is_del'=>'0'),
				'order'=>array('Page.id DESC'),
				'limit'=>5,
				'offset'=>0
			)
		);
		
		return $posts;
    }
	
	public function postcategories() {
        App::import('Model', 'PostCategory');
		$postcat = new PostCategory();
		
		$postcat->bindModel(array(
			'hasMany' => array(
					'Page' => array(
						'className'    => 'Page',
						'foreignKey'   => 'categoryid',
						'conditions'   => array(
							'Page.is_active'=>'Y'
						),
						'fields'=>array('id')
					)
				)
			)
		);
		
		$cats = $postcat->find('all',
			array(
				'conditions'=>array('PostCategory.status'=>'Y'),
				'order'=>array('PostCategory.category_name ASC'),
			)
		);
		
		return $cats;
    }
	
	public function latestTags() {
        App::import('Model', 'PostTag');
		$tag = new PostTag();
		$tags = $tag->find('all',
			array(
				'conditions'=>array('PostTag.status'=>'Y','PostTag.isdel'=>'0'),
				'order'=>array('PostTag.id DESC'),
				'limit'=>10,
				'offset'=>0
			)
		);
		
		return $tags;
    }
	
	public function archive(){
		App::import('Model', 'Page');
		$post = new Page();
		
		$archive = $post->query("SELECT YEAR(created_date) AS yr, MONTH(created_date) AS mth, DATE_FORMAT(created_date,'%M %Y') AS display_date, COUNT(*),created_date FROM pages WHERE is_del ='0' AND created_date >= CURRENT_DATE - INTERVAL 1 YEAR GROUP BY yr,mth ORDER BY yr DESC, mth DESC");
		
		return $archive;
		
		
	} 
	
	private function buildarchive($start){
		App::import('Model', 'Page');
		$post = new Page();
		$month = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
		
		for($i=1; $i<=12; $i++){
			$data = $post->find('all',
				array(
					'conditions'=>array(
						'Page.created_date >='=>date('Y-m-d',strtotime('01-01-2015')),
						'Page.created_date <='=>date('Y-m-d',strtotime('31-12-2015')),
						'Page.type'=>'Post',
						'Page.is_del'=>'0',
					),
					'fields'=>array(
						'Page.id','Page.title','Page.created_date'
					)
				)
			);
		}
		return $data;
	}
	
	public function categoryMenu(){
		$categoryMenu = $this->create_menu();
		return $categoryMenu;
	}
	
	private function categoriesByParentId($id){
		App::import('Model', 'ProductCategory');
		$category = new ProductCategory();
		
		$categories = $category->find('all',array(
			'conditions'=>array('ProductCategory.parent_id'=>$id,
								'ProductCategory.category_status'=>'Y',
								'ProductCategory.is_del'=>0)
			)
		);
		return $categories;
	}
	
	private function create_menu($id=0){
		$str = '';
		$categories = $this->categoriesByParentId($id);
		
		if(count($categories) > 0){
			$str.=($id==0)?'<ul class="list-group margin-bottom-25 sidebar-menu">':'<ul class="dropdown-menu">';
			foreach($categories as $category){
				$subcategories = $this->categoriesByParentId($category['ProductCategory']['id']);
				$str.=(count($subcategories)==0)?'<li class="list-group-item clearfix">':'<li class="list-group-item clearfix dropdown">';
				if(count($subcategories)==0){
					$str.='<a href="'.SITE_URL.$category['ProductCategory']['categories_slug'].'"><i class"fa fa-angle-right"></i>'.$category['ProductCategory']['name'].'</a>';
				} else {
					$str.='<a href="'.SITE_URL.$category['ProductCategory']['categories_slug'].'">'.'<i class"fa fa-angle-right"></i>'.$category['ProductCategory']['name'].'<i class="fa fa-angle-down"></i></a>';
				}
				
				if(count($subcategories)==0){
					$str.='</li>';
				}
				else{
					$str.=$this->create_menu($category['ProductCategory']['id']);
				}
				
			}
			$str.='</ul>'; 
		}

		return $str;
	}
}
?>