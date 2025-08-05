<?php

namespace Console\Command;

use Console\Output\OutputInterface;
use Console\Input\InputInterface;

/**
 * Отображает справку по команде
 */
class HelpCommand extends Command
{
    /**
     * Команда по которой нужна справка
     * 
     * @var Command|null 
     */
    private ?Command $command;

    /**
     * @param Command|null $command
     */
    public function __construct(Command $command = null)
    {
        $this->command = $command;
        
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('help')
            ->setDescription('Show command help information')
            ->setHelp(<<<HELP
Help Command
Displays help information for commands

Usage:
  help [command_name]

Examples:
  help               Show general help
  help list          Show help for 'list' command
  help print         Show help for 'print' command

Available Commands:
  list               List all available commands
  print              Print arguments and options
  help               Display help information
HELP
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeLine("Description: " . $this->command->getDescription());
        $output->writeLine("");
        $output->writeLine("Usage: " . $this->command->getName() . " {arguments} [parameters]");
        $output->writeLine("");
        $output->writeLine($this->command->getHelp());
    }
}