<?php
// Video Codes by --Aiswarya
Class video_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function addMovie($video_filename, $package,$video_type, $title, $link,$description,$sort_order) {
       
        //$movie_name = $files['video']['name'];
        // if($files['poster']['name'] != ""){
        // $poster_name = $files['poster']['name'];
        // }
        $jsoned_packages = json_encode($package);
        
        $this->db->set('title',$title);
        $this->db->set('video_name',$video_filename);
        $this->db->set('video_link', $link);
        //$this->db->set('poster_name',$poster_name);
        $this->db->set('video_type',$video_type);
        $this->db->set('module_id',$package['0']);
        $this->db->set('video_description',$description);
        $this->db->set('sort_order',$sort_order);
        $this->db->insert('video_settings');
        

    }
    

    public function addSuccessforMovie($link) {
        $this->db->set('status','yes');
        $this->db->where('video_link', $link);
        $this->db->update('video_settings');
    }
    public function getMovies($module_id = '') {

        $string = '"'.$module_id.'"';
        $this->db->select('vs.*');
        $this->db->from('video_settings as vs');
        $this->db->where('vs.delete_status', 'no');
        
        //new change
        $this->db->join('video_sort_order as vso', 'vs.id=vso.video_id','INNER');
        
        if($module_id != ''){
            $this->db->like('vs.module_id',$string,'both');
        }
        $this->db->order_by("vso.sort_order", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getModules($video_id){
        $this->db->select('module_id');
        $this->db->from('video_settings');
        $this->db->where('delete_status', 'no');
        $this->db->where('id',$video_id);
        $query = $this->db->get();
        $module_list = $query->row()->module_id;
        return json_decode($module_list);
        
    }

    
    public function getVideoInfo($video_id) {
        $this->db->select('*');
        $this->db->from('video_settings');
        $this->db->where('id',$video_id);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    public function getModuleName($module_id) {
        $this->db->select('video_module_name');
        $this->db->from('2313_video_module_settings');
        $this->db->where('video_module_id',$module_id);
        $query  = $this->db->get();
        $result = $query->row();
        return $result->video_module_name;
    }
    
    public function getAllVideo(){
        $this->db->select('vms.video_module_id');
        $this->db->from('video_module_settings as vms');
        $query = $this->db->get();
        //print_r($query->result_array());die;
        
        $this->db->select('vs.*, vms.video_module_idPrimary');
        $this->db->from('video_settings vs');
        $this->db->where('vs.delete_status', 'no');
        ///$this->db->join('video_module_settings as vms', '')
        //$this->db->where('id',$video_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function insertIntoSortOrder($modules){
        foreach( $modules as $row){
            $movies  =  $this->getMovies($row['module_id']);
            $i = 1;
            foreach($movies as $mv){
                echo "video id ::". $mv['id']."<br>";
                echo "module_id  ::". $row['module_id']."<br>";
                echo "sort order  ::". $i."<br>";
                
                $this->db->set('video_id ',$mv['id']);
                $this->db->set('module_id ',$row['module_id']);
                $this->db->set('sort_order ',$i);
                $this->db->insert('video_sort_order');
                $i++;
            }
            
        }
        die;
    }
    
    public function getMoviesBySortOrder($module_id = ''){
        $string = '"'.$module_id.'"';
        $this->db->select('vs.*, vso.sort_order,vso.module_id');
        $this->db->from('video_settings as vs');
        $this->db->where('vs.delete_status', 'no');
        $this->db->join('video_sort_order as vso', 'vs.id=vso.video_id','INNER');
        if($module_id != ''){
            //$this->db->like('vs.module_id',$string,'both');
            $this->db->where('vso.module_id',$module_id);
        }
        $query  =   $this->db->get();
        return $query->result_array();
    }
    
    public function UpdateSortOrder($edit_id, $module_id, $video_id, $sort_order){
        
        $this->db->trans_begin();
        
        $this->db->set('sort_order', $edit_id);
        $this->db->where('module_id', $module_id);
        $this->db->where('sort_order', $sort_order);
        $second = $this->db->update('video_sort_order');
        
        $this->db->set('sort_order', $sort_order);
        $this->db->where('video_id', $video_id);
        $this->db->where('module_id', $module_id);
        $first  =  $this->db->update('video_sort_order');
        
        if($first && $second){
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }
    //toppick configuration by neenu
    public function getMoviesByToppick($module_id = ''){
        $details=array();
        $string = '"'.$module_id.'"';
        $this->db->select('vs.*, vso.sort_order,vso.module_id');
        $this->db->from('video_settings as vs');
         $this->db->where('vs.delete_status', 'no');
        $this->db->join('video_sort_order as vso', 'vs.id=vso.video_id','INNER');
        if($module_id != ''){
            //$this->db->like('vs.module_id',$string,'both');
            $this->db->where('vso.module_id',$module_id);
        }
        $query  =   $this->db->get();
        $i=0;
         foreach ($query->result() as $row) { 
             $details[$i]['id']=$row->id;
             $details[$i]['title']=$row->title;
             $details[$i]['video_name']=$row->video_name;
             $details[$i]['video_link']=$row->video_link;
             $details[$i]['poster_name']=$row->poster_name;
             $details[$i]['module_id']=$row->module_id;
             $details[$i]['status']=$row->status;
             $details[$i]['sort_order']=$row->sort_order;
             $details[$i]['toppick_status']=$this->isToppick($row->id);
             $details[$i]['toppick_date']=$this->getToppickDate($row->id);
             $details[$i]['trending_status']=$this->isTrending($row->id);
             $details[$i]['trending_date']=$this->getTrendingDate($row->id);
             $i++;
         }
         return $details;
    }
   public function isToppick($video_id){
       $date='';
       $status=0;
        $this->db->select('toppick_date');
        $this->db->where('video_id',$video_id);
        $this->db->from('toppick_videos');
        $query = $this->db->get();
         foreach ($query->result() as $row) {
             $status=1;
             $date=$row->toppick_date;
         }
        return  $status;
   } 
    public function getToppickDate($video_id){
       $date='NA';
       $status=0;
        $this->db->select('toppick_date');
        $this->db->where('video_id',$video_id);
        $this->db->from('toppick_videos');
        $query = $this->db->get();
         foreach ($query->result() as $row) {
             $status=1;
             $date=$row->toppick_date;
         }
        return  $date;
   } 
   public function makeToppick($vid_id,$name){
       $this->db->set('video_id',$vid_id);
       $this->db->set('poster_name',$name);
       $this->db->set('toppick_date',date("Y-m-d H:i:s"));
       return $this->db->insert('toppick_videos');
   }
    public function removeToppick($vid_id){
       $this->db->where('video_id',$vid_id);
       return $this->db->delete('toppick_videos');
   }
    public function keepRemoveHistory($vid_id){
       $this->db->set('video_id',$vid_id);
       $this->db->set('date',date("Y-m-d H:i:s"));
       return $this->db->insert('toppick_removed');
   }

//Get Normal Video codes --Aiswarya
   public function getVideos( $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->from('video_settings as vs');
        $this->db->where('vs.delete_status', 'no');
        $this->db->where('language_id',1);
        $this->db->where('video_type','normal');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->order_by('sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
             $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
          //print_r($query->result_array());die;
        return  $details;
   }
   
      public function getVideo( $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');
        $this->db->where('video_type', 'normal');
        $this->db->from('video_settings as vs');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->order_by('sort_order',"asc")->limit(1);
        if ($limit) { 
            $this->db->limit((int) $limit, (int) $page);
        }
        $query = $this->db->get();
        
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
            $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
        return  $details;
   }
      public function getAllVideos( $limit = '', $page = ''){
       $details=array();
        $status=0;
       //$this->db->select('vs.*,opd.name');
        $this->db->from('video_settings as vs');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->where('language_id',1);
       // $this->db->where('video_type', 'normal');
        $this->db->order_by('vs.sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
            $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_type']=$det[0]['video_type'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
             $details[$i]['video_link']= $row['video_link'];
             $details[$i]['sort_order']= $row['sort_order'];
            $i++;
         }
          //print_r($query->result_array());die;
        return  $details;
   }
   
   public function getAllVideosNew( $limit = '', $page = ''){
       $details=array();
        $status=0;
       //$this->db->select('vs.*,opd.name');
        $this->db->from('video_settings as vs');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->where('language_id',1);
        $this->db->where('delete_status', 'yes');
        //$this->db->where('video_type', 'normal');
        $this->db->order_by('sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
            $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
          $details[$i]['video_type']=$det[0]['video_type'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $details[$i]['sort_order']= $row['sort_order'];
            $i++;
         }
          //print_r($query->result_array());die;
        return  $details;
   }
   //Normal videos ends
   
   
   //Get Started Video codes --Aiswarya
   public function getstartedVideos( $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->from('video_settings as vs');
        $this->db->where('vs.delete_status', 'no');
        $this->db->where('language_id',1);
        $this->db->where('video_type','get_started');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->order_by('sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
             $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
          //print_r($query->result_array());die;
        return  $details;
   }
   
      public function getstartedVideo( $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');
        $this->db->where('video_type', 'get_started');
        $this->db->from('video_settings as vs');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->order_by('sort_order',"asc")->limit(1);
        if ($limit) { 
            $this->db->limit((int) $limit, (int) $page);
        }
        $query = $this->db->get();
        
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
            $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
        return  $details;
   }
      public function getAllgetstartedVideos( $limit = '', $page = ''){
       $details=array();
        $status=0;
       //$this->db->select('vs.*,opd.name');
        $this->db->from('video_settings as vs');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->where('language_id',1);
        $this->db->where('video_type', 'get_started');
        $this->db->order_by('sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
            $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
        return  $details;
   } 
       public function Disable_Enable_video($id,$action) {
          if($action=='disable')
          {
            $this->db->set('delete_status','yes');
            $this->db->where('id', $id);
            $res=$this->db->update('video_settings');
            
          }
          else
          {
            $this->db->set('delete_status','no');
            $this->db->where('id', $id);
            $res=$this->db->update('video_settings');
            
          }
          return $res;
       
    }
    
    public function deleteVideo($id){
        
        $this->db->select('*');
        $this->db->where('id', $id);
        $res=$this->db->delete('video_settings');
        return $res;
    }

    //code ends..
    
    public function getVideoDetails($id){
        
        $details = array();
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('video_settings');
        $query = $this->db->get();
         foreach ($query->result_array() as $row) {
                $details = $row;
             
         }
           return $details;  
    }
    
    
    
          //Get Live Session Video codes --Aiswarya
   public function get_live_Session_Videos( $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->from('video_settings as vs');
        $this->db->where('vs.delete_status', 'no');
        $this->db->where('language_id',1);
        $this->db->where('video_type','live_session');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->order_by('sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
             $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
          //print_r($query->result_array());die;
        return  $details;
   }
   
   
         //Get Live Session Video codes --Aiswarya
   public function grow_your_business_videos( $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->from('video_settings as vs');
        $this->db->where('vs.delete_status', 'no');
        $this->db->where('language_id',1);
        $this->db->where('video_type','grow_your_business');
        $this->db->join('oc_product_description as opd', 'vs.module_id=opd.product_id','INNER');
        $this->db->order_by('sort_order',"asc");
        $this->db->distinct();
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['id'];
            $det = $this->getVideoInfo($row['id']);
             $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            $details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['package_name']= $row['name'];
            $details[$i]['video_description']= $row['video_description'];
           
            $i++;
         }
          //print_r($query->result_array());die;
        return  $details;
   }
       public function getPackageNameFromModuleId($module_id=''){
     
     $package_name='';
     $this->db->select('model');
     $this->db->from('oc_product');
     $this->db->where('product_id',$module_id);
     $query = $this->db->get();
      foreach ($query->result() as $row) {
                $package_name = $row->model;
             
         }
         return $package_name;
    }
    
    public function editSelectedVideo($post_array, $id){
       // print_r($post_array); die;
             $link=$post_array['video_link'];
        $link= str_replace("https://vimeo.com","/videos",$link);
        
        if(strlen($link)>17)
            {
              $link = substr($link, 0, 17);
            }
        $module_id =$post_array['package_type'];
        $this->db->set('title',$post_array['title']);
        $this->db->set('video_description',$post_array['video_description']);
        $this->db->set('sort_order',$post_array['sort_order']);
        $this->db->set('module_id',$module_id[0]);
        $this->db->set('video_type',$post_array['video_type']);
         $this->db->set('video_link',$link);
        $this->db->where('id',$post_array['id']);
        $res =$this->db->update('video_settings');
        return $res;
    }
    
        public function getvideo_types() {
        $this->db->select('*');
        $this->db->from('video_types');
       
        $query = $this->db->get();
        
        return $query->result_array();
    }
    public function getsort_order_availability($sort_order,$video_type,$module_id) {
        
        $flag = true;
        $this->db->select('*');
        $this->db->from('video_settings');
        $this->db->where('sort_order',$sort_order);
        $this->db->where('module_id',$module_id);
        $this->db->where('video_type',$video_type);
       $res = $this->db->get();
       //echo $this->db->last_query(); die;
        $row_count = $res->num_rows();
        return $row_count;
        //return $count;
      
    }
   
}
