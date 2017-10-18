<!DOCTYPE html>
<html>
<body>

<form action="uploadoop.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="1572864" />
    <input name="upload[]" type="file" multiple="multiple" accept="application/pdf" />
	<input type="submit" value="Upload pdf" name="submit">
</form>

</body>
</html>