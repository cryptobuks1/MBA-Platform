<?php

Class misc_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function getRandStr($minlength, $maxlength, $useupper = true, $usespecial = false, $usenumbers = true) {
        $charset = "";
        $key = "";

        $pin_config = $this->getPinConfig();
        $pin_length = $pin_config["pin_length"];
        $character_set = $pin_config["pin_character_set"];
        if ($character_set == "alphabet") {
            if ($useupper)
                $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        }
        else if ($character_set == "numeral") {
            $charset = "0123456789";
        } else {
            if ($useupper)
                $charset .= "ABCDEFGHIJKLMNPQRSTUVWXYZ";
            $charset .= "23456789";
        }
        if ($usespecial)
            $charset .= "~@#$%^*()_+-={}|]["; // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";

        $length = $pin_length;

        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];

        $randum_number = $key;
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . "pin_numbers";

        $dbprefix = $this->db->dbprefix;
        $this->db->set_dbprefix('');
        $this->db->where('pin_numbers', $randum_number);
        $result = $this->db->get($pin_numbers);
        $this->db->set_dbprefix($dbprefix);

        if (!$result->num_rows())
            return $key;
        else
            $this->getRandStr($minlength, $maxlength);
    }

    public function getPinConfig() {
        $config = array();
        $this->db->select('*');
        $query = $this->db->get('pin_config');
        foreach ($query->result_array() as $row) {
            $config["pin_amount"] = $row["pin_amount"];
            $config["pin_length"] = $row["pin_length"];
            $config["pin_maxcount"] = $row["pin_maxcount"];
            $config["pin_character_set"] = $row["pin_character_set"];
        }
        return $config;
    }

}
