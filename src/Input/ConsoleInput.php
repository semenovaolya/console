<?php

namespace Console\Input;

/**
 * Класс для работы с входными данными
 */
class ConsoleInput implements InputInterface
{
    /**
     * Распарсенное название команды
     *
     * @var string|null
     */
    private ?string $commandName = '';

    /**
     * Распарсенные аргументы
     *
     * @var array
     */
    private array $arguments = [];

    /**
     * Распрасенные параметры
     *
     * @var array
     */
    private array $parameters = [];

    /**
     * @param array|null $argv
     */
    public function __construct(?array $argv = null)
    {
        $argv ??= $_SERVER['argv'] ?? [];

        while (null !== $token = array_shift($argv)) {
            $this->parse($argv);
        }
    }

    /**
     * Парсит и разбирает входные данные на аргументы и параметры
     *
     * @param array $tokens
     * @return void
     */
    public function parse(array $tokens): void
    {
        foreach ($tokens as $token) {
            $token = trim($token);

            if (empty($token)) {
                continue;
            }

            if (str_starts_with($token, '{') && str_ends_with($token, '}')) {
                $this->parseArgument($token);
            } elseif (str_starts_with($token, '[') && str_ends_with($token, ']')) {
                $this->parseParameter($token);
            } else {
                $this->commandName = $token;
            }
        }
    }

    /**
     * Парсит аргументы
     *
     * @param string $token
     * @return void
     */
    private function parseArgument(string $token): void
    {
        $content = substr($token, 1, -1);
        $args = explode(',', $content);

        foreach ($args as $arg) {
            if ($arg !== '') {
                $this->arguments[] = $arg;
            }
        }
    }

    /**
     * Парсит параметры
     *
     * @param string $token
     * @return void
     */
    private function parseParameter(string $token): void
    {
        $content = substr($token, 1, -1); // Удаляем квадратные скобки

        // Проверяем наличие знака равенства
        if (!str_contains($content, '=')) {
            // Невалидный формат опции - пропускаем
            return;
        }

        [$name, $value] = explode('=', $content, 2);
        $name = trim($name);

        if ($name === '') {
            // Пустое имя опции - пропускаем
            return;
        }

        $this->parameters[$name] = $this->parseParameterValue($value);
    }

    /**
     * Парсит значения параметра
     *
     * @param string $value
     * @return string|array
     */
    private function parseParameterValue(string $value): string|array
    {
        // Проверяем, является ли значение списком
        if (str_starts_with($value, '{') && str_ends_with($value, '}')) {
            $listContent = substr($value, 1, -1);
            $items = explode(',', $listContent);

            return array_filter($items, function($item) {
                return $item !== '';
            });
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandName(): ?string
    {
        return $this->commandName;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasArgument(string $name): bool
    {
        return in_array($name, $this->arguments);
    }
}