-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 apr 2019 om 18:23
-- Serverversie: 10.1.28-MariaDB
-- PHP-versie: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_toets_3_pannenkoeken`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE `bestellingen` (
  `id` int(11) UNSIGNED NOT NULL,
  `besteltijd` datetime NOT NULL,
  `serveertijd` datetime DEFAULT NULL,
  `betaaltijd` datetime DEFAULT NULL,
  `volgnummer` int(3) UNSIGNED DEFAULT NULL,
  `id_tafel` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `bestellingen`
--

INSERT INTO `bestellingen` (`id`, `besteltijd`, `serveertijd`, `betaaltijd`, `volgnummer`, `id_tafel`) VALUES
(1, '2019-04-15 16:48:35', NULL, NULL, 1, 1),
(2, '2019-04-15 17:16:54', '2019-04-15 23:20:06', NULL, NULL, 3),
(3, '2019-04-15 17:17:11', NULL, NULL, 2, 3),
(4, '2019-04-15 17:19:36', '2019-04-15 17:42:02', NULL, NULL, 6),
(5, '2019-04-15 17:19:46', NULL, NULL, 3, 6),
(6, '2019-04-15 23:14:28', NULL, NULL, 4, 5),
(7, '2019-04-15 23:14:56', NULL, NULL, 5, 5),
(8, '2019-04-15 23:15:57', '2019-04-15 23:16:24', NULL, NULL, 12),
(9, '2019-04-15 23:16:13', NULL, NULL, 6, 12),
(10, '2019-04-15 23:19:07', '2019-04-15 23:19:55', NULL, NULL, 7),
(11, '2019-04-15 23:19:28', '2019-04-15 23:20:01', NULL, NULL, 7),
(12, '2019-04-15 23:19:42', NULL, NULL, 7, 7),
(13, '2019-04-15 23:20:21', NULL, NULL, 8, 8);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling_product`
--

CREATE TABLE `bestelling_product` (
  `id_bestelling` int(11) UNSIGNED NOT NULL,
  `id_product` int(11) UNSIGNED NOT NULL,
  `aantal` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `bestelling_product`
--

INSERT INTO `bestelling_product` (`id_bestelling`, `id_product`, `aantal`) VALUES
(1, 1, 1),
(1, 3, 1),
(1, 4, 1),
(1, 6, 1),
(1, 7, 1),
(1, 9, 2),
(1, 10, 1),
(1, 11, 1),
(1, 12, 2),
(1, 13, 1),
(2, 4, 3),
(2, 5, 1),
(3, 8, 2),
(3, 9, 2),
(4, 1, 4),
(5, 1, 4),
(6, 3, 2),
(6, 4, 6),
(7, 8, 1),
(7, 9, 3),
(7, 10, 2),
(8, 4, 2),
(8, 5, 1),
(8, 8, 2),
(8, 9, 2),
(8, 14, 1),
(9, 12, 1),
(9, 13, 3),
(10, 2, 2),
(10, 3, 2),
(10, 10, 4),
(11, 2, 2),
(11, 3, 2),
(12, 2, 2),
(12, 3, 2),
(13, 6, 20);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `id` int(11) UNSIGNED NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs` decimal(4,2) NOT NULL,
  `id_rubriek` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `naam`, `prijs`, `id_rubriek`) VALUES
(1, 'bier', '2.50', 1),
(2, 'rode wijn', '3.80', 1),
(3, 'witte wijn', '3.60', 1),
(4, 'cola', '2.20', 2),
(5, 'sinas', '2.20', 2),
(6, 'ranja', '1.25', 2),
(7, 'kinderpannenkoek', '4.50', 3),
(8, 'spekpannenkoek', '7.60', 3),
(9, 'kaaspannenkoek', '6.30', 3),
(10, 'geflambeerde pannenkoek', '9.80', 3),
(11, 'kinderijsje', '3.50', 4),
(12, 'dame blanche', '4.50', 4),
(13, 'bananenboot', '7.00', 4),
(14, 'seven up', '2.15', 2),
(15, 'all you can eat', '19.99', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rubrieken`
--

CREATE TABLE `rubrieken` (
  `id` int(11) UNSIGNED NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `rubrieken`
--

INSERT INTO `rubrieken` (`id`, `naam`) VALUES
(1, 'alcohol'),
(2, 'fris'),
(3, 'pannenkoeken'),
(4, 'toetjes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tafels`
--

CREATE TABLE `tafels` (
  `id` int(11) UNSIGNED NOT NULL,
  `nummer` int(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tafels`
--

INSERT INTO `tafels` (`id`, `nummer`) VALUES
(1, 1),
(2, 2),
(3, 3),
(11, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(12, 9),
(10, 10);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tijd` (`besteltijd`),
  ADD KEY `volgnummer` (`volgnummer`),
  ADD KEY `serveertijd` (`serveertijd`),
  ADD KEY `id_tafel` (`id_tafel`);

--
-- Indexen voor tabel `bestelling_product`
--
ALTER TABLE `bestelling_product`
  ADD PRIMARY KEY (`id_bestelling`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rubriek` (`id_rubriek`);

--
-- Indexen voor tabel `rubrieken`
--
ALTER TABLE `rubrieken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `naam` (`naam`);

--
-- Indexen voor tabel `tafels`
--
ALTER TABLE `tafels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nummer` (`nummer`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `rubrieken`
--
ALTER TABLE `rubrieken`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `tafels`
--
ALTER TABLE `tafels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`id_tafel`) REFERENCES `tafels` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `bestelling_product`
--
ALTER TABLE `bestelling_product`
  ADD CONSTRAINT `bestelling_product_ibfk_1` FOREIGN KEY (`id_bestelling`) REFERENCES `bestellingen` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bestelling_product_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `producten` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD CONSTRAINT `producten_ibfk_1` FOREIGN KEY (`id_rubriek`) REFERENCES `rubrieken` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
