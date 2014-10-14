<?php //print_r($site_configurations); ?>

<?php
if (isset($site_configurations_list)) {
    foreach ($site_configurations_list as $key => $site) {
    ?>
    <div class='outer_tab site-config'>
        <label><?php echo $site['configuration_name']; ?></label>
        <div class='outer_tab-values'>
            <ul>
                <?php foreach ($site_configurations as $key => $config) { ?>
                <li>
                    <strong><?php echo $config['field_name']; ?> :</strong> <?php echo $config['field_value_name']; ?>
                </li>            
                <?php } ?>
            </ul>            
        </div>
        <div class="config-edit-block">
            <span class="left">
                <a href="<?php echo site_url('dashboard/addconfiguration/'.$selected_site_id) ?>" class="add">Add New Configuration</a>
            </span>
            <span class="right">
                <a href="<?php echo site_url('dashboard/editconfiguration/'.$selected_site_id) ?>" class="edit">Edit</a> | <a href="<?php echo site_url('dashboard/deleteconfiguration/'.$selected_site_id) ?>" class="delete">Delete</a> | <a href="javascript:void(0)" class="active">Make In-active</a>
            </span>                
        </div>
    </div>        
    <?php    
    }
}
?>