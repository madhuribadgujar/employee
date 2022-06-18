<?php  
   class insertdata extends CI_Model  
   {  
      function __construct()  
      {  
         // Call the Model constructor  
         parent::__construct();  
      }  
      //we will use the select function  
      public function upsert(array $data,$table,$where=null)  
      {  
        
            
            //update data
            if(isset($data['id'])){
                unset($data['id']);
              
                $this->db->where($where[0],$where[1]);
                $this->db->update($table, $data);
                return $this->db->affected_rows() ;

            }
    
            unset($data['id']);
           
            $this->db->insert($table,$data);
            return $this->db->insert_id(); ;
      }  
   
   public function upsertEmp(array $data,$table,$where=null)  
   {  
         
      unset($data['address']);
    
     return $this->upsert($data,$table,$where);
   }  
   public function delete(array $data,$table,$where=null)  
   {  
   
      $this->db->where($where[0],$where[1]);
                $this->db->delete($table);
   }  
}  
?>  