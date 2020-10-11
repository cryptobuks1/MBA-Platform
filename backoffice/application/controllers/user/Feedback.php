<?php

require_once 'Inf_Controller.php';

class feedback extends Inf_Controller {

    function __construct() {
	parent::__construct();
    }

    function feedback_view($action = '', $delete_id = '') {

	$title = $this->lang->line('feedbacks');
	$this->set("title", $this->COMPANY_NAME . " | $title");

	$help_link = "";
	$this->set('help_link', $help_link);

	$this->HEADER_LANG['page_top_header'] = lang('feedback_view');
	$this->HEADER_LANG['page_top_small_header'] = '';
	$this->HEADER_LANG['page_header'] = lang('feedback_view');
	$this->HEADER_LANG['page_small_header'] = '';

	$this->load_langauge_scripts();

	$user_id = $this->LOG_USER_ID;
	$msg = "";
	
	if ($this->input->post('feedback_submit') && $this->validate_feedback_view()) {
            $feedback_post_array = $this->input->post(NULL, TRUE);
            $feedback_post_array = $this->validation_model->stripTagsPostArray($feedback_post_array);
            $feedback_post_array['comments'] = $this->validation_model->stripTagTextArea($this->input->post('comments'));
	    $feed_company = $feedback_post_array['company'];
	    $feed_phone = $feedback_post_array['phone_no'];
	    $feed_time = $feedback_post_array['time_to_call'];
	    $feed_email = $feedback_post_array['email'];
	    $feed_comment = $feedback_post_array['comments'];
	    $result2 = $this->feedback_model->addFeedback($user_id, $feed_company, $feed_phone, $feed_time, $feed_email, $feed_comment);
	    if ($result2) {
                $data_array = array();
                $data_array['feedback_array'] = $feedback_post_array;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'feedback added', $this->LOG_USER_ID,$data);
		$msg = lang('feed_back_added_successfully');
		$this->redirect($msg, "feedback/feedback_view", TRUE);
	    } else {
		$msg = lang('feed_back_failed');
		$this->redirect($msg, "feedback/feedback_view", FALSE);
	    }
	}
        
        $base_url = base_url() . "user/feedback/feedback_view";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->feedback_model->getAllfeedbackCount($user_id);
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        if($action == 'delete') {
            $page = 0;
        }
        else {
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        }
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);
        
	$feedback = $this->feedback_model->getAllfeedback($user_id, $config['per_page'], $page);
	$this->set("feedback", $this->security->xss_clean($feedback));
	$this->setView();
    }

    public function validate_feedback_view() {
	$this->form_validation->set_rules('company', lang('company'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('phone_no', lang('phone_no'), 'trim|required|is_natural|min_length[5]|max_length[10]');
	$this->form_validation->set_rules('time_to_call', lang('time_to_call'), 'trim|required|valid_time');
	$this->form_validation->set_rules('email', lang('email'), 'trim|required|strip_tags|valid_email');
	$this->form_validation->set_rules('comments', lang('comments'), 'trim|required');
	$validate_form = $this->form_validation->run();
	return $validate_form;
	}

	public function delete_feedback()
	{
		if ($this->input->post()) {
			$delete_id = $this->input->post('id', true);
			if (!$delete_id) {
				$this->redirect('', "feedback/feedback_view", false);
			}
			$result1 = $this->feedback_model->deleteFeedback($delete_id);
			if ($result1) {
				$data_array = array();
				$data_array['feedback_id'] = $delete_id;
				$data = serialize($data_array);
				$this->validation_model->insertUserActivity($this->LOG_USER_ID, 'feedback deleted', $this->LOG_USER_ID, $data);
				$msg = lang('feedback_deleted_successfully');
				$this->redirect($msg, "feedback/feedback_view", true);
			} else {
				$msg = lang('error_on_deleting_feedback');
				$this->redirect($msg, "feedback/feedback_view", false);
			}
		}
	}

}