<div class="main_content">
	<div class='content_settings'>
        <div class="config-blk-header">
            <h1>Configuration Settings for:</h1>
            <select>
            <?php
            if(isset($site_lists)) {
                foreach ($site_lists as $value) {
                    echo '<option value="'.$value['id'].'" selected>'.$value['configuration_name'].'</option>';
                }
            }                
            ?>
            </select>
        </div>

        <?php        
        //print_r($field_details);
        ?>
        <legend class="config-blk-settings">   
            <?php
            if(isset($field_details)) {    
                $month_arr = array('january','february','march','april','may','june','july','august','september','october','november','december');
                foreach ($field_details as $each_field) {
                    echo "<div class='outer_tab'>
                            <label>".$each_field['field_name']."</label>
                            <div class='outer_tab-values'>";
                    
                    if($each_field['field_type'] == '1' || $each_field['field_type'] == '3') {                        
                        if($each_field['result_set'][0]['field_value_name'] == 'day' || $each_field['result_set'][1]['field_value_name'] == 'mon' || $each_field['result_set'][2]['field_value_name'] == 'year') {
                            
                            if($each_field['result_set'][0]['field_value_name'] == 'day') {
                                echo "<select style='width:auto'>";
                                echo "<option value='0' selected=''>Day</option>";
                                $day_sel_val = $each_field['result_set'][0]['value'];
                                for($i=1; $i<=31; $i++) {
                                    $day_sel = ($day_sel_val == $i) ? 'selected' : '';
                                    echo '<option value="'.$i.'" '.$day_sel.'>'.$i.'</option>';   
                                } 
                                echo "</select>";
                            }
                            
                            if($each_field['result_set'][1]['field_value_name'] == 'mon') {
                                echo "<select style='width:auto'>";
                                echo '<option value="0" selected="">Month</option>';    
                                $mon_sel_val = $each_field['result_set'][1]['value'];
                                for($j=1; $j<=12; $j++) {
                                    $mon_sel = ($mon_sel_val == $j) ? 'selected' : '';
                                    echo '<option value="'.$j.'" '.$mon_sel.'>'.strtoupper($month_arr[($j-1)]).'</option>';   
                                } 
                                echo "</select>";
                            }
                            
                            if($each_field['result_set'][2]['field_value_name'] == 'year') {
                                echo "<select style='width:auto'>";
                                echo '<option value="0" selected="">Year</option>';
                                $starting_year  =date('Y', strtotime('-4 year'));
                                $ending_year = date('Y', strtotime('+0 year'));
                                $year_sel_val = $each_field['result_set'][2]['value'];
                                
                                for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                    $year_sel = ($year_sel_val == $starting_year) ? 'selected' : '';
                                    echo '<option value="'.$starting_year.'" '.$year_sel.'>'.$starting_year.'</option>';
                                }   
                                echo "</select>";
                            }
                        } else {
                            $multiselect = ($each_field['field_type'] == '3') ? "multiple='' size='5'": "";
                            
                            echo "<select $multiselect>";
                            foreach ($each_field['result_set'] as $each_value) {
                                $selected = ($each_value['selected_status'] == '1') ? "selected" : "";
                                echo "<option value='".$each_value['value']."' ".$selected.">".$each_value['field_value_name']."</option>";
                            }
                            echo "</select>";
                        }                        
                    } else if ($each_field['field_type'] == '2') {
                        $selected_checkbox = ($each_field['result_set'][0]['selected_status'] == '1') ? "checked" : "";
                        echo "<input type='checkbox' ".$selected_checkbox." name='".$each_field['result_set'][0]['field_value_name']."' value='".$each_field['result_set'][0]['value']."' />";
                    } else if ($each_field['field_type'] == '0') {
                        echo "<input type='text' name='".$each_field['result_set'][0]['field_value_name']."' value='".$each_field['result_set'][0]['value']."' />";
                    }
                    echo "</div>
                        </div>";
                }
            }
            ?>
            
             
            
            <!--
            
            
            
            <div class='outer_tab'>
                <label>Notice Type:</label>
                <div class="outer_tab-values">
                    <select>
                        <option value="1,2,3,7,10,11,16">Tenders, RFPs &amp; Prequalification</option>
                        <option value="9">Projects</option>
                        <option value="4,8">Procurement News</option>
                        <option value="5">Contract Awards</option>
                        <option value="1,2,3,7,10,11,16,9,4,8" selected="">All</option>
                    </select> 
                </div>
            </div>

            <div class='outer_tab'>
                <label>Multi Funding Agencies:</label>
                <div class="outer_tab-values">
                    <input type="checkbox" value="1" name="mfa">Check box to search for only MFA 
                </div>
            </div>

            <div class='outer_tab'>
                <label>Sector:</label>
                
                <div class="outer_tab-values">
                <select name="sector" size="5" class="fieldbox">
                    <option value="0" selected="">All Sector</option>
                    <option value="01">Agriculture and Related Services</option>
                    <option value="02">Industry</option>
                    <option value="0202">Industry - Automobiles</option>
                    <option value="0203">Industry - Cement</option>
                    <option value="0204">Industry - Chemicals and Fertilizers</option>
                    <option value="0205">Industry - Leather</option>
                    <option value="0206">Industry - Machinery</option>
                    <option value="0207">Industry - Minerals and Metals</option>
                    <option value="0208">Industry - Mining</option>
                    <option value="0209">Industry - Paper &amp; Packaging</option>
                    <option value="0210">Industry - Plastic &amp; Rubber</option>
                    <option value="0211">Industry - Textiles</option>
                    <option value="0212">Industry - Fire Safety and Security</option>
                    <option value="0214">Industry - Printing and publishing</option>
                    <option value="0215">Industry - Furniture</option>
                    <option value="03">Retail</option>
                    <option value="04">Real Estate</option>
                    <option value="05">BPO</option>
                    <option value="06">SME</option>
                    <option value="07">Research &amp; Development</option>
                    <option value="08">Science &amp; Technology</option>
                    <option value="09">Engineering Procurement &amp; Construction (EPC)</option>
                    <option value="10">Sports</option>
                    <option value="17">Telecommunications</option>
                    <option value="18">Healthcare and Medical</option>
                    <option value="19">Energy, Power and Electrical</option>
                    <option value="1928">Energy &amp; Power - Industrial Automation</option>
                    <option value="1929">Energy &amp; Power - Renewable Energy</option>
                    <option value="1930">Energy &amp; Power - Non-Renewable Energy</option>
                    <option value="20">Water and Sanitation</option>
                    <option value="21">Transportation</option>
                    <option value="2101">Transportation - Airports &amp; Aviation</option>
                    <option value="2102">Transportation - Ports,Waterways and Shipping</option>
                    <option value="2103">Transportation - Railways</option>
                    <option value="2104">Transportation - Roads and highways</option>
                    <option value="26">Banking, Finance, Insurance and Securities (BFIS)</option>
                    <option value="2607">BFIS - Insurance</option>
                    <option value="2611">BFIS - Merger &amp; Acquisition</option>
                    <option value="27">Information Technology (IT)</option>
                    <option value="2703">IT - Access Control</option>
                    <option value="2704">IT - GIS / GPS</option>
                    <option value="28">Consultancy</option>
                    <option value="2801">Consultancy - Education</option>
                    <option value="2802">Consultancy - Engineering</option>
                    <option value="2803">Consultancy - Financial</option>
                    <option value="2804">Consultancy - Health</option>
                    <option value="2805">Consultancy - HR</option>
                    <option value="2806">Consultancy - IT</option>
                    <option value="2807">Consultancy - Management</option>
                    <option value="2808">Consultancy - Oil &amp; Gas</option>
                    <option value="2809">Consultancy - Security</option>
                    <option value="2810">Consultancy - Tourism</option>
                    <option value="2811">Consultancy - Law</option>
                    <option value="44">Oil and Gas</option>
                    <option value="45">Services</option>
                    <option value="4501">Services - Entertainment &amp; Media</option>
                    <option value="4503">Services - Postal and Telegraph</option>
                    <option value="46">Education</option>
                    <option value="47">Infrastructure and construction</option>
                    <option value="4701">Infrastructure - Roads and Highways</option>
                    <option value="4702">Infrastructure - Bridges</option>
                    <option value="4703">Infrastructure - Tunnels</option>
                    <option value="4705">Infrastructure - Airports</option>
                    <option value="4708">Infrastructure - Building</option>
                    <option value="55">Environment and Pollution</option>
                    <option value="56">Defence</option>
                    <option value="57">Public Private Partnership (PPP)</option>
                    <option value="58">Privatisation</option>
                    <option value="60">Rehabilitation</option>
                    <option value="63">Export and Trade</option>								
                </select>
                </div>
            </div>

            <div class='outer_tab'>
                <label>Country/Region:</label>
                
                <div class="outer_tab-values">
                <select name="region_name[]" size="5" multiple=""> 
                    <option value="0" selected="">All Region</option>
                    <option value="REG0100">Africa Region</option>
                    <option value="REG0101">Central Africa/Middle Africa Region</option>
                    <option value="REG0102">East Africa/Eastern Africa Region</option>
                    <option value="REG0103">North Africa/Northern Africa Region</option>
                    <option value="REG0104">Southern Africa Region</option>
                    <option value="REG0105">West Africa Region</option>
                    <option value="REG0106">Sub-Saharan Africa Region</option>
                    <option value="REG0200">Americas Region</option>
                    <option value="REG0201">Caribbean Region</option>
                    <option value="REG0202">Central America Region</option>
                    <option value="REG0203">Northern America Region</option>
                    <option value="REG0204">South America Region</option>
                    <option value="REG0205">Latin America Region</option>
                    <option value="REG0300">Asia Region</option>
                    <option value="REG0301">Central Asia Region</option>
                    <option value="REG0302">Eastern Asia Region</option>
                    <option value="REG0303">Middle East Region</option>
                    <option value="REG0304">South Asia Region</option>
                    <option value="REG0305">South East Asia Region</option>
                    <option value="REG0306">Western Asia Region</option>
                    <option value="REG0307">SAARC Region</option>
                    <option value="REG0308">GCC Countries Region</option>
                    <option value="REG0309">Gulf Countries Region</option>
                    <option value="REG0400">Australia &amp; Oceania Region</option>
                    <option value="REG0401">Australia and New Zealand Region</option>
                    <option value="REG0402">Melanesia Region</option>
                    <option value="REG0403">Micronesia Region</option>
                    <option value="REG0404">Polynesia Region</option>
                    <option value="REG0405">South Pacific Oceania Region</option>
                    <option value="REG0500">Europe Region</option>
                    <option value="REG0501">Eastern Europe Region</option>
                    <option value="REG0502">Northern Europe Region</option>
                    <option value="REG0503">Southern Europe Region</option>
                    <option value="REG0504">Western Europe Region</option>
                    <option value="REG0505">Central Europe Region</option>
                    <option value="REG0506">Baltic Region</option>
                    <option value="REG0600">CIS Region</option>
                    <option value="REG0700">Mediterranean Region</option>
                    <option value="REG0800">MENA Countries Region</option>
                    <option value="REG0900">Asia Pacific Region</option>
                    <option value="REG1000">APEC Countries Region</option>
                    <option value="REG1100">Balkan Region Region</option>
                    <option value="AF">Afghanistan</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AG">Antigua And Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia</option>
                    <option value="BA">Bosnia And Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BV">Bouvet Island</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cape Verde</option>
                    <option value="KY">Cayman Islands</option>
                    <option value="CF">Central African Republic</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CX">Christmas Islands</option>
                    <option value="CC">Cocos (keeling) Islands</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros</option>
                    <option value="CD">Congo Democratic Republic Of</option>
                    <option value="CG">Congo Peoples Republic Of</option>
                    <option value="CK">Cook Islands</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Cote Dlvoire</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands</option>
                    <option value="FO">Faroe Islands</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran Islamic Republic Of</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IM">Isle Of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KP">Korea Democratic Peoples Republic Of</option>
                    <option value="KR">Korea Republic Of</option>
                    <option value="KV">Kosovo</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao Peoples Democratic Republic</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macau</option>
                    <option value="MK">Macedonia</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte Islands</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia (federated States Of)</option>
                    <option value="MD">Moldova Republic Of</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="MJ">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="AN">Netherlands Antilles</option>
                    <option value="NL">Netherlands</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Islands</option>
                    <option value="MP">Northern Mariana Islands</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestine</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RE">Reunion</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation</option>
                    <option value="RW">Rwanda</option>
                    <option value="SH">Saint Helena</option>
                    <option value="KN">Saint Kitts And Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="PM">Saint Pierre And Miquelon</option>
                    <option value="VC">Saint Vincent And The Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome And Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RB">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia And The South Sandwich Islands</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SD">Sudan</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard And Jan Mayen</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syria Arab Republic</option>
                    <option value="TW">Taiwan Province Of China</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania</option>
                    <option value="TH">Thailand</option>
                    <option value="TP">Timor-leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad And Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Turkey</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks And Caicos Islands</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="US">United States</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VA">Vatican City State (holy See)</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN">Vietnam</option>
                    <option value="VG">Virgin Islands (british)</option>
                    <option value="VI">Virgin Islands (u.s.)</option>
                    <option value="WF">Wallis And Futuna Islands</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                    </select>
                </div>
            </div>

            <div class='outer_tab'>
                <label>Bidding Type</label>
                
                <div class="outer_tab-values">
                <select name="competition"> 
                    <option value="2">Select Competition</option> 
                    <option value="0">Domestic Tenders</option> 
                    <option value="1">Global Tenders</option> 
                    <option selected="" value="2">Both Global and Domestic</option> 
                </select>
                </div>
            </div>
            
            <div class='outer_tab'>
                <label>Date From:</label>
                
                <div class="outer_tab-values date-setting">
                <select name="day" size="1">
                    <option value="0" selected="">Day</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
                <select name="mon" size="1">
                    <option value="0" selected="">Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select name="year" size="1">
                    <option value="0" selected="">Year</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>																										
                </select>
                </div>
            </div>
            
            <div class='outer_tab'>
                <label>Keyword Search:</label>
                
                <div class="outer_tab-values">
                    <input type="text" size="30" name="t">
                </div>
            </div>
            
            <div class='outer_tab'>
                <label>Deadline</label>
                
                <div class="outer_tab-values">
                    <select name="deadline"> 
                        <option value="select">All Time</option>
                        <option value="today">Expiring Today</option>
                        <option value="tomorrow">Expiring Tomorrow</option>
                        <option value="next7days">Expiring in Next 7 days</option>
                        <option value="thismonth">Expiring This Month</option>
                        <option value="nextmonth">Expiring Next Month</option> 
                    </select>
                </div>
            </div>
            -->
            <div class='outer_tab'>
                <button class="btn right width-100 btn-success" type="button">Save</button>
            </div>            
        </legend>
		
	</div>
</div>