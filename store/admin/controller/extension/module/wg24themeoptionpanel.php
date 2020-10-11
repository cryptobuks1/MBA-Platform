<?php

class ControllerExtensionModuleWg24ThemeOptionPanel extends Controller {

    private $error = array();
    public $wg24_t_title  = "prallax";
    public $wg24_a_title  = "wg24themeoptionpanel";
    public $ThemeName  = "Prallax Theme";
    public $wg24values = array();
    public $theme_pattern, $wg24_fields_data, $wg24_get_tabs;
    public function index() {
               $this->load->language('extension/module/wg24themeoptionpanel');
        	$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
                $this->load->model('setting/wg24themeoptionpanel');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('wg24themeoptionpanel', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
                   $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['help_product'] = $this->language->get('help_product');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_module_add'] = $this->language->get('button_module_add');
		$data['button_remove'] = $this->language->get('button_remove');
                 if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/wg24themeoptionpanel', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/wg24themeoptionpanel', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$data['token'] = $this->session->data['token'];
                     $this->load->model('tool/image');
               $this->load->model('design/layout');
		if (isset($this->request->post['wg24themeoptionpanel_status'])) {
			$data['wg24themeoptionpanel_status'] = $this->request->post['wg24themeoptionpanel_status'];
		} else {
			$data['wg24themeoptionpanel_status'] = $this->config->get('wg24themeoptionpanel_status');
		}
		 $this->wg24_all_t_Patern();
                 $this->wg24_Theme_values();
                 
                  if (!$this->config->get('wg24themeoptionpanel_homepage123_prallax')==('homepage1' || 'homepage2' || 'homepage3')) {
                        $this->wg24_installValues();
                }  
                
		 $data['wg24optiondesign'] = $this->wg24_administration_form();
                 $this->load->model('design/layout');
                if (isset($this->request->post['wg24themeoptionpanel_body_cus_pattan'])) {
			$data['wg24themeoptionpanel_body_cus_pattan'] = $this->request->post['wg24themeoptionpanel_body_cus_pattan'];
		} else {
			$data['wg24themeoptionpanel_body_cus_pattan'] = $this->config->get('wg24themeoptionpanel_body_cus_pattan');
		}
                $this->load->model('tool/image');

		if (isset($this->request->post['wg24themeoptionpanel_body_cus_pattan']) && is_file(DIR_IMAGE . $this->request->post['wg24themeoptionpanel_body_cus_pattan'])) {
			$data['wg24themeoptionpanel_body_sub_class_thumb'] = $this->model_tool_image->resize($this->request->post['wg24themeoptionpanel_body_cus_pattan'], 100, 100);
		} elseif ($this->config->get('wg24themeoptionpanel_body_cus_pattan') && is_file(DIR_IMAGE . $this->config->get('wg24themeoptionpanel_body_cus_pattan'))) {
			$data['wg24themeoptionpanel_body_sub_class_thumb'] = $this->model_tool_image->resize($this->config->get('wg24themeoptionpanel_body_cus_pattan'), 100, 100);
		} else {
			$data['wg24themeoptionpanel_body_sub_class_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
          
         
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/module/wg24themeoptionpanel', $data));

    }
 
    
     public function wg24_installValues() {
        foreach ($this->wg24values as $wg24_value_result):
            if (isset($wg24_value_result['wg24'])) :
                    if (isset($wg24_value_result['lang']) && $wg24_value_result['lang'] == "true") :
                       $languages = $this->model_localisation_language->getLanguages();
                        foreach ($languages as $langua) :
                            $nameid=$wg24_value_result['id']. '_' . $langua['language_id'];
                            $value=htmlspecialchars($wg24_value_result['wg24']);
                            $array=array(
                                $nameid=>$value
                            );
                            $this->model_setting_wg24themeoptionpanel->editSetting('wg24themeoptionpanel',$array);
                        endforeach;
                    else:
                        $nameid=$wg24_value_result['id'];
                        $value=$wg24_value_result['wg24'];
                            $array=array(
                                $nameid=>$value
                            );
                            $this->model_setting_wg24themeoptionpanel->editSetting('wg24themeoptionpanel',$array);
                    endif;
                endif;;
    endforeach;
        return true;
    }

   	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/wg24themeoptionpanel')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['wg24themeoptionpanel_module'])) {
			foreach ($this->request->post['wg24themeoptionpanel_module'] as $key => $value) {
				if (!$value['width'] || !$value['height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}

		return !$this->error;
	} 
    public function wg24_all_t_Patern() {
        $get_paterns = array();
       $get_paterns_links = HTTPS_SERVER . 'view/javascript/wg24options/theme_patterns/';
      $get_paterns_path = DIR_APPLICATION . 'view/javascript/wg24options/theme_patterns/';
        if (is_dir($get_paterns_path)) {
            if ($image_dir = opendir($get_paterns_path)) {
                while (($patern_name = readdir($image_dir)) !== false) {
                    if (stristr($patern_name,".png") !== false ||  stristr($patern_name, ".jpg") !== false || stristr($patern_name, ".gif") !== false || stristr($patern_name, ".jpeg") !== false) {
                        $get_paterns[] = $get_paterns_links . $patern_name;
                    }
                }
            }
        }
          $this->theme_pattern = $get_paterns;
          return $this->theme_pattern;
    }  
    
    
      public function wg24_Theme_values() {
          
        $theme_pattern = $this->wg24_all_t_Patern();
        $languages = $this->model_localisation_language->getLanguages();
        $administration_image_pathe ='view/javascript/wg24options/img/';
        $theme_image_pathe =HTTP_CATALOG;
        $wg24_get_values = array();
        /*         * **********************************    ********************************** */
        $wg24_get_values[] = array("name" => 'General theme settings',
            "type" => "tabs_title");
        /*         * *************** start home page option *********** */
        $wg24_get_values[] = array("name" => "Home Page",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'You can choose 3 type home page',
            "dsc" => 'You can select home page 1.....3',
            "id" => $this->wg24_a_title . "_homepage123_" . $this->wg24_t_title,
            "wg24" => "homepage1",
            "values" => array('homepage1' => 'Home page 1', 'homepage2' => 'Home page 2', 'homepage3' => 'Home page 3'),
            "type" => "select");
         
        $wg24_get_values[] = array("name" => "Layout",
            "type" => "content-title");
         $wg24_get_values[] = array("name" => 'How Much Parrent  Menu make as mega menu',
            "dsc" => 'How Much Parrent  Menu make as mega menu  to show page on header.',
            "id" => $this->wg24_a_title . '_megamenushow_' . $this->wg24_t_title,
            "wg24" => '2',
            "type" => "text");
          $wg24_get_values[] = array("name" => 'How much Product Want to Show as New Products',
            "dsc" => 'Please sleect limit',
            "id" => $this->wg24_a_title . "_newproductlimit_" . $this->wg24_t_title,
            "wg24" => "50",
            "values" => array('15' => '15', '20' => '20', '30' => '30', '40' => '40', '50' => '50', '60' => '60', '70' => '70', '80' => '80', '90' => '90', '100' => '100'),
            "type" => "select");
          
          $wg24_get_values[] = array("name" => 'Home page Mini Products',
            "dsc" => 'Home page Mini Products sow hide.',
            "id" => $this->wg24_a_title . "_miniproducts_" . $this->wg24_t_title,
            "wg24" => "show",
            "values" => array('show' => 'Show', 'hide' => 'Hide'),
            "type" => "select");
        $wg24_get_values[] = array("name" => 'Show scroll to top button',
            "dsc" => 'You can show or hide Show scroll to top button.',
            "id" => $this->wg24_a_title . "_scrol_top_to_" . $this->wg24_t_title,
            "wg24" => "show",
            "values" => array('show' => 'Show', 'hide' => 'Hide'),
            "type" => "select");
        $wg24_get_values[] = array("name" => 'home page 1 Left sidebar collection 2016',
            "dsc" => 'home page 1 new collection 2016',
            "id" => $this->wg24_a_title . "_home1leftcollec_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '  <div class="left-cat-banner-content">
                                        <div class="banner-hadding"><span>new collection 2016</span></div>
                                        <div class="text-content">
                                            <span>All Summer Sale Product in Shop(Women, Men, jewelry, Books,  clothing,jeans, Accessories) so dont wait Please hurray up to take this product</span>
                                        </div>
                                        <div class="left-banner-offers">30%Off Sale</div>
                                    </div>',
            "type" => "textarea"
        );
       $wg24_get_values[] = array("name" => 'home page 1 Mega Sale 80% off banner',
            "dsc" => 'home page 1 new collection 2016',
            "id" => $this->wg24_a_title . "_home1megasale_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="add-banner-img">
                                                <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/cat-banner/banner1.png" alt="banner image" />
                                            </div>
                                            <div class="add-banner-link">
                                                <a class="btn btn-button white-bg" href="#">shop Now<span class="fa fa-angle-double-right"></span></a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="add-banner-img">
                                                <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/cat-banner/banner2.png" alt="banner image" />
                                            </div>
                                            <div class="add-banner-link link1">
                                                <a class="btn btn-button white-bg" href="#">Shop Now<span class="fa fa-angle-double-right"></span></a>
                                            </div>
                                        </div>',
            "type" => "textarea"
        );
        $wg24_get_values[] = array("name" => 'home page 1 Free Home Delivery Message',
            "dsc" => 'home page 1 Free Home Delivery Message',
            "id" => $this->wg24_a_title . "_home1freedeliverymes_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="free-shipping-box">
                                        <div class="free-sp-icon-box">
                                            <div class="free-sp-icon-box-inner">
                                                <i class="fa fa-gift"></i>
                                            </div>
                                        </div>
                                        <h3 class="hadding-title"><span>free gift voucher</span></h3>
                                        <div class="free-sp-content">
                                            <p>Lorem Ipsum has been the industrys as dummy text ever since the 50, printer took a galley. </p>
                                        </div>
                                        <div class="readmore"><a href="">Read more<i class="fa fa-play"></i></a></div>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-3 col-lg-3">
                                    <div class="free-shipping-box">
                                        <div class="free-sp-icon-box">
                                            <div class="free-sp-icon-box-inner">
                                                <i class="fa fa-truck"></i>
                                            </div>
                                        </div>
                                        <h3 class="hadding-title"><span>Free Home Delivery</span></h3>
                                        <div class="free-sp-content">
                                            <p>Lorem Ipsum has been the industrys as dummy text ever since the 50, printer took a galley. </p>
                                        </div>
                                        <div class="readmore"><a href="">Read more<i class="fa fa-play"></i></a></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <div class="free-shipping-box">
                                        <div class="free-sp-icon-box">
                                            <div class="free-sp-icon-box-inner">
                                                <i class="fa fa-plane"></i>
                                            </div>
                                        </div>
                                        <h3 class="hadding-title"><span>Free Air Shipment</span></h3>
                                        <div class="free-sp-content">
                                            <p>Lorem Ipsum has been the industrys as dummy text ever since the 50, printer took a galley.</p>
                                        </div>
                                        <div class="readmore"><a href="">Read more<i class="fa fa-play"></i></a></div>
                                    </div>
                                </div>',
            "type" => "textarea"
        );
        $wg24_get_values[] = array("name" => 'home page 2 Free Home Delivery Message',
            "dsc" => 'home page 1 Free Home Delivery Message',
            "id" => $this->wg24_a_title . "_home2freedeliverymes_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <div class="col-md-4">
                                <div class="free-shipping-box">
                                    <div class="free-sp-icon-box">
                                        <div class="free-sp-icon-box-inner">
                                            <i class="fa fa-gift"></i>
                                        </div>
                                    </div>
                                    <h3 class="hadding-title"><span>free gift voucher</span></h3>
                                    <div class="free-sp-content">
                                        <p>Lorem Ipsum has been the industrys as dummy text ever since the 50, printer took a galley. </p>
                                    </div>
                                    <div class="readmore"><a href="">Read more<i class="fa fa-play"></i></a></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="free-shipping-box">
                                    <div class="free-sp-icon-box">
                                        <div class="free-sp-icon-box-inner">
                                            <i class="fa fa-truck"></i>
                                        </div>
                                    </div>
                                    <h3 class="hadding-title"><span>free gift voucher</span></h3>
                                    <div class="free-sp-content">
                                        <p>Lorem Ipsum has been the industrys as dummy text ever since the 50, printer took a galley. </p>
                                    </div>
                                    <div class="readmore"><a href="">Read more<i class="fa fa-play"></i></a></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="free-shipping-box">
                                    <div class="free-sp-icon-box">
                                        <div class="free-sp-icon-box-inner">
                                            <i class="fa fa-plane"></i>
                                        </div>
                                    </div>
                                    <h3 class="hadding-title"><span>free gift voucher</span></h3>
                                    <div class="free-sp-content">
                                        <p>Lorem Ipsum has been the industrys as dummy text ever since the 50, printer took a galley.</p>
                                    </div>
                                    <div class="readmore"><a href="">Read more<i class="fa fa-play"></i></a></div>
                                </div>
                            </div>',
            "type" => "textarea"
        );
         $wg24_get_values[] = array("name" => 'home page 3 Free Home Delivery Message',
            "dsc" => 'home page 1 Free Home Delivery Message',
            "id" => $this->wg24_a_title . "_home3freedeliverymes_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <!-- item-1 -->
                        <div class=" col-sm-4 col-md-4 col-lg-4">
                            <div class="free-shgipping-box col-xs-top">
                                <div class="free-sp-icon-box-inner">
                                    <i class="fa fa-gift"></i>
                                </div>
                                <div class="shipping-content">
                                    <h2 class="hadding-title"><span>free gift voucher</span></h2>
                                    <h3 class="sub-hadding-title">customer servis  lorem</h3>
                                    <p>Lorem Ipsum has beehgn the industrys ever since the 50, printer took... </p>
                                </div>
                            </div>
                        </div>
                        <!-- / item-1 -->
                        <!-- item-2 -->
                        <div class=" col-sm-4 col-md-4 col-lg-4">
                            <div class="free-shgipping-box">
                                <div class="free-sp-icon-box-inner">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div class="shipping-content">
                                    <h2 class="hadding-title"><span>Free Home Delivery</span></h2>
                                    <h3 class="sub-hadding-title">customer servis  lorem</h3>
                                    <p>Lorem Ipsum has beehgn the industrys ever since the 50, printer took... </p>
                                </div>
                            </div>
                        </div>
                        <!-- / item-2 -->
                        <!-- item-3 -->
                        <div class=" col-sm-4 col-md-4 col-lg-4">
                            <div class="free-shgipping-box">
                                <div class="free-sp-icon-box-inner">
                                    <i class="fa fa-plane"></i>
                                </div>
                                <div class="shipping-content">
                                    <h2 class="hadding-title"><span>Free Air Shipment</span></h2>
                                    <h3 class="sub-hadding-title">customer servis  lorem</h3>
                                    <p>Lorem Ipsum has beehgn the industrys ever since the 50, printer took... </p>
                                </div>
                            </div>
                        </div>
                        ',
            "type" => "textarea"
        );
        $wg24_get_values[] = array("name" => 'home page 2 pARALLAX THEME Banner',
            "dsc" => 'home page 2 pARALLAX THEME Banner',
            "id" => $this->wg24_a_title . "_home2parrallaxtheme_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<div class="add-banner-2">
        <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/cat-banner/add-banner2.png" alt="add banner two" />
        <div class="add-banner2-contetn">
            <h2>pARALLAX THEME</h2>
            <div class="add-banner2-price">$130</div>
            <a class="read-more" href="">CHECK NOW</a>
        </div>
    </div>',
   "type" => "textarea"
        );
          $wg24_get_values[] = array("name" => 'home page 2 Deal of the day',
            "dsc" => 'home page 2 Deal of the day banner',
            "id" => $this->wg24_a_title . "_home2dealoftheday_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" =>'<div class="col-md-5 col-md-offset-1">
                 <div class="timer-image">
                     <img src="' . $theme_image_pathe . 'catalog/view/theme/parallax/assets/image/timer-banner.png" alt="timer banner" />
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="timer-banner-area">
                     <h2>Deal of the day</h2>
                     <h3>Up to 30% off </h3>
                     <p>Lorem Ipsum has been the industrys as dummy text ever since 50, </p>
                     <div class="timer-banner-box margin-buttom-product" id="countdays">
                     </div>
                     <a href="#" class="btn btn-button border-color white">Shop Now<span class="fa fa-angle-double-right"></span></a>
                 </div>
             </div>',
   "type" => "textarea"
        );
           $wg24_get_values[] = array("name" => 'home page 3 Hot  Deal Add Banner ',
            "dsc" => 'home page 2 Deal of the day banner',
            "id" => $this->wg24_a_title . "_home3hotdealbanner_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" =>'<div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="banner-bottom-inner">
                                <a href="#">
                                    <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/promo4/promo.png" alt="" />
                                </a>
                            </div>
                        </div>
                         <!-- banner-1 -->
                         <!-- banner-2 -->
                        <div class=" col-sm-6 col-md-6 col-lg-6">
                            <div class="banner-bottom-inner banner-botton1">
                                <a href="#">
                                    <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/promo4/promo1.png" alt="" />
                                </a>
                            </div>
                        </div>',
   "type" => "textarea"
        );
          
          $wg24_get_values[] = array("name" => 'home page 3 Mini Product Banner',
            "dsc" => 'home page 3 Mini Product Banner',
            "id" => $this->wg24_a_title . "_home3minibanner_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" =>'  <div class="product-banner">
                                <img src="' . $theme_image_pathe . 'catalog/view/theme/parallax/assets/image/banner-bottom.png" alt="img" />
                                <div class="banner-bottom-content">
                                    <div class="product-banner-after-left"></div>
                                    <div class="product-banner-after-lefthover"></div>
                                    <h1><span>a</span>ccessories</h1>
                                    <p>Lorem Ipsum has been the industrys standard dummy text ever since.</p>
                                    <h2><span>c</span>ollection 2016</h2>
                                    <a class="btn btn-button tomato-bg" href="#">view all</a>
                                    <div class="product-banner-after-right"></div>
                                    <div class="product-banner-after-righthover"></div>
                                </div>
                            </div>',
   "type" => "textarea"
        );
          
          
        
        
        
        
         

        /*         * ******************** start category page  ****************************** */
        $wg24_get_values[] = array("name" => "Category page",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Category Page Subcategory',
            "dsc" => 'You can show or hide Subcategory on Category page',
            "id" => $this->wg24_a_title . "_c_sub_categor_" . $this->wg24_t_title,
            "wg24" => "hide",
            "values" => array('show' => 'Show', 'hide' => 'Hide'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Category Page view mode",
            "dsc" => "If you want to change catalog page default view style.",
            "id" => $this->wg24_a_title . "_c_list_grid_" . $this->wg24_t_title,
            "wg24" => "grid_view",
            "type" => "images",
            "values" => array(
                'grid_view' => $administration_image_pathe . 'grid_view.png',
                'list_view' => $administration_image_pathe . 'list_view.png'
            )
        );
        $wg24_get_values[] = array("name" => 'Category page let sidebar banner',
            "dsc" => 'Category page let sidebar banner',
            "id" => $this->wg24_a_title . "_cateletbanner_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<div class="aside-category-banner-img">
                                        <img alt="" src="' . $theme_image_pathe . 'image/catalog/24wgdemo/category-page/big-banner/banner1.png" />
                                        <div class="aside-category-banner-button">
                                            <a href="#" class="btn btn-button white-bg">buy now</a>
                                        </div>
                                    </div>',
            "type" => "textarea");
        /*         * ******************* product page  **************************************** */
        $wg24_get_values[] = array("name" => "Product page",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Product Page 4 Type of Layout ',
            "dsc" => 'you can choose 4 type of layout.',
            "id" => $this->wg24_a_title . '_productlayout_' . $this->wg24_t_title,
            "wg24" => "default",
            "values" => array('default' => 'Default Layout', 'wminiproducts' => 'With Mini Products','left' => 'Left Column','right' => 'Right Column'),
            "type" => "select");
        
        
        $wg24_get_values[] = array("name" => 'Custom tab',
            "dsc" => 'You can show or hide custom tab page on product',
            "id" => $this->wg24_a_title . '_p_tab_contorl_' . $this->wg24_t_title,
            "wg24" => "show",
            "values" => array('show' => 'Show', 'hide' => 'Hide'),
            "type" => "select");
        $wg24_get_values[] = array("name" => 'Tab title',
            "dsc" => 'Custom HTML tab title design to show on product page.',
            "id" => $this->wg24_a_title . '_p_tab_title_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Custom tab',
            "type" => "text");
        $wg24_get_values[] = array("name" => 'Tab content',
            "dsc" => 'Custom HTML design to show on product page.',
            "id" => $this->wg24_a_title . '_p_tab_content_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
            "type" => "textarea");
        
         $wg24_get_values[] = array("name" => 'Related Product Add banner',
            "dsc" => 'Related Product Add banner show on product page.',
            "id" => $this->wg24_a_title . '_rpaddbanner_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<div class="aside-category-banner-inner">
                                                <div class="aside-category-banner-img">
                                                    <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/category-page/big-banner/banner1.png" alt="">
                                                </div>
                                                <div class="aside-category-banner-button">
                                                    <a class="btn btn-button white-bg" href="#">buy now</a>
                                                </div>
                                            </div>',
            "type" => "textarea");
         
        /*         * *************************************  Start color  **********************************  */
        $wg24_get_values[] = array("name" => 'Theme colors',
            "type" => "tabs_title");
        $wg24_get_values[] = array("name" => 'Load color skin',
            "dsc" => 'You can Load color scheme.',
            "id" => $this->wg24_a_title . '_col_skin_' . $this->wg24_t_title,
            "wg24" => "default",
            "values" => array('default' => 'Default Skin', 'customeskin' => 'Custom Skin'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Main",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Body Background Color for theme 1,2,3',
            "dsc" => 'Default color: #fff. If you want to change this color.',
            "id" => $this->wg24_a_title . '_col_body_bg_' . $this->wg24_t_title,
            "wg24" => "#fff",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Body font color',
            "dsc" => 'Default color: #333333. If you want to change this color.',
            "id" => $this->wg24_a_title . '_col_body_font_' . $this->wg24_t_title,
            "wg24" => "#333333",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Link color for all theme',
            "dsc" => 'Default color: #333333. If you want to change this color.',
            "id" => $this->wg24_a_title . '_col_link_font1_' . $this->wg24_t_title,
            "wg24" => "#333333",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Link Hover color for all theme',
            "dsc" => 'Default color: #ff623f. If you want to change this color.',
            "id" => $this->wg24_a_title . '_col_link_h_font1_' . $this->wg24_t_title,
            "wg24" => "#ff623f",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Input fields background',
            "dsc" => 'Default color: #FFFFFF. If you want to change this color.',
            "id" => $this->wg24_a_title . '_input_bg_col_' . $this->wg24_t_title,
            "wg24" => "#FFFFFF",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Input fields text',
            "dsc" => 'Default color: #555555. If you want to change this color.',
            "id" => $this->wg24_a_title . '_input_text_col_' . $this->wg24_t_title,
            "wg24" => "#9c9b9b",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Input fields border',
            "dsc" => 'Default color: #999. If you want to change this color.',
            "id" => $this->wg24_a_title . '_input_bord_col_' . $this->wg24_t_title,
            "wg24" => "#999",
            "type" => "color");
        /*         * *************************************  header background color  ****************************************************** */
        $wg24_get_values[] = array("name" => "Header and Main Menu ",
            "type" => "content-title");
          $wg24_get_values[] = array("name" => ' Home page 2 bg color ',
            "dsc" => 'Default color: rgba(0, 0, 0, 0.3). If you want to change this color.',
            "id" => $this->wg24_a_title . '_home2menubgcol_' . $this->wg24_t_title,
            "wg24" => "rgba(0, 0, 0, 0.3)",
            "type" => "text");

        
        
        
        $wg24_get_values[] = array("name" => ' link color',
            "dsc" => 'Default color: #999. If you want to change this color.',
            "id" => $this->wg24_a_title . '_h_m_link_col_' . $this->wg24_t_title,
            "wg24" => "#999",
            "type" => "color");
        $wg24_get_values[] = array("name" => ' link hover color',
            "dsc" => 'Default color: #fff. If you want to change this color.',
            "id" => $this->wg24_a_title . '_h_m_link_h_col_' . $this->wg24_t_title,
            "wg24" => "#fff",
            "type" => "color");
          /****************************** global  button   ****************************************** */
        $wg24_get_values[] = array("name" => "Global Color",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => "Global Color For all  theme",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Primary Color',
            "dsc" => 'Default color: #171717. If you want to change this color.',
            "id" => $this->wg24_a_title . '_gobprimary1_col_' . $this->wg24_t_title,
            "wg24" => "#171717",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Secendary color 1',
            "dsc" => 'Default color: #ff623f. If you want to change this color.',
            "id" => $this->wg24_a_title . '_golbalsendary1_col_' . $this->wg24_t_title,
            "wg24" => "#ff623f",
            "type" => "color");
            $wg24_get_values[] = array("name" => 'White Button Bg color',
            "dsc" => 'Default color: #fff. If you want to change this color.',
            "id" => $this->wg24_a_title . '_golbalsendary13_col_' . $this->wg24_t_title,
            "wg24" => "#fff",
            "type" => "color");
            
            $wg24_get_values[] = array("name" => 'White button text color',
            "dsc" => 'Default color: #333. If you want to change this color.',
            "id" => $this->wg24_a_title . '_whitcolortext_col_' . $this->wg24_t_title,
            "wg24" => "#333",
            "type" => "color");
 
        /*         * *******************************   footer   *********************************************** */
        $wg24_get_values[] = array("name" => "FOOTER",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Footer  background',
            "dsc" => 'Default color: #252525. If you want to change this color.',
            "id" => $this->wg24_a_title . '_footer_bg_col_' . $this->wg24_t_title,
            "wg24" => "#252525f",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Footer Headers color',
            "dsc" => 'Default color: #fff. If you want to change this color.',
            "id" => $this->wg24_a_title . '_f_heading_col_' . $this->wg24_t_title,
            "wg24" => "#fff",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Footer links color',
            "dsc" => 'Default color:#fff. If you want to change this color.',
            "id" => $this->wg24_a_title . '_f_link_col_' . $this->wg24_t_title,
            "wg24" => "#fff",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Footer links hover ',
            "dsc" => 'Default color:#ff623f. If you want to change this color.',
            "id" => $this->wg24_a_title . '_f_link_h_col_' . $this->wg24_t_title,
            "wg24" => "#ff623f",
            "type" => "color");
        $wg24_get_values[] = array("name" => 'Footer powered by text color',
            "dsc" => 'Default color:#fff. If you want to change this color.',
            "id" => $this->wg24_a_title . '_f_powered_col_' . $this->wg24_t_title,
            "wg24" => "#fff",
            "type" => "color");

        /*         * ********************************* theme becakgorund **********************************  */
        $wg24_get_values[] = array("name" => 'Theme backgrounds',
            "type" => "tabs_title");
        $wg24_get_values[] = array("name" => 'Background Images',
            "dsc" => 'If you want to change main body background image.',
            "id" => $this->wg24_a_title . "_bg_img_" . $this->wg24_t_title,
            "wg24" => "hide",
            "values" => array('show' => 'Show', 'hide' => 'Hide'),
            "type" => "select");
        $wg24_get_values[] = array("name" => 'Upload Custom Pattern',
            "dsc" => 'You can upload your custom pattern from here.',
            "id" => $this->wg24_a_title . "_bg_cust_patten_" . $this->wg24_t_title,
            "wg24" => '',
            "type" => "upload");
        $wg24_get_values[] = array("name" => "Background Patterns",
            "id" => $this->wg24_a_title . "_bg_patten_" . $this->wg24_t_title,
            "wg24" => "",
            "type" => "tiles",
            "values" => $theme_pattern,
        );
        $wg24_get_values[] = array("name" => "Baackground Attachment",
            "dsc" => "You can set shorthand properties for the background.",
            "id" => $this->wg24_a_title . "_bg_attached_" . $this->wg24_t_title,
            "wg24" => "scroll",
            "values" => array('scroll' => 'Scroll', 'fixed' => 'Fixed', 'inherit' => 'Inherit'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Baackground Repeat",
            "dsc" => "You can set shorthand properties for the background",
            "id" => $this->wg24_a_title . "_bg_repeter_" . $this->wg24_t_title,
            "wg24" => "repeat",
            "values" => array('repeat' => 'Repeat', 'repeat-x' => 'Repeat-x', 'repeat-y' => 'Repeat-y', 'no-repeat' => 'No-repeat', 'inherit' => 'Inherit'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Backgorund Position",
            "dsc" => "You can set shorthand properties for the background",
            "id" => $this->wg24_a_title . "_bg_positin_" . $this->wg24_t_title,
            "wg24" => "scroll",
            "values" => array('left top' => 'Left top', 'left center' => 'Left center', 'left bottom' => 'Left bottom',
                'right top' => 'Right top', 'right center' => 'Right center', 'right bottom' => 'Right bottom',
                'center top' => 'Center top', 'center center' => 'Center center', 'center bottom' => 'Center bottom'),
            "type" => "select");
        /*         * *********************  Font **********************************  */
        $wg24_get_values[] = array("name" => 'Fonts',
            "type" => "tabs_title");
        $wg24_get_values[] = array("name" => "Body font",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Select font source',
            "dsc" => 'If you want to Select font source  system/google.',
            "id" => $this->wg24_a_title . "_body_select_font_" . $this->wg24_t_title,
            "wg24" => "show",
            "values" => array('show' => 'Google', 'hide' => 'System'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Body Font to system",
            "dsc" => "You can change heading font style.",
            "id" => $this->wg24_a_title . "_body_sy_font_" . $this->wg24_t_title,
            "wg24" => array('face' => 'Roboto'),
            "fontsource" => "localfont",
            "type" => "fontscollectin");
        $wg24_get_values[] = array("name" => "Body Font to google",
            "dsc" => "You can change body font style.",
            "id" => $this->wg24_a_title . "_body_google_font_" . $this->wg24_t_title,
            "wg24" => array('face' => 'Roboto'),
            "fontsource" => "webfont",
            "type" => "fontscollectin");
        $wg24_get_values[] = array("name" => 'Font size',
            "dsc" => '',
            "id" => $this->wg24_a_title . "_body_size_font_" . $this->wg24_t_title,
            "wg24" => "14",
            "values" => array('12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Headers font",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Select font source',
            "dsc" => 'If you want to Select font source system/google.',
            "id" => $this->wg24_a_title . "_heders_select_font_" . $this->wg24_t_title,
            "wg24" => "show",
            "values" => array('show' => 'Google', 'hide' => 'System'),
            "type" => "select");
        $wg24_get_values[] = array("name" => "Heading Font to system",
            "dsc" => "You can change heading font style.",
            "id" => $this->wg24_a_title . "_heders_sys_font_" . $this->wg24_t_title,
            "wg24" => array('face' => 'Raleway'),
            "fontsource" => "localfont",
            "type" => "fontscollectin");
        $wg24_get_values[] = array("name" => "Heading Font to google",
            "dsc" => "You can change heading font style.",
            "id" => $this->wg24_a_title . "_heders_gol_font_" . $this->wg24_t_title,
            "wg24" => array('face' => 'Raleway'),
            "fontsource" => "webfont",
            "type" => "fontscollectin");
        /*         * ************************ Main menu **********************************  */
        $wg24_get_values[] = array("name" => 'Main Menu',
            "type" => "tabs_title");
        $wg24_get_values[] = array("name" => 'return & exchange page on header',
            "dsc" => 'Custom message  show page on header .',
            "id" => $this->wg24_a_title . '_ret_mheader_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'return & exchange  within 1 week validates',
            "type" => "textarea");
           $wg24_get_values[] = array("name" => 'First Parrent 1 Mega Menu Bottom Advertisment Banner 1',
            "dsc" => 'Custom Add  Show on first parrent mega menu .',
            "id" => $this->wg24_a_title . '_firstmegamenu1_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <div class="menubanner2">
                                                            <div class="menubanner2-inner">
                                                                <a href="">
                                                                    <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner1.png" alt="banner" />
                                                                    <div class="color-overlay"></div>
                                                                    <p>Bag</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="menubanner2">
                                                            <div class="menubanner2-inner">
                                                                <a href="">
                                                                    <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner2.png" alt="banner" />
                                                                    <div class="color-overlay"></div>
                                                                    <p>Bag</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="menubanner2">
                                                            <div class="menubanner2-inner">
                                                                <a href="">
                                                                    <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner3.png" alt="banner" />
                                                                    <div class="color-overlay"></div>
                                                                    <p>Bag</p>
                                                                </a>
                                                            </div>
                                                        </div>',
            "type" => "textarea");
            $wg24_get_values[] = array("name" => 'First Parrent 1 Mega Menu Right Advertisment Banner 1',
            "dsc" => 'Custom Add  Show on first parrent mega menu .',
            "id" => $this->wg24_a_title . '_firstmegamenu2_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<a class="menuban3" href="">
                        <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner4.png" alt="banner" />
                        <div class="color-overlay"></div>
                        <div class="mmenu-banner-text">
                            <div class="mmenu-banner-inner">
                                <h3>50% OFF StELL </h3>
                                <h2>samsung Gellaxy</h2>
                            </div>
                        </div>
                    </a>',
            "type" => "textarea");
            $wg24_get_values[] = array("name" => 'First Parrent 2 Mega Menu Bottom Advertisment Banner 2',
            "dsc" => 'Custom Add  Show on first parrent mega menu .',
            "id" => $this->wg24_a_title . '_firstmegamenu12_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <div class="menubanner2">
                                                            <div class="menubanner2-inner">
                                                                <a href="">
                                                                    <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner1.png" alt="banner" />
                                                                    <div class="color-overlay"></div>
                                                                    <p>Bag</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="menubanner2">
                                                            <div class="menubanner2-inner">
                                                                <a href="">
                                                                    <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner2.png" alt="banner" />
                                                                    <div class="color-overlay"></div>
                                                                    <p>Bag</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="menubanner2">
                                                            <div class="menubanner2-inner">
                                                                <a href="">
                                                                    <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner3.png" alt="banner" />
                                                                    <div class="color-overlay"></div>
                                                                    <p>Bag</p>
                                                                </a>
                                                            </div>
                                                        </div>',
            "type" => "textarea");
            $wg24_get_values[] = array("name" => 'First Parrent 2 Mega Menu Right Advertisment Banner 2',
            "dsc" => 'Custom Add  Show on first parrent mega menu .',
            "id" => $this->wg24_a_title . '_firstmegamenu22_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<a class="menuban3" href="">
                        <img src="'.$theme_image_pathe.'image/catalog/24wgdemo/category-page/menubanner/banner4.png" alt="banner" />
                        <div class="color-overlay"></div>
                        <div class="mmenu-banner-text">
                            <div class="mmenu-banner-inner">
                                <h3>50% OFF StELL </h3>
                                <h2>samsung Gellaxy</h2>
                            </div>
                        </div>
                    </a>',
            "type" => "textarea");
        
              $wg24_get_values[] = array("name" => 'Home 3 Custom Block',
            "dsc" => 'Home 3 Custom Block .',
            "id" => $this->wg24_a_title . '_mcostomblock_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <a href="">Custom Block<i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                            <ul class="mmenuffect">
                                                <li>
                                                    <ul class="row">
                                                        <li class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="custom-block-box">
                                                                <h2 class="custom-block-title">Custom Block 1</h2>
                                                                <div class="custom-block-content">
                                                                    <p class="dsc">
                                                                        <img alt="" src="'.$theme_image_pathe.'image/catalog/24wgdemo/our-team/img.png"> Lorem Ipsum has been the industrys standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrmbled it to make a type It survived not only five centuries, Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrmbled it to make a type It survived
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="custom-block-box">
                                                                <h2 class="custom-block-title">Custom Block 2</h2>
                                                                <div class="custom-block-content">
                                                                    <p class="dsc">
                                                                        <img alt="" src="'.$theme_image_pathe.'image/catalog/24wgdemo/our-team/img2.png"> Lorem Ipsum has been the industry s standard dummy text ever since the 1500s  when an unknown printer took a galley of type and scrmbled it to make a type It survived not only five centuries, Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrmbled it to make a type It survived
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                              
                                            </ul>',
            "type" => "textarea");
        
        
       
        /*         * ****************** Main menu **********************************  */
        $wg24_get_values[] = array("name" => 'Footer',
            "type" => "tabs_title");
        /*         * ******************  start footer custom column  **************** */

        $wg24_get_values[] = array("name" => "Footer Testimonial",
            "type" => "content-title");
       $wg24_get_values[] = array("name" => 'Testimonial slider page on footer top',
            "dsc" => 'Testimonial slider page on footer top',
            "id" => $this->wg24_a_title . "_home1testimonial_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' <div class="item-inner">
                                <div class="testi-img">
                                    <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/testimonial/image.png" alt="testimonial image" />
                                </div>
                                <div class="testi-content white">
                                    <p>Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a survived not only five but into electronic typesetting, remaining essentially unchanged.</p>
                                </div>
                                <h4 class="testi-title white"><span class="fa fa-tags">- jeck IPSUM -</span></h4>
                                <div class="testi-link">
                                    <a href="">http://24webgroup.com </a>
                                </div>
                            </div>
                            <div class="item-inner">
                                <div class="testi-img">
                                    <img src="' . $theme_image_pathe . 'image/catalog/24wgdemo/testimonial/image.png" alt="testimonial image" />
                                </div>
                                <div class="testi-content white">
                                    <p>Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a survived not only five but into electronic typesetting, remaining essentially unchanged.</p>
                                </div>
                                <div class="testi-title white"><span class="fa fa-tags">- jeck IPSUM -</span></div>
                                <div class="testi-link">
                                    <a href="">http://24webgroup.com </a>
                                </div>
                            </div>',
            "type" => "textarea"
        );
        
        $wg24_get_values[] = array("name" => "Footer Contact Information",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'About us info page on Footer ',
            "dsc" => "You can use this text box for showing footer contact info.",
            "id" => $this->wg24_a_title . "_footer_about_info_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '    <div class="footer-about">
                                    <h3 class="hadding-title">about us</h3>
                                    <div class="footer-content">
                                        <p>Lorem Ipsum has been the industrys the standard dumy text ever.....</p>
                                        <ul class="footer-address">
                                            <li>
                                                <i class="fa fa-map-marker"></i>
                                                <span class="location">R.F.L Tower Sodani 283</span>
                                            </li>
                                            <li>
                                                <i class="fa fa-skype"></i>
                                                <span class="skype">parallax</span>
                                            </li>
                                            <li>
                                                <i class="fa fa-envelope-o"></i>
                                                <span class="email">parallax@gmail.com</span>
                                            </li>
                                        </ul>
                                        <div class="footer-logo">
                                            <img src="' . $theme_image_pathe . 'catalog/view/theme/parallax/assets/image/footer-logo.png" alt="footer logo" />
                                        </div>
                                    </div>
                                </div>',
            "type" => "textarea");
        $wg24_get_values[] = array("name" => 'Footer support number',
            "dsc" => "You can use this text box for showing footer support number.",
            "id" => $this->wg24_a_title . "_footer_suppt_info_" . $this->wg24_t_title,
            "lang" => true,
            "wg24" => '<h2>1-800-806-6453</h2>
                <span class="skype_c2c_free_text_span"> FREE</span>
<p>Support <span>8:00</span> Am - <span>21:00</span> Pm</p>
',
            "type" => "textarea");
        $wg24_get_values[] = array("name" => "Twitter Feed Box",
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Twitter ID',
            "dsc" => "Put your Twitter username.",
            "id" => $this->wg24_a_title . "_twit_id_" . $this->wg24_t_title,
            "wg24" => "webgroup24",
            "type" => "text");
        $wg24_get_values[] = array("name" => 'Tweets to show',
            "dsc" => "Tweets count",
            "id" => $this->wg24_a_title . "_count_twitter_" . $this->wg24_t_title,
            "wg24" => "2",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Consumer key',
            "dsc" => "Put your Consumer key.",
            "id" => $this->wg24_a_title . "_twit_consu_key_" . $this->wg24_t_title,
            "wg24" => "RjCiufG4QlNsRpBndiA8fHxnj",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Consumer secret',
            "dsc" => "Put your Consumer secret.",
            "id" => $this->wg24_a_title . "_twit_consu_secrt_" . $this->wg24_t_title,
            "wg24" => "msyjufRGUdSNm4HmY2UmTy6PaoIx8BBlcnFnBLteHXmKCTezRk",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Access token',
            "dsc" => "Put your Access token.",
            "id" => $this->wg24_a_title . "_twit_uconsu_token_" . $this->wg24_t_title,
            "wg24" => "2469558338-du8gSKPX16LsiyC86BRzTYzHyKhMDjjDPEsVS0f",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Access token secret',
            "dsc" => "Put your Access token secret.",
            "id" => $this->wg24_a_title . "twit_uconsu_secret_" . $this->wg24_t_title,
            "wg24" => "v6Bn9YV1Uzn3OSHuptR9YGXb4bYAY0wXSOu3vo9X0wsU5",
            "type" => "block_text");


        /*         * *************** Start Social icon link  **********************************  */
        $wg24_get_values[] = array("name" => 'Social icons',
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Facebook URL',
            "dsc" => "put your facebook url.",
            "id" => $this->wg24_a_title . "_face_b_icon_url_" . $this->wg24_t_title,
            "wg24" => "http://demo.com",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Twitter URL',
            "dsc" => "Put your Twitter url.",
            "id" => $this->wg24_a_title . "_twitt_icon_url_" . $this->wg24_t_title,
            "wg24" => "http://demo.com",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'skype URL',
            "dsc" => "Put your youtube url.",
            "id" => $this->wg24_a_title . "_skype_icon_url_" . $this->wg24_t_title,
            "wg24" => "http://demo.com",
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Google URL',
            "dsc" => "Put your google url.",
            "id" => $this->wg24_a_title . "_google_icon_url_" . $this->wg24_t_title,
            "wg24" => "http://demo.com",
            "type" => "block_text");


        /*         * *********************  footer additional links      ********************************** */
        $wg24_get_values[] = array("name" => 'Powered by',
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'Copyright text',
            "dsc" => "You can use this text box for showing copyright text page on footer.",
            "id" => $this->wg24_a_title . "_footer_copy_text_" . $this->wg24_t_title,
            "wg24" => '  <p>CopyRight&copy; 2016 Design by <a href="http://24webgroup.com/">24WebGroup</a>. All Rights Reserved.</p>',
            "lang" => true,
            "type" => "textarea");

        /*         * *******************  payment box ************************ */
        $wg24_get_values[] = array("name" => 'Payment Icons links',
            "type" => "content-title");
        $wg24_get_values[] = array("name" => 'PayPal URL',
            "dsc" => "Put your PayPal url.",
            "id" => $this->wg24_a_title . "_fot_paypla_id_" . $this->wg24_t_title,
            "wg24" => 'http://paypal.com',
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'CC Stripe URL',
            "dsc" => "Put your VisaElectron url.",
            "id" => $this->wg24_a_title . "_fot_ccstripe_id_" . $this->wg24_t_title,
            "wg24" => 'http://maestrocard.com//',
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Visa URL',
            "dsc" => "Put your Visa url.",
            "id" => $this->wg24_a_title . "_fot_visa_id_" . $this->wg24_t_title,
            "wg24" => 'http://www.visa.com/',
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'MasterCard URL',
            "dsc" => "Put your MasterCard url.",
            "id" => $this->wg24_a_title . "_fot_mastercard_id_" . $this->wg24_t_title,
            "wg24" => 'http://www.mastercard.com',
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'AmericanExpress URL',
            "dsc" => "Put your AmericanExpress url.",
            "id" => $this->wg24_a_title . "_fot_americanexpress_id_" . $this->wg24_t_title,
            "wg24" => 'https://www.americanexpress.com/',
            "type" => "block_text");
        /*         * *******************  payment box ************************ */
        $wg24_get_values[] = array("name" => 'Upload Custom Payment icon',
            "type" => "content-title");

        $wg24_get_values[] = array("name" => 'Custom Payment icon 1',
            "dsc" => 'You can upload your custom payment icon.',
            "id" => $this->wg24_a_title . "_fot_paycon_1_" . $this->wg24_t_title,
            "wg24" => '',
            "type" => "upload");
        $wg24_get_values[] = array("name" => 'Custom Payment icon link 1',
            "dsc" => "Put your Custom Payment icon link 1 url.",
            "id" => $this->wg24_a_title . "_fot_cus_pay1_id_" . $this->wg24_t_title,
            "wg24" => 'https://www.demo.com/',
            "type" => "block_text");
        $wg24_get_values[] = array("name" => 'Custom Payment icon link 2',
            "dsc" => 'You can upload your custom payment icon.',
            "id" => $this->wg24_a_title . "_fot_paycon_2_" . $this->wg24_t_title,
            "wg24" => '',
            "type" => "upload");
        $wg24_get_values[] = array("name" => 'Custom Payment icon link 2',
            "dsc" => "Put your Custom Payment icon link 1 url.",
            "id" => $this->wg24_a_title . "_fot_cus_pay2_id_" . $this->wg24_t_title,
            "wg24" => 'https://www.demo.com/',
            "type" => "block_text");
        
         /*         * *******************************************  Custome code  **********************************  */
        $wg24_get_values[] = array("name" => 'Text Translation',
            "type" => "tabs_title");
            $wg24_get_values[] = array("name" => 'Search and Mobile menu Catgory text',
            "dsc" => 'Search and Mobile menu Catgory text page on header.',
            "id" => $this->wg24_a_title . '_t_category_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'categories',
            "type" => "text");
             $wg24_get_values[] = array("name" => 'Main menu home text',
            "dsc" => 'Main menu home text page on header.',
            "id" => $this->wg24_a_title . '_hometext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Home',
            "type" => "text");
                $wg24_get_values[] = array("name" => 'On All Product box Sale text',
            "dsc" => 'On All Product box Sale text.',
            "id" => $this->wg24_a_title . '_saletext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Sale',
            "type" => "text");
            $wg24_get_values[] = array("name" => 'On All Product box New text',
            "dsc" => 'On All Product box Sale text.',
            "id" => $this->wg24_a_title . '_newtext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'New',
            "type" => "text");
             $wg24_get_values[] = array("name" => 'On All Product box QuicView text',
            "dsc" => 'On All Product box Sale text.',
            "id" => $this->wg24_a_title . '_quicviewtext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'QuicView',
            "type" => "text");
            
              $wg24_get_values[] = array("name" => 'Popular Products text',
            "dsc" => 'Popular Products text.',
            "id" => $this->wg24_a_title . '_populartext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Most Popular',
            "type" => "text");
                $wg24_get_values[] = array("name" => 'Our Products text',
            "dsc" => 'Our Products text.',
            "id" => $this->wg24_a_title . '_home1ourpeocuttext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Our Products',
            "type" => "text");
            $wg24_get_values[] = array("name" => 'Latest Twitter text',
            "dsc" => 'Latest Twitter text.',
            "id" => $this->wg24_a_title . '_home1latesttext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'latest twitter',
            "type" => "text");
            $wg24_get_values[] = array("name" => 'Mini Product Best Sale  text',
            "dsc" => 'Best Sale  text.',
            "id" => $this->wg24_a_title . '_home1bestsaletext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Best Sale',
            "type" => "text");   
             $wg24_get_values[] = array("name" => 'Mini Product Top Rating  text',
            "dsc" => 'Mini Product Top .',
            "id" => $this->wg24_a_title . '_home1toprattingtext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Top Rating',
            "type" => "text");  
             $wg24_get_values[] = array("name" => 'Mini Product Special  text',
            "dsc" => 'Special  text.',
            "id" => $this->wg24_a_title . '_home1Specialtext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Special',
            "type" => "text");    
              $wg24_get_values[] = array("name" => 'New Products  text',
            "dsc" => 'New Products  text.',
            "id" => $this->wg24_a_title . '_home1newproducttext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'New Product',
            "type" => "text"); 
            $wg24_get_values[] = array("name" => 'Our Blog title text',
            "dsc" => 'Our Blog title  text',
            "id" => $this->wg24_a_title . '_home1blogtitletext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Our Blogs',
            "type" => "text"); 
             $wg24_get_values[] = array("name" => 'Blog text for top menu',
            "dsc" => 'Blog text for top menu',
            "id" => $this->wg24_a_title . '_blogtoptext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Blog',
            "type" => "text"); 
           
            $wg24_get_values[] = array("name" => 'Comments text in blog box',
            "dsc" => 'Comments text in blog box',
            "id" => $this->wg24_a_title . '_blogcommenttext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Comments',
            "type" => "text"); 
             $wg24_get_values[] = array("name" => 'Post by text in blog box',
            "dsc" => 'Post by text in blog box',
            "id" => $this->wg24_a_title . '_blogpostbttext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Post by',
            "type" => "text"); 
              $wg24_get_values[] = array("name" => 'Read More text in blog box',
            "dsc" => 'Read More text in blog box',
            "id" => $this->wg24_a_title . '_blogreadmoretext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Read More...',
            "type" => "text"); 
             $wg24_get_values[] = array("name" => ' flow Us  text for social icon',
            "dsc" => 'flow Us  text for social icon page on footer',
            "id" => $this->wg24_a_title . '_flowustext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => ' flow Us',
            "type" => "text"); 
           $wg24_get_values[] = array("name" => 'Newsletter text',
            "dsc" => 'Newsletter text page on footer Newslatter',
            "id" => $this->wg24_a_title . '_newslettertext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'newsletter',
            "type" => "text"); 
            $wg24_get_values[] = array("name" => 'Popular Tags text',
            "dsc" => 'Popular Tags',
            "id" => $this->wg24_a_title . '_populartexttext_' . $this->wg24_t_title,
            "lang" => true,
            "wg24" => 'Popular Tags',
            "type" => "text"); 
                   
                   
             
              

        /*         * *******************************************  Custome code  **********************************  */
        $wg24_get_values[] = array("name" => ' Custom code',
            "type" => "tabs_title");
        $wg24_get_values[] = array("name" => 'Add Tracking Code',
            "dsc" => 'You can add Google Analytics code/ another  tracking code on this  box.',
            "id" => $this->wg24_a_title . "_thme_track_codes_" . $this->wg24_t_title,
            "wg24" => "",
            "type" => "textarea");
        $wg24_get_values[] = array("name" => 'Add Custom CSS',
            "dsc" => 'Add custom css to show in your theme.',
            "id" => $this->wg24_a_title . "_them_custom_css_" . $this->wg24_t_title,
            "wg24" => '',
            "type" => "textarea");
        $wg24_get_values[] = array("name" => 'Add Custom  JS',
            "dsc" => 'Add custom js to show in your theme.',
            "id" => $this->wg24_a_title . "_them_custom_js_" . $this->wg24_t_title,
            "wg24" => '',
            "type" => "textarea");
        
        
        
       
        $this->wg24values = $wg24_get_values;
         return  $this->wg24values;
    }
    
         public  function wg24_administration_form() {
        global $cookie;
        $wg24_administration_fields = $this->wg24_administration_all_fields();
        $this->wg24_fields_data = $wg24_administration_fields[0];
        $this->wg24_get_tabs = $wg24_administration_fields[1];
        $this->_html .= '
<div class="wrapper">
            <div class="wg24-theme-administration-body-bg">
          <div id="wg24-popup-theme_patterns-save" class="wg24-pupup-message wg24-loading-img">
		<div class="for-button-save">Still Working  Please wait!</div>
	</div>
         <div id="wg24-popup-save" class="wg24-pupup-message fade1">
		<div class="for-button-save">Updated Theme Setting </div>
	</div>
        <form id="for_form" method="post"  enctype="multipart/form-data" >
                <div class="administration-heder-box">
                    <h1>Welcome To 24WebGroup Theme Editor  ' . $this->version . '</h1>
                    <div class="social-link">
                        <a  href="https://twitter.com/24webgroup/" class="flow-us_twitter"></a>
                        <a href="" class="theme-name"><h2>'.$this->ThemeName.'</h2></a>
                        <a href="http://themeforest.net/user/24webgroup" class="flow-is-themeforest"></a>
                    </div>

                </div>
                <div id="tabs">
                    <!-- ADDITIONAL -->
                    <ul class="tabs-product nav nav-tabs tab-menu">
                        ' . $this->wg24_get_tabs . ' 
                            
                    <button  type="submit" class="save-button save-button-bg top-button"> Save settings</button>
                    </ul>
                    <div class="admin_tabs_description tab-content">   
                        ' . $this->wg24_fields_data . ' 
                    </div>
                </div>
                <div class="admin-footer-box">
               
                    <button  type="submit" class="save-button save-button-bg "> Save settings</button>
                </div>
            </div>
          </form>
        </div>';
        return $this->_html;
    }
        
   public function wg24_administration_save_values($data) {
      $rss= $this->config->get($data);
        return  $rss;
    }
      
   public function displayFlags($languages, $default_language, $ids, $id, $return = false, $use_vars_instead_of_ids = false)
    {
        if (count($languages) == 1) {
            return false;
        }
        foreach ($languages as $language) {
           
             if ($language['language_id']==$default_language) {
             $output = '
		<div class="displayed_flag">
			<img src="language/'.$language['code'].'/'.$language['code'].'.png" class="pointer" id="language_current_'.$id.'" onclick="toggleLanguageFlags(this);" alt="" />
		</div>
		<div id="languages_'.$id.'" class="language_flags">
			Choose language:<br /><br />';
             
             }
            
            if ($use_vars_instead_of_ids) {
                $output .= '<img src="language/'.$language['code'].'/'.$language['code'].'.png" class="pointer" alt="'.$language['name'].'" title="'.$language['name'].'" onclick="changeLanguage(\''.$id.'\', '.$ids.', '.$language['language_id'].', \''.$language['code'].'\');" /> ';
            } else {
                $output .= '<img src="language/'.$language['code'].'/'.$language['code'].'.png" class="pointer" alt="'.$language['name'].'" title="'.$language['name'].'" onclick="changeLanguage(\''.$id.'\', \''.$ids.'\', '.$language['language_id'].', \''.$language['code'].'\');" /> ';
            }
        }
        $output .= '</div>';

        if ($return) {
            return $output;
        }
        echo $output;
    }

     
    public function wg24_administration_all_fields() {
        $wg24values = $this->wg24values;
        $wg24_administration_data = array();
        $wg24_tabs = '';
        $wg24_count_data = 0;
        $wg24_fields_result = '';
        foreach ($wg24values as $wg24_output) {
            $wg24_count_data++;
            if ($wg24_output['type'] != "tabs_title") {
                $tabs_title_class = '';
                if (isset($wg24_output['class'])) {
                    $tabs_title_class = $wg24_output['class'];
                }
                $wg24_fields_result .= '<div class="fieldupload  field-' . $wg24_output['type'] . ' ' . $tabs_title_class . '">';

                if ($wg24_output['type'] != "content-title") {
                    if (isset($wg24_output['name']))
                        $wg24_fields_result .= '<h2 class="tabs_title">' . $wg24_output['name'] . '</h2>';
                }else {
                    $wg24_fields_result .= '<h2 class="content-title">' . $wg24_output['name'] . '</h2>';
                }
                if (isset($wg24_output['sub_name']))
                    $wg24_fields_result .= '<h2>' . $wg24_output['sub_name'] . '</h2>';

                $wg24_fields_result .= '<div class="option">';
                    $wg24_fields_result .= '<div class="manage managefull">';
               
            }
            switch ($wg24_output['type']) {
                case 'text':
                    $type_value = '';

                    if (isset($wg24_output['values'])) {
                        $text_option = $wg24_output['values'];
                        if (isset($text_option['cols'])) {
                            $cols = $text_option['cols'];
                        }
                    }
                    $defaultLanguage = (int) ($this->config->get('config_language_id'));
                    $divLangName = $wg24_output['id'];

                    if (isset($wg24_output['lang']) && $wg24_output['lang'] == true)
                        $wg_24 = $this->wg24_administration_save_values($wg24_output['id'] . '_' . $defaultLanguage);
                    else
                        $wg_24 = $this->wg24_administration_save_values($wg24_output['id']);
                    if ($wg_24 != "") {
                        $type_value = stripslashes($wg_24);
                    }
                    $languages = $this->model_localisation_language->getLanguages();
                    if (isset($wg24_output['lang']) && $wg24_output['lang'] == true):
                        foreach ($languages as $langua) {
                            $wg_24 = $this->wg24_administration_save_values($wg24_output['id'] . '_' . $langua['language_id']);
                            if ($wg_24 != "") {
                                $type_value = stripslashes($wg_24);
                            }
                            $wg24_fields_result .='<div id="' . $wg24_output['id'] . '_' . $langua['language_id'] . '" style="display: ' . ($langua['language_id'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $wg24_fields_result .= '<input class="wg24-input" name="' . $wg24_output['id'] . '_' . $langua['language_id'] . '" id="' . $wg24_output['id'] . '_' . $langua['language_id'] . '" value="' . $type_value . '" />';
                            $wg24_fields_result .= '</div>';
                        }
                      $wg24_fields_result .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $wg24_output['id'], true);
                        
                    else:
                        $wg_24 = $this->wg24_administration_save_values($wg24_output['id']);
                        if ($wg_24 != "") {
                            $type_value = stripslashes($wg_24);
                        }
                        $wg24_fields_result .= '<input class="wg24-input" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '" value="' . $type_value . '" />';
                    endif;
                    break;
                case 'textarea':
                    $cols = '11';
                    $type_value = '';
                    $defaultLanguage = (int) ($this->config->get('config_language_id'));
                    $divLangName = $wg24_output['id'];
                    if (isset($wg24_output['lang']) && $wg24_output['lang'] == true)
                        $wg24 = $this->wg24_administration_save_values($wg24_output['id'] . '_' . $defaultLanguage);
                    else
                        $wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                    if ($wg24 != "") {
                        $type_value = stripslashes($wg24);
                    }
                    $languages = $this->model_localisation_language->getLanguages();
                    if (isset($wg24_output['lang']) && $wg24_output['lang'] == true):
                        foreach ($languages as $langua) {
                            $wg24 = $this->wg24_administration_save_values($wg24_output['id'] . '_' . $langua['language_id']);
                            if ($wg24 != "") {
                                $type_value = stripslashes($wg24);
                            }
                            $wg24_fields_result .='<div id="' . $wg24_output['id'] . '_' . $langua['language_id'] . '" style="display: ' . ($langua['language_id'] == $defaultLanguage ? 'block' : 'none') . ';float: left;">';
                            $wg24_fields_result .= '<textarea class="wg24-input" name="' . $wg24_output['id'] . '_' . $langua['language_id'] . '" id="' . $wg24_output['id'] . '_' . $langua['language_id'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                            $wg24_fields_result .= '</div>';
                        }
                         $wg24_fields_result .=$this->displayFlags($languages, $defaultLanguage, $divLangName, $wg24_output['id'], true);
                        
                    else:
                        $wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                        if ($wg24 != "") {
                            $type_value = stripslashes($wg24);
                        }
                        $wg24_fields_result .= '<textarea class="wg24-input" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '" cols="' . $cols . '" rows="8">' . $type_value . '</textarea>';
                    endif;
                    break;
                case "radio":
                    $selected_value = $this->wg24_administration_save_values($wg24_output['id']);
                    foreach ($wg24_output['values'] as $option_val => $name) {
                        $checked = '';
                        if ($selected_value = '') {
                            if ($selected_value == $option_val) {
                                $checked = ' checked';
                            }
                        } else {

                            if ($wg24_output['wg24'] == $option_val) {
                                $checked = ' checked';
                            }
                        }
                        $wg24_fields_result .= '<input class="wg24-input of-radio" name="' . $wg24_output['id'] . '" type="radio" value="' . $option_val . '" ' . $checked . ' /><label class="radio">' . $name . '</label><br/>';
                    }
                    break;
                case 'block_text':
                    $type_value = $this->wg24_administration_save_values($wg24_output['id']);
                    $wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                    if ($wg24 != "") {
                        $type_value = stripslashes($wg24);
                    }
                    $wg24_fields_result .= '<input class="wg24-input" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '" type="' . $wg24_output['type'] . '" value="' . $type_value . '" />';
                    break;

                case 'upload':
                    $wg24_fields_result .= $this->wg24_add_image($wg24_output['id'], $wg24_output['wg24']);
                    break;
                case 'checkbox':
                    if (!isset($wg24_administration_data[$wg24_output['id']])) {
                        $wg24_administration_data[$wg24_output['id']] = 0;
                    }
                    $get_wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                    $wg24 = $wg24_output['wg24'];
                    $checked = '';
                    if (!empty($get_wg24)) {
                        if ($get_wg24 == '1') {
                            $checked = 'checked="checked"';
                        } else {
                            $checked = '';
                        }
                    } elseif ($wg24 == '1') {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    $wg24_fields_result .= '<input type="hidden" class="' . 'checkbox aq-input" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '" value="0"/>';
                    $wg24_fields_result .= '<input type="checkbox" class="' . 'checkbox wg24-input" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '" value="1" ' . $checked . ' />';
                    break;
                case 'color':
                    $type_value = '';
                    $wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                    if ($wg24 != "") {
                        $type_value = stripslashes($wg24);
                    }
                    $wg24_fields_result .= '<div id="' . $wg24_output['id'] . '_picker" class="selectColor"><div style="background-color: ' . $type_value . '"></div></div>';
                    $wg24_fields_result .= '<input class="of-color" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '" type="text" value="' . $type_value . '" />';
                    break;
                case 'select':
                    $wg24_fields_result .= '<div class="for-body-selected">';
                    $wg24_fields_result .= '<select class="of-typography of-typography-size select" name="' . $wg24_output['id'] . '" id="' . $wg24_output['id'] . '">';
                    foreach ($wg24_output['values'] as $select_key => $option_val) {
                        $selected_value = $this->wg24_administration_save_values($wg24_output['id']);
                        if ($selected_value != '') {
                            if ($selected_value == $select_key) {
                                $selected_value = ' selected="selected"';
                            }
                        } else {
                            if ($wg24_output['wg24'] == $select_key) {
                                $selected_value = ' selected="selected"';
                            }
                        }
                        $wg24_fields_result .= '<option id="' . $select_key . '" value="' . $select_key . '" ' . $selected_value . ' />' . $option_val . '</option>';
                    }
                    $wg24_fields_result .= '</select></div>';
                    break;
                case 'fontscollectin':
                    $get_face = $this->wg24_administration_save_values($wg24_output['id'] . '_face');
                    $selectsourcefont = $wg24_output['wg24'];
                    if (isset($selectsourcefont['face'])) {
                        $wg24_fields_result .= '<div class="for-body-selected typography-face" original-title="Font family">';
                        $wg24_fields_result .= '<select class="of-typography of-typography-face select" name="' . $wg24_output['id'] . '[face]" id="' . $wg24_output['id'] . '_face">';

                        $localfonts = array('Roboto' => 'Roboto','Raleway' => 'Raleway', 'Source Sans Pro' => 'Source Sans Pro', 'Open Sans' => 'Open Sans', 'Arial,Helvetica' => 'Arial, Helvetica', 'Geneva' => 'Geneva', 'Helvetica,sans-serif' => 'Helvetica, sans-serif', 'Times New Roman' => 'Times New Roman', 'Times,serif' => 'Times, serif', 'PT+Sans' => 'PT Sans', 'monospace' => 'monospace', 'Georgia,serif' => 'Georgia,Times, serif', 'Verdana' => 'Verdana', 'Oswald' => 'Oswald', 'Telex' => 'Telex', 'Iceberg' => 'Iceberg', 'Yanone Kaffeesatz' => 'Yanone Kaffeesatz ExtraLight', 'tahoma' => 'Tahoma, Geneva', 'Amethysta' => 'Amethysta', 'Courier New,Courier' => 'Courier New, Courier', 'Gudea' => 'Gudea', 'Duru Sans' => 'Duru Sans', 'Germania One' => 'Germania One', 'Macondo Swash Caps' => 'Macondo Swash Caps');
                        $google_web_fonts = array("calibrib" => "calibrib",
                            "Abel" => "Abel",
                            "Abril Fatface" => "Abril Fatface",
                            "Aclonica" => "Aclonica",
                            "Acme" => "Acme",
                            "Actor" => "Actor",
                            "Adamina" => "Adamina",
                            "Advent Pro" => "Advent Pro",
                            "Aguafina Script" => "Aguafina Script",
                            "Akronim" => "Akronim",
                            "Aladin" => "Aladin",
                            "Aldrich" => "Aldrich",
                            "Alegreya" => "Alegreya",
                            "Alegreya SC" => "Alegreya SC",
                            "Alex Brush" => "Alex Brush",
                            "Alfa Slab One" => "Alfa Slab One",
                            "Alice" => "Alice",
                            "Alike" => "Alike",
                            "Alike Angular" => "Alike Angular",
                            "Allan" => "Allan",
                            "Allerta" => "Allerta",
                            "Allerta Stencil" => "Allerta Stencil",
                            "Allura" => "Allura",
                            "Almendra" => "Almendra",
                            "Almendra Display" => "Almendra Display",
                            "Almendra SC" => "Almendra SC",
                            "Amarante" => "Amarante",
                            "Amaranth" => "Amaranth",
                            "Amatic SC" => "Amatic SC",
                            "Amethysta" => "Amethysta",
                            "Anaheim" => "Anaheim",
                            "Andada" => "Andada",
                            "Andika" => "Andika",
                            "Angkor" => "Angkor",
                            "Annie Use Your Telescope" => "Annie Use Your Telescope",
                            "Anonymous Pro" => "Anonymous Pro",
                            "Antic" => "Antic",
                            "Antic Didone" => "Antic Didone",
                            "Antic Slab" => "Antic Slab",
                            "Anton" => "Anton",
                            "Arapey" => "Arapey",
                            "Arbutus" => "Arbutus",
                            "Arbutus Slab" => "Arbutus Slab",
                            "Architects Daughter" => "Architects Daughter",
                            "Archivo Black" => "Archivo Black",
                            "Archivo Narrow" => "Archivo Narrow",
                            "Arimo" => "Arimo",
                            "Arizonia" => "Arizonia",
                            "Armata" => "Armata",
                            "Artifika" => "Artifika",
                            "Arvo" => "Arvo",
                            "Asap" => "Asap",
                            "Asset" => "Asset",
                            "Astloch" => "Astloch",
                            "Asul" => "Asul",
                            "Atomic Age" => "Atomic Age",
                            "Aubrey" => "Aubrey",
                            "Audiowide" => "Audiowide",
                            "Autour One" => "Autour One",
                            "Average" => "Average",
                            "Average Sans" => "Average Sans",
                            "Averia Gruesa Libre" => "Averia Gruesa+Libre",
                            "Averia Libre" => "Averia+Libre",
                            "Averia Sans Libre" => "Averia Sans Libre",
                            "Averia Serif Libre" => "Averia Serif Libre",
                            "Bad Script" => "Bad+Script",
                            "Balthazar" => "Balthazar",
                            "Bangers" => "Bangers",
                            "Basic" => "Basic",
                            "Battambang" => "Battambang",
                            "Baumans" => "Baumans",
                            "Bayon" => "Bayon",
                            "Belgrano" => "Belgrano",
                            "Belleza" => "Belleza",
                            "BenchNine" => "BenchNine",
                            "Bentham" => "Bentham",
                            "Berkshire Swash" => "Berkshire Swash",
                            "Bevan" => "Bevan",
                            "Bigelow Rules" => "Bigelow Rules",
                            "Bigshot One" => "Bigshot One",
                            "Bilbo" => "Bilbo",
                            "Bilbo Swash Caps" => "Bilbo Swash Caps",
                            "Bitter" => "Bitter",
                            "Black Ops One" => "Black Ops One",
                            "Bokor" => "Bokor",
                            "Bonbon" => "Bonbon",
                            "Boogaloo" => "Boogaloo",
                            "Bowlby One" => "Bowlby One",
                            "Bowlby One SC" => "Bowlby One SC",
                            "Brawler" => "Brawler",
                            "Bree Serif" => "Bree Serif",
                            "Bubblegum Sans" => "Bubblegum Sans",
                            "Bubbler One" => "Bubbler One",
                            "Buda" => "Buda",
                            "Buenard" => "Buenard",
                            "Butcherman" => "Butcherman",
                            "Butterfly Kids" => "Butterfly Kids",
                            "Cabin" => "Cabin",
                            "Cabin Condensed" => "Cabin Condensed",
                            "Cabin Sketch" => "Cabin Sketch",
                            "Caesar Dressing" => "Caesar Dressing",
                            "Cagliostro" => "Cagliostro",
                            "Calligraffitti" => "Calligraffitti",
                            "Cambo" => "Cambo",
                            "Candal" => "Candal",
                            "Cantarell" => "Cantarell",
                            "Cantata One" => "Cantata One",
                            "Cantora One" => "Cantora One",
                            "Capriola" => "Capriola",
                            "Cardo" => "Cardo",
                            "Carme" => "Carme",
                            "Carrois Gothic" => "Carrois Gothic",
                            "Carrois Gothic SC" => "Carrois Gothic SC",
                            "Carter One" => "Carter One",
                            "Caudex" => "Caudex",
                            "Cedarville Cursive" => "Cedarville Cursive",
                            "Ceviche One" => "Ceviche One",
                            "Changa One" => "Changa One",
                            "Chango" => "Chango",
                            "Chau Philomene One" => "Chau Philomene One",
                            "Chela One" => "Chela One",
                            "Chelsea Market" => "Chelsea Market",
                            "Chenla" => "Chenla",
                            "Cherry Cream Soda" => "Cherry Cream Soda",
                            "Cherry Swash" => "Cherry Swash",
                            "Chewy" => "Chewy",
                            "Chicle" => "Chicle",
                            "Chivo" => "Chivo",
                            "Cinzel" => "Cinzel",
                            "Cinzel Decorative" => "Cinzel Decorative",
                            "Clicker Script" => "Clicker Script",
                            "Coda" => "Coda",
                            "Coda Caption" => "Coda Caption",
                            "Codystar" => "Codystar",
                            "Combo" => "Combo",
                            "Comfortaa" => "Comfortaa",
                            "Coming Soon" => "Coming Soon",
                            "Concert One" => "Concert One",
                            "Condiment" => "Condiment",
                            "Content" => "Content",
                            "Contrail One" => "Contrail One",
                            "Convergence" => "Convergence",
                            "Cookie" => "Cookie",
                            "Copse" => "Copse",
                            "Corben" => "Corben",
                            "Courgette" => "Courgette",
                            "Cousine" => "Cousine",
                            "Coustard" => "Coustard",
                            "Covered By Your Grace" => "Covered By Your Grace",
                            "Crafty Girls" => "Crafty Girls",
                            "Creepster" => "Creepster",
                            "Crete Round" => "Crete Round",
                            "Crimson Text" => "Crimson Text",
                            "Croissant One" => "Croissant One",
                            "Crushed" => "Crushed",
                            "Cuprum" => "Cuprum",
                            "Cutive" => "Cutive",
                            "Cutive Mono" => "Cutive Mono",
                            "Damion" => "Damion",
                            "Dancing Script" => "Dancing Script",
                            "Dangrek" => "Dangrek",
                            "Dawning of a New Day" => "Dawning of a NewDay",
                            "Days One" => "Days One",
                            "Delius" => "Delius",
                            "Delius Swash Caps" => "Delius Swash Caps",
                            "Delius Unicase" => "Delius Unicase",
                            "Della Respira" => "Della Respira",
                            "Denk One" => "Denk One",
                            "Devonshire" => "Devonshire",
                            "Didact Gothic" => "Didact Gothic",
                            "Diplomata" => "Diplomata",
                            "Diplomata SC" => "Diplomata SC",
                            "Domine" => "Domine",
                            "Donegal One" => "Donegal One",
                            "Doppio One" => "Doppio One",
                            "Dorsa" => "Dorsa",
                            "Dosis" => "Dosis",
                            "Dr Sugiyama" => "Dr Sugiyama",
                            "Droid Sans" => "Droid Sans",
                            "Droid Sans Mono" => "Droid Sans Mono",
                            "Droid Serif" => "Droid Serif",
                            "Duru Sans" => "Duru Sans",
                            "Dynalight" => "Dynalight",
                            "EB Garamond" => "EB Garamond",
                            "Eagle Lake" => "Eagle Lake",
                            "Eater" => "Eater",
                            "Economica" => "Economica",
                            "Electrolize" => "Electrolize",
                            "Elsie" => "Elsie",
                            "Elsie Swash Caps" => "Elsie Swash Caps",
                            "Emblema One" => "Emblema One",
                            "Emilys Candy" => "Emilys Candy",
                            "Engagement" => "Engagement",
                            "Englebert" => "Englebert",
                            "Enriqueta" => "Enriqueta",
                            "Erica One" => "Erica One",
                            "Esteban" => "Esteban",
                            "Euphoria Script" => "Euphoria Script",
                            "Ewert" => "Ewert",
                            "Exo" => "Exo",
                            "Expletus Sans" => "Expletus Sans",
                            "Fanwood Text" => "Fanwood Text",
                            "Fascinate" => "Fascinate",
                            "Fascinate Inline" => "Fascinate Inline",
                            "Faster One" => "Faster One",
                            "Fasthand" => "Fasthand",
                            "Federant" => "Federant",
                            "Federo" => "Federo",
                            "Felipa" => "Felipa",
                            "Fenix" => "Fenix",
                            "Finger Paint" => "Finger Paint",
                            "Fjalla One" => "Fjalla One",
                            "Fjord One" => "Fjord One",
                            "Flamenco" => "Flamenco",
                            "Flavors" => "Flavors",
                            "Fondamento" => "Fondamento",
                            "Fontdiner Swanky" => "Fontdiner Swanky",
                            "Forum" => "Forum",
                            "Francois One" => "Francois One",
                            "Freckle Face" => "Freckle Face",
                            "Fredericka the Great" => "Fredericka the Great",
                            "Fredoka One" => "Fredoka One",
                            "Freehand" => "Freehand",
                            "Fresca" => "Fresca",
                            "Frijole" => "Frijole",
                            "Fruktur" => "Fruktur",
                            "Fugaz One" => "Fugaz One",
                            "GFS Didot" => "GFS Didot",
                            "GFS Neohellenic" => "GFS Neohellenic",
                            "Gabriela" => "Gabriela",
                            "Gafata" => "Gafata",
                            "Galdeano" => "Galdeano",
                            "Galindo" => "Galindo",
                            "Gentium Basic" => "Gentium Basic",
                            "Gentium Book Basic" => "Gentium Book Basic",
                            "Geo" => "Geo",
                            "Geostar" => "Geostar",
                            "Geostar Fill" => "Geostar Fill",
                            "Germania One" => "Germania One",
                            "Gilda Display" => "Gilda Display",
                            "Give You Glory" => "Give You Glory",
                            "Glass Antiqua" => "Glass Antiqua",
                            "Glegoo" => "Glegoo",
                            "Gloria Hallelujah" => "Gloria Hallelujah",
                            "Goblin One" => "Goblin One",
                            "Gochi Hand" => "Gochi Hand",
                            "Gorditas" => "Gorditas",
                            "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
                            "Graduate" => "Graduate",
                            "Grand Hotel" => "Grand+Hotel",
                            "Gravitas One" => "Gravitas One",
                            "Great Vibes" => "Great Vibes",
                            "Griffy" => "Griffy",
                            "Gruppo" => "Gruppo",
                            "Gudea" => "Gudea",
                            "Habibi" => "Habibi",
                            "Hammersmith One" => "Hammersmith One",
                            "Hanalei" => "Hanalei",
                            "Hanalei Fill" => "Hanalei Fill",
                            "Handlee" => "Handlee",
                            "Hanuman" => "Hanuman",
                            "Happy Monkey" => "Happy Monkey",
                            "Headland One" => "Headland One",
                            "Henny Penny" => "Henny Penny",
                            "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
                            "Holtwood One SC" => "Holtwood One SC",
                            "Homemade Apple" => "Homemade Apple",
                            "Homenaje" => "Homenaje",
                            "IM Fell DW Pica" => "IM Fell DW Pica",
                            "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
                            "IM Fell Double Pica" => "IM Fell Double Pica",
                            "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
                            "IM Fell English" => "IM Fell English",
                            "IM Fell English SC" => "IM Fell English SC",
                            "IM Fell French Canon" => "IM Fell French Canon",
                            "IM Fell French Canon SC" => "IM Fell French Canon SC",
                            "IM Fell Great Primer" => "IM Fell Great Primer",
                            "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
                            "Iceberg" => "Iceberg",
                            "Iceland" => "Iceland",
                            "Imprima" => "Imprima",
                            "Inconsolata" => "Inconsolata",
                            "Inder" => "Inder",
                            "Indie Flower" => "Indie Flower",
                            "Inika" => "Inika",
                            "Irish Grover" => "Irish Grover",
                            "Istok Web" => "Istok Web",
                            "Italiana" => "Italiana",
                            "Italianno" => "Italianno",
                            "Jacques Francois" => "Jacques Francois",
                            "Jacques Francois Shadow" => "Jacques Francois Shadow",
                            "Jim Nightshade" => "Jim Nightshade",
                            "Jockey One" => "Jockey One",
                            "Jolly Lodger" => "Jolly Lodger",
                            "Josefin Sans" => "Josefin Sans",
                            "Josefin Slab" => "Josefin Slab",
                            "Joti One" => "Joti One",
                            "Judson" => "Judson",
                            "Julee" => "Julee",
                            "Julius Sans One" => "Julius Sans One",
                            "Junge" => "Junge",
                            "Jura" => "Jura",
                            "Just Another Hand" => "Just Another Hand",
                            "Just Me Again Down Here" => "Just Me Again Down Here",
                            "Kameron" => "Kameron",
                            "Karla" => "Karla",
                            "Kaushan Script" => "Kaushan Script",
                            "Kavoon" => "Kavoon",
                            "Keania One" => "Keania One",
                            "Kelly Slab" => "Kelly Slab",
                            "Kenia" => "Kenia",
                            "Khmer" => "Khmer",
                            "Kite One" => "Kite One",
                            "Knewave" => "Knewave",
                            "Kotta One" => "Kotta One",
                            "Koulen" => "Koulen",
                            "Kranky" => "Kranky",
                            "Kreon" => "Kreon",
                            "Kristi" => "Kristi",
                            "Krona One" => "Krona One",
                            "La Belle Aurore" => "La Belle Aurore",
                            "Lancelot" => "Lancelot",
                            "Lato" => "Lato",
                            "League Script" => "League Script",
                            "Leckerli One" => "Leckerli One",
                            "Ledger" => "Ledger",
                            "Lekton" => "Lekton",
                            "Lemon" => "Lemon",
                            "Libre Baskerville" => "Libre Baskerville",
                            "Life Savers" => "Life Savers",
                            "Lilita One" => "Lilita One",
                            "Limelight" => "Limelight",
                            "Linden Hill" => "Linden Hill",
                            "Lobster" => "Lobster",
                            "Lobster Two" => "Lobster Two",
                            "Londrina Outline" => "Londrina Outline",
                            "Londrina Shadow" => "Londrina Shadow",
                            "Londrina Sketch" => "Londrina Sketch",
                            "Londrina Solid" => "Londrina Solid",
                            "Lora" => "Lora",
                            "Love Ya Like A Sister" => "Love Ya Like A Sister",
                            "Loved by the King" => "Loved by the King",
                            "Lovers Quarrel" => "Lovers Quarrel",
                            "Luckiest Guy" => "Luckiest Guy",
                            "Lusitana" => "Lusitana",
                            "Lustria" => "Lustria",
                            "Macondo" => "Macondo",
                            "Macondo Swash Caps" => "Macondo Swash Caps",
                            "Magra" => "Magra",
                            "Maiden Orange" => "Maiden Orange",
                            "Mako" => "Mako",
                            "Marcellus" => "Marcellus",
                            "Marcellus SC" => "Marcellus SC",
                            "Marck Script" => "Marck Script",
                            "Margarine" => "Margarine",
                            "Marko One" => "Marko One",
                            "Marmelad" => "Marmelad",
                            "Marvel" => "Marvel",
                            "Mate" => "Mate",
                            "Mate SC" => "Mate SC",
                            "Maven Pro" => "Maven Pro",
                            "McLaren" => "McLaren",
                            "Meddon" => "Meddon",
                            "MedievalSharp" => "MedievalSharp",
                            "Medula One" => "Medula One",
                            "Megrim" => "Megrim",
                            "Meie Script" => "Meie Script",
                            "Merienda" => "Merienda",
                            "Merienda One" => "Merienda One",
                            "Merriweather" => "Merriweather",
                            "Merriweather Sans" => "Merriweather Sans",
                            "Metal" => "Metal",
                            "Metal Mania" => "Metal Mania",
                            "Metamorphous" => "Metamorphous",
                            "Metrophobic" => "Metrophobic",
                            "Michroma" => "Michroma",
                            "Milonga" => "Milonga",
                            "Miltonian" => "Miltonian",
                            "Miltonian Tattoo" => "Miltonian Tattoo",
                            "Miniver" => "Miniver",
                            "Miss Fajardose" => "Miss Fajardose",
                            "Modern Antiqua" => "Modern Antiqua",
                            "Molengo" => "Molengo",
                            "Molle" => "Molle",
                            "Monda" => "Monda",
                            "Monofett" => "Monofett",
                            "Monoton" => "Monoton",
                            "Monsieur La Doulaise" => "Monsieur La Doulaise",
                            "Montaga" => "Montaga",
                            "Montez" => "Montez",
                            "Montserrat" => "Montserrat",
                            "Montserrat Alternates" => "Montserrat Alternates",
                            "Montserrat Subrayada" => "Montserrat Subrayada",
                            "Moul" => "Moul",
                            "Moulpali" => "Moulpali",
                            "Mountains of Christmas" => "Mountains of Christmas",
                            "Mouse Memoirs" => "Mouse Memoirs",
                            "Mr Bedfort" => "Mr Bedfort",
                            "Mr Dafoe" => "Mr Dafoe",
                            "Mr De Haviland" => "Mr De Haviland",
                            "Mrs Saint Delafield" => "Mrs Saint Delafield",
                            "Mrs Sheppards" => "Mrs Sheppards",
                            "Muli" => "Muli",
                            "Mystery Quest" => "Mystery Quest",
                            "Neucha" => "Neucha",
                            "Neuton" => "Neuton",
                            "New Rocker" => "New Rocker",
                            "News Cycle" => "News Cycle",
                            "Niconne" => "Niconne",
                            "Nixie One" => "Nixie One",
                            "Nobile" => "Nobile",
                            "Nokora" => "Nokora",
                            "Norican" => "Norican",
                            "Nosifer" => "Nosifer",
                            "Nothing You Could Do" => "Nothing You Could Do",
                            "Noticia Text" => "Noticia Text",
                            "Nova Cut" => "Nova Cut",
                            "Nova Flat" => "Nova Flat",
                            "Nova Mono" => "Nova Mono",
                            "Nova Oval" => "Nova Oval",
                            "Nova Round" => "Nova Round",
                            "Nova Script" => "Nova Script",
                            "Nova Slim" => "Nova Slim",
                            "Nova Square" => "Nova Square",
                            "Numans" => "Numans",
                            "Nunito" => "Nunito",
                            "Odor Mean Chey" => "Odor Mean Chey",
                            "Offside" => "Offside",
                            "Old Standard TT" => "Old Standard TT",
                            "Oldenburg" => "Oldenburg",
                            "Oleo Script" => "Oleo Script",
                            "Oleo Script Swash Caps" => "Oleo Script Swash Caps",
                            "Open Sans" => "Open Sans",
                            "Open Sans Condensed" => "Open Sans Condensed",
                            "Oranienbaum" => "Oranienbaum",
                            "Orbitron" => "Orbitron",
                            "Oregano" => "Oregano",
                            "Orienta" => "Orienta",
                            "Original Surfer" => "Original Surfer",
                            "Oswald" => "Oswald",
                            "Over the Rainbow" => "Over the Rainbow",
                            "Overlock" => "Overlock",
                            "Overlock SC" => "Overlock SC",
                            "Ovo" => "Ovo",
                            "Oxygen" => "Oxygen",
                            "Oxygen Mono" => "Oxygen Mono",
                            "PT Mono" => "PT Mono",
                            "PT Sans" => "PT Sans",
                            "PT Sans Caption" => "PT Sans Caption",
                            "PT Sans Narrow" => "PT Sans Narrow",
                            "PT Serif" => "PT Serif",
                            "PT Serif Caption" => "PT Serif Caption",
                            "Pacifico" => "Pacifico",
                            "Paprika" => "Paprika",
                            "Parisienne" => "Parisienne",
                            "Passero One" => "Passero One",
                            "Passion One" => "Passion One",
                            "Patrick Hand" => "Patrick Hand",
                            "Patrick Hand SC" => "Patrick Hand SC",
                            "Patua One" => "Patua One",
                            "Paytone One" => "Paytone One",
                            "Peralta" => "Peralta",
                            "Permanent Marker" => "Permanent Marker",
                            "Petit Formal Script" => "Petit Formal Script",
                            "Petrona" => "Petrona",
                            "Philosopher" => "Philosopher",
                            "Piedra" => "Piedra",
                            "Pinyon Script" => "Pinyon Script",
                            "Pirata One" => "Pirata One",
                            "Plaster" => "Plaster",
                            "Play" => "Play",
                            "Playball" => "Playball",
                            "Playfair Display" => "Playfair Display",
                            "Playfair Display SC" => "Playfair Display SC",
                            "Podkova" => "Podkova",
                            "Poiret One" => "Poiret One",
                            "Poller One" => "Poller One",
                            "Poly" => "Poly",
                            "Pompiere" => "Pompiere",
                            "Pontano Sans" => "Pontano Sans",
                            "Port Lligat Sans" => "Port Lligat Sans",
                            "Port Lligat Slab" => "Port Lligat Slab",
                            "Prata" => "Prata",
                            "Preahvihear" => "Preahvihear",
                            "Press Start 2P" => "Press Start 2P",
                            "Princess Sofia" => "Princess Sofia",
                            "Prociono" => "Prociono",
                            "Prosto One" => "Prosto One",
                            "Puritan" => "Puritan",
                            "Purple Purse" => "Purple Purse",
                            "Quando" => "Quando",
                            "Quantico" => "Quantico",
                            "Quattrocento" => "Quattrocento",
                            "Quattrocento Sans" => "Quattrocento Sans",
                            "Questrial" => "Questrial",
                            "Quicksand" => "Quicksand",
                            "Quintessential" => "Quintessential",
                            "Qwigley" => "Qwigley",
                            "Racing Sans One" => "Racing Sans One",
                            "Radley" => "Radley",
                            "Raleway" => "Raleway",
                            "Raleway Dots" => "Raleway Dots",
                            "Rambla" => "Rambla",
                            "Rammetto One" => "Rammetto One",
                            "Ranchers" => "Ranchers",
                            "Rancho" => "Rancho",
                            "Rationale" => "Rationale",
                            "Redressed" => "Redressed",
                            "Reenie Beanie" => "Reenie Beanie",
                            "Revalia" => "Revalia",
                            "Ribeye" => "Ribeye",
                            "Ribeye Marrow" => "Ribeye+Marrow",
                            "Righteous" => "Righteous",
                            "Risque" => "Risque",
                            "Roboto" => "Roboto",
                            "Roboto Condensed" => "Roboto+Condensed",
                            "Rochester" => "Rochester",
                            "Rock Salt" => "Rock Salt",
                            "Rokkitt" => "Rokkitt",
                            "Romanesco" => "Romanesco",
                            "Ropa Sans" => "Ropa Sans",
                            "Rosario" => "Rosario",
                            "Rosarivo" => "Rosarivo",
                            "Rouge Script" => "Rouge Script",
                            "Ruda" => "Ruda",
                            "Rufina" => "Rufina",
                            "Ruge Boogie" => "Ruge Boogie",
                            "Ruluko" => "Ruluko",
                            "Rum Raisin" => "Rum Raisin",
                            "Ruslan Display" => "Ruslan Display",
                            "Russo One" => "Russo One",
                            "Ruthie" => "Ruthie",
                            "Rye" => "Rye",
                            "Sacramento" => "Sacramento",
                            "Sail" => "Sail",
                            "Salsa" => "Salsa",
                            "Sanchez" => "Sanchez",
                            "Sancreek" => "Sancreek",
                            "Sansita One" => "Sansita One",
                            "Sarina" => "Sarina",
                            "Satisfy" => "Satisfy",
                            "Scada" => "Scada",
                            "Schoolbell" => "Schoolbell",
                            "Seaweed Script" => "Seaweed Script",
                            "Sevillana" => "Sevillana",
                            "Seymour One" => "Seymour One",
                            "Shadows Into Light" => "Shadows Into Light",
                            "Shadows Into Light Two" => "Shadows Into Light Two",
                            "Shanti" => "Shanti",
                            "Share" => "Share",
                            "Share Tech" => "Share Tech",
                            "Share Tech Mono" => "Share Tech Mono",
                            "Shojumaru" => "Shojumaru",
                            "Short Stack" => "Short Stack",
                            "Siemreap" => "Siemreap",
                            "Sigmar One" => "Sigmar One",
                            "Signika" => "Signika",
                            "Signika Negative" => "Signika Negative",
                            "Simonetta" => "Simonetta",
                            "Sintony" => "Sintony",
                            "Sirin Stencil" => "Sirin Stencil",
                            "Six Caps" => "Six Caps",
                            "Skranji" => "Skranji",
                            "Slackey" => "Slackey",
                            "Smokum" => "Smokum",
                            "Smythe" => "Smythe",
                            "Sniglet" => "Sniglet",
                            "Snippet" => "Snippet",
                            "Snowburst One" => "Snowburst One",
                            "Sofadi One" => "Sofadi One",
                            "Sofia" => "Sofia",
                            "Sonsie One" => "Sonsie One",
                            "Sorts Mill Goudy" => "Sorts Mill Goudy",
                            "Source Code Pro" => "Source Code Pro",
                            "Source Sans Pro" => "Source Sans Pro",
                            "Special Elite" => "Special Elite",
                            "Spicy Rice" => "Spicy Rice",
                            "Spinnaker" => "Spinnaker",
                            "Spirax" => "Spirax",
                            "Squada One" => "Squada One",
                            "Stalemate" => "Stalemate",
                            "Stalinist One" => "Stalinist One",
                            "Stardos Stencil" => "Stardos Stencil",
                            "Stint Ultra Condensed" => "Stint Ultra Condensed",
                            "Stint Ultra Expanded" => "Stint Ultra Expanded",
                            "Stoke" => "Stoke",
                            "Strait" => "Strait",
                            "Sue Ellen Francisco" => "Sue Ellen Francisco",
                            "Sunawesomey" => "Sunawesomey",
                            "Supermercado One" => "Supermercado One",
                            "Suwannaphum" => "Suwannaphum",
                            "Swanky and Moo Moo" => "Swanky and Moo Moo",
                            "Syncopate" => "Syncopate",
                            "Tangerine" => "Tangerine",
                            "Taprom" => "Taprom",
                            "Tauri" => "Tauri",
                            "Telex" => "Telex",
                            "Tenor Sans" => "Tenor Sans",
                            "Text Me One" => "Text Me One",
                            "The Girl Next Door" => "The Girl Next Door",
                            "Tienne" => "Tienne",
                            "Tinos" => "Tinos",
                            "Titan One" => "Titan One",
                            "Titillium Web" => "Titillium Web",
                            "Trade Winds" => "Trade Winds",
                            "Trocchi" => "Trocchi",
                            "Trochut" => "Trochut",
                            "Trykker" => "Trykker",
                            "Tulpen One" => "Tulpen One",
                            "Ubuntu" => "Ubuntu",
                            "Ubuntu Condensed" => "Ubuntu Condensed",
                            "Ubuntu Mono" => "Ubuntu Mono",
                            "Ultra" => "Ultra",
                            "Uncial Antiqua" => "Uncial Antiqua",
                            "Underdog" => "Underdog",
                            "Unica One" => "Unica One",
                            "UnifrakturCook" => "UnifrakturCook",
                            "UnifrakturMaguntia" => "UnifrakturMaguntia",
                            "Unkempt" => "Unkempt",
                            "Unlock" => "Unlock",
                            "Unna" => "Unna",
                            "VT323" => "VT323",
                            "Vampiro One" => "Vampiro One",
                            "Varela" => "Varela",
                            "Varela Round" => "Varela Round",
                            "Vast Shadow" => "Vast Shadow",
                            "Vibur" => "Vibur",
                            "Vidaloka" => "Vidaloka",
                            "Viga" => "Viga",
                            "Voces" => "Voces",
                            "Volkhov" => "Volkhov",
                            "Vollkorn" => "Vollkorn",
                            "Voltaire" => "Voltaire",
                            "Waiting for the Sunrise" => "Waiting for the Sunrise",
                            "Wallpoet" => "Wallpoet",
                            "Walter Turncoat" => "Walter Turncoat",
                            "Warnes" => "Warnes",
                            "Wellfleet" => "Wellfleet",
                            "Wendy One" => "Wendy One",
                            "Wire One" => "Wire One",
                            "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
                            "Yellowtail" => "Yellowtail",
                            "Yeseva One" => "Yeseva+One",
                            "Yesteryear" => "Yesteryear",
                            "Zeyada" => "Zeyada",
                        );



                        if ($wg24_output['fontsource'] == 'webfont') {
                            $font_data = $google_web_fonts;
                        } elseif ($wg24_output['fontsource'] == 'localfont') {
                            $font_data = $localfonts;
                        }
                        foreach ($font_data as $key => $font_value) {
                            $idfont = trim($key);
                            if (!empty($get_face)) {
                                if ($wg24_output['fontsource'] == 'webfont') {
                                    if (trim($get_face) == $idfont)
                                        $selected_gval = 'selected="selected"';
                                    else
                                        $selected_gval = '';
                                }elseif ($wg24_output['fontsource'] == 'localfont') {
                                    if (trim($get_face) == $idfont)
                                        $selected_value = 'selected="selected"';
                                    else
                                        $selected_value = '';
                                }
                            }
                            else {
                                if ($wg24_output['fontsource'] == 'webfont') {
                                    if (trim($selectsourcefont['face']) == $idfont)
                                        $selected_gval = 'selected="selected"';
                                    else
                                        $selected_gval = '';
                                }elseif ($wg24_output['fontsource'] == 'localfont') {
                                    if (trim($selectsourcefont['face']) == $idfont)
                                        $selected_value = 'selected="selected"';
                                    else
                                        $selected_value = '';
                                }
                            }

                            if ($wg24_output['fontsource'] == 'webfont') {
                                $wg24_fields_result .= '<option value="' . $key . '" ' . $selected_gval . '>' . $font_value . '</option>';
                            } elseif ($wg24_output['fontsource'] == 'localfont') {
                                $wg24_fields_result .= '<option value="' . $key . '" ' . $selected_value . '>' . $font_value . '</option>';
                            }
                        }
                        $wg24_fields_result .= '</select>';
                        $wg24_fields_result .= '</div>';

                        if ($wg24_output['fontsource'] == 'webfont') {
                            $wg24_fields_result .= '<div id="live_show_googl_font" ><h4>Quick brown fox jumps over the lazy dog</h4></div>';
                        } elseif ($wg24_output['fontsource'] == 'localfont') {
                            $wg24_fields_result .= '<div id="live_show_system_font"><h4>Quick brown fox jumps over the lazy dog</h4></div>';
                        }
                    }

                    break;
                case 'images':
                    $i = 0;
                    $get_wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                    $wg24 = $wg24_output['wg24'];
                    foreach ($wg24_output['values'] as $key => $option_val) {
                        $i++;
                        if (!empty($get_wg24)) {
                            if ($get_wg24 == $key) {
                                $selected_value = 'add-radio-picture';
                            } else {
                                $selected_value = '';
                            }
                        } elseif ($wg24 == $key) {
                            $selected_value = 'add-radio-picture';
                        } else {
                            $selected_value = '';
                        }
                        $wg24_fields_result .= '<span>';
                        $wg24_fields_result .= '<input type="radio" id="of-radio-img-' . $wg24_output['id'] . $i . '" class="checkbox of-radio-img-radio" value="' . $key . '" name="' . $wg24_output['id'] . '" ' . $selected_value . ' />';
                        $wg24_fields_result .= '<div class="for-radio-picture-label">' . $key . '</div>';
                        $wg24_fields_result .= '<img src="' . $option_val . '" alt="" class="radio-box-picture ' . $selected_value . '" onClick="document.getElementById(\'of-radio-img-' . $wg24_output['id'] . $i . '\').checked = true;" />';
                        $wg24_fields_result .= '</span>';
                    }
                    break;
                case "image":
                    $src = $wg24_output['wg24'];
                    $wg24_fields_result .= '<img src="' . $src . '">';
                    break;
                case 'tabs_title':
                    if ($wg24_count_data >= 2) {
                        $wg24_fields_result .= '</div>';
                    }
                      if ($wg24_count_data== 1) {
                        $tabactive= 'active';
                    }else{
                        $tabactive= '';
                    }
                    $wg24_tabs_class = str_replace(' ', '', strtolower($wg24_output['name']));
                    $click_tabs_title = str_replace(' ', '', strtolower($wg24_output['name']));
                    $click_tabs_title = "of-option-" . $click_tabs_title;
                    $wg24_tabs .= '<li class="' . $wg24_tabs_class .' ' .$tabactive.'"   ><a data-toggle="tab"   title="' . $wg24_output['name'] . '" href="#' . $click_tabs_title . '">' . $wg24_output['name'] . '</a></li>';
                    $wg24_fields_result .= '<div  id="' . $click_tabs_title . '" class="tab-pane fade in '.$tabactive.'"> <div><h1>' . $wg24_output['name'] . '</h1></div>' . "\n";
                    break;
                case 'tiles':
                    $i = 0;
                    $get_wg24 = $this->wg24_administration_save_values($wg24_output['id']);
                    $wg24 = $wg24_output['wg24'];
                    foreach ($wg24_output['values'] as $key => $option_val) {
                        $i++;
                        if (!empty($get_wg24)) {
                            if ($get_wg24 == $option_val) {
                                $selected_value = 'wg24-radio-tile-selected';
                            } else {
                                $selected_value = '';
                            }
                        } elseif ($wg24 == $option_val) {
                            $selected_value = 'wg24-radio-tile-selected';
                        } else {
                            $selected_value = '';
                        }
                        $wg24_fields_result .= '<span>';
                        $wg24_fields_result .= '<input type="radio" id="wg24-radio-tile-' . $wg24_output['id'] . $i . '" class="checkbox wg24-radio-tile-radio" value="' . $option_val . '" name="' . $wg24_output['id'] . '" />';
                        $wg24_fields_result .= '<div class="wg24-radio-tile-img ' . $selected_value . '" onClick="document.getElementById(\'wg24-radio-tile-' . $wg24_output['id'] . $i . '\').checked = true;"><img src="' . $option_val . '" width="50" height="50"></div>';
                        $wg24_fields_result .= '</span>';
                    }

                    break;
                case 'typography':
                    if (isset($wg24_output['color'])) {
                        if (!empty($get_color)) {
                            $selected_value = $get_color;
                        } else {
                            $selected_value = $wg24_output['color'];
                        }
                        $wg24_fields_result .= '<div id="' . $wg24_output['id'] . '_col_add" class="selectColor"><div style="background-color: ' . $selected_value . '"></div></div>';
                        $wg24_fields_result .= '<input  original-title="Font color" name="' . $wg24_output['id'] . '[col_add]" id="' . $wg24_output['id'] . '_col_add" type="text" value="' . $selected_value . '" />';
                    }
                    break;
            }
            if ($wg24_output['type'] != 'tabs_title') {
                if (!isset($wg24_output['dsc'])) {
                    $explain_value = '';
                } else {
                    $explain_value = '<div class="explain">' . $wg24_output['dsc'] . '</div>';
                }
                $wg24_fields_result .= '</div>' . $explain_value;
                $wg24_fields_result .= '<div class="clear"> </div></div></div>';
            }
        }
        $wg24_fields_result .= '</div>';
        return array($wg24_fields_result, $wg24_tabs);
    }
    

        private function wg24_add_image($id, $wg24) {
        $add_image_data = '';
        $add_image = $this->wg24_administration_save_values($id);
        if ($add_image != "") {
            $value = $add_image;
        } else {
            $value = $wg24;
        }
        $add_image_data .= '<input class="upload wg24-input" name="' . $id . '" id="' . $id . '_add" value="' . $value . '" />';

        $add_image_data .= '<div class="upload_button_div"><span class="button upload_button" id="' . $id . '">Upload</span>';
        if (!empty($add_image)) {
            $hidden = '';
        } else {
            $hidden = '';
        }
        $add_image_data .= '<span class="button reset_button ' . $hidden . '" id="reset_' . $id . '" title="' . $id . '">Remove</span>';
        $add_image_data .='</div><div class="clear"></div>';
        if (!empty($add_image)) {
            $add_image_data .= '<div class="screenshot">';
            $add_image_data .= '<a class="wg24-uploaded-image" href="' . $add_image . '">';
            $add_image_data .= '<img class="for-body-picture" id="image_' . $id . '" src="' . $add_image . '" alt="" />';
            $add_image_data .= '</a>';
            $add_image_data .= '</div><div class="clear"></div>';
        }
        return $add_image_data;
    } 
        

    public function  update(){
   $this->load->model('setting/wg24themeoptionpanel');
  $onclick_btn = $_POST['type'];
if ($onclick_btn == 'wg24administrationvalue') {
     $post_data = $post_data = $_POST['data'];
    parse_str($post_data, $data);
    foreach ($data as $id => $result) {
        if (is_array($result)) {
            foreach ($result as $key => $result_value) {
                 $nameid=$id. '_' . $key;
                 $value=htmlspecialchars($result_value);
                $this->model_setting_wg24themeoptionpanel->editSettingValue('wg24themeoptionpanel',$nameid,$value);
            }
        } else {
            $nameid=$id;
            $value=htmlspecialchars($result);
           $this->model_setting_wg24themeoptionpanel->editSettingValue('wg24themeoptionpanel',$nameid,$value);
        }
    }
}elseif ($onclick_btn == 'pattern_upload') {
    $post_data = $_POST['data']; 
    $file_name = $_FILES[$post_data];
    $file_name['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $file_name['name']);
    move_uploaded_file($file_name['tmp_name'], 'view/javascript/wg24options/img/' . $file_name['name']);    
    echo   HTTP_SERVER.'view/javascript/wg24options/img/'. $file_name['name'];
    
}elseif ($onclick_btn == 'image_reset') {
   $delid=$_POST['data'];
    $this->model_setting_wg24themeoptionpanel->deletesingleSetting('wg24themeoptionpanel',$delid);
}
        
    }
    
 
    

}

?>