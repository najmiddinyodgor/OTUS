<?php
namespace App;

use App\Socket;
use BracketsChecker\Checker;

class App {
	public function __construct(string $host, int &$port = null) {
		$this->host = $host;
		$this->port = $port ?? $this->getPort();
	}

	private function getPort() {
		echo "Enter number of TCP port for listening: ";

		$stream = fopen("php://stdin", 'r');
		$input = trim(fgets($stream));
		if(!is_numeric($input)) {
			$this->getPort();
		}
		fclose($stream);
		return $input;
	}

	public function start() {
		$socket = new Socket($this->host, $this->port);
		$socket->listen();
		do {
			$socket->accept();
			if($socket->accept()) {
				$socket->write(
				( new Checker($socket->read()))
				->checkWithInfo()
			);
			}
		} while(true);
	}
}