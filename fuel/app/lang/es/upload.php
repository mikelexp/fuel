<?php

return array(
	'error_'.\Upload::UPLOAD_ERR_OK						=> 'El archivo fue subido correctamente',
	'error_'.\Upload::UPLOAD_ERR_INI_SIZE				=> 'El archivo supera el tamaño máximo permitido en la configuración del servidor',
	'error_'.\Upload::UPLOAD_ERR_FORM_SIZE				=> 'El archivo supera el tamaño máximo permitido en el formulario',
	'error_'.\Upload::UPLOAD_ERR_PARTIAL				=> 'El archivo sólo fue subido parcialmente',
	'error_'.\Upload::UPLOAD_ERR_NO_FILE				=> 'No se subieron archivos',
	'error_'.\Upload::UPLOAD_ERR_NO_TMP_DIR				=> 'No se ha configurado ningún directorio temporal',
	'error_'.\Upload::UPLOAD_ERR_CANT_WRITE				=> 'No se pudo escribir el archivo subido al disco',
	'error_'.\Upload::UPLOAD_ERR_EXTENSION				=> 'La subida ha sido bloqueada por una extensión de PHP',
	'error_'.\Upload::UPLOAD_ERR_MAX_SIZE				=> 'El archivo supera el tamaño máximo permitido',
	'error_'.\Upload::UPLOAD_ERR_EXT_BLACKLISTED		=> 'La extensión del archivo subido no está permitida',
	'error_'.\Upload::UPLOAD_ERR_EXT_NOT_WHITELISTED	=> 'La extensión del archivo subido no está permitida',
	'error_'.\Upload::UPLOAD_ERR_TYPE_BLACKLISTED		=> 'El tipo de archivo subido no está permitido',
	'error_'.\Upload::UPLOAD_ERR_TYPE_NOT_WHITELISTED	=> 'El tipo de archivo subido no está permitido',
	'error_'.\Upload::UPLOAD_ERR_MIME_BLACKLISTED		=> 'El mimetype del archivo subido no está permitido',
	'error_'.\Upload::UPLOAD_ERR_MIME_NOT_WHITELISTED	=> 'El mimetype del archivo subido no está permitido',
	'error_'.\Upload::UPLOAD_ERR_MAX_FILENAME_LENGTH	=> 'El nombre del archivo excede el tamaño máximo permitido',
	'error_'.\Upload::UPLOAD_ERR_MOVE_FAILED			=> 'No se pudo mover el archivo subido al directorio destino',
	'error_'.\Upload::UPLOAD_ERR_DUPLICATE_FILE 		=> 'Ya existe un archivo con ese mismo nombre',
	'error_'.\Upload::UPLOAD_ERR_MKDIR_FAILED			=> 'No se pudo crear el directorio destino del archivo',
);
