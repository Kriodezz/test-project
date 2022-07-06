<?php

namespace Tara\TestProject\Models;

use Tara\TestProject\Exception\InvalidArgumentException;

class Link extends AbstractModel
{
    const TABLE_NAME = 'link';

    protected int $material_id;
    protected ?string $signature;
    protected string $link;

    /**
     * @return int
     */
    public function getMaterialId(): int
    {
        return $this->material_id;
    }

    /**
     * @param int $material_id
     */
    public function setMaterialId(int $material_id): void
    {
        $this->material_id = $material_id;
    }

    /**
     * @return string|null
     */
    public function getSignature(): ?string
    {
        return $this->signature;
    }

    /**
     * @param string|null $signature
     */
    public function setSignature(?string $signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public static function createLink($idMaterial, $data): void
    {
        $exceptions = new InvalidArgumentException();

        if (empty($data['link'])) {
            $exceptions->setException('link', 'Укажите ссылку');
        }

        if (!filter_var(
            $data['link'],
            FILTER_VALIDATE_URL,
            FILTER_FLAG_PATH_REQUIRED)
        ) {
            $exceptions->setException('link', 'Неверный формат ссылки');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $link = new Link();
        $link->setMaterialId($idMaterial);
        if (!empty($data['signature'])) {
            $link->setSignature(htmlentities($data['signature']));
        } else {
            $link->setSignature(null);
        }
        $link->setLink(htmlentities($data['link']));

        $link->save();
    }

    public function updateLink($data): void
    {
        $exceptions = new InvalidArgumentException();

        if (empty($data['link'])) {
            $exceptions->setException('link', 'Укажите ссылку');
        }

        if (!filter_var(
            $data['link'],
            FILTER_VALIDATE_URL,
            FILTER_FLAG_PATH_REQUIRED)
        ) {
            $exceptions->setException('link', 'Неверный формат ссылки');
        }

        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        $this->setLink(htmlentities($data['link']));
        if (!empty($data['signature'])) {
            $this->setSignature(htmlentities($data['signature']));
        } else {
            $this->setSignature(null);
        }

        $this->save();
    }
}
