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

class HistoryClearCommand extends Command
{
	protected $signature = "history:clear {id?} {--driver=}";

	protected $description = "";

	private $driver;

	public function __construct(HistoryDriverInterface $driver)
	{
		$this->driver = $driver;
		parent::__construct();
	}

	public function handle()
	{
		try {
			$args = $this->arguments();
			$opt = $this->options();

			$repo = $this->driver->make($opt['driver']);
			if (isset($args['id']) && (int)$args['id'] > 0) {
				$id = $args['id'];
				$item = $repo->clear($id);
				if ($item) {
					echo "Data with ID $id is removed" . PHP_EOL;
				}
				return;
			}

			$success = $repo->clearAll();
			if ($success) {
				echo "All history is cleared" . PHP_EOL;
			}
		} catch (\Exception $e) {
			echo $e->getMessage() . PHP_EOL;
		}
	}
}
