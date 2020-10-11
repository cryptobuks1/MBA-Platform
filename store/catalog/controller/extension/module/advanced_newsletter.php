<?php
/**
 * Created by ANH To <anh.to87@gmail.com>.
 * User: baoan
 * Date: 11/8/15
 * Time: 00:23
 */

class ControllerExtensionModuleAdvancedNewsletter extends Controller
{
    public function index($setting)
    {
        $this->load->language('extension/module/advanced_newsletter');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_button_submit'] = $this->language->get('text_button_submit');
        $data['text_placeholder_input'] = $this->language->get('text_placeholder_input');

        
        return $this->load->view('extension/module/advanced_newsletter_box.tpl', $data);       
    }
}