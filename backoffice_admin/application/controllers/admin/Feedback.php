<?php

require_once 'Inf_Controller.php';

class feedback extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function feedback_view($action = '', $delete_id = '') {
        $title = $this->lang->line('feedback_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "feedback";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('feedback_view');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('feedback_view');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $msg = "";

        $base_url = base_url() . "admin/feedback/feedback_view";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->feedback_model->getAllfeedbackCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        if ($action == 'delete') {
            $page = 0;
        } else {
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        }
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $feedback = $this->feedback_model->getAllfeedback('', $config['per_page'], $page);
        $this->set("feedback", $this->security->xss_clean($feedback));

        if ($this->feedback_model->getAllUnreadFeedbackCount() > 0) {
            $this->feedback_model->setFeedbackViewed();
            $this->set_header_notification_box();
        }

        $this->setView();
    }

    public function delete_feedback()
    {
        if ($this->input->post()) {
            $delete_id = $this->input->post('id', true);
            if (!$delete_id) {
                $this->redirect('', "feedback/feedback_view", false);
            }
            $result = $this->feedback_model->deleteFeedback($delete_id);
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'feedback deleted', $this->LOG_USER_ID, $data);

                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_feedback', 'Feedback Deleted');
                }
                //

                $msg = lang('feedback_deleted_successfully');
                $this->redirect($msg, "feedback/feedback_view", true);
            } else {
                $msg = lang('error_on_deleting_feedback');
                $this->redirect($msg, "feedback/feedback_view", false);
            }
        }
    }

}
