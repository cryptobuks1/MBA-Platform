<?php
class ModelExtensionModuleModule extends Model {
    private $table;
    public function validate($data)
    {
        $this->table = DB_PREFIX . 'email_subscribed';

        $this->load->language('extension/module/advanced_newsletter');

        $sql = "SELECT * FROM {$this->table} WHERE email = '{$data['email']}'";
        $query = $this->db->query($sql);
        # Check exist email in the system subscribed and customer email
        if ($query->num_rows)
        {
            # Check status of email is blacklist or was un-subscribed
            switch ($query->row['status'])
            {
                case '0':
                case '1':
                case '4':
                    // Enabled/Disabled
                    return array(
                        'error' => 1,
                        'msg'   => $this->language->get('text_email_was_submitted')
                    );
                    break;
                case '2':
                    // Blacklist
                    # If the email is blacklist, then show alert message
                    return array(
                        'error' => 1,
                        'msg'   => $this->language->get('text_email_was_blacklist')
                    );
                case '3':
                    // Un-subscribed
                    # If the email is un-subscribed, send one email to ask subscribe newsletter again
                    $this->_sendEmailConfirm($query->row, 'confirm');
                    $this->_updateConfirmSent($query->row['id']);
                    $this->_updateStatus($query->row['id'], 4);
                    return array(
                        'error' => 0,
                        'msg'   => $this->language->get('text_email_resubscribed')
                    );
            }
        }
        else
        {
            # Add email to subscribed, set status is not verified
            $sql = "INSERT INTO {$this->table} SET email = '{$data['email']}', confirm_sent = 0, created_date = NOW(), status = 4";
            $this->db->query($sql);
            $last_id = $this->db->getLastId();

            $data_email = array(
                'email' => $data['email'],
                'id'    => $last_id
            );
            $this->_sendEmailConfirm($data_email, 'confirm');
            $this->_updateConfirmSent($data_email['id']);
            return array(
                'error' => 1,
                'msg'   => $this->language->get('text_email_submitted')
            );
        }
    }
    private function _updateStatus($id, $status)
    {
        $this->db->query("UPDATE {$this->table} SET status = {$status} WHERE id = {$id}");
    }
    public function agree($email)
    {
        $this->table = DB_PREFIX . 'email_subscribed';

        $sql = "SELECT * FROM {$this->table} WHERE email = '{$email}' AND status IN (3,4)";
        $query = $this->db->query($sql);
        if ($query->num_rows)
        {
            $this->db->query("UPDATE {$this->table} SET status = 1 WHERE id = {$query->row['id']}");

            return true;
        }

        return false;
    }

    public function unagree($email)
    {
        $this->table = DB_PREFIX . 'email_subscribed';

        $sql = "SELECT * FROM {$this->table} WHERE email = '{$email}' AND status IN (0,1,4)";
        $query = $this->db->query($sql);
        if ($query->num_rows)
        {
            $this->db->query("UPDATE {$this->table} SET status = 3 WHERE id = {$query->row['id']}");

            return true;
        }

        return false;
    }

    private function _sendEmailConfirm($data, $filename)
    {
        $encrypt_email = base64_encode($this->encryption->encrypt($data['email']));
        $data['url_agree'] = $this->url->link('extension/module/newsletter/index/confirm/&agree&cid='.$encrypt_email, '', 'SSL');
        $data['url_unagree'] = $this->url->link('extension/module/newsletter/index/confirm&unagree&cid='.$encrypt_email, '', 'SSL');
        $html = $this->_getContent($data, $filename);
        $this->_send($data, 'text_subject_send_confirm_email', $html);
    }

    private function _updateConfirmSent($id)
    {
        $this->db->query("UPDATE {$this->table} SET confirm_sent = 1 WHERE id = $id");
    }


    private function _send($data, $subject, $html)
    {
        $this->load->language('mail/customer');
       
        $subject1 = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setTo($data['email']);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject($subject1);
        $mail->setText($message);
        $mail->setHtml($html);
        $mail->send();
    }

    private function _getContent($data, $filename)
    {
       
     return $this->load->view('mail/'.$this->language->get('code').'/'.$filename.'.tpl', $data);

    }
}