$(function() {

	// tooltips
	$(".tooltip_me").tooltip();

	// datepicker
	$(".datepick_me").datepicker({
		format: "dd/mm/yyyy",
		autoclose: true,
		todayBtn: "linked",
		todayHighlight: true,
		language: "es"
	});
	$(".datepick_trigger").click(function(e) {
		e.preventDefault();
		var datepicker = $(this).data("datepicker");
		$("input[name='" + datepicker + "']").datepicker("show");
	});

	// autosize
	$(".autosize_me").autosize();

	// autofocus
	$(".autofocus_me").focus();

	// lazy load
	$("img.lazy_load_me").lazyload();

	// default value
	$("[placeholder]").defaultValue();

	// autopost
	$(".autopost").bind("change", function() {
		$(this).closest("form").submit();
	});

	// info me
	$(".info_me").click(function(e) {
		e.preventDefault();
		var titulo = $(this).data("titulo");
		var texto = $(this).data("texto");
		$("#modal_info_label").text(titulo);
		$("#modal_info_body").text(texto);
		$("#modal_info").modal();
	});

	// confirm me
	$(".confirm_me").click(function(e) {
		e.preventDefault();
		var titulo = $(this).data("titulo");
		var texto = $(this).data("texto");
		var href = $(this).attr("href");
		$("#modal_confirm_label").text(titulo);
		$("#modal_confirm_body").text(texto);
		$("#modal_confirm_ok").attr("href", href);
		$("#modal_confirm").modal();
	});

	// colorbox
	$(".colorbox").colorbox({
		iframe: false,
		innerWidth: 800,
		innerHeight: 400
	});

});
