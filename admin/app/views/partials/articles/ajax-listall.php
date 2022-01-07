<?php
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
if (!empty($records)) {
?>
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
<?php
} else {
?>
<td class="no-record-found col-12" colspan="100">
    <h4 class="text-muted text-center ">
        No Record Found
    </h4>
</td>
<?php
}
?>
