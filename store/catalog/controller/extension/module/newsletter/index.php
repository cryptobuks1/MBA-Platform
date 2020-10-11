<?php
/**
 * Created by ANH To <anh.to87@gmail.com>.
 * User: baoan
 * Date: 11/7/15
 * Time: 10:45
 */

class ControllerExtensionModuleNewsletterIndex extends Controller
{
    private $code = 'adv_newsletter';

    public function index()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST')
        {
            $this->load->language('extension/module/advanced_newsletter');

            header('Content: application/json');

            if(!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(array(
                    'error' => 1,
                    'msg'   => $this->language->get('text_email_not_valid')
                ));
                return true;
            }
            $this->load->model('extension/module/module');
            $model = $this->model_extension_module_module;

            $post_data = $this->request->post;

            $result = $model->validate($post_data);

            echo json_encode($result);

            return true;
        }
    }

    public function confirm()
    {
        $this->load->model('extension/module/module');
        $model = $this->model_extension_module_module;
        if (isset($this->request->get['agree']) && isset($this->request->get['cid']) && !empty($this->request->get['cid']))
        {
            $email = $this->encryption->decrypt(base64_decode($this->request->get['cid']));
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($model->agree($email))
                {
                    $this->session->data['success'] = $this->language->get('text_subscribe_successful');
                    $this->response->redirect($this->url->link('common/home'));
                    return true;
                }
            }

        }
        else if (isset($this->request->get['unagree']) && isset($this->request->get['cid']) && !empty($this->request->get['cid']))
        {
            $email = $this->encryption->decrypt(base64_decode($this->request->get['cid']));
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($model->unagree($email))
                {
                    $this->session->data['success'] = $this->language->get('text_unsubscribe_successful');
                    $this->response->redirect($this->url->link('common/home'));
                    return true;
                }
            }
        }

        $this->session->data['error'] = $this->language->get('text_subscribe_confirm_error');
        $this->response->redirect($this->url->link('common/home'));
    }
}