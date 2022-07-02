<?php

namespace Tara\TestProject\Exception;

class InvalidArgumentException extends \Exception
{
    protected array $data = [];

    public function setException(string $type, string|bool $message = true): void
    {
        $this->data[$type][] = $message;
    }

    /**
     * @return array
     */
    public function getAllException(): array
    {
        return $this->data;
    }
}
