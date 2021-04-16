<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 06:08:14
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriverInterface;
use Jakmall\Recruitment\Calculator\Handler\HistoryHandler;
use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class HistoryListCommand extends Command
{
	protected $signature = "history:list {id?} {--driver=}";

	protected $description = "";

	private $driver;

	public function __construct(HistoryDriverInterface $driver)
	{
		$this->driver = $driver;
		parent::__construct();
	}

	public function handle()
	{
		$args = $this->arguments();
		$opt = $this->options();

		$repo = $this->driver->make($opt['driver']);
		$handler = new HistoryHandler($repo);
		if (isset($args['id']) && (int)$args['id'] > 0) {
			$item = $handler->getById($args['id']);
			$rows = $this->createRow($item);
			$this->createTable($rows);
			return;
		}

		$items = $handler->handle();
		$this->writeData($items);
	}

	public function writeData($items)
	{
		$rows = "";
		foreach ($items as $data) {
			$rows .= $this->createRow($data);
		}
		$this->createTable($rows);
	}

	private function createTable($rows)
	{
		echo "+----+-----------+-----------------------+--------+" . PHP_EOL;
		echo "| ID |  Command  |       Operation       | Result |" . PHP_EOL;
		echo "+----+-----------+-----------------------+--------+" . PHP_EOL;
		echo $rows;
		echo "+----+-----------+-----------------------+--------+" . PHP_EOL;
	}

	private function createRow($data)
	{
		if (is_null($data)) {
			return "|" . $this->addSpace(49, "Data tidak ditemukan")
				. "|" . PHP_EOL;
		}
		return "|" . $this->addSpace(4, $data->id)
			. "|" . $this->addSpace(11, $data->command)
			. "|" . $this->addSpace(23, $data->operation)
			. "|" . $this->addSpace(8, $data->result)
			. "|" . PHP_EOL;
	}

	private function addSpace($length, $text)
	{
		$textLength = strlen($text);
		$space = "";
		for ($i = $textLength; $i < $length; $i++) {
			$space .= " ";
		}
		$spaceLength = strlen($space);
		$part = (int)floor($spaceLength / 2);
		return substr($space, 0, $part) . $text . substr($space, $part);
	}
}
