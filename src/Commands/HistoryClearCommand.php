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
use Jakmall\Recruitment\Calculator\Handler\RemoveHistoryHandler;

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
			$handler = new RemoveHistoryHandler($repo);
			if (isset($args['id']) && (int)$args['id'] > 0) {
				$id = $args['id'];
				$item = $handler->removeById($id);
				if ($item) {
					echo "Data with ID $id is removed" . PHP_EOL;
				}
				return;
			}

			$success = $handler->handle();
			if ($success) {
				echo "All history is cleared" . PHP_EOL;
			}
		} catch (\Exception $e) {
			echo $e->getMessage() . PHP_EOL;
		}
	}
}
