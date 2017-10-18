<!DOCTYPE html>
<html>
<body>

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

<script>
    $(window).on('load', function() {
        $(function(){
            $("input[type='submit']").click(function(){
                var $fileUpload = $("input[type='file']");
                if (parseInt($fileUpload.get(0).files.length)>3){
                    alert("Er kunnen maar 3 bestanden worden geupload");
                }
            });
        });
    });
</script>

<form action="uploadoop.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="1572864" />
    <input name="upload[]" type="file" multiple="multiple" accept="application/pdf" />
    <input type="submit" value="Upload pdf" name="submit">
</form>

</body>
</html>