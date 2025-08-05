<?php

namespace Console\Command;

use Console\Output\OutputInterface;
use Console\Input\InputInterface;

/**
 * Выводит список доступных команд
 */
class ListCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('list')
            ->setDescription('List all registered commands')
            ->setHelp(<<<HELP
List Command
Displays all available commands in the application

Usage:
  list

Examples:
  list               Show all available commands

Description:
  This command provides a complete list of all registered commands
  in the application along with their short descriptions.
HELP
            );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $commands = $this->getApplication()->getCommands();

        if (empty($commands)) {
            $output->writeLine("Not available commands");
        } else {
            $output->writeLine("Available commands:");
            $output->writeLine("");

            // Определяем максимальную длину имени команды для красивого выравнивания
            $maxLength = max(array_map('strlen', array_keys($commands))) + 2;

            foreach ($commands as $command) {
                $output->writeLine(sprintf(
                    "  %-{$maxLength}s %s",
                    $command->getName(),
                    $command->getDescription()
                ));
            }
        }
    }
}