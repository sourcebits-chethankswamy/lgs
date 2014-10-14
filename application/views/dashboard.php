<div class="main_content">
    <div class='content_settings'>        
        <div class="config-blk-header">
            <h1>Configuration Settings for:</h1>
            <select name="site_id" id="site_id">
            <?php
            if(isset($site_lists)) {
                foreach ($site_lists as $value) {
                    $selected = ($selected_site_id == $value['id']) ? "selected" : '';
                    echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['configuration_name'].'</option>';
                }
            }                
            ?>
            </select>
        </div>
        
        <legend class="config-blk-settings">               
            <?php echo $site_page; ?>                
        </legend>

        <div class='clear'></div>        
    </div>
</div>
