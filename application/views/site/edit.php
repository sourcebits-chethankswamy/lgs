<div class="main_content">
    <div class='content_settings'>        
        <div class="config-blk-header">
            <h1>Edit site details</h1>
        </div>

        <legend class="config-blk-settings site-config-blk">               
            <form method="post" action="<?php echo site_url('site/update_site'); ?>">
                <div class='outer_tab'>
                    <label>Site name</label>
                    <div class='outer_tab-values'>
                        <input type='text' name='site_name' value='<?php echo $site_detals[0]['configuration_name']; ?>' />
                    </div>
                </div>

                <div class="site-fields">
                    <?php
                    foreach ($fields_list as $key => $value) {
                    ?>
                    <div class='outer_tab'>
                        <label>Search field name</label>
                        <div class='outer_tab-values'>
                            <input type='text' name='field_name[<?php echo $value['id']; ?>]' value='<?php echo $value['field_name']; ?>' />
                            <select name="field_type[<?php echo $value['id']; ?>]">
                                <option value="0" <?php echo ($value['field_type'] == '0') ? "selected" : ""; ?>>Input field</option>
                                <option value="1" <?php echo ($value['field_type'] == '1') ? "selected" : ""; ?>>Dropdown</option>
                                <option value="2" <?php echo ($value['field_type'] == '2') ? "selected" : ""; ?>>Checkbox</option>
                                <option value="3" <?php echo ($value['field_type'] == '3') ? "selected" : ""; ?>>Multiselect dropdown</option>
                            </select>
                            <a href="javascript:void(0)" class="delete-field">Delete</a>
                        </div>                    
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <div class='outer_tab'>
                    <input type="hidden" name="site_id" value="<?php echo $site_id; ?>" />
                    <a href="javascript:void(0)" class="left add-field">Add new field</a>
                    
                    <button class="btn right width-100 btn-success" type="submit" name='save' id="add_site">Save</button>
                    <a href="<?php echo site_url('site/edit_field_values/'.$site_id) ?>" class="right edit-field">Edit field values</a>
                </div> 
            </form>
        </legend>

        <div class='clear'></div>        
    </div>
</div>


<script type="text/javascript">
    $(function() {
        $(document).on("click", ".add-field", function() {
            var html = "<div class='outer_tab'>";
            html += "<label>Search field name</label>";
            html += "<div class='outer_tab-values'>";
            html += "<input type='text' name='field_name_new[]' value='' /> ";
            html += "<select name='field_type_new[]'>";
            html += '<option value="0">Input field</option><option value="1">Dropdown</option><option value="2">Checkbox</option><option value="3">Multiselect dropdown</option>';
            html += '</select> ';
            html += '<a href="javascript:void(0)" class="delete-field">delete</a>';
            html += '</div></div>';

            $('.site-fields').append(html);
        });

        $(document).on("click", ".delete-field", function() {
            $(this).parent().parent().remove();
        });
    });

</script>

