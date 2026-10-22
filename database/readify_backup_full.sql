-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: readify
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ai_recommendations`
--

DROP TABLE IF EXISTS `ai_recommendations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ai_recommendations` (
  `id_recommendation` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `recommended_books` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`recommended_books`)),
  `ai_reasoning` text DEFAULT NULL,
  `based_on_count` int(11) NOT NULL DEFAULT 0,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_recommendation`),
  KEY `ai_recommendations_id_pengguna_index` (`id_pengguna`),
  KEY `ai_recommendations_id_pengguna_is_active_index` (`id_pengguna`,`is_active`),
  KEY `ai_recommendations_generated_at_index` (`generated_at`),
  CONSTRAINT `ai_recommendations_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ai_recommendations`
--

LOCK TABLES `ai_recommendations` WRITE;
/*!40000 ALTER TABLE `ai_recommendations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ai_recommendations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anggota` (
  `id_anggota` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_anggota`),
  UNIQUE KEY `anggota_id_pengguna_unique` (`id_pengguna`),
  CONSTRAINT `anggota_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES (43,45,'Faiz Akhrian Putra','Griya Bukit Jaya','08998059878','2026-02-23 03:57:04','2026-02-23 03:57:04'),(44,46,'Dik','gbj','08953932749','2026-02-23 17:48:02','2026-02-23 17:48:02'),(45,49,'Adam Wahyu Utomo','Villas','089286532913','2026-02-26 04:30:29','2026-02-26 04:30:29'),(46,50,'Anggota Demo','Jl. Perpustakaan No. 1','081234567890','2026-10-19 23:50:07','2026-10-19 23:50:07'),(47,56,'Anggota Test Pengujian','Jl. Pengujian No. 123',NULL,'2026-10-20 01:48:15','2026-10-20 01:48:15'),(48,57,'Naufal Pratama','Jl. Kaliurang KM 5, Sleman','081223344551','2026-10-20 02:08:17','2026-10-20 02:08:17'),(49,58,'Zahra Aurelia','Jl. Gejayan No. 45, Depok','081334455662','2026-10-20 02:08:17','2026-10-20 02:08:17'),(50,59,'Rizky Hidayat','Jl. Malioboro No. 12, Danurejan','081556677883','2026-10-20 02:08:18','2026-10-20 02:08:18'),(51,60,'Alya Safira','Jl. Seturan Raya No. 88, Caturtunggal','081778899004','2026-10-20 02:08:18','2026-10-20 02:08:18'),(52,61,'Dimas Ardiansyah','Jl. Palagan KM 8, Ngaglik','081990011225','2026-10-20 02:08:18','2026-10-20 02:08:18'),(53,62,'Penguji Komunitas Satu','Jl. Komunitas No. 1','081234567891','2026-10-20 02:08:56','2026-10-20 02:08:56'),(54,63,'Penguji Komunitas Dua','Jl. Komunitas No. 2','081234567892','2026-10-20 02:08:56','2026-10-20 02:08:56');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sampul` varchar(255) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `jumlah_halaman` int(11) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `bahasa` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `sinopsis` text DEFAULT NULL,
  `lokasi_rak` varchar(50) DEFAULT NULL,
  `id_kategori` bigint(20) unsigned DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_buku`),
  KEY `buku_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `buku_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (11,'sampul/y2PddfbQPTJrPy6vLpv9D5HVpppuUtTm2RgvDUnm.jpg','978-6230-31516-9','Goodbye, Eri','Tatsuki Fujimoto','Gramedia',208,2022,'id',20,'<p>Yuta, seorang anak laki-laki yang mendokumentasikan hari-hari terakhir ibunya yang sakit atas permintaan sang ibu<span style=\"color: rgb(230, 232, 240); background-color: rgb(44, 48, 61);\">. Setelah ibunya meninggal, Yuta membuat film tentang kematian tersebut namun dikritik keras. Di titik terendah, ia bertemu gadis misterius bernama Eri yang membantunya membuat film baru, mengungkap batas antara kenyataan, memori, dan fiksi.</span><span style=\"color: rgb(230, 232, 240); background-color: rgb(31, 31, 31);\">&nbsp;</span></p>','Rak M-01',NULL,'2026-02-23 03:52:59','2026-10-20 01:07:36'),(13,'sampul/5dpkBFobFEMEt44sdnolS0lj722EU0WLGsUTL2sI.jpg','925-91826-2728-4','Steel Ball Run','Hirohiko Araki','Shueisha',213,2001,'en',34,'<p>a 19th-century, 6,000 km, cross-continental horse race across the U.S. with a $50 million prize<span style=\"background-color: rgb(31, 31, 31); color: rgb(230, 232, 240);\">. Paraplegic former jockey Johnny Joestar partners with Gyro Zeppeli to master the \"Spin\" technique, uncovering a conspiracy by President Funny Valentine to use the race to locate the scattered corpse of Jesus Christ.&nbsp;</span></p>','Rak M-01',NULL,'2026-02-23 07:42:06','2026-10-20 01:07:36'),(14,'sampul/oOpXHBH46HTxcLCfZ01YAMcf7d6SZMbcSUzBr3dC.jpg','978-92739-8383-1','Look Back','Tatsuki Fujimoto','Gramedia',224,2021,'id',40,'<p>persahabatan dua siswi, Fujino yang percaya diri dan Kyomoto yang tertutup, yang disatukan oleh gairah menggambar manga<span style=\"background-color: rgb(31, 31, 31); color: rgb(230, 232, 240);\">. Meskipun awalnya cemburu dengan bakat Kyomoto, Fujino terpacu untuk terus menggambar hingga mereka tumbuh bersama, menghadapi suka duka, dan kehilangan dalam mengejar impian.</span></p>','Rak M-01',NULL,'2026-02-23 07:46:31','2026-10-20 01:07:36'),(15,'sampul/ZBKwXKVahSADAtCsW8w8rqARoYLgBI7lhB9jmDcr.png','914-2-28263-02-17','Shangri-la Frontier','Katarina','Gramedia',157,2025,'en',94,'<p>follows Rakuro Hizutome, a teenager obsessed with playing flawed \"trash games\"<span style=\"color: rgb(230, 232, 240); background-color: rgb(44, 48, 61);\">. After mastering these buggy titles, he challenges himself with the top-tier VR game&nbsp;</span><em style=\"color: rgb(230, 232, 240); background-color: rgb(44, 48, 61);\">Shangri-La Frontier</em><span style=\"color: rgb(230, 232, 240); background-color: rgb(44, 48, 61);\">. Using his skills from broken games, he explores the vast world as the bird-masked Sunraku, tackling unique monsters and hidden, complex game mechanics.</span><span style=\"color: rgb(230, 232, 240); background-color: rgb(31, 31, 31);\">&nbsp;</span></p>','Rak M-01',NULL,'2026-02-23 07:49:25','2026-10-20 01:07:36'),(16,'sampul/2jvnIyjNEslylR27QOSJ1yfNYRQKxUOBJZHnpDnH.jpg','914-2-28263-02-1734','Chainsaw Man','Tatsuki Fujimoto','Gramedia',194,2019,'id',86,'<p><span style=\"color: rgb(58, 58, 58);\">Denji\'s a poor young man who\'ll do anything for money, even hunting down Devils with his pet devil-dog Pochita. He\'s a simple man with simple dreams, drowning under a mountain of debt. But his sad life gets turned upside down when he\'s betrayed by someone he trusts. Now with the power of a Devil inside him, Denji\'s become a whole new man-Chainsaw Man!</span></p>','Rak M-01',NULL,'2026-02-23 08:00:57','2026-10-20 01:07:36'),(17,'sampul/to-kill-a-mockingbird.jpg','9780061120084','To Kill a Mockingbird','Harper Lee','J. B. Lippincott & Co.',336,1960,'en',10,'Told through the eyes of young Scout Finch, whose lawyer father Atticus Finch defends a Black man falsely accused of raping a white woman in the racially segregated American South.','Rak E-02',NULL,'2026-02-23 08:03:31','2026-10-20 00:19:58'),(18,'sampul/pride-and-prejudice.jpg','9780141439518','Pride and Prejudice','Jane Austen','Penguin Classics',432,2003,'en',12,'A sparkling romantic comedy following lively Elizabeth Bennet as she deals with issues of upbringing, morality, and marriage in Regency-era England, clashing with the aloof Mr. Darcy.','Rak E-19',NULL,'2026-02-23 08:07:04','2026-10-20 00:24:06'),(19,'sampul/1984.jpg','9780451524935','1984','George Orwell','Secker & Warburg',328,1949,'en',10,'A dystopian masterpiece depicting Winston Smith living under the totalitarian regime of Oceania, where Big Brother watches every move and Thought Police suppresses individual freedom and rebellious thought.','Rak E-01',NULL,'2026-02-23 08:09:33','2026-10-20 00:19:49'),(20,'sampul/the-great-gatsby.jpg','9780743273565','The Great Gatsby','F. Scott Fitzgerald','Charles Scribner\'s Sons',180,1925,'en',11,'Set in the Roaring Twenties on Long Island, the story follows the mysterious millionaire Jay Gatsby and his quixotic passion for the beautiful Daisy Buchanan.','Rak E-02',NULL,'2026-02-23 08:13:54','2026-10-20 00:19:57'),(21,'sampul/the-catcher-in-the-rye.jpg','9780316769488','The Catcher in the Rye','J. D. Salinger','Little, Brown and Company',224,1951,'en',7,'The quintessential novel of teenage alienation and rebellion, following Holden Caulfield over three days in New York City after being expelled from his prep school.','Rak E-03',NULL,'2026-02-23 08:15:58','2026-10-20 00:20:01'),(22,'sampul/UT3jr0FzqaskveMC1eJlRP1MtP119QJNpGEYEcUX.jpg','978-0-553-17698-8','A Brief History of Time','Stephen Hawking','Gramedia',212,1988,NULL,67,'<p>Penjelasan konsep kosmologi untuk pembaca umum.</p>','Rak E-02',NULL,'2026-02-23 08:19:01','2026-10-20 01:07:36'),(23,'sampul/v3NYrDGa8pEOP0K2grGxr70qJWXulkyOsSMpRQDW.jpg','978-0-394-50245-0','Cosmos','Carl Sagan','Gramedia',400,1980,'id',26,'<p>Penjelajahan astronomi dan sejarah peradaban manusia.</p>','Rak E-02',NULL,'2026-02-23 08:21:01','2026-10-20 01:07:36'),(24,'sampul/y0qPyGPawGTxoevOORowzw5ZRs02ye6svE7o08Tf.jpg','978-0-7475-3269-9','Harry Potter and the Philosopher’s Stone','J.K Rowling','Gramedia',223,1997,'id',50,'<p>Harry menemukan dirinya penyihir dan masuk Hogwarts.</p>','Rak E-02',NULL,'2026-02-23 08:24:22','2026-10-20 01:07:36'),(25,'sampul/Tp1yVP0N0ywalALpXTXtAxPx2aVwZOO2ziWF4Pax.jpg','978-4-09-123456-7','Detective Conan','Aoyama Gosho','Gramedia',190,1995,'id',70,'<p>Shinichi Kudo berubah jadi anak kecil dan memecahkan misteri kasus kriminal.</p>','Rak M-01',NULL,'2026-02-23 08:27:34','2026-10-20 01:07:36'),(141,'sampul/one-piece-vol-1-romance-dawn.jpg','9781569319017','One Piece, Vol. 1: Romance Dawn','Eiichiro Oda','Shueisha',216,1997,'ja',12,'Kisah awal Monkey D. Luffy, pemuda bertubuh lentur yang bermimpi menjadi Raja Bajak Laut. Terinspirasi oleh Shanks si Rambut Merah, Luffy memulai petualangannya mengarungi Grand Line untuk mencari harta karun legendaris One Piece.','Rak M-01',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(142,'sampul/naruto-vol-1-uzumaki-naruto.jpg','9781569319000','Naruto, Vol. 1: Uzumaki Naruto','Masashi Kishimoto','Shueisha',192,1999,'ja',10,'Naruto Uzumaki adalah seorang ninja yatim piatu yang nakal dan dikucilkan oleh penduduk desa Konoha karena menyimpan monster Rubah Ekor Sembilan di dalam tubuhnya. Naruto bertekad membuktikan kemampuannya untuk menjadi Hokage.','Rak M-01',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(143,'sampul/bleach-vol-1-the-strawberry-and-the-soul-reapers.jpg','9781591164418','Bleach, Vol. 1: The Strawberry and the Soul Reapers','Tite Kubo','Shueisha',192,2001,'ja',8,'Ichigo Kurosaki adalah siswa SMA berusia 15 tahun yang mampu melihat roh. Hidupnya berubah drastis saat ia bertemu Rukia Kuchiki, seorang Shinigami (Dewa Kematian), dan terpaksa mengambil alih kekuatan Shinigami untuk melindungi keluarganya dari serangan Hollow.','Rak M-01',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(144,'sampul/attack-on-titan-vol-1.jpg','9781612620244','Attack on Titan, Vol. 1','Hajime Isayama','Kodansha',200,2010,'ja',9,'Manusia hidup dalam kepungan tiga lapis tembok raksasa untuk berlindung dari Titan, monster raksasa pemakan manusia. Saat Tembok Maria dihancurkan oleh Titan Kolosal, Eren Yeager bersumpah membasmi seluruh Titan setelah menyaksikan ibunya dimangsa.','Rak M-02',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(145,'sampul/jujutsu-kaisen-vol-1-ryomen-sukuna.jpg','9781974710027','Jujutsu Kaisen, Vol. 1: Ryomen Sukuna','Gege Akutami','Shueisha',192,2018,'ja',11,'Yuji Itadori adalah siswa SMA dengan kekuatan fisik luar biasa. Demi menyelamatkan temannya dari serangan roh kutukan, Yuji menelan jari terkutuk milik Raja Kutukan, Ryomen Sukuna, dan terseret ke dunia berbahaya para penyihir Jujutsu.','Rak M-02',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(146,'sampul/demon-slayer-kimetsu-no-yaiba-vol-1-cruelty.jpg','9781974700523','Demon Slayer: Kimetsu no Yaiba, Vol. 1: Cruelty','Koyoharu Gotouge','Shueisha',192,2016,'ja',14,'Tanjiro Kamado menemukan keluarganya dibantai oleh iblis saat ia pergi menjual arang. Satu-satunya adiknya yang selamat, Nezuko, telah berubah menjadi iblis. Tanjiro bergabung dengan Korps Pembasmi Iblis demi mencari penawar untuk mengembalikan Nezuko menjadi manusia.','Rak M-02',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(147,'sampul/my-hero-academia-vol-1-izuku-midoriya-origin.jpg','9781421582696','My Hero Academia, Vol. 1: Izuku Midoriya: Origin','Kohei Horikoshi','Shueisha',192,2014,'ja',10,'Di dunia tempat 80% populasi memiliki Quirk (kekuatan super), Izuku Midoriya terlahir tanpa Quirk sama sekali. Namun takdirnya berubah saat pahlawan nomor satu, All Might, melihat jiwa kepahlawanan sejati dalam diri Midoriya.','Rak M-03',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(148,'sampul/death-note-vol-1-boredom.jpg','9781421501680','Death Note, Vol. 1: Boredom','Tsugumi Ohba & Takeshi Obata','Shueisha',200,2003,'ja',7,'Light Yagami, siswa jenius yang bosan dengan kebusukan dunia, menemukan buku catatan supernatural milik Shinigami Ryuk. Setiap orang yang namanya ditulis di dalam buku tersebut akan mati. Pertarungan intelek epik dimulai saat detektif misterius \"L\" mulai memburunya.','Rak M-03',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(149,'sampul/fullmetal-alchemist-vol-1.jpg','9781591169208','Fullmetal Alchemist, Vol. 1','Hiromu Arakawa','Square Enix',192,2002,'ja',9,'Edward dan Alphonse Elric melanggar tabu terbesar alkimia: transmutasi manusia untuk menghidupkan kembali ibu mereka. Akibatnya, Edward kehilangan kaki dan tangan, sedangkan jiwa Alphonse terperangkap dalam baju zirah besi. Mereka memulai misi mencari Batu Bertuah untuk memulihkan tubuh mereka.','Rak M-03',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(150,'sampul/hunter-x-hunter-vol-1-the-day-of-departure.jpg','9781591167532','Hunter x Hunter, Vol. 1: The Day of Departure','Yoshihiro Togashi','Shueisha',192,1998,'ja',8,'Gon Freecss meninggalkan Pulau Paus demi mengikuti Ujian Hunter yang terkenal mematikan. Tujuannya adalah mencari sang ayah, Ging, seorang Hunter legendaris yang meninggalkannya sejak kecil. Bersama Kurapika, Leorio, dan Killua, petualangan penuh strategi dimulai.','Rak M-04',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(151,'sampul/berserk-vol-1-the-black-swordsman.jpg','9781593070205','Berserk, Vol. 1: The Black Swordsman','Kentaro Miura','Hakusensha',224,1990,'ja',6,'Mahakarya dark fantasy legendaris yang menceritakan Guts, Pendekar Pedang Hitam bertangan meriam baja dan berpedang raksasa Dragon Slayer. Guts menjelajahi dunia abad pertengahan yang kelam untuk membalas dendam pada monster pemangsa jiwa dan para God Hand.','Rak M-04',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(152,'sampul/vagabond-vol-1.jpg','9781421519210','Vagabond, Vol. 1','Takehiko Inoue','Kodansha',256,1998,'ja',7,'Diadaptasi dari novel epik Eiji Yoshikawa, manga ini mengisahkan perjalanan hidup Shinmen Takezo yang kelak dikenal sebagai Miyamoto Musashi, pendekar pedang terbesar dalam sejarah Jepang, dalam pencarian arti sejati dari kekuatan dan takdir.','Rak M-04',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(153,'sampul/slam-dunk-vol-1.jpg','9781421506791','Slam Dunk, Vol. 1','Takehiko Inoue','Shueisha',192,1990,'ja',11,'Hanamichi Sakuragi, pemuda berandal berambut merah yang sering ditolak wanita, bergabung dengan klub basket SMA Shohoku demi memikat hati Haruko Akagi. Siapa sangka, bakat alami dan semangat pantang menyerahnya menjadikannya andalan tim.','Rak M-05',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(154,'sampul/haikyu-vol-1-hinata-and-kageyama.jpg','9781421587660','Haikyu!!, Vol. 1: Hinata and Kageyama','Haruichi Furudate','Shueisha',192,2012,'ja',10,'Shoyo Hinata memiliki tubuh pendek tetapi bermimpi menjadi pemain voli hebat seperti idolanya \"Raksasa Kecil\". Di SMA Karasuno, ia terpaksa bertandem dengan rival bebuyutannya, setter jenius Tobio Kageyama, menciptakan serangan cepat yang mengejutkan Jepang.','Rak M-05',NULL,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(155,'sampul/pluto-urasawa-x-tezuka-vol-1.jpg','9781421519180','Pluto: Urasawa x Tezuka, Vol. 1','Naoki Urasawa & Osamu Tezuka','VIZ Media LLC',200,2009,'ja',12,'Di dunia ideal tempat manusia dan robot hidup berdampingan, robot raksasa penjaga Swiss, Montblanc, dihancurkan secara misterius. Detektif Europol bernama Gesicht menyelidiki rentetan pembunuhan yang menargetkan tujuh robot tercanggih di dunia.','Rak M-05',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(156,'sampul/spy-x-family-vol-1.jpg','9781974715466','Spy x Family, Vol. 1','Tatsuya Endo','Shueisha',216,2019,'ja',15,'Mata-mata ulung \"Twilight\" harus menyamar sebagai Loid Forger dan membangun keluarga palsu demi misi perdamaian dunia. Tanpa ia ketahui, istri yang ia nikahi adalah pembunuh bayaran ulung, dan anak perempuan yang ia adopsi adalah pembaca pikiran telepatis.','Rak M-06',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(157,'sampul/tokyo-ghoul-vol-1.jpg','9781421580364','Tokyo Ghoul, Vol. 1','Sui Ishida','Shueisha',224,2011,'ja',9,'Ken Kaneki, seorang mahasiswa pendiam, nyaris tewas setelah kencannya ternyata adalah Ghoul, makhluk pemangsa daging manusia. Setelah operasi transplantasi organ darurat, Kaneki terbangun sebagai separuh manusia dan separuh Ghoul.','Rak M-06',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(158,'sampul/vinland-saga-vol-1.jpg','9781612624204','Vinland Saga, Vol. 1','Makoto Yukimura','Kodansha',468,2005,'ja',8,'Thorfinn tumbuh di antara tentara bayaran Viking yang membunuh ayahnya. Ia bersumpah membalas dendam kepada sang pemimpin Askeladd dalam duel terhormat. Berlatar perang Viking di Inggris abad ke-11, inilah kisah pencarian tanah damai Vinland.','Rak M-06',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(159,'sampul/monster-the-perfect-edition-vol-1.jpg','9781421569062','Monster: The Perfect Edition, Vol. 1','Naoki Urasawa','Shogakukan',424,1994,'ja',7,'Dr. Kenzo Tenma, ahli bedah saraf brilian di Jerman Barat, memilih menyelamatkan nyawa seorang anak laki-laki ketimbang wali kota kota Düsseldorf. Sembilan tahun kemudian, anak itu tumbuh menjadi psikopat dingin tak berperasaan bernama Johan Liebert.','Rak M-07',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(160,'sampul/20th-century-boys-the-perfect-edition-vol-1.jpg','9781421599618','20th Century Boys: The Perfect Edition, Vol. 1','Naoki Urasawa','Shogakukan',416,1999,'ja',6,'Kenji Endo menemukan bahwa rangkaian bencana biologis dan teror misterius yang mengguncang Tokyo sama persis dengan skenario kehancuran dunia yang ia dan teman-temannya tulis di buku catatan masa kecil pada tahun 1969.','Rak M-07',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(161,'sampul/jojos-bizarre-adventure-part-1-phantom-blood-vol-1.jpg','9781421578798','JoJo\'s Bizarre Adventure: Part 1--Phantom Blood, Vol. 1','Hirohiko Araki','Shueisha',256,1987,'ja',8,'Inggris abad ke-19, Jonathan Joestar tumbuh bersama saudara angkatnya, Dio Brando yang haus kekuasaan. Saat Dio menemukan topeng batu Aztec yang mengubahnya menjadi vampir abadi, Jonathan harus menguasai teknik energi pernapasan Hamon.','Rak M-07',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(162,'sampul/dragon-ball-vol-1-the-monkey-king.jpg','9781569319208','Dragon Ball, Vol. 1: The Monkey King','Akira Toriyama','Shueisha',192,1984,'ja',12,'Awal mula kisah legendaris Son Goku, bocah berekor kera bertenaga luar biasa yang tinggal sendirian di gunung. Pertemuannya dengan Bulma membawanya berkelana mencari tujuh bola naga ajaib yang konon dapat mengabulkan segala permohonan.','Rak M-08',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(163,'sampul/dragon-ball-z-vol-1.jpg','9781569319307','Dragon Ball Z, Vol. 1','Akira Toriyama','Shueisha',192,1989,'ja',10,'Goku kini telah berkeluarga dan memiliki putra bernama Gohan. Kedatangan bangsa Saiyan ke bumi mengungkap asal-usul sejati Goku sebagai Kakarot, memicu pertempuran antargalaksi terbesar demi menyelamatkan kelangsungan umat manusia.','Rak M-08',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(164,'sampul/one-punch-man-vol-1.jpg','9781421585642','One-Punch Man, Vol. 1','ONE & Yusuke Murata','Shueisha',200,2012,'ja',11,'Saitama menjadi pahlawan hanya untuk bersenang-senang setelah berlatih keras hingga rambutnya rontok. Masalahnya, ia menjadi terlampau kuat sehingga setiap musuh dan monster terkuat sekalipun selalu musnah hanya dengan satu pukulan.','Rak M-08',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(165,'sampul/mob-psycho-100-vol-1.jpg','9781506708782','Mob Psycho 100, Vol. 1','ONE','Shogakukan',200,2012,'ja',8,'Shigeo Kageyama alias \"Mob\" adalah siswa SMP canggung yang sebenarnya merupakan cenayang esper terkuat di dunia. Ia menahan emosinya agar kekuatannya tidak lepas kendali, tetapi jika emosinya mencapai 100%, malapetaka tak terelakkan.','Rak M-09',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(166,'sampul/blue-lock-vol-1.jpg','9781646516544','Blue Lock, Vol. 1','Muneyuki Kaneshiro & Yusuke Nomura','Kodansha',208,2018,'ja',12,'Setelah kegagalan timnas Jepang di Piala Dunia, Asosiasi Sepak Bola Jepang mengumpulkan 300 striker muda terbaik dalam fasilitas isolasi ketat bernama Blue Lock untuk menciptakan satu penyerang paling egois dan haus gol di dunia.','Rak M-09',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(167,'sampul/black-clover-vol-1-the-boys-vow.jpg','9781421587189','Black Clover, Vol. 1: The Boy\'s Vow','Yuki Tabata','Shueisha',192,2015,'ja',9,'Asta terlahir tanpa setitik pun sihir di dunia di mana sihir adalah segalanya. Namun saat sahabatnya Yuno menerima grimoire daun semanggi empat yang legendaris, Asta justru mendapatkan grimoire daun lima dengan pedang Anti-Sihir.','Rak M-09',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(168,'sampul/dr-stone-vol-1-stone-world.jpg','9781974702619','Dr. STONE, Vol. 1: Stone World','Riichiro Inagaki & Boichi','Shueisha',192,2017,'ja',10,'Cahaya misterius membatu seluruh umat manusia selama ribuan tahun. Siswa SMA jenius Senku Ishigami terbangun di era batu modern dan bertekad membangun kembali peradaban manusia dari nol menggunakan kekuatan ilmu pengetahuan dan sains.','Rak M-10',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(169,'sampul/the-promised-neverland-vol-1-grace-field-house.jpg','9781421597126','The Promised Neverland, Vol. 1: Grace Field House','Kaiu Shirai & Posuka Demizu','Shueisha',192,2016,'ja',8,'Emma, Norman, dan Ray hidup bahagia di panti asuhan Grace Field House bersama pengasuh penuh kasih yang mereka sebut \"Mama\". Namun saat menemukan kebenaran mengerikan bahwa panti asuhan itu adalah peternakan makanan bagi iblis, mereka merancang rencana pelarian.','Rak M-10',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(170,'sampul/fairy-tail-vol-1.jpg','9781612622767','Fairy Tail, Vol. 1','Hiro Mashima','Kodansha',208,2006,'ja',9,'Lucy Heartfilia, seorang penyihir celestial, bermimpi bergabung dengan Fairy Tail, guild penyihir paling terkenal sekaligus paling suka berbuat onar. Pertemuannya dengan Natsu Dragneel, penyihir api pembunuh naga, memulai petualangan serunya.','Rak M-10',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(171,'sampul/gintama-vol-1.jpg','9781421513584','Gintama, Vol. 1','Hideaki Sorachi','Shueisha',200,2003,'ja',7,'Di era Edo alternatif ketika alien Amanto telah menaklukkan Jepang dan melarang membawa pedang, samurai eksentrik berambut perak Gintoki Sakata menjalankan usaha serabutan \"Yorozuya\" bersama Shinpachi dan Kagura untuk membayar sewa rumah.','Rak M-11',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(172,'sampul/rurouni-kenshin-vol-1.jpg','9781591162209','Rurouni Kenshin, Vol. 1','Nobuhiro Watsuki','Shueisha',208,1994,'ja',9,'Kenshin Himura adalah mantan pembunuh legendaris \"Hitokiri Battousai\" di era restorasi Meiji. Menyesali masa lalunya yang berlumur darah, ia mengembara membawa pedang bermata terbalik (Sakabato) bersumpah tidak akan pernah membunuh lagi.','Rak M-11',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(173,'sampul/yu-yu-hakusho-vol-1-goodbye-material-world.jpg','9781591160816','Yu Yu Hakusho, Vol. 1: Goodbye, Material World!','Yoshihiro Togashi','Shueisha',200,1990,'ja',8,'Yusuke Urameshi, berandal jalanan berusia 14 tahun, tewas seketika saat menyelamatkan seorang bocah dari tabrakan mobil. Dunia akhirat terkejut atas tindakan mulianya dan memberinya kesempatan hidup kembali sebagai Detektif Roh.','Rak M-11',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(174,'sampul/neon-genesis-evangelion-vol-1.jpg','9781569312940','Neon Genesis Evangelion, Vol. 1','Yoshiyuki Sadamoto','Kadokawa Shoten',184,1995,'ja',7,'Tahun 2015, bumi di ambang kepunahan akibat serangan monster raksasa Angel. Shinji Ikari dipanggil ayahnya ke markas rahasia NERV untuk menjadi pilot robot biomekanik raksasa Evangelion Unit-01 demi menyelamatkan sisa kemanusiaan.','Rak M-12',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(175,'sampul/cowboy-bebop-vol-1.jpg','9781591829027','Cowboy Bebop, Vol. 1','Hajime Yatate & Yutaka Nanten','Kadokawa Shoten',192,1998,'ja',6,'Tahun 2071, para pemburu hadiah luar angkasa (Cowboy) Spike Spiegel dan Jet Black menjelajahi tata surya menggunakan kapal Bebop untuk memburu buronan berbahaya sambil terus dihantui masa lalu mereka.','Rak M-12',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(176,'sampul/akira-vol-1.jpg','9781935429005','Akira, Vol. 1','Katsuhiro Otomo','Kodansha',360,1982,'ja',8,'Mahakarya cyberpunk revolusioner berlatar Neo-Tokyo tahun 2019 setelah Perang Dunia III. Kaneda memimpin geng motor jalanan dan harus berhadapan dengan sahabatnya sendiri, Tetsuo, yang memperoleh kekuatan psikis dahsyat tak terkendali.','Rak M-12',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(177,'sampul/the-ghost-in-the-shell-vol-1.jpg','9781612629766','The Ghost in the Shell, Vol. 1','Masamune Shirow','Kodansha',368,1991,'ja',7,'Mayor Motoko Kusanagi, agen sibernetik di Public Security Section 9, memburu peretas misterius \"Puppet Master\" yang mampu meretas pikiran manusia di dunia masa depan yang terhubung secara digital.','Rak M-13',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(178,'sampul/solo-leveling-vol-1.jpg','9781975319434','Solo Leveling, Vol. 1','Chugong & DUBU','D&C Media',320,2018,'ja',15,'Sung Jin-Woo dikenal sebagai Hunter terlemah di dunia level E. Namun setelah selamat dari ruang bawah tanah ganda misterius, Jin-Woo mendapatkan antarmuka quest layaknya game RPG yang memungkinkannya meningkatkan kekuatannya tanpa batas.','Rak M-13',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(179,'sampul/frieren-beyond-journeys-end-vol-1.jpg','9781974725762','Frieren: Beyond Journey\'s End, Vol. 1','Kanehito Yamada & Tsukasa Abe','Shogakukan',192,2020,'ja',14,'Setelah kelompok pahlawan berhasil mengalahkan Raja Iblis, penyihir elf Frieren yang berumur ribuan tahun menyaksikan rekan-rekan manusianya menua dan meninggal. Ia memulai perjalanan baru untuk lebih memahami arti ikatan dengan manusia.','Rak M-13',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(180,'sampul/oshi-no-ko-vol-1.jpg','9781975363178','Oshi no Ko, Vol. 1','Aka Akasaka & Mengo Yokoyari','Shueisha',216,2020,'ja',11,'Goro Amemiya, dokter kandungan penggemar berat idol Ai Hoshino, tewas dibunuh dan terlahir kembali sebagai putra kembar sang idol bernama Aquamarine. Kehidupan glamor industri hiburan Jepang ternyata menyimpan sisi kelam penuh kebohongan.','Rak M-14',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(181,'sampul/kaguya-sama-love-is-war-vol-1.jpg','9781974700301','Kaguya-sama: Love Is War, Vol. 1','Aka Akasaka','Shueisha',208,2015,'ja',9,'Kaguya Shinomiya dan Miyuki Shirogane adalah dua siswa elit jenius di OSIS Akademi Shuchiin yang saling menyukai. Namun karena harga diri yang teramat tinggi, keduanya menolak menyatakan cinta duluan dan saling menjebak agar lawan yang mengaku terlebih dahulu.','Rak M-14',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(182,'sampul/dandadan-vol-1.jpg','9781974734634','Dandadan, Vol. 1','Yukinobu Tatsu','Shueisha',208,2021,'ja',13,'Momo Ayase percaya hantu tapi tidak percaya alien, sedangkan Okarun percaya alien tapi menolak keberadaan hantu. Keduanya bertaruh mengunjungi tempat angker masing-masing dan mendapati bahwa hantu dan alien ternyata sama-sama nyata!','Rak M-14',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(183,'sampul/kaiju-no-8-vol-1.jpg','9781974725984','Kaiju No. 8, Vol. 1','Naoya Matsumoto','Shueisha',208,2020,'ja',12,'Kafka Hibino berusia 32 tahun yang bekerja sebagai petugas pembersih bangkai monster (Kaiju). Suatu hari seekor parasit monster masuk ke dalam tubuhnya dan memberinya kemampuan berubah menjadi Kaiju terkuat dengan kode Kaiju No. 8.','Rak M-15',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(184,'sampul/sakamoto-days-vol-1-the-legendary-hitman.jpg','9781974728947','Sakamoto Days, Vol. 1: The Legendary Hitman','Yuto Suzuki','Shueisha',192,2020,'ja',10,'Taro Sakamoto dulunya adalah pembunuh bayaran legendaris paling ditakuti. Namun setelah jatuh cinta, ia pensiun, menikah, bertambah gemuk, dan mengelola minimarket keluarga. Masa lalunya terus mengejarnya, memaksanya melindungi keluarganya tanpa membunuh.','Rak M-15',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(185,'sampul/mashle-magic-and-muscles-vol-1.jpg','9781974719297','Mashle: Magic and Muscles, Vol. 1','Hajime Komoto','Shueisha',216,2020,'ja',9,'Di dunia tempat sihir menentukan status sosial, Mash Burnedead lahir tanpa sihir. Namun dengan latihan otot yang gila-gilaan setiap hari, Mash sanggup menangkis sihir terkuat hanya dengan kekuatan tinju mentah dan kecintaannya pada kue sus.','Rak M-15',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(186,'sampul/hells-paradise-jigokuraku-vol-1.jpg','9781974713202','Hell\'s Paradise: Jigokuraku, Vol. 1','Yuji Kaku','Shueisha',208,2018,'ja',8,'Ninja terkuat Gabimaru si Hampa dijatuhi hukuman mati namun tak ada senjata yang bisa menembus tubuhnya. Ia diberi kesempatan pengampunan jika bersedia pergi ke pulau misterius Shinsenkyo untuk mengambil ramuan keabadian.','Rak M-16',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(187,'sampul/tokyo-revengers-vol-1.jpg','9781646512485','Tokyo Revengers, Vol. 1','Ken Wakui','Kodansha',192,2017,'ja',11,'Takemichi Hanagaki adalah pemuda pecundang berusia 26 tahun. Saat mengetahui cinta pertamanya di SMP, Hinata Tachibana, tewas dibunuh geng Tokyo Manji, Takemichi terlempar 12 tahun ke masa lalu dan bersumpah mendaki puncak geng berandal untuk mengubah masa depan.','Rak M-16',NULL,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(188,'sampul/blue-exorcist-vol-1.jpg','9781421540320','Blue Exorcist, Vol. 1','Kazue Kato','Shueisha',200,2009,'ja',8,'Rin Okumura dibesarkan oleh Pendeta Shiro Fujimoto. Suatu hari ia terkejut mengetahui bahwa dirinya adalah putra kandung Setan. Setelah kematian ayah angkatnya, Rin masuk Akademi Salib Sejati untuk menjadi Exorcist dan membalas dendam pada Setan.','Rak M-16',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(189,'sampul/dgray-man-vol-1.jpg','9781421506234','D.Gray-man, Vol. 1','Katsura Hoshino','Shueisha',208,2004,'ja',7,'Allen Walker adalah pemuda pengusir iblis (Exorcist) berlengan terkutuk yang bergabung dengan Black Order untuk membebaskan jiwa-jiwa menderita yang dijadikan senjata Akuma oleh sosok jahat Millennium Earl.','Rak M-17',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(190,'sampul/soul-eater-vol-1.jpg','9780316071055','Soul Eater, Vol. 1','Atsushi Ohkubo','Square Enix',208,2004,'ja',9,'Di Akademi Meister Senjata Shinigami (DWMA), Maka Albarn dan senjatanya yang bisa berubah wujud, Soul Eater, berusaha mengumpulkan 99 jiwa jahat dan 1 jiwa penyihir agar Soul dapat berevolusi menjadi Death Scythe milik Dewa Kematian.','Rak M-17',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(191,'sampul/fire-force-vol-1.jpg','9781632363305','Fire Force, Vol. 1','Atsushi Ohkubo','Kodansha',208,2015,'ja',9,'Tokyo era surya mengalami fenomena aneh di mana manusia tiba-tiba terbakar spontan menjadi monster berapi \"Infernals\". Shinra Kusakabe, pemuda yang mampu mengeluarkan api dari kakinya, bergabung dengan Special Fire Force Kompi 8.','Rak M-17',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(192,'sampul/noragami-stray-god-vol-1.jpg','9781612629063','Noragami: Stray God, Vol. 1','Adachitoka','Kodansha',200,2011,'ja',8,'Yato adalah dewa jalanan miskin tanpa kuil yang menerima segala pekerjaan serabutan hanya dengan imbalan koin 5 yen. Hidupnya berubah setelah siswi SMA Hiyori Iki menyelamatkannya dari kecelakaan, membuat jiwa Hiyori sering terlepas dari tubuhnya.','Rak M-18',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(193,'sampul/bungo-stray-dogs-vol-1.jpg','9780316554701','Bungo Stray Dogs, Vol. 1','Kafka Asagiri & Sango Harukawa','Kadokawa Shoten',200,2012,'ja',10,'Atsushi Nakajima diusir dari panti asuhannya dan tanpa sengaja menyelamatkan Osamu Dazai yang sedang mencoba bunuh diri di sungai. Atsushi kemudian direkrut ke Agensi Detektif Bersenjata, kelompok orang-orang berkekuatan supernatural bertema sastrawan dunia.','Rak M-18',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(194,'sampul/great-teacher-onizuka-gto-vol-1.jpg','9781931514934','Great Teacher Onizuka (GTO), Vol. 1','Tohru Fujisawa','Kodansha',208,1997,'ja',7,'Eikichi Onizuka, mantan pemimpin geng motor berusia 22 tahun, memiliki impian baru: menjadi guru terhebat di Jepang. Ia ditempatkan menjadi wali kelas Kelas 3-4 di SMP Meibi, kelas bermasalah yang gemar membuat guru-guru sebelumnya mengalami gangguan mental.','Rak M-18',NULL,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(195,'sampul/the-count-of-monte-cristo.jpg','9780140449266','The Count of Monte Cristo','Alexandre Dumas','Penguin Classics',1276,2003,'en',10,'Falsely accused of treason, Edmond Dantes is imprisoned in the grim Chateau d If. After fourteen years, he escapes, acquires a vast hidden fortune on the island of Monte Cristo, and exacts calculated revenge upon those who betrayed him.','Rak E-01',NULL,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(196,'sampul/animal-farm.jpg','9780451526342','Animal Farm','George Orwell','Secker & Warburg',140,1945,'en',12,'A political allegory in which farm animals overthrow their human master hoping to create a society of equal beings, only for the pigs led by Napoleon to become just as corrupt as the humans they displaced.','Rak E-01',NULL,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(197,'sampul/brave-new-world.jpg','9780060850524','Brave New World','Aldous Huxley','Chatto & Windus',288,1932,'en',8,'A prophetic vision of a future world state where citizens are genetically engineered, conditioned to conform, and pacified by a synthetic pleasure drug called soma in exchange for true freedom.','Rak E-01',NULL,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(198,'sampul/fahrenheit-451.jpg','9781451673319','Fahrenheit 451','Ray Bradbury','Ballantine Books',256,1953,'en',9,'Guy Montag is a fireman whose job is not to extinguish fires, but to burn banned books in a society where independent thought is outlawed and mindless entertainment is enforced.','Rak E-02',NULL,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(199,'sampul/the-grapes-of-wrath.jpg','9780143039433','The Grapes of Wrath','John Steinbeck','Penguin Classics',464,2006,'en',11,'A monumental portrait of the conflict between the powerful and the powerless, following the Joad family as they are forced off their Oklahoma farm during the Great Depression and journey west in search of dignity.','Rak E-02',NULL,'2026-10-20 00:30:13','2026-10-20 00:30:13'),(200,'sampul/one-hundred-years-of-solitude.jpg','9780060883287','One Hundred Years of Solitude','Gabriel García Márquez','Harper Perennial Modern Classics',417,2006,'en',10,'The brilliant masterwork telling the story of seven generations of the Buendia family and the rise and fall of the mythical Colombian town of Macondo, blending magical realism with tragic Latin American history.','Rak E-02',NULL,'2026-10-20 00:30:15','2026-10-20 00:30:15'),(201,'sampul/slaughterhouse-five.jpg','9780440180296','Slaughterhouse-Five','Kurt Vonnegut','Dial Press',275,1999,'en',7,'Centered on the infamous firebombing of Dresden in World War II, the odyssey of Billy Pilgrim explores trauma, war, and humanity through non-linear time travel and alien encounters.','Rak E-03',NULL,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(202,'sampul/lord-of-the-flies.jpg','9780399501487','Lord of the Flies','William Golding','Faber and Faber',224,1954,'en',8,'A group of British schoolboys stranded on an uninhabited tropical island attempt to govern themselves, with disastrous and savage results as order collapses into primal barbarism.','Rak E-03',NULL,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(203,'sampul/the-hobbit.jpg','9780547928227','The Hobbit','J.R.R. Tolkien','George Allen & Unwin',310,1937,'en',12,'Bilbo Baggins, a peace-loving hobbit, is whisked away into an epic quest by the wizard Gandalf and thirteen dwarves to reclaim the Lonely Mountain and its treasure from the dragon Smaug.','Rak E-03',NULL,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(204,'sampul/the-fellowship-of-the-ring.jpg','9780547928210','The Fellowship of the Ring','J.R.R. Tolkien','George Allen & Unwin',432,1954,'en',10,'The first volume of The Lord of the Rings. Young hobbit Frodo Baggins inherits the One Ring of Sauron and sets out on an arduous journey across Middle-earth to destroy it in Mount Doom.','Rak E-04',NULL,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(205,'sampul/the-two-towers.jpg','9780547928203','The Two Towers','J.R.R. Tolkien','George Allen & Unwin',352,1954,'en',9,'The Fellowship is fractured: Frodo and Sam journey toward Mordor with Gollum trailing them, while Aragorn, Legolas, and Gimli aid Rohan in its battle against Saruman.','Rak E-04',NULL,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(206,'sampul/the-return-of-the-king.jpg','9780547928197','The Return of the King','J.R.R. Tolkien','George Allen & Unwin',448,1955,'en',9,'The epic conclusion of The Lord of the Rings as the great War of the Ring culminates at the gates of Mordor and Aragorn assumes his rightful crown as King of Gondor.','Rak E-04',NULL,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(207,'sampul/the-kite-runner.jpg','9781594631931','The Kite Runner','Khaled Hosseini','Riverhead Books',371,2004,'en',15,'An epic story of an unlikely friendship between a wealthy boy and the son of his father s servant in Kabul, torn apart by tragedy, cowardice, and the devastating turmoil of Afghanistan s modern history.','Rak E-05',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(208,'sampul/harry-potter-and-the-prisoner-of-azkaban.jpg','9780439136365','Harry Potter and the Prisoner of Azkaban','J.K. Rowling','Scholastic',435,1999,'en',11,'Dangerous escapee Sirius Black is on the loose from the wizard prison of Azkaban, and the dreaded Dementors are stationed at Hogwarts, threatening Harry Potter.','Rak E-05',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(209,'sampul/a-game-of-thrones.jpg','9780553103540','A Game of Thrones','George R.R. Martin','Bantam Spectra',694,1996,'en',10,'The noble houses of Westeros plot, battle, and betray one another for the Iron Throne, unaware of the ancient supernatural menace awakening beyond the icy Wall in the far north.','Rak E-05',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(210,'sampul/a-clash-of-kings.jpg','9780553108033','A Clash of Kings','George R.R. Martin','Bantam Spectra',768,1998,'en',8,'Five kings vie for dominion across a war-torn continent, as comets streak across the sky, prophecy takes hold, and Daenerys Targaryen leads her newborn dragons across the red waste.','Rak E-06',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(211,'sampul/dune.jpg','9780441172719','Dune','Frank Herbert','Chilton Books',412,1965,'en',14,'Young Paul Atreides travels with his family to rule Arrakis, a harsh desert planet that is the universe only source of the spice melange, where he will fulfill a galactic prophecy.','Rak E-06',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(212,'sampul/dune-messiah.jpg','9780441172696','Dune Messiah','Frank Herbert','Putnam',256,1969,'en',8,'Twelve years after becoming Emperor, Paul Muad Dib faces political conspiracies and moral dilemmas as the devastating jihad fought in his name sweeps across billions of lives.','Rak E-06',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(213,'sampul/the-hitchhikers-guide-to-the-galaxy.jpg','9780345391803','The Hitchhiker\'s Guide to the Galaxy','Douglas Adams','Pan Books',216,1979,'en',9,'Seconds before Earth is demolished to make way for a galactic freeway, Arthur Dent is plucked into outer space by his alien friend Ford Prefect with nothing but a towel.','Rak E-07',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(214,'sampul/foundation.jpg','9780553293357','Foundation','Isaac Asimov','Gnome Press',244,1951,'en',9,'Psychohistorian Hari Seldon mathematically predicts the inevitable fall of the Galactic Empire and creates the Foundation at the edge of the galaxy to shorten the dark age to a single millennium.','Rak E-07',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(215,'sampul/i-robot.jpg','9780553382563','I, Robot','Isaac Asimov','Gnome Press',256,1950,'en',7,'A visionary collection of nine interconnected science fiction stories exploring humanity interaction with artificial intelligence governed by the Three Laws of Robotics.','Rak E-07',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(216,'sampul/neuromancer.jpg','9780441569595','Neuromancer','William Gibson','Ace',271,1984,'en',8,'The definitive cyberpunk novel that coined cyberspace, following washed-up computer hacker Case as he is hired for one ultimate corporate digital heist by a mysterious employer.','Rak E-08',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(217,'sampul/do-androids-dream-of-electric-sheep.jpg','9780345404473','Do Androids Dream of Electric Sheep?','Philip K. Dick','Doubleday',210,1968,'en',7,'The literary inspiration for Blade Runner. Bounty hunter Rick Deckard stalks rogue androids nearly indistinguishable from human beings across a post-apocalyptic, radiation-dusted San Francisco.','Rak E-08',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(218,'sampul/the-name-of-the-wind.jpg','9780756404741','The Name of the Wind','Patrick Rothfuss','DAW Books',662,2007,'en',9,'The first-person autobiography of Kvothe, a legendary prodigy musician, arcanist, and adventurer, recounting his childhood with a traveling troupe and his admission to the renowned University.','Rak E-08',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(219,'sampul/the-way-of-kings.jpg','9780765326355','The Way of Kings','Brandon Sanderson','Tor Books',1007,2010,'en',10,'On the tempestuous world of Roshar, an enslaved bridge-bearer, a brooding highprince, and an ambitious young scholar are thrust into the convergence of war and returning ancient knights.','Rak E-09',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(220,'sampul/mistborn-the-final-empire.jpg','9780765350381','Mistborn: The Final Empire','Brandon Sanderson','Tor Books',541,2006,'en',11,'For a thousand years ash has fallen from the sky under the immortal Lord Ruler. Street thief Vin is recruited by charismatic allomancer Kelsier to overthrow the god-king empire.','Rak E-09',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(221,'sampul/the-road.jpg','9780307387899','The Road','Cormac McCarthy','Alfred A. Knopf',287,2006,'en',6,'A father and his young son walk alone through burned, ash-covered America toward the coast, carrying a pistol and pushing a grocery cart with their meager scavenged belongings.','Rak E-09',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(222,'sampul/blood-meridian.jpg','9780679728757','Blood Meridian','Cormac McCarthy','Random House',337,1985,'en',6,'A stark, lyrical historical novel following the Kid, a teenage runaway who joins the brutal Glanton gang of scalp hunters along the Texas-Mexico border under the eerie sway of Judge Holden.','Rak E-10',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(223,'sampul/the-shining.jpg','9780307743657','The Shining','Stephen King','Doubleday',447,1977,'en',9,'Jack Torrance takes a winter caretaker position at the isolated Overlook Hotel with his wife and telepathic son Danny, where supernatural malevolence slowly drives Jack into homicidal madness.','Rak E-10',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(224,'sampul/it.jpg','9781501142970','It','Stephen King','Viking',1138,1986,'en',8,'Seven outcast childhood friends in Derry, Maine confront an ancient, shape-shifting evil that emerges every 27 years to prey on children, commonly masquerading as Pennywise the Dancing Clown.','Rak E-10',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(225,'sampul/misery.jpg','9781501156748','Misery','Stephen King','Viking',310,1987,'en',7,'Novelist Paul Sheldon crashes his car in a blizzard and is rescued by former nurse Annie Wilkes, his number one fan, who becomes his terrifying captor upon learning he killed off her favorite character.','Rak E-11',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(226,'sampul/the-da-vinci-code.jpg','9780307474278','The Da Vinci Code','Dan Brown','Doubleday',454,2003,'en',12,'Symbologist Robert Langdon and cryptologist Sophie Neveu unravel a trail of clues hidden within Leonardo da Vinci artwork following a sensational murder inside the Louvre Museum.','Rak E-11',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(227,'sampul/angels-demons.jpg','9780743493468','Angels & Demons','Dan Brown','Pocket Books',572,2000,'en',10,'Robert Langdon is summoned to a Swiss research facility to analyze a cryptic symbol seared onto the chest of a murdered physicist, uncovering a catastrophic plot by the Illuminati against the Vatican.','Rak E-11',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(228,'sampul/the-silent-patient.jpg','9781250301696','The Silent Patient','Alex Michaelides','Celadon Books',336,2019,'en',11,'Alicia Berenson lives a seemingly perfect life until one evening she shoots her husband five times in the face and never speaks another word. Criminal psychotherapist Theo Faber is obsessed with uncovering her motive.','Rak E-12',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(229,'sampul/gone-girl.jpg','9780307588371','Gone Girl','Gillian Flynn','Crown Publishing Group',432,2012,'en',8,'On the morning of their fifth wedding anniversary, Nick Dunne wife Amy disappears from their Missouri home. Under intense police and media scrutiny, Nick lies make him the prime suspect in her murder.','Rak E-12',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(230,'sampul/the-alchemist.jpg','9780062315007','The Alchemist','Paulo Coelho','HarperTorch',197,1988,'en',13,'An enchanting fable about Santiago, an Andalusian shepherd boy who journeys across the desert to Egypt in search of worldly treasure, discovering profound wisdom about following one Personal Legend.','Rak E-12',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(231,'sampul/sapiens-a-brief-history-of-humankind.jpg','9780062316097','Sapiens: A Brief History of Humankind','Yuval Noah Harari','Harvill Secker',443,2014,'en',15,'A captivating exploration of how an insignificant ape became the ruler of planet Earth, traversing the Cognitive, Agricultural, and Scientific Revolutions that reshaped human society.','Rak E-13',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(232,'sampul/homo-deus-a-brief-history-of-tomorrow.jpg','9780062464316','Homo Deus: A Brief History of Tomorrow','Yuval Noah Harari','Harvill Secker',448,2016,'en',9,'Looking into the future of humanity, examining how biotechnology, artificial intelligence, and algorithms may transform Homo sapiens into godlike beings while threatening free will.','Rak E-13',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(233,'sampul/atomic-habits.jpg','9780735211292','Atomic Habits','James Clear','Avery',320,2018,'en',16,'A groundbreaking framework for getting 1 percent better every day, using practical strategies rooted in biology, psychology, and neuroscience to build good habits and break bad ones.','Rak E-13',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(234,'sampul/the-psychology-of-money.jpg','9780857197689','The Psychology of Money','Morgan Housel','Harriman House',256,2020,'en',14,'Nineteen short stories illustrating the strange ways people think about wealth, greed, and happiness, proving that doing well with money has a little to do with how smart you are and a lot to do with how you behave.','Rak E-14',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(235,'sampul/deep-work-rules-for-focused-success-in-a-distracted-world.jpg','9781455586691','Deep Work: Rules for Focused Success in a Distracted World','Cal Newport','Grand Central Publishing',304,2016,'en',10,'An actionable guide to mastering the superpower of deep work: the ability to focus without distraction on cognitively demanding tasks in an era flooded with email and social media noise.','Rak E-14',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(236,'sampul/digital-minimalism-choosing-a-focused-life-in-a-noisy-world.jpg','9780525536512','Digital Minimalism: Choosing a Focused Life in a Noisy World','Cal Newport','Portfolio',304,2019,'en',8,'A practical philosophy for technology use, helping readers reclaim their time and attention by ruthlessly optimizing digital tools around things they deeply value.','Rak E-14',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(237,'sampul/thinking-fast-and-slow.jpg','9780374533557','Thinking, Fast and Slow','Daniel Kahneman','Farrar, Straus and Giroux',499,2011,'en',9,'Nobel laureate Daniel Kahneman explains the two systems that drive the way we think: System 1 (fast, intuitive, and emotional) and System 2 (slower, more deliberative, and more logical).','Rak E-15',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(238,'sampul/outliers-the-story-of-success.jpg','9780316017930','Outliers: The Story of Success','Malcolm Gladwell','Little, Brown and Company',309,2008,'en',11,'An engaging inquiry into what makes high-achievers different, revealing that success is shaped by culture, family, generation, and the 10,000-hour rule of deliberate practice.','Rak E-15',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(239,'sampul/the-power-of-habit-why-we-do-what-we-do-in-life-and-business.jpg','9780812981605','The Power of Habit: Why We Do What We Do in Life and Business','Charles Duhigg','Random House',371,2012,'en',10,'Pulitzer Prize-winning reporter Charles Duhigg demystifies the neurological habit loop (cue, routine, reward) and shows how mastering habits can transform businesses and communities.','Rak E-15',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(240,'sampul/cant-hurt-me-master-your-mind-and-defy-the-odds.jpg','9781544512280','Can\'t Hurt Me: Master Your Mind and Defy the Odds','David Goggins','Lioncrest Publishing',364,2018,'en',12,'The raw autobiography of Navy SEAL and ultra-endurance athlete David Goggins, demonstrating how pushing past mental limits and applying the 40% Rule unlocks true human potential.','Rak E-16',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(241,'sampul/mans-search-for-meaning.jpg','9780807014295','Man\'s Search for Meaning','Viktor E. Frankl','Beacon Press',165,1946,'en',11,'Psychiatrist Viktor Frankl memoir of surviving Nazi concentration camps, introducing logotherapy and arguing that man deepest drive is not pleasure or power, but the pursuit of meaning.','Rak E-16',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(242,'sampul/meditations.jpg','9780140449334','Meditations','Marcus Aurelius','Penguin Classics',254,2006,'en',13,'The personal philosophical journal of Roman Emperor Marcus Aurelius, offering timeless Stoic wisdom on virtue, duty, self-discipline, and serenity amidst chaos.','Rak E-16',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(243,'sampul/the-art-of-war.jpg','9780195014761','The Art of War','Sun Tzu','Oxford University Press',173,1963,'en',10,'An ancient Chinese military treatise dating from the Late Spring and Autumn Period, comprising 13 chapters devoted to the strategic and tactical aspects of warfare and leadership.','Rak E-17',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(244,'sampul/crime-and-punishment.jpg','9780140449136','Crime and Punishment','Fyodor Dostoevsky','Penguin Classics',671,2003,'en',8,'In Saint Petersburg, impoverished ex-student Rodion Raskolnikov murders a corrupt pawnbroker to test his theory of extraordinary men, descending into feverish guilt and psychological turmoil.','Rak E-17',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(245,'sampul/the-brothers-karamazov.jpg','9780374528379','The Brothers Karamazov','Fyodor Dostoevsky','Farrar, Straus and Giroux',796,2002,'en',7,'A passionate philosophical drama entering the deepest recesses of the human soul, centered on the patricide of Fyodor Karamazov and his three sharply contrasting sons.','Rak E-17',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(246,'sampul/the-metamorphosis.jpg','9780553213690','The Metamorphosis','Franz Kafka','Kurt Wolff Verlag',128,1915,'en',10,'Traveling salesman Gregor Samsa wakes up one morning to find himself transformed into a monstrous verminous insect, causing alienation, horror, and tragedy within his family.','Rak E-18',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(247,'sampul/the-stranger.jpg','9780679720201','The Stranger','Albert Camus','Vintage',123,1942,'en',9,'Through the story of an ordinary, emotionally detached French Algerian who kills a man on an Algiers beach, Camus explores absurdist philosophy and the naked truth of human existence.','Rak E-18',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(248,'sampul/the-picture-of-dorian-gray.jpg','9780141439570','The Picture of Dorian Gray','Oscar Wilde','Penguin Classics',272,2003,'en',8,'Enthralled by hedonistic aestheticism, handsome young Dorian Gray wishes his portrait would age instead of him, plunging into a secret life of depravity while his painted image bears the horrific decay.','Rak E-18',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(249,'sampul/frankenstein.jpg','9780141439471','Frankenstein','Mary Shelley','Penguin Classics',280,2003,'en',9,'Young scientist Victor Frankenstein creates a sapient creature in an unorthodox scientific experiment, only to abandon his grotesque creation, sparking a catastrophic cycle of vengeance.','Rak E-19',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(250,'sampul/dracula.jpg','9780141439846','Dracula','Bram Stoker','Penguin Classics',454,2003,'en',9,'Count Dracula attempts to relocate from Transylvania to Victorian England to spread the undead curse, confronted by a small band of heroes led by Professor Abraham Van Helsing.','Rak E-19',NULL,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(251,'sampul/jane-eyre.jpg','9780141441146','Jane Eyre','Charlotte Brontë','Penguin Classics',532,2006,'en',12,'An orphaned governess confronts social inequality, moral duty, and dark secrets within the brooding Edward Rochester s Thornfield Hall, establishing one of the most resilient female protagonists in literature.','Rak E-19',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(252,'sampul/wuthering-heights.jpg','9780141439556','Wuthering Heights','Emily Brontë','Penguin Classics',416,2003,'en',8,'A turbulent gothic romance set upon the windswept Yorkshire moors, exploring the destructive, all-consuming passion between Heathcliff and Catherine Earnshaw across generations.','Rak E-20',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(253,'sampul/clean-code-a-handbook-of-agile-software-craftsmanship.jpg','9780132350884','Clean Code: A Handbook of Agile Software Craftsmanship','Robert C. Martin','Prentice Hall',464,2008,'en',14,'Even bad code can function. But if code isn clean, it can bring a development organization to its knees. Master software engineer Robert C. Martin presents a revolutionary paradigm for writing maintainable software.','Rak E-20',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(254,'sampul/the-pragmatic-programmer-your-journey-to-mastery.jpg','9780135957059','The Pragmatic Programmer: Your Journey to Mastery','David Thomas & Andrew Hunt','Addison-Wesley',352,1999,'en',12,'One of the most significant books in software engineering, providing invaluable practical advice on craftsmanship, career development, and coding discipline that transcends specific programming languages.','Rak E-20',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(255,'sampul/design-patterns-elements-of-reusable-object-oriented-software.jpg','9780201633610','Design Patterns: Elements of Reusable Object-Oriented Software','Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides','Addison-Wesley',395,1994,'en',10,'The seminal Gang of Four reference cataloging 23 classic object-oriented software design patterns that solve recurring problems in software engineering architecture.','Rak E-21',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(256,'sampul/refactoring-improving-the-design-of-existing-code.jpg','9780134757599','Refactoring: Improving the Design of Existing Code','Martin Fowler','Addison-Wesley',448,1999,'en',9,'Martin Fowler breaks down the disciplined technique of restructuring an existing body of code, altering its internal structure without changing its external behavior to improve maintainability.','Rak E-21',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(257,'sampul/introduction-to-algorithms-clrs.jpg','9780262033848','Introduction to Algorithms (CLRS)','Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein','MIT Press',1312,1990,'en',8,'The world renowned comprehensive standard textbook on computer algorithms, covering data structures, graph theory, dynamic programming, sorting, and complexity analysis with mathematical rigor.','Rak E-21',NULL,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(258,'sampul/structure-and-interpretation-of-computer-programs-sicp.jpg','9780262510875','Structure and Interpretation of Computer Programs (SICP)','Harold Abelson & Gerald Jay Sussman','MIT Press',657,1985,'en',7,'A legendary computer science textbook that teaches fundamental concepts of programming, abstraction, recursion, interpreter design, and functional programming via Scheme Lisp.','Rak E-22',NULL,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(259,'sampul/you-dont-know-js-yet-get-started.jpg','9798602477429','You Don\'t Know JS Yet: Get Started','Kyle Simpson','O\'Reilly Media',144,2020,'en',11,'An essential deep dive into the core mechanisms of JavaScript, exploring scopes, closures, object prototypes, types, and asynchronous execution beyond surface-level syntax.','Rak E-22',NULL,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(260,'sampul/zero-to-one-notes-on-startups-or-how-to-build-the-future.jpg','9780804139298','Zero to One: Notes on Startups, or How to Build the Future','Peter Thiel','Crown Business',224,2014,'en',13,'Legendary entrepreneur and investor Peter Thiel shows how we can find singular ways to create new things, moving from 0 to 1 rather than competing in established red-ocean markets.','Rak E-22',NULL,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(269,'sampul/j1SFGFx7kwwLsMcveuYwgMUCHnnpOpDE5mRrWeFN.jpg','9780321125217','Domain-Driven Design: Tackling Complexity in the Heart of Software','Eric Evans','Addison-Wesley Professional',560,2003,'en',7,'Buku standar industri software design berorientasi domain bisnis.','Rak T-05',NULL,'2026-10-20 01:47:46','2026-10-20 01:47:46'),(270,NULL,'978-0000000001','Test Buku QC Automated','Penulis QC','Penerbit QC',NULL,2024,NULL,5,'Buku ini dibuat untuk pengujian otomatis unit dan feature.',NULL,NULL,'2026-10-20 01:48:15','2026-10-20 01:48:15'),(271,'sampul/HaRHFakgrah5pT7ZN0GizormQxRNYE6liIgN61OB.jpg','9780321125217','Domain-Driven Design: Tackling Complexity in the Heart of Software','Eric Evans','Addison-Wesley Professional',560,2003,'en',7,'Buku standar industri software design berorientasi domain bisnis.','Rak T-05',NULL,'2026-10-20 01:52:10','2026-10-20 01:52:10'),(272,NULL,'978-9999999999','Buku Komunitas QC Test','Penulis Komunitas','Penerbit Komunitas',NULL,2024,NULL,5,'Buku untuk pengujian fitur komunitas.',NULL,NULL,'2026-10-20 02:08:56','2026-10-20 02:08:56'),(273,'sampul/OziHRPBJUPB3P7y0bqbc8MdAqQr2czl7BfkqARuJ.jpg','9780321125217','Domain-Driven Design: Tackling Complexity in the Heart of Software','Eric Evans','Addison-Wesley Professional',560,2003,'en',7,'Buku standar industri software design berorientasi domain bisnis.','Rak T-05',NULL,'2026-10-20 02:10:41','2026-10-20 02:10:41'),(274,'sampul/mILlM0oceyjoyIUCdO8Tu1b7y43sQGsdmmSJSnOn.jpg','9780321125217','Domain-Driven Design: Tackling Complexity in the Heart of Software','Eric Evans','Addison-Wesley Professional',560,2003,'en',7,'Buku standar industri software design berorientasi domain bisnis.','Rak T-05',NULL,'2026-10-20 03:00:53','2026-10-20 03:00:53');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku_kategori`
--

DROP TABLE IF EXISTS `buku_kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku_kategori` (
  `id_buku` bigint(20) unsigned NOT NULL,
  `id_kategori` bigint(20) unsigned NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_buku`,`id_kategori`),
  KEY `buku_kategori_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `buku_kategori_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  CONSTRAINT `buku_kategori_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku_kategori`
--

LOCK TABLES `buku_kategori` WRITE;
/*!40000 ALTER TABLE `buku_kategori` DISABLE KEYS */;
INSERT INTO `buku_kategori` VALUES (11,9,'2026-02-23 03:52:59','2026-02-23 03:52:59'),(13,9,'2026-02-23 07:42:06','2026-02-23 07:42:06'),(14,9,'2026-02-23 07:46:31','2026-02-23 07:46:31'),(15,9,'2026-02-23 07:49:25','2026-02-23 07:49:25'),(16,9,'2026-02-23 08:00:57','2026-02-23 08:00:57'),(17,1,'2026-10-20 00:19:58','2026-10-20 00:19:58'),(17,10,'2026-02-23 08:04:13','2026-02-23 08:04:13'),(18,1,'2026-10-20 00:24:06','2026-10-20 00:24:06'),(18,10,'2026-02-23 08:07:04','2026-02-23 08:07:04'),(19,1,'2026-02-23 08:09:33','2026-02-23 08:09:33'),(19,10,'2026-02-23 08:09:33','2026-02-23 08:09:33'),(20,1,'2026-10-20 00:19:57','2026-10-20 00:19:57'),(20,10,'2026-02-23 08:13:54','2026-02-23 08:13:54'),(21,1,'2026-10-20 00:20:01','2026-10-20 00:20:01'),(21,10,'2026-02-23 08:15:58','2026-02-23 08:15:58'),(22,2,'2026-02-23 08:19:01','2026-02-23 08:19:01'),(23,2,'2026-02-23 08:21:01','2026-02-23 08:21:01'),(24,1,'2026-02-23 08:24:22','2026-02-23 08:24:22'),(25,8,'2026-02-23 08:27:34','2026-02-23 08:27:34'),(25,9,'2026-02-23 08:27:34','2026-02-23 08:27:34'),(141,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(141,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(142,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(142,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(143,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(143,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(144,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(144,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(145,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(145,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(146,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(146,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(147,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(147,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(148,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(148,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(149,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(149,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(150,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(150,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(151,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(151,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(152,3,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(152,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(153,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(153,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(154,1,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(154,9,'2026-10-20 00:30:05','2026-10-20 00:30:05'),(155,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(155,4,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(155,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(156,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(156,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(157,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(157,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(158,3,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(158,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(159,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(159,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(160,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(160,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(161,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(161,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(162,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(162,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(163,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(163,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(164,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(164,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(165,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(165,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(166,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(166,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(167,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(167,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(168,2,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(168,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(169,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(169,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(170,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(170,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(171,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(171,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(172,3,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(172,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(173,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(173,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(174,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(174,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(175,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(175,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(176,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(176,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(177,4,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(177,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(178,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(178,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(179,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(179,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(180,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(180,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(181,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(181,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(182,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(182,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(183,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(183,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(184,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(184,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(185,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(185,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(186,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(186,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(187,1,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(187,9,'2026-10-20 00:30:08','2026-10-20 00:30:08'),(188,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(188,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(189,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(189,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(190,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(190,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(191,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(191,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(192,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(192,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(193,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(193,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(194,1,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(194,9,'2026-10-20 00:30:09','2026-10-20 00:30:09'),(195,1,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(195,10,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(196,1,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(196,10,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(197,1,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(197,10,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(198,1,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(198,10,'2026-10-20 00:30:11','2026-10-20 00:30:11'),(199,1,'2026-10-20 00:30:13','2026-10-20 00:30:13'),(199,3,'2026-10-20 00:30:13','2026-10-20 00:30:13'),(199,10,'2026-10-20 00:30:13','2026-10-20 00:30:13'),(200,1,'2026-10-20 00:30:15','2026-10-20 00:30:15'),(200,10,'2026-10-20 00:30:15','2026-10-20 00:30:15'),(201,1,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(201,10,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(202,1,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(202,10,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(203,1,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(203,10,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(204,1,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(204,10,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(205,1,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(205,10,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(206,1,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(206,10,'2026-10-20 00:30:18','2026-10-20 00:30:18'),(207,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(207,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(208,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(208,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(209,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(209,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(210,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(210,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(211,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(211,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(212,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(212,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(213,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(213,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(214,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(214,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(215,4,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(215,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(216,4,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(216,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(217,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(217,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(218,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(218,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(219,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(219,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(220,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(220,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(221,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(221,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(222,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(222,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(223,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(223,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(224,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(224,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(225,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(225,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(226,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(226,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(227,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(227,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(228,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(228,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(229,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(229,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(230,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(230,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(231,2,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(231,3,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(232,2,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(232,4,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(233,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(234,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(235,4,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(235,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(236,4,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(236,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(237,2,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(237,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(238,6,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(238,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(239,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(240,6,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(240,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(241,6,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(241,11,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(242,11,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(243,3,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(243,7,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(244,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(244,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(245,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(245,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(246,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(246,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(247,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(247,11,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(248,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(248,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(249,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(249,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(250,1,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(250,10,'2026-10-20 00:30:20','2026-10-20 00:30:20'),(251,1,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(251,10,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(252,1,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(252,10,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(253,4,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(254,4,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(255,4,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(256,4,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(257,2,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(257,4,'2026-10-20 00:30:22','2026-10-20 00:30:22'),(258,4,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(259,4,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(260,4,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(260,7,'2026-10-20 00:30:23','2026-10-20 00:30:23'),(269,4,'2026-10-20 01:47:46','2026-10-20 01:47:46'),(271,4,'2026-10-20 01:52:10','2026-10-20 01:52:10'),(273,4,'2026-10-20 02:10:41','2026-10-20 02:10:41'),(274,4,'2026-10-20 03:00:53','2026-10-20 03:00:53');
/*!40000 ALTER TABLE `buku_kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('readify_cache_94d92f976fd06fd3e8cf53ec4e03d646','i:2;',1792549746),('readify_cache_94d92f976fd06fd3e8cf53ec4e03d646:timer','i:1792549746;',1792549746),('readify_cache_b8ec9f0cc2df2c992139a16af98b57da','i:1;',1772204083),('readify_cache_b8ec9f0cc2df2c992139a16af98b57da:timer','i:1772204083;',1772204083);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denda`
--

DROP TABLE IF EXISTS `denda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denda` (
  `id_denda` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_peminjaman` bigint(20) unsigned NOT NULL,
  `jumlah_denda` decimal(10,2) NOT NULL,
  `status_pembayaran` enum('belum_bayar','lunas') NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_denda`),
  UNIQUE KEY `denda_id_peminjaman_unique` (`id_peminjaman`),
  CONSTRAINT `denda_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denda`
--

LOCK TABLES `denda` WRITE;
/*!40000 ALTER TABLE `denda` DISABLE KEYS */;
INSERT INTO `denda` VALUES (12,22,-4000.00,'belum_bayar','2026-02-26 03:44:01','2026-02-26 03:44:01');
/*!40000 ALTER TABLE `denda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_peminjaman`
--

DROP TABLE IF EXISTS `detail_peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_peminjaman` (
  `id_detail` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_peminjaman` bigint(20) unsigned NOT NULL,
  `id_buku` bigint(20) unsigned NOT NULL,
  `jumlah` int(11) NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `detail_peminjaman_id_peminjaman_foreign` (`id_peminjaman`),
  KEY `detail_peminjaman_id_buku_foreign` (`id_buku`),
  CONSTRAINT `detail_peminjaman_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  CONSTRAINT `detail_peminjaman_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_peminjaman`
--

LOCK TABLES `detail_peminjaman` WRITE;
/*!40000 ALTER TABLE `detail_peminjaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hak_akses`
--

DROP TABLE IF EXISTS `hak_akses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hak_akses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `fitur` enum('kategori','buku','peminjaman','denda','laporan') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hak_akses_id_pengguna_fitur_unique` (`id_pengguna`,`fitur`),
  CONSTRAINT `hak_akses_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hak_akses`
--

LOCK TABLES `hak_akses` WRITE;
/*!40000 ALTER TABLE `hak_akses` DISABLE KEYS */;
INSERT INTO `hak_akses` VALUES (8,48,'laporan','2026-02-26 09:02:29','2026-02-26 09:02:29'),(9,48,'denda','2026-02-26 09:02:32','2026-02-26 09:02:32'),(10,48,'buku','2026-02-26 09:02:35','2026-02-26 09:02:35'),(11,48,'kategori','2026-02-26 19:10:57','2026-02-26 19:10:57'),(12,48,'peminjaman','2026-02-26 19:11:02','2026-02-26 19:11:02'),(13,52,'kategori','2026-10-19 23:50:39','2026-10-19 23:50:39'),(14,52,'buku','2026-10-19 23:50:39','2026-10-19 23:50:39'),(15,52,'peminjaman','2026-10-19 23:50:39','2026-10-19 23:50:39'),(16,52,'denda','2026-10-19 23:50:39','2026-10-19 23:50:39'),(17,52,'laporan','2026-10-19 23:50:39','2026-10-19 23:50:39');
/*!40000 ALTER TABLE `hak_akses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id_kategori` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Fiksi','2026-02-23 03:24:06','2026-02-23 03:24:06'),(2,'Sains','2026-02-23 03:24:06','2026-02-23 03:24:06'),(3,'Sejarah','2026-02-23 03:24:06','2026-02-23 03:24:06'),(4,'Teknologi','2026-02-23 03:24:06','2026-02-23 03:24:06'),(5,'Seni','2026-02-23 03:24:06','2026-02-23 03:24:06'),(6,'Biografi','2026-02-23 03:24:06','2026-02-23 03:24:06'),(7,'Bisnis','2026-02-23 03:24:06','2026-02-23 03:24:06'),(8,'Anak-anak','2026-02-23 03:24:06','2026-02-23 03:24:06'),(9,'Manga','2026-02-23 03:50:24','2026-02-23 03:50:24'),(10,'Novel','2026-02-23 08:03:48','2026-02-23 08:03:48'),(11,'Filosofi','2026-10-20 00:18:09','2026-10-20 00:18:09');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `koleksi_pribadi`
--

DROP TABLE IF EXISTS `koleksi_pribadi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `koleksi_pribadi` (
  `id_koleksi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `id_buku` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_koleksi`),
  KEY `koleksi_pribadi_id_pengguna_foreign` (`id_pengguna`),
  KEY `koleksi_pribadi_id_buku_foreign` (`id_buku`),
  CONSTRAINT `koleksi_pribadi_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  CONSTRAINT `koleksi_pribadi_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `koleksi_pribadi`
--

LOCK TABLES `koleksi_pribadi` WRITE;
/*!40000 ALTER TABLE `koleksi_pribadi` DISABLE KEYS */;
INSERT INTO `koleksi_pribadi` VALUES (1,45,11,'2026-02-26 03:41:35','2026-02-26 03:41:35');
/*!40000 ALTER TABLE `koleksi_pribadi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komentar_komunitas`
--

DROP TABLE IF EXISTS `komentar_komunitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `komentar_komunitas` (
  `id_komentar` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_postingan` bigint(20) unsigned NOT NULL,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `konten` text NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_komentar`),
  KEY `komentar_komunitas_id_postingan_foreign` (`id_postingan`),
  KEY `komentar_komunitas_id_pengguna_foreign` (`id_pengguna`),
  CONSTRAINT `komentar_komunitas_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  CONSTRAINT `komentar_komunitas_id_postingan_foreign` FOREIGN KEY (`id_postingan`) REFERENCES `postingan_komunitas` (`id_postingan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komentar_komunitas`
--

LOCK TABLES `komentar_komunitas` WRITE;
/*!40000 ALTER TABLE `komentar_komunitas` DISABLE KEYS */;
INSERT INTO `komentar_komunitas` VALUES (1,1,57,'Gue kemaren sempet liat di rak B2 bro, artwork pas awakening beneran gokil sih.','2026-10-20 01:38:18','2026-10-20 01:38:18'),(2,1,45,'Wah harus cepet-cepet booking nih sebelum abis dipinjam orang haha.','2026-10-20 01:53:18','2026-10-20 01:53:18'),(3,1,59,'Gas pinjam bro, ga bakal nyesel lu bacanya!','2026-10-20 02:08:18','2026-10-20 02:08:18'),(4,2,61,'Yang konsep 1% better every day ka! Keliatannya sepele tapi pas dijalanin konsisten 3 bulan efeknya berasa banget.','2026-10-20 00:23:18','2026-10-20 00:23:18'),(5,2,60,'Habit Stacking juga ngebantu banget Zahra, gue gabungin waktu ngopi pagi sama baca 5 halaman buku perpus.','2026-10-20 00:38:18','2026-10-20 00:38:18'),(6,2,57,'Bagian identity-based habit juga ngena, ubah mindset bukan \"mau baca buku\" tapi \"gue adalah seorang pembaca\".','2026-10-20 00:53:18','2026-10-20 00:53:18'),(7,3,59,'Prinsip dasarnya tetep abadi bro, terutama SRP (Single Responsibility) & readability.','2026-10-19 22:53:18','2026-10-19 22:53:18'),(8,3,45,'Setuju, tools boleh ganti tapi cara nulis kode yang bersih dan gampang dibaca orang lain ga bakal basi.','2026-10-19 23:08:18','2026-10-19 23:08:18'),(9,4,58,'Bab tentang \"Man in the Car Paradox\" ngena banget sih. Orang beli barang mewah biar dikagumi, padahal orang lain cuma kagum sama barangnya bukan orangnya.','2026-10-19 20:23:18','2026-10-19 20:23:18'),(10,4,57,'Buku non-fiksi yang wajib dibaca sekali seumur hidup 💯','2026-10-19 20:38:18','2026-10-19 20:38:18'),(11,5,60,'Tim Sirius Black hadir! Karakter paling berjiwa bebas.','2026-10-19 18:23:18','2026-10-19 18:23:18'),(12,5,59,'Profesor Snape tetep the best written character sepanjang seri sih.','2026-10-19 18:38:18','2026-10-19 18:38:18'),(13,6,60,'Coba baca Harry Potter atau Percy Jackson kalau mau yang ringan dan seru alurnya!','2026-10-19 16:23:18','2026-10-19 16:23:18'),(14,6,61,'Kalau mau yang agak berbobot tapi nagih coba Dune bro, di Rak Novel ada.','2026-10-19 16:38:18','2026-10-19 16:38:18'),(15,7,57,'Plot twist dari awal sampe akhir beneran jenius sih Isayama.','2026-10-19 12:23:18','2026-10-19 12:23:18'),(16,8,58,'Setuju, awal-awal agak lambat tapi pas Paul Atreides ke gurun pasir langsung ga bisa berhenti baca.','2026-10-19 06:23:18','2026-10-19 06:23:18'),(17,10,63,'Komentar balasan dari anggota kedua yang sangat ramah.','2026-10-20 02:08:59','2026-10-20 02:08:59'),(18,14,63,'Komentar balasan dari anggota kedua yang sangat ramah.','2026-10-20 02:10:21','2026-10-20 02:10:21'),(19,18,63,'Komentar balasan dari anggota kedua yang sangat ramah.','2026-10-20 02:10:33','2026-10-20 02:10:33'),(20,1,45,'keren','2026-10-20 02:13:47','2026-10-20 02:13:47'),(21,1,45,'keren','2026-10-20 02:13:51','2026-10-20 02:13:51'),(22,1,45,'keren','2026-10-20 02:13:52','2026-10-20 02:13:52'),(23,1,45,'keren','2026-10-20 02:13:54','2026-10-20 02:13:54'),(24,1,45,'keren','2026-10-20 02:13:56','2026-10-20 02:13:56'),(25,1,45,'keren','2026-10-20 02:13:57','2026-10-20 02:13:57'),(26,23,63,'Komentar balasan dari anggota kedua yang sangat ramah.','2026-10-20 03:00:39','2026-10-20 03:00:39');
/*!40000 ALTER TABLE `komentar_komunitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `like_postingan`
--

DROP TABLE IF EXISTS `like_postingan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like_postingan` (
  `id_like` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_postingan` bigint(20) unsigned NOT NULL,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_like`),
  UNIQUE KEY `like_postingan_id_postingan_id_pengguna_unique` (`id_postingan`,`id_pengguna`),
  KEY `like_postingan_id_pengguna_foreign` (`id_pengguna`),
  CONSTRAINT `like_postingan_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  CONSTRAINT `like_postingan_id_postingan_foreign` FOREIGN KEY (`id_postingan`) REFERENCES `postingan_komunitas` (`id_postingan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like_postingan`
--

LOCK TABLES `like_postingan` WRITE;
/*!40000 ALTER TABLE `like_postingan` DISABLE KEYS */;
INSERT INTO `like_postingan` VALUES (1,1,45,'2026-10-20 01:28:18'),(2,1,58,'2026-10-20 01:28:18'),(3,1,59,'2026-10-20 01:28:18'),(4,1,60,'2026-10-20 01:28:18'),(5,2,45,'2026-10-20 00:13:18'),(6,2,57,'2026-10-20 00:13:18'),(7,2,59,'2026-10-20 00:13:18'),(8,3,60,'2026-10-19 22:43:18'),(9,4,59,'2026-10-19 20:13:18'),(10,5,58,'2026-10-19 18:13:18'),(11,5,59,'2026-10-19 18:13:18'),(12,6,58,'2026-10-19 16:13:18'),(13,6,60,'2026-10-19 16:13:18'),(14,6,61,'2026-10-19 16:13:18'),(15,7,45,'2026-10-19 12:13:18'),(16,7,57,'2026-10-19 12:13:18'),(17,7,58,'2026-10-19 12:13:18'),(18,7,61,'2026-10-19 12:13:18'),(19,8,45,'2026-10-19 06:13:18'),(20,8,57,'2026-10-19 06:13:18'),(21,8,58,'2026-10-19 06:13:18'),(22,8,59,'2026-10-19 06:13:18'),(23,8,60,'2026-10-19 06:13:18'),(24,11,63,'2026-10-20 02:09:00'),(27,18,45,'2026-10-20 02:13:37');
/*!40000 ALTER TABLE `like_postingan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_aktivitas`
--

DROP TABLE IF EXISTS `log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_aktivitas` (
  `id_log` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned DEFAULT NULL,
  `nama_pengguna` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'anggota',
  `aksi` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`),
  KEY `log_aktivitas_aksi_dibuat_pada_index` (`aksi`,`dibuat_pada`),
  KEY `log_aktivitas_id_pengguna_index` (`id_pengguna`),
  CONSTRAINT `log_aktivitas_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
INSERT INTO `log_aktivitas` VALUES (1,55,'Sistem / Tamu','tamu','login','Admin login ke sistem untuk uji coba','127.0.0.1','Symfony','2026-10-20 01:48:46'),(2,56,'anggota_test','anggota','cetak_struk','Pengguna \'anggota_test\' mencetak struk transaksi ID #25 (Booking: BKQC9999).','127.0.0.1','Symfony','2026-10-20 01:48:48'),(3,55,'Sistem / Tamu','tamu','login','Admin login ke sistem untuk uji coba','127.0.0.1','Symfony','2026-10-20 01:50:19'),(4,56,'anggota_test','anggota','cetak_struk','Pengguna \'anggota_test\' mencetak struk transaksi ID #25 (Booking: BKQC9999).','127.0.0.1','Symfony','2026-10-20 01:50:21'),(5,55,'Sistem / Tamu','tamu','login','Admin login ke sistem untuk uji coba','127.0.0.1','Symfony','2026-10-20 01:51:50'),(6,56,'anggota_test','anggota','cetak_struk','Pengguna \'anggota_test\' mencetak struk transaksi ID #25 (Booking: BKQC9999).','127.0.0.1','Symfony','2026-10-20 01:51:52'),(7,55,'Sistem / Tamu','tamu','login','Admin login ke sistem untuk uji coba','127.0.0.1','Symfony','2026-10-20 01:52:04'),(8,56,'anggota_test','anggota','cetak_struk','Pengguna \'anggota_test\' mencetak struk transaksi ID #25 (Booking: BKQC9999).','127.0.0.1','Symfony','2026-10-20 01:52:06'),(9,62,'komunitas_user1','anggota','buat_postingan','Membuat postingan komunitas: Ini adalah postingan uji coba untuk test...','127.0.0.1','Symfony','2026-10-20 02:08:58'),(10,63,'komunitas_user2','anggota','komentar_komunitas','Mengomentari postingan #10: Komentar balasan dari anggota kedua...','127.0.0.1','Symfony','2026-10-20 02:08:59'),(11,62,'komunitas_user1','anggota','hapus_postingan','Menghapus postingan komunitas #12 milik pengguna #62','127.0.0.1','Symfony','2026-10-20 02:09:01'),(12,62,'komunitas_user1','anggota','buat_postingan','Membuat postingan komunitas: Ini adalah postingan uji coba untuk test...','127.0.0.1','Symfony','2026-10-20 02:10:20'),(13,63,'komunitas_user2','anggota','komentar_komunitas','Mengomentari postingan #14: Komentar balasan dari anggota kedua...','127.0.0.1','Symfony','2026-10-20 02:10:21'),(14,62,'komunitas_user1','anggota','hapus_postingan','Menghapus postingan komunitas #16 milik pengguna #62','127.0.0.1','Symfony','2026-10-20 02:10:22'),(15,62,'komunitas_user1','anggota','buat_postingan','Membuat postingan komunitas: Ini adalah postingan uji coba untuk test...','127.0.0.1','Symfony','2026-10-20 02:10:32'),(16,63,'komunitas_user2','anggota','komentar_komunitas','Mengomentari postingan #18: Komentar balasan dari anggota kedua...','127.0.0.1','Symfony','2026-10-20 02:10:33'),(17,62,'komunitas_user1','anggota','hapus_postingan','Menghapus postingan komunitas #20 milik pengguna #62','127.0.0.1','Symfony','2026-10-20 02:10:34'),(18,55,'Sistem / Tamu','tamu','login','Admin login ke sistem untuk uji coba','127.0.0.1','Symfony','2026-10-20 02:10:35'),(19,56,'anggota_test','anggota','cetak_struk','Pengguna \'anggota_test\' mencetak struk transaksi ID #25 (Booking: BKQC9999).','127.0.0.1','Symfony','2026-10-20 02:10:36'),(20,45,'Lazver','anggota','komentar_komunitas','Mengomentari postingan #1: keren','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:13:47'),(21,45,'Lazver','anggota','komentar_komunitas','Mengomentari postingan #1: keren','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:13:51'),(22,45,'Lazver','anggota','komentar_komunitas','Mengomentari postingan #1: keren','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:13:52'),(23,45,'Lazver','anggota','komentar_komunitas','Mengomentari postingan #1: keren','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:13:54'),(24,45,'Lazver','anggota','komentar_komunitas','Mengomentari postingan #1: keren','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:13:56'),(25,45,'Lazver','anggota','komentar_komunitas','Mengomentari postingan #1: keren','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:13:57'),(26,45,'Lazver','anggota','buat_postingan','Membuat postingan komunitas: goated','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 02:14:27'),(27,62,'komunitas_user1','anggota','buat_postingan','Membuat postingan komunitas: Ini adalah postingan uji coba untuk test...','127.0.0.1','Symfony','2026-10-20 03:00:36'),(28,63,'komunitas_user2','anggota','komentar_komunitas','Mengomentari postingan #23: Komentar balasan dari anggota kedua...','127.0.0.1','Symfony','2026-10-20 03:00:39'),(29,62,'komunitas_user1','anggota','hapus_postingan','Menghapus postingan komunitas #25 milik pengguna #62','127.0.0.1','Symfony','2026-10-20 03:00:42'),(30,55,'Sistem / Tamu','tamu','login','Admin login ke sistem untuk uji coba','127.0.0.1','Symfony','2026-10-20 03:00:43'),(31,56,'anggota_test','anggota','cetak_struk','Pengguna \'anggota_test\' mencetak struk transaksi ID #25 (Booking: BKQC9999).','127.0.0.1','Symfony','2026-10-20 03:00:46'),(32,45,'Lazver','anggota','login','Pengguna \'Lazver\' (anggota) berhasil masuk ke sistem.','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','2026-10-20 19:28:11');
/*!40000 ALTER TABLE `log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_02_133830_create_pengguna_table',1),(5,'2026_02_02_133831_create_kategori_table',1),(6,'2026_02_02_133832_create_buku_table',1),(7,'2026_02_02_133833_create_anggota_table',1),(8,'2026_02_02_133834_create_peminjaman_table',1),(9,'2026_02_02_133836_create_detail_peminjaman_table',1),(10,'2026_02_02_133837_create_denda_table',1),(11,'2026_02_06_071512_add_role_to_users_table',1),(12,'2026_02_06_170725_add_cover_and_lokasi_to_buku_table',1),(13,'2026_02_16_140637_create_telescope_entries_table',1),(14,'2026_02_17_114156_create_buku_kategori_table',1),(15,'2026_02_17_114757_migrate_existing_buku_kategoris',1),(17,'2026_02_20_101351_create_pengajuan_buku_table',1),(18,'2026_02_20_143000_create_hak_akses_table',1),(19,'2026_02_21_000000_add_laporan_to_hak_akses_fitur_enum',1),(20,'2026_02_21_102916_add_user_notif_to_pengajuan_buku_table',1),(21,'2026_02_21_103053_create_notifikasi_table',1),(22,'2026_02_22_000634_add_status_and_nomor_anggota_to_pengguna_table',1),(23,'2026_02_22_085513_add_detailed_fields_to_buku_table',1),(24,'2026_02_23_000001_add_durasi_and_jatuh_tempo_to_peminjaman',1),(25,'2026_02_25_103018_create_koleksi_pribadis_table',2),(26,'2026_02_26_000000_create_ulasan_table',3),(27,'2026_02_27_132310_add_foto_profil_to_pengguna_table',4),(28,'2026_02_17_create_ai_recommendations_table',5),(29,'2026_10_20_073611_add_id_buku_to_pengajuan_buku_table',5),(30,'2026_10_20_084000_create_log_aktivitas_table',6),(31,'2026_10_20_085000_update_notifikasi_table_for_due_date',7),(32,'2026_10_20_091000_create_komunitas_literasi_tables',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `id_pengajuan` bigint(20) unsigned DEFAULT NULL,
  `id_peminjaman` bigint(20) unsigned DEFAULT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_notifikasi`),
  KEY `notifikasi_id_pengguna_foreign` (`id_pengguna`),
  KEY `notifikasi_id_pengajuan_foreign` (`id_pengajuan`),
  KEY `notifikasi_id_peminjaman_foreign` (`id_peminjaman`),
  CONSTRAINT `notifikasi_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  CONSTRAINT `notifikasi_id_pengajuan_foreign` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_buku` (`id_pengajuan`) ON DELETE CASCADE,
  CONSTRAINT `notifikasi_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--

LOCK TABLES `notifikasi` WRITE;
/*!40000 ALTER TABLE `notifikasi` DISABLE KEYS */;
INSERT INTO `notifikasi` VALUES (20,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,13,NULL,0,'2026-10-20 01:08:15','2026-10-20 01:08:15'),(21,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,13,NULL,0,'2026-10-20 01:08:15','2026-10-20 01:08:15'),(22,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,13,NULL,0,'2026-10-20 01:08:15','2026-10-20 01:08:15'),(23,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,14,NULL,0,'2026-10-20 01:08:17','2026-10-20 01:08:17'),(24,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,15,NULL,0,'2026-10-20 01:08:18','2026-10-20 01:08:18'),(25,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,16,NULL,0,'2026-10-20 01:11:39','2026-10-20 01:11:39'),(26,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,16,NULL,0,'2026-10-20 01:11:39','2026-10-20 01:11:39'),(27,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,16,NULL,0,'2026-10-20 01:11:39','2026-10-20 01:11:39'),(28,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,17,NULL,0,'2026-10-20 01:11:40','2026-10-20 01:11:40'),(29,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,18,NULL,0,'2026-10-20 01:11:41','2026-10-20 01:11:41'),(30,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,19,NULL,0,'2026-10-20 01:18:15','2026-10-20 01:18:15'),(31,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,19,NULL,0,'2026-10-20 01:18:15','2026-10-20 01:18:15'),(32,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,19,NULL,0,'2026-10-20 01:18:15','2026-10-20 01:18:15'),(33,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,20,NULL,0,'2026-10-20 01:18:16','2026-10-20 01:18:16'),(34,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,21,NULL,0,'2026-10-20 01:18:17','2026-10-20 01:18:17'),(35,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,22,NULL,1,'2026-10-20 01:21:32','2026-10-20 01:27:45'),(36,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,22,NULL,0,'2026-10-20 01:21:32','2026-10-20 01:21:32'),(37,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,22,NULL,0,'2026-10-20 01:21:32','2026-10-20 01:21:32'),(38,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,23,NULL,0,'2026-10-20 01:21:33','2026-10-20 01:21:33'),(39,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,24,NULL,0,'2026-10-20 01:21:34','2026-10-20 01:21:34'),(40,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,25,NULL,0,'2026-10-20 01:25:37','2026-10-20 01:25:37'),(41,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,25,NULL,0,'2026-10-20 01:25:37','2026-10-20 01:25:37'),(42,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,25,NULL,0,'2026-10-20 01:25:37','2026-10-20 01:25:37'),(43,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,26,NULL,0,'2026-10-20 01:25:38','2026-10-20 01:25:38'),(44,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,27,NULL,0,'2026-10-20 01:25:39','2026-10-20 01:25:39'),(45,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,28,NULL,0,'2026-10-20 01:47:45','2026-10-20 01:47:45'),(46,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,28,NULL,0,'2026-10-20 01:47:45','2026-10-20 01:47:45'),(47,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,28,NULL,0,'2026-10-20 01:47:45','2026-10-20 01:47:45'),(48,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,29,NULL,0,'2026-10-20 01:47:46','2026-10-20 01:47:46'),(49,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,30,NULL,0,'2026-10-20 01:47:47','2026-10-20 01:47:47'),(53,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,31,NULL,0,'2026-10-20 01:52:09','2026-10-20 01:52:09'),(54,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,31,NULL,0,'2026-10-20 01:52:09','2026-10-20 01:52:09'),(55,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,31,NULL,0,'2026-10-20 01:52:09','2026-10-20 01:52:09'),(56,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,32,NULL,0,'2026-10-20 01:52:10','2026-10-20 01:52:10'),(57,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,33,NULL,0,'2026-10-20 01:52:11','2026-10-20 01:52:11'),(58,62,'komunitas','Komentar Baru di Postinganmu','Penguji Komunitas Dua mengomentari: \"Komentar balasan dari anggota kedua yang sangat ra...\"','http://localhost/komunitas#post-10',NULL,NULL,0,'2026-10-20 02:08:59','2026-10-20 02:08:59'),(59,62,'komunitas','Komentar Baru di Postinganmu','Penguji Komunitas Dua mengomentari: \"Komentar balasan dari anggota kedua yang sangat ra...\"','http://localhost/komunitas#post-14',NULL,NULL,0,'2026-10-20 02:10:21','2026-10-20 02:10:21'),(60,62,'komunitas','Komentar Baru di Postinganmu','Penguji Komunitas Dua mengomentari: \"Komentar balasan dari anggota kedua yang sangat ra...\"','http://localhost/komunitas#post-18',NULL,NULL,0,'2026-10-20 02:10:33','2026-10-20 02:10:33'),(62,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,34,NULL,0,'2026-10-20 02:10:39','2026-10-20 02:10:39'),(63,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,34,NULL,0,'2026-10-20 02:10:39','2026-10-20 02:10:39'),(64,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,34,NULL,0,'2026-10-20 02:10:39','2026-10-20 02:10:39'),(65,56,'status_pengajuan','🎉 Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,35,NULL,0,'2026-10-20 02:10:41','2026-10-20 02:10:41'),(66,56,'status_pengajuan','❌ Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,36,NULL,0,'2026-10-20 02:10:42','2026-10-20 02:10:42'),(67,59,'komunitas','Komentar Baru di Postinganmu','Faiz Akhrian Putra mengomentari: \"keren\"','http://127.0.0.1:8000/komunitas#post-1',NULL,NULL,0,'2026-10-20 02:13:47','2026-10-20 02:13:47'),(68,59,'komunitas','Komentar Baru di Postinganmu','Faiz Akhrian Putra mengomentari: \"keren\"','http://127.0.0.1:8000/komunitas#post-1',NULL,NULL,0,'2026-10-20 02:13:51','2026-10-20 02:13:51'),(69,59,'komunitas','Komentar Baru di Postinganmu','Faiz Akhrian Putra mengomentari: \"keren\"','http://127.0.0.1:8000/komunitas#post-1',NULL,NULL,0,'2026-10-20 02:13:52','2026-10-20 02:13:52'),(70,59,'komunitas','Komentar Baru di Postinganmu','Faiz Akhrian Putra mengomentari: \"keren\"','http://127.0.0.1:8000/komunitas#post-1',NULL,NULL,0,'2026-10-20 02:13:54','2026-10-20 02:13:54'),(71,59,'komunitas','Komentar Baru di Postinganmu','Faiz Akhrian Putra mengomentari: \"keren\"','http://127.0.0.1:8000/komunitas#post-1',NULL,NULL,0,'2026-10-20 02:13:56','2026-10-20 02:13:56'),(72,59,'komunitas','Komentar Baru di Postinganmu','Faiz Akhrian Putra mengomentari: \"keren\"','http://127.0.0.1:8000/komunitas#post-1',NULL,NULL,0,'2026-10-20 02:13:57','2026-10-20 02:13:57'),(73,62,'komunitas','Komentar Baru di Postinganmu','Penguji Komunitas Dua mengomentari: \"Komentar balasan dari anggota kedua yang sangat ra...\"','http://localhost/komunitas#post-23',NULL,NULL,0,'2026-10-20 03:00:39','2026-10-20 03:00:39'),(74,56,'jatuh_tempo','Pengingat Jatuh Tempo (H-1)','Pengingat: Peminjaman buku \'Test Buku QC Automated\' akan jatuh tempo dalam 1 hari lagi (21 Oct 2026). Segera kembalikan atau lakukan perpanjangan untuk menghindari denda Rp 1.000/hari.','http://localhost/anggota/pinjaman',NULL,25,0,'2026-10-20 03:00:46','2026-10-20 03:00:46'),(75,30,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,37,NULL,0,'2026-10-20 03:00:51','2026-10-20 03:00:51'),(76,32,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,37,NULL,0,'2026-10-20 03:00:51','2026-10-20 03:00:51'),(77,55,'pengajuan_baru','Pengajuan Buku Baru','Pengguna \"Anggota Test Readify\" mengajukan buku \"Designing Data-Intensive Applications\".',NULL,37,NULL,0,'2026-10-20 03:00:51','2026-10-20 03:00:51'),(78,56,'status_pengajuan','Usulan Buku Diterima & Terbit!','Selamat! Usulan buku Anda \"Domain-Driven Design: Tackling Complexity in the Heart of Software\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada Rak T-05.',NULL,38,NULL,0,'2026-10-20 03:00:53','2026-10-20 03:00:53'),(79,56,'status_pengajuan','Pengajuan Buku Ditolak','Pengajuan buku \"Buku yang Ditolak\" telah ditolak oleh admin. Catatan admin: Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',NULL,39,NULL,0,'2026-10-20 03:00:55','2026-10-20 03:00:55');
/*!40000 ALTER TABLE `notifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_peminjaman` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `id_buku` bigint(20) unsigned NOT NULL,
  `kode_booking` varchar(12) DEFAULT NULL,
  `tgl_booking` date DEFAULT NULL,
  `durasi_pinjam` int(10) unsigned DEFAULT NULL COMMENT 'Durasi pinjam dalam hari (maks 14)',
  `tgl_jatuh_tempo` date DEFAULT NULL COMMENT 'Tanggal jatuh tempo pengembalian',
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status_transaksi` enum('booking','dipinjam','dikembalikan','terlambat') NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_peminjaman`),
  KEY `peminjaman_id_pengguna_foreign` (`id_pengguna`),
  KEY `peminjaman_id_buku_foreign` (`id_buku`),
  CONSTRAINT `peminjaman_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  CONSTRAINT `peminjaman_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (21,45,11,'BK260223HS4K','2026-02-23',11,'2026-03-06','2026-02-23','2026-02-26','dikembalikan','2026-02-23 03:58:45','2026-02-26 03:44:45'),(22,45,13,'BK260223LEFQ','2026-02-23',1,'2026-02-24','2026-02-23','2026-02-26','dikembalikan','2026-02-23 16:57:23','2026-02-26 03:44:01'),(23,45,16,'BK260226XF82','2026-02-26',7,'2026-03-05','2026-02-27','2026-03-03','dikembalikan','2026-02-26 10:18:50','2026-03-03 10:17:42'),(24,45,25,'BK260303WYMH','2026-03-03',7,'2026-03-10','2026-03-03','2026-03-03','dikembalikan','2026-03-03 09:31:45','2026-03-03 10:17:38'),(25,56,270,'BKQC9999','2026-10-20',7,'2026-10-21','2026-10-20',NULL,'dipinjam','2026-10-20 01:48:46','2026-10-20 01:48:49');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajuan_buku`
--

DROP TABLE IF EXISTS `pengajuan_buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengajuan_buku` (
  `id_pengajuan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) NOT NULL,
  `nama_penulis` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `nama_pengusul` varchar(255) NOT NULL,
  `id_pengguna` bigint(20) unsigned DEFAULT NULL,
  `id_buku` bigint(20) unsigned DEFAULT NULL,
  `alasan_pengusulan` text NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') NOT NULL DEFAULT 'menunggu',
  `catatan_admin` text DEFAULT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan`),
  KEY `pengajuan_buku_id_buku_foreign` (`id_buku`),
  CONSTRAINT `pengajuan_buku_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajuan_buku`
--

LOCK TABLES `pengajuan_buku` WRITE;
/*!40000 ALTER TABLE `pengajuan_buku` DISABLE KEYS */;
INSERT INTO `pengajuan_buku` VALUES (13,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,1,'2026-10-20 01:08:15','2026-10-20 01:29:41'),(14,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,NULL,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',1,'2026-10-20 01:08:16','2026-10-20 01:29:41'),(15,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',1,'2026-10-20 01:08:17','2026-10-20 01:29:41'),(16,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,1,'2026-10-20 01:11:39','2026-10-20 01:29:41'),(17,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,NULL,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',1,'2026-10-20 01:11:39','2026-10-20 01:29:41'),(18,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',1,'2026-10-20 01:11:40','2026-10-20 01:29:41'),(19,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,1,'2026-10-20 01:18:15','2026-10-20 01:29:41'),(20,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,NULL,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',1,'2026-10-20 01:18:15','2026-10-20 01:29:41'),(21,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',1,'2026-10-20 01:18:16','2026-10-20 01:29:41'),(22,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,1,'2026-10-20 01:21:32','2026-10-20 01:27:46'),(23,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,NULL,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',1,'2026-10-20 01:21:32','2026-10-20 01:29:41'),(24,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',1,'2026-10-20 01:21:33','2026-10-20 01:29:41'),(25,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,1,'2026-10-20 01:25:37','2026-10-20 01:29:41'),(26,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,NULL,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',1,'2026-10-20 01:25:37','2026-10-20 01:29:41'),(27,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',1,'2026-10-20 01:25:38','2026-10-20 01:29:41'),(28,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,0,'2026-10-20 01:47:45','2026-10-20 01:47:45'),(29,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,269,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',0,'2026-10-20 01:47:45','2026-10-20 01:47:46'),(30,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',0,'2026-10-20 01:47:46','2026-10-20 01:47:47'),(31,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,0,'2026-10-20 01:52:09','2026-10-20 01:52:09'),(32,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,271,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',0,'2026-10-20 01:52:09','2026-10-20 01:52:10'),(33,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',0,'2026-10-20 01:52:10','2026-10-20 01:52:11'),(34,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,0,'2026-10-20 02:10:39','2026-10-20 02:10:39'),(35,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,273,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',0,'2026-10-20 02:10:39','2026-10-20 02:10:41'),(36,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',0,'2026-10-20 02:10:41','2026-10-20 02:10:42'),(37,'Designing Data-Intensive Applications','Martin Kleppmann','978-1449373320','O\'Reilly Media',2017,'Teknologi','Anggota Test Readify',56,NULL,'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.','menunggu',NULL,0,'2026-10-20 03:00:51','2026-10-20 03:00:51'),(38,'Domain-Driven Design','Eric Evans','9780321125217','Addison-Wesley',2003,'Teknologi','Anggota Test',56,274,'Buku fundamental untuk software architecture dan microservices pattern.','disetujui','Usulan buku disetujui, buku telah tersedia di Rak T-05.',0,'2026-10-20 03:00:51','2026-10-20 03:00:53'),(39,'Buku yang Ditolak','Penulis Random',NULL,NULL,NULL,NULL,'Anggota Test',56,NULL,'Hanya ingin mengusulkan buku ini untuk perpustakaan.','ditolak','Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',0,'2026-10-20 03:00:53','2026-10-20 03:00:55');
/*!40000 ALTER TABLE `pengajuan_buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengguna` (
  `id_pengguna` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `level_akses` enum('admin','petugas','anggota') NOT NULL,
  `status` enum('pending','active','rejected') NOT NULL DEFAULT 'pending',
  `nomor_anggota` varchar(50) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `pengguna_email_unique` (`email`),
  UNIQUE KEY `pengguna_nomor_anggota_unique` (`nomor_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (30,'Faiz AP','admins@readify.id','$2y$12$m6ISvIyQXNVgozEUrGQt4uoeFhRC2/g6kSpyQp1ilkQJtwtBUpk7C','admin','active',NULL,NULL,'2026-02-24 14:54:59','2026-10-20 00:05:53',NULL),(32,'Admin Readify','admin@readify.id','$2y$12$n0zeimsmb0H7olal9CIf4OlmndVIQn3qoY9cq/hE7c.NqNGbXvDRm','admin','active',NULL,NULL,'2026-10-19 23:50:21','2026-10-20 00:05:52',NULL),(45,'Lazver','peritzzx@gmail.com','$2y$12$arSIlUPLWkW7RDjQGn8t5u6Yw1PqxXYtXbMPsnp9IQJUcU4DwmbHm','anggota','active','ID-2-PX-2026',NULL,'2026-02-23 03:57:04','2026-10-20 00:05:55','1772202437_2017-12-06.png'),(46,'Dika','dika@gmail.com','$2y$12$xtKRD/LN/LLIOgV3ZjRF9uLqXqc5TNwTemwpMudoGNUrtlRP3PJx2','anggota','active','ID-4-PX-2026',NULL,'2026-02-23 17:48:02','2026-03-03 10:00:52',NULL),(48,'Officer Readify','officer@readify.id','$2y$12$oDunclKmZxoWk9wUWhr2S.Ts9gFz9mrKXwsD2rKuXxuXLteUedxxi','petugas','active',NULL,NULL,'2026-02-24 14:56:18','2026-10-20 00:05:54',NULL),(49,'Damm','adam@gmail.com','$2y$12$Jx2sT/QuwHBXO7EjfNqNKubfNgFRK07btsg9UpRnQWRe0OAc7iFVS','anggota','active','ID-3-PX-2026',NULL,'2026-02-26 04:30:29','2026-02-26 19:12:11',NULL),(50,'Anggota Readify','anggota@readify.id','$2y$12$CMZjbbad4W9dfB4IbLLk2enMX5XRxSVI0Tw3rY0Aoc5jX.xGA7Ajq','anggota','active','ID-1-PX-2026',NULL,'2026-10-19 23:50:07','2026-10-20 00:05:54',NULL),(52,'Petugas Readify','petugas@readify.id','$2y$12$M9ZMV42RG57m3YNDIDTZ5O0rqLQZThKIQSwwtiZl/SU4.h5DvjVXe','petugas','active',NULL,NULL,'2026-10-19 23:50:39','2026-10-20 00:05:53',NULL),(55,'admin_test','admin_test@readify.id','$2y$04$5QtHW6KVKZ2qm4y/6xdadu69HoGdKyqWoSLL.PrIaJVWRWxM/T9dS','admin','active',NULL,NULL,'2026-10-20 01:08:14','2026-10-20 01:08:14',NULL),(56,'anggota_test','anggota_test@readify.id','$2y$04$NqUAL5apWSXQI4iN9d0ULOGjlJVKanIODtaYFMbDfaGus0kgbEtBu','anggota','active',NULL,NULL,'2026-10-20 01:08:14','2026-10-20 01:08:14',NULL),(57,'naufal_reads','naufal@readify.id','$2y$12$UhnqofYsZuxZ7dWNYXGQyOQAemDQfSmpyEZg6SWg0dVaV8zPhCthK','anggota','active','AGT-5730',NULL,'2026-10-20 02:07:52','2026-10-20 02:07:52',NULL),(58,'zahra_literasi','zahra@readify.id','$2y$12$5GxyntXnWsYnYRLgsc0VpezWovvcltgdCSiqFWn9.wNmcTA/H/qJK','anggota','active','AGT-5507',NULL,'2026-10-20 02:08:17','2026-10-20 02:08:17',NULL),(59,'rizky_manga','rizky@readify.id','$2y$12$6fwylK392Le4NSjgo/2p..Y4ZqXej47fZgD2ZMOvWrpS8Egnxr1a2','anggota','active','AGT-3098',NULL,'2026-10-20 02:08:18','2026-10-20 02:08:18',NULL),(60,'alya_safira','alya@readify.id','$2y$12$LcndaVsWyfRECIkSA95MNeUFfV0eC6b0jqevgMJuzz6rQvKLoK2Qu','anggota','active','AGT-8671',NULL,'2026-10-20 02:08:18','2026-10-20 02:08:18',NULL),(61,'dimas_finance','dimas@readify.id','$2y$12$Zzh5nQL.t.kW5ykI96VO1.bqRvN7PBrnHxgXnU3jR95z6j4CcWhfO','anggota','active','AGT-4206',NULL,'2026-10-20 02:08:18','2026-10-20 02:08:18',NULL),(62,'komunitas_user1','komunitas_test1@readify.id','$2y$04$UKVjiTbcluSNNqxbudLSaOOkvKTIEgoZavSWRKvhnjv6X32YNodNS','anggota','active',NULL,NULL,'2026-10-20 02:08:56','2026-10-20 02:08:56',NULL),(63,'komunitas_user2','komunitas_test2@readify.id','$2y$04$KmBZP7GQYyQIrl97.xk6cuAUCZvplJ2cOU3JD78TRSEAW/4CYb5Mi','anggota','active',NULL,NULL,'2026-10-20 02:08:56','2026-10-20 02:08:56',NULL);
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `postingan_komunitas`
--

DROP TABLE IF EXISTS `postingan_komunitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `postingan_komunitas` (
  `id_postingan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `id_buku` bigint(20) unsigned DEFAULT NULL,
  `tipe` varchar(30) NOT NULL DEFAULT 'diskusi',
  `rating` tinyint(4) DEFAULT NULL,
  `konten` text NOT NULL,
  `jumlah_like` int(10) unsigned NOT NULL DEFAULT 0,
  `jumlah_komentar` int(10) unsigned NOT NULL DEFAULT 0,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_postingan`),
  KEY `postingan_komunitas_id_pengguna_foreign` (`id_pengguna`),
  KEY `postingan_komunitas_id_buku_foreign` (`id_buku`),
  CONSTRAINT `postingan_komunitas_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE SET NULL,
  CONSTRAINT `postingan_komunitas_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postingan_komunitas`
--

LOCK TABLES `postingan_komunitas` WRITE;
/*!40000 ALTER TABLE `postingan_komunitas` DISABLE KEYS */;
INSERT INTO `postingan_komunitas` VALUES (1,59,178,'review',5,'Baru kelar baca Solo Leveling Vol 1 yang baru dipajang di Rak Manga. Asli visual manhwa-nya pas scene double dungeon merinding banget parah! Buat yang baru mau ngikutin kisah Sung Jin-woo, mumpung stok di perpus ada beberapa eks mending buruan pinjam sekarang sebelum keduluan yang lain wkwk 🔥⚔️',14,9,'2026-10-20 01:23:18','2026-10-20 02:13:57'),(2,58,233,'diskusi',NULL,'Ada yang udah nerapin konsep \'2-Minute Rule\' dari buku Atomic Habits? Gue coba buat rutinitas baca buku sebelum tidur, awalnya males banget tapi pas dipaksa 2 menit doang malah kebablasan baca 1 bab tiap malem haha.\n\nMenurut kalian konsep mana di buku ini yang paling ngaruh ke kehidupan sehari-hari?',22,3,'2026-10-20 00:08:18','2026-10-20 00:08:18'),(3,57,253,'diskusi',NULL,'Lagi baca ulang Clean Code karya Uncle Bob di pojok perpus lantai 2. Paling setuju sama bab \'Meaningful Names\'—bikin nama variabel jangan pelit-pelit kek kode rahasia FBI wkwk.\n\nTapi menurut temen-temen programmer di sini, buku ini masih relevan ga sih buat modern development framework kayak sekarang?',18,2,'2026-10-19 22:38:18','2026-10-19 22:38:18'),(4,61,234,'kutipan',NULL,'\"Doing well with money has a little to do with how smart you are and a lot to do with how you behave.\"\n— Morgan Housel, The Psychology of Money.\n\nKutipan simpel tapi nampol banget. Mengelola uang itu ternyata bukan cuma soal rumus matematika rumit, tapi tentang bagaimana kita mengendalikan ego dan emosi diri sendiri.',27,2,'2026-10-19 20:08:18','2026-10-19 20:08:18'),(5,60,24,'review',5,'Re-reading Harry Potter edisi terjemahan perpus Readify! Bagi gue seri ketiga (Prisoner of Azkaban) ini yang paling berkesan dari seluruh saga: perkenalan Sirius Black, Remus Lupin, plus konsep Time-Turner yang jenius banget. Bener-bener nostalgia masa kecil 🦉⚡ Siapa karakter favorit kalian di Hogwarts?',19,2,'2026-10-19 18:08:18','2026-10-19 18:08:18'),(6,45,NULL,'diskusi',NULL,'Koleksi buku sama manga di perpus Readify sekarang makin lengkap banget mantap! Ada rekomendasi novel sci-fi atau fiksi seru ga guys buat nemenin akhir pekan ini? Kalau bisa yang ga terlalu berat biar santai bacanya.',15,2,'2026-10-19 16:08:18','2026-10-19 16:08:18'),(7,59,144,'rekomendasi',NULL,'Buat temen-temen yang belum pernah baca manga Attack on Titan versi fisik, mumpung Vol 1 ada di Rak Manga A1 coba luangin waktu baca deh. Pacing chapter pertamanya ga ada obat, langsung dikasih teror Colossal Titan tanpa ampun dari halaman pertama!',31,1,'2026-10-19 12:08:18','2026-10-19 12:08:18'),(8,61,211,'review',4,'Baru selesai membaca sepertiga buku Dune karya Frank Herbert. Bukunya tebel banget dan butuh fokus ekstra karena istilah planet Arrakis-nya banyak, tapi detail politik sama ekologinya beneran masterpiece sci-fi! Worth reading banget.',12,1,'2026-10-19 06:08:18','2026-10-19 06:08:18'),(9,62,272,'review',5,'Ini adalah postingan uji coba untuk testing feed komunitas Readify!',0,0,'2026-10-20 02:08:58','2026-10-20 02:08:58'),(10,62,272,'diskusi',NULL,'Postingan yang akan dikomentari oleh anggota lain.',0,1,'2026-10-20 02:08:58','2026-10-20 02:08:59'),(11,62,NULL,'diskusi',NULL,'Postingan untuk pengujian toggle like AJAX.',1,0,'2026-10-20 02:08:59','2026-10-20 02:09:00'),(13,62,272,'review',5,'Ini adalah postingan uji coba untuk testing feed komunitas Readify!',0,0,'2026-10-20 02:10:20','2026-10-20 02:10:20'),(14,62,272,'diskusi',NULL,'Postingan yang akan dikomentari oleh anggota lain.',0,1,'2026-10-20 02:10:20','2026-10-20 02:10:21'),(15,62,NULL,'diskusi',NULL,'Postingan untuk pengujian toggle like AJAX.',0,0,'2026-10-20 02:10:21','2026-10-20 02:10:22'),(17,62,272,'review',5,'Ini adalah postingan uji coba untuk testing feed komunitas Readify!',0,0,'2026-10-20 02:10:32','2026-10-20 02:10:32'),(18,62,272,'diskusi',NULL,'Postingan yang akan dikomentari oleh anggota lain.',1,1,'2026-10-20 02:10:32','2026-10-20 02:13:37'),(19,62,NULL,'diskusi',NULL,'Postingan untuk pengujian toggle like AJAX.',0,0,'2026-10-20 02:10:33','2026-10-20 02:10:34'),(21,45,158,'diskusi',NULL,'goated',0,0,'2026-10-20 02:14:27','2026-10-20 02:14:27'),(22,62,272,'review',5,'Ini adalah postingan uji coba untuk testing feed komunitas Readify!',0,0,'2026-10-20 03:00:36','2026-10-20 03:00:36'),(23,62,272,'diskusi',NULL,'Postingan yang akan dikomentari oleh anggota lain.',0,1,'2026-10-20 03:00:36','2026-10-20 03:00:39'),(24,62,NULL,'diskusi',NULL,'Postingan untuk pengujian toggle like AJAX.',0,0,'2026-10-20 03:00:39','2026-10-20 03:00:41');
/*!40000 ALTER TABLE `postingan_komunitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('14PDVmuJLaUteejEyvHz2jmkhaFctYeP2E1KK8h9',NULL,'127.0.0.1','','YToyOntzOjY6Il90b2tlbiI7czo0MDoiSFZvUGpqa3RQS2dRSW5kWnpWUkF5ODB3TFZzZDlWR2dEakttQ2s4SiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792483842),('4Yhv9Du8GfyZ78kgnRkY70CsdRb43wvWDzyFLk64',NULL,'127.0.0.1','Go-http-client/1.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoicjJuamZhYW5OM0tLUWFsV2VrRTZtNjJRcEdFblJDWldYd3l6NjJ2SSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792481144),('6HG32BVcFX93JR36IVwvnkTZLehfmP6cYTfYBLbF',NULL,'127.0.0.1','curl/8.21.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiaWJsMVJJM24xaHR6QlJZSzhpR2F4Um1aTnhmUlYxS0J6cnRRVzRqeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792483757),('6s3eYRz8BZDbE8gvCXS99RiTMldjoxmMWTx2VeNr',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9711','YTozOntzOjY6Il90b2tlbiI7czo0MDoibzY1UW54OEZoeElxTXBOcHFsZERQSzF0Q0FMUm02Tll5V3Q0NGZmcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1792486385),('8n64ZcSJyOEhALQuZLS3VQKlLgsewd51Ns0vPkzy',NULL,'127.0.0.1','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoieTgxUzNZb3RKaVhIdXJnRzlJMDBTWVlNc1RhbHNxQUVKYjFFb2ZZRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1792482198),('9vuY7JKJbVO0E1CTxSyN3C3SzqKgjG4ZIPaujdAn',NULL,'127.0.0.1','Go-http-client/1.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoiTmFmM25CS0czRlRtdjd3VjhRTzJDbko0SGFodGxIZ1BmU3ZoeWxpSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792481132),('A9bbUX3VQMHMDg8TwdU4avu8Xq3BxwCPA1xSkDel',NULL,'127.0.0.1','curl/8.21.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiNndFajlONk9FQjROd3F1T3JIWXczWlloc3NqclFqMGZHVHllN2V4ViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792483775),('B9YXCLO8muxyE5WhpTGaqr6JPDJ29uaTIatHjLpq',NULL,'127.0.0.1','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDhwSzM4ODZLRVNSalp0MzlmS001Sjg2cWhFczd5UTYwdVA2cm9veCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792482195),('COmXJE9EzAGqgqeB7TChTAvwMT4lWnXk9GxXtIQL',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidHBKckd4NU1sc1NTc2N5Q3I5TDVveDE4aVFUT1RsUWFHTzVmRTBNaiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1792490481),('csXOaVo5IfgUCZnx5RhrFAWx9G6Ya7QZ63rXJsSI',NULL,'127.0.0.1','Go-http-client/1.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoiVmd6cUhIaDMwSXFJOUtoeTFUSDY2c0VoNHQ3d1FreEppQkpqSlZxYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792482196),('DVxHFvCPjss47Y9PMPOFh09CKM6TvtPGXYnwnUdb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9711','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1RxMnZEMWdaTzJnREtmWk9GYjVhbHh6ejR5aUVrT0puN1dsUnBrbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==',1792483799),('gJHKhk0y7wDRzCOYAbDDXIbOimpLUbDksrFRZ1m5',45,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYTFJRmZ4dVpBWmZZSVp1bXBZVG9lYkRXa1c3MGxVSGtvczgyQjhyYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rb211bml0YXM/YnVrdV9pZD0yNzIiO3M6NToicm91dGUiO3M6MTU6ImtvbXVuaXRhcy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ1O3M6NjoibG9jYWxlIjtzOjI6ImlkIjt9',1792490477),('h8IHGHHX2xgddnI3F57gZbsam85baBO1irIbWDOk',NULL,'127.0.0.1','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmgwemo1TzR5VkgyNTByTGpNblp5QXQ2UHBpTHVkUEg4Y2hEQkpGbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvYnVrdS9zZWFyY2g/cT1PbmUlMjBQaWVjZSI7czo1OiJyb3V0ZSI7czoxNToiYXBpLmJ1a3Uuc2VhcmNoIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792481134),('h9JjIXtv9f37geR2ug456FkwCnziMOetc3DQ7Aza',NULL,'127.0.0.1','curl/8.21.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiV215OHVzNWtZTXN2Y2d4WDRDTmVEZnRNOTBpbjI0QVZpcjZHSFFTcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792483781),('hBUfBmbmGmlrInwutBWhgzm3LFGi5IZeGxclcVaZ',NULL,'127.0.0.1','Go-http-client/1.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibmg4V1hVSGg4TmI3emFYd1dyM2tXQ1IxUVgxeTFXalNjVTFCSG5jRSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FqdWthbi1idWt1Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hanVrYW4tYnVrdSI7czo1OiJyb3V0ZSI7czoyMToicGVuZ2FqdWFuLWJ1a3UuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792482197),('jCBAoeczgUsKc5seg8LHPqyjflTrCWEExAN1ZKum',NULL,'127.0.0.1','','YToyOntzOjY6Il90b2tlbiI7czo0MDoiQ0VoYXJmOUVjVm1Eb1JLa3VXU1pVc0dmUU1COFNKRlZwaEZLTjVNcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792483857),('vF9TyWvoApTZpg8DiKcQV60IgBDMNnRrxfbHNptS',45,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWmY1MDhMNnk1U1BxME0wMEtkMVpqcHRwU014OVhtU0NqZTNGWTZiUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hbmdnb3RhL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoiYW5nZ290YS5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6ImxvY2FsZSI7czoyOiJpZCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDU7fQ==',1792549707),('X5htqsaklqe6nccjCgtDnIDuxqcPkFENfC0Ou0gl',NULL,'127.0.0.1','Go-http-client/1.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVRjQ05UUVJzeVpCWjdCUGdNT0daTG40cmdQYXU1a2J0YnNmV3pSQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvYnVrdS9zZWFyY2g/cT1IYXJyeSUyMFBvdHRlciI7czo1OiJyb3V0ZSI7czoxNToiYXBpLmJ1a3Uuc2VhcmNoIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792481145),('xBDXUjtv5NXw8x7ITe3QzgP9MVHCt6ZlV1YzGoNZ',NULL,'127.0.0.1','curl/8.21.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoia1hocFVWQnZRbTUzbjdQd3p0TTJEaldCaXBHZzY3TnZTTWdERlVqZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792480087),('ydfO3PbLwxrMSCHCqKLOBRM6kYROPRtYrbeiwbpg',NULL,'127.0.0.1','','YToyOntzOjY6Il90b2tlbiI7czo0MDoiaU45MmEzT3lPNjZtN0FIa3dpUXBuakRWM09TQVgyTWEwMUw5TkxpOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792483883);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_family_hash_index` (`family_hash`),
  KEY `telescope_entries_created_at_index` (`created_at`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries`
--

LOCK TABLES `telescope_entries` WRITE;
/*!40000 ALTER TABLE `telescope_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries_tags`
--

LOCK TABLES `telescope_entries_tags` WRITE;
/*!40000 ALTER TABLE `telescope_entries_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_monitoring`
--

LOCK TABLES `telescope_monitoring` WRITE;
/*!40000 ALTER TABLE `telescope_monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ulasan` (
  `id_ulasan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_buku` bigint(20) unsigned NOT NULL,
  `id_pengguna` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `isi_ulasan` text DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_ulasan`),
  UNIQUE KEY `ulasan_id_buku_id_pengguna_unique` (`id_buku`,`id_pengguna`),
  KEY `ulasan_id_pengguna_foreign` (`id_pengguna`),
  CONSTRAINT `ulasan_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  CONSTRAINT `ulasan_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ulasan`
--

LOCK TABLES `ulasan` WRITE;
/*!40000 ALTER TABLE `ulasan` DISABLE KEYS */;
INSERT INTO `ulasan` VALUES (1,11,45,5,'Ada karya yang bagus. Ada karya yang cerdas. Lalu ada karya yang bikin kamu duduk diam beberapa menit setelah selesai membaca—karena kamu nggak yakin barusan itu kenyataan, manipulasi, atau kenangan yang sudah dibentuk ulang. Goodbye, Eri masuk kategori terakhir.\r\n\r\nKarya one-shot dari Tatsuki Fujimoto ini bukan cuma cerita tentang kehilangan. Ini meditasi tentang bagaimana manusia memproses trauma lewat media—dan bagaimana kamera bisa jadi tameng sekaligus pisau.','2026-02-26 04:27:20','2026-02-26 04:27:20');
/*!40000 ALTER TABLE `ulasan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','petugas','pengguna') NOT NULL DEFAULT 'pengguna',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (30,'Admin Readify','admins@readify.id','admin','2026-02-24 14:54:47','$2y$12$MRQQjBfAeqUGT6aqVxExDOtebLLrMWgRyI6EaJXO6RZF195kaNLWK',NULL,'2026-02-24 14:54:47','2026-10-20 00:05:53'),(31,'Petugas Perpustakaan','officer@readify.id','petugas','2026-02-24 14:56:15','$2y$12$39BtdqnvzB0CwabvW/VNa.49AhcndkEVaK41kMy6O78nME4ZTt2Ka',NULL,'2026-02-24 14:56:15','2026-10-20 00:05:54'),(32,'Admin Readify','admin@readify.id','admin','2026-10-20 00:04:29','$2y$12$LDgIoafMbW6pWqxsJ0T3kei7Ely81.X81wsd2UJ97WiHZFbVOMgJu',NULL,'2026-10-20 00:04:29','2026-10-20 00:05:52'),(33,'Petugas Readify','petugas@readify.id','petugas','2026-10-20 00:04:30','$2y$12$UPcIE18.ISZQv4PxAcR6NOz4uDPXX62tEJ4dI3NkgP.vWIPIipWBe',NULL,'2026-10-20 00:04:30','2026-10-20 00:05:53'),(34,'Anggota Readify','anggota@readify.id','pengguna','2026-10-20 00:05:54','$2y$12$LL.m.ZlQAx4I0PghpLB.COHQXY/mMw8PcqICi5avcNijMN4.LroOa',NULL,'2026-10-20 00:05:54','2026-10-20 00:05:54'),(35,'Lazver','peritzzx@gmail.com','pengguna','2026-10-20 00:05:55','$2y$12$GDsLSmXDTuBpFUxiyjWvQ.QYruE5vmfsHbuloHQDBu5vKJNQd92sm',NULL,'2026-10-20 00:05:55','2026-10-20 00:05:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-22 14:05:29
