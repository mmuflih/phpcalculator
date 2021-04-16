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
	public $input;
	public $command;
	public $operation;
	public $result;

	/**
	 * @param mixed $command 
	 * @param mixed $operation 
	 * @param mixed $result 
	 * @param array $input 
	 * @return void 
	 */
	public function __construct($command, $operation, $result, $input)
	{
		$this->input = json_encode($input);
		$this->command = $command;
		$this->operation = $operation;
		$this->result = $result;
	}

	/** @return string  */
	public function toCsv()
	{
		return "id:$this->id;"
			. "command:$this->command;"
			. "operation:$this->operation;"
			. "result:$this->result;"
			. "input:$this->input";
	}

	/** @return int  */
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

	/** @return void  */
	public function print()
	{
		echo $this->operation . " = " . $this->result . PHP_EOL;
	}

	/**
	 * @param mixed $command 
	 * @param mixed $operation 
	 * @param mixed $result 
	 * @param array $input 
	 * @return CalculatorData 
	 */
	public static function createNew($command, $operation, $result, $input)
	{
		$data = new static($command, $operation, $result, $input);
		$data->id = $data->generateNewId();
		return $data;
	}

	/**
	 * @param mixed $str 
	 * @return stdClass|static|null 
	 */
	public static function fromCsv($str)
	{
		try {
			/** handling old data */
			if (strpos($str, ';')) {
				$cols = explode(";", $str);
			} else {
				$cols = explode(",", $str);
			}
			if (is_null($str)) {
				$data = new stdClass;
				$data->id = 1;
				return $data;
			}
			$input = [];
			if (isset($cols[4])) {
				$csv = str_replace(PHP_EOL, "", self::getValue($cols[4]));
				$input = json_decode($csv, true);
			}
			$data = new static(
				self::getValue($cols[1]),
				self::getValue($cols[2]),
				str_replace(PHP_EOL, "", self::getValue($cols[3])),
				$input,
			);
			$data->id = self::getValue($cols[0]);
			return $data;
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * @param mixed $str 
	 * @return string 
	 */
	private static function getValue($str)
	{
		$data = explode(":", $str);
		if (count($data) == 2) {
			return $data[1];
		}
		return "";
	}
}
