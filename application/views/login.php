<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <h1 class="text-center">LGS Login</h1>
			</div>
			<div class="modal-body">
			<?php echo form_open("user/login"); ?>
				<div class="form-group">
					<input class="form-control input-lg login_fields" type="text" name="email" placeholder="Email">
				</div>
				<div class="form-group">
					<input class="form-control input-lg login_fields" type="password" name="password" placeholder="Password">
				</div>
				<?php if(isset($error) && !empty($error)) {?>
					<div class="form-group">
						<div class='red margin-bottom-12'><?php echo $error;?></div>
					</div>
				<?php } ?>
				<div class="form-group">
					<input type="submit" value='Sign In' class="btn btn-primary btn-lg btn-block" />
					<!--  <span class="pull-right margin-top-12"><a href="http://www.globaltenders.com/" target="_blank">Need help?</a></span> -->
				</div>
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>