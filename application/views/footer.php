        <?php
        $keyword_details = '';
        $email_details = '';
        $email_id_details = '';
        $keyword_id_details = '';
        $sel_emails = '';
        $sel_keywords = '';
        if (isset($emails_list)) {
            $emails = array();
            foreach ($emails_list as $key => $value) {
                $email_chunks = "{label:\"" . $value['email'] . "\",value:\"" . $value['email'] . "\", edb:" . $value['id'] . "}";
                array_push($emails, $email_chunks);
            }
            $email_details = implode(',', $emails);
        }
        if (isset($keywords_list)) {
            $keywords = array();
            foreach ($keywords_list as $key => $value) {
                $keyword_chunks = "{label:\"" . $value['keyword'] . "\",value:\"" . $value['keyword'] . "\", kdb:" . $value['id'] . "}";
                array_push($keywords, $keyword_chunks);
            }
            $keyword_details = implode(',', $keywords);
        }

        if (isset($selected_site_keywords)) {
            $keyword_ids = array();
            $sel_keys = array();
            foreach ($selected_site_keywords as $key => $value) {
                array_push($keyword_ids, $value['keyword_id']);
                array_push($sel_keys, $value['keyword']);
            }
            $keyword_id_details = implode(',', $keyword_ids);
            $sel_keywords = implode(',', $sel_keys);
        }

        if (isset($selected_site_emails)) {
            $email_ids = array();
            $sel_email = array();
            foreach ($selected_site_emails as $key => $value) {
                array_push($email_ids, $value['email_id']);
                array_push($sel_email, $value['email']);
            }
            $email_id_details = implode(',', $email_ids);
            $sel_emails = implode(',', $sel_email);
        }
        ?>
        <script type='text/javascript'>
            var keywords = '<?php echo $keyword_id_details; ?>';
            var emails = '<?php echo $email_id_details; ?>';
            var sel_keywords = '<?php echo $sel_keywords; ?>';
            var sel_emails = '<?php echo $sel_emails; ?>';
            
            var keywordTags = [<?php echo $keyword_details; ?>];
            var emailTags = [<?php echo $email_details; ?>];
        </script>
        
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo site_url('/assets/js/jquery.js'); ?>"></script>
        <script src="<?php echo site_url('/assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo site_url('/assets/js/jquery.autocomplete.multiselect.js'); ?>"></script>
        <script src="<?php echo site_url('/assets/js/bootstrap.min.js'); ?>"></script>  
        <script src="<?php echo site_url('/assets/js/main.js'); ?>"></script>        
    </body>
</html>