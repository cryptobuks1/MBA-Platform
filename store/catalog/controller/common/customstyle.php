<?php
class ControllerCommonCustomStyle extends Controller {
	public function index() {
             $save_value = array(
                   'wg24themeoptionpanel_scrol_top_to_prallax',
                 'wg24themeoptionpanel_c_list_grid_prallax',
                 'wg24themeoptionpanel_col_skin_prallax' ,
                 'wg24themeoptionpanel_col_body_font_prallax',
                 'wg24themeoptionpanel_body_select_font_prallax',
                 'wg24themeoptionpanel_body_google_font_prallax',
                 'wg24themeoptionpanel_body_sy_font_prallax',
                 'wg24themeoptionpanel_body_size_font_prallax',
                 'wg24themeoptionpanel_bg_img_prallax',
                 'wg24themeoptionpanel_bg_cust_patten_prallax',
                 'wg24themeoptionpanel_bg_attached_prallax',
                 'wg24themeoptionpanel_bg_repeter_prallax',
                 'wg24themeoptionpanel_bg_positin_prallax',
                 'wg24themeoptionpanel_col_body_bg_prallax',
                 'wg24themeoptionpanel_bg_patten_prallax',
                 'wg24themeoptionpanel_heders_select_font_prallax',
                 'wg24themeoptionpanel_heders_gol_font_prallax',
                 'wg24themeoptionpanel_heders_gol_font_prallax',
                 'wg24themeoptionpanel_col_link_font1_prallax',
                 'wg24themeoptionpanel_col_link_h_font1_prallax',
                 'wg24themeoptionpanel_input_bg_col_prallax',
                 'wg24themeoptionpanel_input_text_col_prallax',
                 'wg24themeoptionpanel_h_m_link_col_prallax',
                 'wg24themeoptionpanel_h_m_link_h_col_prallax',
                 'wg24themeoptionpanel_gobprimary1_col_prallax',
                 'wg24themeoptionpanel_golbalsendary1_col_prallax',
                 'wg24themeoptionpanel_golbalsendary13_col_prallax',
                 'wg24themeoptionpanel_whitcolortext_col_prallax',
                 'wg24themeoptionpanel_footer_bg_col_prallax',
                 'wg24themeoptionpanel_f_heading_col_prallax',
                 'wg24themeoptionpanel_f_link_col_prallax',
                 'wg24themeoptionpanel_f_link_h_col_prallax',
                 'wg24themeoptionpanel_home2menubgcol_prallax'
                 
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    } 
                if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
                $data['base'] = $server;
            
            
            
            
            return $this->load->view('common/customstyle', $data);
            
        }
        
}