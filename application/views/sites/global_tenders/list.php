<div class="add-new-blk">
    <a href="<?php echo site_url('dashboard/addconfiguration/' . $selected_site_id) ?>" class="btn add_config">Add New Configuration</a>
</div>

<div class="config-list-blk">
<?php
if (isset($config_det)) {
    $month_arr = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
    foreach ($config_det as $site_config_key => $site_config) {
        ?>
        <table class="table table-bordered table-condensed table-hover">
            <caption><?php echo $site_config_key; ?></caption>
            <thead>
               <tr>
                  <th style="background:#f5f5f5">Config Name</th>
                  <th>Config Value</th>
               </tr>
            </thead>
            <tbody>
                <?php foreach ($site_config['configuration_values'] as $key => $config) { ?>
                <tr>
                    <?php
                    if ($config['field_value_name'] == 'day' || $config['field_value_name'] == 'mon' || $config['field_value_name'] == 'year') {
                        if ($config['field_value_slv'] != 'NULL') {
                            $field_name = $config['field_value_name'];
                            if ($config['field_value_name'] == 'mon') {
                                $val = ucfirst($month_arr[$config['field_value_slv'] - 1]);
                            } else {
                                $val = $config['field_value'];
                            }
                            echo '<td style="background:#f5f5f5" width=20%>' . ucfirst($field_name) . '</td>';
                            echo '<td>'.$val.'</td>';
                        } else {
                            continue;
                        }
                    } else {
                        $field_name = $config['field_name'];
                        $val = $config['field_value_name'];
                        echo '<td style="background:#f5f5f5" width=20%>' . ucfirst($field_name) . '</td>';
                        echo '<td>'.$val.'</td>';
                    }
                    ?>       
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2">
                        <span class="right">
                            <?php $status = ($site_config['configuration_status']) ? 0 : 1; ?>
                            <a href="<?php echo site_url('dashboard/editconfiguration/' . $site_config['configuration_id']) ?>" class="edit_config">Edit</a> | <a href="<?php echo site_url('dashboard/deleteconfiguration/' . $site_config['configuration_id']) ?>" class="delete_config">Delete</a> | <a href="<?php echo site_url('dashboard/changeconfigurationstatus/' . $site_config['configuration_id'] . '/' . $status) ?>" class="status_config" data-message="<?php echo ($site_config['configuration_status']) ? "In-active" : "Active"; ?>"><?php echo ($site_config['configuration_status']) ? "Make In-active" : "Make Active"; ?></a>
                        </span>                
                    </td>
                </tr>
            </tbody>
        </table>   
        <?php
    }
}
?>
</div> 