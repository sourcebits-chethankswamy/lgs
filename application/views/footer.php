<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo site_url('/assets/js/jquery.js'); ?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="<?php echo site_url('/assets/js/jquery.autocomplete.multiselect.js'); ?>"></script>
<script src="<?php echo site_url('/assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo site_url('/assets/js/main.js'); ?>"></script>
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
    $(function() {
        var height_of_page = $(document).height() - 82;
        $('.well.sidebar-nav').css('height', height_of_page + 'px');
        $('.well.sidebar-nav ul .active').removeClass('active');
        if (location.href.indexOf('dashboard') != -1) {
            $('.well.sidebar-nav ul li:nth-child(2)').addClass('active');
        } else if (location.href.indexOf('keywords') != -1) {
            $('.well.sidebar-nav ul li:nth-child(4)').addClass('active');
        } else {
            $('.well.sidebar-nav ul li:nth-child(3)').addClass('active');
        }

        $('#sel_keywords').val('<?php echo $keyword_id_details; ?>');
        $('#sel_emails').val('<?php echo $email_id_details; ?>');

        $('#keywordAutocomplete').val('<?php echo $sel_keywords; ?>');
        $('#emailAutocomplete').val('<?php echo $sel_emails; ?>');

        var keywordTags = [<?php echo $keyword_details; ?>];
        var emailTags = [<?php echo $email_details; ?>];

        function split(val) {
            return val.split(/,\s*/);
        }
        function extractLast(term) {
            return split(term).pop();
        }
        $("#keywordAutocomplete")
                // don't navigate away from the field on tab when selecting an item
                .bind("keydown", function(event) {
                    if (event.keyCode === $.ui.keyCode.TAB &&
                            $(this).autocomplete("instance").menu.active) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // delegate back to autocomplete, but extract the last term
                        response($.ui.autocomplete.filter(
                                keywordTags, extractLast(request.term)));
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function(event, ui) {
                        var terms = split(this.value);
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join(", ");

                        return false;
                    }
                });
        $("#emailAutocomplete")
                // don't navigate away from the field on tab when selecting an item
                .bind("keydown", function(event) {
                    if (event.keyCode === $.ui.keyCode.TAB &&
                            $(this).autocomplete("instance").menu.active) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        // delegate back to autocomplete, but extract the last term
                        response($.ui.autocomplete.filter(
                                emailTags, extractLast(request.term)));
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function(event, ui) {
                        var terms = split(this.value);
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join(", ");

                        return false;
                    }
                });

        $(document).on("click", ".delete", function() {
            var type = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            var url = '';
            if (type == 'email') {
                url = 'email/delete_email';
            } else {
                url = 'keywords/delete_keyword';
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: 'id=' + id,
                success: function(r) {
                    location.reload(true);
                }
            });
        });

        $(document).on("click", ".edit", function() {
            var type = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            var url, email, data = '';
            if (type == 'email') {
                url = 'email/modify_email';
                email = $(this).parent().find('input').val();
                data = 'id=' + id + '&email=' + email;
            } else {
                url = 'keywords/modify_keyword';
                keyword = $(this).parent().find('input').val();
                data = 'id=' + id + '&keyword=' + keyword;
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(r) {
                    r = JSON.parse(r);
					if(r['error'] == '-1'){
						$('.error_block').show();
					} else {
            			location.reload(true);
					}
                }
            });
        });

        $(document).on("change", "#site_id", function() {
            var id = $(this).val();
            var url = 'dashboard/set_site/' + id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(r) {
                    //console.log(r);
                    location.reload(true);
                }
            });
        });
         $(window).resize(function(){
        	var height_of_page = $(document).height() - 82;
        	$('.well.sidebar-nav').css('height', height_of_page + 'px');
        });
    });
</script>
</body>
</html>