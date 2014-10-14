<?php

if (isset($field_details)) {
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
                    for ($i = 1; $i <= 31; $i++) {
                        $day_sel = ($day_sel_val == $i) ? 'selected' : '';
                        echo '<option value="' . $each_field['result_set'][0]['field_value_id'] . '_' . sprintf("%02d", $i) . '" ' . $day_sel . '>' . sprintf("%02d", $i) . '</option>';
                    }
                    echo "</select>";
                }

                if ($each_field['result_set'][1]['field_value_name'] == 'mon') {
                    echo "<select name='set[" . $key . "_month]' style='width:auto'>";
                    echo '<option value="' . $each_field['result_set'][1]['field_value_id'] . '_NULL" selected="">Month</option>';
                    $mon_sel_val = $each_field['result_set'][1]['value'];
                    for ($j = 1; $j <= 12; $j++) {
                        $mon_sel = ($mon_sel_val == $j) ? 'selected' : '';
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

                    for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
                        $year_sel = ($year_sel_val == $starting_year) ? 'selected' : '';
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
            echo "<input id='keywordAutocomplete' class='autocomplete left' type='text' name='keywords' value='" . $each_field['result_set'][0]['value'] . "' />";
             echo "<a class='add_anchor' href='".site_url('keywords')."'>Add more keywords in autoselect list</a>";
        }

        echo "</div>
        </div>";

        unset($each_field);
    }
    echo "<div class='outer_tab'>
                <label>Recipient's Email:</label>
                <div class='outer_tab-values'>";
    echo "<input id='emailAutocomplete' class='autocomplete' type='text' name='emails' value='' />";
    echo "</div></div>";

    echo "<div class='outer_tab'>
            <label>AUTO run setting:</label>
            <div class='outer_tab-values'>";

    echo "<select name='cronjob[min]' style='width:auto' title='Minute'>";    
    $cjmin_sel_val = (isset($cronjob_settings[0]['minute'])) ? $cronjob_settings[0]['minute'] : '';
    $cjmin_sel_none = (($cjmin_sel_val != '') && ($cjmin_sel_val == 'NULL')) ? 'selected' : '';
    echo "<option value='NULL' $cjmin_sel_none>Minute</option>";
    for ($cj = 0; $cj <= 59; $cj++) {
        $cjmin_sel = (($cjmin_sel_val != '') && ($cjmin_sel_val === sprintf("%02d", $cj))) ? 'selected' : '';
        echo '<option value="' . sprintf("%02d", $cj) . '" ' . $cjmin_sel . '>' . sprintf("%02d", $cj) . '</option>';
    }
    echo "</select>";

    echo "<select name='cronjob[hour]' style='width:auto' title='Hour'>";
    $cjhour_sel_val = (isset($cronjob_settings[0]['hour'])) ? $cronjob_settings[0]['hour'] : '';
    $cjhour_sel_all = (($cjhour_sel_val != '') && ($cjhour_sel_val == '*')) ? 'selected' : '';
    $cjhour_sel_none = (($cjhour_sel_val != '') && ($cjhour_sel_val == 'NULL')) ? 'selected' : '';
    echo "<option value='NULL' $cjhour_sel_none>Hour</option>";  
    echo "<option value='*' $cjhour_sel_all>Every Hour</option>";
    for ($ck = 0; $ck <= 23; $ck++) {
        $cjhour_sel = (($cjhour_sel_val != '') && ($cjhour_sel_val === sprintf("%02d", $ck))) ? 'selected' : '';
        echo '<option value="' . sprintf("%02d", $ck) . '" ' . $cjhour_sel . '>' . sprintf("%02d", $ck) . '</option>';
    }
    echo "</select>";

    echo "<select name='cronjob[day]' style='width:auto' title='Day of Month'>";    
    $cjday_sel_val = (isset($cronjob_settings[0]['day-of-month'])) ? $cronjob_settings[0]['day-of-month'] : '';
    $cjday_sel_all = (($cjday_sel_val != '') && ($cjday_sel_val == '*')) ? 'selected' : '';
    $cjday_sel_none = (($cjday_sel_val != '') && ($cjday_sel_val == 'NULL')) ? 'selected' : '';
    echo "<option value='NULL' $cjday_sel_none>Day of Month</option>";
    echo "<option value='*' $cjday_sel_all>Every Day</option>";
    for ($ci = 1; $ci <= 31; $ci++) {
        $cjday_sel = (($cjday_sel_val != '') && ($cjday_sel_val === sprintf("%02d", $ci))) ? 'selected' : '';
        echo '<option value="' . sprintf("%02d", $ci) . '" ' . $cjday_sel . '>' . sprintf("%02d", $ci) . '</option>';
    }
    echo "</select>";

    echo "<select name='cronjob[month]' style='width:auto' title='Month'>";    
    $cjmonth_sel_val = (isset($cronjob_settings[0]['month'])) ? $cronjob_settings[0]['month'] : '';
    $cjmonth_sel_all = (($cjmonth_sel_val != '') && ($cjmonth_sel_val == '*')) ? 'selected' : '';
    $cjmonth_sel_none = (($cjmonth_sel_val != '') && ($cjmonth_sel_val == 'NULL')) ? 'selected' : '';
    echo "<option value='NULL' $cjmonth_sel_none>Month</option>";
    echo "<option value='*' $cjmonth_sel_all>Every Month</option>";
    for ($cl = 1; $cl <= 12; $cl++) {
        $cjmonth_sel = (($cjmonth_sel_val != '') && ($cjmonth_sel_val === sprintf("%02d", $cl))) ? 'selected' : '';
        echo '<option value="' . sprintf("%02d", $cl) . '" ' . $cjmonth_sel . '>' . sprintf("%02d", $cl) . '</option>';
    }
    echo "</select>";

    
    
    echo "<select name='cronjob[week]' style='width:auto' title='Day of Week'>";    
    $cjweek_sel_val = (isset($cronjob_settings[0]['day-of-week'])) ? $cronjob_settings[0]['day-of-week'] : '';
    $cjweek_sel_all = (($cjweek_sel_val != '') && ($cjweek_sel_val == '*')) ? 'selected' : '';
    $cjweek_sel_none = (($cjweek_sel_val != '') && ($cjweek_sel_val == 'NULL')) ? 'selected' : '';
    echo "<option value='NULL' $cjweek_sel_none>Day of Week</option>";
    echo "<option value='*' $cjweek_sel_all>Every Week</option>";
    for ($cm = 0; $cm <= 6; $cm++) {
        $cjweek_sel = (($cjweek_sel_val != '') && ($cjweek_sel_val === sprintf("%02d", $cm))) ? 'selected' : '';
        echo '<option value="' . sprintf("%02d", $cm) . '" ' . $cjweek_sel . '>' . sprintf("%02d", $cm) . '</option>';
    }
    echo "</select>";
    echo "</div>
        </div>";
}
?>

