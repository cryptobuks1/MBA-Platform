<?php
class ControllerExtensionModuleWg24blog extends Controller {
	public function index() {
            
                 $save_value = array(
                        'wg24themeoptionpanel_home1blogtitletext_prallax',
                 'wg24themeoptionpanel_blogcommenttext_prallax',
                 'wg24themeoptionpanel_blogpostbttext_prallax',
                 'wg24themeoptionpanel_blogreadmoretext_prallax',
                  'wg24themeoptionpanel_homepage123_prallax'
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                    $blogtitle=$this->config->get('wg24themeoptionpanel_home1blogtitletext_prallax_'.$lang);
                  
                   
            
            
		$this->load->language('product/special');
		$this->load->model('extension/module/wg24blog');
		$this->load->model('tool/image');
                
                
                
                
 
              if (isset($this->request->get['search'])) {
                   $search = $this->request->get['search'];
		} else {
			$search = '';
		}
                if (isset($this->request->get['catepath'])) {
                   $catepath = $this->request->get['catepath'];
		} else {
			$catepath = '';
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

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}
                $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
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

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
            if (isset($this->request->get['catepath'])) {
           $category_info = $this->model_extension_module_wg24blog->getByCategory($catepath);
            $this->document->setTitle($category_info['mtitle']);
            $this->document->setDescription($category_info['mkeyword']);
            $this->document->setKeywords($category_info['mdesc']);
            $data['heading_title'] =  $category_info['title'];
            $data['breadcrumbs'][] = array(
			'text' => $category_info['title'],
			'href' => $this->url->link('extension/module/wg24blog', $url)
		);
           }else{
               
              if (isset($this->request->get['search'])) {  
            $this->document->setTitle($blogtitle.'-'.$this->request->get['search']);
            $data['heading_title'] = $blogtitle.'-'.$this->request->get['search'];
              }else{
                  $this->document->setTitle($blogtitle);
            $data['heading_title'] = $blogtitle; 
                  
              }
            
            
            $data['breadcrumbs'][] = array(
			'text' => $blogtitle,
			'href' => $this->url->link('extension/module/wg24blog', $url)
		);
           }
             if (isset($category_info['catpic'])) {
                    $data['thumb'] = $this->model_tool_image->resize($category_info['catpic'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
            } else {
                    $data['thumb'] = '';
            }
              if (isset($category_info['description'])) {
                    $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            } else {
                     $data['description'] = '';
            }

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['blogpost'] = array();
		$filter_data = array(
                        'filter_name'=>$search,
                        'filter_category_id'=>$catepath,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);

		$product_total = $this->model_extension_module_wg24blog->getTotalBlogPost($filter_data);

		$results = $this->model_extension_module_wg24blog->getBlogPost($filter_data);
               
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'],570,370);
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}
                        $time = new DateTime($result['adddate']);
                        $date = $time->format('n/j/Y');
			$data['blogpost'][] = array(
				'blogpost_img_id'  => $result['blogpost_img_id'],
                              'totalcomment'  => $result['totalcomment'],
				'thumb'       => $image,
                                'video'       => html_entity_decode($result['video'], ENT_QUOTES, 'UTF-8'),
				'title'        => $result['title'],
                                'postadmin'        => $result['postadmin'],
                                'adddate'        => $date,
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                            'href'        => $this->url->link('extension/module/wg24blog/details', 'blogpost_img_id=' . $result['blogpost_img_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('extension/module/wg24blog', 'sort=p.sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.title-ASC',
			'href'  => $this->url->link('extension/module/wg24blog', 'sort=pd.title&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.title-DESC',
			'href'  => $this->url->link('extension/module/wg24blog', 'sort=pd.title&order=DESC' . $url)
		);
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 2, 50, 75, 100));

		sort($limits);

		foreach($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('extension/module/wg24blog', $url . '&limit=' . $value)
			);
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
                 if (isset($this->request->get['catepath'])) {
			$url .= '&catepath=' . $this->request->get['catepath'];
		}
                  if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}
                

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('extension/module/wg24blog', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
		if ($page == 1) {
		    $this->document->addLink($this->url->link('extension/module/wg24blog', '', true), 'canonical');
		} elseif ($page == 2) {
		    $this->document->addLink($this->url->link('extension/module/wg24blog', '', true), 'prev');
		} else {
		    $this->document->addLink($this->url->link('extension/module/wg24blog', 'page='. ($page - 1), true), 'prev');
		}
		if ($limit && ceil($product_total / $limit) > $page) {
		    $this->document->addLink($this->url->link('extension/module/wg24blog', 'page='. ($page + 1), true), 'next');
		}
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$data['continue'] = $this->url->link('common/home');
                
                 /* left column all post category  */
                $data['blogcategorys'] = array();
               $blogcategorys= $this->model_extension_module_wg24blog->getAllCategory(0);
               foreach ($blogcategorys as $blogcategory) {
				// Level 2
				$blogcategory_child = array();
				$blog_children = $this->model_extension_module_wg24blog->getAllCategory($blogcategory['blog_cat_id']);
                           
				foreach ($blog_children as $child) {
					$blogcategory_child[] = array(
                                             'title' => $child['title'],
                                            'href'     => $this->url->link('extension/module/wg24blog', 'catepath=' . $child['blog_cat_id']),
					);          
				}
				// Level 1
				$data['blogcategorys'][] = array(
                                            'title' => $blogcategory['title'],
                                            'href'     => $this->url->link('extension/module/wg24blog', 'catepath=' . $blogcategory['blog_cat_id']),
                                            'child'=>$blogcategory_child
                                        );
                                   
		}
                /* latest post */
                  $data['latestposts'] = array();
               $latestposts= $this->model_extension_module_wg24blog->getLatestPost(3);
               foreach ($latestposts as $latestpost) {
                   	if ($latestpost['image']) {
				$postpic = $this->model_tool_image->resize($latestpost['image'],50,50);
			} else {
				$postpic = $this->model_tool_image->resize('placeholder.png',50,50);
			}
				$data['latestposts'][] = array(
                                           'title' => $latestpost['title'],
                                             'image' => $postpic,
                                             'totalcomment' => $latestpost['totalcomment'],
                                             'adddate' => $latestpost['adddate'],
                                            'href'  => $this->url->link('extension/module/wg24blog/details', 'blogpost_img_id=' . $latestpost['blogpost_img_id'])
                                        );
                                   
		}
                
                /** latest comment */
                $data['latestcomments'] = array();
               $latestcomments= $this->model_extension_module_wg24blog->getRecentBlogComment(3);
             
               foreach ($latestcomments as $latestcomment) {
				$data['latestcomments'][] = array(
                                           'title' => $latestcomment['title'],
                                             'name' => $latestcomment['name'],
                                             'image' => $latestcomment['user_pic'],
                                             'comment' => $latestcomment['comment'],
                                            'href'  => $this->url->link('extension/module/wg24blog/details', 'blogpost_img_id=' . $latestcomment['blogpost_img_id'])
                                        );
                                   
		}
                
                

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/module/wg24blog', $data));
	}
        
        
        public function details() {
		$this->load->language('product/special');

		$this->load->model('extension/module/wg24blog');
		$this->load->model('tool/image');
                
                   $save_value = array(
                        'wg24themeoptionpanel_home1blogtitletext_prallax',
                 'wg24themeoptionpanel_blogcommenttext_prallax',
                 'wg24themeoptionpanel_blogpostbttext_prallax',
                 'wg24themeoptionpanel_blogreadmoretext_prallax',
                  'wg24themeoptionpanel_homepage123_prallax'
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                    $blogtitle=$this->config->get('wg24themeoptionpanel_home1blogtitletext_prallax_'.$lang);
                  
                   
                
                
		$this->document->setTitle($blogtitle);

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $blogtitle,
			'href' => $this->url->link('extension/module/wg24blog')
		);

		$data['heading_title'] = $blogtitle;
		$data['text_empty'] = $this->language->get('text_empty');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['blogpost'] = array();
		$results = $this->model_extension_module_wg24blog->getByBlogPost($this->request->get['blogpost_img_id']);
		foreach ($results as $result) {
                    $this->document->setTitle($result['module_description']['metatitle']);
                    $this->document->setDescription($result['module_description']['metakeyword']);
                    $this->document->setKeywords($result['module_description']['metadesc']);
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'],870,565);
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}
                        $time = new DateTime($result['adddate']);
                        $date = $time->format('n/j/Y');
			$data['blogpost']= array(
				'blogpost_img_id'  => $result['blogpost_img_id'],
				'thumb'       => $image,
                                'video'       => html_entity_decode($result['video'], ENT_QUOTES, 'UTF-8'),
				'title'        => $result['module_description']['title'],
                                'postadmin'        => $result['postadmin'],
                                'adddate'        => $date,
                                 'totalcomment'        =>$result['totalcomment'] ,
				'description' => html_entity_decode($result['module_description']['description'], ENT_QUOTES, 'UTF-8'),
                           
			);
		}
                /* get all comment psot */
               $data['allcomments'] = array();
             $this->model_extension_module_wg24blog->cuntTotalComment($this->request->get['blogpost_img_id']);
               $postcomments= $this->model_extension_module_wg24blog->getAllComment(0,$this->request->get['blogpost_img_id'],1);
               foreach ($postcomments as $postcomment) {
				// Level 2
				$children_data = array();
				$children = $this->model_extension_module_wg24blog->getAllComment($postcomment['comment_id'],$this->request->get['blogpost_img_id'],1);
                           
				foreach ($children as $child) {
					$children_data[] = array(
                                               'comment_id'=> $child['comment_id'],
                                            'user_pic'=> $child['user_pic'],     
                                            'name'=> $child['name'],
                                            'email'=> $child['email'],
                                            'comment'=> $child['comment'],
                                            'comment_date'=> $child['comment_date'] 
					);          
				}
				// Level 1
				$data['allcomments'][] = array(
					    'comment_id'=> $postcomment['comment_id'],
                                            'user_pic'=> $postcomment['user_pic'],     
                                            'name'=> $postcomment['name'],
                                            'email'=> $postcomment['email'],
                                            'comment'=> $postcomment['comment'],
                                            'comment_date'=> $postcomment['comment_date'],
                                            'childcomment'=>$children_data
                                        );
                                   
		}
                
                /* end all comment post */
                /* left column all post category  */
                $data['blogcategorys'] = array();
               $blogcategorys= $this->model_extension_module_wg24blog->getAllCategory(0);
               foreach ($blogcategorys as $blogcategory) {
				// Level 2
				$blogcategory_child = array();
				$blog_children = $this->model_extension_module_wg24blog->getAllCategory($blogcategory['blog_cat_id']);
                           
				foreach ($blog_children as $child) {
					$blogcategory_child[] = array(
                                             'title' => $child['title'],
                                            'href'     => $this->url->link('extension/module/wg24blog', 'catepath=' . $child['blog_cat_id']),
					);          
				}
				// Level 1
				$data['blogcategorys'][] = array(
                                            'title' => $blogcategory['title'],
                                            'href'     => $this->url->link('extension/module/wg24blog', 'catepath=' . $blogcategory['blog_cat_id']),
                                            'child'=>$blogcategory_child
                                        );
                                   
		}
                /* latest post */
                  $data['latestposts'] = array();
               $latestposts= $this->model_extension_module_wg24blog->getLatestPost(3);
               foreach ($latestposts as $latestpost) {
                   	if ($latestpost['image']) {
				$postpic = $this->model_tool_image->resize($latestpost['image'],60,40);
			} else {
				$postpic = $this->model_tool_image->resize('placeholder.png',60,40);
			}
				$data['latestposts'][] = array(
                                           'title' => $latestpost['title'],
                                             'image' => $postpic,
                                             'totalcomment' => $latestpost['totalcomment'],
                                             'adddate' => $latestpost['adddate'],
                                            'href'  => $this->url->link('extension/module/wg24blog/details', 'blogpost_img_id=' . $latestpost['blogpost_img_id'])
                                        );
                                   
		}
                
                /** latest comment */
                $data['latestcomments'] = array();
               $latestcomments= $this->model_extension_module_wg24blog->getRecentBlogComment(3);
             
               foreach ($latestcomments as $latestcomment) {
				$data['latestcomments'][] = array(
                                           'title' => $latestcomment['title'],
                                             'name' => $latestcomment['name'],
                                             'image' => $latestcomment['user_pic'],
                                             'comment' => $latestcomment['comment'],
                                            'href'  => $this->url->link('extension/module/wg24blog/details', 'blogpost_img_id=' . $latestcomment['blogpost_img_id'])
                                        );
                                   
		}
                
                
                
                
                
                
                
                /* post category */
		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/module/wg24blog_details', $data));
	}
        
         public function blogComments(){
             $json = array();
             $this->load->language('extension/module/wg24language');
            $this->load->model('extension/module/wg24blog');
            $this->load->model('tool/image');
            if ($this->request->post['commentauthor'] == '') {
			$json['error']['commentauthor'] = $this->language->get('error_author');
            }
            if ($this->request->post['commentemail'] == '') {
			$json['error']['commentemail'] = $this->language->get('error_email');
            }else{
            if (!filter_var($this->request->post['commentemail'], FILTER_VALIDATE_EMAIL)) {
                $json['error']['commentemail'] = $this->language->get('error_valideemail');
            }
                
            }
            if ($this->request->post['commenttext'] == '') {
			$json['error']['commenttext'] = $this->language->get('error_comment');
            }else{
                 if (strlen($this->request->post['commenttext']) <24) {
                $json['error']['commenttext'] = $this->language->get('error_comment');
            }
                
            }
            if ($this->request->post['commentauthor']!= '' && $this->request->post['commentemail']!= '' && $this->request->post['commenttext']!= '' && filter_var($this->request->post['commentemail'], FILTER_VALIDATE_EMAIL) && !(strlen($this->request->post['commenttext']) <24)) {
                $this->model_extension_module_wg24blog->addComments($this->request->post);
                $json['success']['success'] = sprintf($this->language->get('success')); 
                $json['success']['loadpage'] ="index.php?route=extension/module/wg24blog/details&blogpost_img_id=".$this->request->post['blogpost_img_id']; 
                
            } else {
                    $json['error']['warning'] = sprintf($this->language->get('error_warning'));
            }
             $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
             
         }
        
        
}
