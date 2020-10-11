<?php
class ModelExtensionModuleWg24blog extends Model {

        
         public function getAllCategory($parrent_id) {
		$query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogcategory  as catname INNER JOIN  " . DB_PREFIX . "wg24blogcate_desc  as catdes  ON catname.blog_cat_id=catdes.blog_cat_id WHERE catname.catparrent='".$parrent_id."' and catdes.lang_id = '" . (int)$this->config->get('config_language_id') . "'");
		 return $query->rows;
	}
         public function getByCategory($cate_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM  " . DB_PREFIX . "wg24blogcategory  as catname INNER JOIN  " . DB_PREFIX . "wg24blogcate_desc  as catdes  ON catname.blog_cat_id=catdes.blog_cat_id WHERE catname.blog_cat_id='".$cate_id."' and catdes.lang_id = '" . (int)$this->config->get('config_language_id') . "'");
		 return $query->row;
	}

	
        
        
            public function getBlogPost($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id)";
		if (!empty($data['filter_category_id'])) {
                        $sql .= " LEFT JOIN " . DB_PREFIX . "wg24blogpost_img_cat icat ON (icat.blogpost_img_id = p.blogpost_img_id)";
                }
                $sql .= "WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND status=1";

                if (!empty($data['filter_name'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
                if (!empty($data['filter_category_id'])) {
                        $sql .= " AND icat.blogcate_id = '" . (int)$data['filter_category_id'] . "'";
                }
                
                $sort_data = array(
			'pd.title'
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
        
       
        
        public function  getTotalBlogPost($data) {
		$sql = "SELECT COUNT(DISTINCT p.blogpost_img_id) AS total FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id)";
                if (!empty($data['filter_category_id'])) {
                        $sql .= " LEFT JOIN " . DB_PREFIX . "wg24blogpost_img_cat icat ON (icat.blogpost_img_id = p.blogpost_img_id)";
                }
                $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
                $sql .= " AND p.status =1";
                if (!empty($data['filter_category_id'])) {
                        $sql .= " AND icat.blogcate_id = '" . (int)$data['filter_category_id'] . "'";
                }
              if (!empty($data['filter_name'])) {
			$sql .= " AND pd.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
                
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
         public function getByBlogPost($blogpost_img_id) {
           $getbypost=array();
		$singlepost= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogpost_image where blogpost_img_id='".$blogpost_img_id."'");
                     foreach ($singlepost->rows as $infopost) {
                     $post_description=array();
                    $post_description1= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogpost_image_des where  blogpost_img_id='".$blogpost_img_id."' and language_id = '" . (int)$this->config->get('config_language_id') . "'");
                    foreach ($post_description1->rows as $postdes) {
                    $post_description = array('title' => $postdes['title'],'description' => $postdes['description'],'contents' => $postdes['contents'],'metatitle' => $postdes['metatitle'],'metakeyword' => $postdes['metakeyword'],'metadesc' => $postdes['metadesc']);   
                     } 
                   
                    $getbypost[] = array(
                    'module_description' =>$post_description,
                   'blogpost_img_id'=> $infopost['blogpost_img_id'],
                    'tags'=> $infopost['tags'],     
                    'tags'=> $infopost['tags'],
                    'image'=> $infopost['image'],
                    'video'=> $infopost['video'],
                    'adddate'=> $infopost['adddate'],
                        'totalcomment'=> $infopost['totalcomment'],
                     'postadmin'=> $infopost['postadmin']     
            );
               
             
  
                }
           return $getbypost;        
	}
        
        public function cuntTotalComment($data) {
             if (isset($data)) {
                 $count=$this->db->query("SELECT COUNT(post_id) AS total FROM " . DB_PREFIX . "wg24blogcomment where post_id='".$data."'");
               $total=$count->rows;
               foreach($total as $commentcount){
            $showcomment=$commentcount['total'];
               }
                 $this->db->query("UPDATE  ".DB_PREFIX . "wg24blogpost_image SET totalcomment= '" . (int)$showcomment . "' where blogpost_img_id='".$data."'");            
		}
	}
        
        
	public function getLatestPost($limit) {
            $sql = "SELECT p.blogpost_img_id,p.image,p.totalcomment,p.adddate,pd.title FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id)";
            $sql .= "WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND status='1' ORDER BY p.adddate DESC LIMIT " .(int)$limit;
            $query = $this->db->query($sql);
            return $query->rows;
	}

	public function getRecentBlogComment($limit) {
             $sql = "SELECT p.blogpost_img_id,pd.title,pc.name,pc.user_pic,pc.comment FROM " . DB_PREFIX . "wg24blogpost_image p LEFT JOIN " . DB_PREFIX . "wg24blogpost_image_des pd ON (p.blogpost_img_id = pd.blogpost_img_id)";
             $sql .= " LEFT JOIN " . DB_PREFIX . "wg24blogcomment pc ON (pc.post_id = p.blogpost_img_id)";  
            $sql .= "WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pc.status='1' ORDER BY pc.comment_id DESC LIMIT " .(int)$limit;
            $query = $this->db->query($sql);
            return $query->rows;
	}

	
        public function addComments($data) {
	if (isset($data)) {
            if($data['commentpic']!=''):
                $avotor=$data['commentpic'];
            else:
                 $avotor=HTTPS_SERVER.'/image/no_image.png';
            endif;
		$this->db->query("INSERT INTO " . DB_PREFIX . "wg24blogcomment SET post_id = '".(int)$data['blogpost_img_id']."',parrent_id = '" . (int)$data['parrent_id']."',user_id = '0',user_pic = '$avotor',name = '".$this->db->escape($data['commentauthor'])."',email= '".$this->db->escape($data['commentemail'])."',comment= '".$this->db->escape($data['commenttext'])."',status = '1'");           
	}	
	}
       public function getAllComment($parrent,$postid,$comstataus) {
	   $allcomment= $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24blogcomment where parrent_id='".$parrent."' and post_id='".$postid."' and status='".$comstataus."' ORDER BY comment_id DESC");
           return $allcomment->rows;        
	}  
        
        
        
        
        
        
        
        
}
