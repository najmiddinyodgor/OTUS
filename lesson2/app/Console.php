<?php

namespace App;

use BracketsChecker\Checker;

class Console {
	private $options = [1 => "Ввести строку", "Ввести путь к файлу"];
	private $retryOptions = ['yes', 'no'];

	public function chooseOption() {
		echo "Выберите вариант: \n";
		$this->printArray($this->options);

		echo "Вариант: ";
		$input = intval($this->getInput());

		if(!array_key_exists($input, $this->options)) {
			echo "Неправильный ввод \n";
		}

		$this->switchOption($input);

		$this->retry();
	}

	private function switchOption($input) {
		switch ($input) {
			case 1:
				$this->strInput();
				break;
			case 2:
				$this->fileInput();
				break;
			default:
				break;
		}
	}

	private function fileInput() {
		echo "Путь: ";
		$input = $this->formatInput($this->getInput());
		if(file_exists($input)) {
			$stream = fopen($input, "r");
			echo (new Checker(fgets($stream)))->checkWithInfo()."\n";
			fclose($stream);
		} else {
			echo "Неверный путь \n";
		}
	}

	private function strInput() {
		echo (new Checker($this->getInput()))->checkWithInfo()."\n";	
	}

	private function printArray($arr) {
		foreach($arr as $key => $value) {
			echo $key.". ".$value."\n";
		}
	}

	private function getInput() {
		$stream = fopen("php://stdin", 'r');
		$input = trim(fgets($stream));
		fclose($stream);
		return $input;
	}

	private function formatInput(string $input):string {
		$input = str_replace("\\", "/", $input);
		$input = str_replace("\"", "", $input);
		return $input;
	}

	private function retry() {
		echo "Повторить попытку? \t [yes/no]";
		$input = $this->getInput();
		if(!in_array($input, $this->retryOptions)) {
			$this->retry();
		} else if($input === 'yes') {
			$this->chooseOption();
		} else {
			return 0;
		}

	}
}