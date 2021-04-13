<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-13 14:54:14
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class DivideCommand extends Command
{
	protected $signature = "divide {numbers*}";

	protected $description = "This command is used to divide all given numbers,  and accepts an endless number of inputs as its arguments";

	public function handle()
	{
		$args = $this->arguments();
		$results = 0;
		foreach ($args['numbers'] as $arg) {
			if ($results == 0) {
				$results = (int)$arg;
				continue;
			}
			$results /= (int)$arg;
		}

		echo implode(" / ", $args['numbers']) . " = $results" . PHP_EOL;
	}
}
