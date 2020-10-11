<?php

class ModelRegisterUser extends Model {

    private $data = array();

    public function userNameToID($username) {
        $user_id = 0;
        $user_id_query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE user_name = '" . $username . "'");

        if ($user_id_query->num_rows) {
            $user_id = $user_id_query->row['id'];
        }

        return $user_id;
    }

    public function getUserNameFromCustomerID($customer_id) {
        $user_name = '';
        $user_id_query = $this->db->query("SELECT user_name FROM " . MLM_DB_PREFIX . "ft_individual WHERE oc_customer_ref_id = '" . $customer_id . "'");

        if ($user_id_query->num_rows) {
            $user_name = $user_id_query->row['user_name'];
        }

        return $user_name;
    }

    public function getSponsorFullName($sponsor) {
        $sponsor_id = $this->userNameToID($sponsor);
        $sponsor_name = '';
        $query = $this->db->query("SELECT user_detail_name,user_detail_second_name FROM `" . MLM_DB_PREFIX . "user_details` WHERE user_detail_refid = '" . $this->db->escape($sponsor_id) . "'");

        if ($query->num_rows) {
            $sponsor_name = $query->row['user_detail_name'] . " " . $query->row['user_detail_second_name'];
        }
        return $sponsor_name;
    }

    public function getAllPackages($package_id = '') {
        $where = '';
        if ($package_id != '') {
            $where = "WHERE product_id = '$package_id'";
        }
        $this->load->language('register/step5');
        $query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "packages $where");
        $products = array();
        $i = 0;
        foreach ($query->rows as $row) {
            $products[$i]['id'] = $row['product_id'];
            $products[$i]['name'] = $row['product_name'];
            $products[$i]['amount'] = $row['product_value'];
            $products[$i]['pair_value'] = $row['pair_value'];
            $products[$i]['description'] = $this->language->get('text_package_' . $row['product_id'] . '_description');
            $i++;
        }

