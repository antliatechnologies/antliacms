<?php 
/**
 * Articles Page Controller
 * @category  Controller
 */
class ArticlesController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "articles";
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
		$fields = array("articles.adminapprove", 
			"articles.id", 
			"articles.title", 
			"articles.featuredimage", 
			"articles.exerpt", 
			"articles.tag", 
			"articles.category", 
			"sett_articlecategories.name AS sett_articlecategories_name", 
			"articles.status", 
			"articles.views", 
			"articles.date_created", 
			"articles.date_updated", 
			"articles.source");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(isset($_SESSION['flashmsgnow'])){
    if($_SESSION['flashmsgnow'] == "yes"){
        set_flash_msg($_SESSION['flashmsg'],$type="warning",$dismissable=true,$showduration=5000);
        $_SESSION['flashmsgnow'] = "no";
    }
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				articles.adminapprove LIKE ? OR 
				articles.id LIKE ? OR 
				articles.userid LIKE ? OR 
				articles.title LIKE ? OR 
				articles.featuredimage LIKE ? OR 
				articles.exerpt LIKE ? OR 
				articles.article LIKE ? OR 
				articles.tag LIKE ? OR 
				articles.category LIKE ? OR 
				articles.status LIKE ? OR 
				articles.views LIKE ? OR 
				articles.date_created LIKE ? OR 
				articles.date_updated LIKE ? OR 
				articles.source LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "articles/search.php";
		}
		$db->join("sett_articlecategories", "articles.category = sett_articlecategories.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("articles.id", ORDER_TYPE);
		}
		$db->where("userid = '" .USER_ID. "'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->articles_status)){
			$val = $request->articles_status;
			$db->where("articles.status", $val , "=");
		}
		if(!empty($request->articles_category)){
			$val = $request->articles_category;
			$db->where("articles.category", $val , "=");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
	#Statement to execute after list record
	$_SESSION['enable_update_view'] = 1;
	# End of after list statement
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Articles";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$view_name = (is_ajax() ? "articles/ajax-list.php" : "articles/list.php");
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
		$fields = array("articles.title", 
			"articles.featuredimage", 
			"articles.article", 
			"articles.source", 
			"articles.tag", 
			"articles.category", 
			"sett_articlecategories.name AS sett_articlecategories_name", 
			"articles.views", 
			"articles.id", 
			"articles.userid", 
			"users.username AS users_username", 
			"articles.date_created", 
			"articles.date_updated");
		#Statement to execute before view record
		//Update Views
if ($_SESSION['enable_update_view'] == 1){
    $field_views = array('views');
    $db->where("id", $rec_id);
    $record_views = $db->getOne("articles", $field_views);
    $field_userid = array('userid');
    $db->where("id", $rec_id);
    $record_userid = $db->getOne("articles", $field_userid);
    if ($record_userid['userid'] != USER_ID){
        $updated_views = $record_views['views']+1;
        $aricle_table_data = array(
            "views" => $updated_views
        );
        $db->where("id", $rec_id);
        $bool = $db->update("articles", $aricle_table_data);
    }
    $updated_views = 0;
}
$_SESSION['enable_update_view'] = 0;
		# End of before view statement
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("articles.id", $rec_id);; //select record based on primary key
		}
		$db->join("sett_articlecategories", "articles.category = sett_articlecategories.id", "INNER");
		$db->join("users", "articles.userid = users.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Articles";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("articles/view.php", $record);
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
			$fields = $this->fields = array("userid","title","exerpt","article","tag","category","status","adminapprove","featuredimage","source");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'userid' => 'required',
				'title' => 'required',
				'exerpt' => 'required|max_len,300',
				'article' => 'required',
				'category' => 'required',
				'status' => 'required',
				'featuredimage' => 'required',
				'source' => 'required',
			);
			$this->sanitize_array = array(
				'userid' => 'sanitize_string',
				'title' => 'sanitize_string',
				'exerpt' => 'sanitize_string',
				'tag' => 'sanitize_string',
				'category' => 'sanitize_string',
				'status' => 'sanitize_string',
				'adminapprove' => 'sanitize_string',
				'featuredimage' => 'sanitize_string',
				'source' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_created'] = datetime_now();
			if($this->validated()){
		# Statement to execute before adding record
		$_SESSION['enable_update_view'] = 0;
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
$field_autoapprove = array('auto_approve_posts');
$db->where("id", "1");
$record_autoapprove = $db->getOne("settings", $field_autoapprove);
if ($record_autoapprove['auto_approve_posts'] == 'yes'){
        $table_data_approve = array(
            "adminapprove" => "yes"
        );
        $db->where("id", $rec_id);
        $bool = $db->update("articles", $table_data_approve);
        } elseif ($record_autoapprove['auto_approve_posts'] == 'no') {
        $table_data_approve = array(
        "adminapprove" => "pending"
        );
        $db->where("id", $rec_id);
        $bool = $db->update("articles", $table_data_approve);
        if($modeldata['status'] == 'Published'){
            $_SESSION['flashmsgnow'] = "yes";
            $field_waitapprovemsg = array('wait_approve_message');
            $db->where("id", "1");
            $record_waitapprovemsg = $db->getOne("settings", $field_waitapprovemsg);
            $_SESSION['flashmsg'] = $record_waitapprovemsg['wait_approve_message'];
            } else {
                $_SESSION['flashmsgnow'] = "no";
            }
    }
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("articles");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Articles";
		$this->render_view("articles/add.php");
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
		$fields = $this->fields = array("id","userid","title","exerpt","article","tag","category","status","adminapprove","featuredimage","source");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'userid' => 'required',
				'title' => 'required',
				'exerpt' => 'required|max_len,300',
				'article' => 'required',
				'category' => 'required',
				'status' => 'required',
				'featuredimage' => 'required',
				'source' => 'required',
			);
			$this->sanitize_array = array(
				'userid' => 'sanitize_string',
				'title' => 'sanitize_string',
				'exerpt' => 'sanitize_string',
				'tag' => 'sanitize_string',
				'category' => 'sanitize_string',
				'status' => 'sanitize_string',
				'adminapprove' => 'sanitize_string',
				'featuredimage' => 'sanitize_string',
				'source' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_updated'] = datetime_now();
			if($this->validated()){
		# Statement to execute after adding record
		$_SESSION['enable_update_view'] = 0;
		# End of before update statement
				$db->where("articles.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
$field_autoapprove = array('auto_approve_posts');
$db->where("id", "1");
$record_autoapprove = $db->getOne("settings", $field_autoapprove);
if ($record_autoapprove['auto_approve_posts'] == 'yes'){
        $table_data_approve = array(
            "adminapprove" => "yes"
        );
        $db->where("id", $rec_id);
        $bool = $db->update("articles", $table_data_approve);
        } elseif ($record_autoapprove['auto_approve_posts'] == 'no') {
        $table_data_approve = array(
        "adminapprove" => "pending"
        );
        $db->where("id", $rec_id);
        $bool = $db->update("articles", $table_data_approve);
        if($modeldata['status'] == 'Published'){
            $_SESSION['flashmsgnow'] = "yes";
            $field_waitapprovemsg = array('wait_approve_message');
            $db->where("id", "1");
            $record_waitapprovemsg = $db->getOne("settings", $field_waitapprovemsg);
            $_SESSION['flashmsg'] = $record_waitapprovemsg['wait_approve_message'];
            } else {
                $_SESSION['flashmsgnow'] = "no";
            }
    }
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("articles");
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
						return	$this->redirect("articles");
					}
				}
			}
		}
		$db->where("articles.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Articles";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("articles/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","userid","title","exerpt","article","tag","category","status","adminapprove","featuredimage","source");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'userid' => 'required',
				'title' => 'required',
				'exerpt' => 'required|max_len,300',
				'article' => 'required',
				'category' => 'required',
				'status' => 'required',
				'featuredimage' => 'required',
				'source' => 'required',
			);
			$this->sanitize_array = array(
				'userid' => 'sanitize_string',
				'title' => 'sanitize_string',
				'exerpt' => 'sanitize_string',
				'tag' => 'sanitize_string',
				'category' => 'sanitize_string',
				'status' => 'sanitize_string',
				'adminapprove' => 'sanitize_string',
				'featuredimage' => 'sanitize_string',
				'source' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_updated'] = datetime_now();
			if($this->validated()){
				$db->where("articles.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
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
	#Statement to execute before delete record
	$_SESSION['enable_update_view'] = 0;
	# End of before delete statement
		$db->where("articles.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("articles");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function listall($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("articles.id", 
			"articles.title", 
			"articles.featuredimage", 
			"articles.exerpt", 
			"articles.userid", 
			"users.username AS users_username", 
			"articles.category", 
			"sett_articlecategories.name AS sett_articlecategories_name", 
			"articles.tag", 
			"articles.views", 
			"articles.date_created", 
			"articles.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				articles.adminapprove LIKE ? OR 
				articles.id LIKE ? OR 
				articles.title LIKE ? OR 
				articles.featuredimage LIKE ? OR 
				articles.exerpt LIKE ? OR 
				articles.userid LIKE ? OR 
				articles.category LIKE ? OR 
				articles.tag LIKE ? OR 
				articles.views LIKE ? OR 
				articles.status LIKE ? OR 
				articles.article LIKE ? OR 
				articles.date_created LIKE ? OR 
				articles.date_updated LIKE ? OR 
				articles.source LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "articles/search.php";
		}
		$db->join("users", "articles.userid = users.id", "INNER");
		$db->join("sett_articlecategories", "articles.category = sett_articlecategories.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("articles.id", ORDER_TYPE);
		}
		$db->where("adminapprove = 'yes' AND status = 'published'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
	#Statement to execute after list record
	$_SESSION['enable_update_view'] = 1;
	# End of after list statement
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Articles";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$view_name = (is_ajax() ? "articles/ajax-listall.php" : "articles/listall.php");
		$this->render_view($view_name, $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function listall_admin($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("articles.adminapprove", 
			"articles.title", 
			"articles.userid", 
			"users.username AS users_username", 
			"articles.status", 
			"articles.category", 
			"sett_articlecategories.name AS sett_articlecategories_name", 
			"articles.id", 
			"articles.date_created", 
			"articles.date_updated", 
			"articles.featuredimage", 
			"articles.source");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				articles.adminapprove LIKE ? OR 
				articles.title LIKE ? OR 
				articles.userid LIKE ? OR 
				articles.status LIKE ? OR 
				articles.category LIKE ? OR 
				articles.id LIKE ? OR 
				articles.exerpt LIKE ? OR 
				articles.article LIKE ? OR 
				articles.tag LIKE ? OR 
				articles.views LIKE ? OR 
				articles.date_created LIKE ? OR 
				articles.date_updated LIKE ? OR 
				articles.featuredimage LIKE ? OR 
				articles.source LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "articles/search.php";
		}
		$db->join("users", "articles.userid = users.id", "INNER");
		$db->join("sett_articlecategories", "articles.category = sett_articlecategories.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("articles.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->articles_category)){
			$val = $request->articles_category;
			$db->where("articles.category", $val , "=");
		}
		if(!empty($request->articles_status)){
			$val = $request->articles_status;
			$db->where("articles.status", $val , "=");
		}
		if(!empty($request->articles_adminapprove)){
			$val = $request->articles_adminapprove;
			$db->where("articles.adminapprove", $val , "=");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
	#Statement to execute after list record
	$_SESSION['enable_update_view'] = 1;
	# End of after list statement
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Articles";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("articles/listall_admin.php", $data); //render the full page
	}
}
