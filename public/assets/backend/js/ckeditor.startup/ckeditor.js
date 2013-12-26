var ckeditor_config = {
	width: 550,
	height: 400,
	language: 'es',
	forcePasteAsPlainText: true,
	resize_enabled: false,
	toolbar: [
		['Source'],
		['Cut', 'Copy', 'Paste'],
		['Undo', 'Redo'],
		['RemoveFormat'],
		['Bold', 'Italic'],
		['Link', 'Unlink'],
		['Image'],
		['Maximize']
	],			
	filebrowserBrowseUrl: '/assets/backend/js/ckfinder/ckfinder.html',
 	filebrowserImageBrowseUrl: '/assets/backend/js/ckfinder/ckfinder.html?type=Images',
 	filebrowserFlashBrowseUrl: '/assets/backend/js/ckfinder/ckfinder.html?type=Flash',
 	filebrowserUploadUrl: '/assets/backend/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 	filebrowserImageUploadUrl: '/assets/backend/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
 	filebrowserFlashUploadUrl: '/assets/backend/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
};
$(function() {
	$(".html").ckeditor(ckeditor_config, function() {
	});
});
