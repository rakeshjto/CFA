<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
        }

	public function login()
	{

		//$this->output->enable_profiler(TRUE);
		$session_data = array('username','designation');
		$this->session->unset_userdata($session_data);
		$data = array(
				'title' => 'User Login',
				'scripts' => array('Best_tm_jto'),
				'content' => 'login'
		);
		$this->load->view('layout',$data);  //After submitting the login in login.php, dologin() function is called thru ajax to send proper alerts to the browser...

	}
	
	public function doLogin()
	{
	
		$data = array('username','designation');
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
						'label' => 'Password',
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
			$this->load->model('Best_tm_jto', 'btj');
			$result = $this->btj->auth($this->input->post('username'), $this->input->post('password'));
			if( $result) //If Authentication Sucess
			{
				$data = array(
						
						'username' => $result['username']
				);
	
				$this->session->set_userdata($data); //Setting Session Variables
				
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
				$response = array(
						'status' => 'danger',
						'message' => 'Authentication failed.' . "<br>" .$this->session->userdata('redirect')
				);
				echo json_encode($response);
			}
		}
	
	}

	public function password()
	{
	
		$this->output->enable_profiler(TRUE);
		$data = array(
				'title' => 'Change password',
				'scripts' => array('password_change'),
				'content' => 'password_change'
		);
		$this->load->view('layout',$data);
	
	}
	
	public function doPassword()
	{

		//$this->output->enable_profiler(TRUE);
		$config = array(
		        array(
		                'field' => 'cpassword',
		                'label' => 'current password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => 'You must provide a %s.',
		                ),
		        ),
		        array(
		                'field' => 'npassword',
		                'label' => 'new password',
		                'rules' => 'required',
		                'errors' => array(
		                        'required' => 'You must provide a %s.',
		                ),
		        ),
		        array(
		                'field' => 'rpassword',
		                'label' => 'repeat password',
		                'rules' => 'required|matches[npassword]',
		                'errors' => array(
		                        'required' => 'You must provide a %s.',
		                        'matches' => 'Repeat password not matched with new password.'
		                ),
		        )
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$response = array(
							'status' => 'danger',
							'message' => strip_tags(validation_errors())
						);
			echo json_encode($response);
		} 
		else
		{

			$this->load->model('User_model', 'um');
			
			$result = $this->um->auth($this->session->userdata('username'), $this->input->post('cpassword'));

			if( $result)
			{
				
				$r = $this->um->password($result['id'], $this->input->post('npassword'));

				if( $r > 0) {
					$response = array(
									'status' => 'success',
									'message' => 'Password changed.'
								);
				} else {
					$response = array(
									'status' => 'danger',
									'message' => 'Password change failed.'
								);
				}

				echo json_encode($response);
			}
			else
			{
				$response = array(
								'status' => 'danger',
								'message' => 'Authentication failed....'
							);
				echo json_encode($response);
			}
		}

	}

}