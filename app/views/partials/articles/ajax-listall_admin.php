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
<tr>
    <th class=" td-checkbox">
        <label class="custom-control custom-checkbox custom-control-inline">
            <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                <span class="custom-control-label"></span>
            </label>
        </th>
        <th class="td-sno"><?php echo $counter; ?></th>
        <td class="td-adminapprove">
            <span  data-source='<?php echo json_encode_quote(Menu :: $adminapprove); ?>' 
                data-value="<?php echo $data['adminapprove']; ?>" 
                data-pk="<?php echo $data['id'] ?>" 
                data-url="<?php print_link("articles/editfield/" . urlencode($data['id'])); ?>" 
                data-name="adminapprove" 
                data-title="Select a value ..." 
                data-placement="left" 
                data-toggle="click" 
                data-type="radiolist" 
                data-mode="popover" 
                data-showbuttons="left" 
                class="is-editable" >
                <?php echo $data['adminapprove']; ?> 
            </span>
        </td>
        <td class="td-title">
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
                <?php echo $data['title']; ?> 
            </span>
        </td>
        <td class="td-userid">
            <a size="sm" class="btn btn-secondary page-modal" href="<?php print_link("users/view/" . urlencode($data['userid'])) ?>">
                <i class="fa fa-user "></i> <?php echo $data['users_username'] ?>
            </a>
        </td>
        <td class="td-status">
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
                <?php echo $data['status']; ?> 
            </span>
        </td>
        <td class="td-category">
            <a size="sm" class="btn btn-info page-modal" href="<?php print_link("sett_articlecategories/view/" . urlencode($data['category'])) ?>">
                <i class="fa fa-list-alt "></i> <?php echo $data['sett_articlecategories_name'] ?>
            </a>
        </td>
        <td class="td-id"><a href="<?php print_link("articles/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
        <td class="page-list-action td-btn">
            <div class="dropdown" >
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                    <i class="fa fa-bars"></i> 
                </button>
                <ul class="dropdown-menu">
                    <a class="dropdown-item page-modal" href="<?php print_link("articles/view/$rec_id"); ?>">
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
    </tr>
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
    