<?php
require_once('../includes/config.php');

if (!isset($_POST['create-account'])) {
	gtfo();
}

$username = ucwords(strip_chars($_POST['username']));
if (empty($username)) {
	$_SESSION['error'] = 'Invalid username';
	gtfo(REFERER);
}

if (empty($_POST['password']) || strlen($_POST['password']) < 4) {
	$_SESSION['error'] = 'Invalid password';
	gtfo(REFERER);
}

if (empty($_FILES['image'])) {
	$_SESSION['error'] = 'Please upload an image too';
	gtfo(REFERER);
}

if (empty($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['anti_spam']) {
	$_SESSION['error'] = 'Incorrect CAPTCHA';
	gtfo(REFERER);
}

// ******************************************
// Check if account exists
// ******************************************
$query = "SELECT account_id
					FROM accounts
					WHERE username = :username";
$bind = array(
	'username' => $username,
);
$sql->query($query, $bind);

if($sql->row_count() > 0) {
	$_SESSION['error'] = 'That username already exits. Change your name ;)';
	gtfo(REFERER);
}
// ******************************************
// END Check if account exists
// ******************************************

// validate image
if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
	$_SESSION['error'] = 'Error uploading the profile image. Get help?';
	gtfo(REFERER);
}

// check size
if ($_FILES['image']['size'] > 1048576) {
	$_SESSION['error'] = '1MB image size limit, sorry';
	gtfo(REFERER);
}

if (!$ext = exif_imagetype($_FILES['image']['tmp_name'])) {
	$_SESSION['error'] = 'Please only upload images';
	gtfo(REFERER);
}

switch ($ext) {
	case 1:
		$ext = '.gif';
		break;
	case 2:
		$ext = '.jpeg';
		break;
	case 3:
		$ext = '.png';
		break;
	default:
		$_SESSION['error'] = 'Only JPG, PNG and GIF images are accepted';
		gtfo(REFERER);
		break;
}

// check if image contains magic string???
$ten_bytes = file_get_contents($_FILES['image']['tmp_name'], false, null, ($_FILES['image']['size'] - 10));
$admin = strpos($ten_bytes, 'admin') !== false ? 1 : 0;

// give image a filename
$filename = $username . '-' . mt_rand(100,999) . $ext;
// originals - we delete this after operations
$original_filname = sha1(rand_string(16)) . $ext;
$original_location = IMAGE_UPLOAD . '9cf42ac23dabe8befa3d875710a92903bb9babf6/'; // this is kinda shit. we should upload outside doc_root

if (!$admin && move_uploaded_file($_FILES['image']['tmp_name'], $original_location . $original_filname)) {
	$thumb = new phpThumb();
	$thumb->resetObject();

	$thumb->setParameter('w', '250');
	$thumb->setParameter('h', '250');
	$thumb->setParameter('q', '60');
	$thumb->setParameter('config_output_format', $ext);
	$thumb->setSourceFilename($original_location . $original_filname);

	if ($thumb->GenerateThumbnail()) {
		$thumb->RenderToFile(IMAGE_UPLOAD . $filename);
	} else {
		$_SESSION['error'] = 'Error generating image thumbnail. Get help';
		gtfo(REFERER);
	}
} elseif ($admin && move_uploaded_file($_FILES['image']['tmp_name'], IMAGE_UPLOAD . $filename)) {
	// integrity check to stop someone uploading an existing admins picture.
	$query = "SELECT profile_image
						FROM accounts
						WHERE admin = 1";
	$sql->query($query);

	while ($row = $sql->fetch()) {
		// sha1 compare the new admin image with existing admins
		if (sha1(file_get_contents(IMAGE_UPLOAD . $filename)) == sha1(file_get_contents(IMAGE_UPLOAD . $row['profile_image']))) {
			$_SESSION['error'] = 'You cannot upload an existing admin\'s profile picture.';
			gtfo(REFERER);
		}
	}
} else {
	$_SESSION['error'] = 'Error moving uploaded file. Get help.';
	gtfo(REFERER);
}

// delete the original
unlink($original_location . $original_filname);

// password management
$salt = rand_string(6);
$hashed_password = new_hash($_POST['password'], $salt);
// encryption key generation
$enc_key = crypto_random(32);

$insert_data = array(
	'username' => $username,
	'password' => $hashed_password,
	'salt' => $salt,
	'admin' => $admin,
	'profile_image' => $filename,
	'ip_addr' => $_SERVER['REMOTE_ADDR'],
	'enc_key' => $enc_key,
);
$sql->insert($insert_data, 'accounts');

$_SESSION['success'] = 'Account created. You can login now.';
gtfo('../login');
