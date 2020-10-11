<?php

require_once 'Inf_Controller.php';

class Mail extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function compose_mail()
    {

        $title = lang('compose_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $help_link = 'mail-management';
        $this->set('help_link', $help_link);
        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('compose_mail');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $sender_email = $this->validation_model->getUserEmailId($user_id);
        $user_downlines = $this->mail_model->getUserDownlinesAll($user_id);
        $thread = '';

        $user_id = $this->LOG_USER_ID;
        $admin_username = $this->mail_model->getAdminUsername();
        if ($this->input->post('usersend') && $this->validate_compose_mail()) {
            $send_post_array = $this->input->post(null, true);
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $send_post_array['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));
            $thread = $this->input->post('thread', true);
            $subject = $send_post_array['subject'];
            $message = $send_post_array['message'];
           // $message = addslashes($message);
            $message = htmlentities($message);
            $dt = date('Y-m-d H:i:s');
            $send_post_array['user'];

            if ($send_post_array['user'] == 'admin') {
                $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $dt, "", $thread);
                $msg = '';
                if ($res) {
                    $data_array = array();
                    $data_array['mail_subject'] = $subject;
                    $data_array['mail_body'] = $message;
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail sent', $this->ADMIN_USER_ID, $data);
                    $msg = lang('message_send_successfully');
                    $this->redirect($msg, "mail/compose_mail", true);
                } else {
                    $msg = lang('error_on_message_sending');
                    $this->redirect($msg, "mail/compose_mail", false);
                }
            } else if ($send_post_array['user'] == 'all') {
                if (count($user_downlines)) {

                    $this->mail_model->sendMessageToDownlinesCumulative($subject, $user_id, 'team', $message, 'team');
                    $res = $this->mail_model->sendMessageToAllDownlines($message, $user_id, $user_downlines, $subject);
                    $msg = "";
                    if ($res) {
                        $login_id = $this->LOG_USER_ID;
                        $data_array = array();
                        $data_array['mail_subject'] = $subject;
                        $data_array['mail_body'] = $message;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($login_id, 'mail sent', $this->ADMIN_USER_ID, $data);
                        $msg = $this->lang->line('message_send_successfully');
                        $this->redirect($msg, "mail/compose_mail", true);
                    } else {
                        $msg = $this->lang->line('error_on_message_sending');
                        $this->redirect($msg, "mail/compose_mail", false);
                    }
                } else{
                   $msg = lang('no_downlines_found');
                    $this->redirect($msg, "mail/compose_mail", false);
                }
            } else if ($send_post_array['user'] == 'individual') {
                $to_user_id = $send_post_array['username'];
                if ($to_user_id != '') {
                    $username = $this->validation_model->idToUserName($to_user_id);
                    if ($username) {
                        $this->mail_model->sendMessageToDownlines($subject, $user_id, $to_user_id, $message);
                        $this->mail_model->sendMessageToDownlinesCumulative($subject, $user_id, $to_user_id, $message, 'individual');
                        $msg = "";
                        $res = true;
                        if ($res) {
                            $login_id = $this->LOG_USER_ID;
                            $data_array = array();
                            $data_array['mail_subject'] = $subject;
                            $data_array['mail_body'] = $message;
                            $data = serialize($data_array);
                            $this->validation_model->insertUserActivity($login_id, 'mail to downline sent', $this->ADMIN_USER_ID, $data);
                            $msg = $this->lang->line('message_send_successfully');
                            $this->redirect($msg, "mail/compose_mail", true);
                        } else {
                            $msg = $this->lang->line('error_on_message_sending');
                            $this->redirect($msg, "mail/mail_to_downlines", false);
                        }
                    } else {
                        $msg = lang('invalid_user');
                        $this->redirect($msg, "mail/compose_mail", false);
                    }
                } else {
                    $msg = lang('you_must_select_a_user');
                    $this->redirect($msg, "mail/compose_mail", false);
                }
            } else if ($send_post_array['user'] == 'ext_mail') {
                if($send_post_array['ext_mail_from'] != $this->validation_model->getUserEmailId($this->LOG_USER_ID))
                {
                    $msg = $this->lang->line('error_on_message_sending');
                    $this->redirect($msg, "mail/compose_mail", false);
                }
                $send_details = array();
                $send_details['user_id'] = $this->LOG_USER_ID;
                $type = 'external_mail';
                $email = $send_post_array['ext_mail_from'];
                $to_mail = $send_post_array['ext_mail_to'];
                $send_details['full_name'] = $this->validation_model->getUserFullName($this->LOG_USER_ID);
                $send_details['email'] = $to_mail;
                $send_details['first_name'] = $this->validation_model->getUserData($this->LOG_USER_ID, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($this->LOG_USER_ID, "user_detail_second_name");
                $send_details['email_from'] = $email;
                $send_details['content'] = $message;
                $send_details['subject'] = $subject;
                $res = $this->mail_model->sendAllEmails($type, $send_details);
                $res1 = $this->mail_model->sendMessageToUserCumulative($to_mail, $subject, $message, $dt, 'ext_mail_user');
                $msg = "";
                if ($res) {
                    $login_id = $this->LOG_USER_ID;
                    $data_array = array();
                    $data_array['mail_subject'] = $subject;
                    $data_array['mail_body'] = $message;
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($login_id, 'mail sent', $this->ADMIN_USER_ID, $data);
                    $msg = $this->lang->line('message_send_successfully');
                    $this->redirect($msg, "mail/compose_mail", true);
                } else {
                    $msg = $this->lang->line('error_on_message_sending');
                    $this->redirect($msg, "mail/compose_mail", false);
                }
            }
        }
        $this->set("sender_email", $sender_email);
        $this->set('tran_admin', $admin_username);
        $this->set('user_downlines', $user_downlines);
        $this->setView();
    }

    function reply_mail($mail_id = '')
    {
        $title = lang('reply_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $help_link = 'reply-mail';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('reply_mail');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $mail_id = ($mail_id);
        $mail_details = $this->mail_model->getUserOneMessage($mail_id, $this->LOG_USER_ID);
        $mail_details = $mail_details->result_array();

        if (count($mail_details) <= 0 || $mail_details[0]['mailtoususer'] != $this->LOG_USER_ID) {
            $this->redirect(lang('invalid_mail_id'), 'mail/mail_management', false);
        }

        if ($mail_details[0]['mailfromuser'] == 'admin') {
            $admin_id = $this->validation_model->getAdminId();
            $reply_to_user = $this->validation_model->idToUserName($admin_id);
        } else {
            $reply_to_user = $this->validation_model->idToUserName($mail_details[0]['mailfromuser']);
        }
        $thread = $mail_details[0]['thread'];
        $reply_msg = $mail_details[0]['mailtoussub'];
        if (preg_match('/([\w\-]+\:[\w\-]+)/', $reply_msg)) {
            $string = explode(":", $reply_msg);
            $reply_msg = $string[1];
        }
        $reply_msg = str_replace('%20', ' ', $reply_msg);
        $reply_msg = trim($reply_msg);

        $this->set('reply_to_user', $reply_to_user);
        $this->set('reply_msg', $reply_msg);

        if ($this->input->post('send') && $this->validate_reply_mail()) {
            $send_post_array = $this->input->post(null, true);
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $send_post_array['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));
            $user_name = $send_post_array['user_name'];
            $subject = $send_post_array['subject'];
            $message = $send_post_array['message'];
    //      $message = addslashes($message);
            $message = htmlentities($message);
            $user_id = $this->mail_model->userNameToId($user_name);
            $dt = date('Y-m-d H:i:s');
            $admin_username = $this->mail_model->getAdminUsername();
            if ($user_name == $admin_username) {
                $user_id = $this->LOG_USER_ID;
                $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $dt, '', $thread);
            } else {
                $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $dt, $this->LOG_USER_ID, $thread);
            }
            $msg = "";
            if ($res) {
                $msg = lang('message_send_successfully');
                $this->redirect($msg, 'mail/mail_management', true);
            } else {
                $msg = lang('error_on_message_sending');
                $this->redirect($msg, 'mail/reply_mail', false);
            }
        }
        $this->setView();
    }

    function getMessage($msg_id, $user_id, $user_type)
    {
        $this->mail_model->updateUserOneMessage($msg_id);
        echo "OK";
        exit();
    }

    function deleteMessage($msg_id = "", $msg_type = "")
    {
        $res = FALSE;
        $this->AJAX_STATUS = true;
        if ($msg_type == 'user') {
            $flag = TRUE;
            $res = FALSE;
            $res1 = $this->mail_model->updateAdminMessage($msg_id, $flag);
            $res2 = $this->mail_model->updateUserMessage($msg_id, $flag);
            if ($res1 || $res2) {
                $res = true;
            }
        }
        if ($msg_type == 'contact') {
            $res = $this->mail_model->updateuserContactMessage($msg_id);
        }
        $msg = '';
        if ($res) {
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_management', true);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_management', false);
        }
    }

    function deleteDownlineSendMessage($msg_id = "", $msg_type = "")
    {

        $this->AJAX_STATUS = true;
        $res = $this->mail_model->updateDownlineSendMessage($msg_id);
        $msg = '';
        if ($res) {
            $data_array = array();
            $data_array['msg_id'] = $msg_id;
            $data_array['msg_type'] = $msg_type;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail to downline deleted ', $this->LOG_USER_ID, $data);
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_to_downlines', true);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_to_downlines', false);
        }
    }

    function deleteDownlineFromMessage($msg_id = "", $msg_type = "")
    {

        $this->AJAX_STATUS = true;
        $res = $this->mail_model->updateDownlineFromMessage($msg_id);
        $msg = '';
        if ($res) {
            $data_array = array();
            $data_array['msg_id'] = $msg_id;
            $data_array['msg_type'] = $msg_type;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail from downline deleted ', $this->LOG_USER_ID, $data);
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_to_downlines', true);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_to_downlines', false);
        }
    }

    function deleteSentMessage($msg_id = "", $msg_type = "")
    {
        $this->AJAX_STATUS = true;
        if ($msg_type == 'ext_mail_user') {
            $res = $this->mail_model->updateAdminSentMessage($msg_id);
        } else {
            $res = $this->mail_model->updateUserMessageSent($msg_id, $msg_type);
        }
        $msg = '';
        if ($res) {
            $data_array = array();
            $data_array['msg_id'] = $msg_id;
            $data_array['msg_type'] = $msg_type;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail deleted', $this->LOG_USER_ID, $data);
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_sent', true);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_sent', false);
        }
    }

    function readMessage()
    {
        $msg_id = (strip_tags($this->input->post('id', true)));
        $msg_type = (strip_tags($this->input->post('type', true)));

        $res = $this->mail_model->updateMsgStatus($msg_id);

        $msg = '';
        if ($res) {
            echo $res;
        }
    }

    function mail_management($tab = '')
    {

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
        $user_id = $this->LOG_USER_ID;
        $admin_username = $this->ADMIN_USER_NAME;

        $this->set('tran_admin', $admin_username);
        $base_url = base_url() . 'user/mail/mail_management';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
        $page = 0;

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        }

        $data1 = $this->mail_model->getUserMessages($user_id, $page, $config['per_page']);
        $data2 = $this->mail_model->getUserContactMessages($user_id, $page, $config['per_page']);
        $mail = array_merge($data1, $data2);
        for ($i = 0; $i < count($mail); $i++) {
            if($mail[$i]['type'] == 'contact'){
                $id = $mail[$i]['mailtousid'];
                $mail_enc_thread = $this->encrypt->encode($mail[$i]['mailtousid']);
                $mail_enc_thread = str_replace("/", "_", $mail_enc_thread);
                $mail_enc_thread = rawurlencode($mail_enc_thread);
                $mail[$i]['mail_enc_thread'] = $mail_enc_thread;
            }else{
                $id = $mail[$i]['thread'];
                $mail_enc_thread = $this->encrypt->encode($mail[$i]['thread']);
                $mail_enc_thread = str_replace("/", "_", $mail_enc_thread);
                $mail_enc_thread = rawurlencode($mail_enc_thread);
                $mail[$i]['mail_enc_thread'] = $mail_enc_thread;
            }
            $mail_enc_id = $this->encrypt->encode($id);
            $mail_enc_id = str_replace("/", "_", $mail_enc_id);
            $mail_enc_id = rawurlencode($mail_enc_id);
            $mail[$i]['mail_enc_id'] = $mail_enc_id;

            $mail_enc_type = $this->encrypt->encode($mail[$i]['type']);
            $mail_enc_type = str_replace("/", "_", $mail_enc_type);
            $mail_enc_type = rawurlencode($mail_enc_type);
            $mail[$i]['mail_enc_type'] = $mail_enc_type;
        }
        $num_mail1 = $this->mail_model->getCountUserMessages($user_id);
        $num_mail2 = $this->mail_model->getCountUserContactMessages($user_id);
        $config['total_rows'] = $num_mail1 + $num_mail2;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $cnt_mails = count($mail);

        if ($this->session->userdata('inf_mail_tab_active_arr')) {
            $tab_arr = $this->session->userdata('inf_mail_tab_active_arr');
            $tab1 = $tab_arr['tab1'];
            $tab2 = $tab_arr['tab2'];
            $this->session->unset_userdata('inf_mail_tab_active_arr');
        }
        $this->set('page', $page);
        $this->set('result_per_page', $result_per_page);
        $this->set('row', $this->security->xss_clean($mail));
