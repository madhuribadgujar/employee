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
				$this->insertdata->delete('address_details',array('addr_id' ,$item->id));
				//insert into address
				$this->insertdata->upsert($dataAddr,'address_details',array('addr_id' ,$item->id));
				
	
								
			}


			print_r(json_encode(array("msg"=>"Updated Successfully","data"=>$data['emp']->result_array())));
			return ;
		
		 }
		 	//New Emp
			 $res =$this->insertdata->upsertEmp($_POST,'employee_details');
		 	if($res){
			
			
			if(isset($_POST['address'])){
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
								
			}
			
			 print_r(json_encode(array("msg"=>"Inserted Successfully","data"=>$res)));
			 return ;
			 
	}
	//Delete employee and associate address
	public function deleteEmp(){
		$this->load->database();  
		//load the model  
		$this->load->model('select');  
		$this->load->model('insertdata');  
		//check if employee present
		$data['emp']=$this->select->select('employee_details',array('emp_id'=>$_POST['id']));  
		$count = $data['emp']->num_rows();
	 if($count  === 0){
		print_r(json_encode(array("msg"=>"No employee found")));
		return ;
	 }
	 	//delete fro emp
		$this->insertdata->delete('employee_details',array('emp_id' ,$_POST['id']));
	 	//check address against emp present
		$data['add']=$this->select->select('address_details',array('emp_id'=>$_POST['id']));  
		$addCount = $data['emp']->num_rows();
	 if($addCount > 0){
		//delete from address
		$this->insertdata->delete('address_details',array('emp_id' ,$_POST['id']));
	 }
		print_r(json_encode(array("msg"=>"Deleted Successfully","data"=>$data['emp']->result_array())));
		return ;

	}

	//view and serch employee
	public function view(){
		 //load the database  
         $this->load->database();  
         //load the model  
         $this->load->model('select');  
		 $id = isset($_POST['id']) ?$_POST['id'] : '';
		 $emp_name  = isset($_POST['emp_name']) ?$_POST['emp_name'] : '';
		 $department =isset($_POST['department']) ?$_POST['department'] : '';
		 $data['emp']=$this->select->selectView('employee_details',$id ,$emp_name,$department);  
	
		 print_r(json_encode(array("msg"=>"Successfully Fetch Data","data"=>$data['emp'])));
		 return ;

	}
}