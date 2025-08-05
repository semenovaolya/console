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

    //todo
    /**
     * Возвращает значение true, если объект InputArgument существует по имени или позиции.
     *
     * @param string $name
     * @return bool
     */
    public function hasArgument(string $name): bool;

    /**
     *
     *  Returns the argument value for a given argument name.
     *
     * @throws InvalidArgumentException When argument given doesn't exist
     *
     * @param string $name
     * @param $default
     * @return mixed
     */
    public function getArgument(string $name): mixed;
    public function hasParameter(string $name): bool;
    public function getParameter(string $name, $default = null);
}