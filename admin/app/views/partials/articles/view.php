<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><center><?php echo $data['title']; ?></center></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-featuredimage">
                                        <th class="title"> <center>: </th>
                                            <td class="value"><?php Html :: page_img($data['featuredimage'],400,400,1); ?></td>
                                        </tr>
                                        <tr  class="td-article">
                                        <th class="title"> </center>: </th>
                                        <td class="value"> <?php echo $data['article']; ?></td>
                                    </tr>
                                    <tr  class="td-source">
                                        <th class="title"> Source: </th>
                                        <td class="value"><a href="<?php echo $data['source']; ?>"> <?php echo $data['source']; ?> <a></td>
                                        </tr>
                                        <tr  class="td-tag">
                                            <th class="title"><i class="fa fa-hashtag "></i> : </th>
                                            <td class="value"> <?php echo $data['tag']; ?></td>
                                        </tr>
                                        <tr  class="td-category">
                                            <th class="title"><i class="fa fa-list-alt "></i> : </th>
                                            <td class="value">
                                                <a size="sm" class="btn btn-info page-modal" href="<?php print_link("sett_articlecategories/view/" . urlencode($data['category'])) ?>">
                                                    <i class="fa fa-list-alt "></i> <?php echo $data['sett_articlecategories_name'] ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr  class="td-views">
                                            <th class="title"><i class="fa fa-eye "></i> : </th>
                                            <td class="value"> <?php echo $data['views']; ?></td>
                                        </tr>
                                        <tr  class="td-date_created">
                                            <th class="title"><i class="fa fa-calendar-plus-o "></i> : </th>
                                            <td class="value"> <?php echo $data['date_created']; ?></td>
                                        </tr>
                                        <tr  class="td-date_updated">
                                            <th class="title"><i class="fa fa-calendar-o "></i> : </th>
                                            <td class="value"> <?php echo $data['date_updated']; ?></td>
                                        </tr>
                                    </tbody>
                                    <!-- Table Body End -->
                                </table>
                            </div>
                            <div class="p-3 d-flex">
                            </div>
                            <?php
                            }
                            else{
                            ?>
                            <!-- Empty Record Message -->
                            <div class="text-muted p-3">
                                <i class="fa fa-ban"></i> No Record Found
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if( $show_header == true ){
        ?>
        <div  class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 comp-grid">
                        <button data-toggle="modal" data-target="#Modal-1-Page1" class="btn btn-primary"><i class='fa fa-comments '></i>  Make a comment</button>
                        <div data-backdrop="true" class="modal fade" id="Modal-1-Page1" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"><i class='fa fa-comments '></i>  Comments</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0 reset-grids">
                                        <div class=" reset-grids">
                                            <?php  
                                            $this->render_page("articlecomments/add" , array( 'articleid' => $data['id'],'show_header' => false )); 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div  class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col comp-grid">
                        <h4 class="record-title">Comments</h4>
                    </div>
                </div>
            </div>
        </div>
        <div  class="">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 comp-grid">
                        <div class=" ">
                            <?php  
                            $this->render_page("articlecomments/list/articlecomments.articleid/$data[id]?limit_count=20" , array( 'show_header' => false,'show_footer' => false )); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
