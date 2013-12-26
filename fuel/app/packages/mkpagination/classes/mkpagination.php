<?

namespace Mkpagination;

use Fuel\Core\View;
use Orm\Query;

class Mkpagination {

	public static function get(Query &$query, $pagina, $por_pagina = 10, $rango = 5, $url = null) {

		// calculos
		$total = $query->count();
		$paginas = ceil($total / $por_pagina);
		$offset = $por_pagina * ($pagina - 1);

		if ($paginas > 1 && $url) {

			// generar paginador
			$data['paginas'] = $paginas;
			$data['pagina'] = $pagina;
			$data['hay_anterior'] = $pagina > 1;
			$data['anterior'] = $pagina - 1;
			$data['hay_siguiente'] = $pagina < $paginas;
			$data['siguiente'] = $pagina + 1;
			$data['url'] = $url;
			$data['paginas_a_mostrar'] = self::trim_page_numbers($pagina, $paginas, $rango);
			$html = View::forge("mkpagination", $data);

		} else {

			// solo hay una pagina, no generar
			$html = "";

		}

		// inserto el offset y el limit en el puntero del query
		$query->offset($offset);
		$query->limit($por_pagina);

		// fin
		return $html;

	}

	private static function trim_page_numbers($actual, $ultima, $rango) {

		if ($ultima > $rango) {

			if (!($rango % 2)) $rango++;

			$side1 = floor($rango / 2);
			$side2 = $side1;

			while ( ($actual - $side1) < 1 ) {
				$side1--;
				$side2++;
			}

			while ( ($actual + $side2) > $ultima ) {
				$side1++;
				$side2--;
			}

			$from = $actual - $side1;
			$to = $actual + $side2;

			return(range($from, $to));

		} else {

			return(range(1, $ultima));

		}

	}

}
