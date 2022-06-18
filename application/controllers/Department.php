<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Department extends CI_Controller {



	
	public function index()
	{
		parent::__construct();
	//	$this->load->view('welcome_message');
	}
    public function create()
	{
		$dept_name= $this->input->post('dept_name');
		 //load the database  
         $this->load->database();  
         //load the model  
         $this->load->model('select');  
		 $this->load->model('insertdata');  
         //load the method of model  
		 //validate
         $data['dept']=$this->select->select('department',array('dept_name'=>$_POST['dept_name']));  
		    $count = $data['dept']->num_rows();
		 if($count > 0 && !isset($_POST['id'])){
			print_r(json_encode(array("msg"=>"Department alredy present","data"=>$data['dept']->result_array())));
			return ;
		 }
		 //update department
		 if(isset($_POST['id'])){
			$this->insertdata->upsert($_POST,'department',array("dept_id",$_POST['id']));
			print_r(json_encode(array("msg"=>"Updated Successfully","data"=>$data['dept']->result_array())));
			return ;
		
		 }
		 	//New department
		 	$this->insertdata->upsert($_POST,'department');
			 print_r(json_encode(array("msg"=>"Inserted Successfully","data"=>$data['dept']->result_array())));
			 return ;
	}
}