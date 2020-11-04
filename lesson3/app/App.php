<?php
namespace App;

use App\Socket;
use BracketsChecker\Checker;

class App {
	public function __construct(string $host, int $port) {
		$this->host = $host;
		$this->port = $port;
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