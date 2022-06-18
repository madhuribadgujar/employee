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
      
      public function selectView($table,$where=null,$emp,$dept)  
      {  $qu='';
         $qu1='';
         $qu2='';
         if($where !== ''){
           $qu= array('emp.emp_id',$where);
         }
       
         if($emp !== ''){
           $qu1 = array('emp.emp_name',$emp);
         }
         if($dept !== ''){
            unset($emp);
              $department= $this->select('department',array('dept_name'=>$dept));
            $deptData = $department->result_array();          
            $qu2 =array('emp.dept_id',$deptData[0]['dept_id']);
         }
        //Filtration on id
         if($qu){
           
          $this->db->where($qu[0],$qu[1]);		
          }
          //Filtration on emp name
          if($qu1){
            
          $this->db->where($qu1[0],$qu1[1]);		
          }
          //Filtration on dept name
          if($qu2){
            
            $this->db->where($qu2[0],$qu2[1]);		
            }
            $this->db->select('emp.emp_name,emp.emp_mail_id,dept.*,addr.addr_id,addr.address_details,
                           addr.contact_no' )
                ->from ( 'employee_details as emp' )
                ->join ( 'department dept', 'dept.dept_id = emp.dept_id')
                ->join ( 'address_details addr ', 'addr.emp_id = emp.emp_id' ,'left');
               
            $query = $this->db->get ();
            return $query->result ();  
      }  
      
      
   }  
?>  