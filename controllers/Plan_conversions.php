<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_conversions extends CI_Controller {

	
	public function index()
	{
		$this->datepicker();
		
	}
	
	public function datepicker(){
		$data = array(
				'title' => 'Popular Plans Conversions Report',
				'content' => 'Plan_conversions/dateinput',
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	}
	public function summary() // To get Summary of Higher-> Lower &  Lower-> Higher Plan conversions
	{
		$fdate= strtoupper($this->input->post('fdate'));
		$tdate= strtoupper($this->input->post('tdate'));
		$this->load->model('Plan_conversions_model', 'pc');
		$planconversions = $this->pc->get_planconversions($fdate, $tdate);
	
		$data = array(
				'title' => 'SDE Wise Popular Plans Conversions from ' .$fdate. ' to ' .$tdate,
				'content' => 'Plan_conversions/summary',
				'fdate' => $fdate,
				'tdate' => $tdate,
				'planconversions' => $planconversions,
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	public function lower_to_higher_sum($sde, $fdate, $tdate) // To get Lower-> Higher Plans Summary under a particular SDE 
	{
		$this->load->model('Plan_conversions_model', 'pc');
		$lower_to_higher_sum = $this->pc->get_lower_to_higher_sum($sde, $fdate, $tdate);
	
		$data = array(
				'title' => 'Lower Plan to Higher Plan Conversions Summary under ' .$sde. ' from  '.$fdate.' to  '.$tdate.'',
				'content' => 'Plan_conversions/lower_to_higher_sum',
				'lower_to_higher_sum' => $lower_to_higher_sum,
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	public function lower_to_higher($sde, $fdate, $tdate)
	{
		$this->load->model('Plan_conversions_model', 'pc');
		$lower_to_higher_det = $this->pc->get_lower_to_higher($sde, $fdate, $tdate);
	
		$data = array(
				'title' => 'Lower Plan to Higher Plan Conversions under ' .$sde. ' from  '.$fdate.' to  '.$tdate.'',
				'content' => 'Plan_conversions/lower_to_higher_det',
				'lower_to_higher_det' => $lower_to_higher_det,
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
}


