

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `intellihome`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `alarm`
--

CREATE TABLE IF NOT EXISTS `alarm` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Who` int(11) DEFAULT NULL,
  `Status` varchar(10) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `alarm`
--

INSERT INTO `alarm` (`Id`, `Date`, `Time`, `Who`, `Status`) VALUES
(1, '2017-01-19', '14:36:19', 6, 'OFF'),
(2, '2017-03-20', '14:38:36', 6, 'CHANGE'),
(3, '2017-03-20', '14:38:40', 6, 'OFF');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `heating`
--

CREATE TABLE IF NOT EXISTS `heating` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `OperatingMode` int(1) NOT NULL,
  `Temperature` float NOT NULL,
  `Amplitude` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `heating`
--

INSERT INTO `heating` (`Id`, `Date`, `Time`, `OperatingMode`, `Temperature`, `Amplitude`) VALUES
(1, '2017-03-20', '14:39:21', 1, 20.5, 0.5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `heating_modes`
--

CREATE TABLE IF NOT EXISTS `heating_modes` (
  `Id` int(11) NOT NULL,
  `Name` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `Temperature` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `heating_modes`
--

INSERT INTO `heating_modes` (`Id`, `Name`, `Temperature`) VALUES
(1, 'Dzienny', 20.5),
(2, 'Nocny', 18.5),
(3, 'Wakacyjny', 15),
(4, 'Wyłączony', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `heating_statistics`
--

CREATE TABLE IF NOT EXISTS `heating_statistics` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Temperature` float NOT NULL,
  `Humidity` int(11) NOT NULL,
  `SetTemp` float NOT NULL,
  `FromTemp` float NOT NULL,
  `ToTemp` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `heating_statistics`
--

