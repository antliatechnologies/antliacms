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
<div class="col-sm-12">
    <div class="card bg-light p-2 mb-3 animated bounceIn">
        <div class="mb-2">  
            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("users/view/" . urlencode($data['userid'])) ?>">
                <i class="fa fa-user "></i> <?php echo $data['users_username'] ?>
            </a>
        </div>
        <span><h5><i><?php echo $data['comment']; ?></i></h5></span>
        <div class="mb-2">  
            <span title="<?php echo human_datetime($data['date_created']); ?>" class="has-tooltip">
                <?php echo relative_date($data['date_created']); ?>
            </span>
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
