<?php
class ModelDesignWg24Custommenu extends Model {
	public function addCategory($data) {
		 if (isset($data['module'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "wg24custommenu SET catparrent = '" . (int)$data['module']['catparrent'] . "',url = '" .  $this->db->escape($data['module']['url']) . "', status = '" .  $this->db->escape($data['module']['status']) . "'");
				$cate_id = $this->db->getLastId();
				foreach ($data['module_description'] as $language_id => $module_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "wg24custommenu_desc SET blog_cat_id = '" . (int)$cate_id . "',lang_id= '" . (int)$language_id . "', title = '" .  $this->db->escape($module_description['title']) . "'");
				}   
                                
		}

		
	}
        public function getAllCategory() {
		$query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24custommenu  as catname INNER JOIN  " . DB_PREFIX . "wg24custommenu_desc  as catdes  ON catname.blog_cat_id=catdes.blog_cat_id WHERE  catdes.lang_id = '" . (int)$this->config->get('config_language_id') . "'");
		 return $query->rows;
	}
       public function getByCategory($blog_cat_id) {
           $getbycategory=array();
		$singleecat= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24custommenu where blog_cat_id='".$blog_cat_id."'");
                     foreach ($singleecat->rows as $catid) {
                         $cate_description=array();
                    $singleecatdes= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24custommenu_desc where  blog_cat_id='".$blog_cat_id."' ");
                    
                    foreach ($singleecatdes->rows as $catdes) {
                    $cate_description[$catdes['lang_id']] = array('title' => $catdes['title']);   
                     } 
               $getbycategory[] = array(
                    'module_description' =>$cate_description,
                   'blog_cat_id'=> $catid['blog_cat_id'],
                    'catparrent'=> $catid['catparrent'],
                    'url'=> $catid['url'],
                   'status'=> $catid['status'],
            );
                    
                }
           return $getbycategory;        
	}
	public function editByCategory($blog_cat_id, $data) {
           
             if (isset($data['module'])) {
                        $this->db->query("UPDATE  " . DB_PREFIX . "wg24custommenu SET catparrent = '" . (int)$data['module']['catparrent'] . "',url = '" .  $this->db->escape($data['module']['url']) . "' where blog_cat_id='".$blog_cat_id."'");
                        foreach ($data['module_description'] as $language_id => $module_description) {
                            $this->db->query("UPDATE  " . DB_PREFIX . "wg24custommenu_desc SET title = '" .  $this->db->escape($module_description['title']) . "' where  lang_id='" . (int)$language_id . "' AND blog_cat_id = '" . (int)$blog_cat_id . "' ");
                        }   
                                
		}
	}
	public function deleteCategory($cate_del_id) {
                 $this->db->query("DELETE FROM " . DB_PREFIX . "wg24custommenu_desc WHERE blog_cat_id = '" . (int)$cate_del_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "wg24custommenu WHERE blog_cat_id = '" . (int)$cate_del_id . "'");
		
		
	}

      

	

	
}
