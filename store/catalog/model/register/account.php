<?php

class ModelRegisterAccount extends Model {

    public $backoffice_url;
    public $backoffice_dir;
    public $backoffice_events_url;
    public $backoffice_events_dir;
    public $backoffice_profile_pic_url;
    public $backoffice_profile_pic_dir;

    function __construct($registry) {
	parent::__construct($registry);

	if (isset($_SERVER['HTTPS'])) {
	    $this->backoffice_url = HTTPS_SERVER . "backoffice/";
	} else {
	    $this->backoffice_url = HTTP_SERVER . "backoffice/";
	}
	$this->backoffice_dir = DIR_BACKOFFICE;
	$this->backoffice_events_dir = $this->backoffice_dir . "public_html/images/events/";
	$this->backoffice_events_url = $this->backoffice_url . "public_html/images/events/";
	$this->backoffice_profile_pic_dir = $this->backoffice_dir . "public_html/images/profile_picture/";
	$this->backoffice_profile_pic_url = $this->backoffice_url . "public_html/images/profile_picture/";
    }

    public function getUserIntroPhoto() {
	$photo_url = $this->backoffice_events_url . 'intro_foto.png';

	$query = $this->db->query("SELECT photo_video_name FROM " . DB_PREFIX . "events WHERE type = 'intro_foto'");
	if ($query->num_rows) {
	    $photo_dir = $this->backoffice_events_dir . $query->row['photo_video_name'];
	    if (file_exists($photo_dir)) {
		$photo_url = $this->backoffice_events_url . $query->row['photo_video_name'];
	    }
	}
	return $photo_url;
    }

    public function getUserIntroVideo() {
	$video_url = $this->backoffice_events_url . 'intro_video.mp4';

	$query = $this->db->query("SELECT photo_video_name FROM " . DB_PREFIX . "events WHERE type = 'intro_video'");
	if ($query->num_rows) {
	    $video_dir = $this->backoffice_events_dir . $query->row['photo_video_name'];
	    if (file_exists($video_dir)) {
		$video_url = $this->backoffice_events_url . $query->row['photo_video_name'];
	    }
	}
	return $video_url;
    }

    public function getBirthDaysOfMonth() {
	$birthdays = array();

	$query = $this->db->query("SELECT ft.user_name,ud.user_photo FROM " . DB_PREFIX . "ft_individual AS ft INNER JOIN  " . DB_PREFIX . "user_details AS ud ON ft.id=ud.user_detail_refid WHERE MONTH(user_detail_dob)= '" . date("m") . "'");
	if ($query->num_rows) {
	    foreach ($query->rows AS $users) {
		$photo = $this->backoffice_profile_pic_url . 'nophoto.jpg';
		$photo_dir = $this->backoffice_profile_pic_dir . $users['user_photo'];
		if (file_exists($photo_dir)) {
		    $photo = $this->backoffice_profile_pic_url . $users['user_photo'];
		}
		$birthdays[] = array("name" => $users['user_name'], "photo" => $photo);
	    }
	}

	return $birthdays;
    }

    public function getCustomerEmail($customer_id) {
	$email = '';
	$query = $this->db->query("SELECT email FROM  " . DB_PREFIX . "customer  WHERE customer_id = '" . (int) $customer_id . "'");
	if ($query->num_rows) {
	    $email = $query->row['email'];
	}
	return $email;
    }
    public function getCustomerFirstName($customer_id) {
	$email = '';
	$query = $this->db->query("SELECT firstname FROM  " . DB_PREFIX . "customer  WHERE customer_id = '" . (int) $customer_id . "'");
	if ($query->num_rows) {
	    $email = $query->row['firstname'];
	}
	return $email;
    }
    public function getCustomerLastName($customer_id) {
	$email = '';
	$query = $this->db->query("SELECT lastname FROM  " . DB_PREFIX . "customer  WHERE customer_id = '" . (int) $customer_id . "'");
	if ($query->num_rows) {
	    $email = $query->row['lastname'];
	}
	return $email;
    }

}
