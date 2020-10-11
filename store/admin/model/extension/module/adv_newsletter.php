<?php
/**
 * Created by ANH To <anh.to87@gmail.com>.
 * User: baoan
 * Date: 11/7/15
 * Time: 12:20
 */

class ModelExtensionModuleAdvNewsletter extends Model
{
    public function getEmails($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "email_subscribed";
        $sql .= " WHERE 1";
        if (!empty($data['filter_email'])) {
            $sql .= " AND email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
        }
        if (!empty($data['filter_status'])) {
            $sql .= " AND status IN (" . $this->db->escape($data['filter_status']) . ")";
        }
        $sql .= " ORDER BY id DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);
        
        return $query->rows;
   
    }
    
    
    

    public function getTotalEmails($data = array()) {
        $sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "email_subscribed";
        $sql .= " WHERE 1";
        if (!empty($data['filter_email'])) {
            $sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
        }
        if (!empty($data['filter_status'])) {
            $sql .= " AND status IN (" . $this->db->escape($data['filter_status']) . ")";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    /**
     * Once time install only
     */
    public function install()
    {
        $this->table = DB_PREFIX . 'email_subscribed';

        $sql = "SELECT `TABLE_NAME`
                        FROM information_schema.tables
                        WHERE table_schema = '".DB_DATABASE."'  AND table_name = '{$this->table}'";

        $check_table = $this->db->query($sql);
        // Check the table is exist or not
        if (!isset($check_table->row['TABLE_NAME']))
        {
            $sql = "CREATE TABLE `{$this->table}` (
                      `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      `email` text NOT NULL,
                      `confirm_sent` tinyint(1) NOT NULL,
                      `created_date` datetime NOT NULL,
                      `updated_date` datetime NOT NULL,
                      `status` tinyint(1) NOT NULL COMMENT '0: disabled; 1: enabled; 2: blacklist; 3: un-subscribed; 4: not verified'
                    );";

            $this->db->query($sql);

            # Copy template of email to all languages

            // Auto set setting for image sizes
            $setting = [
                'advanced_newsletter_send_for'   => 'a:1:{i:0;s:1:"1";}',
            ];

            // Get all stores
            $query_store = $this->db->query("SELECT * FROM ".DB_PREFIX."store");

            if ($query_store->num_rows)
            {
                foreach ($query_store->rows as $row)
                {
                    foreach ($setting as $key => $value)
                    {
                        $this->db->query("DELETE FROM ".DB_PREFIX."setting WHERE `key` = '{$key}' AND store_id = {$row['store_id']}");
                        $this->db->query("INSERT INTO ".DB_PREFIX."setting set `code` = 'advanced_newsletter', `key` = '{$key}', value = '{$value}', store_id = {$row['store_id']}, serialized = 1");
                    }
                }
            }

        }
    }
}