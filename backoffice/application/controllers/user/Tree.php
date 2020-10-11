<?php

require_once 'Inf_Controller.php';

class Tree extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->redirect("", "genology_tree");
    }

    public function genology_tree($username = '')
    {

        $title = lang('tree_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "genealogy_tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('genealogy_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('genealogy_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($this->input->post('search_member_submit')) {
            $user_name = (strip_tags($this->input->post('user_name', true)));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/genology_tree', false);
            } else {
                $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'father');
                $logged_user_left_right = $this->tree_model->getUserLeftAndRight($this->LOG_USER_ID, 'father');
                if (($user_left_right['left_father'] < $logged_user_left_right['left_father']) || ($user_left_right['right_father'] > $logged_user_left_right['right_father'])) {
                    $msg = lang('you_could_only_search_downline_users');
                    $this->redirect($msg, 'tree/genology_tree', false);
                }
            }
        } elseif ($username != '') {
            $username = urldecode($username);
            $username = str_replace("_", "/", $username);
            $user_name = $this->encrypt->decode($username);

            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/genology_tree', false);
            } else {
                $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'father');
                $logged_user_left_right = $this->tree_model->getUserLeftAndRight($this->LOG_USER_ID, 'father');
                if (($user_left_right['left_father'] < $logged_user_left_right['left_father']) || ($user_left_right['right_father'] > $logged_user_left_right['right_father'])) {
                    $msg = lang('you_could_only_search_downline_users');
                    $this->redirect($msg, 'tree/genology_tree', false);
                }
            }
        }

        $this->set('user_name', $user_name);

        $this->setView();
    }

    function tree_view()
    {
        $post_array = $this->input->post(null, true);
        $post_array = $this->validation_model->stripTagsPostArray($post_array);

        $user_name = $post_array['user_name'];
        $user_id = $this->validation_model->userNameToID($user_name);

        if ($user_id) {
            $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'father');
            $logged_user_left_right = $this->tree_model->getUserLeftAndRight($this->LOG_USER_ID, 'father');
            if (($user_left_right['left_father'] < $logged_user_left_right['left_father']) || ($user_left_right['right_father'] > $logged_user_left_right['right_father'])) {
                $msg = lang('invalid_user_name');
                $MSG_ARR["MESSAGE"]["DETAIL"] = $msg;
                $MSG_ARR["MESSAGE"]["TYPE"] = false;
                $MSG_ARR["MESSAGE"]["STATUS"] = true;
                $this->session->set_flashdata('MSG_ARR', $MSG_ARR);
                echo ('invalid');
                exit;
            }
            //$this->tree_model->getAllTreeUsers($user_id);
            // $this->tree_model->getTreeView($user_id);
            $this->tree_model->renderTree($user_id, $this->MODULE_STATUS);
            $display_tree = $this->tree_model->display_tree;
            $tooltip_array = $this->tree_model->tree_tooltip_array;
            $tooltip_config = $this->validation_model->getTooltipConfig();

            $this->set('tooltip_config', $tooltip_config);
            $this->set('tooltip_array', $tooltip_array);
            $this->set('display_tree', $display_tree);
            $this->set('user_name', $user_name);
            $this->setView();
        } else {
            echo 'Invalid User Name...';
            die();
        }
    }

    public function sponsor_tree($username = "")
    {

        $title = lang('tree_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $this->url_permission('sponsor_tree_status');

        $help_link = "sponsor-tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('sponsor_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sponsor_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        if ($username != '') {
            $username = urldecode($username);
            $username = str_replace("_", "/", $username);
            $user_name = $this->encrypt->decode($username);

            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/sponsor_tree', false);
            }
        }

        $this->set('user_name', $user_name);

        $this->setView();
    }

    function tree_view_sponsor()
    {

        $post_array = $this->input->post(null, true);
        $post_array = $this->validation_model->stripTagsPostArray($post_array);

        $user_name = $post_array['user_name'];
        $user_id = $this->validation_model->userNameToID($user_name);

        if ($user_id) {
            //$this->tree_model->getAllTreeUsers($user_id, "sponsor_tree");
            // $this->tree_model->getTreeView($user_id, 'sponsor_tree');
            $this->tree_model->renderTree($user_id, $this->MODULE_STATUS, 'sponsor_tree');
            $display_tree = $this->tree_model->display_tree;
            $tooltip_array = $this->tree_model->tree_tooltip_array;
            $tooltip_config = $this->validation_model->getTooltipConfig();

            $this->set('tooltip_config', $tooltip_config);
            $this->set('tooltip_array', $tooltip_array);
            $this->set('display_tree', $display_tree);
            $this->set('user_name', $user_name);
            $this->setView();
        } else {
            echo 'Invalid User Name...';
            die();
        }
    }

    public function select_tree($user_id = "")
    {

        $title = $this->lang->line('tree_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "tabular-tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('tabular_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('tabular_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        $this->set('user_name', $user_name);

        $this->setView();
    }

    function select_tree_view($user_name = "")
    {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_id) {
            echo $this->tree_model->getChildren((int)$user_id);
            exit();
        }
        echo json_encode(array());
        exit();
    }

    function getEncrypt($string)
    {
        $id_encode = $this->encrypt->encode($string);
        $id_encode = str_replace("/", "_", $id_encode);
        return $encrypt_id = urlencode($id_encode);
    }

    public function board_view($board_id = '', $encrypted_id = "")
    {
        $title = $this->lang->line('board_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->load->model('configuration_model');
        $board_config = $this->configuration_model->getBoardSettings($board_id);

        $this->HEADER_LANG['page_top_header'] = $board_config[0]['board_name'];
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $board_config[0]['board_name'];
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = "Board View";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        $user_id = "";
        $id = urldecode($encrypted_id);
        $id_decode = str_replace("_", "/", $id);
        $id_decrypt = $this->encrypt->decode($id_decode);

        if ($this->validation_model->isUserAvailableinBoard($id_decrypt, $board_id)) {
            $user_id = $id_decrypt;
            $user_name = $this->validation_model->IdToUserName($user_id);
            if (isset($this->MODULE_STATUS['table_status']) && $this->MODULE_STATUS['table_status'] == "yes") {
                $this->load->model('configuration_model');
                $board_config = $this->configuration_model->getBoardSettings($board_id);
                $user_board_details = $this->tree_model->getUserBoard($user_id, $board_id);
                $tooltip_array = $this->tree_model->board_tooltip_array;

                $this->set("board_config", $board_config[0]);
                $this->set("user_board_details", $user_board_details);
                $this->set("tooltip_array", $tooltip_array);
            } else {
                $this->load->model('boardview_model');
                $this->boardview_model->getAllBoardUsers($user_id, $board_id);
                $display_tree = $this->boardview_model->display_tree;
                $tooltip_array = $this->boardview_model->tree_tooltip_array;

                $this->set('tooltip_array', $tooltip_array);
                $this->set('display_tree', $display_tree);
                $this->set('user_name', $user_name);
            }
        } else {
            $msg = $this->lang->line('invalid_user');
            $this->redirect("$msg", "boardview/board_view_management/$board_id", false);
        }

        $tooltip_config = $this->validation_model->getTooltipConfig();

        $this->set('tooltip_config', $tooltip_config);
        $this->set('user_name', $user_name);
        $this->set("board_id", $board_id);
        $this->set("board_config", $board_config[0]);
        $this->set("board_name", $board_config[0]['board_name']);

        $this->setView();
    }

    function get_downline_users($user_name = "")
    {
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $downlines = array();
        $down_lines = array();
        $next_lines = array();
        array_push($next_lines, $this->LOG_USER_ID);
        $downlines = $this->tree_model->getDownlines($next_lines, $down_lines);
        $user_detail = "";
        foreach ($downlines as $dl) {
            if ($letters) {
                $start_with = $this->startsWith($dl['user_name'], $letters);
                if ($start_with) {
                    $user_detail .= $dl['id'] . "###" . $dl['user_name'] . "|";
                }
            } else {
                $user_detail .= $dl['id'] . "###" . $dl['user_name'] . "|";
            }
        }
        echo $user_detail;
    }

    public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    function step_view()
    {
        $title = $this->lang->line('step_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");


        $this->HEADER_LANG['page_top_header'] = $this->lang->line('step_view');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $this->lang->line('step_view');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $help_link = "Step View";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;

        $this->tree_model->getAllStepUsers($user_id);

        $user_step_details['tree_depth'] = count($this->tree_model->step_array) - 1;
        $user_step_details['tree_width'] = $this->tree_model->step_array['width'];
        unset($this->tree_model->step_array['width']);

        $user_step_details['users'] = $this->tree_model->step_array;
        $tooltip_array = $this->tree_model->step_tooltip_array;
        $tooltip_config = $this->validation_model->getTooltipConfig();

        $this->set('tooltip_config', $tooltip_config);
        $this->set("user_step_details", $user_step_details);
        $this->set("tooltip_array", $tooltip_array);
        $this->set('user_id', $user_id);

        $row_span = $user_step_details['tree_depth'];
        $row_span_array = array();

        foreach ($user_step_details['users'] as $step_id => $value) {
            $row_step_width = ($user_step_details['tree_depth'] - $step_id + 1) * count($value);
            $row_span = max($row_step_width, $user_step_details['tree_depth']);

            $row_span_array[$step_id] = $row_span;
        }

        $row_span = max($row_span_array);
        $this->set('row_span', $row_span);
        $this->set('row_span_array', $row_span_array);

        $this->setView();
    }

    public function binary_leg_settings()
    {

        $title = $this->lang->line('binary_leg_settings');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "tabular-tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('binary_leg_settings');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('binary_leg_settings');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $get_leg_type = $this->tree_model->get_leg_type($user_id);
        $get_leg_settings = $this->tree_model->get_bnary_leg_setng();

        if ($this->input->post('submit')) {
            $leg = $this->input->post('binary_leg', true);

            if ($leg != 'any' && $leg != 'left' && $leg != 'right' && $leg != 'weak_leg') {
                $msg = lang('please_select_a_leg');
                $this->redirect($msg, 'tree/binary_leg_settings', false);
            }
            $res = $this->tree_model->updateLeg($user_id, $leg);
            if (!$res) {
                $msg = lang('leg_value_updation_failed');
                $this->redirect($msg, 'tree/binary_leg_settings', false);
            } else {
                $msg = lang('leg_type_successfull');
                $this->redirect($msg, 'tree/binary_leg_settings', true);
            }
        }

        $this->set('get_leg_settings', $get_leg_settings);
        $this->set('get_leg_type', $get_leg_type);
        $this->set('user_name', $user_name);

        $this->setView();
    }
}
