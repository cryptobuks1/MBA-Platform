<?php

require_once 'Inf_Controller.php';

class Profile extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function profile_view($url_username = '')
    {
        $this->HEADER_LANG['page_top_header'] = lang('profile_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'profile-management';
        $this->set('help_link', $help_link);

        $prof_view = 'yes';
        $from_page = 'link';
        $current_update_section = '';
        $error_flag = '';

        $user_type = $this->LOG_USER_TYPE;

        if ($user_type == 'employee') {
            $prof_view = 'no';
        }

        $user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;

        if ($user_type == 'employee') {
            $user_name = $this->ADMIN_USER_NAME;
            $user_id = $this->ADMIN_USER_ID;
        }

        $this->load->model('configuration_model');
        $this->load->model('payout_model');
        $bank_info_status = $this->configuration_model->getBankInfoStatus();
        $age_limit = $this->configuration_model->getAgeLimitSetting();

        if ($this->input->post('from_page')) {
            $from_page = 'user_account';
            $this->session->set_userdata('inf_profile_from_page', $from_page);
        } else if ($this->session->userdata('inf_profile_from_page')) {
            $from_page = $this->session->userdata('inf_profile_from_page');
            // $this->session->unset_userdata('inf_profile_from_page');
        }
        $referal_count = $this->validation_model->getReferalCount($this->LOG_USER_ID);
        if ($this->input->post('user_name')) {
            $prof_view = 'yes';
            $name_post_array = $this->input->post(null, true);
            $name_post_array = $this->validation_model->stripTagsPostArray($name_post_array);
            $user_id = $this->validation_model->userNameToID($name_post_array['user_name']);
            if ($user_id) {
                $this->session->set_userdata('inf_usr_name', $name_post_array['user_name']);
                $user_name = $name_post_array['user_name'];
            } else {
                $this->session->unset_userdata('inf_usr_name');
                $msg = lang('invalid_user');
                $this->redirect($msg, 'profile/profile_view', false);
            }
     
        } else if ($url_username != '') {
            $u_name1 = $url_username;
            $decode_id = urldecode($u_name1);
            $decode_id = str_replace('_', '/', $decode_id);
            $user_name = $this->encrypt->decode($decode_id);
            $user_id = $this->validation_model->userNameToID($user_name);
            if ($user_id) {
                $this->session->set_userdata('inf_usr_name', $user_name);
            } else {
                $this->session->unset_userdata('inf_usr_name');
                $msg = lang('invalid_user');
                $this->redirect($msg, 'profile/profile_view', false);
            }
        } else if ($this->session->userdata('inf_usr_name')) {
            $user_name = $this->session->userdata('inf_usr_name');
            $user_id = $this->validation_model->userNameToID($user_name);
            if ($user_id) {
                $this->session->set_userdata('inf_usr_name', $user_name);
            } else {
                $this->session->unset_userdata('inf_usr_name');
                $msg = lang('invalid_user');
                $this->redirect($msg, 'profile/profile_view', false);
            }
        }

        $this->session->set_userdata('inf_user_id', $user_id);
        $title = lang('s_profile');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $user_name . $title);

        $product_status = $this->MODULE_STATUS['product_status'];
        $pin_status = $this->MODULE_STATUS['pin_status'];

        $profile_arr = $this->profile_model->getProfileDetails($user_id, $product_status);

        $profile_arr['details']['year'] = date("Y", strtotime($profile_arr["details"]["dob"]));
        $profile_arr['details']['month'] = date("m", strtotime($profile_arr["details"]["dob"]));
        $profile_arr['details']['day'] = date("d", strtotime($profile_arr["details"]["dob"]));

        $profile_details = $profile_arr['details'];
        //print_r($profile_details); die;
  $referal_count = $this->validation_model->getReferalCount($user_id);
        $country_id = $profile_details['country_id'];
        $state_id = $profile_details['state_id'];
        $countries = $this->country_state_model->viewCountry($country_id);
        $states = $this->country_state_model->viewState($country_id, $state_id);
        $states = "<option value='0'>" . lang('no_state_selected') . "</option>" . $states;

        if ($country_id != '') {
            $mob_code = $this->country_state_model->getCountryTelephoneCode($country_id);
            $mobile_code = "+" . $mob_code;
        } else {
            $mobile_code = "";
        }

        $product_name = '';
        $product_validity = '';
        if ($product_status == 'yes') {
            $product_name = $profile_arr['product_name'];
            $product_validity = $profile_arr['product_validity'];
        }

        $payment_gateway = $this->profile_model->getActivePaymentGateway();
        $payment_method = $this->payout_model->gatewayList();
        
        

        $this->set('gateway_list', $payment_method);
        $this->set('payment_gateway', $payment_gateway);
        $this->set('bank_info_status', $bank_info_status);
        $this->set('age_limit', $age_limit);
        $this->set('u_name', $user_name);
        $this->set('profile_view_permission', $prof_view);
        $this->set('from_page', $from_page);
        $this->set('countries', $countries);
        $this->set('mobile_code', $mobile_code);
        $this->set('product_validity', $product_validity);
        $this->set('states', $states);
        $this->set('product_name', $this->security->xss_clean($product_name));
        $this->set('product_status', $product_status);
        $this->set('product_validity', $product_validity);
        $this->set('pin_status', $pin_status);
        $this->set('profile_details', $this->security->xss_clean($profile_details));
        $this->set('current_update_section', $current_update_section);
        $this->set('error_flag', $error_flag);
        $this->set('referal_count', $referal_count);

        $this->setView();
    }

    function user_account()
    {

        $title = lang('user_account');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'user-details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('user_account');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_account');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $mlm_plan = $this->MLM_PLAN;
        $posted = false;
        $is_valid_username = false;
        $user_name = '';

        if ($this->input->post('user_name') && $this->validate_user_account()) {
            $posted = true;
            $user_name = ($this->input->post('user_name', true));
            $this->session->set_userdata("is_valid_username", $user_name);
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'profile/user_account', false);
            }
        } else {
            $posted = true;
            $user_name = $this->validation_model->getAdminUsername();
            $this->session->set_userdata("is_valid_username", $user_name);
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'profile/user_account', false);
            }
        }

        $this->set('mlm_plan', $mlm_plan);
        $this->set('posted', $posted);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('user_name', $user_name);

        $this->setView();
    }

    function validate_user_account()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function val_user_name($user_name, $k)
    {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_id && $k)
            return true;
        else if (!$user_id && !$k)
            return true;
        else
            return false;
    }

    function get_states($country_id)
    {

        $state_string = $this->country_state_model->viewState($country_id);
        $state = '<select name="state" id="state" tabindex="4" class="form-control">';
        if ($state_string != '') {
            $state .= "<option value='0'>" . lang('select_state_menu') . "</option>" . $state_string;
        } else {
            $state .= "<option value='0'>" . lang('no_data_available') . "</option>";
        }
        $state .= "</select>";
        echo $state;
        exit();
    }

    function validate_username($ref_user = '')
    {
        if ($ref_user != '') {
            $flag = false;
            if ($this->profile_model->isUserNameAvailable($ref_user)) {
                $flag = true;
            }
            return $flag;
        } else {
            $echo = 'no';
            $username = ($this->input->post('username', true));

            if ($this->profile_model->isUserNameAvailable($username)) {
                $echo = "yes";
            }
            echo $echo;
            exit();
        }
    }

    function business_volume()
    {

        $title = lang('business_volume');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('business_volume');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('business_volume');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $from_page = 'link';
        $help_link = 'business-volume';
        $this->set('help_link', $help_link);
        $u_name = '';
        $user_id = $this->LOG_USER_ID;

        if ($this->input->post('from_page')) {
            $from_page = 'user_account';
            $this->session->set_userdata('inf_business_volume_from_page', $from_page);
        } else if ($this->session->userdata('inf_business_volume_from_page')) {
            $from_page = $this->session->userdata('inf_business_volume_from_page');
            $this->session->unset_userdata('inf_business_volume_from_page');
        }

        if ($this->input->post('user_name')) {
            $u_name = $this->input->post('user_name', true);
            $this->session->set_userdata('u_name', $u_name);
            $name_post_array = $this->input->post(null, true);
            $name_post_array = $this->validation_model->stripTagsPostArray($name_post_array);
            $user_id = $this->validation_model->userNameToID($name_post_array['user_name']);
            if (!$user_id) {
                $this->session->set_userdata('u_name', '');
                $msg = lang('invalid_user');
                $this->redirect($msg, 'profile/business_volume', false);
            }
        }
        // $u_name = $this->session->userdata('u_name');
        if ($this->session->userdata('u_name')) {
            $u_name = $this->session->userdata('u_name');
            $user_id = $this->validation_model->userNameToID($u_name);
        }
        $base_url = base_url() . 'admin/profile/business_volume';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;

        $config['total_rows'] = $this->profile_model->getTotalBusinessVolumeCount($user_id);

        $volume_details = $this->profile_model->getBusinessVolumeDetails($config['per_page'], $page, $user_id);
//print_r($volume_details);die;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $this->set('u_name', $u_name);
        $this->set('details', $volume_details);
        $this->set('result_per_page', $result_per_page);
        $this->set('page_id', $page);
        $this->set('user_id', $user_id);
        $this->set('from_page', $from_page);

        $this->setView();
    }

    public function ajax_is_username_available()
    {
        $user_name = $this->input->post('user_name', true);
        if (!$user_name) {
            echo 'no';
            exit();
        }
        $is_username_exists = $this->validation_model->isUsernameExists($user_name);
        if ($is_username_exists) {
            echo 'no';
            exit();
        } else {
            echo 'yes';
            exit();
        }
    }

    public function is_username_available($user_name)
    {
        if (!$user_name) {
            return false;
        }
        $is_username_exists = $this->validation_model->isUsernameExists($user_name);
        if ($is_username_exists) {
            return false;
        } else {
            return true;
        }
    }

    public function update_profile_image()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            if (DEMO_STATUS == 'yes') {
                $msg = $this->check_action_allowed();
                if ($msg) {
                    $response['error'] = true;
                    $response['message'] = $msg;
                    echo json_encode($response);
                    exit();
                }
            }
            if (!isset($_FILES['file'])) {
                $response['error'] = true;
                $response['message'] = lang('select_profile_image');
                echo json_encode($response);
                exit();
            }
            $this->confirmOtp();
            if (!empty($_FILES['file'])) {
                $upload_config = $this->validation_model->getUploadConfig();
                $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                if ($upload_count >= $upload_config) {
                    $msg = lang('you_have_reached_max_upload_limit');
                    $response['error'] = true;
                    $response['message'] = $msg;
                    echo json_encode($response);
                    exit();
                }
            }
            if ($_FILES['file']['error'] != 4) {
                $user_id = $this->validation_model->userNameToID($this->input->post('user_name'));
                if (!$user_id) {
                    $response['error'] = true;
                    $response['message'] = lang('invalid_user_name');
                    echo json_encode($response);
                    exit();
                }
                $random_number = floor($user_id * rand(1000, 9999));
                $config['file_name'] = "pro_" . $random_number;
                $config['upload_path'] = IMG_DIR . 'profile_picture/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2048';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $msg = $this->upload->display_errors();
                    $response['error'] = true;
                    $response['message'] = $msg;
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = '../uploads/images/profile_picture/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }
                    $res = $this->profile_model->changeProfilePicture($user_id, $new_file_name);
                    $this->validation_model->updateUploadCount($user_id);
                    if ($res) {
                        //insert configuration_change_history
                        $settings = $this->configuration_model->getSettings();
                        if ($settings['profile_updation_history']) {
                            $history = "Updated " . $this->input->post('user_name') . "'s " . "Profile Picture to :" . $new_file_name;
                            $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                            $history = "";
                        }
                        //
                        $msg = lang('profile_image_upload_success');
                        $response['success'] = true;
                        $response['message'] = $msg;
                        $response['file_name'] = $new_file_name;
                    } else {
                        $msg = lang('profile_image_upload_error');
                        $response['error'] = true;
                        $response['message'] = $msg;
                    }
                }
                echo json_encode($response);
                exit();
            }
        }
    }

    public function update_personal_info()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $this->confirmOtp();
            $user_id = $this->validation_model->userNameToID($this->input->post('profile_user'));
            if (!$user_id) {
                $response['error'] = true;
                $response['message'] = lang('invalid_user_name');
                echo json_encode($response);
                exit();
            }
            if ($this->validate_personal_info()) {
                $opencart_status = $this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes";
                $res = $this->profile_model->updatePersonalInfo($user_id, $post_arr, $opencart_status);
                if ($res) {
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated " . $post_arr['profile_user'] . "'s " . "Personal info as First Name :" . $post_arr['first_name'] . ", ";
                        $history .= "Last Name :" . $post_arr['last_name'] . ", ";
                        $history .= "Gender :" . $post_arr['gender'] . ", ";
                        $history .= "D.O.B :" . $post_arr['dob'];

                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                        $history = "";
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('personal_info_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('personal_info_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_personal_info()
    {
        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|min_length[3]|max_length[32]|callback__alpha_space');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|min_length[3]|max_length[32]|callback__alpha_space');
        $this->form_validation->set_rules('gender', lang('gender'), 'trim|required|in_list[M,F]', ['in_list' => lang('You_must_select_gender')]);
        $this->form_validation->set_rules('year', lang('year'), 'trim|required');
        $this->form_validation->set_rules('month', lang('month'), 'trim|required');
        $this->form_validation->set_rules('day', lang('day'), 'trim|required');

        // age validation based on year, month and day
        // $this->form_validation->set_rules('dob', lang('date_of_birth'), 'callback_validate_age');

        // age validation based on year
        $this->form_validation->set_rules('dob', lang('date_of_birth'), 'callback_validate_age_year');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }

    public function update_contact_info()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $this->confirmOtp();
            $user_id = $this->validation_model->userNameToID($this->input->post('profile_user'));
            if (!$user_id) {
                $response['error'] = true;
                $response['message'] = lang('invalid_user_name');
                echo json_encode($response);
                exit();
            }
            if ($this->validate_contact_info()) {
                $opencart_status = $this->MODULE_STATUS['opencart_status'] == "yes" && $this->MODULE_STATUS['opencart_status_demo'] == "yes";
                $res = $this->profile_model->updateContactInfo($user_id, $post_arr, $opencart_status);
                if ($post_arr['country'] != '0') {
                    $countries = $this->country_state_model->getCountries($post_arr['country']);
                }
                if ($post_arr['state'] != '0') {
                    $states = $this->country_state_model->getStates($post_arr['country'], $post_arr['state']);
                }
                if ($res) {
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated " . $post_arr['profile_user'] . "'s " . " Contact Info as Address Line 1:" . $post_arr['address'] . ", ";
                        $history .= "Address Line 2 :" . $post_arr['address2'] . ", ";
                        if ($post_arr['country'] == '0') {
                            $history .= "Country : " . ", ";
                        } else {
                            $history .= "Country :" . $countries['0']['country_name'] . ", ";
                        }
                        if ($post_arr['state'] == '0') {
                            $history .= "State : " . ", ";
                        } else {
                            $history .= "State :" . $states['0']['state_name'] . ", ";
                        }
                        $history .= "City :" . $post_arr['city'] . ", ";
                        $history .= "Mobile :" . $post_arr['mobile'] . ", ";
                        $history .= "LandLine :" . $post_arr['land_line'] . ", ";
                        $history .= "Email :" . $post_arr['email'] . ", ";
                        $history .= "Pincode :" . $post_arr['pincode'];

                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                        $history = "";
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('contact_info_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('contact_info_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_contact_info()
    {
        $this->form_validation->set_rules('address', lang('adress_line1'), 'trim|required|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('address2', lang('adress_line2'), 'trim|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('pincode', lang('zip_code'), 'trim|min_length[3]|max_length[10]|is_natural');
        $this->form_validation->set_rules('country', lang('country'), 'trim|required');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|min_length[3]|max_length[32]|callback__alpha_city_address');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', lang('mobile_no'), 'trim|required|is_natural|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('land_line', lang('mobile_no'), 'trim|is_natural|min_length[5]|max_length[10]');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }

    public function update_bank_info()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            // print_r($post_arr); die;
            $this->confirmOtp();
            $user_id = $this->validation_model->userNameToID($this->input->post('profile_user'));
            if (!$user_id) {
                $response['error'] = true;
                $response['message'] = lang('invalid_user_name');
                echo json_encode($response);
                exit();
            }
            if ($this->validate_bank_info()) {
                
                $res = $this->profile_model->updateBankInfo($user_id, $post_arr);
                if ($res) {
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated " . $post_arr['profile_user'] . "'s " . " Bank Info as Account no. :" . $post_arr['account_no'] . ", ";
                        $history .= "IFSC :" . $post_arr['ifsc'] . ", ";
                        $history .= "Bank Name :" . $post_arr['bank_name'] . ", ";
                        $history .= "Account Holder :" . $post_arr['account_holder'] . ", ";
                        $history .= "Branch Name :" . $post_arr['branch_name'] . ", ";
                        $history .= "PAN :" . $post_arr['pan'];

                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                        $history = "";
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('bank_info_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('bank_info_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_bank_info()
    {
        $this->form_validation->set_rules('bank_name', lang('bank_name'), 'trim|min_length[3]|max_length[32]|callback__alpha_space');
        $this->form_validation->set_rules('branch_name', lang('bank_branch'), 'trim|min_length[3]|max_length[32]|callback__alpha_space');
        $this->form_validation->set_rules('account_holder', lang('acct_holder_name'), 'trim|min_length[3]|max_length[32]|callback__alpha_space');
        $this->form_validation->set_rules('account_no', lang('account_no'), 'trim|min_length[3]|max_length[32]|alpha_numeric');
        $this->form_validation->set_rules('ifsc', lang('ifsc'), 'trim|min_length[3]|max_length[32]|alpha_numeric');
        $this->form_validation->set_rules('pan', lang('pan_no'), 'trim|min_length[3]|max_length[32]|alpha_numeric');

        $validation_status = $this->form_validation->run();
        
        return $validation_status;
    }

    public function update_social_info()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $this->confirmOtp();
            $user_id = $this->validation_model->userNameToID($this->input->post('profile_user'));
            if (!$user_id) {
                $response['error'] = true;
                $response['message'] = lang('invalid_user_name');
                echo json_encode($response);
                exit();
            }
            if ($this->validate_social_profile()) {
                $res = $this->profile_model->updateSocialProfile($user_id, $post_arr);
                if ($res) {
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated " . $post_arr['profile_user'] . "'s " . "Social Info as Facebook :" . $post_arr['facebook'] . ", ";
                        $history .= "Twitter :" . $post_arr['twitter'];

                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                        $history = "";
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('social_profile_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('social_profile_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_social_profile()
    {
        $this->form_validation->set_rules('facebook', lang('facebook'), 'trim|valid_url');
        $this->form_validation->set_rules('twitter', lang('twitter'), 'trim|valid_url');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }

    public function _alpha_space($str = '')
    {
        if (!$str) {
            return true;
        }
        $res = (bool)preg_match('/^[A-Z ]*$/i', $str);
        if (!$res) {
            $this->form_validation->set_message('_alpha_space', lang('only_alpha_space'));
        }
        return $res;
    }

    function _alpha_city_address($str_in = '')
    {
        if (!preg_match("/^([a-zA-Z0-9\s\.\,\-])*$/i", $str_in)) {
            $this->form_validation->set_message('_alpha_city_address', lang('city_field_characters'));
            return false;
        } else {
            return true;
        }
    }

    public function validate_age($dob)
    {
        if (!$this->input->post('year') || $this->input->post('month') < 0 || !$this->input->post('day')) {
            return true;
        }
        $age_limit = $this->configuration_model->getAgeLimitSetting();
        if ($age_limit == 0) {
            return true;
        }
        $date1 = new DateTime($dob);
        $date1->add(new DateInterval("P{$age_limit}Y"));
        $date2 = new DateTime();
        if ($date1 <= $date2) {
            return true;
        } else {
            $this->form_validation->set_message('validate_age', sprintf(lang('You_should_be_atleast_n_years_old'), $age_limit));
            return false;
        }
    }

    public function validate_age_year($dob)
    {
        if (!$this->input->post('year') || $this->input->post('month') < 0 || !$this->input->post('day')) {
            return true;
        }
        $age_limit = $this->configuration_model->getAgeLimitSetting();
        if ($age_limit == 0) {
            return true;
        }
        $year = date('Y', strtotime($dob));
        $current_year = date('Y');
        if (($current_year - $year) >= $age_limit) {
            return true;
        } else {
            $this->form_validation->set_message('validate_age_year', sprintf(lang('You_should_be_atleast_n_years_old'), $age_limit));
            return false;
        }
    }

    /*Ajax Function For Payment Details Updation Begins*/
    public function update_payment_details()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $this->confirmOtp();
            $user_id = $this->validation_model->userNameToID($this->input->post('profile_user'));
            $user_name = $this->input->post('profile_user', true);
            if (!$user_id) {
                $response['error'] = true;
                $response['message'] = lang('invalid_user_name');
                echo json_encode($response);
                exit();
            }
            if ($this->validate_payment_details()) {
                // print_r($post_arr['profile_user']);die;
                $res = $this->profile_model->updatePaymentDetails($user_id, $post_arr);
                if ($res) {
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated " . $post_arr['profile_user'] . "'s Payment details as";
                        if (isset($post_arr['paypal_account'])) {
                            if ($post_arr['paypal_account'] == '') {
                                $history .= " Paypal Account: NA,";
                            } else {
                                $history .= " Paypal Account: " . $post_arr['paypal_account'] . ",";
                            }
                        }
                        if (isset($post_arr['blockchain_account'])) {
                            if ($post_arr['blockchain_account'] == '') {
                                $history .= " Blockchain Address: NA,";
                            } else {
                                $history .= " Blockchain Address: " . $post_arr['blockchain_account'] . ", ";
                            }
                        }
                        if (isset($post_arr['bitgo_account'])) {
                            if ($post_arr['bitgo_account'] == '') {
                                $history .= " BitGo Address: NA,";
                            } else {
                                $history .= " BitGo Address: " . $post_arr['bitgo_account'] . ",";
                            }
                        }
                        if (isset($post_arr['blocktrail_account'])) {
                            if ($post_arr['blocktrail_account'] == '') {
                                $history .= " Blocktrail Address: NA";
                            } else {
                                $history .= " Blocktrail Address: " . $post_arr['blocktrail_account'];
                            }
                        }

                        $history = rtrim($history, ", ");
                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                        $history = "";
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('payment_details_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('payment_details_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_payment_details()
    {
        $this->form_validation->set_rules('paypal_account', lang('paypal_account'), 'trim|valid_email');
        $this->form_validation->set_rules('blockchain_account', lang('blockchain_account'), 'trim|alpha_numeric');
        $this->form_validation->set_rules('bitgo_account', lang('bitgo_account'), 'trim|alpha_numeric');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }

    /*Ajax Function For Payment Details Updation Ends*/

    public function update_default_language()
    {
        if ($this->MODULE_STATUS['lang_status'] == 'yes' && $this->input->is_ajax_request()) {
            $this->load->model('multi_language_model');
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $this->confirmOtp();
            $user_id = $this->validation_model->userNameToID($this->input->post('profile_user'));
            $user_name = $this->input->post('profile_user', true);
            if (!$user_id) {
                $response['error'] = true;
                $response['message'] = lang('invalid_user_name');
                echo json_encode($response);
                exit();
            }
            if ($this->validate_language_details()) {
                $res = $this->multi_language_model->setUserDefaultLanguage($post_arr['language'], $user_id);
                if ($res) {
                    $language_name = $this->inf_model->getLanguageName($post_arr['language']);
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated " . $post_arr['profile_user'] . "'s preferred language as {$language_name}";
                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('language_details_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('language_details_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_language_details()
    {
        $this->form_validation->set_rules('language', lang('language'), 'trim|required');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }
    public function checkAdmin()
    {
        $post_user = $this->input->post('user_name');
        if ($post_user && $post_user == $this->validation_model->getAdminUsername()) {
            echo "yes";
            exit;
        }
        echo "no";
        exit;
    }
    public function profileOtpModal()
    {
        $status = false;
        $otp = rand(pow(10, 4), pow(10, 5) - 1);
        if ($otp) {
            if (!empty($this->session->userdata('profile_otp')))
                $this->session->unset_userdata('profile_otp');
            $type = lang('profile_update');
            $this->mail_model->sendOtpMail($otp, $this->validation_model->getUserEmailId($this->validation_model->getAdminId()), $type);
            $this->session->set_userdata('profile_otp', $otp);
            echo $status = true;
            exit;
        } else {
            echo $status;
            exit;
        }
    }
    public function confirmOtp()
    {
        $otp_flag = $this->getOtpStat(true);
        if (!$otp_flag)
            return true;
        $admin_flag = false;
        if ($this->input->post('profile_user') == $this->validation_model->getAdminUsername()) {
            $admin_flag = true;
        }
        if (!$admin_flag)
            return true;
        $otp = $this->input->post('otp') ?? false;
        if ($otp) {
            if (!empty($this->session->userdata('profile_otp'))) {
                if ($otp == $this->session->userdata('profile_otp')) {
                    $this->session->unset_userdata('profile_otp');
                    return true;
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('invalid_otp');
                    echo json_encode($response);
                    exit();
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('otp_expired');
                echo json_encode($response);
                exit();
            }
        } else {
            $response['error'] = true;
            $response['message'] = lang('otp_required');
            echo json_encode($response);
            exit();
        }
    }

    public function users_forget_request()
    {

        $title = lang('forget_request');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('forget_request');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('forget_request');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $help_link = 'forget-me-request';
        $this->set('help_link', $help_link);
        $this->url_permission('gdpr');
        $this->load->model('activate_model');

        $base_url = base_url() . 'admin/profile/users_forget_request';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;

        $config['total_rows'] = $this->profile_model->checkForgetRequest();
        $requests = $this->profile_model->getForgetRequests($config['per_page'], $page);

        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        if (isset($_POST['forget'])) {
            $id = $this->input->post('id');
            $user_id = $this->input->post('user_id');
            $result = $this->profile_model->approveForgetRequest($id, $user_id);
            if ($result) {
                $this->activate_model->inactivateAccount($user_id, 'admin');
                $msg = lang('forget_request_approved_success');
                $this->redirect($msg, 'profile/users_forget_request', true);
            } else {
                $msg = lang('forget_request_approved_failed');
                $this->redirect($msg, 'profile/users_forget_request', false);
            }
        }

        if (isset($_POST['reject'])) {
            $user_id = $this->input->post('user_id');
            $result  = $this->profile_model->rejectForgetRequest($user_id);
            if ($result) {
                $msg = lang('forget_request_rejected');
                $this->redirect($msg, 'profile/users_forget_request', TRUE);
            } else {
                $msg = lang('forget_request_reject_failed');
                $this->redirect($msg, 'profile/users_forget_request', FALSE);
            }
        }

        $this->set('page_id', $page);
        $this->set('requests', $requests);
        $this->set('result_per_page', $result_per_page);
        $this->setView();
    }

    //KYC Approval starts
    public function kyc()
    {

        $title = lang('kyc');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('kyc');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('kyc');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->load->model('configuration_model');
        $this->url_permission('kyc_status');

        $type = '';
        $uname = '';
        $u_id = '';
        $status = 'pending';
        $show_table = 'no';

        if ($this->input->post('view_kyc')) {
            $type = $this->input->post('type');
            $status = $this->input->post('status');
            $uname = $this->input->post('user_name');
            $u_id = $this->validation_model->userNameToID($uname);
            if ($uname && !$u_id) {
                $msg = lang('invalid_user');
                $this->redirect($msg, "profile/kyc", false);
            }
            $show_table = 'yes';
        } else {
            $status = 'pending';
            $show_table = 'yes';
        }

        $kyc_list = $this->profile_model->getPendingKyc($u_id, $type, $status);
        $kyc_catg = $this->configuration_model->getKycDocCategory();

        $this->set("type", $type);
        $this->set("show_table", $show_table);
        $this->set("uname", $uname);
        $this->set("status", $status);
        $this->set("kyc_catg", $kyc_catg);
        $this->set("kyc_list", $kyc_list);
        $this->setView();
    }

    public function ajaxVerify()
    {
        $user_name = $this->input->post('user_name');
        $type = $this->input->post('type');
        $u_id = $this->validation_model->userNameToID($user_name);
        if ($user_name) {
            $status = $this->profile_model->verifyKyc($u_id, $type);
            if ($status) {
                echo 'yes';
                exit();
            }
        }
        echo 'no';
        exit();
    }

    public function ajaxReject()
    {
        $user_name = $this->input->post('user_name');
        $type = $this->input->post('type');
        $reason = $this->input->post('reason');
        $u_id = $this->validation_model->userNameToID($user_name);
        if ($u_id != '' && $reason != '') {
            $status = $this->profile_model->rejectKyc($u_id, $type, $this->security->xss_clean($reason));
            if ($status) {
                echo 'yes';
                exit();
            }
        }
        echo 'no';
        exit();
    }
    //KYC Approval ends

    public function edit_profile()
    {
        $this->HEADER_LANG['page_top_header'] = lang('edit_profile');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('edit_profile');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $help_link = 'profile-management';
        $this->set('help_link', $help_link);

        $user_id = $this->LOG_USER_ID;
        $u_name = $this->LOG_USER_NAME;

        $title = lang('s_profile');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $u_name . $title);
        $this->setView();
    }

    public function update_profileimg_banner()
    {
        $res1 = 0;
        $res2 = 0;
        $user_id = $this->session->userdata('inf_user_id');
        if (DEMO_STATUS == 'yes') {
            $msg = $this->check_action_allowed();
            if ($msg) {
                $this->redirect($msg, "profile/profile_view", false);
            }
        }
        if ($_FILES['file1']['error'] == 4 && $_FILES['file2']['error'] == 4) {
            $msg = lang('select_a_file');
            $this->redirect($msg, "profile/profile_view", false);
        }
        if (isset($_FILES['file1']) && $_FILES['file1']['error'] != 4) {
            if (!empty($_FILES['file1'])) {
                $upload_config = $this->validation_model->getUploadConfig();
                $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                if ($upload_count >= $upload_config) {
                    $msg = lang('you_have_reached_max_upload_limit');
                    $this->redirect($msg, "profile/profile_view", false);
                }
            }
            if ($_FILES['file1']['error'] != 4) {
                if (!$user_id) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, "profile/profile_view", false);
                }
                $random_number = floor($user_id * rand(1000, 9999));
                $config['file_name'] = "pro_" . $random_number;
                $config['upload_path'] = IMG_DIR . 'profile_picture/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2048';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file1')) {
                    $msg = $this->upload->display_errors();
                    $this->redirect($msg, "profile/profile_view", false);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];
                    if ($image['file_name']) {
                        $data['photo'] = '../uploads/images/profile_picture/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }
                    $res1 = $this->profile_model->changeProfilePicture($user_id, $new_file_name);
                    $this->validation_model->updateUploadCount($user_id);
                    if ($res1) {
                        //insert configuration_change_history
                        $settings = $this->configuration_model->getSettings();
                        if ($settings['profile_updation_history']) {
                            $history = "Updated Profile Picture to :" . $new_file_name;
                            $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                            $history = "";
                        }
                    }
                }
            }
        }
        $config = array();
        if (isset($_FILES['file2']) && $_FILES['file2']['error'] != 4) {
            if (!empty($_FILES['file2'])) {
                $upload_config = $this->validation_model->getUploadConfig();
                $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                if ($upload_count >= $upload_config) {
                    $msg = lang('you_have_reached_max_upload_limit');
                    $this->redirect($msg, "profile/profile_view", false);
                }
            }
            if ($_FILES['file2']['error'] != 4) {
                if (!$user_id) {
                    $msg = lang('invalid_user_name');
                    $this->redirect($msg, "profile/profile_view", false);
                }
                $random_number = floor($user_id * rand(1000, 9999));
                $config2['file_name'] = "pro_" . $random_number;
                $config2['upload_path'] = IMG_DIR . 'banners/';
                $config2['allowed_types'] = 'gif|jpg|png|jpeg';
                $config2['max_size'] = '2048';
                $config2['remove_spaces'] = true;
                $config2['overwrite'] = false;
                $this->load->library('upload', $config2);
                $this->upload->initialize($config2, true);
                if (!$this->upload->do_upload('file2')) {
                    $msg = $this->upload->display_errors();
                    $this->redirect($msg, "profile/profile_view", false);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];
                    if ($image['file_name']) {
                        $data2['photo'] = '../uploads/images/banners/' . $image['file_name'];
                        $data2['raw'] = $image['raw_name'];
                        $data2['ext'] = $image['file_ext'];
                    }
                    $res2 = $this->profile_model->changeBannerImage($user_id, $new_file_name);
                    $this->validation_model->updateUploadCount($user_id);
                    if ($res2) {
                        //insert configuration_change_history
                        $settings = $this->configuration_model->getSettings();
                        if ($settings['profile_updation_history']) {
                            $history = "Updated Profile Banner to :" . $new_file_name;
                            $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                            $history = "";
                        }
                    }
                }
            }
        }
        if ($res1 && $res2) {
            $msg = lang('profile_images_update_success');
            $this->redirect($msg, "profile/profile_view", true);
        } else if ($res1) {
            $msg = lang('profile_image_upload_success');
            $this->redirect($msg, "profile/profile_view", true);
        } else if ($res2) {
            $msg = lang('profile_banner_upload_success');
            $this->redirect($msg, "profile/profile_view", true);
        } else {
            $msg = lang('profile_images_update_failed');
            $this->redirect($msg, "profile/profile_view", false);
        }
    }
    public function getOtpStat($flag = false)
    {
        if ($flag) {
            return ($this->validation_model->getModuleStatusByKey('otp_modal') == "yes") ? true : false;
        } else {
            echo $this->validation_model->getModuleStatusByKey('otp_modal');
            exit();
        }
    }
    public function getEditImages()
    {
        $data = [];
        $user_id = $this->session->userdata('inf_user_id') ?? false;
        if ($user_id) {
            echo  json_encode($this->profile_model->getBannerPic($user_id));
            exit;
        } else {
            echo json_encode($data);
            exit;
        }
    }
    public function reset_google_authentication()
    {
        $title = lang('Reset 2-factor authentication');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'Reset 2-factor authentication';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('Reset 2-factor authentication');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('Reset 2-factor authentication');
        $this->HEADER_LANG['page_small_header'] = '';

        if ($this->input->post('reset_button') && $this->validate_reset_google_authentication()) {
            $user_name = $this->input->post('user_name');
            $user_id = $this->validation_model->userNameToID($user_name);
            $result = $this->validation_model->resetGoogleAuthentication($user_id);
            if ($result) {
            $msg = lang('Reset Successfully');
            $this->redirect($msg, "profile/reset_google_authentication", true);
               } else {
            $msg = lang('Eroor on Reset');
            $this->redirect($msg, "profile/reset_google_authentication", false);
    }
            }


        $this->load_langauge_scripts();
        $this->setView();
    }
    public function validate_reset_google_authentication()
    {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    //reward code bgins here --sahla
    function rank_rewards(){
        
        $title = lang('rank_rewards');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('rank_rewards');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('rank_rewards');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $from_page = 'link';
        $help_link = 'rank';
        $this->set('help_link', $help_link);
        $u_name = '';
        $user_id = $this->LOG_USER_ID;
        
        if ($this->input->post('from_page')) {
            $from_page = 'user_account';
            $this->session->set_userdata('inf_rank_from_page', $from_page);
        } else if ($this->session->userdata('inf_rank_from_page')) {
            $from_page = $this->session->userdata('inf_rank_from_page');
            $this->session->unset_userdata('inf_rank_from_page');
        }
        
        if ($this->input->post('user_name')) {
            $u_name = $this->input->post('user_name', true);
            $this->session->set_userdata('u_name', $u_name);
            $name_post_array = $this->input->post(null, true);
            $name_post_array = $this->validation_model->stripTagsPostArray($name_post_array);
            $user_id = $this->validation_model->userNameToID($name_post_array['user_name']);
            if (!$user_id) {
                $this->session->set_userdata('u_name', '');
                $msg = lang('invalid_user');
                $this->redirect($msg, 'profile/rank_rewards', false);
            }
        }
        
        $u_name = $this->session->userdata('u_name');
        $base_url = base_url() . 'admin/profile/rank_rewards';
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4); 
        else
            $page = 0;
        
        $config['total_rows'] = $this->profile_model->getTotalRankCount($user_id);
        //print_r($config); die;
        $reward_details = $this->profile_model->getRankDetails($config['per_page'], $page, $user_id);
        
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        
        $this->set('u_name', $u_name);
        
        $this->set('result_per_page', $result_per_page);
        $this->set('details', $reward_details);
        $this->set('user_id', $user_id);
        $this->set('from_page', $from_page);
        $this->set('page_id', $page);

        $this->setView();
    }
    //user reward code ends  -- sahla
    
    public function update_wallet_info()
    {
        if ($this->input->is_ajax_request()) {
            $response = array();
            $response['error'] = false;
            $post_arr = $this->input->post(null, true);
            $user_id = $this->LOG_USER_ID;
            if ($this->validate_wallet_info()) {
                $res = $this->profile_model->updateWalletInfo($user_id, $post_arr);
                if ($res) {
                    //insert configuration_change_history
                    $settings = $this->configuration_model->getSettings();
                    if ($settings['profile_updation_history']) {
                        $history = "Updated Wallet Info as Bitcoin Address. :" . $post_arr['bitcoin_address'] . ", ";
                        
                        $history .= "Payeer Address :" . $post_arr['payeer_address'];

                        $this->configuration_model->insertConfigChangeHistory('profile updation', $history);
                        $history = "";
                    }
                    //
                    $response['success'] = true;
                    $response['message'] = lang('wallet_info_update_success');
                } else {
                    $response['error'] = true;
                    $response['message'] = lang('wallet_info_update_error');
                }
            } else {
                $response['error'] = true;
                $response['message'] = lang('errors_check');
                foreach ($post_arr as $key => $value) {
                    $response['form_error'][$key] = form_error($key);
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    public function validate_wallet_info()
    {
        $this->form_validation->set_rules('bitcoin_address', lang('bitcoin_address'), 'trim|alpha_numeric');
        $this->form_validation->set_rules('payeer_address', lang('payeer_address'), 'trim|alpha_numeric');

        $validation_status = $this->form_validation->run();
        return $validation_status;
    }
}
