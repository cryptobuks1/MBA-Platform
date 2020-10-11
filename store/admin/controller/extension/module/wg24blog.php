<?php
class ControllerExtensionModuleWg24Blog extends Controller {
	private $error = array();
        public function index() {
		$this->load->language('extension/module/wg24blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/wg24blog');
                $res = $this->db->query("SHOW TABLES LIKE '".DB_PREFIX."wg24blogcategory'");
                $query=$res->num_rows;
                if(!$query){
                    $this->dbcreatetable();
                     $this->dbdemodata();
                    
                }
		$this->getList();
	}

	public function addcategory() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24blog->addCategory($this->request->post);

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
                         

			$this->response->redirect($this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true));
		}
            
		$this->getCatForm();
	}
        
        
        public function addBlogpost() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateBpostForm()) {
			$this->model_design_wg24blog->addBlogpost($this->request->post);
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
                         

			$this->response->redirect($this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true));
		}
            
		$this->getBlogPostForm();
	}
         public function addBlogpostManage() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateBpostForm()) {
			$this->model_design_wg24blog->addBlogpost($this->request->post);
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
                         

		$this->response->redirect($this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true));
		}
            
		$this->getBlogPostManageList();
	}
        public function blogPostdelete() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blogpost_id) {
			$this->model_design_wg24blog->deleteBlogPost($blogpost_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

		 $this->response->redirect($this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}



	public function cateEdit() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24blog->editByCategory($this->request->get['blog_cat_id'], $this->request->post);
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

		$this->response->redirect($this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getCatForm();
	}
        public function blogPostEdit() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24blog->editByBlogPost($this->request->get['blogpost_img_id'], $this->request->post);
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

		$this->response->redirect($this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getBlogPostForm();
	}

	public function cateDelete() {
		$this->load->language('extension/module/wg24blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/wg24blog');
		if (isset($this->request->get['blog_cat_id']) && $this->validateDelete()) {
                    if(isset($this->request->get['blog_cat_id'])){
                        $cat_del_id=$this->request->get['blog_cat_id'];
                    $this->model_design_wg24blog->deleteCategory( $cat_del_id);
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
			$this->response->redirect($this->url->link('extension/module/wg24blog/addcategory', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
        public function dropmoduletable() {
		$this->load->language('extension/module/wg24blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24blog');

		if ($this->validateDelete()) {
                     $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24blogpost_img_cat`');
                     $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24blogpost_image_des`');
                     $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24blogpost_image`');
                       $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24blogcomment`');
                        $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24blogcate_desc`');
                        $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24blogcategory`');
                 
                
                 
                   
                    

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

			$this->response->redirect($this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
        

	protected function getList() {
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
			'href' => $this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['addcategory'] = $this->url->link('extension/module/wg24blog/addcategory', 'token=' . $this->session->data['token'] . $url, true);
                $data['addBlogpost'] = $this->url->link('extension/module/wg24blog/addBlogpost', 'token=' . $this->session->data['token'] . $url, true);
                 $data['manageBlogpost'] = $this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . $url, true);
                
		$data['delete'] = $this->url->link('extension/module/wg24blog/delete', 'token=' . $this->session->data['token'] . $url, true);
                $data['reset'] = $this->url->link('extension/module/wg24blog/dropmoduletable', 'token=' . $this->session->data['token'] . $url, true);
                $data['cancel'] = $this->url->link('extension/extension','token=' . $this->session->data['token'] . '&type=module' . $url, true);
    

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
                $data['text_categorymodule'] = $this->language->get('text_categorymodule');
                $data['text_Blogpost'] = $this->language->get('text_Blogpost');
                $data['text_ManageBlogpost'] = $this->language->get('text_ManageBlogpost');
                $data['text_bloghomeconfigure'] = $this->language->get('text_bloghomeconfigure');
                

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
                $data['button_cancel'] = $this->language->get('button_cancel');
                  $data['button_reset'] = $this->language->get('button_reset');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wg24blogmanager', $data));
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
			'href' => $this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['blog_cat_id'])) {
			$data['action'] = $this->url->link('extension/module/wg24blog/addcategory', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/wg24blog/cateEdit', 'token=' . $this->session->data['token'] . '&blog_cat_id=' . $this->request->get['blog_cat_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true);
		
                $data['allparrentcate']= $this->model_design_wg24blog->getAllCategory();
                
                $data['showcat'] = array();
		$results = $this->model_design_wg24blog->getAllCategory();;

		foreach ($results as $result) {
			$data['showcat'][] = array(
				'title' => $result['title'],
				'cateEdit'      => $this->url->link('extension/module/wg24blog/cateEdit', 'token=' . $this->session->data['token'] . '&blog_cat_id=' . $result['blog_cat_id'] . $url, true),
                                'cateDelete'      => $this->url->link('extension/module/wg24blog/cateDelete', 'token=' . $this->session->data['token'] . '&blog_cat_id=' . $result['blog_cat_id'] . $url, true)
			);
		}
		$data['token'] = $this->session->data['token'];
                

		if (isset($this->request->get['blog_cat_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$cat_info = $this->model_design_wg24blog->getByCategory($this->request->get['blog_cat_id']);
		}
                

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->get['blog_cat_id'])) {
			$cat_info = $this->model_design_wg24blog->getByCategory($this->request->get['blog_cat_id']);
		} else {
			$cat_info = array();
                         $data['thumb']=$this->model_tool_image->resize('no_image.png', 100, 100);
		}
		foreach ($cat_info as $cat_info) {
			if (is_file(DIR_IMAGE . $cat_info['catpic'])) {
				$image = $cat_info['catpic'];
				$thumb = $cat_info['catpic'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}
                    if (isset($this->request->get['blog_cat_id'])) {
                            $data['module_description']=$cat_info['module_description'];
                            $data['blog_cat_id']=$cat_info['blog_cat_id'];        
                            $data['catpic']=$image;
                             $data['thumb']=$this->model_tool_image->resize($thumb, 100, 100);
                              $data['mtitle']=$cat_info['mtitle'];
                               $data['mkeyword']=$cat_info['mkeyword'];
                                $data['mdesc']=$cat_info['mdesc'];
                                 $data['status']=$cat_info['status'];
                            
                    }       
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wg24blogcategory', $data));
	}
        
        
        protected function getBlogPostForm() {
		$data['heading_title'] = $this->language->get('heading_title');
                $data['text_form'] = !isset($this->request->get['blog_cat_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
               $data['entry_content'] = $this->language->get('entry_content');
               $data['entry_tags'] = $this->language->get('entry_tags');
              $data['entry_videocontent'] = $this->language->get('entry_videocontent');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

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
                if (isset($this->error['module_metatitle'])) {
			$data['error_module_metatile'] = $this->error['module_metatitle'];
		} else {
			$data['error_module_metatile'] = array();
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
			'href' => $this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['blogpost_img_id'])) {
			$data['action'] = $this->url->link('extension/module/wg24blog/addBlogpost', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/wg24blog/blogPostEdit', 'token=' . $this->session->data['token'] . '&blogpost_img_id=' . $this->request->get['blogpost_img_id'] . $url, true);
		}
		$data['cancel'] = $this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true);
                $data['allparrentcate']= $this->model_design_wg24blog->getAllCategory();
               $this->load->model('tool/image');
               $this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['token'] = $this->session->data['token'];
                
                if (isset($this->request->get['blogpost_img_id'])) {
			$blog_info = $this->model_design_wg24blog->getByBlogPost($this->request->get['blogpost_img_id']);;
                        
		} else {
			$blog_info = array();
                        $data['thumb']=$this->model_tool_image->resize('no_image.png', 100, 100);
                        $data['showcat']='';  
		}
                $data['post_categories'] = array();
		foreach ($blog_info as $post_info) {
			if (is_file(DIR_IMAGE . $post_info['image'])) {
				$image = $post_info['image'];
				$thumb = $post_info['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}
                     foreach ($post_info['blogcate_id'] as $cat_info) {
                       $category_info = $this->model_design_wg24blog->getByCategory($cat_info['blogcate_id']);
                       
                        foreach ($category_info as $cat_infor) {
                            if ($category_info) {
				$data['post_categories'][] = array(
					'blog_cat_id' => $cat_infor['blog_cat_id'],
					'title' =>$cat_infor['module_description'][(int)$this->config->get('config_language_id')]['title']
				);
			} 
                            
                        }
                      }   
                        
                    if (isset($this->request->get['blogpost_img_id'])) {
                            $data['module_description']=$post_info['module_description'];
                            $data['blogpost_img_id']=$post_info['blogpost_img_id'];        
                            $data['image']=$image;
                            $data['thumb']=$this->model_tool_image->resize($thumb, 100, 100);        
                            $data['tags']=$post_info['tags'];
                           $data['video']=$post_info['video'];
                           $data['status']=$post_info['status'];
     
                    }       
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wg24blogpost', $data));
                
                
	}
        
         protected function getBlogPostManageList() {
             if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.title';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

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
			'href' => $this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/module/wg24blog/addBlogpost', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/wg24blog/blogPostdelete', 'token=' . $this->session->data['token'] . $url, true);
                $data['cancel'] = $this->url->link('extension/module/wg24blog', 'token=' . $this->session->data['token'] . $url, true);

		$data['BlogPost'] = array();
		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$product_total = $this->model_design_wg24blog->getTotalBlogPost($filter_data);

		$results = $this->model_design_wg24blog->getBlogPost($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			$data['BlogPost'][] = array(
				'blogpost_img_id' => $result['blogpost_img_id'],
				'image'      => $image,
				'title'       => $result['title'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('extension/module/wg24blog/addBlogpost', 'token=' . $this->session->data['token'] . '&blogpost_img_id=' . $result['blogpost_img_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
                   $data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . '&sort=pd.title' . $url, true);
		$data['sort_status'] = $this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/wg24blog/addBlogpostManage', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/module/wg24blogpost_list', $data));
             
             
	}
        
        
        

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24blog')) {
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
        protected function validateBpostForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['module_description'])) {
				foreach ($this->request->post['module_description'] as $language_id => $cate_description) {
					if ((utf8_strlen($cate_description['title']) < 2) || (utf8_strlen($cate_description['title']) > 64)) {
						$this->error['module_title'][$language_id] = $this->language->get('error_title');
					}
                                        if ((utf8_strlen($cate_description['metatitle']) < 2) || (utf8_strlen($cate_description['metatitle']) > 64)) {
						$this->error['module_metatitle'][$language_id] = $this->language->get('error_title');
					}
                                        
				}
                               
			
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
        
        
	public function autocomplete() {
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('design/wg24blog');
			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'title',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_design_wg24blog->getCategoriesAutocomplete($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'blog_cat_id' => $result['blog_cat_id'],
					'title'        => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['title'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
        public function autocompleteBolg() {
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('design/wg24blog');
			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'title',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_design_wg24blog->getBlogAutocomplete($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'blogpost_img_id' => $result['blogpost_img_id'],
					'title'        => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['title'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
        
        
   public function  dbcreatetable(){  
   

//-- Table structure for table `oc_wg24blogcategory`
 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24blogcategory` (
`blog_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `catparrent` int(11) NOT NULL,
  `catpic` varchar(250) NOT NULL,
  `mtitle` varchar(100) NOT NULL,
  `mkeyword` varchar(100) NOT NULL,
  `mdesc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blog_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;
');


//-- Table structure for table `oc_wg24blogcate_desc`


 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24blogcate_desc` (
`cate_des_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_cat_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`cate_des_id`),
  FOREIGN KEY (`blog_cat_id`) REFERENCES `' . DB_PREFIX . 'wg24blogcategory` (`blog_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;');

 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24blogcomment` (
`comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `parrent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_pic` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL,
  `comment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;');

//-- Table structure for table `oc_wg24blogpost_image`


 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24blogpost_image` (
`blogpost_img_id` int(11) NOT NULL AUTO_INCREMENT,
  `tags` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `video` varchar(400) NOT NULL,
  `store` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `postadmin` varchar(250) NOT NULL,
  `totalcomment` int(250) NOT NULL,
  `adddate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blogpost_img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;');


 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24blogpost_image_des` (
`blogpost_imgdes_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `contents` text NOT NULL,
  `metatitle` varchar(250) NOT NULL,
  `metakeyword` varchar(250) NOT NULL,
  `metadesc` varchar(250) NOT NULL,
  `blogpost_img_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`blogpost_imgdes_id`),
  FOREIGN KEY (`blogpost_img_id`) REFERENCES `' . DB_PREFIX . 'wg24blogpost_image` (`blogpost_img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;');


//-- Table structure for table `oc_wg24blogpost_img_cat`


 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24blogpost_img_cat` (
`blogpost_img_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `blogpost_img_id` int(11) NOT NULL,
  `blogcate_id` int(11) NOT NULL,
    PRIMARY KEY (`blogpost_img_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;');


 return $res;     
    }
  public function  dbdemodata(){
      
//-- Dumping data for table `oc_wg24blogcategory`


 $this->db->query("INSERT INTO `" . DB_PREFIX . "wg24blogcategory` (`blog_cat_id`, `catparrent`, `catpic`, `mtitle`, `mkeyword`, `mdesc`, `status`, `datetime`) VALUES
(53, 0, 'catalog/demo/canon_eos_5d_1.jpg', 'OpenCart', 'OpenCart', 'OpenCart', 1, '2016-07-21 22:42:23'),
(54, 0, 'catalog/demo/canon_eos_5d_2.jpg', 'PSD', 'PSD', 'PSD', 1, '2016-07-21 22:43:02'),
(55, 0, 'catalog/demo/canon_eos_5d_1.jpg', 'Ecommece', 'Ecommece', 'Ecommece', 1, '2016-07-21 22:44:54'),
(56, 0, 'catalog/demo/canon_eos_5d_2.jpg', 'HTML', 'HTML', 'HTML', 1, '2016-07-21 22:46:02'),
(57, 0, 'catalog/demo/canon_eos_5d_1.jpg', 'WordPress', 'WordPress', 'WordPress', 1, '2016-08-28 01:45:49'),
(58, 0, 'catalog/demo/canon_eos_5d_1.jpg', 'Magento', 'Magento', 'Magento', 1, '2016-08-28 01:49:55'),
(59, 0, 'catalog/demo/compaq_presario.jpg', 'PrestaShop', 'PrestaShop', 'PrestaShop', 1, '2016-08-28 01:52:58');");

//-- Dumping data for table `oc_wg24blogcate_desc`


 $this->load->model('localisation/language'); 
$languages=$this->model_localisation_language->getLanguages();
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24blogcate_desc` (`blog_cat_id`, `lang_id`, `title`, `description`) VALUES
(53,'".$language['language_id']."', 'OpenCart', '&lt;p&gt;OpenCart&lt;br&gt;&lt;/p&gt;'),
(54,'".$language['language_id']."', 'PSD', '&lt;p&gt;PSD&lt;br&gt;&lt;/p&gt;'),
(55,'".$language['language_id']."', 'Ecommece', '&lt;p&gt;Ecommece&lt;br&gt;&lt;/p&gt;'),
(56,'".$language['language_id']."', 'HTML', '&lt;p&gt;HTML&lt;br&gt;&lt;/p&gt;'),
(57,'".$language['language_id']."', 'WordPress', '&lt;p&gt;WordPress&lt;br&gt;&lt;/p&gt;'),
(58,'".$language['language_id']."', 'Magento', '&lt;p&gt;Magento&lt;br&gt;&lt;/p&gt;'),
(59,'".$language['language_id']."', 'PrestaShop', '&lt;p&gt;PrestaShop&lt;br&gt;&lt;/p&gt;');
");
}


//-- --------------------------------------------------------


//-- Dumping data for table `oc_wg24blogpost_image`


 $res =$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24blogpost_image` (`blogpost_img_id`, `tags`, `image`, `video`, `store`, `status`, `postadmin`, `totalcomment`, `adddate`) VALUES
(6, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/4.jpg', '', 0, 1, 'admin', 0, '2016-07-23 02:26:07'),
(7, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/2.jpg', '', 0, 1, 'admin', 0, '2016-07-23 02:33:04'),
(8, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/3.jpg', '', 0, 1, 'admin', 0, '2016-07-23 02:35:03'),
(9, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/17.jpg', '', 0, 1, 'admin', 0, '2016-07-23 02:52:14'),
(10, 'Where does it come from?', 'catalog/24wgdemo/blog/5.jpg', '', 0, 1, 'admin', 0, '2016-07-23 23:17:16'),
(11, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/8.jpg', '', 0, 1, 'admin', 0, '2016-08-08 00:48:19'),
(12, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/7.jpg', '', 0, 1, 'admin', 0, '2016-08-29 23:56:40'),
(13, 'The Girl Racing Bicycle', 'catalog/24wgdemo/blog/3.jpg', '', 0, 1, 'admin', 0, '2016-08-29 23:57:43'),
(14, '', 'catalog/24wgdemo/blog/2.jpg', '', 0, 1, 'admin', 0, '2016-08-29 23:58:29');");

//-- --------------------------------------------------------
//-- Dumping data for table `oc_wg24blogpost_image_des`

foreach($languages as $language){
 $res =$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24blogpost_image_des` (`title`, `description`, `contents`, `metatitle`, `metakeyword`, `metadesc`, `blogpost_img_id`, `language_id`) VALUES
('Head of Guitar Close up Tuning Pegs', '&lt;p&gt;Lorem Ipsum has been the industry''s standard dummy text ever since the \r\n1500s, when an unknown printer took a galley of type scrambled it to ake\r\n sfsa type specimen book. It has survived not only five centuries, but \r\nalso the leap into electronic setting, Ipsum. Lorem Ipsum has been the \r\nindustry''s standard dummy stext ever since the 1500s, when an unknown.\r\n            Lorem Ipsum has been the industry''s standard dummy text ever\r\n since the 1500s, when an unknown printer took a galley of type \r\nscrambleake sfsa type specimen book. It has survived not only five \r\ncenturies, but also the leap into electronic setting, Ipsum. Lorem Ipsum\r\n has been the.&lt;br&gt;&lt;/p&gt;', '', 'Head of Guitar Close up Tuning Pegs', 'Head of Guitar Close up Tuning Pegs', 'Head of Guitar Close up Tuning Pegs', 6, '".$language['language_id']."'),
('The Girl Racing Bicycle', '&lt;p&gt;Lorem Ipsum has been the industry''s standard dummy text ever since the \r\n1500s, when an unknown printer took a galley of type scrambled it to ake\r\n sfsa type specimen book. It has survived not only five centuries, but \r\nalso the leap into electronic setting, Ipsum. Lorem Ipsum has been the \r\nindustry''s standard dummy stext ever since the 1500s, when an unknown.\r\n            Lorem Ipsum has been the industry''s standard dummy text ever\r\n since the 1500s, when an unknown printer took a galley of type \r\nscrambleake sfsa type specimen book. It has survived not only five \r\ncenturies, but also the leap into electronic setting, Ipsum. Lorem Ipsum\r\n has been the.&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;&lt;a&gt;The Girl Racing  Bicycle&lt;/a&gt;&lt;br&gt;&lt;/p&gt;', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 7, '".$language['language_id']."'),
('The Girl Racing Bicycle', '&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;h2 style=&quot;margin: 0px 0px 10px; padding: 0px; font-weight: 400; line-height: 24px; font-family: DauphinPlain; font-size: 24px; text-align: left; color: rgb(0, 0, 0); font-style: normal; font-variant: normal; letter-spacing: normal; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none; background-color: rgb(255, 255, 255);&quot;&gt;There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat&lt;span class=&quot;Apple-converted-space&quot;&gt; &lt;br&gt;&lt;/span&gt;&lt;/span&gt;&lt;/h2&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;&lt;a&gt;The Girl Racing  Bicycle&lt;/a&gt;&lt;br&gt;&lt;/p&gt;', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 8, '".$language['language_id']."'),
('The Girl Racing Bicycle', '&lt;p&gt;Lorem Ipsum has been the industry''s standard dummy text ever since the \r\n1500s, when an unknown printer took a galley of type scrambled it to ake\r\n sfsa type specimen book. It has survived not only five centuries, but \r\nalso the leap into electronic setting, Ipsum. Lorem Ipsum has been the \r\nindustry''s standard dummy stext ever since the 1500s, when an unknown.\r\n            Lorem Ipsum has been the industry''s standard dummy text ever\r\n since the 1500s, when an unknown printer took a galley of type \r\nscrambleake sfsa type specimen book. It has survived not only five \r\ncenturies, but also the leap into electronic setting, Ipsum. Lorem Ipsum\r\n has been the.&lt;/p&gt;', '', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 9, '".$language['language_id']."'),
('The Girl Racing Bicycle', '&lt;p&gt;sfsafasdf sdafasdf sad&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;&lt;a&gt;The Girl Racing  Bicycle&lt;/a&gt;&lt;br&gt;&lt;/p&gt;', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 10, '".$language['language_id']."'),
('The Girl Racing Bicycle', '', '', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 'The Girl Racing Bicycle', 11, '".$language['language_id']."'),
('Head of Guitar Close up Tuning Pegs', '&lt;p&gt;Lorem Ipsum has been the industry''s standard dummy text ever since the \r\n1500s, when an unknown printer took a galley of type scrambled it to ake\r\n sfsa type specimen book. It has survived not only five centuries, but \r\nalso the leap into electronic setting, Ipsum. Lorem Ipsum has been the \r\nindustry''s standard dummy stext ever since the 1500s, when an unknown.\r\n            Lorem Ipsum has been the industry''s standard dummy text ever\r\n since the 1500s, when an unknown printer took a galley of type \r\nscrambleake sfsa type specimen book. It has survived not only five \r\ncenturies, but also the leap into electronic setting, Ipsum. Lorem Ipsum\r\n has been the.&lt;/p&gt;', '', 'Head of Guitar Close up Tuning Pegs', 'Head of Guitar Close up Tuning Pegs', 'Head of Guitar Close up Tuning Pegs', 12, '".$language['language_id']."'),
('The Girl Racing Bicycle', '', '', 'The Girl Racing Bicycle', '', '', 13, '".$language['language_id']."'),
('The Girl Racing Bicycle', '', '', 'The Girl Racing Bicycle', '', '', 14, '".$language['language_id']."');");
}
//-- --------------------------------------------------------
//-- Dumping data for table `oc_wg24blogpost_img_cat`


 $res =$this->db->query('INSERT INTO `'. DB_PREFIX . 'wg24blogpost_img_cat` (`blogpost_img_cat_id`, `blogpost_img_id`, `blogcate_id`) VALUES
(69, 11, 58),
(70, 11, 56),
(71, 11, 59),
(72, 11, 55),
(73, 11, 57),
(79, 9, 55),
(80, 9, 56),
(81, 9, 58),
(82, 9, 53),
(83, 9, 59),
(84, 7, 53),
(85, 7, 54),
(86, 7, 55),
(87, 8, 53),
(88, 8, 54),
(89, 8, 55),
(90, 10, 56),
(91, 10, 58),
(92, 10, 53),
(93, 10, 59),
(94, 10, 55),
(95, 12, 55),
(96, 12, 58),
(97, 12, 53),
(98, 12, 59),
(113, 6, 53),
(114, 6, 54),
(115, 6, 55),
(116, 6, 56),
(122, 14, 55),
(123, 14, 56),
(124, 14, 58),
(125, 14, 53),
(126, 14, 59),
(132, 13, 55),
(133, 13, 56),
(134, 13, 58),
(135, 13, 53),
(136, 13, 59);');
     
     }
        
      
}