<div class="main_content">
    <div class='content_settings'>        

        <legend class="config-blk-settings">               
            <div class="add-new-blk">
                <a href="<?php echo site_url('site/add') ?>" class="btn add_config">Add New Site</a>
            </div>

            <div class="config-list-blk">
                <?php
                if (isset($sites_list)) {
                    foreach ($sites_list as $key => $value) {
                        ?>
                        <table class="table table-bordered table-condensed table-hover">
                            <caption><?php echo $value['configuration_name']; ?></caption>
                            <thead>
                                <tr>
                                    <th style="background:#f5f5f5">Site Name</th>
                                    <th>Created on</th>
                                </tr>
                            </thead>
                            <tbody>                     
                                <tr>
                                    <td style="background:#f5f5f5" width=20%><?php echo ucfirst($value['configuration_name']); ?></td>
                                    <td><?php echo $value['created_date']; ?></td>
                                </tr>                     
                                <tr>
                                    <td colspan="2">
                                        <span class="right">
                                            <?php $status = ($value['status']) ? 0 : 1; ?>
                                            <a href="<?php echo site_url('site/edit/' . $value['id']) ?>" class="edit_site">Edit</a> | <a href="<?php echo site_url('site/delete/' . $value['id']) ?>" class="delete_config">Delete</a> | <a href="<?php echo site_url('site/changestatus/' . $value['id'] . '/' . $status) ?>" class="status_config" data-message="<?php echo ($value['status']) ? "In-active" : "Active"; ?>"><?php echo ($value['status']) ? "Make In-active" : "Make Active"; ?></a>
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
        </legend>

        <div class='clear'></div>        
    </div>
</div>



