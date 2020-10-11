<?php

class ControllerRegisterType extends Controller {

    public function index() {
        $this->load->language('register/success');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $data['breadcrumbs'] = array();
 $this->cart->clear();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_success'),
            'href' => $this->url->link('register/success')
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $firstname = '';
        $data['text_message'] = sprintf($this->language->get('text_message'), $firstname, $this->url->link('information/contact'));

        $data['button_continue'] = $this->language->get('button_continue');

        $data['continue'] = $this->url->link('regiser/type');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
         if (isset($this->request->post['business'])||isset($this->request->post['customer']) ) {
              if (isset($this->request->post['customer'])){
                  $reg_type = "customer";
              }elseif(isset($this->request->post['business'])){
                  $reg_type = "business";
              }
            $this->session->data['inf_reg_data']['reg_type'] = $reg_type;
            
            $this->response->redirect($this->url->link('register/packages'));
         }
        $this->response->setOutput($this->load->view('register/type', $data));
    }

}
