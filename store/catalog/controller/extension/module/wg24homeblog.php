<?php
class ControllerExtensionModuleWg24HomeBlog extends Controller {
	public function index($setting) {
            /* option  */
            
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
            
            
            
            
		$this->load->model('tool/image');
                $this->load->model('extension/module/wg24blog');
               $data['blogpost'] = array();
                $filter_data = array(
			'start' => 0,
			'limit' => $setting['limit']
		);
		$results = $this->model_extension_module_wg24blog->getBlogPost($filter_data);
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'],$setting['width'], $setting['height']);
			} else {
				$image = $this->model_tool_image->resize('placeholder.png',$setting['width'], $setting['height']);
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
                            'href'        => $this->url->link('extension/module/wg24blog/details', 'blogpost_img_id=' . $result['blogpost_img_id'])
			);
		}

			return $this->load->view('extension/module/wg24homeblog', $data);
		}
	}
