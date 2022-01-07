<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * users_username_value_exist Model Action
     * @return array
     */
	function users_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("users");
		return $exist;
	}

	/**
     * users_email_value_exist Model Action
     * @return array
     */
	function users_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("users");
		return $exist;
	}

	/**
     * users_gender_option_list Model Action
     * @return array
     */
	function users_gender_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,name AS label FROM sett_genders ORDER BY name ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * users_user_role_id_option_list Model Action
     * @return array
     */
	function users_user_role_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT role_id AS value, role_name AS label FROM roles";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articles_userid_option_list Model Action
     * @return array
     */
	function articles_userid_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , username AS label FROM users ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articles_category_option_list Model Action
     * @return array
     */
	function articles_category_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , name AS label FROM sett_articlecategories ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articlecomments_articleid_option_list Model Action
     * @return array
     */
	function articlecomments_articleid_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , title AS label FROM articles ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articlecomments_userid_option_list Model Action
     * @return array
     */
	function articlecomments_userid_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , username AS label FROM users ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articles_articlesstatus_option_list Model Action
     * @return array
     */
	function articles_articlesstatus_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT status AS value,status AS label FROM articles ORDER BY status ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articles_articlescategory_option_list Model Action
     * @return array
     */
	function articles_articlescategory_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,name AS label FROM sett_articlecategories ORDER BY name ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * articles_articlesadminapprove_option_list Model Action
     * @return array
     */
	function articles_articlesadminapprove_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT adminapprove AS value,adminapprove AS label FROM articles ORDER BY adminapprove ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

}
