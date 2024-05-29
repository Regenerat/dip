-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:1403
-- Время создания: Май 29 2024 г., 09:55
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dip2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id` int UNSIGNED NOT NULL,
  `fName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `fName`, `lName`, `mName`) VALUES
(1, 'Лев ', 'Николаевич ', 'Толстой'),
(2, 'Фёдор ', 'Михайлович ', 'Достоевский');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `publisher_id` int UNSIGNED NOT NULL,
  `publicationYear` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `stockQuantity` int NOT NULL,
  `status_id` int UNSIGNED NOT NULL,
  `genre_id` int UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `image`, `title`, `author_id`, `publisher_id`, `publicationYear`, `price`, `stockQuantity`, `status_id`, `genre_id`, `description`) VALUES
(1, 'web/images/books/WarAndPeace.webp', 'Война и мир', 1, 1, '1869', '550', 1, 1, 1, 'Роман Льва Николаевича Толстого «Война и мир» — книга на все времена. Кажется, что она существовала всегда, настолько знакомым кажется текст, едва мы открываем первые страницы романа, настолько памятны многие его эпизоды: охота и святки, первый бал Наташи Ростовой, лунная ночь в Отрадном, князь Андрей в сражении при Аустерлице... Сцены «мирной», семейной жизни сменяются картинами, имеющими значение для хода всей мировой истории, но для Толстого они равноценны, связаны в едином потоке времени. Каждый эпизод важен не только для развития сюжета, но и как одно из бесчисленных проявлений жизни, которая насыщена в каждом своем моменте и которую учит любить Толстой.\\nВ данном издании воспроизводится полный комплект иллюстраций к роману «Война и мир», созданных выдающимся чешским художником Станиславом Гудечеком (1872–1947).'),
(2, 'web/images/books/AnnaKarenina.jpg', 'Анна Каренина', 1, 1, '1877', '550', 10, 1, 1, '\"Анну Каренину\" по праву называют самым известным и популярным в мире романом о любви.\n\"Огромная разработка души человеческой\", как отзывался о книге Достоевский, — вот, наверное, что больше всего подкупает нас в этой книге.\nИстория всепоглощающей страсти, история замужней женщины, полюбившей красавца офицера и бросившей своего мужа наперекор всему: мнению света, общепринятой морали, своей совести./n\"Анну Каренину\" экранизировали 30 раз, музыку к балету писали Чайковский и Родион Щедрин, главную героиню в кино играли Грета Гарбо и Вивьен Ли, Алла Тарасова и Татьяна Самойлова, Софи Марсо и Кира Найтли./nЭта книга, конечно, гораздо больше, чем просто роман о любви, это целая наука о семье, об обществе и о жизни.');

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `book_id` int UNSIGNED NOT NULL,
  `count` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_id`, `count`) VALUES
(50, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id` int UNSIGNED NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `genre`) VALUES
(1, 'Классика');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `book_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `places_id` int UNSIGNED NOT NULL,
  `group_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `date`, `user_id`, `book_id`, `quantity`, `places_id`, `group_id`) VALUES
(7, '2024-05-30', 1, 1, 1, 2, '66564ecaac1d3'),
(8, '2024-05-31', 1, 1, 3, 3, '66564f13dec01'),
(9, '2024-05-31', 1, 2, 1, 3, '66564f13dec01'),
(10, '2024-06-09', 1, 1, 2, 2, '66565c437cee5');

-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE `places` (
  `id` int UNSIGNED NOT NULL,
  `metro` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `places`
--

INSERT INTO `places` (`id`, `metro`, `place`) VALUES
(1, 'Парнас', '194358, г. Санкт-Петербург, п. Парголово, ул. Михаила Дудина, д. 6, кор. 1, стр. 1'),
(2, 'Проспект Просвещения', '194355, г. Санкт-Петербург, пр-т Просвещения, д. 19, Лит. А'),
(3, 'Гражданский проспект', '195297, г. Санкт-Петербург, пр-т Просвещения, д. 80, кор. 3, Лит. А');

-- --------------------------------------------------------

--
-- Структура таблицы `publisher`
--

CREATE TABLE `publisher` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `publisher`
--

INSERT INTO `publisher` (`id`, `name`, `adress`) VALUES
(1, 'Перо', '-');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'new');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`, `phone`) VALUES
(1, '1', '1', '1', '1'),
(2, '2', '2', '2', '2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `places_id` (`places_id`);

--
-- Индексы таблицы `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `places`
--
ALTER TABLE `places`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `books_ibfk_4` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`places_id`) REFERENCES `places` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
