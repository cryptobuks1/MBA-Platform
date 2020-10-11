<?php
class ModelDesignWg24Blog extends Model {
	public function addCategory($data) {
		 if (isset($data['module'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogcategory SET catparrent = '" . (int)$data['module']['catparrent'] . "',catpic = '" .  $this->db->escape($data['module']['catpic']) . "',mtitle = '" .  $this->db->escape($data['module']['mtitle']) . "',mkeyword = '" .  $this->db->escape($data['module']['mkeyword']) . "',mdesc = '" .  $this->db->escape($data['module']['mdesc']) . "', status = '" .  $this->db->escape($data['module']['status']) . "'");
				$cate_id = $this->db->getLastId();
				foreach ($data['module_description'] as $language_id => $module_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogcate_desc SET blog_cat_id = '" . (int)$cate_id . "',lang_id= '" . (int)$language_id . "', title = '" .  $this->db->escape($module_description['title']) . "',description = '" .  $this->db->escape($module_description['description']) ."'");
				}   
                                
		}

		
	}
        public function getAllCategory() {
		$query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogcategory  as catname INNER JOIN  " . DB_PREFIX . "wg24blogcate_desc  as catdes  ON catname.blog_cat_id=catdes.blog_cat_id WHERE  catdes.lang_id = '" . (int)$this->config->get('config_language_id') . "'");
		 return $query->rows;
	}
       public function getByCategory($blog_cat_id) {
           $getbycategory=array();
		$singleecat= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogcategory where blog_cat_id='".$blog_cat_id."'");
                     foreach ($singleecat->rows as $catid) {
                         $cate_description=array();
                    $singleecatdes= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogcate_desc where  blog_cat_id='".$blog_cat_id."' ");
                    
                    foreach ($singleecatdes->rows as $catdes) {
                    $cate_description[$catdes['lang_id']] = array('title' => $catdes['title'],'description' => $catdes['description']);   
                     } 
               $getbycategory[] = array(
                    'module_description' =>$cate_description,
                   'blog_cat_id'=> $catid['blog_cat_id'],
                    'catparrent'=> $catid['catparrent'],
                    'catpic'=> $catid['catpic'],
                    'mtitle'=> $catid['mtitle'],
                    'mkeyword'=> $catid['mkeyword'],
                    'mdesc'=> $catid['mdesc'],
                   'status'=> $catid['status'],
            );
                    
                }
           return $getbycategory;        
	}
	public function editByCategory($blog_cat_id, $data) {
           
             if (isset($data['module'])) {
                        $this->db->query("UPDATE  " . DB_PREFIX . "wg24blogcategory SET catparrent = '" . (int)$data['module']['catparrent'] . "',catpic = '" .  $this->db->escape($data['module']['catpic']) . "',mtitle = '" .  $this->db->escape($data['module']['mtitle']) . "',mkeyword = '" .  $this->db->escape($data['module']['mkeyword']) . "',mdesc = '" .  $this->db->escape($data['module']['mdesc']) . "', status = '" .  $this->db->escape($data['module']['status']) . "' where blog_cat_id='".$blog_cat_id."'");
                        foreach ($data['module_description'] as $language_id => $module_description) {
                            $this->db->query("UPDATE  " . DB_PREFIX . "wg24blogcate_desc SET title = '" .  $this->db->escape($module_description['title']) . "',description = '" .  $this->db->escape($module_description['description']) ."' where  lang_id='" . (int)$language_id . "' AND blog_cat_id = '" . (int)$blog_cat_id . "' ");
                        }   
                                
		}
	}
	public function deleteCategory($cate_del_id) {
                 $this->db->query("DELETE FROM " . DB_PREFIX . "wg24blogcate_desc WHERE blog_cat_id = '" . (int)$cate_del_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "wg24blogcategory WHERE blog_cat_id = '" . (int)$cate_del_id . "'");
		
		
	}
        public function getCategoriesAutocomplete($data = array()) {
		$sql = "SELECT c.blog_cat_id , title  FROM " . DB_PREFIX . "wg24blogcategory AS c LEFT JOIN " . DB_PREFIX . "wg24blogcate_desc AS cd ON c.blog_cat_id = cd.blog_cat_id WHERE cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cd.blog_cat_id";

		$sort_data = array(
			'title',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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
        
        public function addBlogpost($data,$store=0) {
            $this->load->model('user/user');
      $user_info = $this->model_user_user->getUser($this->user->getId());
      $adminuser= $user_info['username'];
		 if (isset($data['module'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogpost_image SET tags = '" . $this->db->escape($data['module']['tags']) . "',image = '" .  $this->db->escape($data['module']['image']) . "',video = '" .  $this->db->escape($data['module']['video']) . "',store = '" .$store. "', status = '" .  $this->db->escape($data['module']['status']) . "',postadmin = '" .$adminuser. "'");
				$imageid_id = $this->db->getLastId();
				foreach ($data['module_description'] as $language_id => $module_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogpost_image_des SET  title= '" .  $this->db->escape($module_description['title']) . "',description = '" .  $this->db->escape($module_description['description']) ."',contents = '" .  $this->db->escape($module_description['contents']) ."',metatitle = '" .  $this->db->escape($module_description['metatitle']) ."',metakeyword = '" .  $this->db->escape($module_description['metakeyword']) ."',metadesc = '" .  $this->db->escape($module_description['metadesc']) ."',blogpost_img_id = '" . (int)$imageid_id . "',language_id= '" . (int)$language_id . "'");
				}  
                                foreach ($data['product_category'] as $category_id) {
					 $this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogpost_img_cat SET  blogpost_img_id= '" .(int)$imageid_id. "',blogcate_id= '" . (int)$category_id . "'");
				} 
                                
		}

		
	}
        public function editByBlogPost($blog_id,$data,$store=0) {
            $this->load->model('user/user');
      $user_info = $this->model_user_user->getUser($this->user->getId());
      $adminuser= $user_info['username'];
		 if (isset($data['module'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "wg24blogpost_image SET tags = '" . $this->db->escape($data['module']['tags']) . "',image = '" .  $this->db->escape($data['module']['image']) . "',video = '" .  $this->db->escape($data['module']['video']) . "',store = '" .$store. "', status = '" .  $this->db->escape($data['module']['status']) . "',postadmin = '" .$adminuser. "' where blogpost_img_id='".$blog_id."'");
				foreach ($data['module_description'] as $language_id => $module_description) {
					$this->db->query("UPDATE " . DB_PREFIX . "wg24blogpost_image_des SET  title= '" .  $this->db->escape($module_description['title']) . "',description = '" .  $this->db->escape($module_description['description']) ."',contents = '" .  $this->db->escape($module_description['contents']) ."',metatitle = '" .  $this->db->escape($module_description['metatitle']) ."',metakeyword = '" .  $this->db->escape($module_description['metakeyword']) ."',metadesc = '" .  $this->db->escape($module_description['metadesc']) ."' where language_id= '" . (int)$language_id . "' and  blogpost_img_id='".$blog_id."'");
				}  
                                 $this->db->query("DELETE FROM " . DB_PREFIX . "wg24blogpost_img_cat WHERE blogpost_img_id = '" . (int)$blog_id . "'");
                                foreach ($data['product_category'] as $category_id) {
					 $this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogpost_img_cat SET blogpost_img_id= '" .(int)$blog_id. "',blogcate_id= '" . (int)$category_id . "' ");
				} 
                                
		}

		
	} 
        
        
        
        
        
        
        
        public function getBlogPost($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		$sql .= " GROUP BY p.blogpost_img_id";
		$sort_data = array(
			'pd.title',
			'p.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.title";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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
        
       
        
        public function  getTotalBlogPost($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.blogpost_img_id) AS total FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
         public function deleteBlogPost($post_del_id) {
                 $this->db->query("DELETE FROM " . DB_PREFIX . "wg24blogpost_img_cat WHERE blogpost_img_id = '" . (int)$post_del_id . "'");
                 $this->db->query("DELETE FROM " . DB_PREFIX . "wg24blogpost_image_des WHERE blogpost_img_id = '" . (int)$post_del_id . "'");
                 $this->db->query("DELETE FROM " . DB_PREFIX . "wg24blogpost_image WHERE blogpost_img_id = '" . (int)$post_del_id . "'");
		
		
		
	}
         public function getBlogAutocomplete($data = array()) {
		$sql = "SELECT p.blogpost_img_id , title  FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY pd.blogpost_img_id";

		$sort_data = array(
			'title',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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
          public function getByBlogPost($blogpost_img_id) {
           $getbypost=array();
		$singlepost= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogpost_image where blogpost_img_id='".$blogpost_img_id."'");
                     foreach ($singlepost->rows as $infopost) {
                     $post_description=array();
                    $post_description1= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogpost_image_des where  blogpost_img_id='".$blogpost_img_id."' ");
                    foreach ($post_description1->rows as $postdes) {
                    $post_description[$postdes['language_id']] = array('title' => $postdes['title'],'description' => $postdes['description'],'contents' => $postdes['contents'],'metatitle' => $postdes['metatitle'],'metakeyword' => $postdes['metakeyword'],'metadesc' => $postdes['metadesc']);   
                     } 
                    $showcat= $this->db->query("SELECT blogcate_id FROM  " . DB_PREFIX . "wg24blogpost_img_cat where blogpost_img_id='".$blogpost_img_id."'"); 
                    $showcat1= $showcat->rows;
                    $getbypost[] = array(
                    'module_description' =>$post_description,
                   'blogpost_img_id'=> $infopost['blogpost_img_id'],
                    'blogcate_id'=> $showcat1,
                    'tags'=> $infopost['tags'],
                    'image'=> $infopost['image'],
                    'video'=> $infopost['video'],
                    'status'=> $infopost['status'],
            );
               
             
  
                }
           return $getbypost;        
	}
        
      

	

	
}
