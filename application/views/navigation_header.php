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
              <li class="nav-header pad8">Menu</li>
              <li class=""><a class='pad10 navigation_sidebar' href="<?php echo site_url('/dashboard');?>">Configuration Settings</a></li>
              <li class=""><a class='pad10 navigation_sidebar' href="<?php echo site_url('/dashboard/configsettings');?>"> Email Settings</a></li>
              <!-- Sub Menu -->
              <li class=''><a class='pad10 navigation_sidebar main-tab' href="<?php echo site_url('/email');?>">General Settings<span class='arrow right'></a></span></li>
              <li style=''><a class='sublist navigation_sidebar' href="<?php echo site_url('/email');?>">Email List<span class='arrowleft left'></a></li>
              <li style=''><a class='sublist navigation_sidebar' href="<?php echo site_url('/keywords');?>">Keywords List<span class='arrowleft left'></a></li>
              <li style=''><a class='sublist navigation_sidebar' href="<?php echo site_url('dashboard/changepassword');?>">Reset password<span class='arrowleft left'></a></li>
              
              <li class=''><a class='pad10 navigation_sidebar main-tab1' href="<?php echo site_url('/site');?>">Sites<span class='arrow1 right'></a></span></li>
              <li style=''><a class='sublist navigation_sidebar' href="<?php echo site_url('/site');?>">List<span class='arrowleft1 left'></a></li>
              <li style=''><a class='sublist navigation_sidebar' href="<?php echo site_url('/site/add');?>">Add<span class='arrowleft1 left'></a></li>
              
            </ul>
          </div>
        </div>
