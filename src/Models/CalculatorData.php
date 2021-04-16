<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-15 10:11:19
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Models;

use Illuminate\Support\Facades\File;
use stdClass;

class CalculatorData
{
	public $id;
	public $command;
	public $operation;
	public $result;

	public function __construct($command, $operation, $result)
	{
		$this->command = $command;
		$this->operation = $operation;
		$this->result = $result;
	}

	public function toCsv()
	{
		return "id:$this->id,"
			. "command:$this->command,"
			. "operation:$this->operation,"
			. "result:$this->result";
	}

	private function generateNewId()
	{
		try {
			$file = file(__DIR__ . "/../../storage/mesinhitung.log");
			if (!$file || count($file) == 0) {
				return 1;
			}
			$last = $file[count($file) - 1];
			$data = self::fromCsv($last);
			return (int) $data->id + 1;
		} catch (\Exception $e) {
			return 1;
		}
	}

	public function print()
	{
		echo $this->operation . " = " . $this->result . PHP_EOL;
	}

	public static function createNew($command, $operation, $result)
	{
		$data = new static($command, $operation, $result);
		$data->id = $data->generateNewId();
		return $data;
	}

	public static function fromCsv($str)
	{
		try {
			$cols = explode(",", $str);
			if (is_null($str)) {
				$data = new stdClass;
				$data->id = 1;
				return $data;
			}
			$data = new static(
				self::getValue($cols[1]),
				self::getValue($cols[2]),
				str_replace(PHP_EOL, "", self::getValue($cols[3]))
			);
			$data->id = self::getValue($cols[0]);
			return $data;
		} catch (\Exception $e) {
			return null;
		}
	}

	private static function getValue($str)
	{
		$data = explode(":", $str);
		if (count($data) == 2) {
			return $data[1];
		}
		return "";
	}
}
