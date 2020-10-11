<?php
class ControllerExtensionModuleWg24Custommenu extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('extension/module/wg24custommenu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/wg24custommenu');
                $res = $this->db->query("SHOW TABLES LIKE '".DB_PREFIX."wg24custommenu'");
                $query=$res->num_rows;
                if(!$query){
                    $this->dbcreatetable();   
                }
                
                
                
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24custommenu->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
                          $this->load->model('tool/image');
                         $this->load->model('design/layout');
                        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
                         

			$this->response->redirect($this->url->link('extension/module/wg24custommenu', 'token=' . $this->session->data['token'] . $url, true));
		}
            
		$this->getCatForm();
	}
        
        
 

	public function cateEdit() {
		$this->load->language('extension/module/wg24custommenu');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24custommenu');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24custommenu->editByCategory($this->request->get['blog_cat_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

		$this->response->redirect($this->url->link('extension/module/wg24custommenu', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getCatForm();
	}
 
	public function cateDelete() {
		$this->load->language('extension/module/wg24custommenu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/wg24custommenu');
		if (isset($this->request->get['blog_cat_id']) && $this->validateDelete()) {
                    if(isset($this->request->get['blog_cat_id'])){
                        $cat_del_id=$this->request->get['blog_cat_id'];
                    $this->model_design_wg24custommenu->deleteCategory( $cat_del_id);
                    }
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('extension/module/wg24custommenu', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
        public function dropmoduletable() {
		$this->load->language('extension/module/wg24custommenu');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24custommenu');

		if ($this->validateDelete()) {
                     $this->db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.'wg24blogpost_img_cat`');
                     $this->db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.'wg24blogpost_image_des`');
                     $this->db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.'wg24blogpost_image`');
                       $this->db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.'wg24blogcomment`');
                        $this->db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.'wg24blogcate_desc`');
                        $this->db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.'wg24blogcategory`');
                 
                
                 
                   
                    

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/wg24custommenu', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
        

	protected function getCatForm() {
		$data['heading_title'] = $this->language->get('heading_title');
                $data['text_form'] = !isset($this->request->get['blog_cat_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
                $data['entry_description'] = $this->language->get('entry_description');
                $data['entry_desc'] = $this->language->get('entry_desc');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_banner_add'] = $this->language->get('button_banner_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['module_title'])) {
			$data['error_module_title'] = $this->error['module_title'];
		} else {
			$data['error_module_title'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/wg24custommenu', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['blog_cat_id'])) {
			$data['action'] = $this->url->link('extension/module/wg24custommenu', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/wg24custommenu/cateEdit', 'token=' . $this->session->data['token'] . '&blog_cat_id=' . $this->request->get['blog_cat_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
		
                $data['allparrentcate']= $this->model_design_wg24custommenu->getAllCategory();
                
                $data['showcat'] = array();
		$results = $this->model_design_wg24custommenu->getAllCategory();;

		foreach ($results as $result) {
			$data['showcat'][] = array(
				'title' => $result['title'],
				'cateEdit'      => $this->url->link('extension/module/wg24custommenu/cateEdit', 'token=' . $this->session->data['token'] . '&blog_cat_id=' . $result['blog_cat_id'] . $url, true),
                                'cateDelete'      => $this->url->link('extension/module/wg24custommenu/cateDelete', 'token=' . $this->session->data['token'] . '&blog_cat_id=' . $result['blog_cat_id'] . $url, true)
			);
		}
		$data['token'] = $this->session->data['token'];
                
                $this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->get['blog_cat_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$cat_info = $this->model_design_wg24custommenu->getByCategory($this->request->get['blog_cat_id']);
		
                

		
		foreach ($cat_info as $cat_info) {
                    if (isset($this->request->get['blog_cat_id'])) {
                            $data['module_description']=$cat_info['module_description'];
                            $data['blog_cat_id']=$cat_info['blog_cat_id'];     
                             $data['catparrent']=$cat_info['catparrent'];   
                                $data['url']=$cat_info['url'];
                                 $data['status']=$cat_info['status'];
                            
                    }       
		}
                }
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wg24custommenu', $data));
	}
        
     
        

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24custommenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['module_description'])) {
				foreach ($this->request->post['module_description'] as $language_id => $cate_description) {
					if ((utf8_strlen($cate_description['title']) < 2) || (utf8_strlen($cate_description['title']) > 64)) {
						$this->error['module_title'][$language_id] = $this->language->get('error_title');
					}
				}
			
		}

		return !$this->error;
	}
  
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24custommenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
        

        
   public function  dbcreatetable(){  
   

//-- Table structure for table `oc_wg24blogcategory`
 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24custommenu` (
`blog_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `catparrent` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blog_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;
');


//-- Table structure for table `oc_wg24blogcate_desc`


 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24custommenu_desc` (
`cate_des_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_cat_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  PRIMARY KEY (`cate_des_id`),
  FOREIGN KEY (`blog_cat_id`) REFERENCES `' . DB_PREFIX . 'wg24custommenu` (`blog_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;');

 return $res;     
    }

        
      
}