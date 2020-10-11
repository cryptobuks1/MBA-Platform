<?php

class ControllerApiProduct extends Controller {

    public function index() {
        $this->load->language('api/product');
        $this->load->model('account/api');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/product');
            $this->load->model('catalog/review');
            if (isset($this->request->post['product_id'])) {

                $json['product_info'] = $this->model_catalog_product->getProduct($this->request->post['product_id']);
                $json['product_info']['image'] = ROOT_URL.'store/image/'.$json['product_info']['image'];
		$json['product_info']['special'] = $json['product_info']['special'] ? $json['product_info']['special'] : FALSE;
                $json['product_options'] = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
                
                if (isset($json['product_info'])) {
                    $results = $this->model_catalog_product->getProductImages($this->request->post['product_id']);
                    if($results){
                foreach($results as $result){
                    $result['image'] = ROOT_URL.'store/image/'.$result['image'];
                $json['product']['images'][] = $result;
                
                }
            }
            $other =  $this->model_catalog_product->getProductOtherDetails($this->request->post['product_id']);

            if($other){
                if ((float)$other['price']) {
                    $price = $this->tax->calculate($other['price'], $other['tax_class_id'], $this->config->get('config_tax'));
                } else {
                    $price = false;
                }
                if ((float)$other['special']) {
                    $special = $this->tax->calculate($other['special'], $other['tax_class_id'], $this->config->get('config_tax'));
                } else {
                    $special = false;
                }
                if ($this->config->get('config_tax')) {
                        $tax = (float)$other['special'] ? $other['special'] : $other['price'];
                } else {
                        $tax = false;
                }
                
                $other = array(
                'product_id'  => $other['product_id'],
                'name'        => $other['name'],
                'price'       => $price,
                'special'     => $special,
                'tax'         => $tax
                 );  
                 $json['other'] = $other;        

                    $result = $this->model_catalog_review->getReviewsByProductId($this->request->post['product_id'], 0, 5);
                    if ($result) {
                        $json['other']['reviews'] = $result;
                    } else {
                        $json['other']['reviews'] =array();
                    }
            }
            
            } else {
                $json['error']['product_info'] = $this->language->get('no_product');
                $json['status'] = FALSE;
            }
            }
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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

    public function getReviews() {
        $this->load->model('account/api');
        $this->load->language('api/product');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/review');
            if (isset($this->request->post['product_id']) && isset($this->request->post['start']) && isset($this->request->post['limit'])) {
                $result = $this->model_catalog_review->getReviewsByProductId($this->request->post['product_id'], $this->request->post['start'], $this->request->post['limit']);
                if ($result) {
                    $json['review'] = $result;
                } else {
                    $json['error']['empty'] = $this->language->get('no_more_reviews');
                    $json['status'] = FALSE;
                    $json['review'] = array();
                }
            } else {
                $json['error']['failed'] = $this->language->get('parameters_invalid');
                $json['status'] = FALSE;
            }
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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
    
    public function addReviews() {
        $this->load->model('account/api');
        $this->load->language('api/product');
        $this->load->language('product/product');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/review');
            if (isset($this->request->post['product_id'])) {
                
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

			

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');

				$this->model_catalog_review->addReview($this->request->post['product_id'], $this->request->post);

				
			}
		
            } else {
                $json['error']['failed'] = $this->language->get('parameters_invalid');
                $json['status'] = FALSE;
            }
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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

    public function getCategoryProducts() {
        $this->load->model('account/api');
        $this->load->language('api/product');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);

        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/product');

            if (isset($this->request->post['filter'])) {
                $filter = $this->request->post['filter'];
            } else {
                $filter = '';
            }
            
            if (isset($this->request->post['category_id'])) {
                $category_id = $this->request->post['category_id'];
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
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => $page,
				'limit'              => $limit
			);

            $results = $this->model_catalog_product->getProducts($filter_data);
            
            if($results){
                foreach($results as $result){
                    $result['image'] = ROOT_URL.'store/image/'.$result['image'];
                $json['products'][] = $result;
                
                }
            }
            else{
                 $json['products'] = array();
            }                 
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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
    
    public function getProductOptions() {
        $this->load->model('account/api');
        $this->load->language('api/product');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
            $json['status'] = TRUE;
            $this->load->model('catalog/product');
            if (isset($this->request->post['product_id'])) {
                $result = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
                if ($result) {
                    $json['product_options'] = $result;
                } else {
                    $json['error']['empty'] = $this->language->get('no_more_reviews');
                    $json['status'] = FALSE;
                    $json['product_options'] = array();
                }
            } else {
                $json['error']['failed'] = $this->language->get('parameters_invalid');
                $json['status'] = FALSE;
            }
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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
    
    public function productSearch() {
        $this->load->model('account/api');
        $this->load->language('api/product');
        $api_info = $this->model_account_api->getApiByKey($this->request->post['key']);
        $json = array();
        if ($api_info) {
        	$this->load->language('product/search');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
            $json['status'] = TRUE;
            $this->load->model('catalog/product');
            if (isset($this->request->post['search'])) {
                
                if (isset($this->request->post['search'])) {
			$search = $this->request->post['search'];
		} else {
			$search = '';
		}

		if (isset($this->request->post['tag'])) {
			$tag = $this->request->post['tag'];
		} elseif (isset($this->request->post['search'])) {
			$tag = $this->request->post['search'];
		} else {
			$tag = '';
		}

		if (isset($this->request->post['description'])) {
			$description = $this->request->post['description'];
		} else {
			$description = '';
		}

		if (isset($this->request->post['category_id'])) {
			$category_id = $this->request->post['category_id'];
		} else {
			$category_id = 0;
		}

		if (isset($this->request->post['sub_category'])) {
			$sub_category = $this->request->post['sub_category'];
		} else {
			$sub_category = '';
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

		if (isset($this->request->post['page'])) {
			$page = $this->request->post['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->post['limit'])) {
			$limit = (int)$this->request->post['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

				

		$url = '';

		if (isset($this->request->post['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->post['search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->post['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->post['tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->post['description'])) {
			$url .= '&description=' . $this->request->post['description'];
		}

		if (isset($this->request->post['category_id'])) {
			$url .= '&category_id=' . $this->request->post['category_id'];
		}

		if (isset($this->request->post['sub_category'])) {
			$url .= '&sub_category=' . $this->request->post['sub_category'];
		}

		if (isset($this->request->post['sort'])) {
			$url .= '&sort=' . $this->request->post['sort'];
		}

		if (isset($this->request->post['order'])) {
			$url .= '&order=' . $this->request->post['order'];
		}

		if (isset($this->request->post['page'])) {
			$url .= '&page=' . $this->request->post['page'];
		}

		if (isset($this->request->post['limit'])) {
			$url .= '&limit=' . $this->request->post['limit'];
		}
		
		$filter_data = array(
				'filter_name'         => $search,
				'filter_tag'          => $tag,
				'filter_description'  => $description,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => $sub_category,
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);
			if($results){
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price =$this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = (float)$result['special'] ? $result['special'] : $result['price'];
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				$cat = $this->model_catalog_product->getCategories($result['product_id']);
				
				$cat_id =isset($cat[1]['category_id']) ? $cat[1]['category_id'] : $cat[0]['category_id'];
				$categories_r =	$this->model_catalog_category->getCategory($cat_id);
				if(isset($categories_r['name']))
				$name = $categories_r['name'];
				else
				$name = '';
				
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'category'    => $name,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url),
                                     'quickview'        => $this->url->link('product/product/quickview', 'product_id=' . $result['product_id'] . $url)
				);
				
			}
			
			foreach($data['products'] as $p)
				$json['products'][] = $p;
			$json['status'] = TRUE;
			}
			else{
			$json['products'] = array();
			$json['status'] = TRUE;
			
			}
		
            } else {
                $json['error']['failed'] = $this->language->get('parameters_invalid');
                $json['status'] = FALSE;
            }
        } else {
            $json['error']['key'] = $this->language->get('error_key');
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

}