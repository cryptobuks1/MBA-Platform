<?php
class ControllerExtensionModuleWg24AllHomeBanner extends Controller {
	private $error = array();
        public function index() {
		$this->load->language('extension/module/wg24allhomebanner');

		$this->document->setTitle($this->language->get('heading_title'));
              
		$this->load->model('design/wg24allhomebanner');
                $res = $this->db->query("SHOW TABLES LIKE '".DB_PREFIX."wg24allhomebanner'");
                $query=$res->num_rows;
                if(!$query){
                    $this->dbcreatetable();
                    $this->dbdemodata();
                    
                }
		$this->getList();
	}

	public function add() {
		$this->load->language('extension/module/wg24allhomebanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24allhomebanner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24allhomebanner->addBanner($this->request->post);

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

			$this->response->redirect($this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/module/wg24allhomebanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24allhomebanner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_wg24allhomebanner->editBanner($this->request->get['banner_id'], $this->request->post);
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

			$this->response->redirect($this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/module/wg24allhomebanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24allhomebanner');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $banner_id) {
				$this->model_design_wg24allhomebanner->deleteBanner($banner_id);
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

			$this->response->redirect($this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
        public function dropmoduletable() {
		$this->load->language('extension/module/wg24allhomebanner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/wg24allhomebanner');

		if ($this->validateDelete()) {
                    
                  $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24allhomebanner`');
                  $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24allhomebanner_image`');
                  $this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'wg24allhomebanner_image_description`');

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

			$this->response->redirect($this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
        

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		$data['add'] = $this->url->link('extension/module/wg24allhomebanner/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/wg24allhomebanner/delete', 'token=' . $this->session->data['token'] . $url, true);
                $data['reset'] = $this->url->link('extension/module/wg24allhomebanner/dropmoduletable', 'token=' . $this->session->data['token'] . $url, true);
                $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module' . $url, true);
                
		$data['banners'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$banner_total = $this->model_design_wg24allhomebanner->getTotalBanners();

		$results = $this->model_design_wg24allhomebanner->getBanners($filter_data);

		foreach ($results as $result) {
			$data['banners'][] = array(
				'banner_id' => $result['banner_id'],
				'name'      => $result['name'],
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'edit'      => $this->url->link('extension/module/wg24allhomebanner/edit', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $banner_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($banner_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($banner_total - $this->config->get('config_limit_admin'))) ? $banner_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $banner_total, ceil($banner_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/wg24allhomebanner', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['banner_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
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

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['banner_image'])) {
			$data['error_banner_image'] = $this->error['banner_image'];
		} else {
			$data['error_banner_image'] = array();
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
			'href' => $this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['banner_id'])) {
			$data['action'] = $this->url->link('extension/module/wg24allhomebanner/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/wg24allhomebanner/edit', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/wg24allhomebanner', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$banner_info = $this->model_design_wg24allhomebanner->getBanner($this->request->get['banner_id']);
		}
                
                

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($banner_info)) {
			$data['name'] = $banner_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($banner_info)) {
			$data['status'] = $banner_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['banner_image'])) {
			$banner_images = $this->request->post['banner_image'];
		} elseif (isset($this->request->get['banner_id'])) {
			$banner_images = $this->model_design_wg24allhomebanner->getBannerImages($this->request->get['banner_id']);
		} else {
			$banner_images = array();
		}

		$data['banner_images'] = array();

		foreach ($banner_images as $banner_image) {
			if (is_file(DIR_IMAGE . $banner_image['image'])) {
				$image = $banner_image['image'];
				$thumb = $banner_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['banner_images'][] = array(
				'wg24allhomebanner_image_description' => $banner_image['wg24allhomebanner_image_description'],
				'link'                     => $banner_image['link'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order'               => $banner_image['sort_order']
			);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
          
		$this->response->setOutput($this->load->view('extension/module/wg24allhomebanner1', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24allhomebanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (isset($this->request->post['banner_image'])) {
			foreach ($this->request->post['banner_image'] as $banner_image_id => $banner_image) {
				foreach ($banner_image['wg24allhomebanner_image_description'] as $language_id => $banner_image_description) {
					if ((utf8_strlen($banner_image_description['title']) < 2) || (utf8_strlen($banner_image_description['title']) > 64)) {
						$this->error['banner_image'][$banner_image_id][$language_id] = $this->language->get('error_title');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/wg24allhomebanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
        public function  dbcreatetable(){  
 $res =$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24allhomebanner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
');
$res &=$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24allhomebanner_image` (
  `banner_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`banner_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
');
$res &=$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'wg24allhomebanner_image_description` (
  `banner_image_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `desce` text NOT NULL,
  PRIMARY KEY (`banner_image_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
');
return $res;
          
        }
  public function  dbdemodata(){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner` (`banner_id`, `name`, `status`) VALUES
(6, 'Home 1 Content Slider Module', 1),
(7, 'Home 2 Content Slider Module', 1),
(8, 'Home 3 Content Slider Module', 1),
(9, 'Home 1 Promo Banner Module', 1),
(10, 'Home 2 Promo Banner Module', 1),
(11, 'Home 3 Promo Banner Module', 1)");



$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image` (`banner_image_id`, `banner_id`, `link`, `image`, `sort_order`) VALUES
 (77, 6, 'http//24webgroup.com', 'catalog/24wgdemo/slider/slide-1.png', 1),
(78, 6, 'http//24webgroup.com', 'catalog/24wgdemo/slider/slide-2.png', 2),
 (79, 7, 'http//24webgroup.com', 'catalog/24wgdemo/slider2/slide-1.png', 1),
(80, 7, 'http//24webgroup.com', 'catalog/24wgdemo/slider2/slide-2.png', 2),
(81, 8, 'http//24webgroup.com', 'catalog/24wgdemo/slider3/slide-1.png', 1),
(82, 8, 'http//24webgroup.com', 'catalog/24wgdemo/slider3/slide-2.png', 2),
(83, 9, 'http//24webgroup.com', 'catalog/24wgdemo/promo1/promo1.png', 1),
(84, 9, 'http//24webgroup.com', 'catalog/24wgdemo/promo1/promo2.png', 2),
(85, 9, 'http//24webgroup.com', 'catalog/24wgdemo/promo1/promo3.png', 3),
(86, 10, 'http//24webgroup.com', 'catalog/24wgdemo/cat-banner/banner4.png', 1),
(87, 10, 'http//24webgroup.com', 'catalog/24wgdemo/cat-banner/banner5.png', 2),
(88, 11, 'http//24webgroup.com', 'catalog/24wgdemo/promo3/promo1.png', 1),
(89, 11, 'http//24webgroup.com', 'catalog/24wgdemo/promo3/promo2.png', 2)
");


/* content slider data */
$this->load->model('localisation/language'); 
$languages=$this->model_localisation_language->getLanguages();
for ($i = 1; $i <= 2; ++$i){
    if ($i == 1):
    $banner_image_id=77;
    $label = 'Slider-1';
    $slider1des='<div class="RightToLeft hidden-xs">
                                        <div class="Headding">new products</div>
                                        <div class="sub-heading">with smart phone</div>
                                        <div class="s-dsc"> Lorem Ipsum passages, and more recently with desktop publishing including versions of Lorem Ipsum.</div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-button gray9-bg">buy now</a>
                                        </div>
                                        <div class="slider-content-bg"></div>
                                    </div>';
    elseif ($i == 2):
    $label = "Slider-2";
    $banner_image_id=78;
     $slider1des='<div class="LeftToRight slider-content hidden-xs">
                                        <div class="Headding">We are new on here</div>
                                        <div class="sub-heading">with smart phone</div>
                                        <div class="s-dsc"> Lorem Ipsum passages, and more recently with desktop publishing including versions of Lorem Ipsum..</div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-button gray9-bg">buy now</a>
                                        </div>
                                        <div class="slider-content-bg2"></div>
                                    </div>';
    endif;
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`,`desce`) VALUES
($banner_image_id,'".$language['language_id']."', 6, '$label','$slider1des')");
}
}
/* content slider 2*/
for ($i = 1; $i <= 2; ++$i){
    if ($i == 1):
    $banner_image_id=79;
    $label = 'Slider-1';
    $slider1des='<div class="RightToLeft">
                                 <div class="Headding">AWESOME PARALLAX</div>
                                 <div class="sub-heading">New Features Include</div>
                                 <div class="s-dsc"> Lorem Ipsum passages, and more recently with desktop publishing including versions of Lorem Ipsum.</div>
                                 <div class="readmore">
                                     <a href="#" class="btn btn-button gray9-bg">buy now</a>
                                 </div>
                             </div>';
    elseif ($i == 2):
    $label = "Slider-2";
    $banner_image_id=80;
     $slider1des='<div class="LeftToRight slider-content">
                                 <div class="Headding">AWESOME PARALLAX</div>
                                 <div class="sub-heading">New Features Include</div>
                                 <div class="s-dsc"> Lorem Ipsum passages, and more recently with desktop publishing including versions of Lorem Ipsum..</div>
                                 <div class="readmore">
                                     <a href="#" class="btn btn-button gray9-bg">buy now</a>
                                 </div>
                             </div>';
    endif;
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`,`desce`) VALUES
($banner_image_id,'".$language['language_id']."', 7, '$label','$slider1des')");
}
}
/* content slider 3*/
for ($i = 1; $i <= 2; ++$i){
    if ($i == 1):
    $banner_image_id=81;
    $label = 'Slider-1';
    $slider1des='<div class="RightToLeft slider-3-content">
                                                <div class="Headding">Footwear at Shoes </div>
                                                <div class="sub-heading">Lorem Ipsum is simply</div>
                                                <div class="slider-line"></div>
                                                <div class="readmore">
                                                    <a href="" class="read-more">Read More...<span class="fa fa-angle-double-right"></span></a>
                                                    <a href="#" class="btn btn-button white-bg">BUY NOW</a>
                                                </div>
                                            </div>';
    elseif ($i == 2):
    $label = "Slider-2";
    $banner_image_id=82;
     $slider1des='<div class="RightToLeft slider-3-content">
                                                <div class="Headding">AWESOME PARALLAX</div>
                                                <div class="sub-heading">Lorem Ipsum is simply</div>
                                                <div class="slider-line"></div>
                                                <div class="readmore">
                                                    <a href="" class="read-more">Read More...<span class="fa fa-angle-double-right"></span></a>
                                                    <a href="#" class="btn btn-button white-bg">BUY NOW</a>
                                                </div>
                                            </div>';
    endif;
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`,`desce`) VALUES
($banner_image_id,'".$language['language_id']."', 8, '$label','$slider1des')");
}
}



/* promo banner 1 */
for ($i = 1; $i <= 3; ++$i){
    if ($i == 1):
    $banner_image_id=83;
    $label = 'Promo 1';
    $slider1des='<div class="promo-content promo1">
                                    <h2 class="promo-title"><span>women dress</span></h2>
                                    <div class="promo-sub-title">collection</div>
                                    <a href="#" class="btn btn-button white-bg">view all</a>
                                </div>';
    elseif ($i == 2):
    $label = "Promo 2";
    $banner_image_id=84;
     $slider1des='<div class="promo-content promo2">
                                    <h2 class="promo-title"><span>coming soon</span></h2>
                                    <div class="promo-sub-title">Watch</div>
                                    <a href="#" class="btn btn-button white-bg">Shop Now</a>
                                </div>';
    elseif ($i == 3):
    $label = "Promo 3";
    $banner_image_id=85;
    $slider1des='<div class="promo-content promo3">
                                    <h2 class="promo-title"><span>up to discount</span></h2>
                                    <div class="promo-sub-title">10% on sale</div>
                                    <a href="#" class="btn btn-button white-bg">View All</a>
                                </div>';
    endif;
    
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`,`desce`) VALUES
($banner_image_id,'".$language['language_id']."', 9, '$label','$slider1des')");
}
}


/* promo banner 2 home 2 */
for ($i = 1; $i <= 2; ++$i){
    if ($i == 1):
    $banner_image_id=86;
    $label = 'Promo 1';
    $slider1des='<div class="add-banner-text-box">
                <h2><span>new</span>collection</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <a class="btn btn-button white-bg" href="#">Shop Now<span class="fa fa-angle-double-right"></span></a>
            </div>';
    elseif ($i == 2):
    $label = "Promo 2";
    $banner_image_id=87;
     $slider1des='<div class="add-banner-text-box">
                    <h2><span>UP</span> COMING</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <a class="btn btn-button white-bg" href="#">Shop Now<span class="fa fa-angle-double-right"></span></a>
                </div>';
    endif;
    
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`,`desce`) VALUES
($banner_image_id,'".$language['language_id']."', 10, '$label','$slider1des')");
}
}


/* promo banner 3 home 3 */
for ($i = 1; $i <= 2; ++$i){
    if ($i == 1):
    $banner_image_id=88;
    $label = 'Promo 1';
    $slider1des='<div class="promo-content">
                                    <h2><span>big </span>offer 2016</h2>
                                    <div class="after-before-line-right"></div>
                                    <div class="after-before-line-righthover"></div>
                                    <h3 class="sale-off">sale <span>30%</span> off</h3>
                                    <strong>For Men Shopping</strong>
                                    <div class="after-before-line-left"></div>
                                    <div class="after-before-line-lefthover"></div>
                                    <a href="#" class="btn btn-button white-bg">Shop Now<span class="fa fa-angle-double-right"></span></a>
                                </div>';
    elseif ($i == 2):
    $label = "Promo 2";
    $banner_image_id=89;
     $slider1des='<div class="promo-content">
                                    <h3 class="sale-off">sale <span>30%</span> off</h3>
                                    <div class="after-before-line-right"></div>
                                    <div class="after-before-line-righthover"></div>
                                    <h2>summer 2016</h2>
                                    <strong>For Men Shopping</strong>
                                    <div class="after-before-line-left"></div>
                                    <div class="after-before-line-lefthover"></div>
                                    <a href="#" class="btn btn-button white-bg">Shop Now<span class="fa fa-angle-double-right"></span></a>
                                </div>';
    endif;
    
foreach($languages as $language){
$this->db->query("INSERT INTO `" . DB_PREFIX . "wg24allhomebanner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`,`desce`) VALUES
($banner_image_id,'".$language['language_id']."', 11, '$label','$slider1des')");
}
}







          
     }
        
      
}