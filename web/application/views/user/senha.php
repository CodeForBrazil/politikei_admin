<?php $this->load->view('header'); ?>    

    <div class="container" role="main">

		<div class="row">
			<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 table-responsive" id="disabled_objects">
				
				<form method="post" class="form-horizontal" role="form">
					<div class="form-group">
						<label class="control-label col-sm-4" for="password"><?php echo lang('app_password'); ?></label>
						<div class="controls col-sm-8">
							<input id="user-password" name="password" type="password" class="input-xlarge form-control"
								value="<?php echo set_value('password', ''); ?>" maxlength="15"/>
							 <div class="alert-danger"><?php echo form_error('password'); ?></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="password_confirm"><?php echo lang('app_confirm_password'); ?></label>
						<div class="controls col-sm-8">
							<input id="user-password_confirm" name="password_confirm" type="password" class="input-xlarge form-control"
								value="<?php echo set_value('password_confirm', ''); ?>" maxlength="15"/>
							 <div class="alert-danger"><?php echo form_error('password_confirm'); ?></div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="controls col-sm-8 col-sm-offset-4">
							<button type="submit" class="btn btn-danger"><?php echo lang('app_save'); ?></button>
							<a href="<?php echo site_url('/proposicoes'); ?>" class="btn btn-default">
								Voltar
							</a>
						</div>
					</div>
				</form>				
				
			</div>
		</div>
    </div>

<?php $data['extra_js'][] = base_url("/assets/js/user.js"); ?>

<?php $this->load->view('footer.php',$data);
