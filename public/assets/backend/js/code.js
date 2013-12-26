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

	// chosen
	$("select").chosen();

	// update me
	$(".update_me").bind("change", function(e) {
		var name = $(this).attr("name");
		$.ajax({
			url: "/backend/services/update",
			type: "post",
			dataType: "json",
			data: {
				data: name
			},
			success: function(res) {
				if (res.status != "ok") {
					e.preventDefault();
					alert(res.error);
				}
			},
			error: function() {
				alert("¡Error al actualizar!");
			}
		})
	});

	// scroll to top
	if ($(window).scrollTop() > 100)
		$("#scroll_to_top").fadeIn();
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$("#scroll_to_top").fadeIn();
		} else {
			$("#scroll_to_top").fadeOut();
		}
	});
	$("#scroll_to_top").click(function() {
		$("html, body").animate({
			scrollTop: 0
			},
			400
		);
	});

	// ajax loading
	$(document).ajaxStart(function() {
		$("#ajax").fadeIn();
	});
	$(document).ajaxStop(function() {
		$("#ajax").fadeOut();
	});

});
