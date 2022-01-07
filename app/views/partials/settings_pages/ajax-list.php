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
        <td class="td-id"><a href="<?php print_link("settings_pages/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
        <td class="td-privacy_policy"> <?php echo $data['privacy_policy']; ?></td>
        <td class="td-terms_conditions"> <?php echo $data['terms_conditions']; ?></td>
        <td class="td-help_faq"> <?php echo $data['help_faq']; ?></td>
        <td class="td-about_us"> <?php echo $data['about_us']; ?></td>
        <td class="td-504_page"> <?php echo $data['504_page']; ?></td>
        <th class="td-btn">
            <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("settings_pages/view/$rec_id"); ?>">
                <i class="fa fa-eye"></i> View
            </a>
            <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("settings_pages/edit/$rec_id"); ?>">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("settings_pages/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                <i class="fa fa-times"></i>
                Delete
            </a>
        </th>
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
    