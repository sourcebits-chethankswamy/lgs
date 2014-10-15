<style>
    .site-config-blk input {
        width: 260px !important;
    }
</style>

<div class="main_content">
    <div class='content_settings'>        
        <div class="config-blk-header">
            <h1>Add field values</h1>
        </div>

        <?php if (isset($fields_list)) { ?>
            <legend class="config-blk-settings site-config-blk">               
                <form method="post" action="<?php echo site_url('site/insert_field_value'); ?>">
                    <?php
                    foreach ($fields_list as $key => $value) {
                        ?>    
                        <div class='outer_tab'>
                            <label><?php echo $value['field_name'] ?></label>
                            <div class='outer_tab-values'>
                                <input type='text' name='field_value[name][<?php echo $value['id']; ?>]' value='' placeholder="Field value name" /> 
                                <input type='text' name='field_value[value][<?php echo $value['id']; ?>]' value='' placeholder="Field value" /> 
                            </div>                    
                        </div>                
                        <?php
                    }
                    ?>
                    <div class='outer_tab'>
                        <input type="hidden" name="site_id" value="<?php echo $site_id ?>" />
                        <button class="btn right width-100 btn-success" type="submit" name='save' id="add_fields">Save</button>
                    </div> 
                </form>
            </legend>
        <?php } ?>
    </div>
</div>