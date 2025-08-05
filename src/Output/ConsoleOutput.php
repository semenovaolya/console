<?php

namespace Console\Output;

/**
 * Класс для работы с выходными данными
 */
class ConsoleOutput implements OutputInterface
{
    public function write(string $message): void
    {
        echo $message;
    }

    public function writeLine(string $message): void
    {
        echo $message . PHP_EOL;
    }

    //todo
    public function error(string $message): void
    {
        file_put_contents('php://stderr', $message . PHP_EOL);
    }
}