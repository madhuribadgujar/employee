<?php  
   class select extends CI_Model  
   {  
      function __construct()  
      {  
         // Call the Model constructor  
         parent::__construct();  
      }  
      //we will use the select function  
      public function select($table,$where)  
      {  
         //data is retrive from this query  
         $query = $this->db->get_where($table,$where);  
         return $query;  
      }  
      
   }  
?>  