<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popular_Provisions extends CI_Controller {

	
	public function index()
	{
		$this->datepicker();
		
	}
	
	public function datepicker(){
		$data = array(
				'title' => 'Popular Plans Provisions Report',
				'content' => 'Popular_Provisions/dateinput',
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	}
	public function summary() // To get Summary of Higher-> Lower &  Lower-> Higher Plan conversions
	{
		$fdate= strtoupper($this->input->post('fdate'));
		$tdate= strtoupper($this->input->post('tdate'));
		$this->load->model('Popular_Provisions_model', 'ppp');
		$lower_planconversions = $this->pc->get_Popular_Provisions($fdate, $tdate);
		$higher_planconversions = $this->pc->get_Popular_Provisions($fdate, $tdate);
	
		$data = array(
				'title' => 'SDE Wise Popular Plans Provisions from ' .$fdate. ' to ' .$tdate,
				'content' => 'Plan_conversions/summary',
				'fdate' => $fdate,
				'tdate' => $tdate,
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	public function conv_sum_sde($sde, $fdate, $tdate, $conv_type) // To get Lower-> Higher Plans Summary under a particular SDE 
	{
		
		$title= (($conv_type == 'l2h') ? "LOWER_PLAN TO HIGHER_PLAN" : "HIGHER_PLAN TO LOWER_PLAN");
		$this->load->model('Plan_conversions_model', 'pc');
		$conv_sum_sde = $this->pc->get_conv_sum_sde($sde, $fdate, $tdate, $conv_type);
	
		$data = array(
				'title' => $title .' Conversions Summary under ' .$sde. ' from  '.$fdate.' to  '.$tdate.'',
				'content' => 'Plan_conversions/conv_sum_sde',
				'conv_sum_sde' => $conv_sum_sde,
				'conv_type' => $conv_type,
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	public function conv_det($sde, $fdate, $tdate, $conv_type)
	{
		$this->load->model('Plan_conversions_model', 'pc');
		$conv_det = $this->pc->get_conv_det($sde, $fdate, $tdate, $conv_type);
		$title= (($conv_type == 'l2h') ? "LOWER_PLAN TO HIGHER_PLAN" : "HIGHER_PLAN TO LOWER_PLAN");
		
		$data = array(
				'title' => $title .' Conversions under ' .$sde. ' from  '.$fdate.' to  '.$tdate.'',
				'content' => 'Plan_conversions/conv_det',
				'conv_det' => $conv_det,
				'conv_type' => $conv_type,
				'scripts' => array('Plan_conversions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
}


