<?php

require_once 'Inf_Controller.php';

class employee extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->url_permission('employee_status');
    }

    function employee_register() {
        $title = lang('New_Employee_Registration');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('New_Employee_Registration');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('New_Employee_Registration');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $employee_reg_arr = array();
        if ($this->input->post('register') && $this->validate_employee_register()) {
            $reg_post_array = $this->input->post(NULL, TRUE);
            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
            $reg_arr['first_name'] = $reg_post_array['first_name'];
            $reg_arr['last_name'] = $reg_post_array['last_name'];
            $reg_arr['email'] = $reg_post_array['email'];
            $reg_arr['mobile'] = $reg_post_array['mobile_no'];
            $reg_arr['ref_username'] = $reg_post_array['ref_username'];
            if ($this->employee_model->isUserNameAvailable($reg_arr['ref_username'])) {
                $msg = lang('username_already_exists');
                $this->redirect($msg, 'employee/employee_register', FALSE);
            }
            $reg_arr['pswd'] = $reg_post_array['pswd'];
            $result = $this->employee_model->confirmRegistration($reg_arr);
            if ($result) {
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'employee_register', 'Employee Registered');
                }
                //
                
                $msg = lang('employee_registered');
                $this->redirect($msg, 'employee/employee_register', TRUE);
            } else {
                $msg = lang('You_must_enter_your_email');
                $this->redirect($msg, 'employee/employee_register', FALSE);
            }
        }
        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_employee_register() {
        $employee_reg_arr = $this->input->post(NULL, TRUE);
        $this->session->set_userdata('inf_employee_reg_arr', $employee_reg_arr);
        if ($this->session->userdata("inf_employee_reg_arr")) {
            $employee_reg_arr = $this->session->userdata("inf_employee_reg_arr");
        }

        $this->set('employee_reg_arr', $employee_reg_arr);

        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[3]');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('ref_username', lang('user_name'), 'trim|required|strip_tags|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('pswd', lang('password'), 'trim|required|strip_tags|min_length[6]|max_length[30]');
        $this->form_validation->set_rules('cpswd', lang('confirm_password'), 'trim|required|strip_tags|min_length[6]|max_length[30]|matches[pswd]');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|strip_tags|valid_email');
        $this->form_validation->set_rules('mobile_no', lang('mob_no_10_digit'), 'trim|required|strip_tags|numeric|min_length[5]|max_length[10]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function set_employee_permission() {
        $title = lang('set_employee_modules');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('set_employee_modules');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('set_employee_modules');
        $this->HEADER_LANG['page_small_header'] = '';
        
        $this->load_langauge_scripts();
        
        if ($this->input->post('permission') && $this->validate_set_employee_permission()) {
            $arr_post = $this->input->post(NULL, TRUE);
            $arr_post = $this->validation_model->stripTagsPostArray($arr_post);
            $user_name = $arr_post['user'];
            $result = $this->employee_model->insertIntoUserPermission($arr_post);
            if ($result) {
             
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_employee_permission', 'Employee Permission Updated');
                }
                //
                
                $msg = lang('successfully_added');
                $this->redirect($msg, 'employee/set_employee_permission', TRUE);
            } else {
                $msg = lang('error_on_setting_permission');
                $this->redirect($msg, 'employee/set_employee_permission', FALSE);
            }
        }
        $user_name_submit = FALSE;
        if ($this->input->post('user_name_submit') && $this->validate_user_name_submit()) {

            $user_name_submit = TRUE;
            
            $emp_post_array = $this->input->post(NULL, TRUE);
            $emp_post_array = $this->validation_model->stripTagsPostArray($emp_post_array);
            
                $user_name = $emp_post_array['user_name'];

            if ($this->employee_model->isUserValid($user_name)) {
                $permission = $this->employee_model->viewPermission($user_name);

                $arr = explode(",", $permission);
                $c = 0;
                $main_menu = "";
                $other_menu = "";
                $main_count = 0;
                $other_count = 0;
                $other_menu_arr = Array();
                $menu_arr = Array();
                $main_menu2 = Array();
                $sub_menu_arr = Array();
                for ($i = 0; $i < count($arr); $i++) {
                    $menu = explode("#", $arr[$i]);                    
                    $m = "m";

                    if ($menu[0] == $m) {

                        $menu_arr[$main_count++] = $menu[1];
                    } else if ($menu[0] == "o") {

                        $other_menu_arr[$other_count++] = $menu[1];
                    } else {

                        $sub_menu_main_arr[$c] = $menu[0];
                        if (count($menu) == 2)
                            $sub_menu_arr[$c++] = $menu[1];
                    }
                }

                $menu_id = $this->employee_model->getEmployeeMenuId();
                $menus = array();
                $i = 0;$j=0;$k=0;
                
                foreach ($menu_id->result_array() as $row) {
                    $menu_id = $row['id'];
                    $link = $this->employee_model->getMenuTextId($menu_id);
                    $menu_text = lang($menu_id . "_" . $link);
                    $menus[$k]['name'] = $menu_text;
                    $menus[$k]['id'] = $menu_id;
                    $menus[$k]['sub_menu'] = $link;
                    if (in_array($row['id'], $menu_arr)) {
                        $menus[$k]['check'] = 1;
                    }else{
                       $menus[$k]['check'] = 0; 
                    }
                    $menus[$k]['disable'] = 0;
                    if($row['id'] == 1 || $row['id'] == 24){
                        $menus[$k]['check'] = 1;
                        $menus[$k]['disable'] = 1;
                    }
                    $k++;
                    $sub_row = $this->employee_model->getEmployeeSubMenuId($menu_id);
                    
                    foreach ($sub_row->result_array() as $row1) {
                        $sub_menu_id = $row1['sub_id'];
                        $sub_link = $this->employee_model->getSubmenuText($sub_menu_id);
                        $sub_text = lang($menu_id . "_" . $sub_menu_id . "_" . $sub_link);
                        $sub_menu[$j]['sub_id']= $sub_menu_id;
                        $sub_menu[$j]['menu_id']= $menu_id;
                        $sub_menu[$j]['sub_name']= $sub_text;
                        if (in_array($row1['sub_id'], $sub_menu_arr)) {
                            $sub_menu[$j]['check']= 1;
                        }
                        else
                        {
                            $sub_menu[$j]['check']= 0;
                        }
                        $j++;
                    }                   
                }
                foreach ($menus as $a) {
                    if ($a['id'] == 17) {  // hiding employee management from permission list
                        unset($menus[$i]);
                    }
                    $i++;
                }
                
                $user_enc_id = $this->encrypt->encode($user_name);
                $user_enc_id = str_replace("/", "_", $user_enc_id);
                $user_enc_id = rawurlencode($user_enc_id);
                $this->set('user_enc_id', $user_enc_id);
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $this->set('main_menu', $main_menu);
                $this->set('other_menu', $other_menu);                
                $this->set('user_name', $user_name);
                $this->set('sub_menu', $sub_menu);
                $this->set('menus', $menus);
            } else {
                $msg = lang('employee_not_found');
                $this->redirect($msg, 'employee/set_employee_permission', FALSE);
            }
        }

        $this->set('user_name_submit', $user_name_submit);
       
        $help_link = 'set-employee-permission';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_user_name_submit() {
        $this->form_validation->set_rules('user_name', lang('select_user'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function validate_set_employee_permission() {
        $this->form_validation->set_rules('user', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function employee_auto($letters = '') {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////

        $employee_details = $this->employee_model->getEmployeeDetails($letters);
        echo $employee_details;
    }

    public function employee_username_availability() {
        $user_post_array = $this->input->post(NULL, TRUE);
        //$user_post_array = $this->validation_model->stripTagsPostArray($user_post_array);
        //$user_post_array = $this->validation_model->escapeStringPostArray($user_post_array);
        $username = $user_post_array['user_name'];
        $flag = $this->employee_model->isUserValid($username);
        if ($flag || !ctype_alnum($username))
            echo "no"; //user already exists, hence username not available
        else
            echo "yes";
    }

    //-----------------------------------------------edited by amrutha
    function search_employee($action = '', $id = '') {
        $title = lang('search_employee');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('search_employee');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('search_employee');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $flag = false;
        $this->set('visibility', "none");
        $this->set('visible', "none");
        $base_url = base_url() . "admin/employee/search_employee";
        $config = $this->pagination->customize_style();
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $file_name = 'nophoto.jpg';
        $keyword = "";
        $this->session->unset_userdata('inf_ser_keyword');
        if ($this->input->post('search_employee')) {
            $search_post_array = $this->input->post(NULL, TRUE);
            $search_post_array = $this->validation_model->stripTagsPostArray($search_post_array);
            $action = '';
            $this->set('visibility', "none");
            $this->set('visible','none');
            $keyword = $search_post_array['keyword'];
            if ($keyword == '') {
                $msg = lang('please_search_atleast_a_character');
                $this->redirect($msg, 'employee/search_employee', FALSE);
            }
            $this->session->set_userdata('inf_ser_keyword', $keyword);
        } else if ($this->input->post('view_all')) {
            $this->redirect("", 'employee/view_all_employee');
        } else if(!$this->session->userdata('inf_ser_keyword')) {
            $this->session->set_userdata('inf_ser_keyword', '');
        }
        $singleQuotePosition = strpos($this->session->userdata('inf_ser_keyword'), '\'');
        if ($singleQuotePosition > 0) {
            $this->session->unset_userdata('inf_ser_keyword');
            $msg = lang('invalid_key_word');
            $this->redirect($msg, 'employee/search_employee', FALSE);
        }
        $numrows = $this->employee_model->getCountMembers($this->session->userdata('inf_ser_keyword'));
        $config['total_rows'] = $numrows;
        $this->pagination->initialize($config);

        $emp_detail = $this->employee_model->getDetails($this->session->userdata('inf_ser_keyword'), $config['per_page'], $page);
        $count = count($emp_detail);

        $this->set('count', $count);
        $this->set('keyword', $keyword);
        $this->set('emp_detail', $emp_detail);
        if($this->session->has_userdata('inf_ser_keyword') && $numrows) {
            $flag = TRUE;
        }
        $this->set('flag', $flag);

        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);

        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);
        
        $this->set('action', $action);
        $editdetails = array();

        if (($action == 'delete') && ($id != '')) {
            $result = $this->employee_model->deleteEmployeeDetails($id);
            if ($result) {
                $msg = lang('employee_details_deleted');
                $this->redirect($msg, 'employee/search_employee', TRUE);
            } else {
                $msg = lang('error_on_deleting_employee_details');
                $this->redirect($msg, 'employee/search_employee', FALSE);
            }
        } else if ($action == 'edit') {
            $this->set('visibility', "block");
            $this->set('visible', "block");
            $editdetails = $this->employee_model->editEmployeeDetails($id);
            if(!empty($editdetails))
                $edit_id = $editdetails[0]['user_detail_id'];
        }

        if (isset($edit_id)) {
            $file_name = $this->employee_model->getUserPhoto($edit_id);
        }
        if (!file_exists('public_html/images/employee/' . $file_name)) {
            $file_name = 'nophoto.jpg';
        }
        $this->set('editdetails', $editdetails);
        $this->set("file_name", $file_name);

        if ($this->input->post("update") && $this->validate_view_all_employee()) {
            
            $update_post_array = $this->input->post(NULL, TRUE);
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);

            $first_name = $update_post_array["first_name"];
            $last_name = $update_post_array["last_name"];
            $emp_mob = $update_post_array["mobile"];
            $email = $update_post_array["email"];

            $this->employee_model->updateContent($edit_id, $first_name, $last_name, $emp_mob, $email);
            $this->redirect("Employee Details updated", "employee/search_employee", TRUE);
        }
        $this->setView();
    }

    function validate_search_employee() {

        $this->form_validation->set_rules('keyword', lang('keyword'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function view_all_employee($action = '', $id = '') {

        $title = lang('view_all_employee');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_all_employee');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_all_employee');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set('visible', "none");
        $this->set('keyword', "");
        $this->set('visibility', "none");
        $keyword = 'all';

        $base_url = base_url() . "admin/employee/view_all_employee";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->employee_model->getEmployeeDetailsCount();
        $config['total_rows'] = $total_rows;
        $file_name = 'nophoto.jpg';

        $this->pagination->initialize($config);
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $emp_detail = $this->employee_model->getEmployeDetails($config['per_page'], $page);
        $count = count($emp_detail);

        $config['total_rows'] = $count;
        $this->set('count', $count);
        $this->set('keyword', $keyword);
        $this->set('emp_detail', $emp_detail);

        $pagination = $this->pagination->create_links();
        $this->set('pagination', $pagination);

        $this->set('action', $action);
        $editdetails = array();

        $this->set('visibility', "none");
        if (($action == 'delete') && ($id != '')) {
            $result = $this->employee_model->deleteEmployeeDetails($id);
            if ($result) {
                $msg = lang('employee_details_deleted');
                $this->redirect($msg, 'employee/view_all_employee', TRUE);
            } else {
                $msg = lang('error_on_deleting_employee_details');
                $this->redirect($msg, 'employee/view_all_employee', FALSE);
            }
        } else if ($action == 'edit') {
            $this->set('visibility', "block");
            $this->set('visible', "");
            $editdetails = $this->employee_model->editEmployeeDetails($id);
            if(!empty($editdetails))
                $edit_id = $editdetails[0]['user_detail_id'];
        }

        if (isset($edit_id)) {
            $file_name = $this->employee_model->getUserPhoto($edit_id);
        }
        if (!file_exists('public_html/images/employee/' . $file_name)) {
            $file_name = 'nophoto.jpg';
        }
        $this->set('editdetails', $editdetails);
        $this->set("file_name", $file_name);

        if ($this->input->post("update") && $this->validate_view_all_employee()) {
            
            $update_post_array = $this->input->post(NULL, TRUE);
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);

            $first_name = $update_post_array["first_name"];
            $last_name = $update_post_array["last_name"];
            $emp_mob = $update_post_array["mobile"];
            $email = $update_post_array["email"];

            // if ($_FILES['userfile']['error'] != 4) {
            //     $config['upload_path'] = './public_html/images/employee/';
            //     $config['allowed_types'] = 'gif|jpg|png|jpeg';
            //     $config['max_size'] = '4000000';
            //     $config['remove_spaces'] = true;
            //     $config['overwrite'] = false;
            //     $this->load->library('upload', $config);
            //     $msg = '';
            //     if (!$this->upload->do_upload()) {
            //         $msg = lang('image_not_selected');
            //         $error = array('error' => $this->upload->display_errors());
            //         $this->redirect($msg, 'profile/profile_view', FALSE);
            //     } else {
            //         $image_arr = array('upload_data' => $this->upload->data());
            //         $new_file_name = $image_arr['upload_data']['file_name'];
            //         $image = $image_arr['upload_data'];

            //         if ($image['file_name']) {
            //             $data['photo'] = 'public_html/images/employee/' . $image['file_name'];
            //             $data['raw'] = $image['raw_name'];
            //             $data['ext'] = $image['file_ext'];
            //         }
            //         $res = $this->employee_model->changeProfilePicture($edit_id, $new_file_name);
            //         if (!$res) {
            //             $msg = lang('image_cannot_be_uploaded');
            //             $this->redirect($msg, 'employee/view_all_employee', FALSE);
            //         }
            //     }
            // }

            $this->employee_model->updateContent($edit_id, $first_name, $last_name, $emp_mob, $email);
            $this->redirect("Employee Details updated", "employee/view_all_employee", TRUE);
        }

        $this->setView();
    }

    function validate_view_all_employee() {
        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('mobile', lang('mob_no_10_digit'), 'trim|required|strip_tags|numeric|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|strip_tags|valid_email');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function employee_change_password() {
        $title = lang('change_employee_password');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('change_employee_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_employee_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_type = $this->LOG_USER_TYPE;
        $user_name = $this->LOG_USER_NAME;
        if ($this->input->post('change_pass_button') && $this->validate_change_password()) {
            
            $password_post_array = $this->input->post(NULL, TRUE);
            $password_post_array = $this->validation_model->stripTagsPostArray($password_post_array);
            $employee_name = $password_post_array['user_name'];
            if ($user_type != 'employee') {
                if ($this->employee_model->isUserNameAvailable($employee_name)) {
                    $new_pswd = $password_post_array['new_pwd'];
                    $result = $this->employee_model->updatePassword($new_pswd, $employee_name);
                    if ($result) {
                        
                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_employee_password', 'Employee Password Updated');
                        }
                        //
                        
                        $msg = lang('password_updated_successfully');
                        $this->redirect($msg, 'employee/employee_change_password', TRUE);
                    } else {
                        $msg = lang('error_on_updating_password');
                        $this->redirect($msg, 'employee/employee_change_password', FALSE);
                    }
                } else {
                    $msg = lang('employee_not_found');
                    $this->redirect($msg, 'employee/employee_change_password', FALSE);
                }
            } else {
                if ($user_name == $employee_name) {
                    $new_pswd = $password_post_array['new_pwd'];
                    $result = $this->employee_model->updatePassword($new_pswd, $employee_name);
                    if ($result) {
                        
                        // Employee Activity History
                        if ($this->LOG_USER_TYPE == 'employee') {
                            $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_employee_password', 'Employee Password Updated');
                        }
                        //
                        
                        $msg = lang('password_updated_successfully');
                        $this->redirect($msg, 'employee/employee_change_password', TRUE);
                    } else {
                        $msg = lang('error_on_updating_password');
                        $this->redirect($msg, 'employee/employee_change_password', FALSE);
                    }
                } else {
                    $msg = "You Dont Have Permission To Change Password";
                    $this->redirect($msg, 'employee/employee_change_password', FALSE);
                }
            }
        }

        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_change_password() {

        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_pwd', lang('password'), 'trim|required|strip_tags|min_length[6]|max_length[30]');
        $this->form_validation->set_rules('confirm_pwd', lang('confirm_password'), 'trim|required|strip_tags|min_length[6]|max_length[30]|matches[new_pwd]');

        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    
    function activity_history() {

        $title = lang('activity_history');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('activity_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activity_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $flag = FALSE;
        $user_id = $this->session->userdata('inf_search_employee');
        $user_name = $this->session->userdata('inf_search_employee_name');
        if ($this->input->post('user_name')) {
            $user_name = $this->input->post('user_name', TRUE);
            $user_id = $user_id = $this->validation_model->employeeNameToID($user_name);
            if($user_id) {
                $this->session->set_userdata('inf_search_employee', $user_id);
                $this->session->set_userdata('inf_search_employee_name', $user_name);
            }
            else {
                $this->session->unset_userdata('inf_search_employee');
                $this->session->unset_userdata('inf_search_employee_name');
                $msg = lang('employee_not_found');
                $this->redirect($msg, 'employee/activity_history', FALSE);
            }
        } else {
            if(!$this->session->userdata('inf_search_employee')) {
                $flag = TRUE;
                $user_id = '';
                $user_name = 'All';
        }
        }
        if($user_id || $flag) {
            $base_url = base_url() . 'admin/activity_history';
            $config = $this->pagination->customize_style();
            $config['base_url'] = $base_url;
            $config['per_page'] = $this->PAGINATION_PER_PAGE;
            if ($this->uri->segment(3) != "") {
                $page = $this->uri->segment(3);
            } 
            else {
                $page = 0;
            }

            $config['total_rows'] = $this->employee_model->getCountEmployeeActivity($user_id);
            $activity_details = $this->employee_model->getEmployeeActivity($user_id, $page, $config['per_page']);
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('page_no', $page);

            $this->set('activity_details', $activity_details);
            $this->set('count', count($activity_details));
            $this->set('user_name', $user_name);
            
        }
        else {
            $this->set('user_name', FALSE);
        }
        $help_link = 'employee-activity-history';
        $this->set('help_link', $help_link);
        $this->OPTIONAL_MODULE = lang('these_are_the_optional_packages_please_check') . "<a href='https://infinitemlmsoftware.com/pricing.php'target='_blank' style='text-decoration: none;'>&nbsp;&nbsp;" . lang('click_here') . "</a>&nbsp;" . lang('more_details');
        $this->set('OPTIONAL_MODULE', $this->OPTIONAL_MODULE);
        $this->setView();
    }

    public function ajax_employee_autolist() {
        if ($this->input->is_ajax_request()) {
            $keyword = $this->input->post('keyword', TRUE);
            $data = $this->employee_model->getEmployeesByKeyword($keyword);
            echo json_encode($data);
            exit();
        }
    }

    function dashboard_config($user_name = '') {

        $title = lang('dashboard_config');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('dashboard_config');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('dashboard_config');
        $this->HEADER_LANG['page_small_header'] = '';
        
        $this->load_langauge_scripts();

        $username_url = $user_name;
        $user_name = urldecode($user_name);
        $user_name = str_replace("_", "/", $user_name);
        $user_name = $this->encrypt->decode($user_name);
        $mlm_plan = $this->MLM_PLAN;
        if ($this->input->post('permission') && $this->validate_set_employee_permission()) {
            $arr_post = $this->input->post(NULL, TRUE);
            $arr_post = $this->validation_model->stripTagsPostArray($arr_post);
            $user_name = $arr_post['user'];
            $result = $this->employee_model->insertIntodashboardPermission($arr_post);
            if ($result) {
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_employee_permission', 'Employee Permission Updated');
                }
                //
                $msg = lang('successfully_added');
                $this->redirect($msg, 'employee/dashboard_config/'.$username_url, TRUE);
            } else {
                $msg = lang('error_on_setting_permission');
                $this->redirect($msg, 'employee/dashboard_config/'.$username_url, FALSE);
            }
        }

        $user_name_submit = TRUE;
        $emp_post_array = $this->input->post(NULL, TRUE);
        $emp_post_array = $this->validation_model->stripTagsPostArray($emp_post_array);
        if ($this->employee_model->isUserValid($user_name)) {
            $k = 0;
            $menus = [];
            $permission = $this->employee_model->viewDashboardPermission($user_name);
            $dashboard_menu = explode(",", $permission);
            if($this->MODULE_STATUS['hyip_status'] == 'yes'){
                $block_name = ['ewallet','payout','active_deposit','matured_deposit','replica','lcp','country_graph','joinings','to_do','top_earners','social_media','new_members','top_recruiters'];
            } else{
                $block_name = ['ewallet','sales','payout','mail','replica','lcp','country_graph','joinings','to_do','top_earners','social_media','new_members','top_recruiters'];
            }
            foreach ($block_name as $row) {
                $menus[$k]['name'] = $row;
                $menus[$k]['id'] = $k;
                if (in_array($row, $dashboard_menu)) {
                    $menus[$k]['check'] = 1;
                } else{
                   $menus[$k]['check'] = 0; 
                }
                $menus[$k]['disable'] = 0;
                $k++;                   
            }
            $this->set('dashboard_menu', $dashboard_menu);
            $this->set('block_name', $block_name);
            $this->set('menus', $menus);
            $this->set('user_name', $user_name);
        } else {
            $msg = lang('employee_not_found');
            $this->redirect($msg, 'employee/set_employee_permission', FALSE);
        }
        $help_link = 'Dashboard-configuration';
        $this->set('help_link', $help_link);
        $this->set('mlm_plan', $mlm_plan);

        $this->setView();
    }
    
}
