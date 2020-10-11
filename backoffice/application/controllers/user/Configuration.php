<?php

require_once 'Inf_Controller.php';

class Configuration extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function my_referal() {
        $title = $this->lang->line('view_my_refferals');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "view-my-referrals";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;

        /*         * *pagination**** */

        $basurl = base_url() . "user/configuration/my_referal";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $basurl;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;

        $total_rows = $this->configuration_model->getReferalDetailscount($user_id);
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;

        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $res = $this->configuration_model->getReferalDetails($user_id, $config['per_page'], $page);

        $this->set("arr", $res);
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $count = count($res);
        $this->set("count", $count);
        $this->set("page", $page);

        $this->setView();
    }

    function getUsernamePrefix() {
        $prefix = $this->configuration_model->getUsernamePrefix();
        if ($prefix != "") {
            echo $prefix;
        }
        exit();
    }

    function opencart() {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = STORE_URL . "/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = STORE_URL;
        }
        header("location:$store_url");
    }

    function store() {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = STORE_URL . "/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = STORE_URL;
        }
        header("location:$store_url");
    }
    //replication site config 
    
     public function delete_banner() {
        $banner_id = $this->input->post('banner_id', TRUE);
        $this->load->model('member_model');
        $res = $this->member_model->deleteReplicaBanner($banner_id);
        if ($res) {
            $data_array['banner_id'] = $banner_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite deleted', $this->LOG_USER_ID, $data);

            // Employee Activity History
            if ($this->LOG_USER_TYPE == 'employee') {
                $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_banner_invite', 'Banner Invite Deleted');
            }
            //

            $msg = lang('replication_banner_deleted');
            $this->redirect($msg, "configuration/add_banner", true);
        } else {
            $msg = lang('replication_banner_not_deleted');
            $this->redirect($msg, "configuration/add_banner", false);
        }
    }

   public function validate_link($url) {
        $this->form_validation->set_rules('banner_link', lang('banner_link'), 'trim|required|callback_youtube_validation');        
        $this->form_validation->set_message('youtube_validation', lang('youtube_url_is_not_valid')); 
         if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
        //    print_r($error);die;
            $this->session->set_userdata('error', $error);
        }
        else
        {
        return TRUE;
        }
    }
    
    public function youtube_validation($url)
    {
        $youtube_regexp = "/^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/";
        	
    if(preg_match($youtube_regexp, $url) == 1)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
    }
    //end
    //Replication site home page 
    public function replica_configuration(){
        $title = lang('banner');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('replicated_site_status');

        $this->HEADER_LANG['page_top_header'] = lang('banner');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('banner');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->load->model('member_model');
        $help_link = 'banner';
        $this->set("help_link", $help_link);

        $user_id = $this->LOG_USER_ID;
        //
        $flag = TRUE;
        $type = array();
        $content = '';

        $banners = $this->configuration_model->selectBanner($user_id);
        $this->set("banners", $banners);
        $i=0;
        
        foreach ($banners as $rows) {

            $type[$i] = $rows['subject'];
            $content[$rows['subject']] = $rows['content'];
            $i++;
           
        }
         if(in_array ('content',$type)){
            $val= json_decode($content['content'], TRUE);
            if($val)
            {
                $sub_title = $val['sub_title'];
                $description = $val['content'];
            }
        }
        else {
             $sub_title = 'The Infinite MLM software';
            $description = 'The Infinite MLM software is an entire solution for all type of business plan like Binary,Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP™. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet, Replicating Website, E-Pin, E-Commerce Shopping Cart,Web Design';
        }        
        $this->set('subtitle', $sub_title);
        $this->set('description', $description);

        if ($banners == '') {
            $flag = FALSE;
        }
        $this->set('flag', $flag);
        $this->set('content', $content);
        $this->set('type', $type);

       /* if ($this->input->post('submit_video')) {

            $link = $this->input->post('banner_link', TRUE);
            $res = FALSE;
            if($this->validate_link($this->input->post('banner_link')))
            {
                $res = $this->member_model->insertBannerforReplica('video','link', $link, $user_id);
                if ($res) {

                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Video updated for replication site', $this->LOG_USER_ID);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Video Banner updated', 'Video Banner Updated for replication site');
                    }
                    //

                    $msg = lang('video_banner_updated');
                    $this->redirect($msg, "configuration/replica_configuration", TRUE);
                } else {
                    $msg = lang('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration", FALSE);
                }
            }

        }*/
        if ($this->input->post('submit_image')) {
            $details = array();

            $config['upload_path'] = IMG_DIR . 'banners';
            $config['allowed_types'] = 'png|jpeg|jpg';
            $config['max_size'] = '20000000';
            $config['remove_spaces'] = true;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('banner_image')) {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'You did not select a file to upload.') {
                    $msg = lang('please_select_file');
                    $this->redirect($msg, "configuration/replica_configuration", false);
                }
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_20MB');
                    $this->redirect($msg, "configuration/replica_configuration/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "configuration/replica_configuration", false);
                } else {


                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'configuration/replica_configuration', false);
                }
            } else {
                $banner_arr = array('upload_data' => $this->upload->data());
            }
            $details['product_url'] = $banner_arr['upload_data']['file_name'];

            $res = $this->member_model->insertBannerforReplica('top_banner','image', $banner_arr['upload_data']['file_name'], $user_id);

            if ($res) {

                 $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Top Banner updated for replication site', $this->LOG_USER_ID);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Top Banner Updated', 'Top Banner updated for replication site');
                }
                //

                $msg = lang('top_banner_updated');
                $this->redirect($msg, "configuration/replica_configuration", TRUE);
            } else {
                $msg = lang('error_on_updation');
                $this->redirect($msg, "configuration/replica_configuration", FALSE);
            }
        }
       /* if ($this->input->post('submit_movbanner')) {
            $details = array();

            $config['upload_path'] = '../replica/public_html/images/banner';
            $config['allowed_types'] = 'png|jpeg|jpg';
            $config['max_size'] = '20000000';
            $config['remove_spaces'] = true;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);
             $flag1 = FALSE;
             $flag2 = FALSE;
             $flag3 = FALSE;
             $flag4 = FALSE;
            if(in_array ('moving_banner1',$type)){
                $flag1 = TRUE;
            }
            if(in_array ('moving_banner2',$type)){
                $flag2 = TRUE;
            }
            if(in_array ('moving_banner3',$type)){
                $flag3 = TRUE;
            }
            if(in_array ('moving_banner4',$type)){
                $flag4 = TRUE;
            }
            if(($_FILES['moving_banner1']['name'] == '' && $flag1 == FALSE) || ($_FILES['moving_banner2']['name'] == '' && $flag2 == FALSE) || ($_FILES['moving_banner3']['name'] == '' && $flag3 == FALSE) || ($_FILES['moving_banner4']['name'] == '' && $flag4 == FALSE))
            {
                $msg = lang('please_upload_four_banners');
                $this->redirect($msg, "configuration/replica_configuration", false);
            }
            if(empty($_FILES['moving_banner1']['name']) && empty($_FILES['moving_banner2']['name']) && empty($_FILES['moving_banner3']['name']) && empty($_FILES['moving_banner4']['name']))
            {
                $msg = lang('please_select_file');
                $this->redirect($msg, "configuration/replica_configuration", false);
            }
           if($_FILES['moving_banner1']['name'] != ''){
                
                if (!$this->upload->do_upload('moving_banner1')) {
                
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_20MB');
                    $this->redirect($msg, "configuration/replica_configuration/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "configuration/replica_configuration", false);
                } else {


                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'configuration/replica_configuration', false);
                }
            } else {
                $mvb1 = array('upload_data' => $this->upload->data());
                $res = $this->member_model->insertBannerforReplica('moving_banner1','image', $mvb1['upload_data']['file_name'], $user_id);
            }
           }
            if($_FILES['moving_banner2']['name'] != ''){
                
                if (!$this->upload->do_upload('moving_banner2')) {
                
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
               
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_20MB');
                    $this->redirect($msg, "configuration/replica_configuration/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "configuration/replica_configuration", false);
                } else {


                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'configuration/replica_configuration', false);
                }
            } else {
            
                $mvb2 = array('upload_data' => $this->upload->data());
                $res = $this->member_model->insertBannerforReplica('moving_banner2','image', $mvb2['upload_data']['file_name'], $user_id);
          
            }
            }
            if($_FILES['moving_banner3']['name'] != ''){
                
                if (!$this->upload->do_upload('moving_banner3')) {
                
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_20MB');
                    $this->redirect($msg, "configuration/replica_configuration/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "configuration/replica_configuration", false);
                } else {


                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'configuration/replica_configuration', false);
                }
            } else {
                $mvb3 = array('upload_data' => $this->upload->data());
                  $res = $this->member_model->insertBannerforReplica('moving_banner3','image', $mvb3['upload_data']['file_name'], $user_id);
            
            }
            }
            if($_FILES['moving_banner4']['name'] != ''){
                
                if (!$this->upload->do_upload('moving_banner4')) {
                
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_20MB');
                    $this->redirect($msg, "configuration/replica_configuration/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "configuration/replica_configuration", false);
                } else {


                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'configuration/replica_configuration', false);
                }
            } else {
                $mvb4 = array('upload_data' => $this->upload->data());
                $res = $this->member_model->insertBannerforReplica('moving_banner4','image', $mvb4['upload_data']['file_name'], $user_id);
            }
            }

            if ($res ) {

                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner added for replication site', $this->LOG_USER_ID);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_banner', 'Banner Added for replication site');
                }
                //

                $msg = lang('moving_banner_updated');
                $this->redirect($msg, "configuration/replica_configuration", TRUE);
            } else {
                $msg = lang('error_on_updation');
                $this->redirect($msg, "configuration/replica_configuration", FALSE);
            }
        }*/
        
       /* if ($this->input->post('replica_content')) {
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('replica_content_main'));
            $det['sub_title'] = $this->validation_model->stripTagTextArea($this->input->post('subtitle'));
            $encode_data = json_encode($det);
            $resu = FALSE;
            if($this->validate_content())
            {
                $resu = $this->member_model->insertBannerforReplica('content','text',$encode_data, $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Content of replication site updated', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Content of replication site updated', 'Content of replication site updated');
                    }
                    //

                    $msg = $this->lang->line('content_updated_successfull');
                    $this->redirect($msg, "configuration/replica_configuration/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration/", FALSE);
                }
            }
        }*/
        /*if ($this->input->post('submit_term')) {
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $resu = FALSE;
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('content_terms'));
            if($this->validate_content())
            {
                $resu = $this->member_model->insertBannerforReplica('terms','text',$det['content'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Terms And Conditions Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Terms And Conditions Updated for Replica', 'Terms And Conditions Updated for Replica');
                    }
                    //

                    $msg = $this->lang->line('terms_conditions_updated_successfull');
                    $this->redirect($msg, "configuration/replica_configuration/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration/", FALSE);
                }
            }
        }*/
       /* if ($this->input->post('submit_policy')) {
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $resu = FALSE;
            $det['content'] = $this->validation_model->stripTagTextArea($this->input->post('content_policy'));
             if($this->validate_content())
            {
                $resu = $this->member_model->insertBannerforReplica('policy','text',$det['content'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Privacy Policy Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Privacy Policy Updated for Replica', 'Privacy Policy Updated');
                    }
                    //

                    $msg = $this->lang->line('privacy_policy_updated_successfull');
                    $this->redirect($msg, "configuration/replica_configuration/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration/", FALSE);
                }
            }
        }*/
        /*if ($this->input->post('submit_about')) {
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $resu = FALSE;
            $det['about_us'] = $this->validation_model->stripTagTextArea($this->input->post('content_about'));
            if($this->validate_content())
                {
                
                $resu = $this->member_model->insertBannerforReplica('about_us','text',$det['about_us'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'About Us updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'About Us updated for Replica', 'About us Updated');
                    }
                    //

                    $msg = $this->lang->line('about_us_updated_successfull'); 
                   $this->redirect($msg, "configuration/replica_configuration/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration/", FALSE);
                }
                }
        
        }*/
        /*if ($this->input->post('submit_address')) {
            $post = $this->input->post(NULL, TRUE);
            $post = $this->validation_model->stripTagsPostArray($post);
            $det = array();
            $resu = FALSE;
            $det['contact'] = $this->validation_model->stripTagTextArea($this->input->post('address'));
            if($this->validate_content())
                {
                
                $resu = $this->member_model->insertBannerforReplica('address','text',$det['contact'], $user_id);
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Address Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Address Updated for Replica', 'Address us Updated');
                    }
                    //

                    $msg = $this->lang->line('contact_us_updated_successfull');
                    $this->redirect($msg, "configuration/replica_configuration/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration/", FALSE);
                }
                }
            
            
            
        }*/
       /*if ($this->input->post('submit_social')) {
            if ($this->validate_social_profile()) {
                $post = $this->input->post(NULL, TRUE);
                $post = $this->validation_model->stripTagsPostArray($post);
                $det = array();
                $resu = TRUE;
                if($this->input->post('facebook'))
                {                
                $resu = $this->member_model->insertBannerforReplica('facebook','text',$post['facebook'], $user_id);                
                }
                if($this->input->post('twitter'))
                {
                $resu = $this->member_model->insertBannerforReplica('twitter','text',$post['twitter'], $user_id);
                }
                if($this->input->post('linkedin'))
                {
                $resu = $this->member_model->insertBannerforReplica('linkedin','text',$post['linkedin'], $user_id);
                }
                if($this->input->post('youtube'))
                {
                $resu = $this->member_model->insertBannerforReplica('youtube','text',$post['youtube'], $user_id);
                }
                
                if($this->input->post('google_plus'))
                {
                $resu = $this->member_model->insertBannerforReplica('google_plus','text',$post['google_plus'], $user_id);
                }
                
                if($this->input->post('instagram'))
                {
                $resu = $this->member_model->insertBannerforReplica('instagram','text',$post['instagram'], $user_id);
               
                }
                if ($resu) {
                    $data = serialize($post);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'Social Profile Updated for Replica', $this->LOG_USER_ID, $data);

                    // Employee Activity History
                    if ($this->LOG_USER_TYPE == 'employee') {
                        $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'Social Profile Updated for Replica', 'Social Profile Updated');
                    }
                    //
                    
                    $msg = $this->lang->line('socail_profile_updated_successfull');
                    $this->redirect($msg, "configuration/replica_configuration/", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_updation');
                    $this->redirect($msg, "configuration/replica_configuration/", FALSE);
                }
                
            }
        }*/
        $error = '';
        if ($this->session->userdata('error')) {
            $error = $this->session->userdata('error');
            
            $this->session->unset_userdata('error');
        }
        $this->set('error', $error);
        $this->setView();
    } 

    function validate_social_profile() {
        $this->form_validation->set_rules('facebook', lang('facebook'), 'trim|callback_facebook_checking');
        $this->form_validation->set_message('facebook_checking', lang('facebook_url_is_not_valid'));
        $this->form_validation->set_rules('youtube', lang('youtube'), 'trim|callback_youtube_checking');
        $this->form_validation->set_message('youtube_checking', lang('youtube_url_is_not_valid'));
        $this->form_validation->set_rules('twitter', lang('twitter'), 'trim|callback_twitter_checking');
        $this->form_validation->set_message('twitter_checking', lang('twitter_url_is_not_valid'));
        $this->form_validation->set_rules('google_plus', lang('google_plus'), 'trim|callback_google_checking');
        $this->form_validation->set_message('google_checking', lang('google_plus_url_is_not_valid'));
        $this->form_validation->set_rules('linkedin', lang('linkedin'), 'trim|callback_linkedin_checking');
        $this->form_validation->set_message('linkedin_checking', lang('linkedin_url_is_not_valid'));
        $this->form_validation->set_rules('instagram', lang('instagram'), 'trim|callback_instagram_checking');
        $this->form_validation->set_message('instagram_checking', lang('instagram_url_is_not_valid'));
        
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        } else {
            return TRUE;
        }
    }

    function validate_content()
    {
        $res_val = FALSE;
        if($this->input->post('submit_term'))
        {
             $this->form_validation->set_rules('content_terms', lang('content_terms'), 'trim|required');
        }
        if($this->input->post('submit_policy'))
        {
             $this->form_validation->set_rules('content_policy', lang('content_policy'), 'trim|required');
             
        }
        if(($this->input->post('submit_about')))
        {  
            $this->form_validation->set_rules('content_about', lang('content_about'), 'trim|required');
        }
        if(($this->input->post('submit_address')))
        { 
            $this->form_validation->set_rules('address', lang('address'), 'trim|required');
        }
        if(($this->input->post('replica_content')))
        { 
            $this->form_validation->set_rules('subtitle', lang('subtitle'), 'trim|required');
            $this->form_validation->set_rules('replica_content_main', lang('txtDefaultHtmlArea'), 'trim|required');
        }
        $res_val = $this->form_validation->run();
        if($res_val == FALSE);
        {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        }
        return $res_val;
    
    }
    function valid_url($url)
    {
        if($this->input->post('facebook'))
        {
        $this->form_validation->set_rules('facebook', lang('facebook'), 'trim|xss_clean|callback_facebook_checking');
        $this->form_validation->set_message('facebook_checking', lang('facebook_url_is_not_valid'));
    }
        if($this->input->post('youtube'))
        {
        $this->form_validation->set_rules('youtube', lang('youtube'), 'trim|xss_clean|callback_youtube_checking');
    
        $this->form_validation->set_message('youtube_checking', lang('youtube_url_is_not_valid'));
        }
        if($this->input->post('twitter'))
        {
        $this->form_validation->set_rules('twitter', lang('twitter'), 'trim|xss_clean|callback_twitter_checking');
    
        $this->form_validation->set_message('twitter_checking', lang('twitter_url_is_not_valid'));
        }
        if($this->input->post('google_plus'))
        {
        $this->form_validation->set_rules('google_plus', lang('google_plus'), 'trim|xss_clean|callback_google_checking');
    
        $this->form_validation->set_message('google_checking', lang('google_plus_url_is_not_valid'));
        }
        if($this->input->post('linkedin'))
        {
        $this->form_validation->set_rules('linkedin', lang('linkedin'), 'trim|xss_clean|callback_linkedin_checking');
    
        $this->form_validation->set_message('linkedin_checking', lang('linkedin_url_is_not_valid'));
        }
        if($this->input->post('instagram'))
        {
        $this->form_validation->set_rules('instagram', lang('instagram'), 'trim|xss_clean|callback_instagram_checking');
    
        $this->form_validation->set_message('instagram_checking', lang('instagram_url_is_not_valid'));
        }
       
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('error', $error);
        }
        else
        {
        return TRUE;
        }
    }
          
    function facebook_checking($url)
    {
        $fbUrlCheck = '/^$|http(s)?:\/\/(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
	
        if(preg_match($fbUrlCheck, $url) == 1) 
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    function youtube_checking($url)
    {
        $youtube_regexp = "/^$|http(s)?:\/\/(www\.)?(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
	
        if(preg_match($youtube_regexp, $url) == 1 ) 
        {
            return TRUE;
        }
        else
        {
        return FALSE;
        }
    }
    function twitter_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/";
	
        if(preg_match($tw_regexp, $url) == 1) 
        {
            return TRUE;
        }
        else
        {
        return FALSE;
        }
    }
    function google_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/(www[.])?plus\.google\.com\/.?\/?.?\/?([0-9]*)/";
	
        if(preg_match($tw_regexp, $url) == 1) 
        {
            return TRUE;
        }
        else
        {
        return FALSE;
        }
   
    }
    function linkedin_checking($url)
    {       
        $tw_regexp = "/^$|http(s)?:\/\/((www|\w\w)\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/";
	
        if(preg_match($tw_regexp, $url) == 1) 
        {
            return TRUE;
        }
        else
        {
        return FALSE;
        }
   
    }
    function instagram_checking($url)
    {
        $tw_regexp = "/^$|http(s)?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/";
	
        if(preg_match($tw_regexp, $url) == 1) 
        {  
            return TRUE;
        }
        else
        {  
        return FALSE;
        }
   
    }
    //Replication site home page ends
    
}
