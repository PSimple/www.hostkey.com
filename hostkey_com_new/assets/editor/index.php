<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">


	
		<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>

	
	</head>
	
	
	<body>

	<form>
	<textarea id="editor1"></textarea>
	</form>
	<script>
	 CKEDITOR.replace( 'editor1',
{
	filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
	filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
	filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
	language: 'ru'
});
</script>
	</body>
	</html>