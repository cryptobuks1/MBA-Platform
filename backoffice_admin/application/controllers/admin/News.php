<?php

require_once 'Inf_Controller.php';

class News extends Inf_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function add_news($action = '', $news_id = '')
    {
        $title = $this->lang->line('add_news_and_events');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "news-management";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('add_news_and_events');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_news_and_events');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set("edit_id", null);
        $this->set("news_id", null);
        $this->set("news_title", null);
        $this->set("news_desc", null);
        $this->set("news_date", null);
        if ($action == "edit") {
            $row = $this->news_model->editNews($news_id);
            $this->set("edit_id", $news_id);
            $this->set("news_id", $row['news_id']);
            $this->set("news_title", $row['news_title']);
            $this->set("news_desc", $row['news_desc']);
            $this->set("news_date", $row['news_date']);
        }
        $msg = "";
        
        if ($this->input->post('news_submit') && $this->validate_add_news()) {
            $news_title = (strip_tags($this->input->post('news_title', true)));
            //$news_desc = (strip_tags($this->input->post('news_desc', TRUE)));
            $news_desc = $this->input->post('news_desc', true);
            $result1 = $this->news_model->addNews($news_title, $news_desc);
            if ($result1) {
                $data_array['news_title'] = $news_title;
                $data_array['news_description'] = $news_desc;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news added', $this->LOG_USER_ID, $data);
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_news', 'News Added');
                }
                //

                $msg = $this->lang->line('news_added_successfully');
                $this->redirect($msg, "news/add_news", true);
            } else {
                $msg = $this->lang->line('error_on_adding_news');
                $this->redirect($msg, "news/add_news", false);
            }
        }
        if ($this->input->post('news_update') && $this->validate_add_news()) {
            $news_id1 = (strip_tags($this->input->post('news_id', true)));
            $news_title1 = (strip_tags($this->input->post('news_title', true)));
            $news_desc1 = $this->input->post('news_desc', true);
            $result2 = $this->news_model->updateNews($news_id1, $news_title1, $news_desc1);
            if ($result2) {
                $data_array['news_title'] = $news_title1;
                $data_array['news_description'] = $news_desc1;
                $data_array['news_id'] = $news_id1;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news updated', $this->LOG_USER_ID, $data);
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_news', 'News Updated');
                }
                //

                $msg = $this->lang->line('news_updated_successfully');
                $this->redirect($msg, "news/add_news", true);
            } else {
                $msg = $this->lang->line('error_on_updating_news');
                $this->redirect($msg, "news/add_news", false);
            }
        }

        $base_url = base_url() . "admin/news/add_news";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->news_model->getAllNewsCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        if ($action == 'delete' || $action == 'edit') {
            $page = 0;
        } else {
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        }
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $news_details = $this->news_model->getAllNews($config['per_page'], $page);
        $this->set("news_details", $this->security->xss_clean($news_details));
        $this->set("arr_count", count($news_details));
        $this->setView();
    }

    function validate_add_news()
    {
        $this->form_validation->set_rules('news_title', lang('news_title'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('news_desc', lang('news_desc'), 'trim|required|max_length[200]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function upload_materials($action = '', $delete_id = '')
    {
        $title = lang('Upload_Materials');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->url_permission('upload_status');

        $help_link = "upload-document";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('Upload_Materials');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('Upload_Materials');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $base_url = base_url() . "admin/news/upload_materials";
        $config = $this->pagination->customize_style();
        $config['base_url'] = $base_url;
        $config['per_page'] = $this->PAGINATION_PER_PAGE;
        $total_rows = $this->news_model->getAllDocumentsCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        if ($action == 'delete' || $action == 'edit') {
            $page = 0;
        } else {
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        }
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("page", $page);

        $file_details = $this->news_model->getAllDocuments($config['per_page'], $page);
        $this->set("file_details", $this->security->xss_clean($file_details));
        $this->set("arr_count", count($file_details));
        $this->setView();
    }

    public function validate_upload_materials()
    {
        $this->form_validation->set_rules('file_title', lang('File_Title'), 'trim|required|strip_tags|max_length[50]');
        $this->form_validation->set_rules('file_desc', lang('file_desc'), 'trim|required|strip_tags|max_length[200]');
        // NEXT_VERSION_ONLY
         $this->form_validation->set_rules('category', lang('category'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function delete_material()
    {
        if ($this->input->post()) {
            $delete_id = $this->input->post('id', TRUE);
            if (!$delete_id) {
                $this->redirect('', "news/upload_materials", false);
            }
            $result = $this->news_model->deleteDocument($delete_id);
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'upload material deleted', $this->LOG_USER_ID, $data);
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_material', 'Material Deleted');
                }
                //

                $msg = lang('Material_Deleted_Successfully');
                $this->redirect($msg, "news/upload_materials", true);
            } else {
                $msg = lang('Error_On_Deleting_Material');
                $this->redirect($msg, "news/upload_materials", false);
            }
        }
    }
    
    public function delete_news()
    {
        if ($this->input->post()) {
            $news_id = $this->input->post('id', true);
            if (!$news_id) {
                $this->redirect('', "news/add_news", false);
            }
            $result = $this->news_model->deleteNews($news_id);
            if ($result) {
                $data_array['news_id'] = $news_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news deleted', $this->LOG_USER_ID, $data);
            
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'delete_news', 'News Deleted');
                }
                //

                $msg = $this->lang->line('news_deleted_successfully');
                $this->redirect($msg, "news/add_news", true);
            } else {
                $msg = $this->lang->line('error_on_deleting_news');
                $this->redirect($msg, "news/add_news", false);
            }
        }
    }
    
    public function delete_faq()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id', true);
            if (!$id) {
                $this->redirect('', "news/add_faq", false);
            }
            $del_status = $this->news_model->deleteBackFAQ($id);
            if ($del_status) {
                $activity = 'delete faq';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->validation_model->insertEmployeeActivity("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->validation_model->insertUserActivity("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                $msg = lang('faq_deleted_successfully');
                $this->redirect($msg, "news/add_faq", true);
            } else {
                $msg = lang('unable_to_delete_faq');
                $this->redirect($msg, "news/add_faq", false);
            }
        }
    }

    public function add_new_news($action = '', $news_id = '')
    {
        $title = $this->lang->line('add_news');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "news-management";
        $this->set("help_link", $help_link);

        if ($action == "edit")
            $this->HEADER_LANG['page_top_header'] = lang('update_news');
        else
            $this->HEADER_LANG['page_top_header'] = lang('add_news');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_news');
        $this->HEADER_LANG['page_small_header'] = '';

        if ($this->input->post('news_submit') && $this->validate_add_news()) {
            $news_title = (strip_tags($this->input->post('news_title', true)));
            //$news_desc = (strip_tags($this->input->post('news_desc', TRUE)));
            $news_desc = $this->input->post('news_desc', true);
            $result1 = $this->news_model->addNews($news_title, $news_desc);
            if ($result1) {
                $data_array['news_title'] = $news_title;
                $data_array['news_description'] = $news_desc;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news added', $this->LOG_USER_ID, $data);
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'add_news', 'News Added');
                }
                //

                $msg = $this->lang->line('news_added_successfully');
                $this->redirect($msg, "news/add_news", true);
            } else {
                $msg = $this->lang->line('error_on_adding_news');
                $this->redirect($msg, "news/add_news", false);
            }
        }
        $this->set("edit_id", null);
        $this->set("news_id", null);
        $this->set("news_title", null);
        $this->set("news_desc", null);
        $this->set("news_date", null);
        if ($action == "edit") {
            $row = $this->news_model->editNews($news_id);
            $this->set("edit_id", $news_id);
            $this->set("news_id", $row['news_id']);
            $this->set("news_title", $row['news_title']);
            $this->set("news_desc", $row['news_desc']);
            $this->set("news_date", $row['news_date']);
        }
        if ($this->input->post('news_update') && $this->validate_add_news()) {
            $news_id1 = (strip_tags($this->input->post('news_id', true)));
            $news_title1 = (strip_tags($this->input->post('news_title', true)));
            $news_desc1 = $this->input->post('news_desc', true);
            $result2 = $this->news_model->updateNews($news_id1, $news_title1, $news_desc1);
            if ($result2) {
                $data_array['news_title'] = $news_title1;
                $data_array['news_description'] = $news_desc1;
                $data_array['news_id'] = $news_id1;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news updated', $this->LOG_USER_ID, $data);
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'update_news', 'News Updated');
                }
                //

                $msg = $this->lang->line('news_updated_successfully');
                $this->redirect($msg, "news/add_news", true);
            } else {
                $msg = $this->lang->line('error_on_updating_news');
                $this->redirect($msg, "news/add_news", false);
            }
        }
        $this->set("action", $action);
        $this->load_langauge_scripts();
        $this->setView();
    }
    public function upload_new_material()
    {
        $title = lang('add_new_material');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "upload-document";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('add_new_material');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_new_material');
        $this->HEADER_LANG['page_small_header'] = '';

        $file_type = $this->validation_model->getUploadCategory();
        
        if ($this->input->post('upload_submit') && $this->validate_upload_materials()) {
            if (!empty($_FILES['upload_doc'])) {
                $upload_config = $this->validation_model->getUploadConfig();
                $upload_count = $this->validation_model->getUploadCount($this->LOG_USER_ID);
                if ($upload_count >= $upload_config) {
                    $msg = lang('you_have_reached_max_upload_limit');
                    $this->redirect($msg, "news/upload_new_material", false);
                }
            }
            $file_title = $this->input->post('file_title', true);
            $file_desc = $this->input->post('file_desc', true);
            $file_cat = $this->input->post('category', true);
            $random_number = floor($this->LOG_USER_ID * rand(1000, 9999));
            $config['file_name'] = "doc_" . $random_number;
            $config['upload_path'] = IMG_DIR . '/document/';
            // THIS_VERSION_ONLY
            //  $config['allowed_types'] = 'pdf|ppt|docx|xls|xlsx|doc|ods|odt';
           // $config['allowed_types'] = 'pdf|ppt|docx|xls|xlsx|doc|ods|odt|png|jpeg|jpg|gif|mp4|mov|avi|flv|mpg|wmv|3gp|rm';
            // NEXT_VERSION_ONLY
            if ($file_cat == 1) {
                $config['allowed_types'] = 'pdf|ppt|docx|xls|xlsx|doc|ods|odt';
            } elseif ($file_cat == 2) {
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
            } elseif ($file_cat == 3) {
                $config['allowed_types'] = 'mp4|mov|avi|flv|mpg|wmv|3gp|rm';
            }
            $config['max_size'] = '2048';
            $config['max_width'] = '3000';
            $config['max_height'] = '3000';
            $this->load->library('upload', $config);
            $result = '';
            if ($this->upload->do_upload('upload_doc')) {
                $data = array('upload_data' => $this->upload->data());
                $doc_file_name = $data['upload_data']['file_name'];
           //     $cat_id = $this->validation_model->getUploadCategory($file_cat);
                $result = $this->news_model->addDocuments($file_title, $file_desc, $doc_file_name, $file_cat);
                $this->validation_model->updateUploadCount($this->LOG_USER_ID);
            }
            if ($result) {
                $data_array['file_title'] = $file_title;
                $data_array['file_name'] = $doc_file_name;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'material uploaded', $this->LOG_USER_ID, $data);
                
                // Employee Activity History
                if ($this->LOG_USER_TYPE == 'employee') {
                    $this->validation_model->insertEmployeeActivity($this->LOG_USER_ID, $this->LOG_USER_ID, 'upload_material', 'Material Uploaded');
                }
                //

                $msg = lang('material_uploaded_successfully');
                $this->redirect($msg, "news/upload_materials", true);
            } else {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'You did not select a file to upload.') {
                    $msg = lang('please_select_file');
                    $this->redirect($msg, "news/upload_new_material", false);
                } else if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_2MB');
                    $this->redirect($msg, "news/upload_new_material", false);
                } else if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('filetype_not_allowed');
                    $this->redirect($msg, "news/upload_new_material", false);
                } else if ($error['error'] == 'Invalid file name.') {
                    $msg = lang('invalid_file_name');
                    $this->redirect($msg, "news/upload_materials", false);
                } else {
                    $msg = lang('error_uploading_file');
                }
                $this->redirect($msg, "news/upload_materials", false);
            }
        }
        $this->load_langauge_scripts();

        $this->set('file_type', $file_type);
        $this->setView();
    }
    function add_faq($action = '', $id = '')
    {

        $title = lang('faq');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('create_faq');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('faq');
        $this->HEADER_LANG['page_small_header'] = '';


        $this->load_langauge_scripts();

        if ($this->input->post('new_faq') && $this->validate_add_faq()) {
            $post = $this->input->post(null, true);
            $post = $this->validation_model->stripTagsPostArray($post);
            $question = $this->input->post('question', true);
            $answer = $this->validation_model->textAreaLineBreaker($post['answer']);
            $sort_order = $this->input->post('sort_order', true);

            if ($question && $answer && $sort_order) {
                $ins_status = $this->news_model->insertBackFAQ($question, $answer, $sort_order);
                if ($ins_status) {
                    $activity = 'Creating faq';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->validation_model->insertEmployeeActivity("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->validation_model->insertUserActivity("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = lang('faq_created_successfully');
                    $this->redirect($msg, "news/add_faq", true);
                } else {
                    $msg = lang('unable_to_create_faq');
                    $this->redirect($msg, "news/add_faq", false);
                }
            } else {
                $msg = lang('insufficient_content');
                $this->redirect($msg, "news/add_faq", false);
            }
        }
        
        $faq = $this->news_model->getBackFAQDetails();
        $this->set("faq", $faq);
        $this->setView();
    }
    
    function validate_add_faq()
    {
        $this->form_validation->set_rules('sort_order', lang('sort_order'), 'trim|required|numeric|max_length[5]|greater_than[0]|callback_is_sortorder_available');
        $this->form_validation->set_rules('question', lang('question'), 'trim|required|max_length[200]');
        $this->form_validation->set_rules('answer', lang('answer'), 'trim|required|max_length[1000]');
        $this->form_validation->set_message('is_sortorder_available', $this->lang->line('sort_order_not_available'));
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    
    public function is_sortorder_available($order) {
        if ($order == '') {
            return FALSE; 
        }
        $count = $this->news_model->isSortOrderAvailable($order);
         if ($count > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function ajax_is_sortorder_available() {
        $sort_order = $this->input->post('sort_order', TRUE);
        if (!$sort_order) {
            echo 'no';
            exit();
        }
        $is_sort_order_exists = $this->news_model->isSortOrderAvailable($sort_order);
        
        if ($is_sort_order_exists) {
            echo 'no';
            exit();
        } else {
            echo 'yes';
            exit();
        }
    }
}
