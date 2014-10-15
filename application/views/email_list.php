<div class="main_content">
	<div class='content_settings' style='padding:3% 28%;'>
		<legend style='border:1px solid #c6c6c6;border-bottom:none;'>
           <h1>Emails Setup</h1>
           <?php if(!isset($email_list) || empty($email_list)) { ?>
           		<div class='red'>No Emails present</div>
           <?php }?>
           <?php if(isset($email_list)) {
           		foreach($email_list as $email) { ?>
    			<div class='email_tab'>
		    		<input type='text' value='<?php echo $email['email'];?>' id='' class='email' name='' />
		    		<button class="btn btn-danger right delete" data-type='email' data-id='<?php echo $email['id']?>' type="button">Delete</button>
		    		<button class="btn btn-success right edit" data-type='email' data-id='<?php echo $email['id']?>' type="button">Save</button>
	    		</div>
           	<?php } }?>
           	<div class='email_tab last-child'>
				<input type='text' placeholder='email@domain.com' class='email' id='add_email' name='' />
	    		<button class="btn btn-primary right edit" data-type='email' data-id='0' type="button">Add</button>
			</div>
	    </legend>
    </div>
</div>