<form method="post" action="<?= ROOT."/login/" ?>" role="form" class="login-form col-md-4 col-md-offset-4">
	<fieldset>
		<legend><h2>Login</h2></legend>

		<?php
			if (getMsg()) {
				echo getMsg();
			}
		?>

		<div class='form-group'>
			<label for='username'>Username</label>
			<input type='username'name='loginName' id='username' class='form-control'>
		</div>
		<div class='form-group'>
			<label for='password'>Password</label>
			<input type='password'name='loginPass' id='password' class='form-control'>
		</div>
		<div class='form-group'>
			<input type='submit' name='loginSubmit' id='Login' class='btn btn-primary' value='Login'>
		</div>
	</fieldset>
</form>