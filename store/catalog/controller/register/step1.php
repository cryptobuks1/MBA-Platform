<?php

class ControllerRegisterStep1 extends Controller
{

    public function index()
    {
        $this->load->language('register/step1');
        $this->load->model('account/inf_register');

        $data['text_sponsor_information'] = $this->language->get('text_sponsor_information');
        $data['text_sponsor_description'] = $this->language->get('text_sponsor_description');
        $data['entry_sponsor_user_name'] = $this->language->get('entry_sponsor_user_name');
        $data['button_verify_sponsor'] = $this->language->get('button_verify_sponsor');
        $data['error_only_alphanumerals'] = $this->language->get('error_only_alphanumerals');

        $mlm_plan = MLM_PLAN;
        if (MLM_PLAN == "Binary") {
            $data['entry_position'] = $this->language->get('entry_position');
            $data['entry_select_position'] = $this->language->get('entry_select_position');
            $data['entry_left'] = $this->language->get('entry_left');
            $data['entry_right'] = $this->language->get('entry_right');
        }
        $data['mlm_plan'] = $mlm_plan;
        
        /*if(!isset($this->session->data['inf_reg_data']['reg_type'])){ 
                $this->response->redirect($this->url->link('register/type', '', true));
            }*/
        $read_only = false;
        $sponsor_user_name = '';
        $reg_from_tree = 0;
        $placement_user_name = '';
        $placement_full_name = '';
        $position = 'L';
        $user_type = 'admin';
        $mlm_session = $this->customer->getMlmSessionFromfile();
        $replica_session = $this->customer->getReplicaSessionFromFile();
        if (isset($this->session->data['inf_reg_data']['step1'])) {
            $sponsor_user_name = $this->session->data['inf_reg_data']['step1']['sponsor_user_name'];
            $reg_from_tree = $this->session->data['inf_reg_data']['step1']['reg_from_tree'];
            $placement_user_name = $this->session->data['inf_reg_data']['step1']['placement_user_name'];
            $placement_full_name = $this->session->data['inf_reg_data']['step1']['placement_full_name'];
            $position = $this->session->data['inf_reg_data']['step1']['position'];
        } else if (isset($mlm_session['inf_placement_array'])) { 
            $ci_encryption = new \ci_encryption();
            $placement_array = $ci_encryption->ci_dec($mlm_session['inf_placement_array']);
            $reg_from_tree = $placement_array['reg_from_tree'];
            $sponsor_user_name = $placement_array['sponsor_user_name'];
            $placement_user_name = $placement_array['placement_user_name'];
            $placement_full_name = $placement_array['placement_full_name'];
            $position = $placement_array['position'];
        }elseif ($this->customer->isLogged()) {
            $sponsor_user_name = $this->customer->getUserName();
            $user_type = $this->customer->getUserType();
        } else if (isset($replica_session['replica_user'])) {
             $ci_encryption = new \ci_encryption();
            $replica_session = $ci_encryption->ci_dec($replica_session['replica_user']);//echo "<pre>";print_r($replica_session);die;
            $read_only = true;
            $sponsor_user_name = $replica_session['user_name'];
        }  else {
            $sponsor_user_name = ADMIN_USER_NAME;
        }

        if ($this->customer->isLogged() && $this->customer->getUserType() != "admin") {
            $sponsor_user_name = $this->customer->getUserName();
            $read_only = TRUE;
        }

        if (!isset($mlm_session['replica_user'])) {
            $this->load->model('account/inf_register');
            if (!$this->model_account_inf_register->isSponsorRequired()) {
                $read_only = true;
                $sponsor_user_name = ADMIN_USER_NAME;
            }
        }

        if ($mlm_plan == 'Binary') {
            $sponsor_id = $this->customer->userNameToId($sponsor_user_name);
           // $data['binary_leg'] = $this->model_account_inf_register->getAllowedBinaryLeg($sponsor_id, $this->customer->getUserType(), $this->customer->getUserId());
        }

        $data['user_type'] = $user_type;
        $data['reg_from_tree'] = $reg_from_tree;
        $data['placement_user_name'] = $placement_user_name;
        $data['placement_full_name'] = $placement_full_name;
        $data['mlm_plan'] = $mlm_plan;
        $data['position'] = $position;
        $data['sponsor_user_name'] = $sponsor_user_name;
        $data['read_only'] = $read_only;

        if ($reg_from_tree) {
            $data['entry_placement_username'] = $this->language->get('entry_placement_username');
        }

        $this->response->setOutput($this->load->view('register/step1', $data));
    }

