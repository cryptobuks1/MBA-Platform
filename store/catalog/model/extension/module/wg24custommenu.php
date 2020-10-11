<?php
class ModelExtensionModuleWg24Custommenu extends Model {

        
         public function getAllCategory($parrent_id) {
           $this->table = DB_PREFIX . 'wg24custommenu';
        $sql = "SELECT `TABLE_NAME`
                        FROM information_schema.tables
                        WHERE table_schema = '".DB_DATABASE."'  AND table_name = '{$this->table}'";

        $check_table = $this->db->query($sql);
        // Check the table is exist or not
        if (isset($check_table->row['TABLE_NAME']))
        {
            $query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "wg24custommenu  as catname INNER JOIN  " . DB_PREFIX . "wg24custommenu_desc  as catdes  ON catname.blog_cat_id=catdes.blog_cat_id WHERE catname.catparrent='".$parrent_id."' and  status=1 and catdes.lang_id = '" . (int)$this->config->get('config_language_id') . "'   ");
		 return $query->rows; 
                 
        }
                 
	}
        

}
