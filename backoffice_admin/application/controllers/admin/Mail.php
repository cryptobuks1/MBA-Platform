<?php

require_once 'Inf_Controller.php';

class Mail extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function mail_management($tab = '') {

        $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mail_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $tab1 = ' active';
        $tab2 = '';
        if ($tab == 'tab2') {
            $tab1 = '';
            $tab2 = ' active';
        }

        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('admin_id', $admin_id);

        if ($user_type == 'admin' || $user_type == "employee") {
            $base_url = base_url() . 'admin/mail/mail_management';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['num_links'] = 5;
            if ($this->uri->segment(4) != '')
                $page = $this->uri->segment(4);
            else
                $page = 0;
            $this->set('page', $page);
            $messages = $this->mail_model->getAdminMessages($page, $config['per_page']);//print_r($messages);die;
            $cntctmsgs = $this->mail_model->getContactMessages($page, $config['per_page'], $this->LOG_USER_ID);
            $adminmsgs = array_merge($messages, $cntctmsgs);
            for ($i = 0; $i < count($adminmsgs); $i++) {
                if($adminmsgs[$i]['type'] == 'contact'){
                    $id = $adminmsgs[$i]['id'];
                }else{
                    $id = $adminmsgs[$i]['thread'];
                }
                $mail_enc_id = $this->encrypt->encode($id);
                $mail_enc_id = str_replace("/", "_", $mail_enc_id);
                $mail_enc_id = rawurlencode($mail_enc_id);
                $adminmsgs[$i]['mail_enc_id'] = $mail_enc_id;

                $mail_enc_type = $this->encrypt->encode($adminmsgs[$i]['type']);
                $mail_enc_type = str_replace("/", "_", $mail_enc_type);
                $mail_enc_type = rawurlencode($mail_enc_type);
                $adminmsgs[$i]['mail_enc_type'] = $mail_enc_type;

            }
            $cnt_adminmsgs = count($adminmsgs);
            $this->set('cnt_adminmsgs', $cnt_adminmsgs);
            $numrow1 = $this->mail_model->getCountAdminMessages();
            $numrow2 = $this->mail_model->getCountContactMessages($this->LOG_USER_ID);
            $numrows = $numrow1 + $numrow2;
            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);

            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('adminmsgs', $adminmsgs);
            $this->set('num_rows', $numrows);
        }
        if ($this->session->userdata('inf_mail_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_mail_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab2 = $tab_arr['tab2'];
            $this->session->unset_userdata("inf_mail_tab_active_arr");
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->setView();
    }

    function compose_mail() {

        $title = lang('compose_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('compose_mail');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $sender_id = $this->LOG_USER_ID;
        $date = date('Y-m-d H:i:s');
        $tab1 = ' active';
        $tab2 = '';
        $mail_status = 'single';
        $sender_email = $this->validation_model->getUserEmailId($sender_id);

        if ($this->input->post('adminsend') && $this->validate_compose_mail()) {
            $mail_status = ($this->input->post('mail_status', TRUE));
            $subject = ($this->input->post('subject', TRUE));
            $message = ($this->input->post('message1', TRUE));
            $user_id = ($this->input->post('user_id', TRUE));
            $from_mail = ($this->input->post('ext_mail_from', TRUE));
            $to_mail = ($this->input->post('ext_mail_to', TRUE));
        //  $message = addslashes($message);
            $message = htmlspecialchars($message);
            if ($mail_status == 'single') {
                $user_name_arr = $this->input->post('user_id', TRUE);
                $user_id = $this->validation_model->userNameToID($user_name_arr);
                $user_name_exp = explode(',', $user_name_arr);
                $msg = '';
                for ($i = 0; $i < count($user_name_exp); $i++) {
                    $user_name = $user_name_exp[$i];
                    if ($user_id == 0) {
                        $msg = lang('invalid_user_name');
                        $this->redirect($msg, 'mail/compose_mail', FALSE);
                    } else {
                        $admin_username = $this->mail_model->getAdminUsername();

                           // $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $date);
                        if ($user_name != $admin_username)
//                            $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date, $sender_id);
                            $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date, $this->ADMIN_USER_ID);
                        else {
                            $msg = lang("you_cant_sent_msg_to_yourself");
                            $this->redirect($msg, 'mail/compose_mail', FALSE);
                        }
                    }
                }
            }
            else if ($mail_status == 'all') {
                $res = FALSE;
                $user_name_exp = $this->mail_model->getUsers();
                for ($i = 0; $i < count($user_name_exp); $i++) {
                    $user_id = $user_name_exp[$i];
                    $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date, $sender_id);
                }
            }else if ($mail_status == 'ext_mail') {
                $send_details = array();
                $send_details['user_id'] = $sender_id;
                $type = 'external_mail';
                $email = $from_mail;
                $send_details['full_name'] = $this->validation_model->getUserFullName($sender_id);
                $send_details['email'] = $to_mail;
                $send_details['first_name'] = $this->validation_model->getUserData($sender_id, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($sender_id, "user_detail_second_name");
                $send_details['email_from'] = $email;
                $send_details['content'] = $message;
                $send_details['subject'] = $subject;
                $res = $this->mail_model->sendAllEmails($type, $send_details);

            }

            if ($res) {
                $data_array['subject'] = $subject;
                $data_array['message'] = $message;
                $login_id = $this->LOG_USER_ID;
                if ($mail_status == 'all') {
                    $data_array['sent_to'] = 'all';
                    $data = serialize($data_array);
                    $this->mail_model->sendMessageToUserCumulative('team', $subject, $message, $date, 'team');
                    $this->validation_model->insertUserActivity($login_id, 'message sent', $login_id, $data);
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Message Sent', 'message sent');
                    }
                }
                if ($mail_status != 'all') {
                    if($mail_status == 'ext_mail'){
                        $user_id = $to_mail;
                    $this->mail_model->sendMessageToUserCumulative($user_id, $subject, $message, $date, 'ext_mail');
                    }else{
                         $data_array['sent_to'] = $user_id;
                    $this->mail_model->sendMessageToUserCumulative($user_id, $subject, $message, $date, 'individual');
                    }
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($login_id, 'message sent', $login_id, $data);
                     if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Message Sent', 'message sent');
                    }
                }
                $msg = lang('message_send_successfully');
                $this->redirect($msg, 'mail/mail_management', TRUE);
            } else {
                $msg = lang('error_on_message_sending');
                $this->redirect($msg, 'mail/mail_management', FALSE);
            }
        }

        $this->set("mail_status", $mail_status);
        $this->set("sender_email", $sender_email);
        $this->setView();
    }

    function mail_sent() {

        $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mail_sent');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('admin_id', $admin_id);

        if ($user_type == 'admin' || $user_type == "employee") {
            $base_url = base_url() . 'admin/mail/mail_sent';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['num_links'] = 5;
            if ($this->uri->segment(4) != '')
                $page = $this->uri->segment(4);
            else
                $page = 0;
            $this->set('page', $page);
            $adminmsgs = $this->mail_model->getAdminMessagesSent($page, $config['per_page']);

            for ($i = 0; $i < count($adminmsgs); $i++) {
                if($adminmsgs[$i]['type'] == 'contact'){
                    $id = $adminmsgs[$i]['id'];
                }else{
                    $id = $adminmsgs[$i]['thread'];
                }
                $mail_enc_id = $this->encrypt->encode($id);
                $mail_enc_id = str_replace("/", "_", $mail_enc_id);
                $mail_enc_id = rawurlencode($mail_enc_id);
                $adminmsgs[$i]['mail_enc_id'] = $mail_enc_id;

                $mail_enc_type = $this->encrypt->encode($adminmsgs[$i]['type']);
                $mail_enc_type = str_replace("/", "_", $mail_enc_type);
                $mail_enc_type = rawurlencode($mail_enc_type);
                $adminmsgs[$i]['mail_enc_type'] = $mail_enc_type;
            }

            $cnt_adminmsgs = count($adminmsgs);
            $this->set('cnt_adminmsgs', $cnt_adminmsgs);

            $numrows = $this->mail_model->getCountAdminMessagesSent($this->LOG_USER_ID);
            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);

            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('adminmsgs', $this->security->xss_clean($adminmsgs));
            $this->set('num_rows', $numrows);
        }

        $this->setView();
    }

    function reply_mail($mail_id = '') {

        $title = lang('reply_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('reply_mail');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_type = $this->LOG_USER_TYPE;
        $mail_id = ($mail_id);
        $mail_details = $this->mail_model->getAdminOneMessage($mail_id);
        $mail_details = $mail_details->result_array();
        if(count($mail_details) <= 0) {
            $this->redirect(lang('invalid_mail_id'), 'mail/mail_management', FALSE);
        }
        $thread = $mail_details[0]['thread'];
        $reply_user_id = $mail_details[0]['mailaduser'];
        $reply_user = $this->validation_model->idToUserName($reply_user_id);
        $reply_msg = $mail_details[0]['mailadsubject'];
        $this->set('reply_user', $reply_user);
        if (preg_match('/([\w\-]+\:[\w\-]+)/', $reply_msg)) {
            $string = explode(':', $reply_msg);
            $reply_msg = $string[1];
        }
        $reply_msg = str_replace('%20', ' ', $reply_msg);
        $reply_msg = trim($reply_msg);
        $this->set('reply_msg', $reply_msg);
        if ($this->input->post('send') && $this->validate_reply_mail()) {
            $user_name = ($this->input->post('user_id1', TRUE));
            $subject = ($this->input->post('subject', TRUE));
            $message = ($this->input->post('message', TRUE));
 //         $message = addslashes($message);
            $message = htmlspecialchars($message);
            $user_id = $this->mail_model->userNameToId($user_name);
            $date = date('Y-m-d H:i:s');
            $admin_username = $this->mail_model->getAdminUsername();
            if ($user_name == $admin_username) {
                $user_id = $this->LOG_USER_ID;
                $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $date,"admin",$thread);
                $this->mail_model->sendMessageToUserCumulative('team', $subject, $message, $date, 'team');
            } else {
                $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date,$this->LOG_USER_ID,$thread);
                $this->mail_model->sendMessageToUserCumulative($user_id, $subject, $message, $date, 'individual');
            }
            $msg = '';
            if ($res) {
                $msg = lang('message_send_successfully');
                $this->redirect($msg, 'mail/mail_management', TRUE);
            } else {
                $msg = lang('error_on_message_sending');
                $this->redirect($msg, 'mail/reply_mail', FALSE);
            }
        }
        $this->setView();
    }

    function getMessage($msg_id, $user_id, $user_type) {

        $this->mail_model->updateAdminOneMessage($msg_id);
        echo "OK";
        exit();
    }

    function deleteMessage($msg_id = "", $msg_type = "") {
        $res = false;
        $this->AJAX_STATUS = true;
        if ($msg_type == 'admin') {
            $flag = false;
            $res = false;
            $res1 = $this->mail_model->updateAdminMessage($msg_id,$flag);
            $res2 = $this->mail_model->updateUserMessage($msg_id,$flag);
            if($res1 || $res2){
                $res = true;
            }
        }
        if ($msg_type == 'contact') {
            $res = $this->mail_model->updateContactMessage($msg_id);
        }
        $msg = '';
        if ($res) {
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_management', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_management', FALSE);
        }
    }

    function deleteSentMessage($msg_id = "", $msg_type = "") {
        $res = FALSE;
        $this->AJAX_STATUS = true;
        if ($msg_type == 'ext_mail') {
            $res = $this->mail_model->updateAdminSentMessage($msg_id);
        }  elseif ($msg_type == 'user') {
            $res = $this->mail_model->updateUserMessageSent($msg_id,$msg_type);
        }
        $msg = '';
        if ($res) {
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_sent', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_sent', FALSE);
        }
    }

    function read_mail($msg_id = "",$msg_type = "") {
         $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('read_mail');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $msg_id = urldecode($msg_id);
        $msg_id = str_replace("_", "/", $msg_id);
        $msg_id = $this->encrypt->decode($msg_id);

        $msg_type = urldecode($msg_type);
        $msg_type = str_replace("_", "/", $msg_type);
        $msg_type = $this->encrypt->decode($msg_type);
//        $msg_id = ($this->input->get('id', TRUE));
//        $msg_type = ($this->input->get('type', TRUE));
//        $thread = ($this->input->get('id', TRUE));
        if ($msg_type == 'admin') {
            $result = $this->mail_model->updateMsgStatus($msg_id,$msg_id);
            if ($result) {
                // echo $result;
            }
        }
        if($msg_type == 'contact'){
          $result = $this->mail_model->updateContactMsgStatus($msg_id);
        }
          $mail_details = $this->mail_model->getMailDetails($msg_id,$msg_type,$msg_id);
          for($i=0; $i<count($mail_details) ;$i++){
            if ($msg_type == 'contact') {
                $mail_details['msg'] = htmlspecialchars_decode($mail_details['contact_info']);
            }
            else {
                $mail_details[$i]['msg'] = htmlspecialchars_decode($mail_details[$i]['message']);
            }
             }
         // print_r($mail_details); die;
//        $mail_details->date = date('d M,Y g:i A', strtotime($mail_details->mailadiddate));
//        if($msg_type == 'admin'){
//            $mail_details->user_id = $this->validation_model->idToUserName($mail_details->mailaduser);
        //}
        $this->set('mail_details', $this->security->xss_clean($mail_details));
        $this->set('mail_type', $msg_type);
        $this->setView();

    }

    function reply_mail_name($user = '') {
        echo $user;
    }

    function validate_reply_mail() {
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message', lang('message'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function validate_compose_mail() {
        $tab2 = 'active';
        $tab1 = '';

        $mail_status = ($this->input->post('mail_status', TRUE));
        if ($mail_status == "single") {
            $this->form_validation->set_rules('user_id', lang('username'), 'trim|required|strip_tags');
        }
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message1', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
        function read_sent_mail($msg_id = "",$type = "") {
         $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('read_mail');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $msg_id = urldecode($msg_id);
        $msg_id = str_replace("_", "/", $msg_id);
        $msg_id = $this->encrypt->decode($msg_id);

        $type = urldecode($type);
        $type = str_replace("_", "/", $type);
        $type = $this->encrypt->decode($type);

//        $msg_id = ($this->input->get('id', TRUE));
//        $type = ($this->input->get('type', TRUE));
        if($type == "ext_mail"){
            $mail_details = $this->mail_model->getSentMailDetailsExt($msg_id);
        }else{
            $mail_details = $this->mail_model->getSentMailDetails($msg_id);
            for($i=0; $i<count($mail_details) ;$i++){
                $mail_details[$i]['msg'] = htmlspecialchars_decode($mail_details[$i]['mailtousmsg']);
             }
        }
//        if($mail_details->type == 'individual'){
//            $mail_details->to = $this->validation_model->idToUserName($mail_details[0]->mailtoususer);print_r($mail_details->to);die;
//        }
//        else{
//            $mail_details->to = 'ALL';
//        }
        $this->set('mail_details', $this->security->xss_clean($mail_details));
        $this->setView();

    }

}
