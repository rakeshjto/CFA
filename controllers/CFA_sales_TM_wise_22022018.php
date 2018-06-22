<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CFA_sales_TM_wise extends CI_Controller {

	
	public function index()
	{
		$this->login();
		
	}
	
	private function check_login()
	{
		
		if ( $this->session->userdata('username') != null ) { //Check whether session variable exist
			return true;}
			else
				return false;
	
	}
	
	public function login()
	{
		//$this->output->enable_profiler(TRUE);
		$session_data = array('username','designation');
		$this->session->unset_userdata($session_data);
		$data = array(
				'title' => 'User Login',
				'scripts' => array('CFA_sales_TM_wise'),
				'content' => 'CFA_sales_TM_wise/login'
		);
		$this->load->view('layout',$data);  //After submitting the login in login.php, dologin() function is called thru ajax to send proper alerts to the browser...
	
	}
	
	public function doLogin()
	{

		$data = array('username', 'designation');
		$this->session->unset_userdata($data);

		$config = array(
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required',
						'errors' => array(
								'required' => 'You must provide a %s.',
						),
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required',
						'errors' => array(
								'required' => 'You must provide a %s.',
						),
				),
				array(
						'field' => 'designation',
						'label' => 'designation',
						'rules' => 'required',
						'errors' => array(
								'required' => 'You must provide a %s.',
						),
				)
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) // If Validation Fails
		{
			$response = array(
					'status' => 'danger',
					'message' => strip_tags(validation_errors())
			);
			echo json_encode($response);
		}
		else //If Validation Rules Success
		{
			$this->load->model('CFA_sales_TM_wise_model', 'btj');
			$result = $this->btj->auth($this->input->post('username'), $this->input->post('password'),$this->input->post('designation'));
			if( isset($result['username']) && isset($result['designation'])) //If Authentication Sucess
			{

				$data = array(
						"username" => $result['username'],
						"designation" => $result['designation']
				);
					
				$this->session->set_userdata($data); //Setting Session Variables

				if( $result['designation'] == 'LEV1_JTO_SDE_ID'){
					$redir_url = base_url() . 'CFA_sales_TM_wise/input_form/' .$result['username']. '/' .$result['designation'];
				}

				else if($result['designation'] == 'LEV2_SDE_DE_ID' || $result['designation'] == 'LEV3_SDE_DE_ID' ){
					$redir_url =  base_url() . 'CFA_sales_TM_wise/Get_reports';
				}

				$response = array(
						'status' => 'success',
						'message' => 'Authentication success!. Please wait...',
						'redirect' => $redir_url
				);
				$this->session->unset_userdata('redirect');

				echo json_encode($response);
			}
			else //If Authentication Fails
			{
				if($result=='C'){
					$message="Check Your Clarity Username: " .$this->input->post('username'). " & Designation: " .$this->input->post('designation'). " in Clarity";
				}
				else if($result=='U'){
					$message="Check Your Edak Password";
				}
				$response = array(
						'status' => 'danger',
						'message' => $message
				);
				echo json_encode($response);
			}
		}

	}
	
	
	public function input_form($username,$designation){

		if(!$this->check_login()){
			redirect(base_url() . 'CFA_sales_TM_wise/login');
		}
		//$this->output->enable_profiler(TRUE);
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		
		$result = $this->btj->get_linemen($username,$designation);
		
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'content' => 'CFA_sales_TM_wise/input',
				'scripts' => array('CFA_sales_TM_wise'),
				'linemen' => $result
		);
		
		$this->load->view('layout',$data);
	}
	
	public function Orders_Phone_no() {
		if (! $this->check_login ()) {
			redirect ( base_url () . 'CFA_sales_TM_wise/login' );
		}
		$this->load->model ( 'CFA_sales_TM_wise_model', 'btj' );
		
		$prov_type = $this->input->post ( 'prov_type' );
		$phone_no = $this->input->post ( 'phone_no' );
		
		if ($prov_type == "llphoneno") {
			$text = "LL Provision Order";
		} else if ($prov_type == "bbphoneno") {
			$text = "BB Provision Order";
		} else if ($prov_type == "llbbphoneno") {
			$text = "FollowOn BB Provision Order";
		}
		// echo $phone_no . "|" .$prov_type . "<br>";
		$result = $this->btj->get_orders ( $phone_no, $prov_type );
		
		if (isset ( $result )) {
			$result_data = explode ( "|", $result );
			if ($result_data [0] == 'D') {
				$response = array (
						'status' => 'danger',
						'message' => $phone_no . ' Recently Disconnected on ' . $result_data [1] . ' and can not be inserted' 
				);
			} else if ($result_data [0] == 'S') {
				$response = array (
						'status' => 'success',
						'message' => $result_data [1] 
				);
			}
		} else {
			$response = array (
					'status' => 'danger',
					'message' => 'Phone Number ' . $phone_no . ' has no Completed ' . $text . ' during previous 5 days and hence can not be Inserted' 
			);
		}
		echo json_encode ( $response );
	}
	
	public function get_phoneNums(){
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$user= $this->input->post('user');
		$designation= $this->input->post('designation');
		$result = $this->btj->get_phoneNums($user,$designation);
		if( $result)
		{
			echo json_encode($result);
		}
	}
	
	public function insert_data(){
		if(!$this->check_login()){
			redirect(base_url() . 'CFA_sales_TM_wise/login');
		}
		//$this->output->enable_profiler(TRUE);
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$this->db->trans_start();
		
		$order_no= $this->input->post('order_no');
		$tm_id= $this->input->post('tm_id');
		$result = $this->btj->insert_data($order_no,$tm_id);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$response = array(
					'status' => 'danger',
					'message' => $this->db->_error_message()
			);
		}
		else if($result>0) 
		{
			$response = array(
					'status' => 'success',
					'message' => 'Order No: ' .$order_no . ' has been attached to TT with HR NO: ' .$tm_id . ' Successfully'
			);
			
		}
		else if($result == 0) {
			$response = array(
					'status' => 'danger',
					'message' => 'Order No: ' .$order_no . ' already exists on this Phone No and can not be inserted'
			);
		}

		echo json_encode($response);
	}
	
	public function doLogout()
	{
		if(!$this->check_login()){
			redirect(base_url() . 'CFA_sales_TM_wise/login');
		}
		$data = array('username', 'designation');
		$this->session->unset_userdata($data);
		redirect(base_url().'CFA_sales_TM_wise');
	}
	
	/*public function Get_reports()
	{
		if(!$this->check_login()){
			redirect(base_url() . 'CFA_sales_TM_wise/login');
		}
		$username= $this->session->userdata('username');
		$designation= $this->session->userdata('designation');
		
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$linemen = $this->btj->get_linemen($username,$designation);
		
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'content' => 'CFA_sales_TM_wise/reports',
				'scripts' => array('CFA_sales_TM_wise'),
				'linemen' => $linemen,
		);
		
		$this->load->view('layout',$data);
		
	}*/
	
	public function Get_reports()
	{
		if(!$this->check_login()){
			redirect(base_url() . 'CFA_sales_TM_wise/login');
		}
		//$this->output->enable_profiler(TRUE);
		$username= $this->session->userdata('username');
		$designation= $this->session->userdata('designation');
	
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$subOrdinates = $this->btj->get_subOrdinates($username,$designation);
	
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'content' => 'CFA_sales_TM_wise/reports',
				'scripts' => array('CFA_sales_TM_wise'),
				'subOrdinates' => $subOrdinates,
		);
	
		$this->load->view('layout',$data);
	
	}
	
	public function prov_details($designation,$hr_no,$prov_type,$monyy)
	{
		//$this->output->enable_profiler(TRUE);
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$result = $this->btj->prov_details($designation,$hr_no,$prov_type,$monyy);
	
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'content' => 'CFA_sales_TM_wise/prov_details',
				'scripts' => array('CFA_sales_TM_wise'),
				'monyy' => $monyy,
				'result' => $result
		);
	
		$this->load->view('layout',$data);
	
	}
	
	public function custom_reports_input()
	{
	
		//$this->output->enable_profiler(TRUE);
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'content' => 'CFA_sales_TM_wise/custom_reports_input',
				'scripts' => array('CFA_sales_TM_wise')
		);
	
		$this->load->view('layout',$data);
	
	}
	
	public function custom_reports()
	{
		
		$config = array(
				array(
						'field' => 'designation',
						'label' => 'designation',
						'rules' => 'required',
						'errors' => array(
								'required' => 'You must provide a %s.',
						),
				),
				array(
						'field' => 'monyy',
						'label' => 'Month',
						'rules' => 'required',
						'errors' => array(
								'required' => 'You must provide a %s.',
						),
				)
		);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) // If Validation Fails
		{
			echo strip_tags(validation_errors());
			
			
		}
		else //If Validation Rules Success
		{
			//$this->output->enable_profiler(TRUE);
			$designation= $this->input->post('designation');
			$monyy= strtoupper($this->input->post('monyy'));
			$this->load->model('CFA_sales_TM_wise_model', 'btj');
			$result = $this->btj->custom_reports($designation,$monyy);
			$data = array(
					'title' => 'BEST TM & BEST JTO',
					'monyy' => $monyy,
					'designation' => $designation,
					'result' => $result,
					'content' => 'CFA_sales_TM_wise/custom_reports',
					'scripts' => array('CFA_sales_TM_wise')
			);
			
			$this->load->view('layout',$data);
		}
		
	
	}
	
	public function crm_reports()
	{
		
		//$this->output->enable_profiler(TRUE);
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$result = $this->btj->crm_reports();
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'result' => $result,
				'content' => 'CFA_sales_TM_wise/crm_reports',
				'scripts' => array('CFA_sales_TM_wise')
		);
	
		$this->load->view('layout',$data);
	
	}
	
	public function crm_prov_details($hr_no,$prov_type)
	{
		//$this->output->enable_profiler(TRUE);
		$this->load->model('CFA_sales_TM_wise_model', 'btj');
		$result = $this->btj->crm_prov_details($hr_no,$prov_type);
	
		$data = array(
				'title' => 'BEST TM & BEST JTO',
				'content' => 'CFA_sales_TM_wise/crm_prov_details',
				'scripts' => array('CFA_sales_TM_wise'),
				'result' => $result
		);
	
		$this->load->view('layout',$data);
	
	}
	
}
//@todo Change /phone.png in header.php
//@todo Add Avatar in login.php
//@todo Try foundation.zurb
//@todo How to Handle Multiple Projects in CodeIgniter?
//@todo Unique key Violated error alert not coming
//@todo Try foundation.zurb
//@todo Try foundation.zurb
//@todo Try foundation.zurb
//@todo Try foundation.zurb


