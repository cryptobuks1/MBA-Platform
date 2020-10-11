<?php
class ControllerExtensionPaymentBlockchain extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('extension/payment/block_chain');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$this->load->model('extension/payment/block_chain');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('block_chain', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['language_reload'])) {
				$this->response->redirect($this->url->link('payment/block_chain', 'token=' . $this->session->data['token'], true));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
                $data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_xPub'] = $this->language->get('entry_xPub');
		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_main_password'] = $this->language->get('entry_main_password');
		$data['entry_second_password'] = $this->language->get('entry_second_password');
		$data['entry_secret'] = $this->language->get('entry_secret');
		$data['entry_fee'] = $this->language->get('entry_fee');
		$data['text_status'] = $this->language->get('text_status');

		$data['error_credentials'] = $this->language->get('error_credentials');

		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_xPub'])) {
			$data['error_xPub'] = $this->error['error_xPub'];
		} else {
			$data['error_xPub'] = '';
		}

		if (isset($this->error['error_api_key'])) {
			$data['error_api_key'] = $this->error['error_api_key'];
		} else {
			$data['error_api_key'] = '';
		}

		if (isset($this->error['error_secret'])) {
			$data['error_secret'] = $this->error['error_secret'];
		} else {
			$data['error_secret'] = '';
		}

		if (isset($this->error['error_main_password'])) {
			$data['error_main_password'] = $this->error['error_main_password'];
		} else {
			$data['error_main_password'] = '';
		}

		if (isset($this->error['error_second_password'])) {
			$data['error_second_password'] = $this->error['error_second_password'];
		} else {
			$data['error_second_password'] = '';
		}

		if (isset($this->error['error_fee'])) {
			$data['error_fee'] = $this->error['error_fee'];
		} else {
			$data['error_fee'] = '';
		}

		if (isset($this->error['error_curreny'])) {
			$data['error_curreny'] = $this->error['error_curreny'];
		} else {
			$data['error_curreny'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/block_chain', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/block_chain', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['block_chain_xPub'])) {
			$data['xPub'] = $this->request->post['block_chain_xPub'];
		} elseif ($this->config->get('block_chain_xPub')) {
			$data['xPub'] = $this->config->get('block_chain_xPub');
		} else {
			$data['xPub'] = '';
		}

		if (isset($this->request->post['block_chain_api_key'])) {
			$data['api_key'] = $this->request->post['block_chain_api_key'];
		} elseif ($this->config->get('block_chain_api_key')) {
			$data['api_key'] = $this->config->get('block_chain_api_key');
		} else {
			$data['api_key'] = '';
		}

		if (isset($this->request->post['block_chain_secret'])) {
			$data['secret'] = $this->request->post['block_chain_secret'];
		} elseif ($this->config->get('block_chain_secret')) {
			$data['secret'] = $this->config->get('block_chain_secret');
		} else {
			$data['secret'] = '';
		}

		if (isset($this->request->post['block_chain_main_password'])) {
			$data['main_password'] = $this->request->post['block_chain_main_password'];
		} elseif ($this->config->get('block_chain_main_password')) {
			$data['main_password'] = $this->config->get('block_chain_main_password');
		} else {
			$data['main_password'] = '';
		}

		if (isset($this->request->post['block_chain_second_password'])) {
			$data['second_password'] = $this->request->post['block_chain_second_password'];
		} elseif ($this->config->get('block_chain_second_password')) {
			$data['second_password'] = $this->config->get('block_chain_second_password');
		} else {
			$data['second_password'] = '';
		}

		if (isset($this->request->post['block_chain_fee'])) {
			$data['fee'] = $this->request->post['block_chain_fee'];
		} elseif ($this->config->get('block_chain_fee')) {
			$data['fee'] = $this->config->get('block_chain_fee');
		} else {
			$data['fee'] = '';
		}
                if (isset($this->request->post['block_chain_status'])) {
			$data['block_chain_status'] = $this->request->post['block_chain_status'];
		} elseif ($this->config->get('block_chain_status')) {
			$data['block_chain_status'] = $this->config->get('block_chain_status');
		} else {
			$data['block_chain_status'] = '0';
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
                
		$this->response->setOutput($this->load->view('extension/payment/block_chain', $data));
                
	}

	public function install() {
		$this->load->model('extension/payment/block_chain');
		$this->load->model('extension/event');
		$this->model_extension_payment_block_chain->install();
		$this->model_extension_event->addEvent('block_chain_cature', 'catalog/model/checkout/order/after', 'extension/payment/block_chain/capture');
		$this->model_extension_event->addEvent('block_chain_history_capture', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/payment/block_chain/capture');
	}

	public function uninstall() {
		$this->load->model('extension/payment/block_chain');
		$this->load->model('extension/event');
		$this->model_extension_payment_block_chain->uninstall();
		$this->model_extension_event->deleteEvent('block_chain_cature');
		$this->model_extension_event->deleteEvent('block_chain_history_capture');
	}

	protected function validate() {
		$this->load->model('localisation/currency');

		if (!$this->user->hasPermission('modify', 'extension/payment/block_chain')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['block_chain_xPub']) {
			$this->error['error_xPub'] = $this->language->get('error_xPub');
		}

		if (!$this->request->post['block_chain_api_key']) {
			$this->error['error_api_key'] = $this->language->get('error_api_key');
		}
		if (!$this->request->post['block_chain_main_password']) {
			$this->error['error_main_password'] = $this->language->get('error_main_password');
		}
		if (!$this->request->post['block_chain_second_password']) {
			$this->error['error_second_password'] = $this->language->get('error_second_password');
		}
		if (isset($this->request->post['block_chain_fee'])&& $this->request->post['block_chain_fee'] != "") {
                        if($this->request->post['block_chain_fee'] <= 0){
                            
                            $this->error['error_fee'] = $this->language->get('error_block_chain_fee');
                        }
		}


		return !$this->error;
	}

}