<?php

namespace Console\Command;

/**
 * Базовый класс для всех команд
 */
abstract class Command implements CommandInterface
{
    private string $name;
    private string $help = '';
    private string $description = '';

    /**
     * Конфигурирует текущую команду
     */
    abstract protected function configure(): void;

    /**
     * Устанавливает название команды
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->validateName($name);

        $this->name = $name;

        return $this;
    }

    /**
     * Возвращает название команды
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Устанавливает описание команды
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Возвращает описание команды
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Устанавливает справку по команде
     *
     * @param string $help
     * @return $this
     */
    public function setHelp(string $help): static
    {
        $this->help = $help;

        return $this;
    }

    /**
     * Возвращает справку по команде
     *
     * @return string|null
     */
    public function getHelp(): ?string
    {
        return $this->help;
    }

    /**
     * Валидация названия команды
     *
     * @param string $name
     * @return void
     */
    private function validateName(string $name): void
    {
        if (preg_match('/^[a-z0-9_-]+$/i', $name) !== 1) {
            throw new \InvalidArgumentException(\sprintf('Command name "%s" is invalid.', $name));
        }
    }
}