        return $products;
    }

    public function getPackageName($product_id) {
        $data = array();
        $product_name = "";

        $query = $this->db->query("SELECT product_name,product_value FROM " . MLM_DB_PREFIX . "packages WHERE product_id = '" . $product_id . "'");
        foreach ($query->rows as $row) {
            $data['name'] = $row['product_name'];
            $data['value'] = $row['product_value'];
            $product_name = $data['name'] . "----" . $data['value'];
        }
        return $product_name;
    }

    public function getAutoshipProduct() {
        $data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE autoship_status='yes'");
        foreach ($query->rows as $row) {
            $data['product_id'] = $row['product_id'];
            $data['image'] = $row['image'];
            $data['name'] = $row['model'];
            $data['amount'] = round($row['price'], 2);
            $data['distributor_amount'] = round($row['distributor_price'], 2);
        }
        return $data;
    }

    public function getAutoshipProductDetails() {
        $cart_product = array();

        $product_id = $this->getAutoshipProductID();

        $product['product_id'] = (int) $product_id;
        $key = base64_encode(serialize($product));
        $cart_product['cart'][$key] = 1;

        foreach ($cart_product['cart'] as $key => $quantity) {
            $product = unserialize(base64_decode($key));

            $stock = true;

            // Options
            if (!empty($product['option'])) {
                $options = $product['option'];
            } else {
                $options = array();
            }

            // Profile
            if (!empty($product['recurring_id'])) {
                $recurring_id = $product['recurring_id'];
            } else {
                $recurring_id = 0;
            }

            $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int) $product_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

            if ($product_query->num_rows) {
                $option_price = 0;
                $option_points = 0;
                $option_weight = 0;

                $option_data = array();

                foreach ($options as $product_option_id => $value) {
                    $option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int) $product_option_id . "' AND po.product_id = '" . (int) $product_id . "' AND od.language_id = '" . (int) $this->config->get('config_language_id') . "'");

                    if ($option_query->num_rows) {
                        if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
                            $option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int) $value . "' AND pov.product_option_id = '" . (int) $product_option_id . "' AND ovd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

                            if ($option_value_query->num_rows) {
                                if ($option_value_query->row['price_prefix'] == '+') {
                                    $option_price += $option_value_query->row['price'];
                                } elseif ($option_value_query->row['price_prefix'] == '-') {
                                    $option_price -= $option_value_query->row['price'];
                                }

                                if ($option_value_query->row['points_prefix'] == '+') {
                                    $option_points += $option_value_query->row['points'];
                                } elseif ($option_value_query->row['points_prefix'] == '-') {
                                    $option_points -= $option_value_query->row['points'];
                                }

                                if ($option_value_query->row['weight_prefix'] == '+') {
                                    $option_weight += $option_value_query->row['weight'];
                                } elseif ($option_value_query->row['weight_prefix'] == '-') {
                                    $option_weight -= $option_value_query->row['weight'];
                                }

                                if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
                                    $stock = false;
                                }

                                $option_data[] = array(
                                    'product_option_id' => $product_option_id,
                                    'product_option_value_id' => $value,
                                    'option_id' => $option_query->row['option_id'],
                                    'option_value_id' => $option_value_query->row['option_value_id'],
                                    'name' => $option_query->row['name'],
                                    'value' => $option_value_query->row['name'],
                                    'type' => $option_query->row['type'],
                                    'quantity' => $option_value_query->row['quantity'],
                                    'subtract' => $option_value_query->row['subtract'],
                                    'price' => $option_value_query->row['price'],
                                    'price_prefix' => $option_value_query->row['price_prefix'],
                                    'points' => $option_value_query->row['points'],
                                    'points_prefix' => $option_value_query->row['points_prefix'],
                                    'weight' => $option_value_query->row['weight'],
                                    'weight_prefix' => $option_value_query->row['weight_prefix']
                                );
                            }
                        } elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
                            foreach ($value as $product_option_value_id) {
                                $option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int) $product_option_value_id . "' AND pov.product_option_id = '" . (int) $product_option_id . "' AND ovd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

                                if ($option_value_query->num_rows) {
                                    if ($option_value_query->row['price_prefix'] == '+') {
                                        $option_price += $option_value_query->row['price'];
                                    } elseif ($option_value_query->row['price_prefix'] == '-') {
                                        $option_price -= $option_value_query->row['price'];
                                    }

                                    if ($option_value_query->row['points_prefix'] == '+') {
                                        $option_points += $option_value_query->row['points'];
                                    } elseif ($option_value_query->row['points_prefix'] == '-') {
                                        $option_points -= $option_value_query->row['points'];
                                    }

                                    if ($option_value_query->row['weight_prefix'] == '+') {
                                        $option_weight += $option_value_query->row['weight'];
                                    } elseif ($option_value_query->row['weight_prefix'] == '-') {
                                        $option_weight -= $option_value_query->row['weight'];
                                    }

                                    if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
                                        $stock = false;
                                    }

                                    $option_data[] = array(
                                        'product_option_id' => $product_option_id,
                                        'product_option_value_id' => $product_option_value_id,
                                        'option_id' => $option_query->row['option_id'],
                                        'option_value_id' => $option_value_query->row['option_value_id'],
                                        'name' => $option_query->row['name'],
                                        'value' => $option_value_query->row['name'],
                                        'type' => $option_query->row['type'],
                                        'quantity' => $option_value_query->row['quantity'],
                                        'subtract' => $option_value_query->row['subtract'],
                                        'price' => $option_value_query->row['price'],
                                        'price_prefix' => $option_value_query->row['price_prefix'],
                                        'points' => $option_value_query->row['points'],
                                        'points_prefix' => $option_value_query->row['points_prefix'],
                                        'weight' => $option_value_query->row['weight'],
                                        'weight_prefix' => $option_value_query->row['weight_prefix']
                                    );
                                }
                            }
                        } elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
                            $option_data[] = array(
                                'product_option_id' => $product_option_id,
                                'product_option_value_id' => '',
                                'option_id' => $option_query->row['option_id'],
                                'option_value_id' => '',
                                'name' => $option_query->row['name'],
                                'value' => $value,
                                'type' => $option_query->row['type'],
                                'quantity' => '',
                                'subtract' => '',
                                'price' => '',
                                'price_prefix' => '',
                                'points' => '',
                                'points_prefix' => '',
                                'weight' => '',
                                'weight_prefix' => ''
                            );
                        }
                    }
                }

                $price = $product_query->row['price'];

                $distributor_price = $product_query->row['distributor_price'];

                if (isset($this->session->data['customer_id'])) {
                    $account_type = $this->cart->getCustomerAccountType($this->session->data['customer_id']);
                } else {
                    if (isset($this->session->data['reg_data']['account_type'])) {
                        $account_type = $this->session->data['reg_data']['account_type'];
                    }
                }
                if ($account_type != 'customer') {
                    $price = $distributor_price;
                }
                $price_excluding_tax = $price;

                // Product Discounts
                $discount_quantity = 0;

                foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
                    $product_2 = (array) unserialize(base64_decode($key_2));

                    if ($product_2['product_id'] == $product_id) {
                        $discount_quantity += $quantity_2;
                    }
                }

                $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int) $discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

                if ($product_discount_query->num_rows) {
                    $price = $product_discount_query->row['price'];
                }

                // Product Specials
                $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

                if ($product_special_query->num_rows) {
                    $price = $product_special_query->row['price'];
                }

                // Reward Points
                $product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "'");

                if ($product_reward_query->num_rows) {
                    $reward = $product_reward_query->row['points'];
                } else {
                    $reward = 0;
                }

                // Downloads
                $download_data = array();

                $download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int) $product_id . "' AND dd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

                foreach ($download_query->rows as $download) {
                    $download_data[] = array(
                        'download_id' => $download['download_id'],
                        'name' => $download['name'],
                        'filename' => $download['filename'],
                        'mask' => $download['mask']
                    );
                }

                // Stock
                if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
                    $stock = false;
                }

                $recurring_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "product_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`product_id` = " . (int) $product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`recurring_id` = `p`.`recurring_id` AND `pd`.`language_id` = " . (int) $this->config->get('config_language_id') . " WHERE `pp`.`recurring_id` = " . (int) $recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int) $this->config->get('config_customer_group_id'));

                if ($recurring_query->num_rows) {
                    $recurring = array(
                        'recurring_id' => $recurring_id,
                        'name' => $recurring_query->row['name'],
                        'frequency' => $recurring_query->row['frequency'],
                        'price' => $recurring_query->row['price'],
                        'cycle' => $recurring_query->row['cycle'],
                        'duration' => $recurring_query->row['duration'],
                        'trial' => $recurring_query->row['trial_status'],
                        'trial_frequency' => $recurring_query->row['trial_frequency'],
                        'trial_price' => $recurring_query->row['trial_price'],
                        'trial_cycle' => $recurring_query->row['trial_cycle'],
                        'trial_duration' => $recurring_query->row['trial_duration']
                    );
                } else {
                    $recurring = false;
                }

                $this->data[$key] = array(
                    'key' => $key,
                    'product_id' => $product_query->row['product_id'],
                    'name' => $product_query->row['name'],
                    'model' => $product_query->row['model'],
                    'shipping' => $product_query->row['shipping'],
                    'image' => $product_query->row['image'],
                    'option' => $option_data,
                    'download' => $download_data,
                    'quantity' => $quantity,
                    'minimum' => $product_query->row['minimum'],
                    'subtract' => $product_query->row['subtract'],
                    'stock' => $stock,
                    'price' => ($price + $option_price),
                    'price_excluding_tax' => $price_excluding_tax,
                    'distributor_price' => $distributor_price,
                    'product_pv' => $product_query->row['product_pv'], //new field
                    'customer_pv' => $product_query->row['customer_pv'], //new field
                    'product_type' => $product_query->row['product_type'], //new field
                    'autoship_status' => $product_query->row['autoship_status'], //new field
                    'total' => ($price + $option_price) * $quantity,
                    'reward' => $reward * $quantity,
                    'points' => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
                    'tax_class_id' => $product_query->row['tax_class_id'],
                    'weight' => ($product_query->row['weight'] + $option_weight) * $quantity,
                    'weight_class_id' => $product_query->row['weight_class_id'],
                    'length' => $product_query->row['length'],
                    'width' => $product_query->row['width'],
                    'height' => $product_query->row['height'],
                    'length_class_id' => $product_query->row['length_class_id'],
                    'recurring' => $recurring
                );
            }
        }

        return $this->data;
    }

    public function getAutoshipProductID() {
        $product_id = 0;

        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE autoship_status='yes'");
        foreach ($query->rows as $row) {
            $product_id = $row['product_id'];
        }
        return $product_id;
    }

    public function addCustomer($data) {

        $this->event->trigger('pre.customer.add', $data);

        $customer_group_id = $this->config->get('config_customer_group_id');

        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);


        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int) $customer_group_id . "', store_id = '" . (int) $this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['cellphone']) . "', fax = '', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? serialize($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int) $data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int) !$customer_group_info['approval'] . "', date_added = NOW(),sponsor_name = '" . $this->db->escape($data['sponsor_id']) . "',account_type = '" . $this->db->escape($data['account_type']) . "',user_name = '" . $this->db->escape($data['username']) . "', product_id = '" . $this->db->escape($data['enrollment_order']) . "'");

        $customer_id = $this->db->getLastId();

        $this->session->data['reg_data'] ['customer_id'] = $customer_id;

        $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int) $customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '', address_1 = '" . $this->db->escape($data ['address']) . "', address_2 = '', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int) $data['country_id'] . "', zone_id = '" . (int) $data['zone_id'] . "', shipping_address = '" . $this->db->escape($data['ship_address']) . "',  shipping_city = '" . $this->db->escape($data['ship_city']) . "', shipping_postcode = '" . $this->db->escape($data['ship_postcode']) . "', shipping_country_id = '" . (int) $data ['ship_country_id'] . "', shipping_zone_id = '" . (int) $data['ship_zone_id'] . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? serialize($data['custom_field']['address']) : '') . "'");

        $address_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int) $address_id . "' WHERE customer_id = '" . (int) $customer_id . "'");

        $this->insertAllUserInfo($data, $customer_id, $address_id);

        $this->registerUserBackOffice($data, $customer_id, $address_id);

        $this->event->trigger('post.customer.add', $customer_id);

        return $customer_id;
    }

    public function insertAllUserInfo($data, $customer_id, $address_id) {

        $date_of_birth = $this->db->escape($data['year']) . "-" . $this->db->escape($data['month']) . "-" . $this->db->escape($data ['day']);
        $co1_date_of_birth = $this->db->escape($data['co1_year']) . "-" . $this->db->escape($data['co1_month']) . "-" . $this->db->escape($data['co1_day']);

        if (!$data['autoship_type']) {
            $data['cc_number'] = substr_replace($data['cc_number'], 'xxxxxxxxxxxx', 0, 12);
        }

        $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "user_info SET customer_ref_id = '" . (int) $customer_id . "', address_ref_id = '" . (int) $address_id . "',sponsor_id = '" . $this->db->escape($data ['sponsor_id']) . "' ,account_type = '" . $this->db->escape($data ['account_type']) . "' ,firstname = '" . $this->db->escape($data['firstname']) . "', middle_initial = '" . $this->db->escape($data ['middle_initial']) . "',lastname = '" . $this->db->escape($data['lastname']) . "',  gender = '" . $this->db->escape($data['gender']) . "', birthday='" . $date_of_birth . "', ssn = '" . $this->db->escape($data ['ssn']) . "', business_entity = '" . $this->db->escape($data['business_entity']) . "',federal_tax_id = '" . $this->db->escape($data['federal_tax_id']) . "',co1_title = '" . $this->db->escape($data['co1_title']) . "', co1_firstname = '" . $this->db->escape($data['co1_firstname']) . "',co1_middle_initial='" . $this->db->escape($data['co1_middle_initial']) . "', co1_lastname='" . $this->db->escape($data ['co1_lastname']) . "', co1_gender='" . $this->db->escape($data['co1_gender']) . "', co1_birthday='" . $co1_date_of_birth . "',co1_ssn='" . $this->db->escape($data ['co1_ssn']) . "',co2_title='" . $this->db->escape($data ['co2_title']) . "',co2_firstname='" . $this->db->escape($data['co2_firstname']) . "',     co2_middle_initial='" . $this->db->escape($data['co2_middle_initial']) . "',co2_lastname='" . $this->db->escape($data['co2_lastname']) . "',co2_ssn='" . $this->db->escape($data ['co2_ssn']) . "',co2_address='" . $this->db->escape($data ['co2_address']) . "',co2_city='" . $this->db->escape($data ['co2_city']) . "',co2_country_id='" . $this->db->escape($data ['co2_country_id']) . "',co2_zone_id='" . $this->db->escape($data ['co2_zone_id']) . "',co2_postcode='" . $this->db->escape($data ['co2_postcode']) . "',co3_title='" . $this->db->escape($data ['co3_title']) . "',co3_firstname='" . $this->db->escape($data['co3_firstname']) . "',co3_middle_initial='" . $this->db->escape($data['co3_middle_initial']) . "',co3_lastname='" . $this->db->escape($data['co3_lastname']) . "',co3_ssn='" . $this->db->escape($data['co3_ssn']) . "',co3_address='" . $this->db->escape($data['co3_address']) . "',co3_city='" . $this->db->escape($data['co3_city']) . "',co3_country_id='" . $this->db->escape($data['co3_country_id']) . "',co3_zone_id='" . $this->db->escape($data['co3_zone_id']) . "',co3_postcode='" . $this->db->escape($data ['co3_postcode']) . "',co4_title='" . $this->db->escape($data['co4_title']) . "',co4_firstname='" . $this->db->escape($data['co4_firstname']) . "',co4_middle_initial='" . $this->db->escape($data['co4_middle_initial']) . "',co4_lastname='" . $this->db->escape($data['co4_lastname']) . "',co4_ssn='" . $this->db->escape($data['co4_ssn']) . "',co4_address='" . $this->db->escape($data['co4_address']) . "',co4_city='" . $this->db->escape($data['co4_city']) . "',co4_country_id='" . $this->db->escape($data['co4_country_id']) . "',co4_zone_id='" . $this->db->escape($data['co4_zone_id']) . "',co4_postcode='" . $this->db->escape($data ['co4_postcode']) . "',co5_title='" . $this->db->escape($data['co5_title']) . "',co5_firstname='" . $this->db->escape($data['co5_firstname']) . "',co5_middle_initial='" . $this->db->escape($data['co5_middle_initial']) . "',co5_lastname='" . $this->db->escape($data['co5_lastname']) . "',co5_ssn='" . $this->db->escape($data['co5_ssn']) . "',co5_address='" . $this->db->escape($data['co5_address']) . "',co5_city='" . $this->db->escape($data['co5_city']) . "',co5_country_id='" . $this->db->escape($data['co5_country_id']) . "',co5_zone_id='" . $this->db->escape($data['co5_zone_id']) . "',co5_postcode='" . $this->db->escape($data ['co5_postcode']) . "',cellphone='" . $this->db->escape($data['cellphone']) . "',homephone='" . $this->db->escape($data ['homephone']) . "',agree_contact='" . $this->db->escape($data['agree_contact']) . "',email='" . $this->db->escape($data['email']) . "',agree_mail='" . $this->db->escape($data['agree_mail']) . "',website='" . $this->db->escape($data['website']) . "',username='" . $this->db->escape($data['username']) . "',password='" . $this->db->escape($data['password']) . "',confirm='" . $this->db->escape($data['confirm']) . "',by_clicking='" . $this->db->escape($data['by_clicking']) . "',address = '" . $this->db->escape($data['address']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . $data['country_id'] . "', zone_id = '" . $data ['zone_id'] . "', ship_address = '" . $this->db->escape($data ['ship_address']) . "',  ship_city = '" . $this->db->escape($data['ship_city']) . "', ship_postcode = '" . $this->db->escape($data ['ship_postcode']) . "', ship_country_id = '" . $data ['ship_country_id'] . "', ship_zone_id = '" . $data['ship_zone_id'] . "',agree_distributor_policy = '" . $this->db->escape($data['agree_distributor_policy']) . "',agree = '" . $this->db->escape($data['agree']) . "',enrollment_order = '" . $this->db->escape($data['enrollment_order']) . "',purchase_type = '" . $this->db->escape($data['purchase_type']) . "',purchase_quantity = '" . $data ['purchase_quantity'] . "',autoship_type = '" . $this->db->escape($data ['autoship_type']) . "',quantity = '" . $this->db->escape($data ['quantity']) . "',autoship_day = '" . $this->db->escape($data ['autoship_day']) . "',shipping = '" . $this->db->escape($data['shipping']) . "',order_confirmation_payment_method = '" . $this->db->escape($data['confirm_enrollment_order']) . "',confirm_autoship_order = '" . $this->db->escape($data['confirm_autoship_order']) . "',i_authorize = '" . $this->db->escape($data ['i_authorize']) . "',cc_type = '" . $this->db->escape($data['cc_type']) . "',cc_number = '" . $data ['cc_number'] . "',cc_firstname = '" . $this->db->escape($data['cc_firstname']) . "',cc_lastname = '" . $this->db->escape($data['cc_lastname']) . "',cc_expire_date_month = '" . $this->db->escape($data['cc_expire_date_month']) . "',cc_expire_date_year = '" . $this->db->escape($data['cc_expire_date_year']) . "',cc_cvv2 = '" . $this->db->escape($data['cc_cvv2']) . "',cc_issue = '" . $this->db->escape($data['cc_issue']) . "', date_added =  NOW()");
    }

    public function registerUserBackOffice($reg_data, $customer_id, $address_id) {

        $customer_details = $this->getCustomerDetails($reg_data, $customer_id, $address_id);

        if (!$this->request->server['HTTPS']) {
            $backoffice_url = HTTP_SERVER . "backoffice/";
        } else {
            $backoffice_url = HTTPS_SERVER . "backoffice/";
        }

        $url = $backoffice_url . 'login/opencart_user_register';

        $this->runMLMCURL($customer_id, $url, $customer_details, 'register');
    }

    public function runMLMCURL($customer_id, $url, $curl_data, $type = 'register') {

        $curl_data["from_store"] = true;
        $curl_data["inf_token"] = "f6f7369316c4928fdceaaed397356f5b";

        $curl_id = $this->insertCURLHistory($customer_id, $curl_data, $url, $type);

        $field_string = http_build_query($curl_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $field_string);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $curl_result = curl_exec($curl);
        curl_close($curl);

        $this->updateCURLHistory($customer_id, $curl_id, $curl_result);
    }

    public function insertCURLHistory($customer_id, $curl_data, $url, $curl_type = 'register') {
        $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "mlm_curl_history SET customer_id ='" . $customer_id . "', curl_url  = '" . $url . "', curl_type = '" . $curl_type . "',  curl_data  = '" . serialize($curl_data) . "', curl_date = NOW()");

        $curl_id = $this->db->getLastId();
        return $curl_id;
    }

    public function updateCURLHistory($customer_id, $curl_id, $curl_result) {
        $this->db->query("UPDATE " . MLM_DB_PREFIX . "mlm_curl_history SET curl_result ='" . serialize($curl_result) . "' , curl_date = NOW() WHERE customer_id ='" . $customer_id . "' AND curl_id = $curl_id");
    }

    public function getCustomerDetails($reg_data, $customer_id, $address_id) {

        $regr = array();

        $address_data = $this->getAddress($customer_id, $address_id);

        $this->load->model('account/customer');
        $customer_data = $this->model_account_customer->getCustomer($customer_id);
        $customer_info = $this->getCustomerInfo($customer_id);

        $regr['order_id'] = $reg_data['order_id'];
        $regr['user_name_type'] = 'static';
        $regr['user_name_entry'] = $customer_data['user_name'];
        $regr['address'] = $address_data['address_1'];
        $regr['post_office'] = $address_data['postcode'];
        $regr['town'] = $address_data['city'];
        $regr['state'] = $address_data['zone'];
        $regr['district'] = $address_data['city'];
        $regr['pin'] = $address_data['postcode'];
        $regr['shipping_address'] = $address_data['shipping_address'];
        $regr['shipping_city'] = $address_data['shipping_city'];
        $regr['shipping_postcode'] = $address_data['shipping_postcode'];
        $regr['pin'] = $address_data['postcode'];
        $regr['pin'] = $address_data['postcode'];
        $regr['land_line'] = $customer_data['telephone'];
        $regr['email'] = $customer_data['email'];
        $regr['date_of_birth'] = $customer_info['birthday'];
        $regr['nominee'] = '';
        $regr['relation'] = '';
        $regr['pan_no'] = '';
        $regr['bank_acc_no'] = '';
        $regr['ifsc'] = '';
        $regr['bank_name'] = '';
        $regr['bank_branch'] = '';
        $regr['joining_date'] = $customer_data['date_added'];
        $regr['year'] = '';
        $regr['month'] = '';
        $regr['day'] = '';
        $regr['mobile_code'] = '';
        $regr['active_tab'] = '';
        $regr['is_ewallet_ok'] = true;
        $regr['is_card_ok'] = true;
        $regr['is_pin'] = true;
        $regr['full_name'] = $customer_data['firstname'] . ' ' . $customer_data['lastname'];
        $regr['pswd'] = $customer_data['password'];
        $regr['cpswd'] = $customer_data['password'];
        $regr['gender'] = 'M';
        $regr['country'] = $address_data['country'];
        $regr['mobile'] = $customer_data['telephone'];
        $regr['by_using'] = 'cart';
        $regr['customer_id'] = $customer_id;
        $regr['reg_from'] = 'cart';
        $regr['referral_name'] = $customer_data['sponsor_name'];
        $regr['referral_id'] = $this->userNameToID($customer_data['sponsor_name']);
        $regr['father_id'] = $customer_data['sponsor_name'];
        $regr['prodcut_id'] = $customer_data['product_id'];
        $regr['account_type'] = $customer_data['account_type'];

        return $regr;
    }

    public function getCustomerInfo($customer_id) {
        $query = $this->db->query("SELECT * FROM " . MLM_DB_PREFIX . "user_info WHERE customer_ref_id = '" . (int) $customer_id . "'");

        if ($query->num_rows) {
            $data = array(
                'customer_ref_id' => $query->row['customer_ref_id'],
                'address_ref_id' => $query->row['address_ref_id'],
                'sponsor_id' => $query->row['sponsor_id'],
                'account_type' => $query->row['account_type'],
                'firstname' => $query->row['firstname'],
                'middle_initial' => $query->row['middle_initial'],
                'lastname' => $query->row['lastname'],
                'gender' => $query->row['gender'],
                'birthday' => $query->row['birthday'],
                'ssn' => $query->row['ssn'],
                'business_entity' => $query->row['business_entity'],
                'federal_tax_id' => $query->row['federal_tax_id'],
                'co1_title' => $query->row['co1_title'],
                'co1_firstname' => $query->row['co1_firstname'],
                'co1_middle_initial' => $query->row['co1_middle_initial'],
                'co1_lastname' => $query->row['co1_lastname'],
                'co1_gender' => $query->row['co1_gender'],
                'co1_birthday' => $query->row['co1_birthday'],
                'co1_ssn' => $query->row['co1_ssn'],
                'co2_title' => $query->row['co2_title'],
                'co2_firstname' => $query->row['co2_firstname'],
                'co2_middle_initial' => $query->row['co2_middle_initial'],
                'co2_lastname' => $query->row['co2_lastname'],
                'co2_ssn' => $query->row['co2_ssn'],
                'co2_address' => $query->row['co2_address'],
                'co2_city' => $query->row['co2_city'],
                'co2_country_id' => $query->row['co2_country_id'],
                'co2_zone_id' => $query->row['co2_zone_id'],
                'co2_postcode' => $query->row['co2_postcode'],
                'co3_title' => $query->row['co3_title'],
                'co3_firstname' => $query->row['co3_firstname'],
                'co3_middle_initial' => $query->row['co3_middle_initial'],
                'co3_lastname' => $query->row['co3_lastname'],
                'co3_ssn' => $query->row['co3_ssn'],
                'co3_address' => $query->row['co3_address'],
                'co3_city' => $query->row['co3_city'],
                'co3_country_id' => $query->row['co3_country_id'],
                'co3_zone_id' => $query->row['co3_zone_id'],
                'co3_postcode' => $query->row['co3_postcode'],
                'co4_title' => $query->row['co4_title'],
                'co4_firstname' => $query->row['co4_firstname'],
                'co4_middle_initial' => $query->row['co4_middle_initial'],
                'co4_lastname' => $query->row['co4_lastname'],
                'co4_ssn' => $query->row['co4_ssn'],
                'co4_address' => $query->row['co4_address'],
                'co4_city' => $query->row['co4_city'],
                'co4_country_id' => $query->row['co4_country_id'],
                'co4_zone_id' => $query->row['co4_zone_id'],
                'co4_postcode' => $query->row['co4_postcode'],
                'co5_title' => $query->row['co5_title'],
                'co5_firstname' => $query->row['co5_firstname'],
                'co5_middle_initial' => $query->row['co5_middle_initial'],
                'co5_lastname' => $query->row['co5_lastname'],
                'co5_ssn' => $query->row['co5_ssn'],
                'co5_address' => $query->row['co5_address'],
                'co5_city' => $query->row['co5_city'],
                'co5_country_id' => $query->row['co5_country_id'],
                'co5_zone_id' => $query->row['co5_zone_id'],
                'co5_postcode' => $query->row['co5_postcode'],
                'cellphone' => $query->row['cellphone'],
                'homephone' => $query->row['homephone'],
                'agree_contact' => $query->row['agree_contact'],
                'email' => $query->row['email'],
                'agree_mail' => $query->row['agree_mail'],
                'website' => $query->row['website'],
                'username' => $query->row['username'],
                'password' => $query->row['password'],
                'confirm' => $query->row['confirm'],
                'by_clicking' => $query->row['by_clicking'],
                'address' => $query->row['address'],
                'city' => $query->row['city'],
                'postcode' => $query->row['postcode'],
                'country_id' => $query->row['country_id'],
                'zone_id' => $query->row['zone_id'],
                'ship_address' => $query->row['ship_address'],
                'ship_city' => $query->row['ship_city'],
                'ship_postcode' => $query->row['ship_postcode'],
                'ship_country_id' => $query->row['ship_country_id'],
                'ship_zone_id' => $query->row['ship_zone_id'],
                'agree_distributor_policy' => $query->row['agree_distributor_policy'],
                'agree' => $query->row['agree'],
                'enrollment_order' => $query->row['enrollment_order'],
                'purchase_type' => $query->row['purchase_type'],
                'purchase_quantity' => $query->row['purchase_quantity'],
                'autoship_type' => $query->row['autoship_type'],
                'quantity' => $query->row['quantity'],
                'autoship_day' => $query->row['autoship_day'],
                'shipping' => $query->row['shipping'],
                'order_confirmation_payment_method' => $query->row['order_confirmation_payment_method'],
                'confirm_autoship_order' => $query->row['confirm_autoship_order'],
                'i_authorize' => $query->row['i_authorize'],
                'cc_type' => $query->row['cc_type'],
                'cc_number' => $query->row['cc_number'],
                'cc_firstname' => $query->row['cc_firstname'],
                'cc_lastname' => $query->row['cc_lastname'],
                'cc_expire_date_month' => $query->row['cc_expire_date_month'],
                'cc_expire_date_year' => $query->row['cc_expire_date_year'],
                'cc_cvv2' => $query->row['cc_cvv2'],
                'cc_issue' => $query->row['cc_issue'],
                'date_added' => $query->row['date_added']
            );

            return $data;
        } else {
            return false;
        }
    }

    public function getAddress($customer_id, $address_id) {
        $address_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int) $address_id . "' AND customer_id = '" . (int) $customer_id . "'");

        if ($address_query->num_rows) {
            $country_id = $address_query->row['country_id'];
            $country_details = $this->getCountryDetails($country_id);
            $zone_id = $address_query->row['zone_id'];
            $zone_details = $this->getZoneDetails($zone_id);

            $ship_country_id = $address_query->row['shipping_country_id'];
            $ship_country_details = $this->getCountryDetails($ship_country_id);
            $ship_zone_id = $address_query->row['shipping_zone_id'];
            $ship_zone_details = $this->getZoneDetails($ship_zone_id);

            $address_data = array(
                'address_id' => $address_query->row['address_id'],
                'firstname' => $address_query->row['firstname'],
                'lastname' => $address_query->row['lastname'],
                'company' => $address_query->row['company'],
                'address_1' => $address_query->row['address_1'],
                'address_2' => $address_query->row['address_2'],
                'postcode' => $address_query->row['postcode'],
                'city' => $address_query->row['city'],
                'zone_id' => $address_query->row['zone_id'],
                'zone' => $zone_details['zone'],
                'zone_code' => $zone_details['zone_code'],
                'country_id' => $address_query->row['country_id'],
                'country' => $country_details['country'],
                'iso_code_2' => $country_details['iso_code_2'],
                'iso_code_3' => $country_details['iso_code_3'],
                'address_format' => $country_details['address_format'],
                'shipping_address' => $address_query->row['shipping_address'],
                'shipping_city' => $address_query->row['shipping_city'],
                'shipping_postcode' => $address_query->row['shipping_postcode'],
                'shipping_country_id' => $address_query->row['shipping_country_id'],
                'shipping_zone_id' => $address_query->row['shipping_zone_id'],
                'custom_field' => unserialize($address_query->row['custom_field'])
            );

            return $address_data;
        } else {
            return false;
        }
    }

    public function getCountryDetails($country_id) {
        $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $country_id . "'");

        if ($country_query->num_rows) {
            $country = $country_query->row['name'];
            $iso_code_2 = $country_query->row['iso_code_2'];
            $iso_code_3 = $country_query->row['iso_code_3'];
            $address_format = $country_query->row['address_format'];
        } else {
            $country = '';
            $iso_code_2 = '';
            $iso_code_3 = '';
            $address_format = '';
        }

        $country_details = array('country' => $country, 'iso_code_2' => $iso_code_2, 'iso_code_3' => $iso_code_3, 'address_format' => $address_format);

        return $country_details;
    }

    public function getZoneDetails($zone_id) {
        $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $zone_id . "'");

        if ($zone_query->num_rows) {
            $zone = $zone_query->row['name'];
            $zone_code = $zone_query->row['code'];
        } else {
            $zone = '';
            $zone_code = '';
        }

        $zone_details = array('zone' => $zone, 'zone_code' => $zone_code);
        return $zone_details;
    }

    function ValidatePhone($phone) {
        $patterns = array(
            '\d{3}([-\. ])\d{3}\g{-1}\d{4}',
            '\(\d{3}\) \d{3}-\d{4}'
        );

        $phone = trim($phone);

        foreach ($patterns as $pattern) {
            if (preg_match('/^' . $pattern . '$/', $phone)) {
                return true;
            }
        }

        return false;
    }

    function validatefederal($federal) {
        $patterns = array(
            '\d{2}([-\. ])\d{7}'
        );

        $federal = trim($federal);

        foreach ($patterns as $pattern) {
            if (preg_match('/^' . $pattern . '$/', $federal)) {
                return true;
            }
        }

        return false;
    }

    public function validateUsername($date) {

        $status = false;
        if (preg_match("/^[a-zA-Z0-9_]{5,}+((\.(-\.)*-?|-(\.-)*\.?)[a-zA-Z0-9_]{5,}+)*$/", $date)) {
            $status = true;
        }
        return $status;
    }

    public function validatePassword($date) {
        $status = false;
        if (preg_match("/^[a-zA-Z0-9]{6,}+$/", $date)) {
            $status = true;
        }

        return $status;
    }

    public function validateDigit($date) {
        $status = false;
        if (preg_match("/^[1-9][0-9]{0,15}$/", $date)) {
            $status = true;
        }
        return $status;
    }

    public function getZoneCode($zone_id) {
        $query = $this->db->query("SELECT code FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int) $zone_id . "' AND status = '1'");
    }

    public function validateAgeLimit($dob) {

        $status = false;
        $date1 = $dob;
        $date2 = date("Y-m-d");

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $diff = $year2 - $year1;
        if ($diff >= 18) {
            $status = true;
        }

        return $status;
    }

    public function validateEmail($email) {
        $status = false;
        $regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
        if (preg_match($regex, $email)) {
            $status = true;
        }
        return $status;
    }

    public function validateSSN($date) {
        if ($date) {
            $status = false;
            if (preg_match("/^(\d{3}-?\d{2}-?\d{4}|XXX-XX-XXXX)$/", $date)) {
                $status = true;
            }

            return $status;
        } else {
            return true;
        }
    }

    public function calculateUserRepurchase($order_id, $customer_id) {

        $order_details = array();

        if ($customer_id && $order_id) {

            $ordered_products_data = $this->getRepurchaseOrders($order_id);

            if (count($ordered_products_data)) {
                $order_details['customer_id'] = $customer_id;
                $order_details['order_data'] = $ordered_products_data;
                $order_details['order_id'] = $order_id;

                if (!$this->request->server['HTTPS']) {
                    $backoffice_url = HTTP_SERVER . "backoffice/";
                } else {
                    $backoffice_url = HTTPS_SERVER . "backoffice/";
                }

                $url = $backoffice_url . 'login/opencart_repurchase_commission';

                $this->runMLMCURL($customer_id, $url, $order_details, 'repurchase');
            }
        }
    }

    public function getRepurchaseOrders($order_id) {
        $repurchase_orders = array();
        $this->load->model('account/order');
        $ordered_products_data = $this->model_account_order->getOrderProducts($order_id);
        foreach ($ordered_products_data AS $order) {
            if ($order['product_type'] == 'purchase') {
                $repurchase_orders[] = $order;
            }
        }
        return $repurchase_orders;
    }

    public function getCartedProducts($type = 'cart') {

        $product_arr = array();

        $this->load->model('tool/image');
        $this->load->model('tool/upload');
        if ($type == "cart") {
            if ($this->cart->countPurchaseProducts()) {
                $products = $this->cart->getProducts();
            } else {
                $products = $this->getAutoshipProductDetails();
            }
        } else {
            if ($this->cart->countAutoshipProducts()) {
                $products = $this->cart->getAutoshipProducts();
            } else {
                $products = $this->getAutoshipProductDetails();
            }
        }

        foreach ($products as $product) {

            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
            }

            if ($product['image']) {
                $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
            } else {
                $image = '';
            }

            $option_data = array();

            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['value'];
                } else {
                    $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                    if ($upload_info) {
                        $value = $upload_info['name'];
                    } else {
                        $value = '';
                    }
                }

                $option_data[] = array(
                    'name' => $option['name'],
                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                );
            }


            $price_excluding_tax = $product['price'];
            $account_type = 'customer';

            if (isset($this->session->data['reg_data']['account_type'])) {
                $account_type = $this->session->data['reg_data']['account_type'];
            }
            if ($account_type != 'customer') {
                $price = $product['distributor_price'];
            }

            // Display prices
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = false;
            }

            $distributor_price = $this->currency->format($product['distributor_price']);

            // Display prices
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
            } else {
                $total = false;
            }

            $recurring = '';

            if ($product['recurring']) {
                $frequencies = array(
                    'day' => $this->language->get('text_day'),
                    'week' => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month' => $this->language->get('text_month'),
                    'year' => $this->language->get('text_year'),
                );

                if ($product['recurring']['trial']) {
                    $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                }

                if ($product['recurring']['duration']) {
                    $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                } else {
                    $recurring .= sprintf($this->language->get('text_payment_until_canceled_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                }
            }

            $product_arr[] = array(
                'key' => $product['key'],
                'thumb' => $image,
                'name' => $product['name'],
                'model' => $product['model'],
                'option' => $option_data,
                'recurring' => $recurring,
                'quantity' => $product['quantity'],
                'stock' => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
                'reward' => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
                'price' => $price,
                'price_excluding_tax' => $price_excluding_tax,
                'distributor_price' => $distributor_price,
                'product_pv' => $product['product_pv'], //new field
                'customer_pv' => $product['customer_pv'], //new field
                'product_type' => $product['product_type'], //new field
                'autoship_status' => $product['autoship_status'], //new field
                'total' => $total,
                'href' => $this->url->link('product/product', 'product_id=' . $product['product_id'])
            );
        }

        return $product_arr;
    }

    public function insertPackageOrderHistory($sponsor_id, $account_type, $enrollment_order_id, $step4_data, $step5_data, $step6_data, $step7_data) {

        if (!$step5_data['autoship_type']) {
            $step7_data['cc_number'] = substr_replace($step7_data['cc_number'], 'xxxxxxxxxxxx', 0, 12);
        }

        $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "user_package_purchase_history SET sponsor_id ='" . $sponsor_id . "', account_type = '" . $account_type . "', enrollment_order_id= '" . $enrollment_order_id . "', step4_data  = '" . serialize($step4_data) . "', step5_data  = '" . serialize($step5_data) . "', step6_data  = '" . serialize($step6_data) . "', step7_data  = '" . serialize($step7_data) . "',date_added = NOW()");

        $purchase_order_id = $this->db->getLastId();

        return $purchase_order_id;
    }

    public function getAllRegistrationPackages($product_id = '') {

        $category_id = 305;

        $this->load->model("catalog/product");

        $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'";


        $sql .= " AND p2c.category_id = '" . (int) $category_id . "'";

        if ($product_id != '') {
            $sql .= " AND p.product_id = '" . (int) $product_id . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $sql .= " ORDER BY p.sort_order";

        $sql .= " ASC, LCASE(pd.name) ASC";

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_details = $this->model_catalog_product->getProduct($result['product_id']);
            $product_details['description'] = html_entity_decode($product_details['description']);
            $product_data[$result['product_id']] = $product_details;
        }

        return $product_data;
    }

    public function removeOtherPackages($product_id) {
        $packages = $this->getOtherPackages($product_id);
        foreach ($packages AS $package) {
            $product_id = $package['product_id'];
            $product['product_id'] = (int) $product_id;
            $key = base64_encode(serialize($product));
            $this->cart->remove($key);
        }
    }

    public function getOtherPackages($product_id) {
        $this->load->model("catalog/product");
        $product_data = array();
        $sql = "SELECT product_id  FROM " . DB_PREFIX . "product WHERE product_id != " . (int) $product_id . " AND product_type = 'package' AND status = 1 ";
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
        }
        return $product_data;
    }

    public function addAutoshipOrder_old($autoship_order_data) {
        $autoship_products = $autoship_order_data['products'];
        $autoship_quantity = $autoship_order_data['autoship_quantity'];
        $autoship_day = $autoship_order_data['autoship_day'];
        $shipping = $autoship_order_data['shipping'];

        foreach ($autoship_products AS $product) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];
            $unit_price = $product['price'];
            $product_pv = $product['product_pv'];

            $this->db->query("INSERT INTO " . MLM_DB_PREFIX . "user_autoship_details SET product_id ='" . $product_id . "', quantity = '" . $quantity . "', unit_price= '" . $unit_price . "', product_pv  = '" . $product_pv . "', shipping_method  = '" . $shipping . "', shipping_day  = '" . $autoship_day . "', last_updated = NOW()");
        }

        $order_id = $this->db->getLastId();
        return $order_id;
    }

    public function addAutoshipOrder($data) {

        $this->addAutoshipOrder_old($data); //remove this after finishing autoship management options                

        $this->event->trigger('pre.order.add', $data);

        $this->db->query("INSERT INTO `" . DB_PREFIX . "autoship_order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int) $data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int) $data['customer_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int) $data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int) $data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? serialize($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int) $data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int) $data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? serialize($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float) $data['total'] . "', affiliate_id = '" . (int) $data['affiliate_id'] . "', commission = '" . (float) $data['commission'] . "', marketing_id = '" . (int) $data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int) $data['language_id'] . "', currency_id = '" . (int) $data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float) $data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" . $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW(),order_status_id=1");

        $order_id = $this->db->getLastId();

        // Products
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "autoship_order_product SET order_id = '" . (int) $order_id . "', product_id = '" . (int) $product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int) $product['quantity'] . "', autoship_day = '" . (int) $product['autoship_day'] . "', shipping_method = '" . $product['shipping_method'] . "', price = '" . (float) $product['price'] . "', total = '" . (float) $product['total'] . "', tax = '" . $product['tax'] . "', reward = '" . (int) $product['reward'] . "', distributor_price = '" . (float) $product['distributor_price'] . "', product_pv = '" . (float) $product['product_pv'] . "',customer_pv = '" . (float) $product['customer_pv'] . "', product_type = '" . $product['product_type'] . "'");
            }
        }

        // Totals
        if (isset($data['totals'])) {
            foreach ($data['totals'] as $total) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "autoship_order_total SET order_id = '" . (int) $order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float) $total['value'] . "', sort_order = '" . (int) $total['sort_order'] . "'");
            }
        }

        $this->event->trigger('post.order.add', $order_id);

        return $order_id;
    }

    public function updateOrderCustomerID($order_id, $customer_id) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET  customer_id = '" . (int) $customer_id . "' WHERE order_id ='" . (int) $order_id . "'");
    }

    public function updateAutoshipOrderCustomerID($autoship_order_id, $customer_id) {
        $this->db->query("UPDATE `" . DB_PREFIX . "autoship_order` SET  customer_id = '" . (int) $customer_id . "' WHERE order_id ='" . (int) $autoship_order_id . "'");
        return $autoship_order_id;
    }

    public function addAutoshipOrderHistory($order_id, $order_status_id, $comment = '', $notify = false) {
        $this->event->trigger('pre.order.history.add', $order_id);

        $order_info = $this->getAutoshipOrder($order_id);
        if ($order_info) {
            // Fraud Detection
            $this->load->model('account/customer');

            $customer_info = $this->model_account_customer->getCustomer($order_info['customer_id']);

            if ($customer_info && $customer_info['safe']) {
                $safe = true;
            } else {
                $safe = false;
            }

            if ($this->config->get('config_fraud_detection')) {
                $this->load->model('checkout/fraud');

                $risk_score = $this->model_checkout_fraud->getFraudScore($order_info);

                if (!$safe && $risk_score > $this->config->get('config_fraud_score')) {
                    $order_status_id = $this->config->get('config_fraud_status_id');
                }
            }

            // Ban IP
            if (!$safe) {
                $status = false;

                if ($order_info['customer_id']) {
                    $results = $this->model_account_customer->getIps($order_info['customer_id']);

                    foreach ($results as $result) {
                        if ($this->model_account_customer->isBanIp($result['ip'])) {
                            $status = true;

                            break;
                        }
                    }
                } else {
                    $status = $this->model_account_customer->isBanIp($order_info['ip']);
                }

                if ($status) {
                    $order_status_id = $this->config->get('config_order_status_id');
                }
            }

            $this->db->query("UPDATE `" . DB_PREFIX . "autoship_order` SET order_status_id = '" . (int) $order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "autoship_order_history SET order_id = '" . (int) $order_id . "', order_status_id = '" . (int) $order_status_id . "', notify = '" . (int) $notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

            // If order status is 0 then becomes greater than 0 send main html email
            if ($order_status_id) {
                // Check for any downloadable products
                $download_status = false;

                // Load the language for any mails that might be required to be sent out
                $language = new Language($order_info['language_directory']);
                $language->load('default');
                $language->load('mail/autoship_order');

                /* $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "autoship_order_status WHERE order_status_id = '" . (int) $order_status_id . "' AND language_id = '" . (int) $order_info['language_id'] . "'");

                  if ($order_status_query->num_rows) {
                  $order_status = $order_status_query->row['name'];
                  } else {
                  $order_status = '';
                  } */

                $order_status = 'ACTIVE';

                $order_id_with_prefix = str_pad($order_id, 7, 0, STR_PAD_LEFT);
                $subject = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id_with_prefix);

                // HTML Mail
                $data = array();

                $data['title'] = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id_with_prefix);

                $data['text_greeting'] = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
                $data['text_link'] = $language->get('text_new_link');
                $data['text_download'] = $language->get('text_new_download');
                $data['text_order_detail'] = $language->get('text_new_order_detail');
                $data['text_instruction'] = $language->get('text_new_instruction');
                $data['text_order_id'] = $language->get('text_new_order_id');
                $data['text_date_added'] = $language->get('text_new_date_added');
                $data['text_payment_method'] = $language->get('text_new_payment_method');
                $data['text_shipping_method'] = $language->get('text_new_shipping_method');
                $data['text_email'] = $language->get('text_new_email');
                $data['text_telephone'] = $language->get('text_new_telephone');
                $data['text_ip'] = $language->get('text_new_ip');
                $data['text_order_status'] = $language->get('text_new_order_status');
                $data['text_payment_address'] = $language->get('text_new_payment_address');
                $data['text_shipping_address'] = $language->get('text_new_shipping_address');
                $data['text_product'] = $language->get('text_new_product');
                $data['text_model'] = $language->get('text_new_model');
                $data['text_quantity'] = $language->get('text_new_quantity');
                $data['text_price'] = $language->get('text_new_price');
                $data['text_total'] = $language->get('text_new_total');
                $data['text_footer'] = $language->get('text_new_footer');

                $data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
                $data['store_name'] = $order_info['store_name'];
                $data['store_url'] = $order_info['store_url'];
                $data['customer_id'] = $order_info['customer_id'];
                $data['link'] = '';

                if ($download_status) {
                    $data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
                } else {
                    $data['download'] = '';
                }

                $data['order_id'] = $order_id_with_prefix;
                $data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
                $data['payment_method'] = $order_info['payment_method'];
                $data['shipping_method'] = $order_info['shipping_method'];
                $data['email'] = $order_info['email'];
                $data['telephone'] = $order_info['telephone'];
                $data['ip'] = $order_info['ip'];
                $data['order_status'] = $order_status;

                if ($comment && $notify) {
                    $data['comment'] = nl2br($comment);
                } else {
                    $data['comment'] = '';
                }
                if ($order_info['payment_address_format']) {
                    $format = $order_info['payment_address_format'];
                } else {
                    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );

                $replace = array(
                    'firstname' => $order_info['payment_firstname'],
                    'lastname' => $order_info['payment_lastname'],
                    'company' => $order_info['payment_company'],
                    'address_1' => $order_info['payment_address_1'],
                    'address_2' => $order_info['payment_address_2'],
                    'city' => $order_info['payment_city'],
                    'postcode' => $order_info['payment_postcode'],
                    'zone' => $order_info['payment_zone'],
                    'zone_code' => $order_info['payment_zone_code'],
                    'country' => $order_info['payment_country']
                );

                $data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );
                $replace = array(
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname' => $order_info['shipping_lastname'],
                    'company' => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city' => $order_info['shipping_city'],
                    'postcode' => $order_info['shipping_postcode'],
                    'zone' => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country' => $order_info['shipping_country']
                );

                $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                $this->load->model('tool/upload');

                // Products
                $data['products'] = array();
                $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "autoship_order_product WHERE order_id = '" . (int) $order_id . "'");
                foreach ($order_product_query->rows as $product) {
                    $option_data = array();

                    $data['products'][] = array(
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                        'total' => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
                    );
                }

                // Vouchers
                $data['vouchers'] = array();
                // Order Totals
                $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "autoship_order_total` WHERE order_id = '" . (int) $order_id . "' ORDER BY sort_order ASC");

                foreach ($order_total_query->rows as $total) {
                    $value = $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']);
                    if ($total['title'] == 'Total Tax') {
                        $value = 'To be Updated';
                    }
                    $data['totals'][] = array(
                        'title' => $total['title'],
                        'text' => $value,
                    );
                }

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/autoship_order.tpl')) {
                    $html = $this->load->view($this->config->get('config_template') . '/template/mail/autoship_order.tpl', $data);
                } else {
                    $html = $this->load->view('default/template/mail/autoship_order.tpl', $data);
                }

                // Can not send confirmation emails for CBA orders as email is unknown
                $this->load->model('payment/amazon_checkout');

                if (!$this->model_payment_amazon_checkout->isAmazonOrder($order_info['order_id'])) {
                    // Text Mail
                    $text = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
                    $text .= $language->get('text_new_order_id') . ' ' . $order_id_with_prefix . "\n";
                    $text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
                    $text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";

                    if ($comment && $notify) {
                        $text .= $language->get('text_new_instruction') . "\n\n";
                        $text .= $comment . "\n\n";
                    }
                }

                $text .= $language->get('text_new_order_total') . "\n";

                foreach ($order_total_query->rows as $total) {
                    $text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                }

                $text .= "\n";

                if ($order_info['customer_id']) {
                    $text .= $language->get('text_new_link') . "\n";
                    //$text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
                }

                if ($download_status) {
                    $text .= $language->get('text_new_download') . "\n";
                    $text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
                }

                // Comment
                if ($order_info['comment']) {
                    $text .= $language->get('text_new_comment') . "\n\n";
                    $text .= $order_info['comment'] . "\n\n";
                }

                $text .= $language->get('text_new_footer') . "\n\n";

                $mail = new Mail($this->config->get('config_mail'));
                $mail->setTo($order_info['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($order_info['store_name']);
                $mail->setSubject($subject);
                $mail->setHtml($html);
                $mail->setText($text);
                $mail->send();
            }

            // Admin Alert Mail
            if ($this->config->get('config_order_mail')) {
                $subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

                // HTML Mail
                $data['text_greeting'] = $language->get('text_new_received');

                if ($comment) {
                    if ($order_info['comment']) {
                        $data['comment'] = nl2br($comment) . '<br/><br/>' . $order_info['comment'];
                    } else {
                        $data['comment'] = nl2br($comment);
                    }
                } else {
                    if ($order_info['comment']) {
                        $data['comment'] = $order_info['comment'];
                    } else {
                        $data['comment'] = '';
                    }
                }
                $data['text_download'] = '';

                $data['text_footer'] = '';

                $data['text_link'] = '';
                $data['link'] = '';
                $data['download'] = '';

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/autoship_order.tpl')) {
                    $html = $this->load->view($this->config->get('config_template') . '/template/mail/autoship_order.tpl', $data);
                } else {
                    $html = $this->load->view('default/template/mail/autoship_order.tpl', $data);
                }

                // Text
                $text = $language->get('text_new_received') . "\n\n";
                $text .= $language->get('text_new_order_id') . ' ' . $order_id_with_prefix . "\n";
                $text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
                $text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
                $text .= $language->get('text_new_products') . "\n";

                foreach ($order_product_query->rows as $product) {
                    $text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                }

                $text .= $language->get('text_new_order_total') . "\n";

                foreach ($order_total_query->rows as $total) {
                    $text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                }

                $text .= "\n";

                if ($order_info['comment']) {
                    $text .= $language->get('text_new_comment') . "\n\n";
                    $text .= $order_info['comment'] . "\n\n";
                }

                $mail = new Mail($this->config->get('config_mail'));
                $mail->setTo($this->config->get('config_email'));
                $mail->setFrom($this->config->get('config_email'));
                $mail->setReplyTo($order_info['email']);
                $mail->setSender($order_info['store_name']);
                $mail->setSubject($subject);
                $mail->setHtml($html);
                $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
                $mail->send();

                // Send to additional alert emails
                $emails = explode(',', $this->config->get('config_mail_alert'));

                foreach ($emails as $email) {
                    if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
                        $mail->setTo($email);
                        $mail->send();
                    }
                }
            }
        }

        $this->event->trigger('post.order.history.add', $order_id);
    }

    public function getAutoshipOrder($order_id) {
        $order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "autoship_order` o WHERE o.order_id = '" . (int) $order_id . "'");

        if ($order_query->num_rows) {
            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $order_query->row['payment_country_id'] . "'");

            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $order_query->row['payment_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $order_query->row['shipping_country_id'] . "'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $order_query->row['shipping_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            $this->load->model('localisation/language');

            $language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];
                $language_directory = $language_info['directory'];
            } else {
                $language_code = '';
                $language_directory = '';
            }

            return array(
                'order_id' => $order_query->row['order_id'],
                'invoice_no' => $order_query->row['invoice_no'],
                'invoice_prefix' => $order_query->row['invoice_prefix'],
                'store_id' => $order_query->row['store_id'],
                'store_name' => $order_query->row['store_name'],
                'store_url' => $order_query->row['store_url'],
                'customer_id' => $order_query->row['customer_id'],
                'firstname' => $order_query->row['firstname'],
                'lastname' => $order_query->row['lastname'],
                'email' => $order_query->row['email'],
                'telephone' => $order_query->row['telephone'],
                'fax' => $order_query->row['fax'],
                'custom_field' => unserialize($order_query->row['custom_field']),
                'payment_firstname' => $order_query->row['payment_firstname'],
                'payment_lastname' => $order_query->row['payment_lastname'],
                'payment_company' => $order_query->row['payment_company'],
                'payment_address_1' => $order_query->row['payment_address_1'],
                'payment_address_2' => $order_query->row['payment_address_2'],
                'payment_postcode' => $order_query->row['payment_postcode'],
                'payment_city' => $order_query->row['payment_city'],
                'payment_zone_id' => $order_query->row['payment_zone_id'],
                'payment_zone' => $order_query->row['payment_zone'],
                'payment_zone_code' => $payment_zone_code,
                'payment_country_id' => $order_query->row['payment_country_id'],
                'payment_country' => $order_query->row['payment_country'],
                'payment_iso_code_2' => $payment_iso_code_2,
                'payment_iso_code_3' => $payment_iso_code_3,
                'payment_address_format' => $order_query->row['payment_address_format'],
                'payment_custom_field' => unserialize($order_query->row['payment_custom_field']),
                'payment_method' => $order_query->row['payment_method'],
                'payment_code' => $order_query->row['payment_code'],
                'shipping_firstname' => $order_query->row['shipping_firstname'],
                'shipping_lastname' => $order_query->row['shipping_lastname'],
                'shipping_company' => $order_query->row['shipping_company'],
                'shipping_address_1' => $order_query->row['shipping_address_1'],
                'shipping_address_2' => $order_query->row['shipping_address_2'],
                'shipping_postcode' => $order_query->row['shipping_postcode'],
                'shipping_city' => $order_query->row['shipping_city'],
                'shipping_zone_id' => $order_query->row['shipping_zone_id'],
                'shipping_zone' => $order_query->row['shipping_zone'],
                'shipping_zone_code' => $shipping_zone_code,
                'shipping_country_id' => $order_query->row['shipping_country_id'],
                'shipping_country' => $order_query->row['shipping_country'],
                'shipping_iso_code_2' => $shipping_iso_code_2,
                'shipping_iso_code_3' => $shipping_iso_code_3,
                'shipping_address_format' => $order_query->row['shipping_address_format'],
                'shipping_custom_field' => unserialize($order_query->row['shipping_custom_field']),
                'shipping_method' => $order_query->row['shipping_method'],
                'shipping_code' => $order_query->row['shipping_code'],
                'comment' => $order_query->row['comment'],
                'total' => $order_query->row['total'],
                'order_status_id' => $order_query->row['order_status_id'],
                'order_status' => $order_query->row['order_status'],
                'affiliate_id' => $order_query->row['affiliate_id'],
                'commission' => $order_query->row['commission'],
                'language_id' => $order_query->row['language_id'],
                'language_code' => $language_code,
                'language_directory' => $language_directory,
                'currency_id' => $order_query->row['currency_id'],
                'currency_code' => $order_query->row['currency_code'],
                'currency_value' => $order_query->row['currency_value'],
                'ip' => $order_query->row['ip'],
                'forwarded_ip' => $order_query->row['forwarded_ip'],
                'user_agent' => $order_query->row['user_agent'],
                'accept_language' => $order_query->row['accept_language'],
                'date_modified' => $order_query->row['date_modified'],
                'date_added' => $order_query->row['date_added'],
                'cc_type' => $order_query->row['cc_type'],
                'cc_number' => $order_query->row['cc_number'],
                'cc_firstname' => $order_query->row['cc_firstname'],
                'cc_lastname' => $order_query->row['cc_lastname'],
                'cc_expire_date_month' => $order_query->row['cc_expire_date_month'],
                'cc_expire_date_year' => $order_query->row['cc_expire_date_year'],
                'cc_cvv2' => $order_query->row['cc_cvv2'],
                'cc_issue' => $order_query->row['cc_issue']
            );
        } else {
            return false;
        }
    }

    public function updateAutoshipOrderCustomerID_old($autoship_order, $customer_id) {
        $this->db->query("UPDATE `" . MLM_DB_PREFIX . "user_autoship_details` SET  customer_id = '" . (int) $customer_id . "' WHERE autoship_id ='" . (int) $autoship_order . "'");
    }

    public function isEmailExist($email) {
        $query = $this->db->query("SELECT email FROM " . DB_PREFIX . "news_letter WHERE email ='" . $email . "'");
        if ($query->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function addToNewsLetter($email) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "news_letter SET email ='" . $email . "',date = NOW() ");
    }

    public function updateAutoshipOrderCCDetails($autoship_order_id, $cc_details) {
        $this->db->query("UPDATE " . DB_PREFIX . "autoship_order SET cc_type ='" . $cc_details['cc_type'] . "', cc_number ='" . $cc_details['cc_number'] . "', cc_firstname ='" . $cc_details['cc_firstname'] . "', cc_lastname ='" . $cc_details['cc_lastname'] . "', cc_expire_date_month ='" . $cc_details['cc_expire_date_month'] . "', cc_expire_date_year ='" . $cc_details['cc_expire_date_year'] . "', cc_cvv2 ='" . $cc_details['cc_cvv2'] . "', cc_issue ='" . $cc_details['cc_issue'] . "' WHERE order_id = '$autoship_order_id'");
    }

    public function checkValidCustomer($user_id, $customer_id) {
        $query = $this->db->query("SELECT id FROM " . MLM_DB_PREFIX . "ft_individual WHERE id ='" . $user_id . "' AND oc_customer_ref_id ='" . $customer_id . "'");
        if ($query->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomerAddressId($customer_id) {
        $address_query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "address WHERE  customer_id = '" . (int) $customer_id . "'");
        return $address_query->row['address_id'];
    }

    public function getCustomerGroupID($customer_id) {
        $address_query = $this->db->query("SELECT customer_group_id FROM " . DB_PREFIX . "customer WHERE  customer_id = '" . (int) $customer_id . "'");
        return $address_query->row['customer_group_id'];
    }

    public function updateAutoshipOrder($data, $order_id) {

        $this->event->trigger('pre.order.add', $data);

        $this->db->query("UPDATE `" . DB_PREFIX . "autoship_order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int) $data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int) $data['customer_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int) $data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int) $data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? serialize($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int) $data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int) $data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? serialize($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float) $data['total'] . "', affiliate_id = '" . (int) $data['affiliate_id'] . "', commission = '" . (float) $data['commission'] . "', marketing_id = '" . (int) $data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int) $data['language_id'] . "', currency_id = '" . (int) $data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float) $data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" . $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW(),order_status_id=1 WHERE order_id=$order_id");

        // Products
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $this->db->query("UPDATE " . DB_PREFIX . "autoship_order_product SET  name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int) $product['quantity'] . "', autoship_day = '" . (int) $product['autoship_day'] . "', shipping_method = '" . $product['shipping_method'] . "', price = '" . (float) $product['price'] . "', total = '" . (float) $product['total'] . "', tax = '" . (float) $product['tax'] . "', reward = '" . (int) $product['reward'] . "', distributor_price = '" . (float) $product['distributor_price'] . "', product_pv = '" . (float) $product['product_pv'] . "',customer_pv = '" . (float) $product['customer_pv'] . "', product_type = '" . $product['product_type'] . "' WHERE order_id = '" . (int) $order_id . "' AND product_id = '" . (int) $product['product_id'] . "'");
            }
        }

        // Totals
        if (isset($data['totals'])) {
            foreach ($data['totals'] as $total) {
                $this->db->query("UPDATE " . DB_PREFIX . "autoship_order_total SET  title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float) $total['value'] . "', sort_order = '" . (int) $total['sort_order'] . "' WHERE order_id = '" . (int) $order_id . "' AND code = '" . $this->db->escape($total['code']) . "'");
            }
        }

        $this->event->trigger('post.order.add', $order_id);

        return $order_id;
    }

    public function validateFirstname($firstname) {
        if ($firstname) {
            $status = false;
            if (preg_match("/^[A-z]+$/", $firstname)) {
                $status = true;
            }

            return $status;
        } else {
            return true;
        }
    }

    public function getPaymentMethods($code = '', $type = 'cart') {
        $method_data = array();

        $this->load->model('extension/extension');

        $results = $this->model_extension_extension->getExtensions('payment');

        $total = 0;
        if ($type == 'cart') {
            $total = $this->cart->getTotal();
        } else {
            $total = $this->cart->getAutoshipTotal();
        }
        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
                $flag = FALSE;
                if ($code != '') {
                    if ($result['code'] == $code) {
                        $flag = true;
                    }
                } else {
                    $flag = true;
                }
                if ($flag) {
                    $this->load->model('payment/' . $result['code']);

                    $method = $this->{'model_payment_' . $result['code']}->getMethod($this->session->data['payment_address'], $total);
                    if ($method) {
                        $method_data[$result['code']] = $method;
                    }
                }
            }
        }

        $sort_order = array();

        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $method_data);

        return $method_data;
    }

    public function getShippingMethods($code, $address, $type = 'cart') {
        $method_data = array();

        if ($this->config->get($code . '_status')) {
            $this->load->model('shipping/' . $code);

            if ($type == 'cart') {
                $quote = $this->{'model_shipping_' . $code}->getQuote($address);
            } else {
                $quote = $this->{'model_shipping_' . $code}->getAutoshipQuote($address);
            }

            if ($quote) {
                $method_data[$code] = array(
                    'title' => $quote['title'],
                    'quote' => $quote['quote'],
                    'sort_order' => $quote['sort_order'],
                    'error' => $quote['error']
                );
            }
        }
        return $method_data;
    }

    public function insertPP_PROHistory($request, $order_id, $customer_id, $type = 'order') {
        $request = serialize($request);
        $this->db->query("INSERT INTO " . DB_PREFIX . "pp_pro_transaction_history SET customer_id ='" . $customer_id . "', order_id  = '" . $order_id . "', request_data = '" . $request . "',  type  = '" . $type . "', date = NOW()");

        $curl_id = $this->db->getLastId();
        return $curl_id;
    }

    public function addFailedOrderHistory($customer_id, $order_id, $autoship_order_id, $message) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "failed_autoship_orders SET customer_id ='" . $customer_id . "', order_id  = '" . $order_id . "', monthly_order_id = '" . $autoship_order_id . "',  error_message  = '" . $message . "', date = NOW()");
    }

    public function updatePP_PROHistory($pp_pro_history_id, $response, $order_id, $customer_id) {
        $response = serialize($response);
        $this->db->query("UPDATE " . DB_PREFIX . "pp_pro_transaction_history SET response_data ='" . $response . "' , customer_id ='" . $customer_id . "', date = NOW() WHERE history_id = $pp_pro_history_id AND order_id ='" . $order_id . "'");
    }
            
   public function getAutofillDetails() {
        $autofill_data = array();
        $autofill_data['user_name'] = "OC" . $this->getUniqueUserame();
        $autofill_data['first_name'] = "Your First Name ";
        $autofill_data['last_name'] = "Your Last Name";
        $autofill_data['gender'] = "M";
        $autofill_data['year'] = 1990;
        $autofill_data['month'] = 1;
        $autofill_data['day'] = 1;
        $autofill_data['address'] = "your Address";
        $autofill_data['country'] = "India";
        $autofill_data['country_id'] = 244;
        $autofill_data['zone_id'] = 3513;
        $autofill_data['city'] = "City";
        $autofill_data['zip_code'] = 654321;
        $autofill_data['mobile'] = 9961148729;
        $autofill_data['bank_name'] = "";
        $autofill_data['bank_branch'] = "";
        $autofill_data['bank_acc_no'] = "";
        $autofill_data['ifsc'] = "";
        $autofill_data['ifsc'] = "";
        $autofill_data['pan_no'] = "";
        $autofill_data['land_line'] = "";
        $autofill_data['fax'] = "";
        $autofill_data['email'] = "infinitemlmsoftware@gmail.com";

        return $autofill_data;
    }

    public function getUniqueUserame() {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        // Create username
        $username = '';
        for ($i = 0; $i < 4; $i++)
            $username .= $chars[(mt_rand(0, (strlen($chars) - 1)))];
        return $username;
    }

}
