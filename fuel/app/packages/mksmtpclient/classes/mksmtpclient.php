<?

namespace Mksmtpclient;

use Fuel\Core\Config;
use Fuel\Core\FuelException;
use Log;

class Mksmtpclient {

	private static $instance = null;

	private $host;
	private $user;
	private $password;
	private $port;
	private $from;
	private $timeout;

	private $tos;
	private $ccs;
	private $bccs;
	private $subject;
	private $message;
	private $headers;

	private $socket = null;

	public static function _init() {
		Config::load("mksmtpclient", true, true, true);
		$instance = static::instance();
		$instance->host = Config::get("mksmtpclient.host", "localhost");
		$instance->user = Config::get("mksmtpclient.user");
		$instance->password = Config::get("mksmtpclient.password");
		$instance->port = Config::get("mksmtpclient.port", 25);
		$instance->timeout = Config::get("mksmtpclient.timeout", 15);
		$instance->from = Config::get("mksmtpclient.from");
		$instance->tos = array();
		$instance->ccs = array();
		$instance->bccs = array();
		$instance->subject = "";
		$instance->message = "";
		$instance->headers = array();
		$instance->socket = null;
	}

	/**
	 * @return Mksmtpclient
	 */
	public static function forge() {
		return new Mksmtpclient;
	}

	/**
	 * @return Mksmtpclient
	 */
	public static function instance() {
		if (static::$instance === null)
			static::$instance = static::forge();
		return static::$instance;
	}

	/**
	 * @param string $host
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function host($host = null) {
		if (!$host)
			throw new MksmtpclientException("El parámetro host es obligatorio");
		static::instance()->host = $host;
		return static::instance();
	}

	/**
	 * @param int $port
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function port($port = 25) {
		if (!$port)
			throw new MksmtpclientException("El parámetro port es obligatorio");
		if (!is_int($port))
			throw new MksmtpclientException("El parámetro port debe ser entero");
		static::instance()->port = $port;
		return static::instance();
	}

	/**
	 * @param string $user
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function user($user = null) {
		if (!$user)
			throw new MksmtpclientException("El parámetro user es obligatorio");
		static::instance()->user = $user;
		return static::instance();
	}

	/**
	 * @param string $password
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function password($password = null) {
		if (!$password)
			throw new MksmtpclientException("El parámetro password es obligatorio");
		static::instance()->password = $password;
		return static::instance();
	}

	/**
	 * @param string $from_email
	 * @param string $from_name
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function from($from_email = null, $from_name = null) {
		if (!$from_email)
			throw new MksmtpclientException("El parámetro from_email es obligatorio");
		static::instance()->from = array(
			$from_email => $from_name
		);
		return static::instance();
	}

	/**
	 * @param int $timeout
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function timeout($timeout = 15) {
		if (!$timeout)
			throw new MksmtpclientException("El valor de timeout es obligatorio");
		if (!is_int($timeout))
			throw new MksmtpclientException("El valor de timeout debe ser entero");
		static::instance()->timeout = $timeout;
		return static::instance();
	}

	/**
	 * @param string $to_email
	 * @param string $to_name
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function to($to_email = null, $to_name = null) {
		if (!$to_email)
			throw new MksmtpclientException("El parámetro to_email es obligatorio");
		$instance = static::instance();
		$instance->tos[$to_email] = $to_name;
		return static::instance();
	}

	/**
	 * @param string $cc_email
	 * @param string $cc_name
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function cc($cc_email = null, $cc_name = null) {
		if (!$cc_email)
			throw new MksmtpclientException("El parámetro cc_email es obligatorio");
		$instance = static::instance();
		$instance->ccs[$cc_email] = $cc_name;
		return static::instance();
	}

	/**
	 * @param string $bcc_email
	 * @param string $bcc_name
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function bcc($bcc_email = null, $bcc_name = null) {
		if (!$bcc_email)
			throw new MksmtpclientException("El parámetro bcc_email es obligatorio");
		$instance = static::instance();
		$instance->bccs[$bcc_email] = $bcc_name;
		return static::instance();
	}

	/**
	 * @param string $subject
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function subject($subject = null) {
		if (!$subject)
			throw new MksmtpclientException("El parámetro subject es obligatorio");
		static::instance()->subject = $subject;
		return static::instance();
	}

	/**
	 * @param string $message
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function message($message = null) {
		if (!$message)
			throw new MksmtpclientException("El parámetro message es obligatorio");
		static::instance()->message = $message;
		return static::instance();
	}

	/**
	 * @param null $header_var
	 * @param null $header_value
	 * @return Mksmtpclient
	 * @throws MksmtpclientException
	 */
	public static function header($header_var = null, $header_value = null) {
		if (!$header_var || !$header_value)
			throw new MksmtpclientException("Los parámetros header_var y header_value son obligatorios");
		static::instance()->headers[$header_var] = $header_value;
		return static::instance();
	}

