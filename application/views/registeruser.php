<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <h1 class="text-center">Admin Signup</h1>
			</div>
			<div class="modal-body">
			<?php 
                $attributes = array('class' => 'cmxform', 'id' => 'registerform');
                echo form_open("user/register", $attributes); ?>
				<div class="form-group">
					<input class="form-control input-lg login_fields" type="email" name="email" placeholder="Email">
				</div>	
                <div class="form-group">
					<input class="form-control input-lg login_fields" id="new_password" type="password" name="new_password" placeholder="Password">
				</div>
                <div class="form-group">
					<input class="form-control input-lg login_fields" type="password" name="confirm_password" placeholder="Confirm Password">
				</div>
				<div class="form-group">
					<input type="submit" value='Signup' class="btn btn-primary btn-lg btn-block" />
				</div>
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>
	$(function() {
    // validate signup form on keyup and submit
		$("#registerform").validate({
			rules: {
				new_password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#new_password"
				},
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				new_password: {
					required: "Please provide a new password",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Please provide a new password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address"
			}
		}); 
 });
</script>