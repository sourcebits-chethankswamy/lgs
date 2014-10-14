<div class="main_content">
    <div class='content_settings'>
        <form method="post" action="<?php echo site_url('dashboard/save_configuration');?>">
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
                <?php 
                	echo "<div class='outer_tab'>
	                <label>Recipient's Email:</label>
	                <div class='outer_tab-values'>";
				    echo "<input id='emailAutocomplete' class='autocomplete' type='text' name='emails' value='' />";
				    echo "</div>";
				    echo "<a class='add_anchor' href='".site_url('email')."'>Add more emails in autoselect list</a>";
				    echo "</div>";
				
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
                ?>
                	<div class='outer_tab'>
                		<button class="btn right width-100 btn-success" type="submit" name='save' value='save'>Save</button> 
                	</div> 
            </legend>
        </form>
    </div>
</div>
