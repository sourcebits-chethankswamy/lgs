<div class="main_content">
    <div class='content_settings'>
        <form method="post" action="<?php echo site_url('dashboard/save');?>">
            <div class="config-blk-header">
                <h1>Search Settings for:</h1>
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
           <?php if(isset($save)) {?>
 			<div class='green'>Your changes are saved</div>
 			<?php } ?>
            <legend class="config-blk-settings">               
                <?php echo $site_page; ?>
                <div class='outer_tab'>
                	<button class="btn right width-100 btn-success" onclick="$('form').attr('action','<?php echo site_url('dashboard/save');?>');" type="submit" name='save'>Save</button>
                	<button class="btn right width-100 btn-primary" onclick="$('form').attr('action','<?php echo site_url('dashboard/search');?>');" type="submit" name='search'>Test Search</button>                
           		</div> 
            </legend>
        </form>
        <div class='clear'></div>
        <?php if(isset($search_view)) {?>
        <div class='search_results'>
        	<hr/>
        	<?php echo $search_view;?>
    	</div>
    	<?php }?>
    </div>
</div>
