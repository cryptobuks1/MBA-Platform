<?php

class ControllerApiHome extends Controller {

    public function index() {
        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/category');
            $this->load->model('catalog/product');
            $this->load->model('tool/image');
            $data['categories'] = array();
            $categories = $this->model_catalog_category->getCategories(0);       
            foreach ($categories as $category) {
                if ($category['top']) {
                    // Level 2
                    $children_data = array();
                    $children = $this->model_catalog_category->getCategories($category['category_id']);

                    foreach ($children as $child) {
                        $children_data3 = array();
                        $children3 = $this->model_catalog_category->getCategories($child['category_id']);

                        foreach ($children3 as $child3) {
                            $filter_data3 = array(
                                'filter_category_id' => $child3['category_id'],
                                'filter_sub_category' => true
                            );

                            $children_data3[] = array(
                                'name' => $child3['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data3) . ')' : ''),
                                'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child3['category_id']),
                                'category_id' => $child3['category_id'],
                             // 'top_picks'=>$this->getCategoryPopProducts($category['category_id']),
                                'top_picks'=> array(),
                            );
                        }

                        $filter_data = array(
                            'filter_category_id' => $child['category_id'],
                            'filter_sub_category' => true
                        );

                        $children_data[] = array(
                            'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                            'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']),
                            'children' => $children_data3,
                            'category_id' => $child['category_id'],
                         // 'top_picks'=>$this->getCategoryPopProducts($category['category_id']),
                            'top_picks'=> array(),
                        );
                    }

                    // Level 1
                    $data['categories'][] = array(
                        'name' => $category['name'],
                        'children' => $children_data,
                        'column' => $category['column'] ? $category['column'] : 1,
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id']),
                        'category_id' =>$category['category_id'],
                        'top_picks'=>$this->getCategoryPopProducts($category['category_id']),
                      //  'top_picks'=> array(),
                    );
                }
            }
          
            $filter_new = array(
                'sort' => 'p.date_added',
                'order' => 'DESC',
                'start' => 0,
                'limit' => $this->config->get('wg24themeoptionpanel_newproductlimit_prallax')
            );
            $this->load->model('catalog/product');

            $newproducts = $this->model_catalog_product->getProducts($filter_new);

            if ($newproducts) {
                if ($newproducts) {
                    foreach ($newproducts as $result) {
                        
                        if ((float) $result['special']) {
                            $special = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                        } else {
                            $special = false;
                        }
                        $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));

                        $data['featured'][] = array(
                            'product_id' => $result['product_id'],
                            'price' => $result['price'],
                            'pair_value' => $result['pair_value'],
                            'special' => $special,
                            'name' => $result['name'],
                            'image' => $image,
                        );
                    }
                }

                //popular products
                $this->load->model('tool/image');
                $results = $this->model_catalog_product->getPopularProducts(5);

                foreach ($results as $result) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], 270, 270);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', 270, 270);
                    }

                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        $price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                    } else {
                        $price = false;
                    }

                    if ((float) $result['special']) {
                        $special = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                    } else {
                        $special = false;
                    }

                    if ($this->config->get('config_tax')) {
                        $tax = (float) $result['special'] ? $result['special'] : $result['price'];
                    } else {
                        $tax = false;
                    }

                    if ($this->config->get('config_review_status')) {
                        $rating = (int) $result['rating'];
                    } else {
                        $rating = false;
                    }

                    $data['pproducts'][] = array(
                        'product_id' => $result['product_id'],
                        'image' => $image,
                        'name' => $result['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                        'price' => $price,
                        'special' => $special,
                        'tax' => $tax,
                        'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                        'rating' => $result['rating'],
                        'href' => $this->url->link('product/product', 'product_id=' . $result['product_id']),
                        'quickview' => $this->url->link('product/product/quickview', 'product_id=' . $result['product_id'])
                    );
                }
                
                //banner
                $results_bannr = array();
                $this->load->model('design/wg24homebanner');
                $this->load->model('extension/module');
                
                $setting = $this->model_extension_module->getModule(32);

                $results_bannr = $this->model_design_wg24homebanner->getBannerImages($setting['banner_id']);
                foreach ($results_bannr as $result) {
                    if (is_file(DIR_IMAGE . $result['image'])) {

                        $data['banners'][] = array(
                            'description' => $result['description'],
                            'link' => $result['link'],
                            'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
                        );
                    }
                } 
                //brands
                $setting = $this->model_extension_module->getModule(29);
		$this->load->model('design/banner');
		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['brands'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		} 
                
                $json = $data;
            } else {
                $json['categories'] = array();
            }		
            $offers = array();
            $dir = ROOT_DIR . 'image/catalog/24wgdemo/cat-banner/';
            $files = scandir($dir);
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getCategoryPopProducts($category_id) {
        $this->load->model('account/api');
        $this->load->language('api/product');

        $this->load->model('catalog/product');
        if (isset($this->request->post['filter'])) {
            $filter = $this->request->post['filter'];
        } else {
            $filter = '';
        }

        if (isset($category_id)) {
            $category_id = $category_id;
        }

        if (isset($this->request->post['sort'])) {
            $sort = $this->request->post['sort'];
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->post['order'])) {
            $order = $this->request->post['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->post['offset'])) {
            $page = $this->request->post['offset'];
        } else {
            $page = 1;
        }

        if (isset($this->request->post['limit'])) {
            $limit = (int) $this->request->post['limit'];
        } else {
            $limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
        }

        $filter_data = array(
            'filter_category_id' => $category_id,
            'filter_filter' => $filter,
            'sort' => $sort,
            'order' => $order,
            'start' => $page,
            'limit' => $limit
        );

        $results = $this->model_catalog_product->getCategoryToppicks($filter_data);
        $r = array();
        foreach ($results as $res) {
            $res['image'] = ROOT_URL . 'store/image/' . $res['image'];
            $r[] = $res;
        }
        return $r;
    }

    public function get_product_by_category() {

        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('register/data');
            $json["status"] = true;
            $base_url = $this->config->get('config_url');
            $post_array = $this->request->post;
            if (!isset($post_array['category_id']) || $post_array['category_id'] == '') {
                $json['status'] = false;
                $json['message'] = 'category_id is required';
            } else {
                $json['data'] = $this->model_register_data->getProductByCategory($base_url, $post_array['category_id']);
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_product_by_keyword() {

        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('register/data');
            $json["status"] = true;
            $base_url = $this->config->get('config_url');
            $post_array = $this->request->post;
            if (!isset($post_array['keyword']) || $post_array['keyword'] == '') {
                $json['status'] = false;
                $json['message'] = 'Keyword is required';
            } else {
                $json['data'] = $this->model_register_data->getProductByKeyword($base_url, $post_array['keyword']);
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_product_by_id() {

        $this->load->model('account/api');
        $this->load->language('api/home');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $this->load->model('register/data');
            $json["status"] = true;
            $base_url = $this->config->get('config_url');
            $post_array = $this->request->post;
            if (!isset($post_array['product_id']) || $post_array['product_id'] == '') {
                $json['status'] = false;
                $json['message'] = 'product_id is required';
            } else {
                $json['data'] = $this->model_register_data->getProductById($base_url, $post_array['product_id']);
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
            $json['status'] = FALSE;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
