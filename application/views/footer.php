   <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo site_url('/js/jquery.js');?>"></script>
    <script src="<?php echo site_url('js/bootstrap.min.js');?>"></script>
    <script src="<?php echo site_url('/js/main.js');?>"></script>
    <script type='text/javascript'>
    	$(document).ready(function(){
        	var height_of_page = $(window).height()-82;
			$('.well.sidebar-nav').css('height', height_of_page+'px');
		});
    </script>
</body>
</html>