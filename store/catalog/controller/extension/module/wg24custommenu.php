<?php
class ControllerExtensionModuleWg24Custommenu extends Controller {
	public function index() {
		$this->load->model('extension/module/wg24custommenu');
                 /* left column all post category  */
                $data['blogcategorys'] = array();
               $blogcategorys= $this->model_extension_module_wg24custommenu->getAllCategory(0);
               if(isset($blogcategorys)){
               foreach ($blogcategorys as $blogcategory) {
				// Level 2
				$blogcategory_child = array();
				$blog_children = $this->model_extension_module_wg24custommenu->getAllCategory($blogcategory['blog_cat_id']);
                           
				foreach ($blog_children as $child) {
					$blogcategory_child[] = array(
                                             'title' => $child['title'],
                                            'href'     =>$child['url'],
					);          
				}
				// Level 1
				$data['blogcategorys'][] = array(
                                            'title' => $blogcategory['title'],
                                            'href'     => $blogcategory['url'],
                                            'child'=>$blogcategory_child
                                        );
                                   
		}
                
                return $this->load->view('extension/module/wg24custommenu', $data);
               }
	
	}
        
        
}
