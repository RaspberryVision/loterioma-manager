<?php

namespace App\Command;

use App\Message\Game\GameUpdated;
use App\Repository\GameRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class SyncGameCommand extends Command
{
    /**
     * @var GameRepository $gameRepository
     */
    private $gameRepository;

    /**
     * @var MessageBusInterface $messageBus
     */
    private $messageBus;

    protected static $defaultName = 'app:sync:game';

    /**
     * SyncGameCommand constructor.
     * @param MessageBusInterface $messageBus
     * @param GameRepository $gameRepository
     */
    public function __construct(MessageBusInterface $messageBus, GameRepository $gameRepository)
    {
        $this->messageBus = $messageBus;
        $this->gameRepository = $gameRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($games = $this->gameRepository->findAll() as $game) {
            $this->messageBus->dispatch(new GameUpdated(json_encode($game->dto())));
        }

        $io->success(sprintf('Synced games: %d', count($games)));

        return 0;
    }
}
