-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql657.db.sakura.ne.jp
-- 生成日時: 2024 年 7 月 31 日 06:49
-- サーバのバージョン： 5.7.40-log
-- PHP のバージョン: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs1_pj1`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `admin`
--

CREATE TABLE `admin` (
  `id` int(6) NOT NULL,
  `hashed_id` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `timestamp` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `admin`
--

INSERT INTO `admin` (`id`, `hashed_id`, `username`, `password`, `timestamp`) VALUES
(1, '', '山田', '$2y$10$no2AMSwPJjhVF3k8vuacIuan/xA/jVf1GuW8s/MlCfrp6V6kShcNq', '2024-07-31 05:33:22.000000'),
(2, '', '山田', '$2y$10$x1v9v0I5zFqAPnasfeeOBufRXyrajlTst8fTXryU.h.azonOOOLZK', '2024-07-31 05:34:05.000000'),
(3, '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce', '1234', '$2y$10$P6P1WxRgH5exuZQWjMgLwejEbu2E4diPSWR3SFUFxuZZrCkgsu/Wq', '2024-07-31 05:53:56.000000');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `username` varchar(64) NOT NULL,
  `hashed_id` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `hashed_id`, `email`, `message`, `timestamp`) VALUES
(1, 'YO', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'ii@ddd', 'あいうえお', '2024-07-31 03:58:00.000000'),
(2, 'YO', 'd4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35', 'ii@ddd', 'あいうえお', '2024-07-31 04:05:00.000000'),
(3, 'YO', '4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce', 'ii@ddd', '2222', '2024-07-31 06:13:00.000000');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
