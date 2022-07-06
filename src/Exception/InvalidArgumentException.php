<?php

namespace Tara\TestProject\Exception;

class InvalidArgumentException extends \Exception
{
    //Массив с данными исключений
    protected array $data = [];

    /*
     * Запись в $data информации об исключениях
     * Без указания сообщения в $data будет храниться сведения
     * о том что в типе данных $data['type'] есть ошибка ($data['type'] => true)
     * Если для одного типа может быть несколько ошибок, необходимо указывать
     * сообщения об ошибках.
     */
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
