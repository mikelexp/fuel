<?php

namespace Mkutils;

use Fuel\Core\Uri;

class Mkutils {

	public static function parse_fecha($fecha, $separador = "/") {
		if (!is_int($fecha))
			$fecha = strtotime($fecha);
		$m = date('m', $fecha);
		$d = date('d', $fecha);
		$y = date('Y', $fecha);
		return("{$d}{$separador}{$m}{$separador}{$y}");
	}

	public static function parse_hora($fecha, $con_segundos = true, $separador = ":") {
		if (!is_int($fecha))
			$fecha = strtotime($fecha);
		$h = date('H', $fecha);
		$m = date('i', $fecha);
		$s = date('s', $fecha);
		if ($con_segundos)
			return("{$h}{$separador}{$m}{$separador}{$s}");
		else
			return("{$h}{$separador}{$m}");
	}

	public static function parse_fecha_humana($fecha) {
		if (!is_int($fecha))
			$fecha = strtotime($fecha);
		$dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
		$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$d = $dias[date("w", $fecha)];
		$n = date("j", $fecha);
		$m = $meses[date("m", $fecha) - 1];
		$a = date("Y", $fecha);
		return "{$d} {$n} de {$m} de {$a}";
	}

	public static function get_youtube_thumbnail($video_id = "", $index = 0) {
		return $video_id ? "https://img.youtube.com/vi/{$video_id}/{$index}.jpg" : "";
	}

	public static function get_youtube_player_url($video_id = "") {
		return $video_id ? "https://youtube.com/v/{$video_id}" : "";
	}

	public static function get_current_url($with_querystring = true) {
		$url = Uri::current();
		if ($with_querystring)
			$url .= "?".$_SERVER['QUERY_STRING'];
		return $url;
	}

}
