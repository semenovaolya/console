<?php

namespace Console\Input;

/**
 * Класс для работы с входными данными
 */
class ConsoleInput implements InputInterface
{
    private ?string $commandName;
    private array $arguments = [];
    private array $parameters = [];

    /**
     * @param array|null $argv
     */
    public function __construct(?array $argv = null)
    {
        $argv ??= $_SERVER['argv'] ?? [];

        $this->parse($argv);
    }

    /**
     * Парсит и разбирает входные данные на аргументы и параметры
     *
     * @param array $tokens
     * @return array
     */
    public function parse(array $tokens): array
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
                // Одиночный аргумент без скобок
                $this->arguments[] = $token;
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
     * Возвращает название команты
     *
     * @return string|null
     */
    public function getCommandName(): ?string
    {
        return $this->commandName;
    }

    /**
     * Возвращает аргументы
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Возвращает параметры
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Возвращает флаг наличия команды в запросе
     *
     * @param string $name
     * @return bool
     */
    public function hasArgument(string $name): bool
    {
        return in_array($name, $this->arguments);
    }

    public function getArgument(string $name, $default = null)
    {
        return $this->arguments[$name] ?? $default;
    }

    public function hasParameter(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    public function getParameter(string $name, $default = null)
    {
        return $this->parameters[$name] ?? $default;
    }
}