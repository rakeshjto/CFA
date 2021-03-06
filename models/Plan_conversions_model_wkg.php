<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_conversions_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->oracle=$this->load->database('default',true);
    }	
    
    function get_planconversions($fdate, $tdate)
    {
    	$sql= "SELECT B.SDE, COUNT(*) CNT FROM 
((SELECT A.ORDER_NO FROM 
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Delete') A,
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Add') B
WHERE A.ORDER_NO=B.ORDER_NO)
UNION
(SELECT A.ORDER_NO FROM 
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Delete') A,
(SELECT ORDER_NO FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB - BBG COMBO ULD 300GB PLAN') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Add') B
WHERE A.ORDER_NO=B.ORDER_NO)) A,
(SELECT A.ORDER_NO,A.EXCHANGE_CODE, A.ORDER_TYPE, A.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE   FROM CDR_CRM_ORDERS A, EXCHANGE_CODE B WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(A.ORDER_COMP_DATE) BETWEEN '" .$fdate. "' AND '" .$tdate. "') B
WHERE A.ORDER_NO=B.ORDER_NO GROUP BY SDE ORDER BY CNT DESC";
    	//return $sql;
		$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
	
	function get_lower_to_higher_sum($sde, $fdate, $tdate)
    {
    	$sql= "SELECT A.LOWER_PLAN, A.HIGHER_PLAN,COUNT(*) CNT  FROM
((SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Delete') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Add') B
WHERE A.ORDER_NO=B.ORDER_NO)
UNION
(SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Delete') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB - BBG COMBO ULD 300GB PLAN') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Add') B
WHERE A.ORDER_NO=B.ORDER_NO)) A,
(SELECT A.ORDER_NO,A.EXCHANGE_CODE, A.ORDER_TYPE, A.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE   FROM CDR_CRM_ORDERS A, EXCHANGE_CODE B WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(A.ORDER_COMP_DATE) BETWEEN '" .$fdate. "' AND '" .$tdate. "' AND B.SDE='" .$sde. "') B
WHERE A.ORDER_NO=B.ORDER_NO GROUP BY A.LOWER_PLAN, A.HIGHER_PLAN ORDER BY CNT DESC";
    	//return $sql;
		$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
	
	function get_lower_to_higher($sde, $fdate, $tdate)
    {
    	$sql= "SELECT A.ORDER_NO, A.LOWER_PLAN, A.HIGHER_PLAN,B.EXCHANGE_CODE, B.ORDER_TYPE, B.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE  FROM
((SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('LL - PLAN 49_REVIVAL','LL - EXPERIENCE LL 49','LL PLAN 99') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Delete') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Add') B
WHERE A.ORDER_NO=B.ORDER_NO)
UNION
(SELECT A.ORDER_NO,A.PRODUCT_NAME LOWER_PLAN,B.PRODUCT_NAME HIGHER_PLAN  FROM 
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Delete') A,
(SELECT ORDER_NO,PRODUCT_NAME FROM ORDER_ITEMS WHERE PRODUCT_NAME IN ('BB - BBG COMBO ULD 300GB PLAN') AND PROD_CATG_CD IN ('Plan','Combo Plan') AND PRODUCT_STATUS='Add') B
WHERE A.ORDER_NO=B.ORDER_NO)) A,
(SELECT A.ORDER_NO,A.EXCHANGE_CODE, A.ORDER_TYPE, A.ORDER_SUB_TYPE,B.STATION_CODE,B.SDE   FROM CDR_CRM_ORDERS A, EXCHANGE_CODE B WHERE A.EXCHANGE_CODE=B.EXCHANGE_CODE AND TRUNC(A.ORDER_COMP_DATE) BETWEEN '" .$fdate. "' AND '" .$tdate. "' AND B.SDE='" .$sde. "') B
WHERE A.ORDER_NO=B.ORDER_NO";
    	//return $sql;
		$query = $this->oracle->query($sql);
    	return $query->result_array();
    	 
    }
    
}

// $del_plans= ['LL - PLAN 49_REVIVAL','BB  EXPERIENCE UNLIMITED COMBO BROADBAND 249','LL - EXPERIENCE LL 49'];
// $add_plans= ['BB - BBG COMBO ULD 45GB PLAN','BB - BBG COMBO ULD 150GB PLAN','BB - BBG COMBO ULD 300GB PLAN'];