	/**
	 * @return bool
	 * @throws MksmtpclientException
	 */
	public static function send() {

		$instance = static::instance();

		// inicio
		if (!$instance->start())
			throw new MksmtpclientException("No pudo iniciarse la conexión con el servidor SMTP");

		// handshake
		if (!$instance->write("EHLO ".$instance->host, true, 1, "250"))
			throw new MksmtpclientException("Error al escribir EHLO al servidor SMTP");

		// login
		if (!$instance->write("AUTH LOGIN", true, 1, "334"))
			throw new MksmtpclientException("Error al escribir AUTH LOGIN al servidor SMTP");
		if (!$instance->write(base64_encode($instance->user), true, 1, "334"))
			throw new MksmtpclientException("Error al escribir usuario al servidor SMTP");
		if (!$instance->write(base64_encode($instance->password), true, 1, "235"))
			throw new MksmtpclientException("Error al escribir password al servidor SMTP");

		// from email
		if (count($instance->from) == 0)
			throw new MksmtpclientException("No se especificó el FROM del email");
		$keys = array_keys($instance->from);
		$from_email = $keys[0];
		if (!$instance->write("MAIL FROM: <{$from_email}>", true, 1, "250"))
			throw new MksmtpclientException("Error al escribir MAIL FROM al servidor SMTP");

		// to
		if (count($instance->tos) == 0)
			throw new MksmtpclientException("No se especificó por lo menos un TO para el email");
		$keys = array_keys($instance->tos);
		$to_email = $keys[0];
		if (!$instance->write("RCPT TO: <{$to_email}>", true, 1, "250"))
			throw new MksmtpclientException("Error al escribir RCPT TO <{$to_email}> al servidor SMTP");

		// inicio de mensaje
		if (!$instance->write("DATA", true, 1, "354"))
			throw new MksmtpclientException("Error al escribir DATA al servidor SMTP");

		// from
		$from_name = $instance->from[$from_email];
		if ($from_name)
			$instance->header("From", "{$from_name} <{$from_email}>");

		// tos
		$header_tos = array();
		foreach ($instance->tos as $to_email => $to_name) {
			if ($to_name)
				$header_tos[] = "{$to_name} <{$to_email}>";
			else
				$header_tos[] = "<{$to_email}>";
		}
		if (!$instance->write("To: ".implode(", ", $header_tos)))
			throw new MksmtpclientException("Error al escribir header to al servidor SMTP");

		// ccs
		$header_ccs = array();
		foreach ($instance->ccs as $cc_email => $cc_name) {
			if ($cc_name)
				$header_ccs[] = "{$cc_name} <{$cc_email}>";
			else
				$header_ccs[] = "<{$cc_email}>";
		}
		if (!$instance->write("Cc: ".implode(", ", $header_ccs)))
			throw new MksmtpclientException("Error al escribir header cc al servidor SMTP");

		// bccs
		$header_bccs = array();
		foreach ($instance->bccs as $bcc_email => $bcc_name) {
			if ($bcc_name)
				$header_bccs[] = "{$bcc_name} <{$bcc_email}>";
			else
				$header_bccs[] = "<{$bcc_email}>";
		}
		if (!$instance->write("Bcc: ".implode(", ", $header_bccs)))
			throw new MksmtpclientException("Error al escribir header bcc al servidor SMTP");

		// subject
		if (!$instance->write("Subject: ".$instance->subject))
			throw new MksmtpclientException("Error al escribir header subject al servidor SMTP");

		// headers
		foreach ($instance->headers as $header_var => $header_value) {
			if (!$instance->write("{$header_var}: {$header_value}"))
				throw new MksmtpclientException("Error al escribir header {$header_var}: {$header_value} al servidor SMTP");
		}

		// body
		if (!$instance->write($instance->message))
			throw new MksmtpclientException("Error al escribir cuerpo del mensaje al servidor SMTP");

		// fin de data
		if (!$instance->write(".", true, 1, "250"))
			throw new MksmtpclientException("Error al escribir fin de mensaje al servidor SMTP");

		// quit
		if (!$instance->write("QUIT"))
			throw new MksmtpclientException("Error al escribir QUIT al servidor SMTP");

		// end
		if (!$instance->end())
			throw new MksmtpclientException("Error al cerrar conexión con el servidor SMTP");

		// si llegamos hasta aca es porque no salio nada mal
		return true;

	}

