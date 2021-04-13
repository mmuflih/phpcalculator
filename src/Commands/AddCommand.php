<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-14 06:08:14
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class AddCommand extends Command
{
	protected $signature = "add {numbers*}";

	protected $description = "This command is used to add all given numbers, and accepts an endless number of inputs as its arguments";

	public function handle()
	{
		$args = $this->arguments();
		$results = 0;
		foreach ($args['numbers'] as $arg) {
			$results += (int)$arg;
		}

		echo implode(" + ", $args['numbers']) . " = $results " . PHP_EOL;
	}
}
