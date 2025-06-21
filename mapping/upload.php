<?php
$filename = $_FILES["upfile"]['name'];

echo move_uploaded_file(
  $_FILES["upfile"]["tmp_name"],
  "uploads/" . $filename
) ? $filename : "ERROR UPLOADING";

?>
