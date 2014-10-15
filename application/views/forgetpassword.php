<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <h1 class="text-center">Forgot password</h1>
			</div>
			<div class="modal-body">
			<?php 
                $attributes = array('class' => 'cmxform', 'id' => 'forgotpasswordform');
                echo form_open("user/doforget", $attributes); ?>
				<div class="form-group">
					<input class="form-control input-lg login_fields" type="email" name="email" placeholder="Email">
				</div>				 
				<div class="form-group">
					<input type="submit" value='Reset' class="btn btn-primary btn-lg btn-block" />
				</div>
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>


<script>
    $(function() {
       // validate signup form on keyup and submit
		$("#forgotpasswordform").validate({
			rules: {
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				email: "Please enter a valid email address"
			}
		}); 
    });
</script>