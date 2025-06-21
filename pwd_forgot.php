<?php
// Start the session
  session_start();
  include 'db_connect.php';
  include 'lang_man.php';
  include_once 'header.php';
  ?>
	<form class="login-form" action="pwd_forgot.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<!-- form validation messages -->
		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
  <script type="text/javascript" src="js/formLabelAnimate.js"></script>
  <?php include_once 'footer.php'; ?>