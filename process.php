<?php

session_start();
$output;
$return_var;

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['videoFile'])) {
	$uploadDir = 'uploads/';
	$audioDir = 'audio_output/';

	if(!is_dir($uploadDir)) {
		mkdir($uploadDir, 0777, true);
	}

	if(!is_dir($audioDir)) {
		mkdir($audioDir, 0777, true);
	}

	$timestamp = date('Ymd_His');
	$videoPath = $uploadDir . basename($_FILES['videoFile']['name']);
	$audioFileName = pathinfo($_FILES['videoFile']['name'], PATHINFO_FILENAME) . '_' . $timestamp . '.mp3';
	$audioPath = $audioDir . $audioFileName;

	if(move_uploaded_file($_FILES['videoFile']['tmp_name'], $videoPath)) {
		$command = "ffmpeg -i " . escapeshellarg($videoPath) . " -vn -ar 44100 -ac 2 -b:a 192k -f mp3 " . escapeshellarg($audioPath);
		$output = [];
		$return_var = -1;
		exec($command . " 2>&1", $output, $return_var);

		if($return_var === 0){
			$_SESSION['audio_path'] = $audioPath;
			$_SESSION['audio_filename'] = $audioFileName;
			// echo "Konversi Berhasil! <a href='". htmlspecialchars($audioPath) ."'>Download Audio</a>";
			unlink($videoPath);
			header("Location: index.php");
			exit;
		} else {
			echo "Konversi Gagal.<br>";
			echo "Return code: " . $return_var . "<br>";
			echo "FFmpeg output: <pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";

			if(empty($output) && $return_var !== 0){
				echo "<br><b>Kemungkinan Masalah:</b><br>";
				echo "- FFmpeg tidak terinstal atau tidak ada dalam PATH sistem.<br>";
				echo "- Path ke FFmpeg tidak benar.<br>";
				echo "- PHP tidak memiliki izin untuk menjalankan shell commands.<br>";
			}
		}
	} else {
		echo "Gagal mengunggah file video";
	}
} else {
	echo "";
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Konversi</title>
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
		Pilih video untuk dikonversi:
		<input type="file" name="videoFile" id="videoFile" accept="video/*">
		<input type="submit" value="Konversi ke Audio" name="submit">
	</form>
</body>
</html>