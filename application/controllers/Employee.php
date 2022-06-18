<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Employee extends CI_Controller {
	
	public function index()
	{
		parent::__construct();
	//	$this->load->view('welcome_message');
	}
    public function create()
	{
	
		
		$emp_mail= $this->input->post('emp_mail_id');
		 //load the database  
         $this->load->database();  
         //load the model  
         $this->load->model('select');  
		 $this->load->model('insertdata');  
         //load the method of model  
		 //validate
         $data['emp']=$this->select->select('employee_details',array('emp_mail_id'=>$_POST['emp_mail_id']));  
		    $count = $data['emp']->num_rows();
		 if($count > 0 && !isset($_POST['id'])){
			print_r(json_encode(array("msg"=>"Emplyee alredy present","data"=>$data['emp']->result_array())));
			return ;
		 }
		 
		 //update department
		 if(isset($_POST['id'])){
			
			$res =$this->insertdata->upsertEmp($_POST,'employee_details',array("emp_id",$_POST['id']));
	
			//if($res =$this->insertdata->upsertEmp($_POST,'employee_details',array("emp_id",$_POST['id']))){
			
				$arr= json_decode($_POST['address']);
		
				$dataAddr=[];
				foreach($arr as $item) {
					// $item->contact_no;
					$dataAddr= ['contact_no' => $item->contact_no,
					'address_details' => $item->address_details,
					'emp_id' => $_POST['id']
					
				];
				//delete from address
				$this->insertdata->delete($dataAddr,'address_details',array('addr_id' ,$item->id));
				//insert into address
				$this->insertdata->upsert($dataAddr,'address_details',array('addr_id' ,$item->id));
				
			//	}
								
			}


			print_r(json_encode(array("msg"=>"Updated Successfully","data"=>$data['emp']->result_array())));
			return ;
		
		 }
		 	//New Emp
			
		 	if($res =$this->insertdata->upsertEmp($_POST,'employee_details')){
			
				$arr= json_decode($_POST['address']);
			
				$dataAddr=[];
				foreach($arr as $item) {
					// $item->contact_no;
					$dataAddr= ['contact_no' => $item->contact_no,
					'address_details' => $item->address_details,
					'emp_id' => $res
					
				];
				//insert into address
				$this->insertdata->upsert($dataAddr,'address_details');
				
				}
								
			}
			
			 print_r(json_encode(array("msg"=>"Inserted Successfully","data"=>$data['emp']->result_array())));
			 return ;
			 
	}
}