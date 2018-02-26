-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Úte 06. úno 2018, 12:41
-- Verze serveru: 10.1.26-MariaDB-0+deb9u1
-- Verze PHP: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `netteweb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `prefix_gallery_item`
--

CREATE TABLE `prefix_gallery_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_gallery` bigint(20) UNSIGNED NOT NULL COMMENT 'vazba na galerii',
  `image` varchar(400) DEFAULT NULL COMMENT 'obrazek',
  `added` datetime DEFAULT NULL COMMENT 'pridano',
  `visible` tinyint(1) DEFAULT '0' COMMENT 'viditelnost',
  `visible_on_homepage` tinyint(1) DEFAULT '0' COMMENT 'viditelnost na homepage',
  `position` bigint(20) UNSIGNED DEFAULT '0' COMMENT 'poradi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='galerie - polozky';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_gallery_item`
--
ALTER TABLE `prefix_gallery_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gallery_item_gallery_idx` (`id_gallery`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_gallery_item`
--
ALTER TABLE `prefix_gallery_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prefix_gallery_item`
--
ALTER TABLE `prefix_gallery_item`
  ADD CONSTRAINT `fk_gallery_item_gallery` FOREIGN KEY (`id_gallery`) REFERENCES `prefix_gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