INSERT INTO `heating_statistics` (`Id`, `Date`, `Time`, `Temperature`, `Humidity`, `SetTemp`, `FromTemp`, `ToTemp`) VALUES
(1, '2017-03-09', '15:18:44', 22, 44, 20.2, 20.1, 20.3),
(2, '2017-03-09', '15:19:02', 21.3, 44, 20.2, 20.1, 20.3),
(3, '2017-03-09', '16:00:26', 21.3, 45, 20.2, 20.1, 20.3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `heating_timetable`
--

CREATE TABLE IF NOT EXISTS `heating_timetable` (
  `DayOfWeek` int(11) NOT NULL,
  `StartBlock1` time NOT NULL,
  `StopBlock1` time NOT NULL,
  `ModeBlock1` int(1) NOT NULL,
  `StartBlock2` time DEFAULT NULL,
  `StopBlock2` time DEFAULT NULL,
  `ModeBlock2` int(1) DEFAULT NULL,
  `StartBlock3` time DEFAULT NULL,
  `StopBlock3` time DEFAULT NULL,
  `ModeBlock3` int(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `heating_timetable`
--

INSERT INTO `heating_timetable` (`DayOfWeek`, `StartBlock1`, `StopBlock1`, `ModeBlock1`, `StartBlock2`, `StopBlock2`, `ModeBlock2`, `StartBlock3`, `StopBlock3`, `ModeBlock3`) VALUES
(1, '00:00:00', '09:59:00', 2, '10:00:00', '16:59:00', 1, '17:00:00', '23:59:00', 4),
(2, '00:00:00', '06:59:00', 4, '07:00:00', '21:59:00', 1, '22:00:00', '23:59:00', 2),
(3, '00:00:00', '05:59:00', 2, '06:00:00', '21:59:00', 1, '22:00:00', '23:59:00', 2),
(4, '00:00:00', '10:59:00', 2, '11:00:00', '21:59:00', 1, '22:00:00', '23:59:00', 2),
(5, '00:00:00', '11:59:00', 2, '12:00:00', '21:59:00', 1, '22:00:00', '23:59:00', 2),
(6, '00:00:00', '06:59:00', 2, '07:00:00', '21:59:00', 1, '22:00:00', '23:59:00', 2),
(7, '00:00:00', '10:59:00', 2, '11:00:00', '21:59:00', 1, '22:00:00', '23:59:00', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Content` varchar(250) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `logs`
--

INSERT INTO `logs` (`Id`, `Date`, `Time`, `Content`) VALUES
(1, '2017-02-15', '06:18:33', 'Aktywowano alarm'),
(260, '2017-03-20', '14:36:19', 'Użytkownik Jan Kowalski dezaktywował alarm używając serwisu IntelliHome'),
(261, '2017-03-20', '14:37:07', 'Użytkownik Jan Kowalski zmienił tryb ogrzewania używając serwisu IntelliHome'),
(262, '2017-03-20', '14:37:22', 'Użytkownik Jan Kowalski zmienił ustawienia pamięci systemu używając serwisu IntelliHome'),
(263, '2017-03-20', '14:37:27', 'Użytkownik Jan Kowalski zmienił ustawienia użytkownika systemu używając serwisu IntelliHome'),
(264, '2017-03-20', '14:37:35', 'Użytkownik Jan Kowalski zmienił ustawienia użytkownika systemu używając serwisu IntelliHome'),
(265, '2017-03-20', '14:38:07', 'Użytkownik Jan Kowalski zmienił harmonogram ogrzewania'),
(266, '2017-03-20', '14:38:24', 'Użytkownik Jan Kowalski zmienił tryby ogrzewania'),
(267, '2017-03-20', '14:38:31', 'Użytkownik Jan Kowalski aktywował inteligentne podlewanie używając serwisu IntelliHome'),
(268, '2017-03-20', '14:38:36', 'Użytkownik Jan Kowalski aktywował alarm używając serwisu IntelliHome'),
(269, '2017-03-20', '14:38:40', 'Użytkownik Jan Kowalski dezaktywował alarm używając serwisu IntelliHome'),
(270, '2017-03-20', '14:38:56', 'Użytkownik Jan Kowalski zmienił ustawienia systemu używając serwisu IntelliHome'),
(271, '2017-03-20', '14:39:00', 'Użytkownik Jan Kowalski zmienił ustawienia systemu używając serwisu IntelliHome'),
(272, '2017-03-20', '14:39:21', 'Użytkownik Jan Kowalski zmienił ustawienia ogrzewania używając serwisu IntelliHome');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `motion_detect`
--

CREATE TABLE IF NOT EXISTS `motion_detect` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `PIRId` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `motion_sensors`
--

CREATE TABLE IF NOT EXISTS `motion_sensors` (
  `Id` int(11) NOT NULL,
  `RoomName` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `motion_sensors`
--

INSERT INTO `motion_sensors` (`Id`, `RoomName`) VALUES
(1, 'Wiatrołap'),
(2, 'Salon'),
(3, 'Łazienka'),
(4, 'Sypialnia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Type` varchar(10) COLLATE utf8mb4_polish_ci NOT NULL,
  `Content` varchar(250) COLLATE utf8mb4_polish_ci NOT NULL,
  `IsRead` tinyint(1) NOT NULL,
  `ReadByUser` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `notifications`
--

INSERT INTO `notifications` (`Id`, `Date`, `Time`, `Type`, `Content`, `IsRead`, `ReadByUser`) VALUES
(3, '2017-03-09', '13:49:27', 'danger', 'Włamanie !!!', 0, 0),
(4, '2017-03-09', '13:49:44', 'info', 'System IntelliHome został zrestartowany. Alarm zdezaktywowany.', 0, 0),
(5, '2017-03-09', '13:54:59', 'success', 'Zmieniono numer PIN', 0, 0),
(6, '2017-03-09', '14:16:40', 'warning', 'Trzykrotnie wpisano błędny PIN', 0, 0),
(7, '2017-03-09', '14:24:38', 'success', 'Zmieniono numer alarmowy na: 555444333', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `Id` int(11) NOT NULL,
  `CardNumber` int(11) NOT NULL,
  `Name` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `persons`
--

INSERT INTO `persons` (`Id`, `CardNumber`, `Name`) VALUES
(1, 0, 'Jan Kowalski'),
(2, 0, 'Michał Nowak'),
(3, 0, ''),
(4, 0, ''),
(5, 0, 'Gość'),
(6, 0, 'System IntelliHome');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `services_deadlines`
--

CREATE TABLE IF NOT EXISTS `services_deadlines` (
  `Id` int(11) NOT NULL,
  `ServiceName` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `DeadlineDate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `services_deadlines`
--

INSERT INTO `services_deadlines` (`Id`, `ServiceName`, `DeadlineDate`) VALUES
(1, 'Domain', '2017-07-30'),
(2, 'Hosting', '2017-02-06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `Id` int(11) NOT NULL,
  `AlarmPhoneNumber` varchar(15) COLLATE utf8mb4_polish_ci NOT NULL,
  `BlindTime` int(11) NOT NULL,
  `SirenTime` int(11) NOT NULL,
  `ShowCameraViewWhenAlarmDeactivated` tinyint(1) NOT NULL,
  `ChangeBlindsAfterAlarmActicated` tinyint(1) NOT NULL,
  `ChangeHeatingAfterAlarmActicated` tinyint(1) NOT NULL,
  `PreventHeating` tinyint(1) NOT NULL,
  `PreventBlindsDamage` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `settings`
--

INSERT INTO `settings` (`Id`, `AlarmPhoneNumber`, `BlindTime`, `SirenTime`, `ShowCameraViewWhenAlarmDeactivated`, `ChangeBlindsAfterAlarmActicated`, `ChangeHeatingAfterAlarmActicated`, `PreventHeating`, `PreventBlindsDamage`) VALUES
(1, '737444053', 40000, 15, 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings_users`
--

CREATE TABLE IF NOT EXISTS `settings_users` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `LiquidWasteEmail` tinyint(1) NOT NULL,
  `LogsEmail` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `settings_users`
--

INSERT INTO `settings_users` (`Id`, `UserId`, `LiquidWasteEmail`, `LogsEmail`) VALUES
(1, 3, 1, 1),
(2, 4, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `temporary_data`
--

CREATE TABLE IF NOT EXISTS `temporary_data` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Temperature` float NOT NULL,
  `Humidity` int(11) NOT NULL,
  `Insolation` int(11) NOT NULL,
  `WindLevel` int(11) NOT NULL,
  `RainLevel` int(11) NOT NULL,
  `Pressure` int(11) NOT NULL,
  `LiquidWaste` int(11) NOT NULL,
  `HomeTemperature` float NOT NULL,
  `HomeHumidity` int(11) NOT NULL,
  `BlindLevel` int(11) NOT NULL,
  `HeatingLevel` int(11) NOT NULL,
  `WateringState` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `temporary_data`
--

INSERT INTO `temporary_data` (`Id`, `Date`, `Time`, `Temperature`, `Humidity`, `Insolation`, `WindLevel`, `RainLevel`, `Pressure`, `LiquidWaste`, `HomeTemperature`, `HomeHumidity`, `BlindLevel`, `HeatingLevel`, `WateringState`) VALUES
(1, '2017-03-20', '14:38:33', 23.6, 65, 84, 2, 0, 1015, 210, 21.3, 45, 60, 10, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `role` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`, `surname`, `sex`, `birthdate`, `role`) VALUES
(5, 'user', 'user', 'brzozowski.test@gmail.com', 'brzozowski.test@gmail.com', 1, NULL, '$2y$13$7QWoEuOTaRVsrqT7K4.g9eC04IepNbB/Ypx/DGQMnkoPQa6S/V.XS', '2017-03-20 14:35:34', NULL, NULL, 'a:0:{}', 'Jan', 'Kowalski', 'm', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `weather_station`
--

CREATE TABLE IF NOT EXISTS `weather_station` (
  `Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `City` text COLLATE utf8mb4_polish_ci NOT NULL,
  `Temperature` float NOT NULL,
  `FeelsLike` float NOT NULL,
  `Humidity` int(11) NOT NULL,
  `SolarRadiation` text COLLATE utf8mb4_polish_ci NOT NULL,
  `UV` text COLLATE utf8mb4_polish_ci NOT NULL,
  `WindLevel` double NOT NULL,
  `RainLevel` double NOT NULL,
  `RainToday` float NOT NULL,
  `Pressure` int(11) NOT NULL,
  `LiquidWaste` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4926 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `weather_station`
--

INSERT INTO `weather_station` (`Id`, `Date`, `Time`, `City`, `Temperature`, `FeelsLike`, `Humidity`, `SolarRadiation`, `UV`, `WindLevel`, `RainLevel`, `RainToday`, `Pressure`, `LiquidWaste`) VALUES
(1, '2017-01-07', '17:42:10', 'Gmina Kostrzyn', -5.7, -11, 78, '--', '-1', 13, 0, 0, 1027, 0),
(2, '2017-01-07', '17:52:08', 'Gmina Kostrzyn', -5.6, -11, 78, '--', '-1', 12, 0, 0, 1027, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `alarm`
--
ALTER TABLE `alarm`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `heating`
--
ALTER TABLE `heating`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `heating_modes`
--
ALTER TABLE `heating_modes`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `heating_statistics`
--
ALTER TABLE `heating_statistics`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `heating_timetable`
--
ALTER TABLE `heating_timetable`
  ADD PRIMARY KEY (`DayOfWeek`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `motion_detect`
--
ALTER TABLE `motion_detect`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `motion_sensors`
--
ALTER TABLE `motion_sensors`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `services_deadlines`
--
ALTER TABLE `services_deadlines`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `settings_users`
--
ALTER TABLE `settings_users`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `temporary_data`
--
ALTER TABLE `temporary_data`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_1483A5E9C05FB297` (`confirmation_token`);

--
-- Indexes for table `weather_station`
--
ALTER TABLE `weather_station`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `alarm`
--
ALTER TABLE `alarm`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `heating`
--
ALTER TABLE `heating`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `heating_modes`
--
ALTER TABLE `heating_modes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `heating_statistics`
--
ALTER TABLE `heating_statistics`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `heating_timetable`
--
ALTER TABLE `heating_timetable`
  MODIFY `DayOfWeek` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `logs`
--
ALTER TABLE `logs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=273;
--
-- AUTO_INCREMENT dla tabeli `motion_detect`
--
ALTER TABLE `motion_detect`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `motion_sensors`
--
ALTER TABLE `motion_sensors`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `notifications`
--
ALTER TABLE `notifications`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `persons`
--
ALTER TABLE `persons`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `services_deadlines`
--
ALTER TABLE `services_deadlines`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `settings`
--
ALTER TABLE `settings`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `settings_users`
--
ALTER TABLE `settings_users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `temporary_data`
--
ALTER TABLE `temporary_data`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `weather_station`
--
ALTER TABLE `weather_station`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4926;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
