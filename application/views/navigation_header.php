<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
       	<a class="brand margin-left-12" href="#">Lead Generation System</a>
			<?php 
           		$atts = array(
              'class' => 'logout'
            );
           	echo anchor('user/logout', ' ', $atts); ?>
           	<p class="navbar-text pull-right">
           		Welcome <a class="navbar-link" href="#"><?php echo $this->session->userdata('user_email');?></a>
           	</p>
	</div>
</div>