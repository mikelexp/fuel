<?

namespace Mkemailqueue;

use Email\Email;
use Email\EmailSendingFailedException;
use Email\EmailValidationFailedException;
use Fuel\Core\Cli;
use Fuel\Core\Config;
use Fuel\Core\DB;
use Fuel\Core\Fuel;
use Fuel\Core\Package;

class Mkemailqueue {

	protected static $_send_amount;
	protected static $_auto_send;
	protected static $_purge_days;
	protected static $_purge_success;
	protected static $_purge_error;

	private $_from;
	private $_tos;
	private $_ccs;
	private $_bccs;
	private $_subject;
	private $_message_plain;
	private $_message_html;
	private $_attachs;
	private $_prioritario;
	private $_procesado;
	private $_fecha_procesado;
	private $_ok;
	private $_error_string;
	private $_extra_info;

	public static function _init() {

		Config::load("mkemailqueue", true, true, true);

		static::$_send_amount = Config::get("mkemailqueue.send_amount", 50);
		static::$_auto_send = Config::get("mkemailqueue.auto_send", false);
		static::$_purge_days = Config::get("mkemailqueue.purge_days", 30);
		static::$_purge_success = Config::get("mkemailqueue.purge_success", 1);
		static::$_purge_error = Config::get("mkemailqueue.purge_error", 1);

	}

	public static function forge() {

		$eq = new static;

		$eq->_from = array("email" => "", "name" => "");
		$eq->_tos = array();
		$eq->_ccs = array();
		$eq->_bccs = array();
		$eq->_attachs = array();
		$eq->_prioritario = false;
		$eq->_procesado = false;
		$eq->_ok = false;

		return $eq;

	}

	public function from($email = "", $name = "") {
		$this->_from = array(
			"email" => $email,
			"name" => $name
		);
		return $this;
	}

	public function to($email = "", $name = "") {
		$this->_tos[] = array(
			"email" => $email,
			"name" => $name
		);
		return $this;
	}

	public function cc($email, $name = null) {
		$this->_ccs[] = array(
			"email" => $email,
			"name" => $name
		);
		return $this;
	}

	public function bcc($email, $name = null) {
		$this->_bccs[] = array(
			"email" => $email,
			"name" => $name
		);
		return $this;
	}

	public function subject($subject) {
		$this->_subject = $subject;
		return $this;
	}

	public function message_plain($message_plain) {
		$this->_message_plain = $message_plain;
		return $this;
	}

	public function message_html($message_html) {
		$this->_message_html = $message_html;
		return $this;
	}

	public function attach($attach) {
		$this->_attachs[] = $attach;
		return $this;
	}

	public function prioritario($prioritario = true) {
		$this->_prioritario = $prioritario;
		return $this;
	}

	public function procesado($procesado = true) {
		$this->_procesado = $procesado;
		return $this;
	}

	public function ok($ok = true) {
		$this->_ok = $ok;
		return $this;
	}

	public function error_string($error_string) {
		$this->_error_string = $error_string;
		return $this;
	}

	public function extra_info($extra_info) {
		$this->_extra_info = $extra_info;
		return $this;
	}

	public function fecha_procesado($fecha_procesado) {
		$this->_fecha_procesado = $fecha_procesado;
		return $this;
	}

	public function save() {

		$eq = new Model_Mkemailqueue;

		// from
		$eq->from = serialize($this->_from);

		// tos
		if (is_array($this->_tos) && count($this->_tos))
			$eq->tos = serialize($this->_tos);

		// ccs
		if (is_array($this->_ccs) && count($this->_ccs))
			$eq->ccs = serialize($this->_ccs);

		// bccs
		if (is_array($this->_bccs) && count($this->_bccs))
			$eq->bccs = serialize($this->_bccs);

		// subject
		$eq->subject = $this->_subject;

		// message
		$eq->message_plain = $this->_message_plain;
		$eq->message_html = $this->_message_html;

		// attachs
		if (is_array($this->_attachs) && count($this->_attachs))
			$eq->attachs = serialize($this->_attachs);

		// fecha
		$eq->fecha_creacion = date("Y-m-d H:i:s");

		// flags
		$eq->prioritario = $this->_prioritario ? 1 : 0;
		$eq->procesado = $this->_procesado ? 1 : 0;
		$eq->fecha_procesado = $this->_fecha_procesado;
		$eq->ok = $this->_ok ? 1 : 0;

		// guardar
		$eq->save();

		// procesar auto send
		if (static::$_auto_send)
			self::send(static::$_send_amount);

	}

