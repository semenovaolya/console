<?php

namespace Console\Output;

/**
 * Интерфейс, реализуемый всеми output
 */
interface OutputInterface
{
    /**
     * Записывает сообщение в выходные данные
     *
     * @param string $message
     * @return void
     */
    public function write(string $message): void;

    /**
     * Записывает сообщение в выходные данные и добавляет новую строку в конце
     *
     * @param string $message
     * @return void
     */
    public function writeLine(string $message): void;
}