-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 15 2014 г., 03:01
-- Версия сервера: 5.5.27
-- Версия PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test-auth`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `fb_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fb_id` (`fb_id`),
  KEY `email` (`email`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `active`, `fb_id`) VALUES
(1, 'test@test.com', 'e10adc3949ba59abbe56e057f20f883e', 'est', 'rec', 1, NULL),
(3, 'test2@test.com', '46e44aa0bc21d8a826d79344df38be4b', 'ÐœÐ°ÐºÑÐ¸Ð¼', 'Ð®Ð´Ð¸Ð½', 1, NULL),
(13, 'mxlpitelik@outlook.com', '420c2381d05c460ea29cbde578c4fda4', '', '', 0, NULL),
(14, 'merrykurva@ya.ru', '46e44aa0bc21d8a826d79344df38be4b', '', '', 1, NULL),
(15, 'sdf@sdf.com', '46e44aa0bc21d8a826d79344df38be4b', '', '', 1, NULL),
(16, 'p@p.com', '8446413fa6ca49a96903f31c174803c4', '', '', 1, NULL),
(17, 'jhg@jhg.ckj', 'd86674e6d7ad3b70cd316b9687eec875', 'khgg', 'hjgjhg', 1, NULL),
(18, 'kjh@kjh.iou', 'd86674e6d7ad3b70cd316b9687eec875', 'ÐœÐ°ÐºÑ', 'Ð®Ð´Ð¸Ð½', 1, NULL),
(19, 'kjhjkh@kjh.kj', 'a73d57035b5f1ad09ac48814960e2064', 'erhkj', 'khjkhkjh', 1, NULL),
(20, 'mxlpitelik@gmail.com', '334c4a4c42fdb79d7ebc3e73b517e6f8', 'ÐœÐ°ÐºÑÐ¸Ð¼', 'Ð®Ð´Ð¸Ð½', 1, 804134066325854);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
