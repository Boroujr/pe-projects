<?php


$passwordLocker = [
	"username" => "password",
];



$username = '';
$password = '';






$class = "hide";
// ;





if (
	isset($_POST['submitted'])  &&
	(isset($_POST['username'])) &&
	(isset($_POST['password'])) &&
	($_POST['username'] != '')  &&
	($_POST['password'] != '')
) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	if ((isset($passwordLocker[$username])) && ($passwordLocker[$username] == $password)) {
		$output = "Welcome to the cave, <span>$username</span>";
	} else {
		$output = "I don't know <span>you<span>";
	}
	$class = "output-field";
}











?>


<form id="e4p" autocomplete='off' method="POST">

	<div class="input-field">
		<input id="username-ID" type="text" class="text-number-input" required name="username" placeholder="username??" value="<?= $username ?>">
		<label class="firm-voice" for="username-ID">Username</label>
	</div>
	<div class="input-field">
		<input required class="text-number-input" id="password-ID" type="password" name="password" placeholder="password?!" value="<?= $password ?>">
		<label class="firm-voice" for="password-ID">password</label>
	</div>


	<button type="submit" class="button" name="submitted">
		Validate
	</button>


	<output class="<?= $class ?>">
		<p><?= $output ?></p>
	</output>

</form>