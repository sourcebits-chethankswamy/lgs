<div class="main_content">
    <div class='content_settings'>        
        <div class="config-blk-header">
            <h1>Add new site</h1>
        </div>

        <legend class="config-blk-settings site-config-blk">               
            <form method="post" action="<?php echo site_url('site/create_site'); ?>">
                <div class='outer_tab'>
                    <label>Site name</label>
                    <div class='outer_tab-values'>
                        <input type='text' name='site_name' value='' />
                    </div>
                </div>

                <div class="site-fields">
                    <div class='outer_tab'>
                        <label>Search field name</label>
                        <div class='outer_tab-values'>
                            <input type='text' name='field_name[]' value='' />
                            <select name="field_type[]">
                                <option value="0">Input field</option>
                                <option value="1">Dropdown</option>
                                <option value="2">Checkbox</option>
                                <option value="3">Multiselect dropdown</option>
                            </select>
                            <a href="javascript:void(0)" class="delete-field">Delete</a>
                        </div>                    
                    </div>
                </div>

                <div class='outer_tab'>    
                    <a href="javascript:void(0)" class="left add-field">Add new field</a>
                    <button class="btn right width-100 btn-success" type="submit" name='save' id="add_site">Save</button>
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
            html += "<input type='text' name='field_name[]' value='' />";
            html += "<select name='field_type[]'>";
            html += '<option value="" selected="">Field type</option><option value="0">Input field</option><option value="1">Dropdown</option><option value="2">Checkbox</option><option value="3">Multiselect dropdown</option>';
            html += '</select> ';
            html += '<a href="javascript:void(0)" class="delete-field">Delete</a>';
            html += '</div></div>';

            $('.site-fields').append(html);
        });

        $(document).on("click", ".delete-field", function() {
            $(this).parent().parent().remove();
        });
    });

</script>

