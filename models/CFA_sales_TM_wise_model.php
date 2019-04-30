<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CFA_sales_TM_wise_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->edak=$this->load->database('mysql',true);
            $this->oracle=$this->load->database('default',true);
            
    }	

    public function auth($user, $pass, $designation)
    {
    	$hrno= substr($user, 1);
    	$query = $this->edak->get_where('users', array('HR_NO' => $hrno, 'PASSWORD'=> md5($pass)));

	if($query->num_rows() == 1)
		{
			$this->oracle->where(array($designation => $user ));
			$query1 = $this->oracle->get('CLARITY_LM_MOBILES');
			if($query1->num_rows() >= 1){
				$data= array('username'=> $user,'designation'=> $designation);
			}
			else
			{
				$data = "C"; //User Credentials not matched in CLARITY_LM_MOBILES
			}

		}
		else
		{
			$data = "U"; // User Credentials not matched in EDAK.Users table
		}
    	    	
    	return $data;
    }
    
    function get_linemen($username,$designation)
    {
    	$sql= "SELECT DISTINCT LINEMAN_USERID,LINEMAN_NAME FROM CLARITY_LM_MOBILES where " .$designation. "='" .$username. "'";
		//$this->oracle->distinct('LINEMAN_USERID','LINEMAN_NAME');
    	//$this->oracle->where($designation, $username);
    	//$query = $this->oracle->get('CLARITY_LM_MOBILES'); // Produces: SELECT DISTINCT LINEMAN_USERID,LINEMAN_NAME,WORKGRP FROM clarity_lm_mobiles
    	$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
    
	function get_subOrdinates($username,$designation)
    {
    	if($designation == 'LEV1_JTO_SDE_ID'){
    		$sub_staff= "LINEMAN_USERID";	
    	}
    	else if($designation == 'LEV2_SDE_DE_ID'){
    		$sub_staff= "LEV1_JTO_SDE_ID";
    	}
    	else if($designation == 'LEV3_SDE_DE_ID'){
    		$sub_staff= "LEV2_SDE_DE_ID";
    	}
    	
    	$sql= "select distinct " .$sub_staff. " AS sub_staff,B.EMP_NAME from CLARITY_LM_MOBILES A,WG_STAFF B where " .$designation. "='" .$username ."' AND A." .$sub_staff ."='B'||B.HR_NO";
    	$query = $this->oracle->query($sql);
    	return $query->result_array();
    
    }
    
    /*function get_phoneNums($username,$designation)
    {
    	$sql= "SELECT a.EXCHANGE_CODE,A.MOBILE_NO,A.PHONE_NO, ORDER_NO, TO_CHAR(TRUNC(ORDER_COMP_DATE),'YYYY-MM-DD') ORDER_COMP_DATE,ORDER_TYPE, ORDER_SUB_TYPE, ORDER_STATUS,
	SERVICE_SUB_TYPE,CUSTOMER_NAME,BILL_ACCNT_TYPE, BILL_ACCNT_SUB_TYPE, CHANNEL,TO_CHAR(TRUNC(ORDER_COMP_DATE),'YYYY-MM-DD') ORDER_COMP_DATE FROM CDR_CRM_ORDERS A,
    			(SELECT DISTINCT EXCHANGE_CODE FROM EXCHANGE_CODE) B
	WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(ORDER_COMP_DATE) BETWEEN TRUNC(LAST_DAY(ADD_MONTHS(SYSDATE,-2))+1) AND TRUNC(LAST_DAY(ADD_MONTHS(SYSDATE,-1))) AND SERVICE_TYPE in ('Landline', 'ISDN', 'DSPT', 'LL PCO')
	AND ORDER_STATUS='Complete' AND ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision' AND B.EXCHANGE_CODE IN (SELECT DISTINCT SUBSTR(C.WORKGRP,1,6) FROM CLARITY_LM_MOBILES C WHERE C." .$designation. "='" .$username. "' ) order by PHONE_NO";
    	$query = $this->oracle->query($sql);
    	return $query->result_array();
    
    }*/
    
    function get_orders($phone_no, $prov_type) {
		$username = $this->session->userdata ( 'username' );
		$designation = $this->session->userdata ( 'designation' );
		if ($prov_type == "llphoneno") {
			$query_string = "ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision'";
			$dis_string = "ORDER_TYPE='Disconnect' AND ORDER_SUB_TYPE IN ('Disconnect','Disconnect Due to Misuse')";
		} else if ($prov_type == "bbphoneno") {
			$query_string = "ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision'";
			$dis_string = "((ORDER_TYPE='Modify' AND ORDER_SUB_TYPE='Broadband Disconnection')or (ORDER_TYPE='Disconnect' AND ORDER_SUB_TYPE IN ('Disconnect','Disconnect Due to Misuse')))";
		} else if ($prov_type == "ftthphoneno") {
			$query_string = "ORDER_TYPE='New' AND ORDER_sub_type='Broadband Provision'";
			$dis_string = " ORDER_TYPE='Disconnect' and ORDER_SUB_TYPE='Disconnect' and SERVICE_SUB_TYPE='Bharat Fiber BB'";
		}
		
		$sql_dis = "SELECT TRUNC(ORDER_COMP_DATE)  ORDER_COMP_DATE FROM CDR_CRM_ORDERS WHERE TRUNC(ORDER_COMP_DATE) BETWEEN TRUNC(SYSDATE-35) AND TRUNC(SYSDATE-1) AND SERVICE_TYPE in ('Landline', 'ISDN', 'DSPT', 'LL PCO','Bharat Fiber BB') AND PHONE_NO='" . $phone_no . "' AND " . $dis_string;
		$query = $this->oracle->query ( $sql_dis );
		if ($query->num_rows () >= 1) {
			$row = $query->row_array ();
			return 'D|' . $row ['ORDER_COMP_DATE'];
		} else {
				if($username=="B123456789"){//BASED ON EDAK ID 180725056 for B200400726,BASED ON EDAK ID 180730022 B200301234, EDAK ID  180808064,(B200203427,180904047)
					$days= 30;
				} else{
					$days= 30;
				}
			$sql = "SELECT A.ORDER_NO,A.ORDER_COMP_DATE,A.ORDER_TYPE,A.ORDER_SUB_TYPE,A.SERVICE_SUB_TYPE,A.EXCHANGE_CODE FROM CDR_CRM_ORDERS A,
    			(SELECT DISTINCT EXCHANGE_CODE FROM EXCHANGE_CODE) B
    			WHERE TRUNC(A.ORDER_COMP_DATE) BETWEEN TRUNC(SYSDATE-".$days.") AND TRUNC(SYSDATE-1) AND SERVICE_TYPE in ('Landline', 'ISDN', 'DSPT', 'LL PCO','Bharat Fiber BB') AND
    			A.EXCHANGE_CODE=B.EXCHANGE_CODE AND ORDER_STATUS='Complete' AND " . $query_string . " AND PHONE_NO='" . $phone_no . "' AND B.EXCHANGE_CODE IN (SELECT DISTINCT SUBSTR(C.WORKGRP,1,6) FROM CLARITY_LM_MOBILES C WHERE C." . $designation . "='" . $username . "')";
			$query = $this->oracle->query ( $sql );
			if ($query->num_rows () >= 1) {
				$row = $query->row_array ();
				$discarded_plans = "SELECT PRODUCT_NAME,PROD_ID FROM ORDER_ITEMS WHERE ORDER_NO='".$row ['ORDER_NO']."' AND PROD_CATG_CD in('Plan','BB Plan','Combo Plan','Bharat Fiber Combo Plan') AND PRODUCT_STATUS='Add' AND CREATED<>ACTIVATE_DATE";
				$query = $this->oracle->query ( $discarded_plans );
				$row1 = $query->row_array ();
				if( $row1 ['PRODUCT_NAME']== "BBG RURAL USOF 150" || $row1 ['PRODUCT_NAME']== "BBG RURAL USOF 99"){
						return 'P|' . $row1 ['PRODUCT_NAME'];
				}
				else{
					$getFMC = "SELECT A.NAME NAME,A.ROW_ID,a.PART_NUM,(nvl(B.MONTHLY_RENT,0)+ nvl(B.BB_MONTHLY_RENT,0)) MON_RENT  FROM PRODUCT_DETAILS A,PLAN_ATTRIBUTES B WHERE A.PART_NUM=B.PACKAGE_ID AND A.ROW_ID='".$row1 ['PROD_ID']."'";
					$query = $this->oracle->query ( $getFMC );
				$FMC = $query->row_array ();
				return 'S|' . $row['ORDER_NO'] . '|' .$row['ORDER_COMP_DATE'] . '|' .$row['ORDER_TYPE'] . '|' .$row['ORDER_SUB_TYPE'] . '|' .$row['SERVICE_SUB_TYPE'] . '|' .$row['EXCHANGE_CODE']  . '|' .$FMC['NAME'] . '|' .$FMC['ROW_ID']. '|' .$FMC['PART_NUM']. '|' .$FMC['MON_RENT'] ;
				}
			}
		}
	}
    
    function insert_data($order_no,$tm_id,$order_comp_date,$order_type,$order_sub_type,$service_sub_type,$exchange_code,$name,$row_id,$part_num,$mon_rent,$phone_no,$prov_type)
    {
    	date_default_timezone_set ( 'Asia/Kolkata' );
		$query = $this->oracle->get_where('BEST_TT_JTO_NEW', array('ORDER_NO' => $order_no));// Check whether the Order No is already exists
		if($query->num_rows() == 1)
		{
			return 0;
		}
		else{
			$data = array(//ORDER_TYPE, ORDER_SUB_TYPE, ORDER_COMP_DATE, PRODUCT_NAME,SERVICE_SUB_TYPE, EXCHANGE_CODE
    			'ORDER_NO' => $order_no,
    			'TM_USERID' => $tm_id,
    			'JTO_USERID' => $this->session->userdata('username'),
				'ORDER_COMP_DATE' => $order_comp_date,
				'ORDER_TYPE' => $order_type,
				'ORDER_SUB_TYPE' => $order_sub_type,
				'SERVICE_SUB_TYPE' => $service_sub_type,
				'EXCHANGE_CODE' => $exchange_code,
				'NAME' => $name,
				'ROW_ID' => $row_id,
				'PART_NUM' => $part_num,
				'MON_RENT' => $mon_rent,
				'SYSTEM_IP' => $_SERVER ['REMOTE_ADDR'],
				'SUBMIT_DATE' => strtoupper ( date( 'd-M-Y' )),
				'PHONE_NO'=> $phone_no,
				'PROV_TYPE'=> $prov_type
				);
			return $this->oracle->insert('BEST_TT_JTO_NEW', $data);

		}
    	
    }
   
     function get_reports($userid,$designation)
    {
    	if($designation == 'LINEMAN_USERID'){
    		
    		$sql= "SELECT
    	count(case when ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision' then 1 end) LLPROV,
    	count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NULL then 1 end) BBPROV,
    	count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NOT NULL then 1 end) LLBBPROV
    	from BEST_TT_JTO A,CDR_CRM_ORDERS B
    	WHERE A.ORDER_NO=B.ORDER_NO AND A.TM_USERID='" .$userid. "'";
    	}
    	else if($designation == 'LEV1_JTO_SDE_ID'){
    		$sql= "select TM_USERID HR_NO,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Provision' and MON_RENT<200 then 1 end)*5 LL5,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Provision' and MON_RENT>200 then 1 end)*10 LL10,
        COUNT(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' and MON_RENT<675 then 1 end)*5 BB5,
        COUNT(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' and MON_RENT>675 then 1 end)*10 BB10,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Broadband Provision' and MON_RENT<777 then 1 end)*5 FTTH5,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Broadband Provision' and MON_RENT>=777 then 1 end)*10 FTTH10
        from BEST_TT_JTO_NEW 
        where   JTO_USERID='" .$userid. "'
        group by TM_USERID";
    	}
    	else if($designation == 'LEV2_SDE_DE_ID'){
    		$sql= "SELECT
    	count(case when ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision' then 1 end) LLPROV,
    	count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NULL then 1 end) BBPROV,
    	count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NOT NULL then 1 end) LLBBPROV
    	from BEST_TT_JTO A,CDR_CRM_ORDERS B,
			(SELECT DISTINCT LEV1_JTO_SDE_ID FROM clarity_lm_mobiles WHERE LEV2_SDE_DE_ID='" .$userid. "') C
    	WHERE A.ORDER_NO=B.ORDER_NO AND A.JTO_USERID=C.LEV1_JTO_SDE_ID";
    	}
    	$query = $this->oracle->query($sql);
    	return $query->row();
    	 
    } 
	
	 function custom_reports($designation,$monyy){
		if($designation == 'TM'){
			/*$sql= "SELECT TM_USERID as HR_NO,C.EMP_NAME,B.EXCHANGE_CODE EXCH_CODE,D.STATION_CODE,
				count(case when ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision' then 1 end) LLPROV,
				count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NULL then 1 end) BBPROV,
				count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NOT NULL then 1 end) LLBBPROV
				FROM BEST_TT_JTO A,CDR_CRM_ORDERS B,WG_STAFF C,EXCHANGE_CODE D WHERE A.ORDER_NO=B.ORDER_NO  AND B.EXCHANGE_CODE=D.EXCHANGE_CODE AND TRUNC(ORDER_COMP_DATE) LIKE '%" .$monyy. "' AND  A.TM_USERID ='B'||C.HR_NO
				GROUP BY TM_USERID,C.EMP_NAME,B.EXCHANGE_CODE,D.STATION_CODE";
				*/
			$sql= "select TM_USERID HR_NO,a.EXCHANGE_CODE EXCH_CODE,b.EMP_NAME,c.STATION_CODE,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Provision' and MON_RENT<200 then 1 end)*5 LL5,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Provision' and MON_RENT>200 then 1 end)*10 LL10,
        COUNT(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' and MON_RENT<675 then 1 end)*5 BB5,
        COUNT(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' and MON_RENT>675 then 1 end)*10 BB10,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Broadband Provision' and MON_RENT<777 then 1 end)*5 FTTH5,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Broadband Provision' and MON_RENT>=777 then 1 end)*10 FTTH10
        from BEST_TT_JTO_NEW a,WG_STAFF B,EXCHANGE_CODE C
        where  a.EXCHANGE_CODE=C.EXCHANGE_CODE and TRUNC(a.ORDER_COMP_DATE) like '%" .$monyy. "' and  a.TM_USERID ='B'||B.HR_NO
        group by TM_USERID,a.EXCHANGE_CODE,b.EMP_NAME,c.STATION_CODE";
		}
		else if($designation == 'JTO'){
			$userid= "JTO_USERID";
			/*$sql= "SELECT JTO_USERID as HR_NO,C.EMP_NAME,C.JTO,D.STATION_CODE,
				count(case when ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision' then 1 end) LLPROV,
				count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NULL then 1 end) BBPROV,
				count(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NOT NULL then 1 end) LLBBPROV
				FROM BEST_TT_JTO A,CDR_CRM_ORDERS B,WG_STAFF C,EXCHANGE_CODE D WHERE A.ORDER_NO=B.ORDER_NO  AND B.EXCHANGE_CODE=D.EXCHANGE_CODE AND TRUNC(ORDER_COMP_DATE) LIKE '%" .$monyy. "' AND A.JTO_USERID ='B'||C.HR_NO
				GROUP BY JTO_USERID,C.EMP_NAME,C.JTO,D.STATION_CODE";*/
			$sql= "select JTO_USERID HR_NO,b.EMP_NAME,c.STATION_CODE,b.designation JTO,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Provision' and MON_RENT<200 then 1 end)*5 LL5,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Provision' and MON_RENT>200 then 1 end)*10 LL10,
        COUNT(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' and MON_RENT<675 then 1 end)*5 BB5,
        COUNT(case when ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' and MON_RENT>675 then 1 end)*10 BB10,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Broadband Provision' and MON_RENT<777 then 1 end)*5 FTTH5,
        COUNT(case when ORDER_TYPE='New' and ORDER_SUB_TYPE='Broadband Provision' and MON_RENT>=777 then 1 end)*10 FTTH10
        from BEST_TT_JTO_NEW a,WG_STAFF B,EXCHANGE_CODE C
        where  a.EXCHANGE_CODE=C.EXCHANGE_CODE and TRUNC(a.ORDER_COMP_DATE) like '%" .$monyy. "' and  a.JTO_USERID ='B'||B.HR_NO
        group by JTO_USERID,b.EMP_NAME,c.STATION_CODE,b.designation";
		}
		
		 $query = $this->oracle->query($sql);
		 return $query->result_array();
	 }
	 
	 function prov_details($designation,$hr_no,$prov_type,$monyy){
		  
		if($prov_type== "LLPROV")
    	{
    		$order_type = "a.ORDER_TYPE='New' AND a.ORDER_SUB_TYPE='Provision'";
    	}
    	else if ($prov_type== "BBPROV")
    	{
    		$order_type= "a.ORDER_TYPE='Modify' AND a.ORDER_sub_type='Broadband Provision'";
    	}
    	else if ($prov_type== "FTTHPROV")
    	{
    		$order_type= "a.ORDER_TYPE='New' AND a.ORDER_sub_type='Broadband Provision'";
    	}
		
		if($designation == 'TM'){
			$userid= "TM_USERID";
		}
		else if($designation == 'JTO'){
			$userid= "JTO_USERID";
		}
		
		/*$sql="SELECT a.EXCHANGE_CODE,A.HRMS_ID,A.MOBILE_NO,A.PHONE_NO, A.ORDER_NO, TO_CHAR(TRUNC(ORDER_COMP_DATE),'YYYY-MM-DD') ORDER_COMP_DATE,ORDER_TYPE, ORDER_SUB_TYPE, ORDER_STATUS,
	SERVICE_SUB_TYPE,CUSTOMER_NAME,BILL_ACCNT_TYPE, BILL_ACCNT_SUB_TYPE, CHANNEL FROM CDR_CRM_ORDERS A,BEST_TT_JTO_NEW B
WHERE  A.ORDER_NO=B.ORDER_NO AND SERVICE_TYPE in ('Landline', 'ISDN', 'DSPT', 'LL PCO','Bharat Fiber BB') AND TRUNC(ORDER_COMP_DATE) LIKE '%" .$monyy. "' AND " .$userid. "='" .$hr_no. "' AND " .$order_type;*/
$sql="Select a.EXCHANGE_CODE,a.PHONE_NO,a.ORDER_NO,TO_CHAR(TRUNC(a.ORDER_COMP_DATE),'DD-MM-YYYY') ORDER_COMP_DATE,a.name,a.PROV_TYPE,a.MON_RENT,B.CUSTOMER_NAME,b.MOBILE_NO
from BEST_TT_JTO_NEW a,CDR_CRM_ORDERS B 
WHERE  A.ORDER_NO=B.ORDER_NO AND TRUNC(a.ORDER_COMP_DATE) LIKE '%" .$monyy. "' AND " .$userid. "='" .$hr_no. "' AND " .$order_type;
		 $query = $this->oracle->query($sql);
		 return $query->result_array();
	 }
	 
	 
	 function crm_reports(){
		
			$sql= "select a.hr_no,a.emp_name,a.designation,a.location,(nvl(b.npc,0)*5) LLPROV,(nvl(c.bb_alone,0)*10) BBPROV,(nvl(d.followon_bb,0)*10) LLBBPROV from 
(select hr_no,emp_name,designation,location from wg_staff)a,
(select hrms_id,count(*) npc from cdr_crm_orders where hrms_id is not null  AND ORDER_STATUS='Complete' and ORDER_TYPE='New' AND order_sub_type='Provision' and hrms_id in(select distinct hr_no from wg_staff) group by hrms_id)b,
(select hrms_id,count(*) bb_alone from cdr_crm_orders where hrms_id is not null  AND ORDER_STATUS='Complete' and ORDER_TYPE='Modify' AND order_sub_type='Broadband Provision'  and par_order_id is null and hrms_id in(select distinct hr_no from wg_staff) group by hrms_id)c,
(select hrms_id,count(*) followon_bb from cdr_crm_orders where hrms_id is not null  AND ORDER_STATUS='Complete' and ORDER_TYPE='Modify' AND order_sub_type='Broadband Provision'  and par_order_id is not null and hrms_id in(select distinct hr_no from wg_staff) group by hrms_id)d
where a.hr_no=b.hrms_id(+) and  a.hr_no=c.hrms_id(+) and  a.hr_no=d.hrms_id(+)  and (b.npc is not null or c.bb_alone is not null or d.followon_bb is not null)";
		
		
		
		 $query = $this->oracle->query($sql);
		 return $query->result_array();
	 }
	 
	 function crm_prov_details($hr_no,$prov_type){
		  
		if($prov_type== "LLPROV")
    	{
    		$order_type = "ORDER_TYPE='New' AND ORDER_SUB_TYPE='Provision'";
    	}
    	else if ($prov_type== "BBPROV")
    	{
    		$order_type= "ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NULL";
    	}
    	else if ($prov_type== "LLBBPROV")
    	{
    		$order_type= "ORDER_TYPE='Modify' AND ORDER_sub_type='Broadband Provision' AND PAR_ORDER_ID IS NOT NULL";
    	}
		
		
		
		$sql="SELECT a.EXCHANGE_CODE,A.HRMS_ID,A.MOBILE_NO,A.PHONE_NO, A.ORDER_NO, TO_CHAR(TRUNC(ORDER_COMP_DATE),'YYYY-MM-DD') ORDER_COMP_DATE,ORDER_TYPE, ORDER_SUB_TYPE, ORDER_STATUS,
	SERVICE_SUB_TYPE,CUSTOMER_NAME,BILL_ACCNT_TYPE, BILL_ACCNT_SUB_TYPE, CHANNEL FROM CDR_CRM_ORDERS A
WHERE   SERVICE_TYPE in ('Landline', 'ISDN', 'DSPT', 'LL PCO','Bharat Fiber BB') AND a.ORDER_STATUS='Complete' AND HRMS_ID='" .$hr_no. "' AND " .$order_type;
		 $query = $this->oracle->query($sql);
		 return $query->result_array();
	 }
    
}