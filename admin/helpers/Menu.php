<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Dashboard', 
			'icon' => '<i class="fa fa-dashboard "></i>'
		),
		
		array(
			'path' => 'users', 
			'label' => 'Users', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => '', 
			'label' => 'Articles', 
			'icon' => '<i class="fa fa-book "></i>','submenu' => array(
		array(
			'path' => 'articles', 
			'label' => 'My Articles', 
			'icon' => '<i class="fa fa-caret-right "></i>'
		),
		
		array(
			'path' => 'articles/listall', 
			'label' => 'All Articles', 
			'icon' => '<i class="fa fa-caret-right "></i>'
		),
		
		array(
			'path' => 'articles/listall_admin', 
			'label' => 'All Articles (Admin)', 
			'icon' => '<i class="fa fa-caret-right "></i>'
		)
	)
		),
		
		array(
			'path' => '', 
			'label' => 'Article Comments', 
			'icon' => '<i class="fa fa-commenting-o "></i>','submenu' => array(
		array(
			'path' => 'articlecomments', 
			'label' => 'Comments', 
			'icon' => '<i class="fa fa-caret-right "></i>'
		)
	)
		),
		
		array(
			'path' => 'links', 
			'label' => 'Links', 
			'icon' => '<i class="fa fa-link "></i>'
		),
		
		array(
			'path' => 'location', 
			'label' => 'Location', 
			'icon' => ''
		),
		
		array(
			'path' => 'phones', 
			'label' => 'Phones', 
			'icon' => ''
		),
		
		array(
			'path' => 'articlefavorites', 
			'label' => 'Articlefavorites', 
			'icon' => ''
		),
		
		array(
			'path' => 'articlelikes', 
			'label' => 'Articlelikes', 
			'icon' => ''
		),
		
		array(
			'path' => 'role_permissions', 
			'label' => 'Role Permissions', 
			'icon' => ''
		),
		
		array(
			'path' => 'roles', 
			'label' => 'Roles', 
			'icon' => ''
		)
	);
		
			public static $navbartopleft = array(
		array(
			'path' => '', 
			'label' => 'Create', 
			'icon' => '<i class="fa fa-plus-square-o "></i>','submenu' => array(
		array(
			'path' => 'articles/add', 
			'label' => 'Article', 
			'icon' => '<i class="fa fa-book "></i>'
		)
	)
		),
		
		array(
			'path' => '', 
			'label' => 'Settings', 
			'icon' => '<i class="fa fa-gears "></i>','submenu' => array(
		array(
			'path' => 'settings/edit/1', 
			'label' => 'General', 
			'icon' => '<i class="fa fa-gear "></i>'
		),
		
		array(
			'path' => 'settings_pages/edit/1', 
			'label' => 'Page Settings', 
			'icon' => '<i class="fa fa-gear "></i>'
		),
		
		array(
			'path' => 'sett_articlecategories', 
			'label' => 'Set Article Categories', 
			'icon' => '<i class="fa fa-gear "></i>'
		),
		
		array(
			'path' => 'sett_genders', 
			'label' => 'Set Genders', 
			'icon' => '<i class="fa fa-gear "></i>'
		),
		
		array(
			'path' => 'sett_linkcategories', 
			'label' => 'Set Link Categories', 
			'icon' => '<i class="fa fa-gear "></i>'
		)
	)
		)
	);
		
	
	
			public static $status = array(
		array(
			"value" => "Draft", 
			"label" => "Draft", 
		),
		array(
			"value" => "Published", 
			"label" => "Published", 
		),);
		
			public static $adminapprove = array(
		array(
			"value" => "yes", 
			"label" => "Yes", 
		),
		array(
			"value" => "no", 
			"label" => "No", 
		),
		array(
			"value" => "pending", 
			"label" => "Pending", 
		),);
		
			public static $auto_approve_posts = array(
		array(
			"value" => "yes", 
			"label" => "Yes", 
		),
		array(
			"value" => "no", 
			"label" => "No", 
		),);
		
			public static $mail_admin_post = array(
		array(
			"value" => "Yes", 
			"label" => "Yes", 
		),
		array(
			"value" => "No", 
			"label" => "No", 
		),);
		
}