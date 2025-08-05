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

    /**
     * Выводит ошибку в консоль
     * 
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        file_put_contents('php://stderr', $message . PHP_EOL);
    }
}