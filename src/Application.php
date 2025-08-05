<?php

namespace Console;

use Console\Command\CommandInterface;
use Console\Input\ConsoleInput;
use Console\Input\InputInterface;
use Console\Output\ConsoleOutput;
use Console\Output\OutputInterface;

/**
 * Основная точка входа в консольное приложение
 */
class Application
{
    private array $commands = [];

    /**
     * Регистрирует новую команду
     *
     * @param CommandInterface $command
     * @return void
     */
    public function registerCommand(CommandInterface $command): void
    {
        $this->commands[$command->getName()] = $command;
    }

    public function run(?InputInterface $input = null, ?OutputInterface $output = null): void
    {
        $input ??= new ConsoleInput();
        $output ??= new ConsoleOutput();

        try {
            $commandName = $this->getCommandName($input);

            $command = $this->getCommand($commandName);

            return $command->execute($input, $output);
        } catch (CommandNotFoundException $e) {
            $output->error($e->getMessage());
        } catch (\Throwable $e) {
            $output->error("Error: " . $e->getMessage());
        }
    }

    public function getCommandName(InputInterface $input): string
    {
        $commandName = $input->getCommandName();

        if (!$input->getCommandName()) {
            $commandName = 'list';
        } elseif ($input->hasArgument('help')) {
            $commandName = 'help';
        }

        return $commandName;
    }

    public function getCommand(string $name): CommandInterface
    {
        return $this->commands[$name] ?? throw new CommandNotFoundException("Command not found: $name");
    }
}