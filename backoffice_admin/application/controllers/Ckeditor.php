<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ckeditor extends CI_Controller {

	public function ckupload()
	{
		if ($this->input->post('ckCsrfToken')) {
			$time = time();
			$config['upload_path'] = IMG_DIR . 'ckeditor/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '20000000';
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;
			$this->load->library('upload', $config);
			$file_name = NULL;
			$url = NULL;
			$status = 0;
			if ($this->upload->do_upload('upload')) {
				$message = '';
				$file_name = $this->upload->data('file_name');
				$url = dirname(base_url()) . '/uploads/images/ckeditor/' . $this->upload->data('file_name');
				$status = 1;
			}
			else {
				$message = $this->upload->display_errors();
				$message = str_replace(['<p>', '</p>'], '', $message);
			}
			$funcNum = $_GET['CKEditorFuncNum'] ?? 1;

			// echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
			if ($status) {
				echo json_encode([
					'fileName' => $file_name,
					'uploaded' => $status,
					'url' => $url,
				]);
			}
			else {
				echo json_encode([
					'error' => [
						'message' => $message
					]
				]);
			}
			exit();
		}
		
	}
}
