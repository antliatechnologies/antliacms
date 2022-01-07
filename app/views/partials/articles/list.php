<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="grid" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">My Articles</h4>
                </div>
                <div class="col-sm-3 ">
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("articles/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        New Article 
                    </a>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('articles'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <div class="">
                            <!-- Page bread crumbs components-->
                            <?php
                            if(!empty($field_name) || !empty($_GET['search'])){
                            ?>
                            <hr class="sm d-block d-sm-none" />
                            <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                <ul class="breadcrumb m-0 p-1">
                                    <?php
                                    if(!empty($field_name)){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('articles'); ?>">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                                        <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                                    </li>
                                    <?php 
                                    }   
                                    ?>
                                    <?php
                                    if(get_value("search")){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('articles'); ?>">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-capitalize">
                                        Search
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                            <!--End of Page bread crumbs components-->
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div  class="">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-sm-4 comp-grid">
                        <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                            <div class="card mb-3">
                                <div class="card-header h4 h4">Status</div>
                                <div class="p-2">
                                    <?php 
                                    $articles_status_options = $comp_model -> articles_articlesstatus_option_list();
                                    if(!empty($articles_status_options)){
                                    foreach($articles_status_options as $option){
                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                    $checked = $this->set_field_checked('articles_status', $value);
                                    ?>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input id="" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="radio"  name="articles_status"  />
                                            <span class="custom-control-label"><?php echo $label; ?></span>
                                        </label>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header h4 h4">Category</div>
                                    <div class="p-2">
                                        <?php 
                                        $articles_category_options = $comp_model -> articles_articlescategory_option_list();
                                        if(!empty($articles_category_options)){
                                        foreach($articles_category_options as $option){
                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                        $checked = $this->set_field_checked('articles_category', $value);
                                        ?>
                                        <label class="custom-control custom-radio custom-control-inline">
                                            <input id="" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="radio"  name="articles_category"  />
                                                <span class="custom-control-label"><?php echo $label; ?></span>
                                            </label>
                                            <?php
                                            }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-8 comp-grid">
                                <?php $this :: display_page_errors(); ?>
                                <div class="filter-tags mb-2">
                                    <?php
                                    if(!empty(get_value('articles_status'))){
                                    ?>
                                    <div class="filter-chip card bg-light">
                                        <b>Articles Status :</b> 
                                        <?php 
                                        if(get_value('articles_statuslabel')){
                                        echo get_value('articles_statuslabel');
                                        }
                                        else{
                                        echo get_value('articles_status');
                                        }
                                        $remove_link = unset_get_value('articles_status', $this->route->page_url);
                                        ?>
                                        <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                            &times;
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if(!empty(get_value('articles_category'))){
                                    ?>
                                    <div class="filter-chip card bg-light">
                                        <b>Articles Category :</b> 
                                        <?php 
                                        if(get_value('articles_categorylabel')){
                                        echo get_value('articles_categorylabel');
                                        }
                                        else{
                                        echo get_value('articles_category');
                                        }
                                        $remove_link = unset_get_value('articles_category', $this->route->page_url);
                                        ?>
                                        <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                            &times;
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div  class=" animated fadeIn page-content">
                                    <div id="articles-list-records">
                                        <?php
                                        if(!empty($records)){
                                        ?>
                                        <div id="page-report-body">
                                            <?php Html::ajaxpage_spinner(); ?>
                                            <div class="row md-gutters page-data" id="page-data-<?php echo $page_element_id; ?>">
                                                <!--record-->
                                                <?php
                                                $counter = 0;
                                                foreach($records as $data){
                                                $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                                $counter++;
                                                ?>
                                                <div class="col-sm-6">
                                                    <div class="card bg-light p-2 mb-3 animated bounceIn">
                                                        <div class="mb-2">  <?php Html :: check_button($data['adminapprove'], "Yes") ?></div>
                                                        <div class="mb-2">  
                                                            <span  data-value="<?php echo $data['title']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="title" 
                                                                data-title="Enter Title" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <span class="font-weight-light text-muted ">
                                                                    Title:  
                                                                </span>
                                                                <?php echo $data['title']; ?> 
                                                            </span>
                                                        </div>
                                                        <div class="mb-2">  <?php Html :: page_img($data['featuredimage'],50,50,1); ?></div>
                                                        <div class="mb-2">  
                                                            <span  data-value="<?php echo $data['exerpt']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="exerpt" 
                                                                data-title="Enter Exerpt" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <span class="font-weight-light text-muted ">
                                                                    Exerpt:  
                                                                </span>
                                                                <?php echo $data['exerpt']; ?> 
                                                            </span>
                                                        </div>
                                                        <div class="mb-2">  
                                                            <span  data-value="<?php echo $data['tag']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="tag" 
                                                                data-title="Enter Tag" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <span class="font-weight-light text-muted ">
                                                                    Tag:  
                                                                </span>
                                                                <?php echo $data['tag']; ?> 
                                                            </span>
                                                        </div>
                                                        <div class="mb-2">  
                                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("sett_articlecategories/view/" . urlencode($data['category'])) ?>">
                                                                <i class="fa fa-list-alt "></i> <?php echo $data['sett_articlecategories_name'] ?>
                                                            </a>
                                                        </div>
                                                        <div class="mb-2">  
                                                            <span  data-source='<?php echo json_encode_quote(Menu :: $status); ?>' 
                                                                data-value="<?php echo $data['status']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="status" 
                                                                data-title="Select a value ..." 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="select" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <span class="font-weight-light text-muted ">
                                                                    Status:  
                                                                </span>
                                                                <?php echo $data['status']; ?> 
                                                            </span>
                                                        </div>
                                                        <div class="mb-2">  
                                                            <span class="font-weight-light text-muted ">
                                                                Views:  
                                                            </span>
                                                        <?php echo $data['views']; ?></div>
                                                        <div class="mb-2">  
                                                            <span class="font-weight-light text-muted ">
                                                                Date Created:  
                                                            </span>
                                                        <?php echo $data['date_created']; ?></div>
                                                        <div class="mb-2">  
                                                            <span class="font-weight-light text-muted ">
                                                                Date Updated:  
                                                            </span>
                                                        <?php echo $data['date_updated']; ?></div>
                                                        <div class="mb-2">  
                                                            <span  data-value="<?php echo $data['source']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="source" 
                                                                data-title="Enter Source" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <span class="font-weight-light text-muted ">
                                                                    Source:  
                                                                </span>
                                                                <?php echo $data['source']; ?> 
                                                            </span>
                                                        </div>
                                                        <div class="td-btn">
                                                            <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("articles/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                            <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("articles/edit/$rec_id"); ?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("articles/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                                <i class="fa fa-times"></i>
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                }
                                                ?>
                                                <!--endrecord-->
                                            </div>
                                            <div class="row md-gutters search-data" id="search-data-<?php echo $page_element_id; ?>"></div>
                                            <div>
                                            </div>
                                        </div>
                                        <?php
                                        if($show_footer == true){
                                        ?>
                                        <div class=" border-top mt-2">
                                            <div class="row justify-content-center">    
                                                <div class="col-md-auto">   
                                                </div>
                                                <div class="col">   
                                                    <?php
                                                    if($show_pagination == true){
                                                    $pager = new Pagination($total_records, $record_count);
                                                    $pager->route = $this->route;
                                                    $pager->show_page_count = true;
                                                    $pager->show_record_count = true;
                                                    $pager->show_page_limit =true;
                                                    $pager->limit_count = $this->limit_count;
                                                    $pager->show_page_number_list = true;
                                                    $pager->pager_link_range=5;
                                                    $pager->ajax_page = true;
                                                    $pager->render();
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        }
                                        else{
                                        ?>
                                        <div class="text-muted  animated bounce p-3">
                                            <h4><i class="fa fa-ban"></i> No record found</h4>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
