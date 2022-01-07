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
