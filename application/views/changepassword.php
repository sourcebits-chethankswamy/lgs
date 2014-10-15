<div style='overflow:visible;' class="main_content">
    <div class='content_settings'> 
		<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					  <h1 class="text-center">Reset password</h1>
					</div>
					<div class="modal-body">
					<?php 
		                $attributes = array('class' => 'cmxform', 'id' => 'changepasswordform');
		                echo form_open("dashboard/dochangepassword", $attributes); ?>
						<div class="form-group">
							<input class="form-control input-lg login_fields" type="password" name="old_password" placeholder="Old password">
						</div>	
		                <div class="form-group">
							<input class="form-control input-lg login_fields" id="new_password" type="password" name="new_password" placeholder="New password">
						</div>
		                <div class="form-group">
							<input class="form-control input-lg login_fields" type="password" name="confirm_password" placeholder="Confirm password">
						</div>
						<div class="form-group">
							<input type="submit" value='Reset' class="btn btn-primary btn-lg btn-block" />
						</div>
					<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $(function() {
       // validate signup form on keyup and submit
		$("#changepasswordform").validate({
			rules: {
				old_password: "required",				 
				new_password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#new_password"
				}
			},
			messages: {
				old_password: "Please enter your current password",				 
				new_password: {
					required: "Please provide a new password",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Please provide a new password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				}
			}
		}); 
    });
</script>
