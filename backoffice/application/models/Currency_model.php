<?php

class currency_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function automaticCurrencyUpdate($default_currency) {
        return TRUE;
        //Using Google finance API
        $multy_currency_status = $this->getMultyCurrencyStatus();
        $result = false;
        if ($multy_currency_status == 'yes') {
            $currencies = $this->getAllCurrencyCodes($default_currency);
            foreach ($currencies as $cur){
                 $value = $this->calculateCurrency($default_currency,$cur,1);
                 $result = $this->updateCurrencyValues($cur, $value);
            }
        } else {
            $result = true;
        }

        return $result;
    }
    function calculateCurrency($fromCurrency, $toCurrency, $amount) {
    $amount = urlencode($amount);
    $fromCurrency = urlencode($fromCurrency);
    $toCurrency = urlencode($toCurrency);
    $rawdata = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$fromCurrency&to=$toCurrency");
      $data = explode('bld>', $rawdata);
      if(isset($data[1])){
      $data = explode($toCurrency, $data[1]);
      return round($data[0], 8);
      }
      return 0;
}

    public function getAllCurrencyCodes($default_currency = 'USD') {

        $currency = array();
        $this->db->select('code');
        $this->db->from('currency_details');
        $this->db->where('delete_status','yes');
        $this->db->where('default_id','!=',1);
        $query = $this->db->get();
        foreach ($query->result_array() AS $row) {
            $currency[] = $row['code'];
        }
        return $currency;
    }

    public function getCurrencyDetails($currency_status = '', $limit = '', $page = '') {
        $currency_details = array();
        $this->db->select('*');
        $this->db->from('currency_details');
        $this->db->where('delete_status', 'yes');
        if ($currency_status) {
            $this->db->where('status', $currency_status);
        }
        if ($limit) {
            $this->db->limit((int) $limit, (int) $page);
        }
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            if(!$row['symbol_right'] && !$row['symbol_left']){
                $row['symbol_left'] = substr($row['title'], 0,3);
            }
            $currency_details[] = $row;
        }
        return $currency_details;
    }
    
    public function getCurrencyCount($currency_status = '') {
        $this->db->where('delete_status', 'yes');
        if ($currency_status) {
            $this->db->where('status', $currency_status);
        }
        $count = $this->db->count_all_results('currency_details');

        return $count;
    }

    public function getCurrencyDetailsById($id) {
        $currency_details = array();
        $this->db->select('*');
        $this->db->from('currency_details');
        $this->db->where('id', $id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            if($row['symbol_right']==Null && $row['symbol_left']==Null){
                $row['symbol_left'] = substr($row['title'], 0,3);
            }
            if($row['value'] == 0){
                $row['value'] = 1;
            }
            $currency_details = $row;
        }
        return $currency_details;
    }

    public function updateCurrencyDetails($details) {
        $this->db->set('value', $details['currency_value']);
        $this->db->set('symbol_left', $details['symbol_left']);
        $this->db->set('symbol_right', $details['symbol_right']);
        $this->db->set('status', $details['status']);
        $this->db->where('id', $details['currency_id']);
        return $res = $this->db->update('currency_details');
    }

    public function insertCurrencyDetails($details) {
        $data = array(
            'title' => $details['currency_title'],
            'code' => $details['currency_code'],
            'value' => $details['currency_value'],
            'symbol_left' => $details['symbol_left'],
            'symbol_right' => $details['symbol_right'],
            'status' => $details['status'],
        );
        return $res = $this->db->insert('currency_details', $data);
    }

    public function setDefaultCurrency($id, $user_id) {
        $this->db->set('default_id', 0);
        $this->db->update('currency_details');

        $this->db->set('default_id', 1);
        $this->db->set('value', 1);
        $this->db->where('id', $id);
        $query = $this->db->update('currency_details');

        if ($query) {
            $this->updateProjectDefaultCurrency($id, $user_id);
        }
        return $query;
    }

    public function updateProjectDefaultCurrency($id, $user_id) {
        $this->updateUserCurrency($id, $user_id);

        $this->load->dbforge();
        $fields = array(
        'default_currency' => array(
                'type' => 'int(11)',
                'default' => $id
        ),
);
        $this->dbforge->modify_column('ft_individual', $fields);
    }

    public function updateUserCurrency($id, $user_id) {
        $this->db->set('default_currency', $id);
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        return $res;
    }

    public function changeConversionStatus($status) {
        $this->db->set('currency_conversion_status', $status);
        $result = $this->db->update('module_status');
    }

    public function getConversionStatus() {
        $conversion_status = '';
        $this->db->select('currency_conversion_status');
        $this->db->from('module_status');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $conversion_status = $row['currency_conversion_status'];
        }
        return $conversion_status;
    }

    public function getMultyCurrencyStatus() {
        $multy_currency_status = '';
        $this->db->select('multy_currency_status');
        $this->db->from('module_status');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $multy_currency_status = $row->multy_currency_status;
        }
        if ($multy_currency_status == 'yes') {
            return true;
        }
        return false;
    }

    public function getProjectDefaultCurrencyDetails() {
        $currency_details = array();

        $currency_status = $this->validation_model->getModuleStatusByKey('multy_currency_status');
        if ($currency_status == 'no') {
            $currency_details = array(
                'id' => '1',
                'title' => 'dollar',
                'code' => 'USD',
                'value' => '1',
                'symbol_left' => '$',
                'symbol_right' => '',
                'decimal' => '',
                'status' => 'enabled',
                'default_id' => '1',
                'delete_status' => 'yes',
                'last_modified' => '2015-03-04 09:41:28'
            );
            return $currency_details;
        }

        $this->db->select('*');
        $this->db->from('currency_details');
        $this->db->where('default_id', 1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $currency_details = $row;
        }
        return $currency_details;
    }

    public function getAllCurrency() {
        $currency_array = array();

        $currency_status = $this->validation_model->getModuleStatusByKey('multy_currency_status');
        if ($currency_status == 'no') {
            $currency_array[] = array(
                'id' => '1',
                'title' => 'dollar',
                'code' => 'USD',
                'value' => '1',
                'symbol_left' => '$',
                'symbol_right' => '',
                'decimal' => '',
                'status' => 'enabled',
                'default_id' => '1',
                'delete_status' => 'yes',
                'last_modified' => '2015-03-04 09:41:28'
            );
            return $currency_array;
        }

        $this->db->select('id,symbol_left,symbol_right,title');
        $this->db->from('currency_details');
        $this->db->where('status', 'enabled');
        $this->db->where('delete_status', 'yes');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result() as $row) {
            $currency_array[$i]['id'] = $row->id;
            $currency_array[$i]['title'] = $row->title;
            $currency_array[$i]['symbol_left'] = $row->symbol_left;
            $currency_array[$i]['symbol_right'] = $row->symbol_right;
            $i++;
        }

        return $currency_array;
    }

    public function updateCurrencyValues($currency, $value) {

        $value = (float) $value;
        $this->db->set("value", $value);
        $this->db->set("last_modified", date('Y-m-d H:i:s'));
        $this->db->where("code", $currency);
        return $this->db->update("currency_details");
    }

    public function deleteCurrency($delete_id) {
        $this->db->set('delete_status', 'no');
        $this->db->where('id', $delete_id);
        $result = $this->db->update('currency_details');
        return $result;
    }

    public function getPaypalSupportedCurrencies() {
        //Reference : https://developer.paypal.com/docs/integration/direct/rest_api_payment_country_currency_support/
        $currencies = array("AUD", "BRL", "CAD", "CZK", "DKK", "EUR", "HKD", "HUF", "ILS", "JPY", "MYR", "MXN", "TWD", "NZD", "NOK", "PHP", "PLN", "GBP", "RUB", "SGD", "SEK", "CHF", "THB", "TRY", "USD");
        return $currencies;
    }

    public function getCurrencyConversionRate($base_currency_code, $currency_code) {
        $conversion_rate = 1;
        $url = "https://www.xe.com/currencyconverter/convert/?Amount={$conversion_rate}&From={$base_currency_code}&To={$currency_code}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        
        $data = explode('uccResultAmount', $rawdata);
        @$data = explode('uccToCurrencyCode', $data[1]);
        $converted_currency = preg_replace('/[^0-9,.]/', '', $data[0]);
        return $converted_currency;
    }
            
    public function isUSDDefault(){
        $currency_status = $this->validation_model->getModuleStatusByKey('multy_currency_status');
        if ($currency_status == 'no') {
            return TRUE;
        }
        $query = $this->db
                ->select('default_id')
                ->where("id",1)
                ->get("currency_details");
        if($query->row()->default_id == 1){
            return true;
        }else{
            return false;
        }
    }

    public function currencyToBtc($currency, $amount) {
        $url = 'https://bitpay.com/api/rates/' . $currency;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $info = json_decode($result, true);
        $info['amount'] = $amount;
        $info['btc_amount'] = round($amount / $info['rate'], 8);
        return $info;
    }

    public function getUserDefaultCurrencyDetails($user_id = '') {
        $currency = NULL;
        $this->db->select('default_currency');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $currency_id = $row->default_currency;
            $currency = $this->getCurrencyDetailsById($currency_id);
        }
        return $currency;
    }
}
