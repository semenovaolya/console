<?php

namespace Console\Input;

/**
 * Интерфейс, реализуемый всеми input
 */
interface InputInterface
{
    /**
     * Возвращает название введенной команды
     *
     * @return string|null
     */
    public function getCommandName(): ?string;

    /**
     * Возвращает все заданные аргументы
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Возвращает все заданные параметры
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Проверяет наличие аргумента
     *
     * @param string $name
     * @return bool
     */
    public function hasArgument(string $name): bool;
}