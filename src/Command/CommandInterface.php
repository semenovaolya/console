<?php

namespace Console\Command;

use Console\Output\OutputInterface;
use Console\Input\InputInterface;

/**
 * Интерфейс, реализуемый всеми командами
 */
interface CommandInterface
{
    /**
     * Выполняет команду
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output): void;
}