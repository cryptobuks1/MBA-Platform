<?php

require_once 'Inf_Controller.php';

class Document extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
    }

////////////Code added By Sreelakshmi////////////////////
    function download_document()
    {
        $title = lang('download_document');
        $this->set('action_page', $this->CURRENT_URL);
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('upload_status');

        $this->load_langauge_scripts();
        $this->HEADER_LANG['page_top_header'] = lang('download_document');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('download_document');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $base_url = base_url() . "user/document/download_document";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->document_model->getAllDocumentsCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        if ($this->document_model->getUnreadDocumentsCount($this->LOG_USER_ID) > 0) {
            $this->document_model->setDocumentViewed($this->LOG_USER_ID);
            $this->set_header_notification_box();
        }

        $file_details = $this->document_model->getAllDocuments($config['per_page'], $page);
        $this->set("file_details", $this->security->xss_clean($file_details));
        $this->set("arr_count", count($file_details));
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
}
