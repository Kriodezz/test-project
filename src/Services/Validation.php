<?php

namespace Tara\TestProject\Services;

use Tara\TestProject\Exception\InvalidArgumentException;
use Tara\TestProject\Models\Author;
use Tara\TestProject\Models\Category;

class Validation
{

    public static function validationDataMaterial($data)
    {
        //Создание объекта исключений
        $exceptions = new InvalidArgumentException();

        /*
         * В случае несоответствия переданного типа ни одному из имеющихся
         * записывается ошибка с указанием на тип 'type'
         */
        if (!in_array(
            $data['type'],
            ['Книга', 'Статья', 'Видео', 'Сайт/Блог', 'Подборка', 'Ключевые идеи книги']
        )
        ) {
            $exceptions->setException('type');
        }

        /*
         * В случае несоответствия переданной категории ни одной из имеющихся
         * записывается ошибка с указанием на тип 'category'
         */
        $allCategories = Category::getDataColumn('title');
        if (!in_array($data['category'], $allCategories)) {
            $exceptions->setException('category');
        }
        /*
         * Если не передано название записывается ошибка с указанием на тип 'title'
         */
        if (empty($data['title'])) {
            $exceptions->setException('title');
        }

        /*
         * Если передано несколько авторов, разделители переданные пользователем
         * приводятся к единому разделителю " | ", проверяется соответствие имен
         * на корректность (допускается наличие только букв и пробелов) и
         * возвращается массив с именами авторов для дальнейшей обработки
         */
        if (!empty($data['authors'])) {
            $AuthorsWithOneSeparator = preg_replace(
                '~\s*[\.,\,,\:,\;,\/,\|,\\\]\s*~',
                '|', $data['authors']);
            $Authors = explode('|', $AuthorsWithOneSeparator);
            foreach ($Authors as $keyAuthor => $NameAuthor) {
                if (!preg_match('~^[A-я,\s]+$~', $NameAuthor)) {
                    $exceptions->setException('authors', "Недопустимые символы в имени $NameAuthor");
                }
            }
        }

        //Если при прохождении валидации возникли ошибки бросается исключение
        if (!empty($exceptions->getAllException())) {
            throw $exceptions;
        }

        //В случае успешной валидации возвращается массив с авторами материала
        return $Authors ?? null;
    }
}
