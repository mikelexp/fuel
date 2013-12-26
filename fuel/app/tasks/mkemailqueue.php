<?

namespace Fuel\Tasks;

use Fuel\Core\Cli;

class Mkemailqueue {

	public function send() {

		$send_amount = Cli::option("send_amount", null);

		$eq = \Mkemailqueue\Mkemailqueue::forge();
		$eq->send($send_amount);

	}

	public function purge() {

		$purge_days = Cli::option("purge_days", null);
		$purge_success = Cli::option("purge_success", null);
		$purge_error = Cli::option("purge_error", null);

		$eq = \Mkemailqueue\Mkemailqueue::forge();
		$eq->purge($purge_days, $purge_success, $purge_error);
		
	}

}
