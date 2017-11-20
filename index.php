

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<title>Image Upload</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="content">
	<!-- Upload image form-->
	<form method="POST" action="index.php" enctype="multipart/form-data">
		<input type="hidden" name="size" value="1000000">
		<div>
			<input type="file" name="image">
		</div>
		<div>
			<textarea id="text" cols="40" rows="4" name="image_text" placeholder="Say something about this image..."></textarea>
		</div>
		<div>
			<button type="submit" name="upload">POST</button>
		</div>
	</form>

<?php
	$db = mysqli_connect("localhost", "image_upload", "image_upload", "upload");
		if (!$db) {
			die("Connection failed: " . mysqli_connect_error());
		}

	if (isset($_POST['upload'])) {
		$target = "images/".basename($_FILES['image']['name']);
		$image = $_FILES['image']['name'];
		$image_text = mysqli_real_escape_string($db, $_POST['image_text']);


		$sql = "INSERT INTO images (image, image_text) VALUES ('$image', '$image_text')";
		mysqli_query($db, $sql);

		if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$msg = "Image uploaded successfully";
		}else{
			$msg = "Failed to upload image";
		}
	}

	$result = mysqli_query($db, "SELECT * FROM images");

?>
	<?php

	while ($row = mysqli_fetch_array($result)) {
		echo "<div id='img_div'>";
			echo "<img src='images/".$row['image']."' >";
			echo "<p>".$row['image_text']."</p>";
		echo "</div>";
	}
?>
</div>
</body>
</html>