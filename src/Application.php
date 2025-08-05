<?php

namespace Console;

use Console\Command\CommandInterface;
use Console\Command\HelpCommand;
use Console\Command\ListCommand;
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

    public function __construct()
    {
        foreach ($this->getDefaultCommands() as $command) {
            $this->registerCommand($command);
        }
    }

    public function run(?InputInterface $input = null, ?OutputInterface $output = null): void
    {
        $input ??= new ConsoleInput();
        $output ??= new ConsoleOutput();

        try {
            $command = $this->getCommand($input);
            $command->execute($input, $output);
        } catch (\Throwable $e) {
            $output->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Возвращает команды по умолчанию, которые всегда должны быть доступны
     *
     * @return Command[]
     */
    protected function getDefaultCommands(): array
    {
        return [/*new HelpCommand(), */new ListCommand()];
    }

    /**
     * Возвращает все доступные команды
     *
     * @return Command[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Отдает экземпляр команды, которую нажо выполнить
     *
     * @param InputInterface $input
     * @return CommandInterface
     * @throws \Exception
     */
    protected function getCommand(InputInterface $input): CommandInterface
    {
        $commandName = $input->getCommandName();

        if (!empty($commandName)) {
            $command = $this->commands[$commandName] ?? throw new \Exception("Command not found: $commandName");

            if ($input->hasArgument('help')) {
                $command = new HelpCommand($command);
            }
        } else {
            $command = new ListCommand();
        }

        return $command;
    }
}