<?php

Class Lcp_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function InsertCrmLead($capture_details) {
        $res1 = $res2 = FALSE;
        $data = array(
            'first_name' => $capture_details['first_name'],
            'last_name' => $capture_details['last_name'],
            'email_id' => $capture_details['email'],
            'skype_id' => $capture_details['skype_id'],
            'mobile_no' => $capture_details['phone'],
            'country' => $capture_details['country'],
            'description' => $capture_details['comment'],
            'interest_status' => 'Interested',
            'lead_status' => 'Ongoing',
            'added_by' => $capture_details['user_id'],
            'date' => date('Y-m-d H:i:s')
            );
        $res1 = $this->db->insert('crm_leads', $data);

        $crm_id = $this->db->insert_id();
        $lead_unique_number = "LEAD" . str_pad($crm_id, 6, '0', STR_PAD_LEFT);

        $this->db->set('lead_id', $lead_unique_number);
        $this->db->where('id', $crm_id);
        $res2 =$this->db->update('crm_leads');

        if($res1 && $res2)
            return TRUE;
        else
            return FALSE;
    }

}
