<div class="main_content">
	<div class='content_settings' style='padding:3% 28%;'>
		<legend style='border:1px solid #c6c6c6;border-bottom:none;'>
           <h1>Emails Setup</h1>
           <?php if(!isset($users_list) || empty($users_list)) { ?>
           		<div class='red'>No Users present</div>
           <?php }?>
           <?php if(isset($users_list)) {
           		foreach($users_list as $user) { ?>
    			<div class='email_tab'>
		    		<input type='text' value='<?php echo $user['email'];?>' id='' class='' name='' />
		    		<a class="btn btn-danger right delete" href='<?php echo site_url("superadmin/delete/".$user['id']);?>'>Delete</a>
		    	</div>
           	<?php } }?>
        </legend>
    </div>
</div>