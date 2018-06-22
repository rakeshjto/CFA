<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_conversions_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->oracle=$this->load->database('default',true);
    }	
    
    function get_planconversions($fdate, $tdate, $conv_type)
    {
    	if($conv_type== 'l2h'){
			$lower_plans= "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99')";
			$lower_plans_custom = "('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plan_action= "Delete";
			$higher_plans= "('BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')"; 
			$higher_plans_custom = "('BB - BBG COMBO ULD 300GB PLAN')";
			$higher_plan_action= "Add";
		}
		else if($conv_type== 'h2l'){
			$higher_plans= "('BBG COMBO ULD 675 AP1','BB - BBG COMBO ULD 675 CS209','BB - BBG COMBO ULD 470 CS142','BBG COMBO ULD 999 - 8MBPS_60GB / 2 MBPS','FTTH BB - FIBRO COMBO ULD 645 CS95','FTTH BB - FIBRO COMBO ULD 1045 CS96','BBG COMBO ULD 945 - 8MBPS_40GB / 2 MBPS', 'BBG RURAL COMBO ULD 650','BBG ULD 545 - 2MBPS_15GB / 512 KBPS','BB - BBG COMBO ULD 1199','BB - BBG COMBO ULD 999 CS214','BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN')"; 
			$higher_plan_action= "Delete";
			$higher_plans_custom = "('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plans= "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plans_custom = "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99','BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN')";
			$lower_plan_action= "Add";
		}
		
		$sql= "SELECT B.SDE, COUNT(*) CNT FROM 
((SELECT A.ORDER_NO FROM 
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$lower_plans. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$lower_plan_action. "') A,
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$higher_plans. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$higher_plan_action. "') B
WHERE A.ORDER_NO=B.ORDER_NO)
UNION
(SELECT A.ORDER_NO FROM 
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$lower_plans_custom. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$lower_plan_action. "') A,
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$higher_plans_custom. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$higher_plan_action. "') B
WHERE A.ORDER_NO=B.ORDER_NO)) A,
(SELECT A.ORDER_NO,A.EXCHANGE_CODE, A.ORDER_TYPE, A.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE   FROM CDR_CRM_ORDERS A, EXCHANGE_CODE B WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(A.ORDER_COMP_DATE) BETWEEN '" .$fdate. "' AND '" .$tdate. "') B
WHERE A.ORDER_NO=B.ORDER_NO GROUP BY SDE ORDER BY CNT DESC";
    	//return $sql;
		$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
	
	function get_conv_sum_sde($sde, $fdate, $tdate, $conv_type)
    {
    	if($conv_type== 'l2h'){
			$lower_plans= "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99')";
			$lower_plans_custom = "('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plan_action= "Delete";
			$higher_plans= "('BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')"; 
			$higher_plans_custom = "('BB - BBG COMBO ULD 300GB PLAN')";
			$higher_plan_action= "Add";
		}
		else if($conv_type== 'h2l'){
			$higher_plans= "('BBG COMBO ULD 675 AP1','BB - BBG COMBO ULD 675 CS209','BB - BBG COMBO ULD 470 CS142','BBG COMBO ULD 999 - 8MBPS_60GB / 2 MBPS','FTTH BB - FIBRO COMBO ULD 645 CS95','FTTH BB - FIBRO COMBO ULD 1045 CS96','BBG COMBO ULD 945 - 8MBPS_40GB / 2 MBPS', 'BBG RURAL COMBO ULD 650','BBG ULD 545 - 2MBPS_15GB / 512 KBPS','BB - BBG COMBO ULD 1199','BB - BBG COMBO ULD 999 CS214','BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN')"; 
			$higher_plan_action= "Delete";
			$higher_plans_custom = "('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plans= "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plans_custom = "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99','BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN')";
			$lower_plan_action= "Add";
		}
		$sql= "SELECT A.LOWER_PLAN, A.HIGHER_PLAN,COUNT(*) CNT  FROM
((SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$lower_plans. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$lower_plan_action. "') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$higher_plans. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$higher_plan_action. "') B
WHERE A.ORDER_NO=B.ORDER_NO)
UNION
(SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$lower_plans_custom. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$lower_plan_action. "') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$higher_plans_custom. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$higher_plan_action. "') B
WHERE A.ORDER_NO=B.ORDER_NO)) A,
(SELECT A.ORDER_NO,A.EXCHANGE_CODE, A.ORDER_TYPE, A.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE   FROM CDR_CRM_ORDERS A, EXCHANGE_CODE B WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(A.ORDER_COMP_DATE) BETWEEN '" .$fdate. "' AND '" .$tdate. "' AND B.SDE='" .$sde. "') B
WHERE A.ORDER_NO=B.ORDER_NO GROUP BY A.LOWER_PLAN, A.HIGHER_PLAN ORDER BY CNT DESC";
    	//return $sql;
		$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
	
	function get_conv_det($sde, $fdate, $tdate, $conv_type )
    {
    	if($conv_type== 'l2h'){
			$lower_plans= "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99')";
			$lower_plans_custom = "('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plan_action= "Delete";
			$higher_plans= "('BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')"; 
			$higher_plans_custom = "('BB - BBG COMBO ULD 300GB PLAN')";
			$higher_plan_action= "Add";
		}
		else if($conv_type== 'h2l'){
			$higher_plans= "('BBG COMBO ULD 675 AP1','BB - BBG COMBO ULD 675 CS209','BB - BBG COMBO ULD 470 CS142','BBG COMBO ULD 999 - 8MBPS_60GB / 2 MBPS','FTTH BB - FIBRO COMBO ULD 645 CS95','FTTH BB - FIBRO COMBO ULD 1045 CS96','BBG COMBO ULD 945 - 8MBPS_40GB / 2 MBPS', 'BBG RURAL COMBO ULD 650','BBG ULD 545 - 2MBPS_15GB / 512 KBPS','BB - BBG COMBO ULD 1199','BB - BBG COMBO ULD 999 CS214','BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN')"; 
			$higher_plan_action= "Delete";
			$higher_plans_custom = "('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plans= "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249')";
			$lower_plans_custom = "('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99','BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN')";
			$lower_plan_action= "Add";
		}
		
		$sql= "SELECT A.ORDER_NO, A.LOWER_PLAN, A.HIGHER_PLAN,B.EXCHANGE_CODE, B.ORDER_TYPE, B.PHONE_NO,  B.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE  FROM
((SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$lower_plans. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$lower_plan_action. "') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$higher_plans. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$higher_plan_action. "') B
WHERE A.ORDER_NO=B.ORDER_NO)
UNION
(SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$lower_plans_custom. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$lower_plan_action. "') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN " .$higher_plans_custom. " AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='" .$higher_plan_action. "') B
WHERE A.ORDER_NO=B.ORDER_NO)) A,
(SELECT A.ORDER_NO,A.EXCHANGE_CODE, A.PHONE_NO, A.ORDER_TYPE, A.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE   FROM CDR_CRM_ORDERS A, EXCHANGE_CODE B WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(A.ORDER_COMP_DATE) BETWEEN '" .$fdate. "' AND '" .$tdate. "' AND B.SDE='" .$sde. "') B
WHERE A.ORDER_NO=B.ORDER_NO";
    	//return $sql;
		$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
    
}

// $del_plans= ['LL - PLAN 49_REVIVAL','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249','LL - EXPERIENCE LL 49'];
// $add_plans= ['BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN'];
// Global Vars for $higher_plans etc
// Aliases for 45 GB, 150 GB, 300 GB PLANS