<?php
	/*###############################################################################################
		Company Name 		:-	Virtual Sys Technologies, INDIA
		Project Name		:-	Profit-X 1.1
		Page/Script Name	:-	class.settings.php
		Description			:- 	class file
		Created By & Date	:- VsT Dev Team, 20th/Oct/2010
		Modified By & Date	:-  Sreechand.Ks, 15th/June/2011, Xtreme Technologies,UAE
	################################################################################################*/
	class Settings extends dbcon
	{
		################	MEMBER VARIABLES SECTION	##############
		/*For Automatic Code Generation*/
		var $_setting_id;
		var $_setting_head_code;
		var	$_setting_group_code;
		var	$_setting_account;
		var $_setting_subaccount;
		var $_setting_code;
		/*For Department Parameters*/
		var $_dept_parameter_id;
		var $_dept_parameter_department_id;
		var $_dept_parameter_department_code;
		var $_dept_parameter_cash_account_id;
		var $_dept_parameter_cash_account_code;
		var $_dept_parameter_sales_account_id;
		var $_dept_parameter_sales_account_code;
		var $_dept_parameter_customer_cash_account_id;
		var $_dept_parameter_customer_cash_account_code;
		var $_dept_parameter_bank_account_id;
		var $_dept_parameter_bank_account_code;
		var $_dept_parameter_credit_card_account_id;
		var $_dept_parameter_credit_card_account_code;
		var $_dept_parameter_credit_account_id;
		var $_dept_parameter_credit_account_code;
		var $_dept_parameter_pdc_issue_account_id;
		var $_dept_parameter_pdc_issue_account_code;
		var $_dept_parameter_pdc_receive_account_id;
		var $_dept_parameter_pdc_receive_account_code;
		var $_dept_parameter_inventory_account_id;
		var $_dept_parameter_inventory_account_code;
		var $_dept_parameter_cost_sale_account_id;
		var $_dept_parameter_cost_sale_account_code;
		var $_dept_parameter_local_purchase_account_id;
		var $_dept_parameter_local_purchase_account_code;
		var $_dept_parameter_import_purchase_account_id;
		var $_dept_parameter_import_purchase_account_code;
		var $_dept_parameter_purchase_return_account_id;
		var $_dept_parameter_purchase_return_account_code;
		var $_dept_parameter_sales_return_account_id;
		var $_dept_parameter_sales_return_account_code;
		var $_dept_parameter_cheque_return_account_id;
		var $_dept_parameter_cheque_return_account_code;
		var $_dept_parameter_discount_account_id;
		var $_dept_parameter_discount_account_code;
		var $_dept_parameter_discount_allowed_account_id;
		var $_dept_parameter_discount_allowed_account_code;
		var $_dept_parameter_discount_received_account_id;
		var $_dept_parameter_discount_received_account_code;
		var $_dept_parameter_wip_account_id;
		var $_dept_parameter_wip_account_code;
		var $_dept_parameter_quot;
		var $_dept_parameter_so_no;
		var $_dept_parameter_do_no;
		var $_dept_parameter_si_no;
		var	$_dept_parameter_rv_num;
		var	$_dept_parameter_se_num;
		var $_dept_parameter_pe_no;
		var $_dept_parameter_po_no;
		var $_dept_parameter_mrv_no;
		var $_dept_parameter_pi_num;
		var $_dept_parameter_pv_num;
		var $_dept_parameter_pc_num;
		var $_dept_parameter_credit_invno;
		var $_dept_parameter_cq_num;
		var $_dept_parameter_cash_inv;
		var $_dept_parameter_w_inv;
		var $_dept_parameter_ir_num;
		var $_dept_parameter_srtn_num;
		var $_dept_parameter_psrtn_num;
		var $_dept_parameter_pj_num;
		var $_dept_parameter_trfr_no;
		var $_dept_parameter_local_trfr_no;
		var $_dept_parameter_local_ip_local;
		var $_dept_parameter_local_ip_import;
		var $_dept_parameter_bank_r;
		var $_dept_parameter_next_bp;
		var $_dept_parameter_dn_num;
		var $_dept_parameter_cn_num;
		var $_dept_parameter_jv_num;
		var $_dept_parameter_db_no;
		var $_dept_parameter_cb_no;
		var $_dept_parameter_transaction_method;
		var $_dept_parameter_flag;
		var $_dept_parameter_sales_serial_no_type;
		var $_dept_parameter_start_date;
		var $_dept_parameter_end_date;
		var $_dept_parameter_status;
		var $_output_alert;
		################	MEMBER FUNCTIONS SECTION	##############
		function GetSettingDetails(){
			$Sqlcmd="SELECT * FROM aip_settings";
			$this->Query($Sqlcmd);
			if($this->_num_rows > 0){
			$i=0;
			while($row=mysqli_fetch_object($this->_result)){
					$records[$i]['settings_head_code']			=	$row->settings_head_code;
					$records[$i]['settings_group_code']			=	$row->settings_group_code;
					$records[$i]['settings_account_code']		=	$row->settings_account_code;
					$records[$i]['settings_sub_account_code']	=	$row->settings_sub_account_code;
					$i++;
				}
				return $records;
			}
			else return false;
		}//END FUNCTION
		function UpdateSettingDetails($case){
			$Sqlcmd	=	"UPDATE  aip_settings SET";
				if($case=="head")
					$Sqlcmd	=$Sqlcmd." settings_head_code=".$this->_setting_code."";
				if($case=="group")
					$Sqlcmd	=	$Sqlcmd." settings_group_code=".$this->_setting_code."";
				if($case=="account")
					$Sqlcmd	=	$Sqlcmd." settings_account_code=".$this->_setting_code."";
				if($case=="subaccount")
			$Sqlcmd	=	$Sqlcmd." settings_sub_account_code=".$this->_setting_code."";
				$this->Query($Sqlcmd);
				return ($this->mysqlerror())?false:true;
		}
		function SaveDeptParameter($id=''){
		if($id)
			$Sqlcmd	=	"UPDATE";
		else
			$Sqlcmd	=	"INSERT INTO";
		$Sqlcmd	=	$Sqlcmd." aip_department_parameter SET";
		//if($this->_dept_parameter_department_code)
			$Sqlcmd	=	$Sqlcmd." dept_parameter_department_code='".$this->_dept_parameter_department_code."'";
		if($this->_dept_parameter_department_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_department_id=".$this->_dept_parameter_department_id;
		if($this->_dept_parameter_cash_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cash_account_id=".$this->_dept_parameter_cash_account_id;
		if($this->_dept_parameter_cash_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cash_account_code=".$this->_dept_parameter_cash_account_code;
		if($this->_dept_parameter_sales_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_sales_account_id=".$this->_dept_parameter_sales_account_id;
		if($this->_dept_parameter_sales_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_sales_account_code=".$this->_dept_parameter_sales_account_code;
		if($this->_dept_parameter_customer_cash_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_customer_cash_account_id=".$this->_dept_parameter_customer_cash_account_id;
		if($this->_dept_parameter_customer_cash_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_customer_cash_account_code=".$this->_dept_parameter_customer_cash_account_code;
		if($this->_dept_parameter_bank_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_bank_account_id=".$this->_dept_parameter_bank_account_id;
		if($this->_dept_parameter_bank_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_bank_account_code=".$this->_dept_parameter_bank_account_code;
		if($this->_dept_parameter_credit_card_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_credit_card_account_id=".$this->_dept_parameter_credit_card_account_id;
		if($this->_dept_parameter_credit_card_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_credit_card_account_code=".$this->_dept_parameter_credit_card_account_code;
		if($this->_dept_parameter_credit_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_credit_account_id=".$this->_dept_parameter_credit_account_id;
		if($this->_dept_parameter_credit_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_credit_account_code=".$this->_dept_parameter_credit_account_code;
		if($this->_dept_parameter_pdc_issue_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pdc_issue_account_id=".$this->_dept_parameter_pdc_issue_account_id;
		if($this->_dept_parameter_pdc_issue_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pdc_issue_account_code=".$this->_dept_parameter_pdc_issue_account_code;
		if($this->_dept_parameter_pdc_receive_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pdc_receive_account_id=".$this->_dept_parameter_pdc_receive_account_id;
		if($this->_dept_parameter_pdc_receive_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pdc_receive_account_code=".$this->_dept_parameter_pdc_receive_account_code;
if($this->_dept_parameter_inventory_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_inventory_account_id=".$this->_dept_parameter_inventory_account_id;
		if($this->_dept_parameter_inventory_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_inventory_account_code=".$this->_dept_parameter_inventory_account_code;
		if($this->_dept_parameter_cost_sale_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cost_sale_account_id=".$this->_dept_parameter_cost_sale_account_id;
		if($this->_dept_parameter_cost_sale_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cost_sale_account_code=".$this->_dept_parameter_cost_sale_account_code;
		if($this->_dept_parameter_local_purchase_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_local_purchase_account_id=".$this->_dept_parameter_local_purchase_account_id;
		if($this->_dept_parameter_local_purchase_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_local_purchase_account_code=".$this->_dept_parameter_local_purchase_account_code;
		if($this->_dept_parameter_import_purchase_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_import_purchase_account_id=".$this->_dept_parameter_import_purchase_account_id;
		if($this->_dept_parameter_import_purchase_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_import_purchase_account_code=".$this->_dept_parameter_import_purchase_account_code;
		if($this->_dept_parameter_purchase_return_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_purchase_return_account_id=".$this->_dept_parameter_purchase_return_account_id;
		if($this->_dept_parameter_purchase_return_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_purchase_return_account_code=".$this->_dept_parameter_purchase_return_account_code;
		if($this->_dept_parameter_sales_return_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_sales_return_account_id=".$this->_dept_parameter_sales_return_account_id;
		if($this->_dept_parameter_sales_return_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_sales_return_account_code=".$this->_dept_parameter_sales_return_account_code;
		if($this->_dept_parameter_cheque_return_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cheque_return_account_id=".$this->_dept_parameter_cheque_return_account_id;
		if($this->_dept_parameter_cheque_return_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cheque_return_account_code=".$this->_dept_parameter_cheque_return_account_code;
		if($this->_dept_parameter_discount_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_discount_account_id=".$this->_dept_parameter_discount_account_id;
		if($this->_dept_parameter_discount_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_discount_account_code=".$this->_dept_parameter_discount_account_code;
		if($this->_dept_parameter_discount_allowed_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_discount_allowed_account_id=".$this->_dept_parameter_discount_allowed_account_id;
		if($this->_dept_parameter_discount_allowed_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_discount_allowed_account_code=".$this->_dept_parameter_discount_allowed_account_code;
		if($this->_dept_parameter_discount_received_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_discount_received_account_id=".$this->_dept_parameter_discount_received_account_id;
		if($this->_dept_parameter_discount_received_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_discount_received_account_code=".$this->_dept_parameter_discount_received_account_code;
		if($this->_dept_parameter_wip_account_id)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_wip_account_id=".$this->_dept_parameter_wip_account_id;
		if($this->_dept_parameter_wip_account_code)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_wip_account_code=".$this->_dept_parameter_wip_account_code;
		if($this->_dept_parameter_quot)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_quote=".$this->_dept_parameter_quot;
		if($this->_dept_parameter_so_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_so_no=".$this->_dept_parameter_so_no;
		if($this->_dept_parameter_do_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_do_no=".$this->_dept_parameter_do_no;
		if($this->_dept_parameter_si_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_si_no=".$this->_dept_parameter_si_no;
		if($this->_dept_parameter_rv_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_rv_num=".$this->_dept_parameter_rv_num;
		if($this->_dept_parameter_se_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_se_num=".$this->_dept_parameter_se_num;
		if($this->_dept_parameter_pe_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pe_no=".$this->_dept_parameter_pe_no;
		if($this->_dept_parameter_po_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_po_no=".$this->_dept_parameter_po_no;
		if($this->_dept_parameter_mrv_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_mrv_no=".$this->_dept_parameter_mrv_no;
		if($this->_dept_parameter_pi_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pi_num=".$this->_dept_parameter_pi_num;
		if($this->_dept_parameter_pv_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pv_num=".$this->_dept_parameter_pv_num;
		if($this->_dept_parameter_pc_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pc_num=".$this->_dept_parameter_pc_num;
		if($this->_dept_parameter_credit_invno)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_credit_invno=".$this->_dept_parameter_credit_invno;
		if($this->_dept_parameter_cq_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cq_num=".$this->_dept_parameter_cq_num;
		if($this->_dept_parameter_cash_inv)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cash_inv=".$this->_dept_parameter_cash_inv;
		if($this->_dept_parameter_w_inv)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_w_inv=".$this->_dept_parameter_w_inv;
		if($this->_dept_parameter_ir_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_ir_num=".$this->_dept_parameter_ir_num;
		if($this->_dept_parameter_srtn_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_srtn_num=".$this->_dept_parameter_srtn_num;
		if($this->_dept_parameter_psrtn_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_psrtn_num=".$this->_dept_parameter_psrtn_num;
		if($this->_dept_parameter_pj_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_pj_num=".$this->_dept_parameter_pj_num;
		if($this->_dept_parameter_trfr_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_trfr_no=".$this->_dept_parameter_trfr_no;
		if($this->_dept_parameter_local_trfr_no)
			$Sqlcmd	=	$Sqlcmd." , dept_parameter_local_trfr_no=".$this->_dept_parameter_local_trfr_no;
		if($this->_dept_parameter_local_ip_local)
			$Sqlcmd	=	$Sqlcmd." , dept_parameter_local_ip_local=".$this->_dept_parameter_local_ip_local;
		if($this->_dept_parameter_local_ip_import)
			$Sqlcmd	=	$Sqlcmd." , dept_parameter_local_ip_import=".$this->_dept_parameter_local_ip_import;
		if($this->_dept_parameter_bank_r)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_bank_r=".$this->_dept_parameter_bank_r;
		if($this->_dept_parameter_next_bp)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_next_bp=".$this->_dept_parameter_next_bp;
		if($this->_dept_parameter_dn_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_dn_num=".$this->_dept_parameter_dn_num;
		if($this->_dept_parameter_cn_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cn_num=".$this->_dept_parameter_cn_num;
		if($this->_dept_parameter_jv_num)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_jv_num=".$this->_dept_parameter_jv_num;
		if($this->_dept_parameter_db_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_db_no=".$this->_dept_parameter_db_no;
		if($this->_dept_parameter_cb_no)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_cb_no=".$this->_dept_parameter_cb_no;
		if($this->_dept_parameter_transaction_method)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_transaction_method='".$this->_dept_parameter_transaction_method."'";
		if($this->_dept_parameter_flag)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_flag='".$this->_dept_parameter_flag."'";
		if($this->_dept_parameter_sales_serial_no_type)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_sales_serial_no_type='".$this->_dept_parameter_sales_serial_no_type."'";
		if($this->_dept_parameter_start_date)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_start_date='".$this->_dept_parameter_start_date."'";
		if($this->_dept_parameter_end_date)
			$Sqlcmd	=	$Sqlcmd.", dept_parameter_end_date='".$this->_dept_parameter_end_date."'";
		if($id)
			$Sqlcmd	=	$Sqlcmd." WHERE dept_parameter_id=".$id;
			//echo $this->_dept_parameter_department_code."<br/>";
			//echo $id."<br/>";
			//echo $Sqlcmd; exit;
		if(!$this->GetDeptParameterDetails('','','',$this->_dept_parameter_department_code,$id,'')){
			//echo "<br/>******************";
			$this->Query($Sqlcmd);
			$this->_output_alert="Ok";
		}else{
			$this->_output_alert="Exist";
			return false;
		}
		return ($this->mysqlerror())?false:true;
	}//END FUNCTION
	function GetDeptParameterDetails($id='',$dept_id='',$status='',$dept_code='',$actionid='',$search=''){
		//echo '***********'.$dept_id;
		$Sqlcmd			=	"SELECT * FROM aip_department_parameter WHERE 1";
		if($id)
			$Sqlcmd		=	$Sqlcmd." AND dept_parameter_id=".$id;
		if($dept_id!="")
			$Sqlcmd		=	$Sqlcmd." AND dept_parameter_department_id=".$dept_id;
			//echo $Sqlcmd."<br/>";
		if(($status) and ($status!="All"))
			$Sqlcmd		=	$Sqlcmd." AND dept_parameter_status='".$status."'";
		if($dept_code)
			$Sqlcmd		=	$Sqlcmd." AND dept_parameter_department_code='".$dept_code."'" ;
		if($actionid)
			$Sqlcmd		=	$Sqlcmd." AND dept_parameter_id!=".$actionid;
		if($search)
			$Sqlcmd		=	$Sqlcmd."  AND (dept_parameter_department_code like '%$search%')";
			$Sqlcmd		=	$Sqlcmd." ORDER BY dept_parameter_id";
			//echo $Sqlcmd;
			if($this->_sql_excu_method=="sqltran")	$this->TransQuery($Sqlcmd); else $this->Query($Sqlcmd);
			if($this->_num_rows > 0){
				$i=0;
				while($row=mysqli_fetch_object($this->_result)){
					$records[$i]['dept_parameter_id']							=	$row->dept_parameter_id;
					$records[$i]['dept_parameter_department_id']				=	$row->dept_parameter_department_id;
					$records[$i]['dept_parameter_department_code']				=	$row->dept_parameter_department_code;
					$records[$i]['dept_parameter_cash_account_id']				=	$row->dept_parameter_cash_account_id;
					$records[$i]['dept_parameter_cash_account_code']			=	$row->dept_parameter_cash_account_code;
					$records[$i]['dept_parameter_sales_account_id']				=	$row->dept_parameter_sales_account_id;
					$records[$i]['dept_parameter_sales_account_code']			=	$row->dept_parameter_sales_account_code;
					$records[$i]['dept_parameter_customer_cash_account_id']		=	$row->dept_parameter_customer_cash_account_id;
					$records[$i]['dept_parameter_customer_cash_account_code']	=	$row->dept_parameter_customer_cash_account_code;
					$records[$i]['dept_parameter_bank_account_id']				=	$row->dept_parameter_bank_account_id;
					$records[$i]['dept_parameter_bank_account_code']			=	$row->dept_parameter_bank_account_code;
					$records[$i]['dept_parameter_credit_card_account_id']		=	$row->dept_parameter_credit_card_account_id;
					$records[$i]['dept_parameter_credit_card_account_code']		=	$row->dept_parameter_credit_card_account_code;
					$records[$i]['dept_parameter_credit_account_id']			=	$row->dept_parameter_credit_account_id;
					$records[$i]['dept_parameter_credit_account_code']			=	$row->dept_parameter_credit_account_code;
					$records[$i]['dept_parameter_pdc_issue_account_id']			=	$row->dept_parameter_pdc_issue_account_id;
					$records[$i]['dept_parameter_pdc_issue_account_code']		=	$row->dept_parameter_pdc_issue_account_code;
					$records[$i]['dept_parameter_pdc_receive_account_id']		=	$row->dept_parameter_pdc_receive_account_id;
					$records[$i]['dept_parameter_pdc_receive_account_code']		=	$row->dept_parameter_pdc_receive_account_code;
					$records[$i]['dept_parameter_inventory_account_id']			=	$row->dept_parameter_inventory_account_id;
					$records[$i]['dept_parameter_inventory_account_code']		=	$row->dept_parameter_inventory_account_code;
					$records[$i]['dept_parameter_cost_sale_account_id']			=	$row->dept_parameter_cost_sale_account_id;
					$records[$i]['dept_parameter_cost_sale_account_code']		=	$row->dept_parameter_cost_sale_account_code;
					$records[$i]['dept_parameter_local_purchase_account_id']	=	$row->dept_parameter_local_purchase_account_id;
					$records[$i]['dept_parameter_local_purchase_account_code']	=	$row->dept_parameter_local_purchase_account_code;
					$records[$i]['dept_parameter_import_purchase_account_id']	=	$row->dept_parameter_import_purchase_account_id;
					$records[$i]['dept_parameter_import_purchase_account_code']	=	$row->dept_parameter_import_purchase_account_code;
					$records[$i]['dept_parameter_purchase_return_account_id']	=	$row->dept_parameter_purchase_return_account_id;
					$records[$i]['dept_parameter_purchase_return_account_code']	=	$row->dept_parameter_purchase_return_account_code;
					$records[$i]['dept_parameter_sales_return_account_id']		=	$row->dept_parameter_sales_return_account_id;
					$records[$i]['dept_parameter_sales_return_account_code']	=	$row->dept_parameter_sales_return_account_code;
					$records[$i]['dept_parameter_cheque_return_account_id']		=	$row->dept_parameter_cheque_return_account_id;
					$records[$i]['dept_parameter_cheque_return_account_code']	=	$row->dept_parameter_cheque_return_account_code;
					$records[$i]['dept_parameter_discount_account_id']			=	$row->dept_parameter_discount_account_id;
					$records[$i]['dept_parameter_discount_account_code']		=	$row->dept_parameter_discount_account_code;
					$records[$i]['dept_parameter_discount_allowed_account_id']	=	$row->dept_parameter_discount_allowed_account_id;
					$records[$i]['dept_parameter_discount_allowed_account_code']=	$row->dept_parameter_discount_allowed_account_code;
					$records[$i]['dept_parameter_discount_received_account_id']	=	$row->dept_parameter_discount_received_account_id;
					$records[$i]['dept_parameter_discount_received_account_code']=	$row->dept_parameter_discount_received_account_code;
					$records[$i]['dept_parameter_wip_account_id']				=	$row->dept_parameter_wip_account_id;
					$records[$i]['dept_parameter_wip_account_code']				=	$row->dept_parameter_wip_account_code;
					$records[$i]['dept_parameter_quote']						=	$row->dept_parameter_quote;
					$records[$i]['dept_parameter_so_no']						=	$row->dept_parameter_so_no;
					$records[$i]['dept_parameter_do_no']						=	$row->dept_parameter_do_no;
					$records[$i]['dept_parameter_si_no']						=	$row->dept_parameter_si_no;
					$records[$i]['dept_parameter_rv_num']						=	$row->dept_parameter_rv_num;
					$records[$i]['dept_parameter_se_num']						=	$row->dept_parameter_se_num;
					$records[$i]['dept_parameter_pe_no']						=	$row->dept_parameter_pe_no;
					$records[$i]['dept_parameter_po_no']						=	$row->dept_parameter_po_no;
					$records[$i]['dept_parameter_mrv_no']						=	$row->dept_parameter_mrv_no;
					$records[$i]['dept_parameter_pi_num']						=	$row->dept_parameter_pi_num;
					$records[$i]['dept_parameter_pv_num']						=	$row->dept_parameter_pv_num;
					$records[$i]['dept_parameter_pc_num']						=	$row->dept_parameter_pc_num;
					$records[$i]['dept_parameter_credit_invno']					=	$row->dept_parameter_credit_invno;
					$records[$i]['dept_parameter_cq_num']						=	$row->dept_parameter_cq_num;
					$records[$i]['dept_parameter_cash_inv']						=	$row->dept_parameter_cash_inv;
					$records[$i]['dept_parameter_w_inv']						=	$row->dept_parameter_w_inv;
					$records[$i]['dept_parameter_ir_num']						=	$row->dept_parameter_ir_num;
					$records[$i]['dept_parameter_srtn_num']						=	$row->dept_parameter_srtn_num;
					$records[$i]['dept_parameter_psrtn_num']					=	$row->dept_parameter_psrtn_num;
					$records[$i]['dept_parameter_pj_num']						=	$row->dept_parameter_pj_num;
					$records[$i]['dept_parameter_trfr_no']						=	$row->dept_parameter_trfr_no;
					$records[$i]['dept_parameter_local_trfr_no']				=	$row->dept_parameter_local_trfr_no;
					$records[$i]['dept_parameter_local_ip_local']				=	$row->dept_parameter_local_ip_local;
					$records[$i]['dept_parameter_local_ip_import']				=	$row->dept_parameter_local_ip_import;
					$records[$i]['dept_parameter_bank_r']						=	$row->dept_parameter_bank_r;
					$records[$i]['dept_parameter_next_bp']						=	$row->dept_parameter_next_bp;
					$records[$i]['dept_parameter_dn_num']						=	$row->dept_parameter_dn_num;
					$records[$i]['dept_parameter_cn_num']						=	$row->dept_parameter_cn_num;
					$records[$i]['dept_parameter_jv_num']						=	$row->dept_parameter_jv_num;
					$records[$i]['dept_parameter_db_no']						=	$row->dept_parameter_db_no;
					$records[$i]['dept_parameter_cb_no']						=	$row->dept_parameter_cb_no;
					$records[$i]['dept_parameter_transaction_method']			=	$row->dept_parameter_transaction_method;
					$records[$i]['dept_parameter_flag']							=	$row->dept_parameter_flag;
					$records[$i]['dept_parameter_sales_serial_no_type']			=	$row->dept_parameter_sales_serial_no_type;
					$records[$i]['dept_parameter_start_date']					=	$row->dept_parameter_start_date;
					$records[$i]['dept_parameter_end_date']						=	$row->dept_parameter_end_date;
					$records[$i]['dept_parameter_status']						=	$row->dept_parameter_status;
					$i++;
				}
				return $records;
			}
			else return false;
		}// END FUNCTION
		function GetNumbers($id=''){
			$Sqlcmd	="SELECT dept_parameter_quote,dept_parameter_si_no,dept_parameter_pe_no,
				dept_parameter_po_no ,dept_parameter_pi_num,dept_parameter_pv_num,dept_parameter_rv_num FROM aip_department_parameter WHERE dept_parameter_department_id=".$id;
			$this->Query($Sqlcmd);
			if($this->_num_rows > 0){
				$i=0;
				while($row=mysqli_fetch_object($this->_result)){
					$records[$i]['dept_parameter_quote']				=	$row->dept_parameter_quote;
					$records[$i]['dept_parameter_si_no']				=	$row->dept_parameter_si_no;
					$records[$i]['dept_parameter_pe_no']				=	$row->dept_parameter_pe_no;
					$records[$i]['dept_parameter_po_no']				=	$row->dept_parameter_po_no;
					$records[$i]['dept_parameter_pi_num']				=	$row->dept_parameter_pi_num;
					$records[$i]['dept_parameter_pv_num']				=	$row->dept_parameter_pv_num;
					$records[$i]['dept_parameter_rv_num']				=	$row->dept_parameter_rv_num;
				$i++;
				}
				return $records;
			}
			else return false;
		}//END FUNCTION
	function GetTransactionItemDetection($id=''){
		$Sqlcmd	=	" SELECT dept_parameter_flag,dept_parameter_transaction_method,dept_parameter_inventory_account_id,dept_parameter_inventory_account_code,dept_parameter_cost_sale_account_id,dept_parameter_cost_sale_account_code FROM aip_department_parameter WHERE dept_parameter_department_id=".$id;
		if($this->_sql_excu_method=="sqltran")	$this->TransQuery($Sqlcmd); else $this->Query($Sqlcmd);
		if($this->_num_rows > 0){
			$i=0;
			while($row=mysqli_fetch_object($this->_result)){
				$records[$i]['dept_parameter_flag']						=	$row->dept_parameter_flag;
				$records[$i]['dept_parameter_transaction_method']		=	$row->dept_parameter_transaction_method;
				$records[$i]['dept_parameter_inventory_account_id']		=	$row->dept_parameter_inventory_account_id;
				$records[$i]['dept_parameter_inventory_account_code']	=	$row->dept_parameter_inventory_account_code;
				$records[$i]['dept_parameter_cost_sale_account_id']		=	$row->dept_parameter_cost_sale_account_id;
				$records[$i]['dept_parameter_cost_sale_account_code']	=	$row->dept_parameter_cost_sale_account_code;
			$i++;
			}
			return $records;
		}
		else return false;
	}//END FUNCTION
	function StatusChange($id,$status){
		$Sqlcmd="UPDATE aip_department_parameter SET  dept_parameter_status='".$status."' WHERE dept_parameter_id=".$id;
		$this->Query($Sqlcmd);
		//echo $Sqlcmd;
		return ($this->mysqlerror())?false:true;
	}//END FUNCTION
} // END CLASS
?>