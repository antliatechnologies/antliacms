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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
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
                    <div class="col-sm-3 comp-grid">
                        <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                            <div class="card mb-3">
                                <div class="card-header h4 h4">Article Category</div>
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
                                <div class="card mb-3">
                                    <div class="card-header h4 h4">Article Status</div>
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
                                        <div class="card-header h4 h4">Approved By Admin?</div>
                                        <div class="p-2">
                                            <?php 
                                            $articles_adminapprove_options = $comp_model -> articles_articlesadminapprove_option_list();
                                            if(!empty($articles_adminapprove_options)){
                                            foreach($articles_adminapprove_options as $option){
                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                            $checked = $this->set_field_checked('articles_adminapprove', $value);
                                            ?>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input id="" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="radio"  name="articles_adminapprove"  />
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
                                <div class="col-sm-9 comp-grid">
                                    <?php $this :: display_page_errors(); ?>
                                    <div class="filter-tags mb-2">
                                        <?php
                                        if(!empty(get_value('articles_category'))){
                                        ?>
                                        <div class="filter-chip card bg-light">
                                            <b>Article Category :</b> 
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
                                        <?php
                                        if(!empty(get_value('articles_status'))){
                                        ?>
                                        <div class="filter-chip card bg-light">
                                            <b>Article Status :</b> 
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
                                        if(!empty(get_value('articles_adminapprove'))){
                                        ?>
                                        <div class="filter-chip card bg-light">
                                            <b>Approved :</b> 
                                            <?php 
                                            if(get_value('articles_adminapprovelabel')){
                                            echo get_value('articles_adminapprovelabel');
                                            }
                                            else{
                                            echo get_value('articles_adminapprove');
                                            }
                                            $remove_link = unset_get_value('articles_adminapprove', $this->route->page_url);
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
                                        <div id="articles-listall_admin-records">
                                            <div id="page-report-body" class="table-responsive">
                                                <table class="table table-hover table-striped table-sm text-left">
                                                    <thead class="table-header bg-light">
                                                        <tr>
                                                            <th class="td-checkbox">
                                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                                    <input class="toggle-check-all custom-control-input" type="checkbox" />
                                                                    <span class="custom-control-label"></span>
                                                                </label>
                                                            </th>
                                                            <th class="td-btn"></th>
                                                            <th class="td-sno">#</th>
                                                            <th style="width:primary;" <?php echo (get_value('orderby')=='adminapprove' ? 'class="sortedby td-adminapprove"' : null); ?>>
                                                                <?php Html :: get_field_order_link('adminapprove', "Approved"); ?>
                                                            </th>
                                                            <th  class="td-title"> Title</th>
                                                            <th  class="td-userid"> Userid</th>
                                                            <th  class="td-status"> Status</th>
                                                            <th  class="td-category"> Category</th>
                                                            <th  class="td-id"> Id</th>
                                                            <th  class="td-date_created"> Date Created</th>
                                                            <th  class="td-date_updated"> Date Updated</th>
                                                            <th  class="td-featuredimage"> Featuredimage</th>
                                                            <th  class="td-source"> Source</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    if(!empty($records)){
                                                    ?>
                                                    <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                                        <!--record-->
                                                        <?php
                                                        $counter = 0;
                                                        foreach($records as $data){
                                                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                                        $counter++;
                                                        ?>
                                                        <tr>
                                                            <th class=" td-checkbox">
                                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                                    <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                                                                        <span class="custom-control-label"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="td-sno"><?php echo $counter; ?></th>
                                                                <td class="page-list-action td-btn">
                                                                    <div class="dropdown" >
                                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                            <i class="fa fa-bars"></i> 
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <a class="dropdown-item" href="<?php print_link("articles/view/$rec_id"); ?>">
                                                                                <i class="fa fa-eye"></i> View 
                                                                            </a>
                                                                            <a class="dropdown-item" href="<?php print_link("articles/edit/$rec_id"); ?>">
                                                                                <i class="fa fa-edit"></i> Edit
                                                                            </a>
                                                                            <a  class="dropdown-item record-delete-btn" href="<?php print_link("articles/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                                                <i class="fa fa-times"></i> Delete 
                                                                            </a>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                                <td class="td-adminapprove">
                                                                    <span  data-source='<?php echo json_encode_quote(Menu :: $adminapprove); ?>' 
                                                                        data-value="<?php echo $data['adminapprove']; ?>" 
                                                                        data-pk="<?php echo $data['id'] ?>" 
                                                                        data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                        data-name="adminapprove" 
                                                                        data-title="Approved by Admin?" 
                                                                        data-placement="left" 
                                                                        data-toggle="click" 
                                                                        data-type="radiolist" 
                                                                        data-mode="popover" 
                                                                        data-showbuttons="left" 
                                                                        class="is-editable" >
                                                                        <?php echo $data['adminapprove']; ?> 
                                                                    </span>
                                                                </td>
                                                                <td class="td-title"><a href="<?php print_link("articles/view/$data[id]") ?>"><?php echo $data['title']; ?></a></td>
                                                                <td class="td-userid">
                                                                    <a size="sm" class="btn btn-secondary page-modal" href="<?php print_link("users/view/" . urlencode($data['userid'])) ?>">
                                                                        <i class="fa fa-user "></i> <?php echo $data['users_username'] ?>
                                                                    </a>
                                                                </td>
                                                                <td class="td-status"> <?php echo $data['status']; ?></td>
                                                                <td class="td-category">
                                                                    <a size="sm" class="btn btn-info page-modal" href="<?php print_link("sett_articlecategories/view/" . urlencode($data['category'])) ?>">
                                                                        <i class="fa fa-list-alt "></i> <?php echo $data['sett_articlecategories_name'] ?>
                                                                    </a>
                                                                </td>
                                                                <td class="td-id"><a href="<?php print_link("articles/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
                                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                                <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
                                                                <td class="td-featuredimage">
                                                                    <span  data-value="<?php echo $data['featuredimage']; ?>" 
                                                                        data-pk="<?php echo $data['id'] ?>" 
                                                                        data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                                                                        data-name="featuredimage" 
                                                                        data-title="Browse..." 
                                                                        data-placement="left" 
                                                                        data-toggle="click" 
                                                                        data-type="text" 
                                                                        data-mode="popover" 
                                                                        data-showbuttons="left" 
                                                                        class="is-editable" >
                                                                        <?php echo $data['featuredimage']; ?> 
                                                                    </span>
                                                                </td>
                                                                <td class="td-source">
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
                                                                        <?php echo $data['source']; ?> 
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                            }
                                                            ?>
                                                            <!--endrecord-->
                                                        </tbody>
                                                        <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                                        <?php
                                                        }
                                                        ?>
                                                    </table>
                                                    <?php 
                                                    if(empty($records)){
                                                    ?>
                                                    <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                                        <i class="fa fa-ban"></i> No Articles found
                                                    </h4>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if( $show_footer && !empty($records)){
                                                ?>
                                                <div class=" border-top mt-2">
                                                    <div class="row justify-content-center">    
                                                        <div class="col-md-auto justify-content-center">    
                                                            <div class="p-3 d-flex justify-content-between">    
                                                                <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("articles/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                                    <i class="fa fa-times"></i> Delete Selected
                                                                </button>
                                                                <div class="dropup export-btn-holder mx-1">
                                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-save"></i> Export
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                                                        <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                                                            <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                                                            </a>
                                                                            <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                                                            <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                                                                <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                                                                </a>
                                                                                <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                                                                <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                                                    <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                                                    </a>
                                                                                    <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                                                    <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                                                        <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                                                        </a>
                                                                                        <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                                                        <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                                                            <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
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
                                                                                $pager->render();
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
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
