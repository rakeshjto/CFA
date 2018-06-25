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
	public function summary() // To get Summary of SDE Wise Provisions under Popular plans
	{
		$fdate= strtoupper($this->input->post('fdate'));
		$tdate= strtoupper($this->input->post('tdate'));
		$this->load->model('Popular_Provisions_model', 'ppp');
		$popular_provisions = $this->ppp->get_Popular_Provisions($fdate, $tdate);
		$get_groupby_plan = $this->ppp->get_groupby_plan($fdate, $tdate);
	
		$data = array(
				'title' => 'Popular Plans Provisions summary from ' .$fdate. ' to ' .$tdate,
				'fdate' => $fdate,
				'tdate' => $tdate,
				'content' => 'Popular_Provisions/summary',
				'popular_provisions' => $popular_provisions,
				'get_groupby_plan' => $get_groupby_plan,
				'scripts' => array('Popular_Provisions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	public function plan_sum_sde($sde, $fdate, $tdate) // To get Summary of Plan wise Provisions under each SDE 
	{
		$this->load->model('Popular_Provisions_model', 'ppp');
		$plan_sum_sde = $this->ppp->get_plan_sum_sde($sde,$fdate, $tdate);
	
		$data = array(
				'title' => 'Popular Plans Provisions from ' .$fdate. ' to ' .$tdate. ' under '. $sde,
				'fdate' => $fdate,
				'tdate' => $tdate,
				'content' => 'Popular_Provisions/plan_sum_sde',
				'plan_sum_sde' => $plan_sum_sde,
				'scripts' => array('Popular_Provisions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	public function plan_det($sde, $fdate, $tdate) // To get Details of Plan wise Provisions under each SDE 
	{
		$this->load->model('Popular_Provisions_model', 'ppp');
		$prov_det = $this->ppp->get_plan_det($sde, $fdate, $tdate);
		
		$data = array(
				'title' => 'Popular Plans Provisions under ' .$sde. ' from  '.$fdate.' to  '.$tdate.'',
				'content' => 'Popular_Provisions/prov_det',
				'prov_det' => $prov_det,
				'scripts' => array('Popular_Provisions'),
		);
	
		$this->load->view('layout_new',$data);
	
	}
	
	
}