	/**
	 * @param int $respuesta_esperada
	 * @return bool
	 */
	private static function chequear_respuesta($respuesta_esperada) {
		$instance = static::instance();
		if ($instance->socket) {
			Log::debug("SMTP_MAILER: Esperando respuesta {$respuesta_esperada}");
			$respuesta = "";
			while (substr($respuesta, 3, 1) != " ") {
				if (!($respuesta = fgets($instance->socket, 256))) {
					Log::error("SMTP_MAILER: Error al recibir el código de respuesta del servidor");
					return false;
				}
			}
			if (!(substr($respuesta, 0, 3) == $respuesta_esperada)) {
				Log::error("SMTP_MAILER: La respuesta recibida no es la esperada - esperada={$respuesta_esperada} recibida={$respuesta}");
				return false;
			}
			Log::debug("SMTP_MAILER: Respuesta {$respuesta_esperada} recibida correctamente");
			return true;
		} else {
			Log::error("SMTP_MAILER: No se pudo chequear la respuesta porque el socket no esta abierto");
			return false;
		}
	}

	/**
	 * @return bool
	 */
	private static function start() {
		$instance = static::instance();
		Log::debug("SMTP_MAILER: Abriendo socket - {$instance->host}:{$instance->port} timeout={$instance->timeout}");
		$instance->socket = @fsockopen($instance->host, $instance->port, $errno, $errstr, $instance->timeout);
		if (!$instance->socket) {
			Log::error("SMTP_MAILER: No se pudo abrir el socket - {$instance->host}:{$instance->port} timeout={$instance->timeout} errno={$errno} errstr={$errstr}");
			return false;
		} else {
			Log::info("SMTP_MAILER: Socket abierto correctamente");
			return $instance->chequear_respuesta("220");
		}
	}

	/**
	 * @param string $string
	 * @param bool $crlf
	 * @param int $crlf_count
	 * @param int $respuesta_esperada
	 * @return bool
	 */
	private static function write($string = null, $crlf = true, $crlf_count = 1, $respuesta_esperada = null) {
		$instance = static::instance();
		if ($instance->socket) {
			if ($string != null) {
				Log::debug("SMTP_MAILER: Escribiendo '{$string}'");
				$write = @fwrite($instance->socket, $string);
				if (!$write) {
					Log::error("SMTP_MAILER: Error al escribir en el socket");
					return false;
				}
			} else {
				Log::warning("SMTP_MAILER: Se pidio escribir un string vacio al socket");
			}
			if ($crlf)
				$instance->crlf($crlf_count);
			if ($respuesta_esperada) {
				$respuesta = $instance->chequear_respuesta($respuesta_esperada);
				if (!$respuesta)
					return false;
			}
			return true;
		} else {
			Log::error("SMTP_MAILER: Error al escribir, el socket no esta abierto");
			return false;
		}
	}

	/**
	 * @param int $return_count
	 * @return bool
	 */
	private static function crlf($return_count = 1) {
		$instance = static::instance();
		if ($instance->socket) {
			for ($c = 1; $c <= $return_count; $c++) {
				Log::debug("SMTP_MAILER: Enviando carriage return numero {$c}");
				fwrite($instance->socket, "\r\n");
			}
			return true;
		} else {
			Log::error("SMTP_MAILER: Error al enviar carriage returns, el socket no esta abierto");
			return false;
		}
	}

	/**
	 * @return bool
	 */
	private static function end() {
		$instance = static::instance();
		if ($instance->socket) {
			Log::debug("SMTP_MAILER: Cerrando socket");
			if (@fclose($instance->socket)) {
				Log::debug("SMTP_MAILER: Socket cerrado correctamente");
				return true;
			} else {
				Log::error("SMTP_MAILER: Error al cerrar el socket");
				return false;
			}
		} else {
			Log::error("SMTP_MAILER: No se pudo cerrar el socket porque no estaba abierto");
			return false;
		}
	}

}

class MksmtpclientException extends FuelException {

}
