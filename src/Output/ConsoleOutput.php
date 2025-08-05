<?php

namespace Console\Output;

/**
 * Класс для работы с выходными данными
 */
class ConsoleOutput implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(string $message): void
    {
        echo $message;
    }

    /**
     * {@inheritdoc}
     */
    public function writeLine(string $message): void
    {
        echo $message . PHP_EOL;
    }
}