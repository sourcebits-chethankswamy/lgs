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
    </script>
</body>
</html>