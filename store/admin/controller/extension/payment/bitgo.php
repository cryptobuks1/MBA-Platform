<?php
class ControllerExtensionPaymentBitgo extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('extension/payment/bitgo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$this->load->model('extension/payment/bitgo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bitgo', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['language_reload'])) {
				$this->response->redirect($this->url->link('payment/bitgo', 'token=' . $this->session->data['token'], true));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
                $data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_wallet_id'] = $this->language->get('entry_wallet_id');
		$data['entry_token'] = $this->language->get('entry_token');
		$data['entry_wallet_passphrase'] = $this->language->get('entry_wallet_passphrase');
		
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

		if (isset($this->error['error_wallet_id'])) {
			$data['error_wallet_id'] = $this->error['error_wallet_id'];
		} else {
			$data['error_wallet_id'] = '';
		}
		if (isset($this->error['error_token'])) {
			$data['error_token'] = $this->error['error_token'];
		} else {
			$data['error_token'] = '';
		}

		if (isset($this->error['error_wallet_id'])) {
			$data['error_wallet_id'] = $this->error['error_wallet_id'];
		} else {
			$data['error_wallet_id'] = '';
		}

		if (isset($this->error['error_token'])) {
			$data['error_token'] = $this->error['error_token'];
		} else {
			$data['error_token'] = '';
		}

		if (isset($this->error['error_wallet_passphrase'])) {
			$data['error_wallet_passphrase'] = $this->error['error_wallet_passphrase'];
		} else {
			$data['error_wallet_passphrase'] = '';
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
			'href' => $this->url->link('extension/payment/bitgo', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/bitgo', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['bitgo_wallet_id'])) {
			$data['bitgo_wallet_id'] = $this->request->post['bitgo_wallet_id'];
		} elseif ($this->config->get('bitgo_wallet_id')) {
			$data['bitgo_wallet_id'] = $this->config->get('bitgo_wallet_id');
		} else {
			$data['bitgo_wallet_id'] = '';
		}

		if (isset($this->request->post['bitgo_token'])) {
			$data['bitgo_token'] = $this->request->post['bitgo_token'];
		} elseif ($this->config->get('bitgo_token')) {
			$data['bitgo_token'] = $this->config->get('bitgo_token');
		} else {
			$data['bitgo_token'] = '';
		}

		if (isset($this->request->post['bitgo_wallet_passphrase'])) {
			$data['bitgo_wallet_passphrase'] = $this->request->post['bitgo_wallet_passphrase'];
		} elseif ($this->config->get('bitgo_wallet_passphrase')) {
			$data['bitgo_wallet_passphrase'] = $this->config->get('bitgo_wallet_passphrase');
		} else {
			$data['bitgo_wallet_passphrase'] = '';
		}

		if (isset($this->request->post['bitgo_mode'])) {
			$data['bitgo_mode'] = $this->request->post['bitgo_mode'];
		} elseif ($this->config->get('bitgo_mode')) {
			$data['bitgo_mode'] = $this->config->get('bitgo_mode');
		} else {
			$data['bitgo_mode'] = '';
		}
                if (isset($this->request->post['bitgo_status'])) {
			$data['bitgo_status'] = $this->request->post['bitgo_status'];
		} elseif ($this->config->get('bitgo_status')) {
			$data['bitgo_status'] = $this->config->get('bitgo_status');
		} else {
			$data['bitgo_status'] = '0';
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
                
		$this->response->setOutput($this->load->view('extension/payment/bitgo', $data));
                
	}

	public function install() {
		$this->load->model('extension/payment/bitgo');
		$this->load->model('extension/event');
		//$this->model_extension_payment_blocktrail->install();
		$this->model_extension_event->addEvent('bitgo_capture', 'catalog/model/checkout/order/after', 'extension/payment/bitgo/capture');
		$this->model_extension_event->addEvent('bitgo_history_capture', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/payment/bitgo/capture');
	}

	public function uninstall() {
		$this->load->model('extension/payment/bitgo');
		$this->load->model('extension/event');
		//$this->model_extension_payment_block_chain->uninstall();
		$this->model_extension_event->deleteEvent('blocktrail_cature');
		$this->model_extension_event->deleteEvent('blocktrail_history_capture');
	}

	protected function validate() {
		$this->load->model('localisation/currency');

		if (!$this->user->hasPermission('modify', 'extension/payment/bitgo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['bitgo_wallet_id']) {
			$this->error['error_wallet_id'] = $this->language->get('error_wallet_id');
		}

		if (!$this->request->post['bitgo_token']) {
			$this->error['error_token'] = $this->language->get('error_token');
		}
		if (!$this->request->post['bitgo_wallet_passphrase']) {
			$this->error['error_wallet_passphrase'] = $this->language->get('error_wallet_passphrase');
		}
		
		return !$this->error;
	}

}