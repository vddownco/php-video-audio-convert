<?php

session_start();
$downloadLink = '';
$mesage = '';

if(isset($_SESSION['audio_path']) && isset($_SESSION['audio_filename'])) {
	if(file_exists($_SESSION['audio_path'])) {
		$downloadLink = "<a href='". htmlspecialchars($_SESSION['audio_path']) ."' download='". htmlspecialchars($_SESSION['audio_filename']) ."'>". htmlspecialchars($_SESSION['audio_filename']) ."</a>";
	} else {
		$mesage = "Konversi berhasil, tetapi file audio tidak ditemukan";
	}

	unset($_SESSION['audio_path']);
	unset($_SESSION['audio_filename']);
} else {
	echo "";
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h1>Konversi Video ke Audio</h1>
	<a href="process.php">Mulai konversi</a><br><br>

	<?php if (!empty($downloadLink)): ?>
		<p>Download Audio: <?php echo $downloadLink; ?></p>
	<?php endif; ?>
</body>
</html>