	public function send($send_amount = null) {

		$send_amount = $send_amount == null ? static::$_send_amount : $send_amount;

		if (Fuel::$is_cli)
			Cli::write("Maximo a enviar: {$send_amount}");

		$eqs = Model_Mkemailqueue::query()
				->where("procesado", "=", 0)
				->order_by("fecha_creacion")
				->limit($send_amount)
				->get();

		if (count($eqs) > 0) {

			if (Fuel::$is_cli)
				Cli::write("Emails a enviar en esta instancia: ".count($eqs));

			Package::load("email");

			foreach ($eqs as $eq) {

				$email = Email::forge();

				// from
				try {
					$from = unserialize($eq->from);
					if ($from['email'] && $from['name'])
						$email->from($from['email'], $from['name']);
					else if ($from['email'])
						$email->from($from['email']);
				} catch (\ErrorException $ex) {
					continue;
				}

				// to
				try {
					$tos = unserialize($eq->tos);
					if (is_array($tos)) {
						foreach ($tos as $to) {
							if ($to['email'] && $to['name'])
								$email->to($to['email'], $to['name']);
							else if ($to['email'])
								$email->to($to['email']);
						}
					}
				} catch (\ErrorException $ex) {
					continue;
				}

				// ccs
				try {
					$ccs = unserialize($eq->ccs);
					if (is_array($ccs)) {
						foreach ($ccs as $cc) {
							if ($cc['email'] && $cc['name'])
								$email->cc($cc['email'], $cc['name']);
							else if ($cc['email'])
								$email->cc($cc['email']);
						}
					}
				} catch (\ErrorException $ex) {
					continue;
				}

				// bccs
				try {
					$bccs = unserialize($eq->bccs);
					if (is_array($bccs)) {
						foreach ($bccs as $bcc) {
							if ($bcc['email'] && $bcc['name'])
								$email->bcc($bcc['email'], $bcc['name']);
							else if ($bcc['email'])
								$email->bcc($bcc['email']);
						}
					}
				} catch (\ErrorException $ex) {
					continue;
				}

				// subject
				$email->subject($eq->subject);

				// body
				if ($eq->message_html && $eq->message_plain) {
					$email->html_body($eq->message_html);
					$email->alt_body($eq->message_plain);
				} else if ($eq->message_html) {
					$email->html_body($eq->message_html);
				} else if ($eq->message_plain) {
					$email->body($eq->message_plain);
				}

				// attachs
				try {
					$attachs = unserialize($eq->attachs);
					if (is_array($attachs)) {
						foreach ($attachs as $attach) {
							$email->attach($attach);
						}
					}
				} catch (\ErrorException $ex) {
					continue;
				}

				// prioritario
				if ($eq->prioritario)
					$email->priority(Email::P_HIGH);

				// send
				$eq->procesado = true;
				$eq->fecha_procesado = date("Y-m-d H:i:s");
				try {
					$email->send();
					$eq->ok = true;
				} catch (EmailValidationFailedException $ex) {
					$eq->ok = false;
					$eq->extra_info = "EmailValidationFailedException";
					$eq->error_string = $ex->getMessage();
				} catch (EmailSendingFailedException $ex) {
					$eq->ok = false;
					$eq->extra_info = "EmailSendingFailedException";
					$eq->error_string = $ex->getMessage();
				}
				$eq->save();

			}

			if (Fuel::$is_cli)
				Cli::write("Ok!");

		} else {

			if (Fuel::$is_cli)
				Cli::write("No hay emails pendientes para enviar");

		}
		
	}

	public function purge($purge_days = null, $purge_success = null, $purge_error = null) {

		$purge_days = $purge_days == null ? static::$_purge_days : $purge_days;
		$purge_success = $purge_success == null ? static::$_purge_success : $purge_success;
		$purge_error = $purge_error == null ? static::$_purge_error : $purge_error;

		if (Fuel::$is_cli) {
			Cli::write("Purgando emails anteriores a: ".$purge_days." dias");
			Cli::write("Purgar mails enviados correctamente: ".($purge_success == 1 ? "Si" : "No"));
			Cli::write("Purgar mails con error de envio: ".($purge_error == 1 ? "Si" : "No"));
		}

		$query = "DELETE FROM email_queue";
		$query .= " WHERE fecha_creacion <= DATE_SUB(NOW(), INTERVAL {$purge_days} DAY)";
		$query .= " AND procesado = 1";

		if ($purge_success == 1 && $purge_error == 0)
			$query .= " AND ok = 1";

		if ($purge_success == 0 && $purge_error == 1)
			$query .= " AND ok = 0";

		DB::query($query)->execute();

		if (Fuel::$is_cli)
			Cli::write("Ok!");

	}

}
