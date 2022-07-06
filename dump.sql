-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 07 2022 г., 00:49
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `author`
--

INSERT INTO `author` (`id`, `title`) VALUES
(1, 'Кристи Голден'),
(2, 'Metallica'),
(3, 'Сергей Ермохин');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`) VALUES
(1, 'Музыка'),
(2, 'Спорт'),
(3, 'Наука и техника'),
(4, 'Животные'),
(5, 'Литература'),
(6, 'Игры');

-- --------------------------------------------------------

--
-- Структура таблицы `link`
--

CREATE TABLE `link` (
  `id` int NOT NULL,
  `material_id` int NOT NULL,
  `signature` varchar(50) DEFAULT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `link`
--

INSERT INTO `link` (`id`, `material_id`, `signature`, `link`) VALUES
(1, 1, 'Купить на Лабиринте', 'https://www.labirint.ru/books/624315/'),
(2, 1, 'Купить на OZON', 'https://www.ozon.ru/product/world-of-warcraft-rozhdenie-ordy-golden-kristi-250447558/?sh=Jtm_4KzcDQ'),
(3, 2, 'Смотреть на YouTube', 'https://www.youtube.com/watch?v=DqpgMBNdZhU&amp;list=RDDqpgMBNdZhU&amp;start_radio=1'),
(4, 3, 'Читать на Риа новости', 'https://ria.ru/20220706/zhivotnye-1800781255.html'),
(5, 4, 'Слушать на mp3.name', 'https://mp3name.co/populjarnaja-muzyka/'),
(6, 4, 'Слушать на music-2022', 'https://music-2022.ru/'),
(7, 5, NULL, 'https://kriodezz.ru/');

-- --------------------------------------------------------

--
-- Структура таблицы `material`
--

CREATE TABLE `material` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `material`
--

INSERT INTO `material` (`id`, `title`, `type`, `description`) VALUES
(1, 'World of Warcraft: Рождение Орды', 'Книга', 'Одна из огромного множества книг, одной из самых потрясающих вселенных!!!'),
(2, 'Metallica - Live Shit: Binge &amp; Purge - Seattle 1989', 'Видео', 'Невероятный концерт лучшей группы из когда-либо существовавших!'),
(3, 'законопроект о запрете умерщвления здоровых животных', 'Статья', NULL),
(4, 'Популярная попса', 'Подборка', 'Подборка популярной музыки 2022 года'),
(5, 'Гайды по Vampires Fall', 'Сайт/Блог', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `material_author`
--

CREATE TABLE `material_author` (
  `material_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `material_author`
--

INSERT INTO `material_author` (`material_id`, `author_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `material_category`
--

CREATE TABLE `material_category` (
  `material_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `material_category`
--

INSERT INTO `material_category` (`material_id`, `category_id`) VALUES
(1, 5),
(2, 1),
(3, 4),
(4, 1),
(5, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `material_tag`
--

CREATE TABLE `material_tag` (
  `material_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `material_tag`
--

INSERT INTO `material_tag` (`material_id`, `tag_id`) VALUES
(1, 1),
(2, 3),
(3, 1),
(3, 2),
(4, 2),
(4, 4),
(5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `tag`
--

INSERT INTO `tag` (`id`, `title`) VALUES
(1, 'Интересное'),
(2, 'Новое'),
(3, 'Вечное'),
(4, 'Популярное');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material_author`
--
ALTER TABLE `material_author`
  ADD PRIMARY KEY (`material_id`,`author_id`);

--
-- Индексы таблицы `material_category`
--
ALTER TABLE `material_category`
  ADD PRIMARY KEY (`material_id`,`category_id`);

--
-- Индексы таблицы `material_tag`
--
ALTER TABLE `material_tag`
  ADD PRIMARY KEY (`material_id`,`tag_id`);

--
-- Индексы таблицы `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `link`
--
ALTER TABLE `link`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `material`
--
ALTER TABLE `material`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
