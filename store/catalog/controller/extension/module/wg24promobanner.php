<?php
class ControllerExtensionModuleWg24PromoBanner extends Controller {
	public function index($setting) {
             // options data
                    $save_value = array(
                        'wg24themeoptionpanel_homepage123_prallax',
                        'wg24themeoptionpanel_home2freedeliverymes_prallax',
                        'wg24themeoptionpanel_home3freedeliverymes_prallax'
                        
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
            
            
		static $module = 0;

		$this->load->model('design/wg24homebanner');
		$this->load->model('tool/image');
		$data['banners'] = array();

		$results = $this->model_design_wg24homebanner->getBannerImages($setting['banner_id']);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'description' => $result['description'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}
		$data['module'] = $module++;
		return $this->load->view('extension/module/wg24promobanner', $data);
	}
}