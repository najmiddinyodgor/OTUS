<?php
namespace App;
use BracketsChecker\Checker;

class Socket {
	private $host, $port;
	private $sock, $result, $conn;
	private $is_client;

	public function __construct(string $host,int $port, bool $is_client = false) {
		set_time_limit(0);
		$this->is_client = $is_client;

		$this->create();

		if(!$this->is_client) {
			$this->bind($host, $port);
		}
	}

	public function __destruct() {
		if(!$this->is_client && $this->conn) {
			socket_close($this->conn);
		}
		socket_close($this->sock);
	}

	/**
		Create socket
		@result bool
	*/

	private function create():void {
		$this->sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

		socket_set_nonblock($this->sock);
	}

	/**
		Bind socket
		@result bool
	*/

	private function bind($host, $port):void {
		$this->host = $host;
		$this->port = $port;
		$this->result = socket_bind($this->sock, $this->host, $this->port) or die("Could not bind to socket\n");
	}

	/**
		Listen socket
		@param int
		@result bool
	*/

	public function listen(int $connections = 1):bool {
		$this->result = socket_listen($this->sock, $connections) or die("Could not set up socket listener\n");
		return true;
	}

	/**
		Accepts new connections
		@result bool
	*/

	public function accept():bool {
		return $this->conn = socket_accept($this->sock);// or die("Could not accept incoming connection\n");
	}

	/**
		Connects to socket
		@result bool
	*/

	public function connect():bool {
		return socket_connect($this->sock, $this->host, $this->port);
	}

	/**
		Read message
		@result string
	*/

	public function read():string {
		$msg = socket_read($this->get_conn(), 1024);
		return $msg;
	}

	/**
		Write message
		@result bool
	*/

	public function write(string $msg):bool {
		socket_write($this->get_conn(), $msg, strlen($msg)) or die("Could not write output\n");
		return true;
	}

	/**
		Define connection for socket
		@result resource
	*/

	private function get_conn():resource {
		return $this->is_client?$this->sock:$this->conn;
	}
}