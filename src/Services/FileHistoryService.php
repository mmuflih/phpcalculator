<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-14 17:33:43
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Services;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class FileHistoryService implements CommandHistoryManagerInterface
{
	protected $filename = "mesinhitung.log";

	public function findAll(): array
	{
		return file(__DIR__ . "/../../storage/$this->filename");
	}

	public function find($id)
	{
		$data = $this->findAll();
		foreach ($data as $item) {
			$data = CalculatorData::fromCsv($item);
			if ($data->id == $id) {
				return $data;
			}
		}
		return null;
	}

	public function log($command): bool
	{
		try {
			$file = fopen(__DIR__ . "/../../storage/$this->filename", 'a+');
			fwrite($file, $command . PHP_EOL);
			return fclose($file);
		} catch (\Exception $e) {
			return false;
		}
	}

	public function clear($id): bool
	{
		try {
			$items = $this->findAll();
			foreach ($items as $key => $item) {
				$data = CalculatorData::fromCsv($item);
				if ($data->id == $id) {
					unset($items[$key]);
					continue;
				}
			}
			$file = fopen(__DIR__ . "/../../storage/$this->filename", 'w');
			fwrite($file, implode("", $items));
			return fclose($file);
		} catch (\Exception $e) {
			return false;
		}
	}

	public function clearAll(): bool
	{
		try {
			$file = fopen(__DIR__ . "/../../storage/$this->filename", 'w');
			fwrite($file, "");
			return fclose($file);
		} catch (\Exception $e) {
			return false;
		}
	}
}
