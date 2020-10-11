<?php

class ControllerRegisterSuccess extends Controller {

    public function index() {
        $this->load->language('register/success');
        $backoffice_url = OFFICE_PATH_USER.'user/redirection';
        $Message="Successfully Registered";
        
        if($this->customer->getId()==1){
              $backoffice_url = OFFICE_PATH.'admin/home/redirection';
        }
      //  $this->response->redirect($backoffice_url, 'Successfully Registered');
     //   header("Location:$backoffice_url?Message={$Message}");
     if($this->customer->getId()){
        header("Location:$backoffice_url?Message={$Message}");
     }
        //$this->redirect($Message, $backoffice_url, true);
        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

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

        $data['continue'] = $this->url->link('account/login');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('register/success', $data));
    }

}
