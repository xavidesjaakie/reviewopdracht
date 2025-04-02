-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 02 apr 2025 om 11:41
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reviewlijst`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `inlog`
--

CREATE TABLE `inlog` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `inlog`
--

INSERT INTO `inlog` (`id`, `naam`, `email`) VALUES
(1, 'kaasje', 'kakerkak11@gmail.com'),
(2, 'appelsap', 'xavivanbeekalt@gmail.com'),
(3, 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `bericht` varchar(255) NOT NULL,
  `cijfer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`id`, `naam`, `bericht`, `cijfer`) VALUES
(1, 'xavi', 'ik ben rijk', ''),
(2, 'e', 'eee', '3'),
(3, 'Lisa Jansen', 'Geweldige service! Ik kom hier zeker terug.', '9'),
(4, 'Mark de Vries', 'Goede ervaring, maar de wachttijd was iets te lang.', '7'),
(5, 'Sophie van Dam', 'Heel vriendelijk personeel en een fijne sfeer.', '10'),
(6, 'Kevin Bakker', 'Product was zoals beschreven. Zeer tevreden!', '8'),
(7, 'Emma Vermeer', 'Snelle levering en goede kwaliteit.', '9'),
(8, 'Tom Peeters', 'Redelijke ervaring, maar had meer verwacht.', '6'),
(9, 'Julia Smit', 'Fantastisch! Dit was beter dan ik had verwacht.', '10'),
(10, 'Daan Bos', 'Eten was lekker, maar service kon beter.', '7'),
(11, 'Mila de Groot', 'Geweldige ervaring! 100% aanbevolen.', '10'),
(12, 'Ruben Visser', 'Goede kwaliteit voor de prijs.', '8'),
(13, 'Naomi Willems', 'Teleurgesteld, product voldeed niet aan mijn verwachtingen.', '5'),
(14, 'Lars van Dijk', 'Klantenservice was erg behulpzaam.', '9'),
(15, 'Eva Meijer', 'Ik vond het prima, maar niet bijzonder.', '7'),
(16, 'Noah Smeets', 'Geweldig personeel, supervriendelijk!', '10'),
(17, 'Sanne Vos', 'Levering duurde langer dan verwacht.', '6'),
(18, 'Jasper Hendriks', 'Alles was perfect geregeld!', '10'),
(19, 'Lotte Mulder', 'Had hogere verwachtingen, maar het was oké.', '6'),
(20, 'Rick de Boer', 'Goede prijs-kwaliteitverhouding.', '8'),
(21, 'Tessa van Leeuwen', 'Slechte ervaring, niet tevreden.', '4'),
(22, 'Bram Jansen', 'Goede service en vriendelijk personeel.', '9'),
(23, 'Elise Jacobs', 'Zeker een aanrader, ik kom terug!', '10'),
(24, 'Tim Scholten', 'De bestelling was niet compleet, jammer.', '5'),
(25, 'Hanna Kuipers', 'Goede ervaring, lekker gegeten.', '8'),
(26, 'Niels Koster', 'Super snel geholpen, top!', '9'),
(27, 'Laura van den Berg', 'Niet de beste ervaring, maar ook niet slecht.', '7'),
(31, 'kaasje', 'jo mensen', '8'),
(32, 'appsap', 'e', '2');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `inlog`
--
ALTER TABLE `inlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `inlog`
--
ALTER TABLE `inlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
