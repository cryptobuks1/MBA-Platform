<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}
                
                  // options data
                    $save_value = array(
                    'wg24themeoptionpanel_t_category_prallax',
                    ); 
                    $lang=$this->config->get('config_language_id'); 
                    foreach ($save_value as $loadvalue) {  
                    if ($this->config->get($loadvalue.'_'.$lang)) {
                    $data[$loadvalue] = $this->config->get($loadvalue.'_'.$lang);
                    }else{
                    $data[$loadvalue] = $this->config->get($loadvalue);
                    } 
                    }
                $data['categories'] = array();
                $categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $category['category_id']
				);
			}
		}
                
                
                
                
                

		return $this->load->view('common/search', $data);
	}
        
        
        public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) ) {
			$this->load->model('catalog/product');
                        $this->load->model('tool/image');
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
                        if (isset($this->request->get['category_id'])) {
                        $category_id = $this->request->get['category_id'];
                        } else {
                        $category_id = 0;
                        }
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit =5;
			}
			$filter_data = array(
				'filter_name'=> $filter_name,
                                'filter_category_id'=> $category_id,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
                            
                                if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'],40,40);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png',40,40);
				}
                                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				
                                
                                
                                
                            
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                                        'thumb'       => $image,
					'price'       => $price,
					'special'     => $special,
                                       'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
        
}