<div class="main_content">
    <div class='content_settings'>
        <form method="post" action="dashboard/save_configuration">
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

            <?php        
            //print_r($field_details);
            ?>
            <legend class="config-blk-settings">               
                <?php echo $site_page; ?>
                <div class='outer_tab'>
                	<button class="btn right width-100 btn-success" type="submit" name='save'>Save</button>
                	<button class="btn right width-100 btn-primary" type="submit" name='search'>Search</button>                
           		</div> 
            </legend>
        </form>
    </div>
</div>