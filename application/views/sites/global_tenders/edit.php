<form method="post" action="<?php echo site_url('dashboard/save');?>" id="submit_config_form">
    <?php
    //print_r($field_details);exit;
    if (isset($field_details)) {
        echo "<div class='outer_tab'>
                <label>Configuration name</label>
                <div class='outer_tab-values'>
                    <input type='text' name='config_name' value='".$configuration_name."' />
                </div>
             </div>";
        
        $month_arr = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
        foreach ($field_details as $key => $each_field) {
            echo "<div class='outer_tab'>
                    <label>" . $each_field['field_name'] . "</label>
                    <div class='outer_tab-values'>";

            if ($each_field['field_type'] == '1' || $each_field['field_type'] == '3') {
                if ($each_field['result_set'][0]['field_value_name'] == 'day' || $each_field['result_set'][1]['field_value_name'] == 'mon' || $each_field['result_set'][2]['field_value_name'] == 'year') {

                    if ($each_field['result_set'][0]['field_value_name'] == 'day') {
                        echo "<select name='set[" . $key . "_day]' style='width:auto'>";
                        echo "<option value='" . $each_field['result_set'][0]['field_value_id'] . "_NULL' selected=''>Day</option>";
                        $day_sel_val = $each_field['result_set'][0]['value'];
                        $day_selected = $each_field['result_set'][0]['selected_status'];
                        for ($i = 1; $i <= 31; $i++) {
                            $day_sel = ($day_selected == '1' && $day_sel_val == $i) ? 'selected' : '';
                            echo '<option value="' . $each_field['result_set'][0]['field_value_id'] . '_' . sprintf("%02d", $i) . '" ' . $day_sel . '>' . sprintf("%02d", $i) . '</option>';
                        }
                        echo "</select>";
                    }

                    if ($each_field['result_set'][1]['field_value_name'] == 'mon') {
                        echo "<select name='set[" . $key . "_month]' style='width:auto'>";
                        echo '<option value="' . $each_field['result_set'][1]['field_value_id'] . '_NULL" selected="">Month</option>';
                        $mon_sel_val = $each_field['result_set'][1]['value'];
                        $mon_selected = $each_field['result_set'][1]['selected_status'];
                        for ($j = 1; $j <= 12; $j++) {
                            $mon_sel = ($mon_selected == '1' && $mon_sel_val == $j) ? 'selected' : '';
                            echo '<option value="' . $each_field['result_set'][1]['field_value_id'] . '_' . $j . '" ' . $mon_sel . '>' . strtoupper($month_arr[($j - 1)]) . '</option>';
                        }
                        echo "</select>";
                    }

                    if ($each_field['result_set'][2]['field_value_name'] == 'year') {
                        echo "<select name='set[" . $key . "_year]' style='width:auto'>";
                        echo '<option value="' . $each_field['result_set'][2]['field_value_id'] . '_NULL" selected="">Year</option>';
                        $starting_year = date('Y', strtotime('-4 year'));
                        $ending_year = date('Y', strtotime('+0 year'));
                        $year_sel_val = $each_field['result_set'][2]['value'];
                        $year_selected = $each_field['result_set'][2]['selected_status'];
                        
                        for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
                            $year_sel = ($year_selected == '1' && $year_sel_val == $starting_year) ? 'selected' : '';
                            echo '<option value="' . $each_field['result_set'][2]['field_value_id'] . '_' . $starting_year . '" ' . $year_sel . '>' . $starting_year . '</option>';
                        }
                        echo "</select>";
                    }
                } else {
                    $multiselect = ($each_field['field_type'] == '3') ? "multiple='' size='5'" : "";

                    if ($multiselect) {
                        $name = "set[" . $key . "][]";
                    } else {
                        $name = "set[" . $key . "]";
                    }

                    echo "<select name='" . $name . "' $multiselect>";
                    foreach ($each_field['result_set'] as $each_value) {
                        $selected = ($each_value['selected_status'] == '1') ? "selected" : "";
                        echo "<option value='" . $each_value['field_value_id'] . "' " . $selected . ">" . $each_value['field_value_name'] . "</option>";
                    }
                    echo "</select>";

                    unset($each_value);
                }
            } else if ($each_field['field_type'] == '2') {
                $selected_checkbox = ($each_field['result_set'][0]['selected_status'] == '1') ? "checked" : "";
                echo "<input class='ignore' type='checkbox' " . $selected_checkbox . " name='set[" . $key . "]' value='" . $each_field['result_set'][0]['field_value_id'] . "' />";
            } else if ($each_field['field_type'] == '0') {
                echo "<input id='keywordAutocomplete' class='autocomplete' type='text' name='keywords' value='" . $each_field['result_set'][0]['value'] . "' />";
            }

            echo "</div>
            </div>";

            unset($each_field);
        }

        //echo "<div class='outer_tab'><label>AUTO run setting:</label><div class='outer_tab-values'></div></div>";
    }
    ?>
    <div class='outer_tab'>
        <input type="hidden" name="site_id" value="<?php echo $selected_site_id; ?>" />
        <input type="hidden" name="configuration_id" value="<?php echo $selected_configuration_id; ?>" />
        <button class="btn right width-100 btn-success" type="submit" name='save' id="save_conf">Save</button>
        <button class="btn right width-100 btn-primary" type="button" name='search' id="search_conf">Test Search</button>                
    </div>     
</form>

<div class="ajx-loading">
    <img src="/assets/images/load.gif" alt="loading..." title="loading.." />
</div>
<div class='search_results' id="output"></div>