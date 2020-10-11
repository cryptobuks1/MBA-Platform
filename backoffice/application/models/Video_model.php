<?php

Class video_model extends inf_model {

    function __construct() {
        parent::__construct();
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
        $this->db->where('delete_status', 'no');
        $query = $this->db->get();
        //print_r($query->result_array()); exit();
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
   public function getToppickVideos(){
       $details=array();
       $status=0;
        $this->db->select('*');
        $this->db->from('toppick_videos');
        $this->db->where('delete_status', 'no');
        $this->db->order_by("toppick_date", "DESC");
        $this->db->limit(5);
        $query = $this->db->get();
        $i=0;
         foreach ($query->result_array() as $row) { 
            $details[$i]['video_id']= $row['video_id'];
            $details[$i]['toppick_date']= $row['toppick_date'];
            $details[$i]['poster_name']= $row['poster_name'];
            $det = $this->getVideoInfo($row['video_id']);
            $details[$i]['id']= $det[0]['id'];
            $details[$i]['title']= $det[0]['title'];
            $details[$i]['video_name']=$det[0]['video_name'];
            $details[$i]['video_link']= $det[0]['video_link'];
            //$details[$i]['poster_name']=$det[0]['poster_name'];
            $details[$i]['module_id']= json_decode($det[0]['module_id'])[0];
            $details[$i]['status']= $det[0]['status'];
            $i++;
         }
        return  $details;
   } 
   public function isTrending($video_id){
       $date='';
       $status=0;
        $this->db->select('trending_date');
        $this->db->where('video_id',$video_id);
        $this->db->from('trending_videos');
        $query = $this->db->get();
         foreach ($query->result() as $row) {
             $status=1;
             $date=$row->trending_date;
         }
        return  $status;
   } 
    public function getTrendingDate($video_id){
       $date='NA';
       $status=0;
        $this->db->select('trending_date');
        $this->db->where('video_id',$video_id);
        $this->db->from('trending_videos');
        $query = $this->db->get();
         foreach ($query->result() as $row) {
             $status=1;
             $date=$row->trending_date;
         }
        return  $date;
   }
   public function makeTrending($vid_id,$name){
       $this->db->set('video_id',$vid_id);
       $this->db->set('poster_name',$name);
       $this->db->set('trending_date',date("Y-m-d H:i:s"));
       return $this->db->insert('trending_videos');
   }
    public function removeTrending($vid_id){
       $this->db->where('video_id',$vid_id);
       return $this->db->delete('trending_videos');
   }
    public function keepTrendingRemoveHistory($vid_id){
       $this->db->set('video_id',$vid_id);
       $this->db->set('date',date("Y-m-d H:i:s"));
       return $this->db->insert('trending_removed');
   }
   
   
   //Normal videos ends
public function getVideo($product_id,$limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');  
        $this->db->where('module_id', $product_id);
        $this->db->where('video_type', 'normal');
        $this->db->from('video_settings');
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
             $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
        return  $details;
   } 


   public function getVideos($product_id, $limit = '', $page = ''){
       
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');
         $this->db->where('module_id', $product_id);
         $this->db->where('video_type', 'normal');
          $this->db->order_by('sort_order',"asc");
        $this->db->from('video_settings');
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
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
     
        return  $details;
   } 
   // normal video code ends--
   
   
   
   //Get started videos ends
public function getstartedVideo($product_id,$limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');  
        $this->db->where('module_id', $product_id);
        $this->db->where('video_type', 'get_started');
        $this->db->from('video_settings');
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
             $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
        return  $details;
   } 


   public function getstartedVideos($product_id, $limit = '', $page = ''){
       
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');
         $this->db->where('module_id', $product_id);
         $this->db->where('video_type', 'get_started');
          $this->db->order_by('sort_order',"asc");
        $this->db->from('video_settings');
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
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
     
        return  $details;
   } 
   // get started video code ends--
   
   
      //live_session_videos starts
         public function live_session_videos($product_id, $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');
         $this->db->where('module_id', $product_id);
         $this->db->where('video_type', 'live_session');
          $this->db->order_by('sort_order',"asc");
        $this->db->from('video_settings');
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
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
     
        return  $details;
   } 
   // live_session_videos code ends--
   
   
   
      //grow_your_business_videos starts
      public function grow_your_business_videos($product_id, $limit = '', $page = ''){
       $details=array();
        $status=0;
        $this->db->select('*');
        $this->db->where('delete_status', 'no');
         $this->db->where('module_id', $product_id);
         $this->db->where('video_type', 'grow_your_business');
          $this->db->order_by('sort_order',"asc");
        $this->db->from('video_settings');
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
            $details[$i]['delete_status']= $det[0]['delete_status'];
            $details[$i]['video_description']= $row['video_description'];
            $i++;
         }
     
        return  $details;
   } 
   // grow_your_business_videos code ends--
   

      //toppick configuration by neenu ends
      //code added MSk
    public function deleteVideo($video_id){
        $this->db->set('delete_status',"yes");
        $this->db->where('id', $video_id);
        $res =  $this->db->update('video_settings');
        if($res){
            
        $this->db->set('delete_status',"yes");
        $this->db->where('video_id', $video_id);
         $this->db->update('toppick_videos');
        
        $this->db->set('delete_status',"yes");
        $this->db->where('video_id', $video_id);
         $this->db->update('trending_videos');
        
        }
        return $res;
    }
     public function addMailRequestHistory($name, $email, $acc_no) {
        $this->db->set('name', $name);
        $this->db->set('from_email', $email);
        $this->db->set('mt4_acc_no', $acc_no);
        return $this->db->insert('doc_mail_request');
    }
    //code ends..
   
}
