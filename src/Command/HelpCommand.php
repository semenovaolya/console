<?php

namespace Console\Command;

use Console\Output\OutputInterface;
use Console\Input\InputInterface;
/**
 * Отображает справку по команде
 */
class HelpCommand extends Command
{
    private Command $command;

    protected function configure(): void
    {
        $this
            ->setName('help')
            ->setDescription('Show command help information')
            //Arguments:\n  {command} - Command name to show help for
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command displays help for a given command:

  <info>%command.full_name% list</info>

You can also output the help in other formats by using the <comment>--format</comment> option:

  <info>%command.full_name% --format=xml list</info>

To display the list of available commands, please use the <info>list</info> command.
EOF
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $commandName = $input->getCommandName();

        if ($commandName && $this->registry->hasCommand($commandName)) {
            $this->showCommandHelp($commandName, $output);
        } else {
            $this->showGlobalHelp($output);
        }
    }

    private function showCommandHelp(string $commandName, OutputInterface $output): void
    {
        $command = $this->registry->getCommand($commandName);

        $output->writeLine("Description: " . $command->getDescription());
        $output->writeLine("");
        $output->writeLine("Usage: " . $command->getName() . " [arguments] [parameters]");
        $output->writeLine("");
        $output->writeLine($command->getHelp());
    }

    private function showGlobalHelp(OutputInterface $output): void
    {
        $output->writeLine("Available commands:");

        foreach ($this->registry->getCommands() as $command) {
            $output->writeLine(sprintf(
                "  %-15s %s",
                $command->getName(),
                $command->getDescription()
            ));
        }

        $output->writeLine("\nUse {help} with any command to see command details");
    }
}