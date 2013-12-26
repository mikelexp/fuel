/**
 *
 * mk_select_updater 0.2
 * @licence private
 *
 * Ejemplo de uso
 * $("#pais").mk_select_updater({opciones});
 *
 * Opciones:
 * target_id: el ID del select a actualizar (obligatorio)
 * url: la URL que devuelve un json con objetos con dos valores: value y text (obligatorio)
 * type: usar GET o POST para llamar la URL (default: POST)
 * async: llamado sincronico o asincronico (default: true)
 * data: se puede pasar un object { } de datos a pasar por POST a la URL (default: { })
 * param_name: nombre del parametro a pasar por POST a la URL (solo hace falta si no se uso el parametro data)
 * add_first_option: agregar una opcion vacia al select target (default: true)
 * first_option_label: label para la opcion vacia del select target (default: '')
 * trigger_target_change: ejecutar autometicamente el evento change en el target select (default: true)
 * callback: funcion a ejecutar al final de la actualizacion del select (opcional)
 * 
 */

(function( $ ) {

	$.fn.mk_select_updater = function(options) {

		var settings = {
			target_id: "",
			url: "",
			type: "POST",
			async: true,
			data: {},
			param_name: "",
			add_first_option: true,
			first_option_label: "",
			trigger_target_change: true,
			callback: false
		};

		return this.each(function() {
			if (options) {
				$.extend(settings, options);
			}
			$(this).change(function() {
				$("#" + settings.target_id).html("");
				if (settings.param_name != "") {
					settings.data[settings.param_name] = $(this).val();
				}
				$.ajax({
					url: settings.url,
					type: settings.type,
					async: settings.async,
					dataType: "json",
					data: settings.data,
					success: function(items) {
						if (settings.add_first_option) {
							$("#" + settings.target_id).append($("<option />").val("").html(settings.first_option_label));
						}
						$.each(items, function(id, item) {
							$("#" + settings.target_id).append($("<option />").val(item.value).html(item.text));
						});
						if (settings.trigger_target_change) {
							$("#" + settings.target_id).trigger("change");
						}
					},
					complete: settings.callback
				});
			});
		});

	};

})( jQuery );