//print_r($mail);die;
        $this->set('cnt_mails', $cnt_mails);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->setView();
    }

    function mail_sent()
    {

        $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mail_sent');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;

        $base_url = base_url() . 'user/mail/mail_sent';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;

        $page = 0;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        }

        $mail = $this->mail_model->getUserMessagesSent($user_id, $page);
        for ($i = 0; $i < count($mail); $i++) {
            if($mail[$i]['type'] == 'contact' || $mail[$i]['type'] == 'ext_mail_user'){
                $id = $mail[$i]['mailtousid'];
            }else{
                $id = $mail[$i]['thread'];
            }

            $mail_enc_id = $this->encrypt->encode($id);
            $mail_enc_id = str_replace("/", "_", $mail_enc_id);
            $mail_enc_id = rawurlencode($mail_enc_id);
            $mail[$i]['mail_enc_id'] = $mail_enc_id;

            $mail_enc_type = $this->encrypt->encode($mail[$i]['type']);
            $mail_enc_type = str_replace("/", "_", $mail_enc_type);
            $mail_enc_type = rawurlencode($mail_enc_type);
            $mail[$i]['mail_enc_type'] = $mail_enc_type;
        }

        $mail_count = $this->mail_model->getCountUserMessagesSent($user_id);
        $num_mails = $mail_count;
        $config['total_rows'] = $num_mails;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $cnt_mails = count($mail);
        $mails = [];
        if (!$page){
            if($config['per_page'] > $num_mails)
                $limit = $num_mails;
             else
                $limit = $config['per_page'];
        } else {
            $page_end_limit = $page + $config['per_page'];
            $limit = $page_end_limit;
            if($limit > $num_mails)
                $limit = $num_mails;
        }

        for ($i = $page; $i < $limit; $i++) {
            $mails[] = $mail[$i];
        }

        $this->set('page', $page);
        $this->set('result_per_page', $result_per_page);
        $this->set('row', $this->security->xss_clean($mails));
        $this->set('cnt_mails', $cnt_mails);
        $this->setView();
    }

    function validate_compose_mail()
    {
        $tab2 = 'active';
        $tab1 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function validate_reply_mail()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }
    function read_mail($msg_id = "", $msg_type = "", $thread = "")
    {
        $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('read_mail');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $i = 0;
        $msg_id = urldecode($msg_id);
        $msg_id = str_replace("_", "/", $msg_id);
        $msg_id = $this->encrypt->decode($msg_id);

        $msg_type = urldecode($msg_type);
        $msg_type = str_replace("_", "/", $msg_type);
        $msg_type = $this->encrypt->decode($msg_type);
        $msg_type = str_replace("/", "_", $msg_type);

        $thread = urldecode($thread);
        $thread = str_replace("_", "/", $thread);
        $thread = $this->encrypt->decode($thread);

//        $msg_id = ($this->input->get('id', true));
//        $msg_type = ($this->input->get('type', true));
//        $thread = ($this->input->get('thread', true));
        if ($msg_type == 'user') {
            $result = $this->mail_model->updateMsgStatus($msg_id, $thread);
            if ($result) {
                // echo $result;
            }
        }
        if ($msg_type == 'contact') {
            $result = $this->mail_model->updateContactMsgStatus($msg_id);
        }
        $mail_details = $this->mail_model->getUserMailDetails($msg_id, $msg_type, $thread);
        for ($i = 0; $i < count($mail_details); $i++) {
            if ($msg_type == 'contact') {
                $mail_details['msg'] = htmlspecialchars_decode($mail_details['contact_info']);
            } else {
                $mail_details[$i]['msg'] = htmlspecialchars_decode($mail_details[$i]['message']);
            }
        }
        if ($msg_type == 'contact') {
            $mail_details['date'] = date('d M,Y g:i A', strtotime($mail_details['mailadiddate']));
        }
        if ($msg_type == 'user') {
//            $mail_details->date = date('d M,Y g:i A', strtotime($mail_details->mailtousdate));
//            $mail_details->user_id = $this->validation_model->idToUserName($mail_details->mailfromuser);
//            $mail_details->from_mail = $this->validation_model->getUserEmailId($mail_details->mailfromuser);
        }
        //print_r($mail_details);die;
        $this->set('mail_details', $this->security->xss_clean($mail_details));
        $this->set('mail_type', $msg_type);
        $this->setView();

    }
    function read_sent_mail($msg_id="" , $type ="" )
    {
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
        $type = str_replace("/", "_", $type);
        $type = $this->encrypt->decode($type);

        $type = str_replace("/", "_", $type);

//        $msg_id = ($this->input->get('id', true));
//        $type = ($this->input->get('type', true));
        $user_id = $this->LOG_USER_ID;
        if ($type == "to_admin") {
            $mail_details = $this->mail_model->getUserSentMailDetails($msg_id, $type, $user_id);
            for ($i = 0; $i < count($mail_details); $i++) {
                $mail_details[$i]['msg'] = htmlspecialchars_decode($mail_details[$i]['mailadidmsg']);
            }
        } else {
            $mail_details = $this->mail_model->getUserSentMailDetails($msg_id, $type, $user_id);
            for ($i = 0; $i < count($mail_details); $i++) {
                $mail_details[$i]['msg'] = htmlspecialchars_decode($mail_details[$i]['mailtousmsg']);
            }
        }
        $this->set('mail_details', $mail_details);
        $this->set('mail_type', $type);
        $this->setView();

    }
}
