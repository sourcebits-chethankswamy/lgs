<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
       	<a class="brand margin-left-12" href="<?php echo site_url();?>">Lead Generation System</a>
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

<div class="content">
	<div class="row-fluid">
        <div class="navigation left">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header pad8">Search Options</li>
              <li class="active"><a class='pad10 navigation_sidebar' href="<?php echo site_url('/dashboard');?>">Search Settings</a></li>
              <li><a class='pad10 navigation_sidebar' href="<?php echo site_url('/email');?>">Email List</a></li>
              <li><a class='pad10 navigation_sidebar' href="<?php echo site_url('/keywords');?>">Keywords List</a></li>
            </ul>
          </div>
        </div>