    public function save()
    {

        $this->load->language('register/step1');

        $json = array();

        $this->load->model('account/inf_register');
        if (!$this->model_account_inf_register->isRegistrationAllowed()) {
            $this->session->data['error_redirect'] = $this->language->get('registration_not_allowed');
            $json['redirect'] = $this->url->link('common/home', '', true);
            echo json_encode($json);
            exit();
        }

        if ((utf8_strlen(trim($this->request->post['sponsor_user_name'])) < 4) || (utf8_strlen(trim($this->request->post['sponsor_user_name'])) > 50)) {
            $json['error']['sponsor_user_name'] = $this->language->get('error_sponsor_user_name_invalid');
        }

        if (!$this->model_account_inf_register->isSponsorRequired()) {
            $read_only = true;
            $sponsor_user_name = ADMIN_USER_NAME;
            if ($this->request->post['sponsor_user_name'] != $sponsor_user_name) {
                $json['error']['sponsor_user_name'] = $this->language->get('invalid_sponsor_name');
            }
        }
        if (MLM_PLAN == "Binary") {
            if (utf8_strlen(trim($this->request->post['position'])) < 1) {
              //  $json['error']['position'] = $this->language->get('error_position');
            } else {
                if ($this->request->post['reg_from_tree'] && $this->request->post['placement_user_name']) {
                    $sponsor_id = $this->customer->userNameToID($this->request->post['placement_user_name']);
                } else {
                    $sponsor_id = $this->customer->userNameToID($this->request->post['sponsor_user_name']);
                }
                $binary_leg = $this->model_account_inf_register->getAllowedBinaryLeg($sponsor_id, $this->customer->getUserType(), $this->customer->getUserId());
                if ($binary_leg != 'any' && $binary_leg != $this->request->post['position']) {
                    $json['error']['position'] = $this->language->get('position_not_usable');
                }
            }
        }

        if (!$json) {

            $mlm_session = $this->customer->getMlmSession();
            if (!isset($mlm_session['replica_user'])) {
                if (!$this->model_account_inf_register->isSponsorRequired()) {
                    $read_only = true;
                    $this->request->post['sponsor_user_name'] = ADMIN_USER_NAME;
                }
            }

            $user_id = $this->customer->userNameToID($this->request->post['sponsor_user_name']);
            $user_id = $this->customer->validUserNameToID($this->request->post['sponsor_user_name']);

            if ($user_id) {
                $valid_placement = TRUE;
                if ($this->request->post['reg_from_tree']) {
                    $sponsor_id = $this->customer->userNameToID($this->request->post['sponsor_user_name']);
                    $placement_id = $this->customer->userNameToID($this->request->post['placement_user_name']);
                    $sponsor_left_right = $this->model_account_inf_register->getUserLeftRightNode($sponsor_id);
                    $placement_left_right = $this->model_account_inf_register->getUserLeftRightNode($placement_id);
                    if (($placement_left_right['left'] < $sponsor_left_right['left']) || ($placement_left_right['right'] > $sponsor_left_right['right'])) {
                        $valid_placement = FALSE;
                        $json['error']['placement_user_name'] = $this->language->get('invalid_placement');
                        $this->response->addHeader('Content-Type: application/json');
                        $this->response->setOutput(json_encode($json));
                    }
                }
                if ($valid_placement) {
                    $this->session->data['inf_reg_data']['step1']['sponsor_user_name'] = trim($this->request->post['sponsor_user_name']);
                    $this->session->data['inf_reg_data']['step1']['position'] = trim($this->request->post['position']);
                    $this->session->data['inf_reg_data']['step1']['user_type'] = trim($this->request->post['user_type']);
                    $this->session->data['inf_reg_data']['step1']['reg_from_tree'] = trim($this->request->post['reg_from_tree']);
                    $this->session->data['inf_reg_data']['step1']['placement_user_name'] = trim($this->request->post['placement_user_name']);
                    $this->session->data['inf_reg_data']['step1']['placement_full_name'] = trim($this->request->post['placement_full_name']);
                }
            } else {
                $json['error']['sponsor_user_name'] = $this->language->get('error_sponsor_user_name');
            }
        } else {
            $json['error']['warning'] = $this->language->get('error_step1');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
