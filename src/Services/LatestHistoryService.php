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

class LatestHistoryService implements CommandHistoryManagerInterface
{
	protected $filename = "latest.log";

	public function findAll(): array
	{
		$items = file(__DIR__ . "/../../storage/$this->filename");
		if (!$items) {
			return [];
		}
		return $items;
	}

	public function find($id)
	{
		$items = $this->findAll();
		foreach ($items as $key => $item) {
			$data = CalculatorData::fromCsv($item);
			if ($data->id == $id) {
				unset($items[$key]);
				$items[] = $item;
				$items = $this->updateLinkedData($items, $key, $data);
				$this->updateData($items);
				return $data;
			}
		}
		return null;
	}

	public function log($command): bool
	{
		try {
			/** set provious id */
			$data = CalculatorData::fromCsv($command);
			$data->prevId = CalculatorData::getLastInsertedItem($this->findAll());
			$command = $data->toCsv();

			$this->checkMaxItems(10);
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
			$k = 0;
			$dataClear = null;
			foreach ($items as $key => $item) {
				$data = CalculatorData::fromCsv($item);
				if ($data->id == $id) {
					$k = $key;
					$dataClear = $data;
					unset($items[$key]);
					continue;
				}
			}

			$items = $this->checkAndSetFirstData($items, $k, $dataClear);

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

	private function checkMaxItems($size)
	{
		$items = $this->findAll();
		if (count($items) > $size - 1) {
			unset($items[0]);
			$file = fopen(__DIR__ . "/../../storage/$this->filename", 'w');
			fwrite($file, implode("", $items));
			fclose($file);
		}
	}

	private function updateData($items)
	{
		$file = fopen(__DIR__ . "/../../storage/$this->filename", 'w');
		fwrite($file, implode("", $items));
	}

	private function updateLinkedData(array $items, $key, $data)
	{
		$prev = null;
		$prevId = null;
		if ($key == 0) {
			$prevId = $data->prevId;
		}
		foreach ($items as $k => $item) {
			if ($key != 0 && $k < $key) {
				$prev = $item;
				continue;
			}
			$currentObj = CalculatorData::fromCsv($item);
			$prevObj = CalculatorData::fromCsv($prev);
			$currentObj->prevId = $prevObj->id;
			if (!is_null($prevId)) {
				$currentObj->prevId = $prevId;
				$prevId = null;
			}
			$items[$k] = $currentObj->toCsv() . PHP_EOL;

			/** update prev */
			$prev = $item;
		}
		return $items;
	}

	private function checkAndSetFirstData($items, $key, $data)
	{
		$fileSvc = new FileHistoryService();
		$fileHistoryCount = count($fileSvc->findAll());
		if ($key == 0 && $fileHistoryCount <= 10) {
			return $items;
		}
		$newItems = [];
		if ($key == 0 && count($items) < 10 && !is_null($data)) {
			if ($data->prevId == 0) {
				return $items;
			}
			$oldObject = $fileSvc->find($data->prevId);
			$newItems[] = $oldObject->toCsv() . PHP_EOL;
		} else if (count($items) < 10) {
			foreach ($items as $item) {
				$first = CalculatorData::fromCsv($item);
				$oldObject = $fileSvc->find($first->prevId);
				$newItems[] = $oldObject->toCsv() . PHP_EOL;
				break;
			}
		} else {
			return $items;
		}
		return array_merge($newItems, $items);
	}
}
