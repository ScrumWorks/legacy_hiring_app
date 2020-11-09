<?php

namespace Console\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Tracy\Debugger;

/**
 * @author Martin Baží­k <martin@bazo.sk>
 */
class CallAPI extends Command
{

	private \PDO $db;

	private Client $http;

	public function __construct(\PDO $db)
	{
		parent::__construct();
		$this->db				 = $db;
		$this->http = new Client([
			'base_uri' => 'https://enq3insv1k0js.x.pipedream.net/',
			'timeout'  => 2.0,
		]);
	}


	protected function configure()
	{
		$this
			->setName('api:call')
			->setDescription('Calls an API :)');
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$res = $this->db->query('SELECT * FROM users');

		$count = $res->rowCount();

		ProgressBar::setFormatDefinition('custom', '%current%/%max% -- %message%');
		$progressBar = new ProgressBar($output, $count);
		$progressBar->setFormat('custom');

		foreach ($res as $row) {
			$progressBar->setMessage('Sending data of user: ' . $row['id']);

			try {
				$res = $this->http->request('PUT', '/users', [
					'json' => [
						'id' => $row['id'],
						'name' => $row['name'],
					]
				]);
				$progressBar->setMessage('ok');
			} catch (\Throwable $e) {
				$progressBar->setMessage('not ok');
				Debugger::log($e);
			} finally {
				$progressBar->advance();
			}
		}

		$progressBar->setMessage('Done');
		$progressBar->finish();

		$output->writeln('');

		return Command::SUCCESS;
	}
}
