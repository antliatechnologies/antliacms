<?php 
/**
 * Settings Page Controller
 * @category  Controller
 */
class SettingsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "settings";
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","auto_approve_posts","mail_admin_post","admin_mail","wait_approve_message");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'auto_approve_posts' => 'required',
				'mail_admin_post' => 'required',
				'admin_mail' => 'required',
				'wait_approve_message' => 'required',
			);
			$this->sanitize_array = array(
				'auto_approve_posts' => 'sanitize_string',
				'mail_admin_post' => 'sanitize_string',
				'admin_mail' => 'sanitize_string',
				'wait_approve_message' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_updated'] = datetime_now();
			if($this->validated()){
				$db->where("settings.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("settings/edit/$rec_id");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("settings/edit/$rec_id");
					}
				}
			}
		}
		$db->where("settings.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Settings";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("settings/edit.php", $data);
	}
}
