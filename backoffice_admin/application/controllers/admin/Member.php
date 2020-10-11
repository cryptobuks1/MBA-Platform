<?php

define("IN_WALLET", true);
require "../vendor/autoload.php";

use Blocktrail\SDK\BlocktrailSDK;

require_once 'Inf_Controller.php';

class member extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ewallet_model', '', true);
          $this->load->model('video_model', '', true);
    }

    function search_member()
    {

        $title = lang('search_member');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('search_member');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('search_member');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "search-member";
        $this->set("help_link", $help_link);
        if ($this->input->post('reset')) {
            $this->session->set_userdata('inf_ser_keyword', '');
        } else if ($this->input->post('search_member') && $this->validate_search_member() && $this->validate_member()) { } elseif (!$this->session->userdata('inf_ser_keyword')) {
            $this->session->set_userdata('inf_ser_keyword', '');
        }

        $flag = false;
        if ($this->session->has_userdata('inf_ser_keyword')) {
            $numrows = $this->member_model->getCountMembers($this->session->userdata('inf_ser_keyword'));
            if (!$numrows) {
                $this->session->unset_userdata('inf_ser_keyword');
                $msg = lang('No_User_Found');
                $this->redirect($msg, "member/search_member", false);
            }

            $flag = true;
            $base_url = base_url() . 'admin/search_member';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;
            $config['total_rows'] = $numrows;

            if ($this->uri->segment(3) != "") {
                $page = $this->uri->segment(3);
            } else {
                $page = 0;
            }

            $mem_details_arr = $this->member_model->searchMembers($this->session->userdata('inf_ser_keyword'), $page, $config['per_page']);
            $count = count($mem_details_arr);

            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $this->set("mem_arr", $this->security->xss_clean($mem_details_arr));
            $this->set("count", $count);
            $this->set('result_per_page', $result_per_page);
            $this->set('page_id', $page);
            $this->set('search_key', $this->session->userdata('inf_ser_keyword'));
        }
        $this->set('search_key', '');
        $this->set('flag', $flag);
        $this->setView();
    }

    public function validate_member()
    {
        $this->form_validation->set_rules('keyword', lang('keyword'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function validate_search_member()
    {

        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post(null, true));
        $keyword = $post_arr['keyword'];

        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {

            $check_user_id = $this->validation_model->userNameToID($keyword);
            $check_user_type = $this->validation_model->getUserType($check_user_id);
            if ($check_user_type == 'admin') {
                $msg = lang('you_cant_access_admin');
                $this->redirect($msg, "member/search_member", false);
            }
        }

        if ($keyword != "" && $keyword != "'") {

            $this->session->set_userdata('inf_ser_keyword', $keyword);
        }

        return true;
    }

    public function validate_upgrade_account()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('remarks', lang('remarks'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function leads()
    {

        $title = lang('lead');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('lead_capture_status');

        $this->HEADER_LANG['page_top_header'] = lang('lead');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('lead');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $lcp_url = base_url() . "../";

        $help_link = "Leads";
        $this->set("help_link", $help_link);
        $this->set("lcp_url", $lcp_url);

        $user_id = $this->LOG_USER_ID;
        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];
        $prefix = str_replace('_', '', $table_prefix);
        $key_word = '';
        $username = $this->member_model->IdToUserName($user_id);
        $this->set("tran_user_name", $username);
        if ($this->input->post('search_lead')) {
            $key_word = ($this->input->post('keyword', true));
            if (!$key_word) {
                $msg = lang('You must enter a keyword');
                $this->redirect($msg, "member/leads", false);
            }
            $this->session->set_userdata('search_keyword', $key_word);
        }
        if (!$this->session->has_userdata('search_keyword')) {
            $this->session->set_userdata('search_keyword', $key_word);
        }
        if (!$this->uri->segment(4) && !$this->input->post()) {
            $this->session->unset_userdata('search_keyword');
        }

        $base_url = base_url() . "admin/leads";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;;
        $total_rows = $this->member_model->getLeadDetailsCount('', $this->session->userdata('search_keyword'));
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $details = $this->member_model->getLeadDetails('', $this->session->userdata('search_keyword'), $config['per_page'], $page);
        $this->set("details", $this->security->xss_clean($details));
        $this->set("id", $user_id);
        $this->set("prefix", $prefix);

        $this->setView();
    }

    public function getleads()
    {
        $details = array();
        $id = $this->input->post('id', true);
        $details = $this->member_model->getLeadDetailsById($id);
        $comment_admin = $this->member_model->getAdminComent($id);
        $pending_status = '';
        $following_status = '';
        $reg_status = '';
        $dec_status = '';
        $i = 1;
        $details = $this->security->xss_clean($details);
        $comment_admin = $this->security->xss_clean($comment_admin);
        if ($details['lead_status'] == 'Ongoing') {
            $following_status = 'selected';
        } elseif ($details['lead_status'] == 'Accepted') {
            $reg_status = 'selected';
        } elseif ($details['lead_status'] == 'Rejected') {
            $dec_status = 'selected';
        }
        $csrf_token_name = $this->CSRF_TOKEN_NAME;
        $csrf_token_value = $this->CSRF_TOKEN_VALUE;
        if ($details) {
            if (!$details["first_name"])
                $details["first_name"] = 'NA';
            if (!$details["sponser_name"])
                $details["sponser_name"] = 'NA';
            if (!$details["email_id"])
                $details["email_id"] = 'NA';
            if (!$details["skype_id"])
                $details["skype_id"] = 'NA';
            if (!$details["mobile_no"])
                $details["mobile_no"] = 'NA';
            if (!$details["country"])
                $details["country"] = 'NA';
            if (!$details["date"])
                $details["date"] = 'NA';
            if (!$details["description"])
                $details["description"] = 'NA';
        }

        $this->set('details', $details);
        $this->set('comment_admin', $comment_admin);
        $this->set('following_status', $following_status);
        $this->set('reg_status', $reg_status);
        $this->set('dec_status', $dec_status);

        $this->setView();
    }

    public function edit_Lead_Capture()
    {
        $res1 = $res2 = false;
        if ($this->input->post('edit_lead')) {
            $det = $this->input->post(null, true);
            $det = $this->validation_model->stripTagsPostArray($det);
            $res1 = $this->member_model->addFollowup($det);
            $res2 = $this->member_model->updateCRM($det);
            $lead_details = $this->member_model->getLeadDetailsById($det['lead_id']);
            $lead_details['new_status'] = $det["status"];
            $lead_details['admin_comment'] = $det["admin_comment"];
            $lead_details['email'] = $lead_details["email_id"];

            if ($res1 && $res2) {
                $this->load->model('mail_model');
                $this->mail_model->sendAllEmails("lcp_reply", $lead_details);
                $msg = lang('lead_capture_updated');
                $this->redirect($msg, "member/leads", true);
            } else
                if ($res2) {
                $msg = lang('lead_capture_updated');
                $this->redirect($msg, "member/leads", true);
            } else {
                $msg = lang('unable_to_update_lead_capture');
                $this->redirect($msg, "member/leads", false);
            }
        }
    }

    public function text_invite_configuration()
    {

        $this->check_menu_promotion();

        $title = lang('text_invite');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('text_invite');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('text_invite');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'text invite';
        $this->set("help_link", $help_link);

        $base_url = base_url() . "admin/member/text_invite_configuration";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->member_model->getTextInvitesDataCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $mail_data = $this->member_model->getTextInvitesData($config['per_page'], $page);
        $this->set("mail_data", $this->security->xss_clean($mail_data));

        if ($this->input->post('update') && $this->validate_invite_text()) {

            $update_post_array = $this->input->post(null, true);
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
            $update_post_array['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));

            $mail_content['mail_content'] = $update_post_array['mail_content'];
            $mail_content['subject'] = $update_post_array['subject'];
            $res = $this->member_model->insertTextInvites($mail_content);
            if ($res) {
                $data = serialize($update_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_text_invite', 'Text Invite Added');
                }
                //

                $msg = lang('invite_text_added');
                $this->redirect($msg, "member/text_invite_configuration", true);
            } else {
                $msg = lang('invite_text_not_added');
                $this->redirect($msg, "member/text_invite_configuration", false);
            }
        }

        $this->setView();
    }

    public function edit_invite_text()
    {

        if ($this->input->post('invite_text_id')) {
            $title = lang('edit_text_invite');
            $this->set("title", $this->COMPANY_NAME . " | $title");

            $this->HEADER_LANG['page_top_header'] = lang('edit_text_invite');
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = lang('edit_text_invite');
            $this->HEADER_LANG['page_small_header'] = '';

            $this->load_langauge_scripts();

            $help_link = lang('text_invite');
            $this->set("help_link", $help_link);

            $edit_id = $this->input->post('invite_text_id', true);
            $mail_details = $this->member_model->getTextInvitesDataById($edit_id);
            $this->set('mail_details', $mail_details);
            if ($this->input->post('update')) {
                $update_post_array = $this->input->post(null, true);
                $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
                $update_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                if ($this->validate_invite_text()) {
                    $mail_content['mail_content'] = $update_post_array['mail_content'];
                    $mail_content['subject'] = $update_post_array['subject'];
                    $mail_content['id'] = $update_post_array['invite_text_id'];
                    $res = $this->member_model->editTextInvites($mail_content);
                    if ($res) {
                        $data = serialize($update_post_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite edited', $this->LOG_USER_ID, $data);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_text_invite', 'Text Invite Updated');
                        }
                        //

                        $msg = lang('updated_invite_text');
                        $this->redirect($msg, "member/text_invite_configuration", true);
                    } else {
                        $msg = lang('invite_text_not_updated');
                        $this->redirect($msg, "member/text_invite_configuration", false);
                    }
                }
            }

            $this->setView();
        } else {
            $this->redirect('', "member/text_invite_configuration", true);
        }
    }

    public function validate_invite_text()
    {
        $this->form_validation->set_rules('subject', lang('subject'), 'required|max_length[50]');
        $this->form_validation->set_rules('mail_content', lang('content'), 'required|max_length[200]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function delete_invite_text()
    {
        $invite_text_id = (strip_tags($this->input->post('invite_text_id', true)));
        $res = $this->member_model->deleteInviteText($invite_text_id);
        if ($res) {
            $data_array['text_invite_id'] = $invite_text_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite deleted', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_text_invite', 'Text Invite Deleted');
            }
            //

            $msg = lang('invite_text_deleted');
            $this->redirect($msg, "member/text_invite_configuration", true);
        } else {
            $msg = lang('invite_text_not_deleted');
            $this->redirect($msg, "member/text_invite_configuration", false);
        }
    }

    public function invite_wallpost_config($type = 'email')
    {

        $this->check_menu_promotion();
        $title = lang('social_invites');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('social_invites');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('social_invites');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'wallpost';
        $this->set("help_link", $help_link);

        $pagination1 = new CI_Pagination();
        $base_url1 = base_url() . "admin/member/invite_wallpost_config";
        $config1 = $pagination1->customize_style();
        $config1['base_url'] = $base_url1;
        $config1['per_page'] = 10;
        $total_rows1 = $this->member_model->getSocialInviteDataCount('social_email');
        $config1['total_rows'] = $total_rows1;
        $config1["uri_segment"] = 4;
        $pagination1->initialize($config1);
        if ($type == 'fb' || $type == 'twitter' || $type == 'instagram') {
            $page1 = 0;
        } else {
            $page1 = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        }
        $result_per_page1 = $pagination1->create_links();
        $this->set("result_per_page1", $result_per_page1);
        $this->set("page1", $page1);

        $pagination2 = new CI_Pagination();
        $base_url2 = base_url() . "admin/member/invite_wallpost_config/fb";
        $config2 = $pagination2->customize_style();
        $config2['base_url'] = $base_url2;
        $config2['per_page'] = 10;
        $total_rows2 = $this->member_model->getSocialInviteDataCount('social_fb');
        $config2['total_rows'] = $total_rows2;
        $config2["uri_segment"] = 5;
        $pagination2->initialize($config2);
        if ($type == 'email' || $type == 'twitter' || $type == 'instagram') {
            $page2 = 0;
        } else {
            $page2 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        }
        $result_per_page2 = $pagination2->create_links();
        $this->set("result_per_page2", $result_per_page2);
        $this->set("page2", $page2);

        $pagination4 = new CI_Pagination();
        $base_url4 = base_url() . "admin/member/invite_wallpost_config/twitter/tab/tab";
        $config4 = $pagination4->customize_style();
        $config4['base_url'] = $base_url4;
        $config4['per_page'] = 10;
        $total_rows4 = $this->member_model->getSocialInviteDataCount('social_twitter');
        $config4['total_rows'] = $total_rows4;
        $config4["uri_segment"] = 7;
        $pagination4->initialize($config4);
        if ($type == 'email' || $type == 'fb' || $type == 'instagram') {
            $page4 = 0;
        } else {
            $page4 = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
        }

        $result_per_page4 = $pagination4->create_links();
        $this->set("result_per_page4", $result_per_page4);
        $this->set("page4", $page4);

        $pagination5 = new CI_Pagination();
        $base_url5 = base_url() . "admin/member/invite_wallpost_config/instagram/tab/tab/tab";
        $config5 = $pagination5->customize_style();
        $config5['base_url'] = $base_url5;
        $config5['per_page'] = 10;
        $total_rows5 = $this->member_model->getSocialInviteDataCount('social_instagram');
        $config5['total_rows'] = $total_rows5;
        $config5["uri_segment"] = 8;
        $pagination5->initialize($config5);
        if ($type == 'email' || $type == 'fb' || $type == 'twitter') {
            $page5 = 0;
        } else {
            $page5 = ($this->uri->segment(8)) ? $this->uri->segment(8) : 0;
        }
        $result_per_page5 = $pagination5->create_links();
        $this->set("result_per_page5", $result_per_page5);
        $this->set("page5", $page5);

        $social_invite_email = $this->member_model->getSocialInviteData('social_email', $config1['per_page'], $page1);
        $social_invite_fb = $this->member_model->getSocialInviteData('social_fb', $config2['per_page'], $page2);
        $social_invite_twitter = $this->member_model->getSocialInviteData('social_twitter', $config4['per_page'], $page4);
        $social_invite_instagram = $this->member_model->getSocialInviteData('social_instagram', $config5['per_page'], $page5);

        $this->set("social_invite_email", $this->security->xss_clean($social_invite_email));
        $this->set("social_invite_fb", $this->security->xss_clean($social_invite_fb));
        $this->set("social_invite_twitter", $this->security->xss_clean($social_invite_twitter));
        $this->set("social_invite_instagram", $this->security->xss_clean($social_invite_instagram));

        if ($this->input->post('submit_email') && $this->validate_invite_social_email()) {
            $details = $this->input->post(null, true);
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $res = $this->member_model->insertsocialInvites($details, 'social_email');
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'email invite updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_email_invite', 'Email Invite Added');
                }
                //

                $msg = lang('email_invite_added');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_add_email_invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        if ($this->input->post('submit_fb') && $this->validate_invite_social_fb()) {
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('caption'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('description'));
            $res = $this->member_model->insertsocialInvites($details, 'social_fb');
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'facebook invite updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_facebook_invite', 'Facebook Invite Added');
                }
                //

                $msg = lang('fb_invite_added');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_add_fb_invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        $this->setView();
    }

    public function validate_invite_social_email()
    {
        $this->form_validation->set_rules('subject', lang('subject'), 'required|max_length[50]');
        $this->form_validation->set_rules('message', lang('message'), 'required|max_length[200]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function validate_invite_social_fb()
    {
        $this->form_validation->set_rules('caption', lang('caption'), 'required|max_length[50]');
        $this->form_validation->set_rules('description', lang('description'), 'required|max_length[200]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function edit_invite_wallpost()
    {

        if ($this->input->post('invite_text_id')) {
            $title = lang('edit_email_invite');
            $this->set("title", $this->COMPANY_NAME . " | $title");

            $this->HEADER_LANG['page_top_header'] = lang('edit_email_invite');
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = lang('edit_email_invite');
            $this->HEADER_LANG['page_small_header'] = '';


            $help_link = lang('edit_email_invite');
            $this->set("help_link", $help_link);

            $edit_id = $this->input->post('invite_text_id', true);
            $type = $this->input->post('type', true);
            if ($type == "social_fb") {
                $title = lang('edit_facebook_invite');
                $this->HEADER_LANG['page_top_header'] = lang('edit_facebook_invite');
                $this->HEADER_LANG['page_header'] = lang('edit_facebook_invite');
                $media = 'facebook';
            } else if ($type == "social_twitter") {
                $title = lang('edit_twitter_invite');
                $this->HEADER_LANG['page_top_header'] = lang('edit_twitter_invite');
                $this->HEADER_LANG['page_header'] = lang('edit_twitter_invite');
                $media = 'twitter';
            } elseif ($type == "social_instagram") {
                $title = lang('edit_instagram_invite');
                $this->HEADER_LANG['page_top_header'] = lang('edit_instagram_invite');
                $this->HEADER_LANG['page_header'] = lang('edit_instagram_invite');
                $media = 'instagram';
            } else {
                $media = 'email';
            }
            $this->load_langauge_scripts();

            $mail_details = $this->member_model->getSocialInvitesDataById($edit_id, $type);
            $this->set('mail_details', $mail_details);
            if ($this->input->post('update')) {
                $update_post_array = $this->input->post(null, true);
                $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
                $update_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                if ($this->validate_invite_text()) {
                    $mail_content['mail_content'] = $update_post_array['mail_content'];
                    $mail_content['subject'] = $update_post_array['subject'];
                    $mail_content['id'] = $update_post_array['invite_text_id'];
                    $res = $this->member_model->editTextInvites($mail_content);
                    if ($res) {
                        $data = serialize($update_post_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Social invite edited', $this->LOG_USER_ID, $data);

                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_social_invite', 'Social Invite Updated');
                        }
                        //

                        $msg = lang($media) . lang('invite_updated');
                        $this->redirect($msg, "member/invite_wallpost_config", true);
                    } else {
                        $msg = lang($media) . lang('invite_not_updated');
                        $this->redirect($msg, "member/invite_wallpost_config", false);
                    }
                }
            }
            $this->set('panel_head', $title);
            $this->set('type', $type);
            $this->setView();
        } else {
            $this->redirect('', "member/text_invite_configuration", true);
        }
    }

    public function invite_banner_config()
    {

        $this->check_menu_promotion();
        $title = lang('banner');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('banner');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('banner');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'banner';
        $this->set("help_link", $help_link);

        $base_url = base_url() . "admin/member/invite_banner_config";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->member_model->getBannersCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $banners = $this->member_model->getBanners($config['per_page'], $page);
        $this->set("banners", $this->security->xss_clean($banners));

        if ($this->input->post('banner')) {

            $details = array();

            $config['upload_path'] = IMG_DIR . 'banners/';
            $config['allowed_types'] = 'png';
            $config['max_size'] = '20000000';
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('banner_image')) {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'You did not select a file to upload.') {
                    $msg = lang('please_select_file');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                }
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('exceeded_max_size');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                } else {
                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'member/invite_banner_config', false);
                }
            } else {
                $banner_arr = array('upload_data' => $this->upload->data());
            }
            $details['product_url'] = $banner_arr['upload_data']['file_name'];
            $res = $this->member_model->insertBanner($banner_arr['upload_data']['file_name']);

            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_banner_invite', 'Banner Invite Added');
                }
                //

                $msg = lang('banner_added');
                $this->redirect($msg, "member/invite_banner_config/", true);
            } else {
                $msg = lang('banner_not_added');
                $this->redirect($msg, "member/invite_banner_config/", false);
            }
        }
        $this->setView();
    }

    public function delete_banner()
    {
        $banner_id = $this->input->post('banner_id', true);

        $res = $this->member_model->deleteBanner($banner_id);
        if ($res) {
            $data_array['banner_id'] = $banner_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite deleted', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_banner_invite', 'Banner Invite Deleted');
            }
            //

            $msg = lang('banner_deleted');
            $this->redirect($msg, "member/invite_banner_config", true);
        } else {
            $msg = lang('banner_not_deleted');
            $this->redirect($msg, "member/invite_banner_config", false);
        }
    }

    function package_validity($id = "")
    {
        $this->url_permission('product_validity');
        $title = lang('upgrade_package_validity');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('upgrade_package_validity');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upgrade_package_validity');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "package-validity";
        $this->set("help_link", $help_link);

        $base_url = base_url() . "admin/member/package_validity";

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else
            $page = 0;

        if (!$this->input->post('search_member') && $this->validate_upgrade_account()) {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_upgrade_package_validity_error', $error_array);
        }

        $error_array = array();
        if ($this->session->userdata('inf_upgrade_package_validity_error')) {
            $error_array = $this->session->userdata('inf_upgrade_package_validity_error');
            $this->session->unset_userdata('inf_upgrade_package_validity_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;

        $user_id = '';

        if ($this->input->post('user_name')) {
            $user_name = $this->input->post('user_name', true);
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$this->validation_model->isUserAvailable($user_id)) {
                $this->redirect(lang('invalid_user_name'), "member/package_validity", false);
            }
            $page = $config['per_page'] = 0;
        }

        $numrows = $this->member_model->getPackageExpiredUsersCount($this->ADMIN_USER_ID, $user_id);
        $config['total_rows'] = $numrows;
        $this->set("count", $numrows);
        $this->pagination->initialize($config);

        $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $user_id, $page, $config['per_page']);

        $this->set("expired_users", $expired_users);
        $result_per_page = $this->pagination->create_links();

        $this->set("result_per_page", $result_per_page);
        $this->set("page_num", $page);

        $this->setView();
    }

    function upgrade_package_validity($url_username = "")
    {
        $this->load->model('product_model');
        $this->load->model('register_model');

        $title = lang('upgrade_package_validity');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('upgrade_package_validity');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upgrade_package_validity');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "package-validity";
        $this->set("help_link", $help_link);

        if (!$url_username) {
            $this->redirect('', 'package_validity');
        }

        $user_id = '';
        $decode_id = urldecode($url_username);
        $decode_id = str_replace('_', '/', $decode_id);
        $user_name = $this->encrypt->decode($decode_id);
        $user_id = $this->validation_model->userNameToID($user_name);

        if (!$user_id) {
            $msg = lang('invalid_user');
            $this->redirect($msg, 'member/package_validity', false);
        }
        $this->set('user_id', $user_name);
        $user_img = $this->validation_model->getProfilePicture($user_id);
        $this->set('user_img', $user_img);

        $product_id = $this->validation_model->getProductId($user_id);
        $package_id = $this->product_model->getProdId($product_id, $this->MODULE_STATUS, 'registration');
        $product_status = $this->product_model->isProductAvailable($package_id);

        $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $user_id);
        $expired_users = $expired_users[0];
        $this->set("expired_users", $expired_users);
        $this->set("product_status", !$product_status);

        $pin_count = 0;
        if ($this->session->userdata("inf_package_validity_upgrade_post_array")) {
            $validity_post_array = $this->session->userdata("inf_package_validity_upgrade_post_array");
            $pin_count = $validity_post_array['pin_count'];
            $this->session->unset_userdata("inf_package_validity_upgrade_post_array");
        }
        $this->set('pin_count', $pin_count);

        $product_amount = $this->product_model->getProduct($expired_users['product_id']);
        $this->set('product_amount', $product_amount);

        $payment_methods_tab = false;
        $payment_gateway_array = array();
        $payment_module_status_array = array();

        if ($this->MODULE_STATUS['product_status'] == 'yes') {
            $payment_methods_tab = true;
            $payment_gateway_array = $this->register_model->getPaymentGatewayStatus("membership_renewal");
            $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        }
        $this->set('payment_methods_tab', $payment_methods_tab);
        $this->set('payment_gateway_array', $payment_gateway_array);
        $this->set('payment_module_status_array', $payment_module_status_array);
        $this->set('mlm_plan', $this->MLM_PLAN);
        $this->set('username_type', $this->LOG_USER_TYPE);

        $this->setView();
    }

    function package_validity_submit()
    {
        $this->load->model('repurchase_model');
        $package_validity_upgrade = $this->input->post(null, true);
        $package_validity_upgrade['user_id'] = $this->validation_model->userNameToID($package_validity_upgrade['user_id']);

        $module_status = $this->MODULE_STATUS;
        $is_pin_ok = false;
        $is_ewallet_ok = false;
        $is_paypal_ok = false;
        $is_authorize_ok = false;
        $is_blockchain_ok = false;
        $is_bitgo_ok = false;
        $is_bitcoin_ok = false;
        $is_free_join_ok = false;
        $is_payeer_ok = false;
        $is_sofort_ok = false;
        $is_squareup_ok = false;

        $payment_gateway_array = $this->register_model->getPaymentGatewayStatus("membership_renewal");

        $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $package_validity_upgrade['user_id']);
        $expired_users = $expired_users[0];

        $purchase['total_amount'] = $this->product_model->getProduct($expired_users['product_id']);
        $this->set('product_amount', $purchase['total_amount']);

        // $purchase['user_id'] = $this->LOG_USER_ID;
        $purchase['user_id'] = $package_validity_upgrade['user_id'];
        $package_details[0]['id'] = $expired_users['product_id'];
        $is_user_available = $this->validation_model->isUserAvailable($purchase['user_id']);
        // print_r($package_validity_upgrade);die();
        if (!$is_user_available) {
            $msg = lang('invalid_user');
            $this->redirect($msg, 'member/package_validity', false);
        }

        $product_id = $this->validation_model->getProductId($package_validity_upgrade['user_id']);
        $package_id = $this->product_model->getProdId($product_id, $this->MODULE_STATUS, 'registration');
        $product_status = $this->product_model->isProductAvailable($package_id);
        if (!$product_status) {
            $msg = $this->lang->line('your_product_currently_not_available');
            $this->redirect($msg, 'member/package_validity', false);
        }

        if ($package_validity_upgrade['active_tab'] == "epin_tab") {
            $payment_type = 'epin';
            $upgrade_user_id = $package_validity_upgrade['user_id'];
            $pin_count = count($package_validity_upgrade['epin']);
            $pin_details = $package_validity_upgrade['epin'];
            $pin_data = [];
            $i = 1;
            foreach ($pin_details as $v) {
                $pin_data[$i]['pin'] = $v;
                $pin_data[$i]['pin_amount'] = 0;
                $i++;
            }

            $pin_array = $this->repurchase_model->validateAllEpins($pin_data, $purchase['total_amount'], $this->LOG_USER_ID, $upgrade_user_id);


            $is_pin_ok = !(in_array('nopin', array_column($pin_array, 'pin')));
            if (!$is_pin_ok) {
                $msg = $this->lang->line('Invalid Epins');
                $this->redirect($msg, "member/package_validity", false);
            }
            $is_pin_duplicate = (count(array_column($pin_array, 'pin')) != count(array_unique(array_column($pin_array, 'pin'))));
            if ($is_pin_duplicate) {
                $msg = $this->lang->line('duplicate_epin');
                $this->redirect($msg, "member/package_validity", false);
            }
        } elseif ($package_validity_upgrade['active_tab'] == "ewallet_tab") {

            $payment_type = 'ewallet';
            $used_amount = $purchase['total_amount'];
            $ewallet_user = $package_validity_upgrade['user_name_ewallet'];
            $ewallet_trans_password = base64_decode(urldecode($package_validity_upgrade['tran_pass_ewallet']));
            $upgrade_user = $package_validity_upgrade['user_id'];
            $upgrade_username = $this->validation_model->IdToUserName($upgrade_user);
            $admin_username = $this->validation_model->getAdminUsername();
            if ($ewallet_user != "") {
                if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
                    if ($ewallet_user != $admin_username && $ewallet_user != $upgrade_username) {
                        $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                        $this->redirect($msg, "member/package_validity", false);
                    }
                } else
                    if ($this->LOG_USER_TYPE == 'user') {
                    if ($ewallet_user != $this->LOG_USER_NAME) {
                        $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                        $this->redirect($msg, "member/package_validity", false);
                    }
                }
                $ewallet_user_id = $this->validation_model->userNameToID($ewallet_user);

                $user_available = $this->validation_model->isUserAvailable($ewallet_user_id);
                if ($user_available) {
                    if ($ewallet_trans_password != "") {
                        $ewallet_user_id = $this->validation_model->userNameToID($ewallet_user);
                        $trans_pass_available = $this->register_model->checkEwalletPassword($ewallet_user_id, $ewallet_trans_password);
                        if ($trans_pass_available == 'yes') {

                            $ewallet_balance_amount = $this->register_model->getBalanceAmount($ewallet_user_id);
                            if ($ewallet_balance_amount >= $used_amount) {
                                $is_ewallet_ok = true;
                            } else {
                                $msg = $this->lang->line('insuff_bal');
                                $this->redirect($msg, "member/package_validity", false);
                            }
                        } else {
                            $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
                            $this->redirect($msg, "member/package_validity", false);
                        }
                    } else {
                        $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
                        $this->redirect($msg, "member/package_validity", false);
                    }
                } else {
                    $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                    $this->redirect($msg, "member/package_validity", false);
                }
            } else {
                $msg = $this->lang->line('invalid_user_name_ewallet_tab');
                $this->redirect($msg, "member/package_validity", false);
            }
        } elseif (($package_validity_upgrade['active_tab'] == "paypal_tab")) {
            if ($payment_gateway_array['paypal_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'paypal';
            $is_paypal_ok = true;
        } elseif (($package_validity_upgrade['active_tab'] == "authorize_tab")) {
            if ($payment_gateway_array['authorize_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'Athurize.Net';
            $is_authorize_ok = true;
        } elseif (($package_validity_upgrade['active_tab'] == "free_join_tab")) {
            $free_payment_status = $this->register_model->getPaymentStatus('Free Joining');
            if ($free_payment_status == 'no') {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'free_purchase';
            $is_free_join_ok = true;
        } else
            if (($package_validity_upgrade['active_tab'] == "blockchain_tab")) {
            if ($payment_gateway_array['blockchain_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'blockchain';
            $is_blockchain_ok = true;
        } elseif (($package_validity_upgrade['active_tab'] == "bitgo_tab")) {
            if ($payment_gateway_array['bitgo_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'bitgo';
            $is_bitgo_ok = true;
        } else
            if (($package_validity_upgrade['active_tab'] == "bitcoin_tab")) {
            if ($payment_gateway_array['bitcoin_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'bitcoin';
            $is_bitcoin_ok = true;
        } elseif (($package_validity_upgrade['active_tab'] == "sofort_tab")) {
            if ($payment_gateway_array['sofort_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'sofort';
            $is_sofort_ok = true;
        } elseif (($package_validity_upgrade['active_tab'] == "payeer_tab")) {
            if ($payment_gateway_array['payeer_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'payeer';
            $is_payeer_ok = true;
        } elseif (($package_validity_upgrade['active_tab'] == "squareup_tab")) {
            if ($payment_gateway_array['squareup_status'] == "no") {
                $msg = lang('payment_method_not_available');
                $this->redirect($msg, "member/package_validity", false);
            }
            $payment_type = 'squareup';
            $is_squareup_ok = true;
        }

        $purchase['payment_type'] = $payment_type;

        if ($is_pin_ok) {
            $this->repurchase_model->begin();
            $purchase['by_using'] = 'pin';

            $pin_array['user_id'] = $purchase['user_id'];
            $res = $this->register_model->UpdateUsedEpin($pin_array, $pin_count, 'repurchase');
            if ($res) {
                $this->register_model->insertUsedPin($pin_array, $pin_count, false, 'package_validity');
                $payment_status = true;
            }
        } elseif ($is_ewallet_ok) {
            $this->repurchase_model->begin();
            $purchase['by_using'] = 'ewallet';
            $used_user_id = $this->validation_model->userNameToID($ewallet_user);
            $transaction_id = $this->repurchase_model->getUniqueTransactionId();
            $res1 = $this->register_model->insertUsedEwallet($used_user_id, $purchase['user_id'], $used_amount, $transaction_id, false, "package_validity");
            if ($res1) {
                $res2 = $this->register_model->deductFromBalanceAmount($used_user_id, $used_amount);
                if ($res2) {
                    $payment_status = true;
                }
            }
            // $this->repurchase_model->rollback();die();
        } elseif ($is_paypal_ok) {
            $purchase['by_using'] = 'paypal';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $this->session->set_userdata('package_details', $package_details);
            $msg = "";
            //            $this->payNow($package_details, $purchase);
            $this->redirect($msg, "/member/payNow/", false);
        } elseif ($is_authorize_ok) {
            $purchase['by_using'] = 'Authorize.Net';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $this->redirect($msg, "/member/authorizeNetPayment/", false);
        } elseif ($is_free_join_ok) {
            $purchase['by_using'] = 'free join';
            $this->repurchase_model->begin();
            $payment_status = true;
        } elseif ($is_blockchain_ok) {
            $purchase['by_using'] = 'blockchain';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $this->redirect($msg, "/member/blockchain", false);
        } elseif ($is_bitgo_ok) {
            $purchase['by_using'] = 'bitgo';
            $purchase['is_new'] = 'yes';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $this->redirect($msg, "/member/bitgo_gateway/", false);
        } elseif ($is_bitcoin_ok) {
            $purchase['by_using'] = 'bitcoin';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $this->redirect($msg, "/member/bitcoin_payment/", false);
        } elseif ($is_sofort_ok) {
            $purchase['by_using'] = 'sofort';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $this->redirect($msg, "/member/sofort_payment/", false);
        } elseif ($is_payeer_ok) {
            $purchase['by_using'] = 'payeer';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $data = array(
                'user_id' => $package_validity_upgrade['user_id'],
                'product_id' => $expired_users['product_id'],
                'product_name' => $this->register_model->getProductName($expired_users['product_id']),
                'product_amount' => $purchase['total_amount'],
                'currency' => 'EUR',
            );
            $this->session->set_userdata('payeer_data', $data);
            $this->redirect($msg, "/member/payeer_payment/", false);
        } elseif ($is_squareup_ok) {
            $purchase['by_using'] = 'squareup';
            $this->session->set_userdata('inf_package_validity', $purchase);
            $msg = "";
            $this->redirect($msg, "/member/squareup_payment/", false);
        }
        if ($payment_status) {

            $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase);
            $data = serialize($purchase);
            $login_id = $this->LOG_USER_ID;
            if ($this->LOG_USER_TYPE == 'admin') {
                $user_name = $this->validation_model->getUserName($purchase['user_id']);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), $purchase['user_id'], $data);
            } elseif ($this->LOG_USER_TYPE == 'employee') {
                $user_name = $this->validation_model->getUserName($purchase['user_id']);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), $this->LOG_USER_ID, $data);
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']));
            } else {
                $user_name = $this->validation_model->getUserName($login_id);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), $login_id, $data);
            }

            if ($this->MLM_PLAN == "Stair_Step") {
                $this->repurchase_model->updateUserPv($package_details, $purchase);
            }

            if ($invoice_no) {
                $this->repurchase_model->commit();
                $this->session->unset_userdata('package_validity_upgrade_array');
                $this->session->unset_userdata('inf_package_validity_upgrade_array');
                $msg = lang('package_successfully_updated');
                $enc_order_id = $this->validation_model->encrypt($invoice_no);
                $this->redirect("<span>$msg :  $invoice_no </span>", "member/package_validity", true);
            } else {
                $this->repurchase_model->rollback();
                $msg = lang('package_updation_error');
                $this->redirect($msg, '/member/package_validity', false);
            }
        } else {
            $this->repurchase_model->rollback();
            $msg = lang('payment_type_dosnot_selected');
            $this->redirect($msg, '/member/package_validity', false);
        }
    }

    function payNow()
    {
        require(dirname(__FILE__) . '/../Paypal.php');
        $paypal = new Paypal;
        $this->load->model('repurchase_model');
        $cart_products = $this->session->userdata('package_details');
        $purchase_details = $this->session->userdata('inf_package_validity');
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();

        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";

        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        //        $usd_conevrsion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);

        $usd_conevrsion_rate = 1;
        $total_amount = round($purchase_details['total_amount'] * $usd_conevrsion_rate, 8);
        $this->session->set_userdata('cart_products', $cart_products);

        $description = "Package Validity Upgrade " . $this->COMPANY_NAME;
        $description .= "\nPackage Amount : $paypal_currency_left_symbol $total_amount $paypal_currency_right_symbol";

        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'item' => "Package Repuchase",
            'description' => $description,
            'currency' => $paypal_currency_code,
            'return_url' => $base_url . $this->LOG_USER_TYPE . "/" . $paypal_details['package_validity_return_url'],
            'cancel_url' => $base_url . $this->LOG_USER_TYPE . "/" . $paypal_details['package_validity_cancel_url']
        );
        $response = $paypal->initilize($params);
    }

    function payment_success()
    {
        require(dirname(__FILE__) . '/../Paypal.php');
        $paypal = new Paypal;
        $this->load->model('repurchase_model');

        $paypal_currency_code = "USD";
        $paypal_currency_left_symbol = "$";
        $paypal_currency_right_symbol = "";
        $default_currency_code = ($this->DEFAULT_CURRENCY_CODE != '') ? $this->DEFAULT_CURRENCY_CODE : "USD";
        $default_currency_left_symbol = ($this->DEFAULT_SYMBOL_LEFT != '') ? $this->DEFAULT_SYMBOL_LEFT : "$";
        $default_currency_right_symbol = ($this->DEFAULT_SYMBOL_RIGHT != '') ? $this->DEFAULT_SYMBOL_RIGHT : "";

        $usd_conevrsion_rate = $this->currency_model->getCurrencyConversionRate($default_currency_code, $paypal_currency_code);
        $usd_conevrsion_rate = 1;
        $purchase = $this->session->userdata('inf_package_validity');
        $total_amount = round($purchase['total_amount'] * $usd_conevrsion_rate, 8);

        $paypal_details = $this->configuration_model->getPaypalConfigDetails();

        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'currency' => $paypal_details['currency'],
            'return_url' => $base_url . $this->LOG_USER_TYPE . "/" . $paypal_details['package_validity_return_url'],
            'cancel_url' => $base_url . $this->LOG_USER_TYPE . "/" . $paypal_details['package_validity_cancel_url']
        );

        $response = $paypal->callback($params);

        if ($response->success()) {
            $paypal_output = $this->input->get();

            $user_id = $purchase["user_id"];
            $payment_details = array(
                'payment_method' => 'paypal',
                'token_id' => $paypal_output['token'],
                'currency' => $paypal_details['currency'],
                'amount' => $total_amount,
                'acceptance' => '',
                'payer_id' => $paypal_output['PayerID'],
                'user_id' => $user_id,
                'status' => '',
                'card_number' => '',
                'ED' => '',
                'card_holder_name' => '',
                'submit_date' => date("Y-m-d H:i:s"),
                'pay_id' => '',
                'error_status' => '',
                'brand' => ''
            );

            $this->register_model->insertintoPaymentDetails($payment_details);
            $purchase['by_using'] = 'paypal';
            $this->repurchase_model->begin();

            $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase['user_id']);
            $package_details[0]['id'] = $expired_users[0]['product_id'];
            $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase);
            $data = serialize($purchase);
            $login_id = $this->LOG_USER_ID;
            if ($this->LOG_USER_TYPE == 'admin') {
                $user_name = $this->validation_model->getUserName($purchase['user_id']);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), $purchase['user_id'], $data);
            } else {
                $user_name = $this->validation_model->getUserName($login_id);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), $login_id, $data);
            }

            if ($this->MLM_PLAN == "Stair_Step") {
                $this->repurchase_model->updateUserPv($package_details, $purchase);
            }

            if ($invoice_no) {
                $this->repurchase_model->commit();
                $this->session->unset_userdata('package_validity_upgrade_array');
                $this->session->unset_userdata('inf_package_validity_upgrade_array');
                $msg = lang('package_successfully_updated');
                $enc_order_id = $this->validation_model->encrypt($invoice_no);
                $this->redirect("<span> $msg :  $invoice_no </span>", "member/package_validity", true);
            } else {
                $this->repurchase_model->rollback();
                $msg = lang('package_updation_error');
                $this->redirect($msg, 'member/package_validity', false);
            }
        } else {
            $msg = 'Payment Failed';
            $this->redirect($msg, 'member/package_validity', false);
        }
    }

    function authorizeNetPayment()
    {

        $this->load->model('repurchase_model');
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('authorize_authentication');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('authorize_authentication');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('authorize_authentication');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $purchase_details = $this->session->userdata('inf_package_validity');
        $total_amount = $purchase_details['total_amount'];

        $this->load->model('authorizeNetPayment_model');
        $merchant_details = $this->authorizeNetPayment_model->getAuthorizeDetails();

        $api_login_id = $merchant_details['merchant_id'];
        $transaction_key = $merchant_details['transaction_key'];

        $fp_timestamp = time();
        $fp_sequence = "123" . time(); // Enter an invoice or other unique number.
        $fingerprint = $this->authorizeNetPayment_model->authorizePay($api_login_id, $transaction_key, $total_amount, $fp_sequence, $fp_timestamp);

        $this->set('user_type', $this->LOG_USER_TYPE);
        $this->set('api_login_id', $api_login_id);
        $this->set('transaction_key', $transaction_key);
        $this->set('amount', $total_amount);
        $this->set('fp_timestamp', $fp_timestamp);
        $this->set('fingerprint', $fingerprint);
        $this->set('fp_sequence', $fp_sequence);

        $this->setView();
    }

    public function delete_social_invite()
    {
        $invite_text_id = (strip_tags($this->input->post('invite_text_id', true)));
        $type = $this->member_model->getSocialInvitesTypeById($invite_text_id);
        $res = $this->member_model->deleteInviteText($invite_text_id);
        if ($res) {
            $data_array['text_invite_id'] = $invite_text_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Social invite deleted', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_text_invite', 'Social Invite Deleted');
            }
            //
            if ($type == 'social_fb') {
                $media = 'facebook';
            } elseif ($type == 'social_twitter') {
                $media = 'twitter';
            } elseif ($type == 'social_instagram') {
                $media = 'instagram';
            } elseif ($type == 'social_email') {
                $media = 'email';
            }

            $msg = lang($media) . lang('invite_deleted');
            $this->redirect($msg, "member/invite_wallpost_config", true);
        } else {
            $msg = lang('invite_not_deleted');
            $this->redirect($msg, "member/invite_wallpost_config", false);
        }
    }

    public function add_text_invite()
    {

        $this->check_menu_promotion();

        $title = lang('add_text_invite');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('add_text_invite');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_text_invite');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('text_invite');
        $this->set("help_link", $help_link);

        if ($this->input->post('update') && $this->validate_invite_text()) {

            $update_post_array = $this->input->post(null, true);
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
            $update_post_array['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));

            $mail_content['mail_content'] = $update_post_array['mail_content'];
            $mail_content['subject'] = $update_post_array['subject'];
            $res = $this->member_model->insertTextInvites($mail_content);
            if ($res) {
                $data = serialize($update_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite added', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_text_invite', 'Text Invite Added');
                }
                //

                $msg = lang('invite_text_added');
                $this->redirect($msg, "member/text_invite_configuration", true);
            } else {
                $msg = lang('invite_text_not_added');
                $this->redirect($msg, "member/text_invite_configuration", false);
            }
        }
        $this->setView();
    }

    public function add_banner_invite()
    {

        $this->check_menu_promotion();
        $title = lang('banner');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('banner');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('banner');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('banner');
        $this->set("help_link", $help_link);
        if ($this->input->post('banner')) {
            $upload_config = $this->validation_model->getUploadConfig();

            $upload_count = $this->validation_model->getUploadCount($this->ADMIN_USER_ID);
            if ($upload_count >= $upload_config) {
                $msg = lang('you_have_reached_max_upload_limit');
                $this->redirect($msg, "member/add_banner_invite/", false);
            }

            $details = array();
            $random_number = floor($this->LOG_USER_ID * rand(1000, 9999));
            $config['file_name'] = "banner_" . $random_number;
            $config['upload_path'] = IMG_DIR . 'banners/';
            $config['allowed_types'] = 'png';
            $config['max_size'] = '2048';
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;

            $this->load->library('upload', $config);
            if ($this->validate_banner_invite()) {
                if (!$this->upload->do_upload('banner_image')) {
                    $error = array('error' => $this->upload->display_errors());
                    $error = $this->validation_model->stripTagsPostArray($error);
                    $error = $this->validation_model->escapeStringPostArray($error);
                    if ($error['error'] == 'You did not select a file to upload.') {
                        $msg = lang('please_select_file');
                        $this->redirect($msg, "member/add_banner_invite/", false);
                    } else
                        if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                        $msg = lang('exceeded_max_size');
                        $this->redirect($msg, "member/add_banner_invite/", false);
                    } else
                        if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                        $msg = lang('please_choose_a_png_file.');
                        $this->redirect($msg, "member/add_banner_invite/", false);
                    } else
                        if ($error['error'] == 'Invalid file name.') {
                        $msg = lang('invalid_file_name');
                        $this->redirect($msg, "member/add_banner_invite", false);
                    } else {
                        $msg = 'Error uploading file';
                        $this->redirect($msg, 'member/add_banner_invite', false);
                    }
                } else {
                    $banner_arr = array('upload_data' => $this->upload->data());
                }
                $details['product_url'] = $banner_arr['upload_data']['file_name'];
                $details['banner_name'] = $this->input->post('banner_name', true);
                $details['target_url'] = $this->input->post('target_url', true);
                $res = $this->member_model->insertBanner($banner_arr['upload_data']['file_name'], $details['target_url'], $details['banner_name']);
                $this->validation_model->updateUploadCount($this->LOG_USER_ID);
                if ($res) {
                    $data = serialize($details);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite added', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_banner_invite', 'Banner Invite Added');
                    }
                    //

                    $msg = lang('banner_added');
                    $this->redirect($msg, "member/invite_banner_config/", true);
                } else {
                    $msg = lang('banner_not_added');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                }
            }
        }
        $this->setView();
    }

    public function add_email_invite()
    {

        $this->check_menu_promotion();
        $title = lang('add_email_invite');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('add_email_invite');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_email_invite');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('add_email_invite');
        $this->set("help_link", $help_link);
        if ($this->input->post('submit_email') && $this->validate_invite_social_email()) {
            $details = $this->input->post(null, true);
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $res = $this->member_model->insertsocialInvites($details, 'social_email');
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'email invite updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_email_invite', 'Email Invite Added');
                }
                //

                $msg = lang('email_invite_added');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_add_email_invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        $this->setView();
    }

    public function add_facebook_invite()
    {

        $this->check_menu_promotion();
        $title = lang('add_facebook_invite');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('add_facebook_invite');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_facebook_invite');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('add_facebook_invite');
        $this->set("help_link", $help_link);
        if ($this->input->post('submit_fb') && $this->validate_invite_social_fb()) {
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('caption'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('description'));
            $res = $this->member_model->insertsocialInvites($details, 'social_fb');
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'facebook invite updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_facebook_invite', 'Facebook Invite Added');
                }
                //

                $msg = lang('fb_invite_added');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_add_fb_invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        $this->setView();
    }

    public function pending_registration()
    {

        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            $msg = lang('you_dont_have_permission_to_access_this_page');
            $this->redirect($msg, "home", false);
        }
        $title = lang('pending_registration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('pending_registration');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('pending_registration');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('pending_registration');
        $this->set("help_link", $help_link);

        $this->load->model('register_model');

        $count = $this->register_model->getPendingRegistrationsCount();
        $base_url = base_url() . 'admin/member/pending_registration';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $page = ($this->uri->segment(4) != "") ? $this->uri->segment(4) : 0;
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $pending_registration_list = $this->register_model->getPendingRegistrations($page, $config['per_page']);
        $this->set("pending_registration_list", $pending_registration_list);
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);

        $this->setView();
    }

    public function approve_registration()
    {
        $post_arr = $this->input->post(null, true);
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $this->load->model('register_model');
        $count = sizeof($post_arr['release']);
        $result = false;
        for ($i = 0; $i < $count; $i++) {
            $user_name = $post_arr['release'][$i];
            $registration_details = $this->register_model->getPendingRegistrationDetailsByUsername($user_name);
            $payment_method = $registration_details['payment_method'];
            $id = $registration_details['data']["pending_id"] = $registration_details['id'];

            $this->register_model->begin();
            $registration_details['data']['reg_from_tree'] = false;
            $registration_details['data']['user_name_type'] = 'static';
            $registration_details['data']['joining_date'] = date('Y-m-d H:i:s');
            $res = $this->register_model->confirmRegister($registration_details['data'], $this->MODULE_STATUS);
            if (isset($res['status']) && $res['status']) {
                $this->register_model->commit();
                $user_id = $res['user_id'];
                $this->register_model->updatePendingRegistration($id, $user_id, $user_name, $payment_method, $registration_details['data']);

                $result = true;
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'user_register', 'User Registered', $data = '');
                }
            } else {
                $this->register_model->rollback();
                $msg = lang('error_approve_registration') . " of $user_name";
                $this->redirect($msg, 'member/pending_registration', false);
            }
        }
        if ($result) {
            $msg = lang('success_approve_registration');
            $this->redirect($msg, 'member/pending_registration', true);
        } else {
            $msg = lang('error_approve_registration');
            $this->redirect($msg, 'member/pending_registration', false);
        }
    }

    public function validate_banner_invite()
    {
        $this->form_validation->set_rules('banner_name', lang('banner_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('target_url', lang('target_url'), 'trim|valid_url');
        $this->form_validation->set_message('valid_url', lang('please_enter_valid_url'));
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    /* Blocktrail Starts */

    public function bitcoin_payment()
    {
        /*
         * Install these libraries :
          sudo apt-get install libgmp-dev
          sudo apt-get install php5-gmp
          sudo service apache2 restart
         */
        require(dirname(__FILE__) . '/../Blocktrail.php');
        $blocktrail = new Blocktrail;
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('blocktrail_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "blocktrail_payment";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('blocktrail_payment');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('blocktrail_payment');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        //-----amount conversion
        $currency = 'USD';

        $bitcoin_price = $blocktrail->bitcoinRate($currency);
        $this->session->set_userdata('bitcoin_price', $bitcoin_price);
        //end-----amount conversion

        $purchase_details = $this->session->userdata('inf_package_validity');
        $bitcoin_id = $this->register_model->bitcoinHistory($this->LOG_USER_ID, $purchase_details, 'upgrade_package_validity');
        $this->session->set_userdata('bitcoin_id', $bitcoin_id);

        //$total_amount = round((floatval($purchase_details['total_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);
        $total_amount = 1;
        $this->session->set_userdata('total_amount', $total_amount);

        $bitcoin_amount = $total_amount / $bitcoin_price;

        $this->session->set_userdata('bitcoin_amount', $bitcoin_amount);
        $this->set('bitcoin_amount', round($bitcoin_amount, 8));
        $qr_btc_amount = round($bitcoin_amount, 8);

        $data = $blocktrail->generateAddress($qr_btc_amount);
        if ($data['status']) {
            $this->set('bitcoin_address', $data['bitcoin_address']);
            $this->set('qr_code', $data['qr_code']);
            $this->setView();
        } else {
            $msg = $data['msg'];
            $this->redirect($msg, 'member/package_validity', false);
        }
    }

    public function bitcoin_registration()
    {

        require(dirname(__FILE__) . '/../Blocktrail.php');
        $blocktrail = new Blocktrail;
        $satoshi = "";
        $bitcoin_address = $this->session->userdata('bitcoin_address');
        $paid_amount = $this->session->userdata('bitcoin_amount');
        $response = $blocktrail->getResponse($bitcoin_address);

        $regr = $this->session->userdata('inf_package_validity');
        $regr['user_name_entry'] = $this->member_model->IdToUserName($regr['user_id']);
        $regr['bitcoin_address'] = $bitcoin_address;
        $regr['paid_amount'] = $paid_amount;
        $regr['response'] = $response;
        $user_id = $regr['user_id'];

        if ($response['data']) {
            foreach ($response['data'][0]['outputs'] as $value) {
                if ($value['address'] == $bitcoin_address) {
                    $satoshi = $value['value'];
                }
            }
            $transaction = $response['data'][0]['hash'];
            $return_address = $response['data'][0]['outputs'][0]['address'];
            $response_amount = number_format(($satoshi) * (pow(10, -8)), 8, '.', '');
            if (round($response_amount, 8) >= round($paid_amount, 8)) {
                if ($this->session->userdata('inf_package_validity')) {
                    $payment_method = 'blocktrail';
                    $total_amount = $this->session->userdata('total_amount');
                    $bitcoin_id = $this->session->userdata('bitcoin_id');
                    $current_bitcoin_value = $this->session->userdata('bitcoin_price');
                    $result = $this->register_model->insertInToBitcoinPaymentDetails($bitcoin_id, $user_id, 'Package Upgradation', $total_amount, $current_bitcoin_value, $paid_amount, $response_amount, $bitcoin_address, $transaction, $return_address, "");
                    $result = $this->register_model->updateBitcoinHistory($user_id, $bitcoin_id, 'yes');
                    $this->session->unset_userdata('bitcoin_id');

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, 'upgrade_package_validity', 'Package Upgraded', "");
                    }
                    //

                    $regr['by_using'] = 'blocktrail';
                    $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $regr['user_id']);
                    $package_details[0]['id'] = $expired_users[0]['product_id'];
                    $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $regr);
                    $data = serialize($regr);
                    $login_id = $this->LOG_USER_ID;
                    if ($this->LOG_USER_TYPE == 'admin') {
                        $user_name = $this->validation_model->getUserName($user_id);
                        $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($regr['by_using']), $user_id, $data);
                    } else {
                        $user_name = $this->validation_model->getUserName($login_id);
                        $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($regr['by_using']), $login_id, $data);
                    }

                    $this->session->unset_userdata('inf_package_validity');
                    $msg = lang('package_upgradation_success');
                    $this->redirect($msg, "member/package_validity", true);
                } else {
                    $error_data['user_name_entry'] = '';
                    $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($error_data, "No Session Data", $this->LOG_USER_ID);
                    $msg = lang('upgradation_failed');
                    $this->redirect($msg, 'member/package_validity', false);
                }
            } else {
                $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($regr, "Amount Missmatch", $this->LOG_USER_ID);
                $this->redirect("Amount Missmatch!!", 'member/bitcoin_payment', false);
            }
        } else {
            $result = $this->register_model->insertInToBitcoinPaymentProcessDetails($regr, "No Response", $this->LOG_USER_ID);
            $msg = lang('upgradation_failed');
            $this->redirect($msg, 'member/package_validity', false);
        }
    }

    public function bitcoin_response()
    {
        require(dirname(__FILE__) . '/../Blocktrail.php');
        $blocktrail = new Blocktrail;
        $status = "no";

        $regr = $this->session->userdata('inf_package_validity');
        $regr['user_name_entry'] = $this->member_model->IdToUserName($regr['user_id']);
        if (isset($_POST)) {
            $bitcoin_address = $_POST['bitcoin_address'];
            $response = $blocktrail->getResponse($bitcoin_address);
            $regr['bitcoin_address'] = $bitcoin_address;
            $regr['response'] = $response;
            if ($response['data']) {
                foreach ($response['data'][0]['outputs'] as $value) {
                    if ($value['address'] == $bitcoin_address) {
                        $satoshi = $value['value'];
                    }
                }
                if ($satoshi > 0) {
                    $this->register_model->insertInToBitcoinPaymentProcessDetails($regr, "Amount Paid", $this->LOG_USER_ID);
                    $status = "yes";
                } else {
                    $status = "no";
                }
            } else {
                $status = "no";
            }
        } else {
            $this->register_model->insertInToBitcoinPaymentProcessDetails($regr, "No Post Data", $this->LOG_USER_ID);
            $status = "no_post_data";
        }
        echo $status;
        exit();
    }

    /* Blocktrails Ends */

    /* Blockchain Starts */

    public function blockchain()
    {
        require(dirname(__FILE__) . '/../Blockchain.php');
        $blockchain = new Blockchain;
        $title = lang('pay_bitcoin');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('pay_bitcoin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('pay_bitcoin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $base_url = base_url();
        $date = date("Y-m-d H:i:s");
        $invoice_id = time();
        $secret = $blockchain->getToken();
        if (empty($this->session->userdata("inf_package_validity"))) {
            $this->redirect("", 'member/package_validity', false);
        }
        $purchase_details = $this->session->userdata("inf_package_validity");
        $product_id = $this->validation_model->getProductId($purchase_details['user_id']);
        $total_amount = round((floatval($purchase_details['total_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);

        $currency = "USD";
        $blockchain_root = "https://blockchain.info/";
        $price_in_btc = file_get_contents($blockchain_root . "tobtc?currency=$currency&value=" . $total_amount);

        $new_address = false;
        if ($this->register_model->getUnpaidAddressCount() >= 19) {
            if ($address = ($this->register_model->getUnpaidAddress()) ?: false) { } else {
                if ($this->LOG_USER_TYPE == 'admin') {
                    $this->redirect(lang('you_have_reached_maximum_unpaid_address'), 'member/package_validity', false);
                } else {
                    $this->redirect(lang('payment_not_available_now'), 'member/package_validity', false);
                }
            }
        } else {
            $address = $blockchain->generateAddress();
            $new_address = true;
        }
        $qr_code = $blockchain->generateQr($address);
        if ($address) {
            if ($new_address) {
                $this->register_model->keepBitcoinAddress($address);
            } else {
                $this->register_model->updateAddressDate($address);
            }
            $regr = $this->session->userdata("inf_package_validity");
            $regr['product_id'] = $product_id;
            $this->register_model->insertPaymentDetails($invoice_id, $address, $secret, $total_amount, $price_in_btc, $date, $regr, 'upgrade_package_validity');
        } else {
            $this->redirect("Something wrong", 'member/package_validity', false);
        }

        $this->set('address', $address);
        $this->set('qr_code', $qr_code);
        $this->set('amount', $total_amount);
        $this->set('amount_in_btc', $price_in_btc);
        $this->set('invoice_id', $invoice_id);
        $this->session->set_userdata('block_address', $address);
        $this->session->set_userdata('price_in_btc', $price_in_btc);
        $this->session->set_userdata('invoice_id', $invoice_id);
        $this->setView();
    }

    public function blockchain_payment_done()
    {
        require(dirname(__FILE__) . '/../Blockchain.php');
        $blockchain = new Blockchain;
        if ($this->session->userdata('block_address') && $this->session->userdata('price_in_btc')) {
            $block_address = $this->session->userdata('block_address');
            $paid_amount = $this->session->userdata('price_in_btc');

            $purchase_details = $this->session->userdata("inf_package_validity");
            $total_amount = round((floatval($purchase_details['total_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);

            $res_arr = $blockchain->getResponse($block_address);
            $response_amount = 0;
            foreach ($res_arr['txs'] as $key => $value) {
                $count = count($value['out']);
                for ($i = 0; $i < $count; $i++) {
                    if ($value['out'][$i]['addr'] == $block_address) {
                        $amount = $value['out'][$i]['value'];
                        $response_amount = $amount / 100000000;
                    }
                }
            }
            $invoice_id = $this->session->userdata('invoice_id');

            $purchase_details['user_name_entry'] = $this->member_model->IdToUserName($this->LOG_USER_ID);
            $purchase_details['block_address'] = $block_address;
            $purchase_details['paid_amount'] = $paid_amount;
            $purchase_details['response'] = $response;
            $this->register_model->keepRowAddressReponse($block_address, $invoice_id, $res_arr, 'Upgrade Package');
            $this->register_model->updateBitcoinAddress($block_address, 'yes');

            if ($response_amount > 0.00000001 && (round($response_amount, 8) >= round($paid_amount, 8))) {

                $purchase_details['by_using'] = 'blockchain';

                $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase_details['user_id']);
                $package_details[0]['id'] = $expired_users[0]['product_id'];
                $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase_details);
                $data = serialize($purchase_details);
                $login_id = $this->LOG_USER_ID;
                if ($this->LOG_USER_TYPE == 'admin') {
                    $user_name = $this->validation_model->getUserName($purchase['user_id']);
                    $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase['by_using']), $purchase['user_id'], $data);
                } else {
                    $user_name = $this->validation_model->getUserName($login_id);
                    $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of' . $user_name . ' through ' . lang($purchase['by_using']), $login_id, $data);
                }

                $this->session->unset_userdata('inf_package_validity');
                $this->session->unset_userdata('block_address');
                $this->session->unset_userdata('price_in_btc');
                $this->session->unset_userdata('invoice_id');
                $msg = lang('package_upgradation_success');
                $this->redirect($msg, "member/package_validity", true);
                exit();
                //unset all session
            } else {
                $msg = lang('package_upgradation_failed');
                $this->redirect($msg, 'member/package_validity', false);
            }
        }
    }

    /* Blockchain Ends */

    /* BitGo Starts */

    public function bitgo_gateway()
    {

        require(dirname(__FILE__) . '/../Bitgo.php');
        $bitgo = new Bitgo;

        $error = '';
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('bitgo_gateway');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('bitgo_gateway');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('bitgo_gateway');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $purchase_details = $this->session->userdata('inf_package_validity');
        $total_amount = round((floatval($purchase_details['total_amount']) / $this->DEFAULT_CURRENCY_VALUE), 8);

        $this->load->model("currency_model");
        $is_usd_default = $this->currency_model->isUSDDefault();
        if (!$is_usd_default) {
            $usd_details = $this->currency_model->getCurrencyDetailsById(1);
            $total_amount = $total_amount * $usd_details['value'];
        }

        if (!empty($this->session->userdata('bitcoin_session')) && $purchase_details['is_new'] == "no") {
            $bitcoin_session = $this->session->userdata('bitcoin_session');
            $pay_address = $bitcoin_session['bitcoin_address'];
            $sendAmount =  $bitcoin_session['send_amount'];
        } else {
            try {
                $address = $bitgo->bitgo_gateway();
            } catch (Exception $e) {
                $msg = lang("initializing_wallet_failed_because") . ' ' . $e->getMessage();
                $this->redirect($msg, 'member/package_validity', false);
            }
            $btc_amount = $this->currency_model->currencyToBtc('USD', $total_amount);
            $sendAmount = $btc_amount['btc_amount'];
            $user_id = $this->LOG_USER_ID;
            $p_id = $this->validation_model->getProductId($user_id);
            $pay_address = $address->address;
            $wallet_id = $address->wallet;
            $bitgo_hid = $this->register_model->insertIntoBitGoPaymentHistory($user_id, serialize($purchase_details), $p_id, $btc_amount['btc_amount'], $pay_address, serialize($address), $wallet_id);

            $bitcoin_session = array(
                'bitcoin_address' => $pay_address,
                'send_amount' => $btc_amount['btc_amount'],
                'bitgo_hid' => $bitgo_hid,
                'wallet_id' => $wallet_id
            );
            $this->session->set_userdata('bitcoin_session', $bitcoin_session);
            $_SESSION['purchase_details']['is_new'] = "no";
        }

        $btc_amount = round($sendAmount, 8);
        $qr_code = $bitgo->generateBitcoinQrCode($pay_address, $btc_amount);

        $this->set('pay_address', $pay_address);
        $this->set('amount', $btc_amount);
        $this->set('qr_code', $qr_code);
        $this->set('error', $error);
        $this->setView();
    }

    public function ajax_bitgo_payment_verify()
    {
        require(dirname(__FILE__) . '/../Bitgo.php');
        $bitgo = new Bitgo;
        if (!empty($this->session->userdata('bitcoin_session'))) {

            $rs_arr = array();
            $bitcoin_address_array = $this->session->userdata('bitcoin_session');
            $bitcoin_address = $bitcoin_address_array['bitcoin_address'];
            $btc_amount = $bitcoin_address_array['send_amount'];
            $bitgo_hid = $bitcoin_address_array['bitgo_hid'];
            $wallet_id = $bitcoin_address_array['wallet_id'];
            $bitcoin_status = $bitgo->checkBitcoinPaymentStatus($bitcoin_address, $btc_amount, $bitgo_hid, $wallet_id);

            if ($bitcoin_status['status']) {
                if ($this->session->userdata('inf_package_validity')) {
                    $purchase_details = $this->session->userdata('inf_package_validity');
                    $purchase_details['by_using'] = 'BitGo';
                    $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase_details['user_id']);
                    $package_details[0]['id'] = $expired_users[0]['product_id'];
                    $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase_details);
                    $data = serialize($purchase_details);
                    $login_id = $this->LOG_USER_ID;
                    if ($this->LOG_USER_TYPE == 'admin') {
                        $user_name = $this->validation_model->getUserName($purchase_details['user_id']);
                        $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase_details['by_using']), $purchase_details['user_id'], $data);
                    } else {
                        $user_name = $this->validation_model->getUserName($login_id);
                        $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase_details['by_using']), $login_id, $data);
                    }
                    $rs_arr['status'] = $bitcoin_status['status'];
                    echo json_encode($rs_arr);
                }
                //  echo json_encode($bitcoin_status);
            } else {
                $rs_arr['status'] = "Failed";
                echo json_encode($bitcoin_status);
            }
        } else {
            $rs_arr['status'] = "Failed";
            // $rs_arr['error'] = $bitcoin_status['msg'];
            echo json_encode($rs_arr);
            // $error = $bitcoin_status['msg'];
            //   $this->redirect(lang('current_session_expired'), 'register/user_register', false);
        }
    }

    function btc_confirm()
    {
        if (!empty($this->session->userdata('inf_package_validity'))) {
            $this->session->unset_userdata('inf_package_validity');
            $msg = lang('package_upgradation_success');
            $this->redirect($msg, "member/package_validity", true);
        } else {
            $msg = lang('package_upgradation_failed');
            $this->redirect($msg, "member/package_validity", false);
        }
    }

    /* BitGo Ends */

    function check_menu_promotion()
    {

        $status = $this->member_model->getStatus(35);
        if ($status == "no") {
            $msg = lang('permission_denied');
            $this->redirect($msg, 'home/index', false);
        }
    }

    public function upgrade_package()
    {

        $title = lang('upgrade_package');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('upgrade_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upgrade_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = "upgrade_package";
        $this->set("help_link", $help_link);

        $this->url_permission('package_upgrade');
        $this->load_langauge_scripts();

        if ($this->session->flashdata('username')) {
            $user_name = $this->session->flashdata('username');
            $user_id = $this->validation_model->userNameToID($user_name);
        } else {
            if ($this->LOG_USER_TYPE == 'employee') {
                $user_id = $this->ADMIN_USER_ID;
                $user_name = $this->ADMIN_USER_NAME;
            } else {
                $user_id = $this->LOG_USER_ID;
                $user_name = $this->LOG_USER_NAME;
            }
        }

        $this->load->model('upgrade_model');
        $current_package_details = $this->upgrade_model->getMembershipPackageDetails($user_id);
        $upgradable_package_list = $this->upgrade_model->getUpgradablePackageList($current_package_details);

        $this->set("upgradable_package_list", $upgradable_package_list);
        $this->set("current_package_details", $current_package_details);
        $this->set('user_name', $user_name);

        $this->setView();
    }

    public function upgrade_package_submit()
    {
        
        if ($this->input->post('upgrade')) {
            $this->load->model('upgrade_model');
            $module_status = $this->MODULE_STATUS;
            $post_data = $this->input->post(null, true);
            $user_name = $post_data['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_username');
                $this->redirect($msg, 'member/upgrade_package', false);
            }

            $product_id = $post_data['product_id'];
            $package_id = $this->product_model->getProductPackageId($product_id, $module_status, 'registration');
            $current_package_id = $this->validation_model->getProductId($user_id);
            $is_upgradable_package = $this->upgrade_model->isUpgradablePackage($current_package_id, $package_id);
            $upgrade_res = false;
            if ($is_upgradable_package) {
                $upgrade_res = $this->member_model->upgradePackageDetails($user_id, $current_package_id, $package_id, 'free_upgrade', $this->LOG_USER_ID, $module_status);
                $package_name = $this->home_model->getPackageNameFromPackageId($package_id, $module_status);
                $data = serialize($post_data);
                $login_id = $this->LOG_USER_ID;
                $user_name = $this->validation_model->getUserName($user_id);
                $this->validation_model->insertUserActivity($login_id, $user_name . '`s package upgraded to ' . $package_name . ' manually ', $user_id, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, $user_name . '`s package upgraded to ' . $package_name . ' manually ', $user_name . '`s package upgraded to ' . $package_name . ' manually ');
                }
            }
            if ($upgrade_res) {
                $msg = lang('package_upgrade_success');
                $this->redirect($msg, 'member/upgrade_package', true);
            } else {
                $msg = lang('package_upgrade_error');
                $this->redirect($msg, 'member/upgrade_package', false);
            }
        }
    }

    public function package_info()
    {
        $this->load->model('upgrade_model');
        $product_id = $this->input->get('product_id');
        $package_info = $this->upgrade_model->getPackageDetails($product_id);
        echo json_encode($package_info);
        exit();
    }

    public function search_member_upgrade()
    {
        if ($this->input->post('search_member_submit')) {
            $user_name = $this->input->post('user_name', true);
            $user_id = $this->validation_model->userNameToID($user_name);
            if ($user_id) {
                $this->session->set_flashdata('username', $user_name);
                $this->redirect('', 'member/upgrade_package', true);
            } else {
                $msg = lang('invalid_username');
                $this->redirect($msg, 'member/upgrade_package', false);
            }
        }
    }

    public function add_social_invite()
    {
        $this->check_menu_promotion();
        $media = $this->input->post('social_media') ? $this->input->post('social_media') : $this->session->userdata('media');
        $this->session->set_userdata('media', $media);
        $title = lang('add_' . $media);
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('add_' . $media);
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_' . $media);
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($media == "facebook_invite") {
            $type = "social_fb";
            $tool = "facebook";
        } elseif ($media == "twitter_invite") {
            $type = "social_twitter";
            $tool = "twitter";
        } elseif ($media == "instagram_invite") {
            $type = "social_instagram";
            $tool = "instagram";
        }
        $this->set('media', $media);

        $help_link = lang('add_' . $media);
        $this->set("help_link", $help_link);
        if ($this->input->post('submit_social') && $this->validate_invite_social_fb()) {
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('caption'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('description'));
            $res = $this->member_model->insertsocialInvites($details, $type);
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, $tool . 'invite updated', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_' . $tool . '_invite', $tool . ' Invite Added');
                }
                //

                $msg = lang($tool) . " " . lang('invite_added');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_add') . $tool . lang('invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        $this->setView();
    }

    public function getSocialInviteData()
    {
        $id = ($this->input->post('id', true));
        $details = $this->member_model->getSocialInvitesById($id);
        $value = json_encode($details);
        echo $value;
        exit();
    }

    function check_epin_validity()
    {
        $this->load->model('repurchase_model');
        $pin_details = $this->input->post('pin_array', true);
        $upgrade_user_name = $this->input->post('upgrade_user_name', true);
        $upgrade_user_id = $this->validation_model->userNameToID($upgrade_user_name);
        $pin_data = [];
        $i = 0;
        foreach ($pin_details as $v) {
            $pin_data[$i]['pin'] = $v;
            $pin_data[$i]['pin_amount'] = 0;
            $i++;
        }
        $total_amount = $this->input->post('repurchase_amount', true);
        $pin_array = $this->repurchase_model->validateAllEpins($pin_data, $total_amount, $this->LOG_USER_ID, $upgrade_user_id);
        $value = json_encode($pin_array);
        echo $value;
        exit();
    }

    function check_ewallet_balance()
    {
        $this->load->model('register_model');
        $status = "no";
        $ewallet_user = $this->input->post('user_name', true);
        $ewallet_pass = $this->input->post('ewallet', true);
        $total_amount = $this->input->post('repruchase_amount', true);
        $upgrade_username = $this->input->post('upgrade_username', true);
        if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'employee') {
            $admin_username = $this->validation_model->getAdminUsername();
            if ($ewallet_user != $admin_username || $ewallet_user != $upgrade_username) {
                $status = "invalid";
                echo $status;
                exit();
            }
        }
        if ($this->LOG_USER_TYPE == 'user') {
            if ($ewallet_user != $this->LOG_USER_NAME) {
                $status = "invalid";
                echo $status;
                exit();
            }
        }
        $user_id = $this->validation_model->userNameToID($ewallet_user);
        if ($user_id) {
            $user_password = $this->register_model->checkEwalletPassword($user_id, $ewallet_pass);
            if ($user_password == 'yes') {
                $user_bal_amount = $this->register_model->getBalanceAmount($user_id);
                if ($user_bal_amount > 0) {
                    if ($user_bal_amount >= $total_amount) {
                        $status = "yes";
                    }
                }
            } else {
                $status = "invalid";
            }
        } else {
            $status = "invalid";
        }
        echo $status;
        exit();
    }

    public function update_pv()
    {

        $title = lang('update_pv');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('update_pv');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('update_pv');
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = "update_pv";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();
        $user_name_submit = false;

        if ($this->input->post('user_name_submit') && $this->validate_user_name_submit()) {
            $user_name_submit = true;
            $post_array = $this->input->post(null, true);
            $post_array = $this->validation_model->stripTagsPostArray($post_array);
            $user_name = $post_array['user_name'];

            if ($this->validation_model->isUserNameAvailable($user_name)) {
                $user_id = $this->validation_model->userNameToID($user_name);
            } else {
                $msg = lang('invalid_username');
                $this->redirect($msg, 'member/update_pv', false);
            }
            $this->load->model('select_report_model');

            $current_rank = $this->validation_model->getUserRank($user_id);
            $rank_details = [];
            if ($current_rank != '') {
                $rank_details = $this->select_report_model->selectRankDetails($current_rank);
            } else {
                $rank_details['rank_name'] = "NA";
            }
            $personal_pv = $this->validation_model->getPersnlPv($user_id);
            $group_pv = $this->validation_model->getGrpPv($user_id);

            $this->set("rank_details", $rank_details);
            $this->set("personal_pv", $personal_pv);
            $this->set("group_pv", $group_pv);
            $this->set('user_name', $user_name);
        } else {
            $user_name_submit = TRUE;
            $user_name = $this->validation_model->getAdminUsername();
            $user_id = $this->validation_model->getAdminId();
            $this->load->model('select_report_model');
            $current_rank = $this->validation_model->getUserRank($user_id);
            $rank_details = [];
            if ($current_rank != '') {
                $rank_details = $this->select_report_model->selectRankDetails($current_rank);
            } else {
                $rank_details['rank_name'] = "NA";
            }
            $personal_pv = $this->validation_model->getPersnlPv($user_id);
            $group_pv = $this->validation_model->getGrpPv($user_id);

            $this->set("rank_details", $rank_details);
            $this->set("personal_pv", $personal_pv);
            $this->set("group_pv", $group_pv);
            $this->set('user_name', $user_name);
        }
        $this->set('user_name_submit', $user_name_submit);
        $this->setView();
    }

    public function update_pv_submit()
    {

        $this->load->model('calculation_model');
        $post_data = $this->input->post(null, true);
        $total_pv = 0;
        $user_name = $post_data['user_name'];
        $new_pv = $post_data['new_pv'];
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $msg = lang('invalid_username');
            $this->redirect($msg, 'member/update_pv', false);
        }
        if ($this->input->post('add_pv')) {
            $pv_update = FALSE;
            if (is_numeric($new_pv)  && $this->validate_pv_value()) {
                $old_pv = $this->validation_model->getPersnlPv($user_id);
                $sponsor_id = $this->validation_model->getSponsorId($user_id);
                $this->calculation_model->updatePersonalPV($user_id, $new_pv);
                $this->calculation_model->updateGroupPV($sponsor_id, $new_pv);
                $pv_update = true;
                $total_pv = $old_pv + $new_pv;
                $this->member_model->insertManualPVUpdateHistory($user_id, $new_pv, $total_pv, $old_pv, 'pv_added');
                $module_status = $this->MODULE_STATUS;
                $rank_status = $module_status['rank_status'];
                if ($rank_status == "yes") {
                    $this->load->model('rank_model');
                    $this->rank_model->updateUplineRank($user_id);
                }
            }
            if ($pv_update) {
                $data = serialize($post_data);
                $login_id = $this->LOG_USER_ID;
                $user_name = $this->validation_model->getUserName($user_id);
                $this->validation_model->insertUserActivity($login_id, $user_name . '`s Personal PV added ' . $new_pv . ' manually ', $user_id, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, $user_name . '`s Personal PV added' . $new_pv . ' manually ', $user_name . '`s Personal PV added' . $new_pv . ' manually ');
                }
                $msg = lang('pv_updated_successfully');
                $this->redirect($msg, 'member/update_pv', true);
            } else {
                $msg = lang('pv_updation_error');
                $this->redirect($msg, 'member/update_pv', false);
            }
        } else if ($this->input->post('deduct_pv')) {
            $pv_deduct = FALSE;
            $old_pv = $this->validation_model->getPersnlPv($user_id);
            if (is_numeric($new_pv)  && $this->validate_pv_value() && ($old_pv >= $new_pv)) {
                $sponsor_id = $this->validation_model->getSponsorId($user_id);

                $this->calculation_model->deductPersonalPV($user_id, $new_pv);
                $this->calculation_model->deductGroupPV($sponsor_id, $new_pv);
                $pv_deduct = TRUE;
                $total_pv = $old_pv - $new_pv;
                $this->member_model->insertManualPVUpdateHistory($user_id, $new_pv, $total_pv, $old_pv, 'pv_deduct');
                $module_status = $this->MODULE_STATUS;
                $rank_status = $module_status['rank_status'];
                if ($rank_status == "yes") {
                    $this->load->model('rank_model');
                    $this->rank_model->updateUplineRank($user_id);
                }
            }
            if ($pv_deduct) {
                $data = serialize($post_data);
                $login_id = $this->LOG_USER_ID;
                $user_name = $this->validation_model->getUserName($user_id);
                $this->validation_model->insertUserActivity($login_id, $user_name . '`s Personal PV deducted ' . $new_pv . ' manually ', $user_id, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $user_id, $user_name . '`s Personal PV added' . $new_pv . ' manually ', $user_name . '`s Personal PV added' . $new_pv . ' manually ');
                }
                $msg = lang('pv_deducted_successfully');
                $this->redirect($msg, 'member/update_pv', TRUE);
            } else {
                $msg = lang('pv_deduction_error');
                $this->redirect($msg, 'member/update_pv', FALSE);
            }
        }
    }

    public function validate_user_name_submit()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    public function validate_pv_value()
    {
        $this->form_validation->set_rules('new_pv', lang('personal_pv'), 'trim|required|strip_tags|numeric|greater_than[0]|max_length[5]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function sofort_payment()
    {
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('sofort');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('sofort');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sofort');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->session->userdata('inf_package_validity')) {
            $purchase_details = $this->session->userdata('inf_package_validity');

            $eur_conevrsion_rate = 0.87;
            $total_amount = round($purchase_details['total_amount'] * $eur_conevrsion_rate, 8);
            $currency = 'EUR';
            $user_name = $this->validation_model->getUserName($purchase_details['user_id']);
            $comment = 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase_details['by_using']);
            $this->set('comment', $comment);
            $this->set('amount', $total_amount);
            $this->set('currency', $currency);
            $this->setView();
        }
    }

    public function sofort_response()
    {

        require(dirname(__FILE__) . '/../SofortPay.php');
        $sofort = new SofortPay;

        $this->load->model("payment_model");
        $input = array();
        $input = $this->input->post(null, true);

        $result = $sofort->sofortResponse($input);
        if (!$result['status']) {
            $result = $this->payment_model->insertInToSofortProcessDetails($this->session->userdata('inf_package_validity'), $result['msg'], $this->LOG_USER_ID);
            $this->session->unset_userdata('inf_package_validity');
            $msg = lang('package_upgradation_failed');
            $this->redirect($msg, 'member/package_validity', FALSE);
        }
    }

    public function sofort_success()
    {
        $this->load->model("payment_model");
        if ($this->session->userdata('inf_package_validity')) {
            $transaction_id = $this->session->userdata('transactionid');
            $purchase_details = $this->session->userdata('inf_package_validity');

            $payment_details = [
                'user_id' => $purchase_details['user_id'],
                'type' => 'Package Upgrade',
                'status' => 'success',
                'total_amount' => $purchase_details['total_amount'],
                'transaction_id' => $transaction_id
            ];

            $result = $this->payment_model->insertIntoSofortPaymentHistory($payment_details);
            $purchase_details['by_using'] = 'sofort';
            $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase_details['user_id']);
            $package_details[0]['id'] = $expired_users[0]['product_id'];
            $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase_details);
            $data = serialize($purchase_details);
            $login_id = $this->LOG_USER_ID;
            if ($this->LOG_USER_TYPE == 'admin') {
                $user_name = $this->validation_model->getUserName($purchase_details['user_id']);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase_details['by_using']), $purchase_details['user_id'], $data);
            } else {
                $user_name = $this->validation_model->getUserName($login_id);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of' . $user_name . ' through ' . lang($purchase_details['by_using']), $login_id, $data);
            }
            $this->session->unset_userdata('inf_package_validity');
            $msg = lang('package_successfully_updated');
            $this->redirect($msg, "member/package_validity", TRUE);
            exit();
        } else {
            $msg = lang('package_upgradation_failed');
            $this->redirect($msg, 'member/package_validity', false);
        }
    }

    public function payeer_payment()
    {
        $title = lang('payeer');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payeer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payeer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        if ($this->session->userdata('payeer_data')) {
            $data = $this->session->userdata('payeer_data');
            $setting = $this->member_model->getPayeerSettings();
            $m_shop = $setting['merchant_id'];   //   merchant   ID
            $m_curr = 'EUR';   //   invoice   currency
            $m_orderid = ''; //   invoice   number   in   the   merchant's   invoicing   system
            $m_amount = number_format($data['product_amount'], 2, '.', '');   //   invoice   amount   with   two   decimal   places following   a   period
            $m_desc = '';   //   invoice   description   encoded   using   a   base64 algorithm
            $m_key = $setting['merchant_key']; //   Forming   an   array   for   signature   generation
            $arHash = array($m_shop, $m_orderid, $m_amount, $m_curr, $m_desc); //   Forming   an   array   for   additional   parameters
            // $arParams   =   array('success_url'   =>   'https://dev.bizmo.world/backoffice/user/member/payeer_success',
            //                         'fail_url'   =>  'https://dev.bizmo.world/backoffice/user/member/payeer_failure',
            //                         'status_url'   =>   'https://dev.bizmo.world/backoffice/register/payeer_status',
            //                         //   Forming   an   array   for   additional   fields
            //                         'reference'   =>   array('var1'   =>   $data['product_id'],
            //                     ),
            //                     //'submerchant'   =>   'mail.com',
            //                 );
            // //   Forming   a   key   for   encryption
            // $key   =   md5($setting['encryption_key'].$m_orderid);//   Encrypting   additional   parameters
            // $m_params = urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key, json_encode($arParams), MCRYPT_MODE_ECB)));
            // //   Encrypting   additional   parameters   using   AES-256-CBC   (for   >=   PHP   7)
            // //
            // $m_params   =   urlencode(base64_encode(openssl_encrypt(json_encode($arParams),'AES-256-CBC',$key,OPENSSL_RAW_DATA)));
            // //   Adding   parameters   to   the   signature-formation   array
            // $arHash[]   =   $m_params;
            //  //   Adding   the   secret   key   to   the   signature-formation   array
            // $arHash[]   =   $m_key;
            // //   Forming   a   signature
            // $sign = strtoupper(hash('sha256', implode(':', $arHash)));
            if (isset($m_params)) {
                $arHash[] = $m_params;
            }
            // Adding the secret key
            $arHash[] = $m_key;
            // Forming a signature
            $sign = strtoupper(hash('sha256', implode(":", $arHash)));
            $new_package_name = $this->register_model->getProductName($data['product_id']);
            $comment = "Payment for the Product $new_package_name";
            $this->set('m_shop', $m_shop);
            $this->set('m_orderid', $m_orderid);
            $this->set('m_amount', $m_amount);
            $this->set('m_curr', $m_curr);
            $this->set('m_desc', $m_desc);
            $this->set('sign', $sign);
            $this->set('type', $comment);
            $this->setView();
        } else {
            $msg = lang('package_upgrade_error');
            $this->redirect($msg, 'upgrade/package_upgrade', false);
        }
    }

    public function payeer_success()
    {

        $this->load->model("payment_model");
        $session_data = $this->session->userdata('payeer_data');
        $module_status = $this->MODULE_STATUS;
        $payment_type = 'payeer';
        $total_amount = $session_data['payment_amount'];
        $user_id = $session_data['user_id'];
        $package_id = $session_data['package_id'];
        $product_id = $session_data['product_id'];
        $current_package_id = $this->validation_model->getProductId($user_id);
        $payment_details = array(
            'user_id' => $user_id,
            'purpose' => 'Package Upgrade',
            'amount' => $total_amount,
            'product_id' => $product_id,
            'status' => 'success',
            'currency' => 'EUR',
            'invoice_number' => '',
            'date' => date('Y-m-d H:i:s')
        );
        $this->payment_model->insertIntoPayeerOrderHistory($payment_details);
        $payeer_details = $this->configuration_model->getPayeerConfigurationDetails();
        $purchase_details = $this->session->userdata('inf_package_validity');
        if ($this->session->userdata('payeer_payment')) {

            $purchase_details['by_using'] = 'payeer';
            $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase_details['user_id']);
            $package_details[0]['id'] = $expired_users[0]['product_id'];
            $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase_details);
            $data = serialize($purchase_details);
            $login_id = $this->LOG_USER_ID;
            if ($this->LOG_USER_TYPE == 'admin') {
                $user_name = $this->validation_model->getUserName($purchase_details['user_id']);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase_details['by_using']), $purchase_details['user_id'], $data);
            } else {
                $user_name = $this->validation_model->getUserName($login_id);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of' . $user_name . ' through ' . lang($purchase_details['by_using']), $login_id, $data);
            }
            $this->session->unset_userdata('inf_package_validity');
            $msg = lang('package_upgradation_success');
            $this->redirect($msg, "member/package_validity", true);
            exit();
        } else {
            $this->inf_model->rollback();
            $msg = lang('package_upgrade_error');
            $this->redirect($msg, 'member/package_validity', false);
        }
    }

    public function payeer_failure()
    {
        $this->register_model->rollback();
        $msg = lang('payeer_payment_error');
        $this->redirect($msg, 'member/package_validity', false);
    }

    public function squareup_payment()
    {

        $title = lang('squareup_payment');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('squareup_payment');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('squareup_payment');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if (empty($this->session->userdata('inf_package_validity'))) {
            $msg = lang('package_upgradation_failed');
            $this->redirect($msg, 'member/package_validity', FALSE);
        }

        $merchant_details = $this->configuration_model->getSquareUpConfigDetails();
        $application_id = $merchant_details['application_id'];
        $location_id = $merchant_details['location_id'];

        $purchase_details = $this->session->userdata('inf_package_validity');
        $payment_amount = $purchase_details['total_amount'];

        $total_amount = $payment_amount * 100; //USD in Cents
        $this->session->set_userdata('total_amount', $total_amount);

        $this->set('application_id', $application_id);
        $this->set('location_id', $location_id);

        $this->setView();
    }

    public function squareup_success()
    {

        require(dirname(__FILE__) . '/../Squareup.php');
        $squareup = new SquareUp;
        $this->load->model('payment_model');

        if (empty($this->session->userdata('inf_package_validity'))) {
            $msg = lang('package_upgradation_failed');
            $this->redirect($msg, 'member/package_validity', FALSE);
        }

        $purchase_details = $this->session->userdata('inf_package_validity');
        $total_amount = $this->session->userdata('total_amount');

        $merchant_details = $this->configuration_model->getSquareUpConfigDetails();
        $location_id = $merchant_details['location_id'];

        $nonce = $_POST['nonce'];
        if (is_null($nonce)) {
            $this->payment_model->insertSquareUpResponse($purchase_details, "Invalid card data", $this->LOG_USER_ID);
            $msg = lang('invalid_card_data');
            $this->redirect($msg, 'member/package_validity', FALSE);
        }

        $request_body = array(
            "card_nonce" => $nonce,
            # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
            "amount_money" => array(
                "amount" => $total_amount,
                "currency" => "USD"
            ),
            "idempotency_key" => uniqid()
        );
        $response = $squareup->squareResponse($request_body, $location_id);

        if ($response['status']) {
            $transaction_id = $response['transaction_id'];
            $user_id = $purchase_details['user_id'];
            $user_name = $this->validation_model->IdToUserName($user_id);

            $insert_id = $this->payment_model->insertSquareUpPaymentDetails($user_id, $user_name, $request_body, 'Member Reactivation', $transaction_id, 'success');

            $purchase_details['by_using'] = 'squareup';
            $expired_users = $this->member_model->getPackageExpiredUsers($this->ADMIN_USER_ID, $purchase_details['user_id']);
            $package_details[0]['id'] = $expired_users[0]['product_id'];
            $invoice_no = $this->member_model->packageValidityUpgrade($package_details, $purchase_details);
            $data = serialize($purchase_details);
            $login_id = $this->LOG_USER_ID;
            if ($this->LOG_USER_TYPE == 'admin') {
                $user_name = $this->validation_model->getUserName($purchase_details['user_id']);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of ' . $user_name . ' through ' . lang($purchase_details['by_using']), $purchase_details['user_id'], $data);
            } else {
                $user_name = $this->validation_model->getUserName($login_id);
                $this->validation_model->insertUserActivity($login_id, 'Membership Reactivation of' . $user_name . ' through ' . lang($purchase_details['by_using']), $login_id, $data);
            }
            $this->session->unset_userdata('inf_package_validity');
            $msg = lang('package_successfully_updated');
            $this->redirect($msg, "member/package_validity", TRUE);
            exit();
        } else {
            $this->payment_model->insertSquareUpResponse($this->session->userdata('inf_package_validity'), $response['msg'], $this->LOG_USER_ID);
            $this->session->unset_userdata('inf_package_validity');
            $msg = lang('package_upgradation_failed');
            $this->redirect($msg, 'member/package_validity', FALSE);
        }
    }

    public function pending_orders()
    {

        if ($this->MODULE_STATUS['opencart_status'] == 'yes') {
            $msg = lang('you_dont_have_permission_to_access_this_page');
            $this->redirect($msg, "home", false);
        }

        $title = lang('approval');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('approval');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('approval');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('approval');
        $this->set("help_link", $help_link);

        $this->load->model('repurchase_model');

        $count = $this->repurchase_model->getPendingorderCount();
        $base_url = base_url() . 'admin/pending_orders';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = 5;
        $page = ($this->uri->segment(3) != "") ? $this->uri->segment(3) : 0;
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $pending_order_list = $this->repurchase_model->getPendingOrders('', $page, $config['per_page']);
        $this->set("pending_order_list", $pending_order_list);
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);

        $this->setView();
    }

    public function approve_order()
    {
        $post_arr = $this->input->post(null, true);
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $this->load->model('repurchase_model');
        if (!$this->input->post('approval')) {
            $result = false;
        } else {
            $count = sizeof($post_arr['approval']);
            $result = false;
            $module_status = $this->MODULE_STATUS;
            $rank_status = $module_status['rank_status'];
            for ($i = 0; $i < $count; $i++) {
                $enc_invoice_order_id = $post_arr['approval'][$i];
                $invoice_order_id = $this->validation_model->decrypt($enc_invoice_order_id);
                if ($invoice_order_id) {
                    $repurchase_details = $this->repurchase_model->getPendingOrders($invoice_order_id);
                    $purchase_details = ['user_id'  => $repurchase_details[0]['user_id']];
                    $cart_products = $this->repurchase_model->getOrderDetailsById($invoice_order_id);
                    $this->repurchase_model->updateUserPv($cart_products, $purchase_details, $module_status);
                    if ($rank_status == "yes") {
                        $this->load->model('rank_model');
                        $this->rank_model->updateUplineRank($purchase_details['user_id']);
                    }
                    $result = $this->repurchase_model->updatePendingOrder($invoice_order_id);
                }
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'order_approval', 'Order Approved', $data = '');
                }
            }
        }
        if ($result) {
            $msg = lang('success_approving_order');
            $this->redirect($msg, 'member/pending_orders', true);
        } else {
            $msg = lang('error_approving_order');
            $this->redirect($msg, 'member/pending_orders', false);
        }
    }
    public function manage_members()
    {

        $title = lang('all_Members_List');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('all_Members_List');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('all_Members_List');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "manage_members";

        $member_arr = array();
        $user_detail_arr = array();
        $this->set("help_link", $help_link);

        $count = count($this->member_model->getMemberDetails());

        $base_url = base_url() . 'admin/member/manage_members';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        //$config['use_page_numbers'] = TRUE;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $page = ($this->uri->segment(4) != "") ? $this->uri->segment(4) : 0;
        $config['total_rows'] = $count;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();



        if ($this->input->post('manage_members') && $this->validate_manage_members()) {
            $user_name = $this->input->post('user_name');
            $user_id  = $this->validation_model->userNameToID($user_name);
            $member_arr = $this->member_model->getMemberDetailsPOfUser($user_id);
        } else {
            $member_arr = $this->member_model->getMemberDetails($page, $config['per_page']);
        }

        $i = 0;
        foreach ($member_arr as $row) {

            $id_encode = $this->encrypt->encode($row['user_name']);
            $id_encode = str_replace("/", "_", $id_encode);
            $encrypt_id = urlencode($id_encode);

            $user_detail_arr[$i]['username'] = $row['user_name'];
            $user_detail_arr[$i]['Parent'] = $this->validation_model->IdToUserName($row['father_id']);
            $user_detail_arr[$i]['sponsor'] = $this->validation_model->IdToUserName($row['sponsor_id']);
            $user_detail_arr[$i]['rank'] = $this->validation_model->getRankName($row['user_rank_id']);
            $user_detail_arr[$i]['joining_date'] = $row['date_of_joining'];
            $user_detail_arr[$i]['encrypt_id'] = $encrypt_id;
            $user_detail_arr[$i]['status'] = $row['active'];

            $i++;
        }

        $this->set('user_detail_arr', $user_detail_arr);
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->setView();
    }
    public function validate_manage_members()
    {

        $this->form_validation->set_rules('user_name', lang('user_name'), 'required|max_length[20]');
        $this->form_validation->set_message('required', lang('you_must_enter_username'));
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
       function choose_default_legs() {
        $title = lang('change_placement');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-password';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_placement');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_placement');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        if($this->input->post()){
            $left_leg = $this->input->post('left_leg');
            
           $res =  $this->member_model->updateDefaultLegs($this->LOG_USER_ID,$left_leg);
           if($res){
                $msg = lang('leg_changed_successffully');
                $this->redirect($msg, "member/choose_default_legs", true);
            } else {
                $msg = lang('leg_upgradation_failed');
                $this->redirect($msg, "member/choose_default_legs", false);
            }
        }
        $leg_details = $this->member_model->getDefaultLegs($this->LOG_USER_ID);
        $this->set('leg_details',$leg_details);
        $this->setView();
    }
    
    //Calender codes __Aiswarya
    public function calender_view()
    {
        $title = lang('calender_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('calender_view');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('calender_view');
        $this->HEADER_LANG['page_small_header'] = '';
        $result1 = $this->member_model->getcalender();
        $this->set('calender',$result1);
        $this->load_langauge_scripts();
        $this->setView();
    }
    
    public function calender_description()
    {
        $title = lang('calender_description');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('calender_description');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('calender_description');
        $this->HEADER_LANG['page_small_header'] = '';
        
            $config = $this->pagination->customize_style();
            $base_url = base_url() . "admin/member/calender_description";
            $config['base_url'] = $base_url;
            $config['per_page'] =$this->PAGINATION_PER_PAGE;
            // $config['per_page'] =5;
            if ($this->uri->segment(4) != ""){
                $page = $this->uri->segment(4) ;
            }
            else{
                $page = 0;
            }
            
        $date = date("Y-m-d");
        $report_date = '';
        $this->set("date", $date);
        if ($this->input->post('weekdate') && $this->validate_date()) {
            if (($this->input->post('week_date1') != '') && ($this->input->post('week_date2') != '')) {
                if (($this->input->post('week_date1')) > ($this->input->post('week_date2'))) {
                    $msg = lang('To-Date should be greater than From-Date');
                    $this->redirect($msg, 'member/calender_description', FALSE);
                }
            }
            $from = (strip_tags($this->input->post('week_date1', TRUE)));
            $to = (strip_tags($this->input->post('week_date2', TRUE)));
            $report_date = lang('from') . "\t" . $from . "\t" . lang('to') . "\t" . $to;
            if ($from)
                $from = $from . " 00:00:00";
            if ($to)
                $to = $to . " 23:59:59";

            $this->session->set_userdata("inf_week_date1", $from);
            $this->session->set_userdata("inf_week_date2", $to);
           
           $result1=$this->member_model->getcountcalender($from,$to);
           $result = $this->member_model->getallcalender($config['per_page'],$page,$from,$to);
           $config['total_rows'] = count($result1);
            
        }
        else
        {
             $result1=$this->member_model->getcountcalender('','');
            $result = $this->member_model->getallcalender($config['per_page'],$page);
            $config['total_rows'] = count($result1);
        }
         $result1 = $this->member_model->getcalender();

        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('start', $page);
        $this->set('calender',$result);
        $this->load_langauge_scripts();
        $this->setView();
    }
    function validate_date() {
        $this->form_validation->set_rules('week_date1', lang('start_date'), 'trim|strip_tags');
        $this->form_validation->set_rules('week_date2', lang('end_date'), 'trim|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    public function addevent()
    {
        $title = $this->input->post('title');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $title = $this->member_model->insertcalender($title,$start,$end);
         echo 'no';
        exit();
        

    }
 public function fetchevent()
    {
        $result = $this->member_model->getcalender();
         echo json_encode($result);
         exit();       

    }

     public function deleteevent()
    {
        $id = $this->input->post('id');
        $result = $this->member_model->deletecalender($id);
         // echo json_encode($result);
        echo 1;
        exit();       

    }

    public function editevent()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $result = $this->member_model->editcalender($id,$title,$start,$end);
         echo json_encode($result);
        exit();       

    }
    //calender codes ends--Aiswarya

 ///Vimeo video uploading ---Author Aiswarya   
 public function video2()
    {
      
        $title = lang('trading_education');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('trading_education');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('trading_education');
        $this->HEADER_LANG['page_small_header'] = '';

        $get_videos = $this->video_model->getVideos();
       
        $get_video = $this->video_model->getVideo();
        $this->set('videos',$get_videos);
        $this->set('video',$get_video);
        $this->load_langauge_scripts();
        $this->setView();
       

    }
    
    public function get_started_videos()
    {
      
        $title = lang('get_started_videos');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('get_started_videos');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('get_started_videos');
        $this->HEADER_LANG['page_small_header'] = '';

        $get_videos = $this->video_model->getstartedVideos();
       
        $get_video = $this->video_model->getstartedVideo();
        $this->set('videos',$get_videos);
        $this->set('video',$get_video);
        $this->load_langauge_scripts();
        $this->setView();
       

    }
    
    
            //Show Live Session Videos---Aiswarya
    public function live_session_videos()
    {
        $title = lang('live_session_videos');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('live_session_videos');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('live_session_videos');
        $this->HEADER_LANG['page_small_header'] = '';

        $get_videos = $this->video_model->get_live_Session_Videos();
       
       // $get_video = $this->video_model->getstartedVideo();
        $this->set('videos',$get_videos);
        //$this->set('video',$get_video);
        $this->load_langauge_scripts();
        $this->setView();

    }
    
    
        //Show Grow Your business Videos---Aiswarya
    public function grow_your_business_videos()
    {
        $title = lang('grow_your_business');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('grow_your_business_videos');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('grow_your_business_videos');
        $this->HEADER_LANG['page_small_header'] = '';

        $get_videos = $this->video_model->grow_your_business_videos();
       
        $this->set('videos',$get_videos);
        $this->load_langauge_scripts();
        $this->setView();

    }
    
    public function add_video()
    {
        $title = lang('add_video');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "upload-document";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('new_video_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_video');
        $this->HEADER_LANG['page_small_header'] = '';
        
        $this->load_langauge_scripts();
            $config = $this->pagination->customize_style();
            $base_url = base_url() . "admin/member/add_video";
            $config['base_url'] = $base_url;
            $config['per_page'] =$this->PAGINATION_PER_PAGE;
            // $config['per_page'] =5;
            if ($this->uri->segment(4) != ""){
                $page = $this->uri->segment(4) ;
            }
            else{
                $page = 0;
            }
        $modules = $this->validation_model->getAllModules();
        // $get_videos = $this->video_model->getAllVideosNew();
        $get_videos = $this->video_model->getAllVideos();
     //  print_r($get_videos); die;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        if($this->input->get('video_uri')!=NULL){
            $unique_value = $this->input->get('video_uri');
            $this->video_model->addSuccessforMovie($unique_value);
            $msg = lang('video_uploading_in_progress');
            $this->redirect($msg, "video/add_video", true);
        }
        //print_r($config); die;
        $this->set('result_per_page', 2);
        $this->set('start', $page);
        $this->set('package',$modules);
        $this->set('videos',$get_videos);
        
        $this->setView();    

    }
    
    public function disable_enable_video($id,$action)
    {
          if($action=='disable')
          {
              $msg = 'Video Disabled.';
          }
          if($action=='enable')
          {
              $msg = 'Video Enabled.';
          }
    
         if($action=='delete'){
             $details = $this->video_model->getVideoDetails($id);
              $res = $this->video_model->deleteVideo($id);
              if($res){
                   $msg = 'Video Deleted.';
                   $delete_history = "Deleted Video ".serialize($details);
                   $this->configuration_model->insertConfigChangeHistory('Video Deleted', $delete_history);
              }
         }
              
          
        $res=$this->video_model->Disable_Enable_video($id,$action);
         if($res)
         {
           
            $this->redirect($msg, "member/add_video", true);
         }
    }
//Vimeo Upload code
    public function vimeo_upload()
    {
        $title = lang('upload_video');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "upload-document";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('upload_video_to_vimeo');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upload_video_to_vimeo');
        $this->HEADER_LANG['page_small_header'] = '';
        
        $this->load_langauge_scripts();
        
      //  print_r("here"); die;
        
        if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != '') {
            $size = $_FILES['video']['size'];

        }

         $name = $this->input->post('video_title');

        if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != '') {


            //if (isset($_FILES['poster']['name']) && $_FILES['poster']['name'] != '') {

               // $_FILES['poster']['name'] = date("Y-m-d H-i-s") . $_FILES['poster']['name'];
              //  $_FILES['poster']['name'] = preg_replace('/\s+/', '', $_FILES['poster']['name']);
               
                $date = date("ymd");
                
               // $this->compressUpload($_FILES);
                $video_filename = $_FILES['video']['name'];
                 $valid_videoext = array('mp4');
                $file_parts = pathinfo($video_filename);

            

                // $configVideo['upload_path'] = IMG_DIR . 'banners/';
                // $configVideo['max_size'] = '6000000000';
                // $configVideo['allowed_types'] = 'png|jpg|jpeg';
                // $configVideo['overwrite'] = FALSE;
                // $configVideo['remove_spaces'] = TRUE;
               // $video_name = $_FILES['poster']['name'];
               // $configVideo['file_name'] = $video_name;
                // $this->load->library('upload', $configVideo);
                // $this->upload->initialize($configVideo);
                // if(!$this->upload->do_upload('poster')) {
                  
                //     $msg = $this->upload->display_errors();
                //     $this->redirect($msg, "video/add_video", false);
                // }
                //   if(!in_array($file_parts['extension'],$valid_videoext)){
                //       $msg = 'The file type you are attempting to upload is not allowed.';
                //     $this->redirect($msg, "video/add_video", false);
                //  }
          //  }
        
            $type = $this->input->post("package_type", TRUE);
            $video_type = $this->input->post("video_type", TRUE);
            $title = $this->input->post("video_title");
            $description = $this->input->post("video_description");
             $sort_order=$this->input->post("sort_order");
        
        

        $data_json=[
            'upload'=>[
                        'approach' => 'post',
                        'size' => $size,
                      'redirect_url' => 'https://mbatradingacademy.com/office/backoffice_admin/admin/add_video'
                        
                        ],
                        'name' => $name,
                        'privacy' => [
                                        'embed' => 'whitelist'
                                        ]
                    ];

//Get vimeo access token from confiration table--It will get vimeo account
        $obj_arr = $this->configuration_model->getSettings();
        $access_token=$obj_arr['vimeo_access_token'];
        $requestUrl='https://api.vimeo.com/me/videos';        
        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: bearer $access_token","Accept: application/vnd.vimeo.*+json;version=3.4"));
        $result = curl_exec($ch);
      

        $result=  json_decode($result,TRUE);
        
        $link = $result['uri'];

        $this->video_model->addMovie($video_filename,$type,$video_type,$title,$link,$description,$sort_order);
        
        if (function_exists('curl_file_create')) { // php 5.5+
          $cFile = curl_file_create($_FILES['video']['tmp_name']);
        } else { // 
          $cFile = '@' . realpath($_FILES['video']['tmp_name']);
        }
        
        $post = array('file_data'=> $cFile);
        
        $target_url=$result['upload']['upload_link'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$target_url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $result=curl_exec ($ch);
        curl_close ($ch);
        if($result){
            $unique_value = $link;
            $this->video_model->addSuccessforMovie($unique_value);
            $msg = lang('video_uploading_in_progress');
            $this->redirect($msg, "member/add_video", true);
        }
        else{
            $msg = lang('video_uploading_failed');
            $this->redirect($msg, "member/add_video", false);
        }
        } //Code if vimeo link is giving for uploading video
        else if($this->input->post('video_link')) {
            
             $type = $this->input->post("package_type", TRUE);
            $video_type = $this->input->post("video_type", TRUE);
            $title = $this->input->post("video_title");
            $description = $this->input->post("video_description");
             $sort_order=$this->input->post("sort_order");
            $link=$this->input->post('video_link');
            $link=$this->input->post('video_link');
           $link= str_replace("https://vimeo.com","/videos",$link);
            if(strlen($link)>17)
             {
                 $link = substr($link, 0, 17);
             }
            $res= $this->video_model->addMovie('',$type,$video_type,$title,$link,$description,$sort_order);

            $msg = lang('video_uploading_in_progress');
            $this->redirect($msg, "member/add_video", true);
        }
        else 
        {
            $msg = 'Please select  a video file or video link';
            $this->redirect($msg, "member/add_video", false);
        }

        $this->set('form_action',$result['upload']['upload_link']);
        $this->setView();
        
    }


       public function compressUpload(){
        // Getting file name
              $filename = $_FILES['poster']['name'];
             
              // Valid extension
              $valid_ext = array('png','jpeg','jpg','JPEG');
            
              // Location
              $location = IMG_DIR.$filename;
            
              // file extension
              $file_extension = pathinfo($location, PATHINFO_EXTENSION);
              $file_extension = strtolower($file_extension);
            
              // Check extension
              if(in_array($file_extension,$valid_ext)){
            
                // Compress Image
               $compressed =  $this->compressImage($_FILES['poster']['tmp_name'],$location,60);
              }
    }

    function compressImage($source, $destination, $quality) {


          $info = getimagesize($source);
        
          if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
        
          elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
        
          elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
        //die(imagecreatefromjpeg($source));
          imagejpeg($image, $destination, $quality);
        return $destination;
}

    public function edit_video($id){
        
        $title = $this->lang->line('edit_video');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('edit_video');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('edit_video');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();
        
        $details = $this->video_model->getVideoDetails($id);
        $module_name = $this->video_model->getPackageNameFromModuleId($details['module_id']);
        
            $modules = $this->validation_model->getAllModules();
            $this->set('id', $id);
            $this->set('video_type', $details['video_type']);
            $this->set('title', $details['title']);
            $this->set('video_description', $details['video_description']);
             //$this->set('sort_order',$details['sort_order']);
               $this->set('video_link',$details['video_link']);
            $this->set('module_name',$module_name);
            $this->set('package', $modules);
           
           if ($this->input->post('video_update')  && $this->validate_video()){
               $post_array = $this->input->post(NULL, TRUE);
               $post_array = $this->validation_model->stripTagsPostArray($post_array);
               $edit_video = $this->video_model->editSelectedVideo($post_array, $id);
               if($edit_video){
                   $msg = $this->lang->line('video_details_updated_successfully');
                $this->redirect($msg, "admin/member/edit_video/$id", TRUE);
               }
               else{
                   $msg = $this->lang->line('errorrrrrrr');
                $this->redirect($msg, "admin/member/edit_video/$id", FALSE);
               }
           }
           $this->setView();
    }
    
    public function validate_video(){
        
        $this->form_validation->set_rules('video_type', lang('video_type'), 'trim|required');
        $this->form_validation->set_rules('title', lang('title'), "trim|required");
        $this->form_validation->set_rules('video_description', lang('video_description'), 'trim|required');
          //$this->form_validation->set_rules('sort_order', lang('sort_order'), 'numeric|greater_than[0]|trim|required');
        $res_val = $this->form_validation->run();

        return $res_val;
    }
      public function ajax_is_sortorder_available() {
        $sort_order = $this->input->post('sort_order', TRUE);
        $video_type = $this->input->post('video_type', TRUE);
        $module_id = $this->input->post('module_id', TRUE);
        if (!$sort_order) {
            echo 'no';
            exit();
        }
        $is_sort_order_exists = $this->video_model->getsort_order_availability($sort_order,$video_type,$module_id);
        
        if ($is_sort_order_exists) {
            echo 'no';
            exit();
        } else {
            echo 'yes';
            exit();
        }
    }
}
