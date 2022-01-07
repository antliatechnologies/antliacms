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
                    <h4 class="record-title">Articles</h4>
                </div>
                <div class="col-sm-3 ">
                    <a  class="btn btn-primary" href="<?php print_link("articles/list") ?>">
                        <i class="fa fa-book "></i>                             
                        My articles 
                    </a>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('articles/'); ?>" method="get">
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
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="articles-listall-records">
                                <?php
                                if(!empty($records)){
                                ?>
                                <div id="page-report-body">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <div class="row sm-gutters page-data" id="page-data-<?php echo $page_element_id; ?>">
                                        <!--record-->
                                        <?php
                                        $counter = 0;
                                        foreach($records as $data){
                                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                        $counter++;
                                        ?>
                                        <div class="col-sm-4">
                                            <div class="card bg-light p-2 mb-3 animated bounceIn">
                                                <div class="mb-2">  <a href="<?php print_link("articles/view/$data[id]") ?>">
                                                    <span class="font-weight-light text-muted ">
                                                        <h3><center>:  
                                                        </span>
                                                    <?php echo $data['title']; ?></a></div>
                                                    <div class="mb-2">  
                                                        <span class="font-weight-light text-muted ">
                                                            </center></h3><center>:  
                                                        </span>
                                                    <?php echo $data['featuredimage']; ?></div>
                                                    <div class="mb-2">  
                                                        <span class="font-weight-light text-muted ">
                                                        </center>:  
                                                    </span>
                                                <?php echo $data['exerpt']; ?></div>
                                                <div class="mb-2">  
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("users/view/" . urlencode($data['userid'])) ?>">
                                                        <i class="fa fa-user "></i> <?php echo $data['users_username'] ?>
                                                    </a>
                                                </div>
                                                <div class="mb-2">  
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("sett_articlecategories/view/" . urlencode($data['category'])) ?>">
                                                        <i class="fa fa-list-alt "></i> <?php echo $data['sett_articlecategories_name'] ?>
                                                    </a>
                                                </div>
                                                <div class="mb-2">  
                                                    <span class="font-weight-light text-muted ">
                                                        Tags:  
                                                    </span>
                                                <?php echo $data['tag']; ?></div>
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
                                                <div class="td-btn">
                                                    <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("articles/view/$rec_id"); ?>">
                                                        <i class="fa fa-eye"></i> Read
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                        <!--endrecord-->
                                    </div>
                                    <div class="row sm-gutters search-data" id="search-data-<?php echo $page_element_id; ?>"></div>
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
