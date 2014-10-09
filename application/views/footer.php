   <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo site_url('/assets/js/jquery.js');?>"></script>
    <script src="<?php echo site_url('/assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo site_url('/assets/js/main.js');?>"></script>
    <script type='text/javascript'>
    	$(document).ready(function(){
        	var height_of_page = $(window).height()-82;
			$('.well.sidebar-nav').css('height', height_of_page+'px');
			$('.well.sidebar-nav ul .active').removeClass('active');
			if(location.href.indexOf('dashboard') != -1){
				$('.well.sidebar-nav ul li:nth-child(2)').addClass('active');
			} else if(location.href.indexOf('keywords') != -1){
				$('.well.sidebar-nav ul li:nth-child(4)').addClass('active');
			} else {
				$('.well.sidebar-nav ul li:nth-child(3)').addClass('active');
			}
		});
    	function edit_add_data(chk, type, id){
			if(type == 'email'){
				var url = 'email/modify_email';
				var email = $(chk).parent().find('input').val();
				var data = 'id='+id+'&email='+email;
			} else {
				var url = 'keywords/modify_keyword';
				var keyword = $(chk).parent().find('input').val();
				var data = 'id='+id+'&keyword='+keyword;
			}
			$.ajax({
				type: 'POST',
				url : url,
				data: data,
				success: function(r){ 
					location.reload(true);
				}
			});
		}
		
		function delete_data(type, id){
			if(type == 'email'){
				var url = 'email/delete_email';
			} else {
				var url = 'keywords/delete_keyword';
			}
			$.ajax({
				type: 'POST',
				url : url,
				data: 'id='+id,
				success: function(r){ 
					location.reload(true);
				}
			});
		}
    </script>
</body>
</html>