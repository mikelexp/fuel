<?

/**
 *
 * @name SWFObject Package para FuelPHP
 * @author bajocero.in
 * @copyright 2013-bajocero.in
 * @license private
 * @version 0.1
 * @example swf("/my/file.swf", "flash_banner", 200, 100, "div", "10", array("xmlurl" => "/my/file.xml"), array(), true)
 *
 * @param string $swf_file
 * @param string $element_id
 * @param int $width
 * @param int $height
 * @param string $element_tag
 * @param string $flash_version
 * @param array $flash_vars
 * @param array $flash_params
 * @param bool $transparent
 * @return string
 *
 */

namespace Mkswf;

use Fuel\Core\Asset;
use Fuel\Core\Uri;

class Mkswf {

	public static function swf($swf_file, $element_id, $width, $height, $element_tag = "div", $flash_version = "10", $flash_vars = array(), $flash_params = array(), $transparent = true) {

		$output = "";

		// elemento contenedor del flash
		$output .= "<{$element_tag} id=\"{$element_id}\"></{$element_tag}>\n";

		// inicio de script
		$output .= "<script type=\"text/javascript\">\n";

		// inicio de flash vars
		$output .= "\tvar {$element_id}_vars = {\n";

		// flash vars
		if (is_array($flash_vars) && count($flash_vars) > 0) {
			$vars = array();
			foreach ($flash_vars as $var => $value) {
				$vars[] = "\t\t{$var}: \"{$value}\"";
			}
			$output .= implode(",\n", $vars);
		}

		// fin de flash vars
		$output .= "\n\t};\n";

		// inicio de flash params
		$output .= "\tvar {$element_id}_params = {\n";

		// transparente?
		if ($transparent) {
			$flash_params['wmode'] = "transparent";
		} else {
			$flash_params['wmode'] = "opaque";
		}

		// flash params
		if (is_array($flash_params) && count($flash_params) > 0) {
			$params = array();
			foreach ($flash_params as $param => $value) {
				$params[] = "\t\t{$param}: \"{$value}\"";
			}
			$output .= implode(",\n", $params);
		}

		// fin de flash params
		$output .= "\n\t};\n";

		// express install swf
		$eis = Uri::create(Asset::find_file("expressInstall.swf", "js", "swfobject"));

		// swfobject
		$output .= "\tswfobject.embedSWF(\"{$swf_file}\", \"{$element_id}\", {$width}, {$height}, \"{$flash_version}\", \"{$eis}\", {$element_id}_vars, {$element_id}_params);\n";

		// fin de script
		$output .= "</script>\n";

		return($output);

	}

}
