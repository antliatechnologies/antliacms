<?php 
/**
 * Articlecomments Page Controller
 * @category  Controller
 */
class ArticlecommentsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "articlecomments";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("articlecomments.id", 
			"articlecomments.articleid", 
			"articles.title AS articles_title", 
			"articlecomments.userid", 
			"users.username AS users_username", 
			"articlecomments.comment", 
			"articlecomments.date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				articlecomments.id LIKE ? OR 
				articlecomments.articleid LIKE ? OR 
				articlecomments.userid LIKE ? OR 
				articlecomments.comment LIKE ? OR 
				articlecomments.status LIKE ? OR 
				articlecomments.date_created LIKE ? OR 
				articlecomments.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "articlecomments/search.php";
		}
		$db->join("articles", "articlecomments.articleid = articles.id", "INNER");
		$db->join("users", "articlecomments.userid = users.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("articlecomments.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Articlecomments";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$view_name = (is_ajax() ? "articlecomments/ajax-list.php" : "articlecomments/list.php");
		$this->render_view($view_name, $data);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("articlecomments.id", 
			"articlecomments.articleid", 
			"articles.title AS articles_title", 
			"articlecomments.userid", 
			"users.username AS users_username", 
			"articlecomments.comment", 
			"articlecomments.status", 
			"articlecomments.date_created", 
			"articlecomments.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("articlecomments.id", $rec_id);; //select record based on primary key
		}
		$db->join("articles", "articlecomments.articleid = articles.id", "INNER");
		$db->join("users", "articlecomments.userid = users.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Articlecomments";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("articlecomments/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("articleid","userid","comment");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'articleid' => 'required',
				'userid' => 'required',
				'comment' => 'required',
			);
			$this->sanitize_array = array(
				'articleid' => 'sanitize_string',
				'userid' => 'sanitize_string',
				'comment' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_created'] = datetime_now();
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("articlecomments");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Articlecomments";
		$this->render_view("articlecomments/add.php");
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
		$fields = $this->fields = array("id","articleid","userid","comment");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'articleid' => 'required',
				'userid' => 'required',
				'comment' => 'required',
			);
			$this->sanitize_array = array(
				'articleid' => 'sanitize_string',
				'userid' => 'sanitize_string',
				'comment' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_updated'] = datetime_now();
			if($this->validated()){
				$db->where("articlecomments.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("articlecomments");
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
						return	$this->redirect("articlecomments");
					}
				}
			}
		}
		$db->where("articlecomments.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Articlecomments";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("articlecomments/edit.php", $data);
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("articlecomments.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("articlecomments");
	}
}
