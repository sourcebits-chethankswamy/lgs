function closeMessage() {
    $('.message').slideUp('slow');
    $('.message span').html("");
}
function openMessage() {
    $('.message').slideDown('slow', function() {
        window.setTimeout('closeMessage()', 2000);
    });
}
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
$(function() {
    if ($('.message span').text().length) {
        openMessage();
    }
    var height_of_page = $(document).height() - 82;
    $('.well.sidebar-nav').css('height', height_of_page + 'px');
    $('.well.sidebar-nav ul .active').removeClass('active');
    $('.main-tab, .main-tab1').css('cssText','margin-bottom:0px !important');
    if (location.href.indexOf('dashboard/configsettings') != -1) { // configuration settings
    	$('.well.sidebar-nav ul li:nth-child(3)').addClass('active');
    } else if (location.href.indexOf('dashboard/changepassword') != -1 || location.href.indexOf('keywords') != -1 || location.href.indexOf('email') != -1) {	// General settings subtabs
    	$('.well.sidebar-nav ul li:nth-child(4)').addClass('active');
    	$('.arrow').css('border-top','8px solid #fafafa');
    	$('.main-tab').css('cssText','margin-bottom:10px !important');
    } else if (location.href.indexOf('site') != -1) {	// Site subtabs
    	$('.well.sidebar-nav ul li:nth-child(8)').addClass('active');
    	$('.arrow').css('border-top','8px solid #fafafa');
    	$('.main-tab1').css('cssText','margin-bottom:10px !important');
    } else { // Email settings
        $('.well.sidebar-nav ul li:nth-child(2)').addClass('active');
    }
    
    
    $('#sel_keywords').val(keywords);
    $('#sel_emails').val(emails);

    $('#keywordAutocomplete').val(sel_keywords);
    $('#emailAutocomplete').val(sel_emails);

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
        var r = confirm("Are you sure, you want to delete?");
        if (r == false) {
            return false;
        }
        
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
                r = JSON.parse(r);
                if (r['error'] == '1') {
                    $('.message span').html(r['message']);
                    openMessage();
                } else {
                    $('.message span').html(r['message']);
                    openMessage();
                    setTimeout(function() {
                        location.reload(true);
                    }, 500);
                }
            }
        });
    });

    $(document).on("click", ".edit", function() {
        var input_data = $(this).parent().find('input').val();
        if(input_data == ''){
            alert('No data provided');
            return false;
        }
        
        var type = $(this).attr('data-type');
        var id = $(this).attr('data-id');
        var url, email, data = '';
        if (type == 'email') {
            email = $(this).parent().find('input').val();
            if(!validateEmail(email)) {
                alert('Invalid email provided');
                return false;
            }
            url = 'email/modify_email';            
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
                if (r['error'] == '1') {
                    $('.message span').html(r['message']);
                    openMessage();
                } else {
                    $('.message span').html(r['message']);
                    openMessage();
                    setTimeout(function() {
                        location.reload(true);
                    }, 500);
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

    $(document).on("click", ".delete_config", function(e) {
        var r = confirm("Are you sure to delete?, It cannot be undone");
        if (r == false) {
            e.preventDefault();
        }
    });

    $(document).on("click", ".status_config", function(e) {
        var r = confirm("Are you sure you want to make this configuration \"" + $(this).attr('data-message') + "\"?");
        if (r == false) {
            e.preventDefault();
        }
    });

    $(window).resize(function() {
        var height_of_page = $(document).height() - 82;
        $('.well.sidebar-nav').css('height', height_of_page + 'px');
    });


    $(document).on("click", "#search_conf", function(e) {
        $('#output').html('');
        $('html, body').animate({
            scrollTop: $(".ajx-loading").offset().top
        }, 2000);
        $('.ajx-loading').show();
        var formURL = site_url + 'dashboard/search';
        var postData = $('#submit_config_form').serialize();
        var jqxhr = $.post(formURL, postData, function(data) {
            $('#output').html(data).show();
            $('html, body').animate({
                scrollTop: $("#output").offset().top
            }, 2000);
        }).done(function() {
            $('.ajx-loading').hide();
        }).fail(function() {
            $('#output').html('Sorry, Error encountered while fetching the data!! Please reload the page and try again');
        });
    });
});
