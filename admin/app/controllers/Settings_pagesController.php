<?php 
/**
 * Settings_pages Page Controller
 * @category  Controller
 */
class Settings_pagesController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "settings_pages";
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
		$fields = $this->fields = array("id","privacy_policy","terms_conditions","help_faq","about_us","504_page");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'privacy_policy' => 'required',
				'terms_conditions' => 'required',
				'help_faq' => 'required',
				'about_us' => 'required',
				'504_page' => 'required',
			);
			$this->sanitize_array = array(
				'privacy_policy' => 'sanitize_string',
				'terms_conditions' => 'sanitize_string',
				'help_faq' => 'sanitize_string',
				'about_us' => 'sanitize_string',
				'504_page' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("settings_pages.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("settings_pages/edit/$rec_id");
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
						return	$this->redirect("settings_pages/edit/$rec_id");
					}
				}
			}
		}
		$db->where("settings_pages.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Settings Pages";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("settings_pages/edit.php", $data);
	}
}
