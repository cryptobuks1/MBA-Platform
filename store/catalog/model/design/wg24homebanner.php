<?php
class ModelDesignWg24HomeBanner extends Model {
    
    public function getTopRated($settings) {		
		
		$limit = $settings;		
		$product_data = array();
		
		if(!isset($limit) || $limit<0) return $product_data;
		
		$cachestring = 'product.toprated' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.L' . (int)$limit;
				
		$product_data = $this->cache->get($cachestring);
		
		if (!$product_data) {
			$product_data = array();

			$sql = "SELECT r.product_id, AVG(r.rating) as TotalRating FROM ";
			$sql = $sql . " " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id=p.product_id) ";
			$sql = $sql . " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
			$sql = $sql . " WHERE r.`status` = '1' AND p.`status` = '1' AND p.date_available <= NOW() ";
			$sql = $sql . " AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			$sql = $sql . " GROUP BY r.product_id ORDER BY TotalRating DESC LIMIT " . (int)$limit;
			
			$query = $this->db->query($sql);			
			
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
			}
			
			$this->cache->set($cachestring, $product_data);				
		}

		return $product_data;
	}
    
    
    
    
    
    
	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner b LEFT JOIN " . DB_PREFIX . "banner_image bi ON (b.banner_id = bi.banner_id) WHERE b.banner_id = '" . (int)$banner_id . "' AND b.status = '1' AND bi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");
		return $query->rows;
	}
        
        public function getBannerImages($banner_id) {
		$banner_image_data = array();

		$banner_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "wg24allhomebanner_image WHERE banner_id = '" . (int)$banner_id . "' ORDER BY sort_order ASC");

		foreach ($banner_image_query->rows as $banner_image) {
			$banner_image_description_data = array();
                      
			$banner_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "wg24allhomebanner_image_description WHERE banner_image_id = '" . (int)$banner_image['banner_image_id'] . "' AND banner_id = '" . (int)$banner_id . "' ");

			foreach ($banner_image_description_query->rows as $banner_image_description) {
				$banner_image_description_data = array('title' => $banner_image_description['title'],'desce' => $banner_image_description['desce']);     
                        }

			$banner_image_data[] = array(
				'description' => $banner_image_description_data,
				'link'                     => $banner_image['link'],
				'image'                    => $banner_image['image'],
				'sort_order'               => $banner_image['sort_order']
			);
		}

		return $banner_image_data;
	}
        
        
}
