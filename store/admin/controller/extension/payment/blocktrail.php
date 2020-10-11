<?php
class ControllerExtensionPaymentBlocktrail extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('extension/payment/blocktrail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$this->load->model('extension/payment/blocktrail');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('blocktrail', $this->request->post);

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
		
		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_api_secret'] = $this->language->get('entry_api_secret');
		$data['entry_wallet_name'] = $this->language->get('entry_wallet_name');
		$data['entry_wallet_password'] = $this->language->get('entry_wallet_password');
		$data['entry_mode'] = $this->language->get('entry_mode');
		$data['text_status'] = $this->language->get('text_status');
		$data['text_live'] = $this->language->get('text_live');
		$data['text_test'] = $this->language->get('text_test');

		$data['error_credentials'] = $this->language->get('error_credentials');

		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_api_secret'])) {
			$data['error_api_secret'] = $this->error['error_api_secret'];
		} else {
			$data['error_api_secret'] = '';
		}
		if (isset($this->error['error_api'])) {
			$data['error_api'] = $this->error['error_api'];
		} else {
			$data['error_api'] = '';
		}

		if (isset($this->error['error_wallet_name'])) {
			$data['error_wallet_name'] = $this->error['error_wallet_name'];
		} else {
			$data['error_wallet_name'] = '';
		}

		if (isset($this->error['error_wallet_password'])) {
			$data['error_wallet_password'] = $this->error['error_wallet_password'];
		} else {
			$data['error_wallet_password'] = '';
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
			'href' => $this->url->link('extension/payment/blocktrail', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/blocktrail', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['blocktrail_api'])) {
			$data['blocktrail_api'] = $this->request->post['blocktrail_api'];
		} elseif ($this->config->get('blocktrail_api')) {
			$data['blocktrail_api'] = $this->config->get('blocktrail_api');
		} else {
			$data['blocktrail_api'] = '';
		}

		if (isset($this->request->post['blocktrail_api_secret'])) {
			$data['blocktrail_api_secret'] = $this->request->post['blocktrail_api_secret'];
		} elseif ($this->config->get('blocktrail_api_secret')) {
			$data['blocktrail_api_secret'] = $this->config->get('blocktrail_api_secret');
		} else {
			$data['blocktrail_api_secret'] = '';
		}

		if (isset($this->request->post['blocktrail_wallet_name'])) {
			$data['blocktrail_wallet_name'] = $this->request->post['blocktrail_wallet_name'];
		} elseif ($this->config->get('blocktrail_wallet_name')) {
			$data['blocktrail_wallet_name'] = $this->config->get('blocktrail_wallet_name');
		} else {
			$data['blocktrail_wallet_name'] = '';
		}

		if (isset($this->request->post['blocktrail_wallet_password'])) {
			$data['blocktrail_wallet_password'] = $this->request->post['blocktrail_wallet_password'];
		} elseif ($this->config->get('blocktrail_wallet_password')) {
			$data['blocktrail_wallet_password'] = $this->config->get('blocktrail_wallet_password');
		} else {
			$data['blocktrail_wallet_password'] = '';
		}


		if (isset($this->request->post['blocktrail_mode'])) {
			$data['blocktrail_mode'] = $this->request->post['blocktrail_mode'];
		} elseif ($this->config->get('blocktrail_mode')) {
			$data['blocktrail_mode'] = $this->config->get('blocktrail_mode');
		} else {
			$data['blocktrail_mode'] = '';
		}
                if (isset($this->request->post['blocktrail_status'])) {
			$data['blocktrail_status'] = $this->request->post['blocktrail_status'];
		} elseif ($this->config->get('blocktrail_status')) {
			$data['blocktrail_status'] = $this->config->get('blocktrail_status');
		} else {
			$data['blocktrail_status'] = '0';
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
                
		$this->response->setOutput($this->load->view('extension/payment/blocktrail', $data));
                
	}

	public function install() {
		$this->load->model('extension/payment/blocktrail');
		$this->load->model('extension/event');
		//$this->model_extension_payment_blocktrail->install();
		$this->model_extension_event->addEvent('blocktrail_capture', 'catalog/model/checkout/order/after', 'extension/payment/blocktrail/capture');
		$this->model_extension_event->addEvent('blocktrail_history_capture', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/payment/blocktrail/capture');
	}

	public function uninstall() {
		$this->load->model('extension/payment/blocktrail');
		$this->load->model('extension/event');
		//$this->model_extension_payment_block_chain->uninstall();
		$this->model_extension_event->deleteEvent('blocktrail_cature');
		$this->model_extension_event->deleteEvent('blocktrail_history_capture');
	}

	protected function validate() {
		$this->load->model('localisation/currency');

		if (!$this->user->hasPermission('modify', 'extension/payment/block_chain')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['blocktrail_api_secret']) {
			$this->error['error_api_secret'] = $this->language->get('error_api_secret');
		}

		if (!$this->request->post['blocktrail_api']) {
			$this->error['error_api_key'] = $this->language->get('error_api_key');
		}
		if (!$this->request->post['blocktrail_wallet_name']) {
			$this->error['error_wallet_name'] = $this->language->get('error_wallet_name');
		}
		if (!$this->request->post['blocktrail_wallet_password']) {
			$this->error['error_wallet_password'] = $this->language->get('error_wallet_password');
		}
		
		return !$this->error;
	}

}