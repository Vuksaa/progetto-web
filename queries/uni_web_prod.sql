-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: uni_web_prod
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_name` varchar(90) NOT NULL,
  `address_info` varchar(90) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `client_id_idx` (`client_id`),
  CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'Casa','Via Guglielmo Oberdan 20',1),(2,'Casa','Via Raniero Arsendi 13',2),(3,'Lavoro','Via Giacomo della Torre 7',2),(4,'Casa','Via Solferino 1',3),(5,'Casa','Via Romanello da Forli 11',4),(6,'Casa','Via Valverde 28',5),(7,'Nonna','Via Lombardini 4',5),(8,'Casa','Via Alberto Bani 4',6),(9,'Casa','Via Italo Stegher 10',7),(10,'Casa','Viale Roma 31',8),(11,'Casa','Via Leonardo Da Vinci 2',9),(13,'Lavoro','Via Domenico Martoni 21',10),(15,'Casa','Via Romeo Galli 50',10);
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allergen`
--

DROP TABLE IF EXISTS `allergen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allergen` (
  `allergen_id` int(11) NOT NULL AUTO_INCREMENT,
  `allergen_name` varchar(45) NOT NULL,
  PRIMARY KEY (`allergen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allergen`
--

LOCK TABLES `allergen` WRITE;
/*!40000 ALTER TABLE `allergen` DISABLE KEYS */;
INSERT INTO `allergen` VALUES (1,'Mollusco'),(2,'Uovo'),(3,'Pesce'),(4,'Latte'),(5,'Arachidi'),(6,'Soia'),(7,'Noci'),(8,'Grano'),(9,'Glutine'),(10,'Grano saraceno'),(11,'Lupino'),(12,'Frutti di mare'),(13,'Mostarda'),(14,'Sesamo'),(15,'Solfiti'),(16,'Propoli'),(17,'Pappa reale'),(18,'Mango'),(19,'Pesca'),(20,'Maiale'),(21,'Pomodoro'),(22,'Lattice di gomma naturale');
/*!40000 ALTER TABLE `allergen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Osteria'),(2,'Pub'),(3,'Piadineria'),(4,'Aperto tardi'),(5,'Colazione'),(6,'Hamburgeria'),(7,'Vegetariano'),(8,'Vegano'),(9,'Orientale'),(10,'Sushi'),(11,'Tradizione locale'),(12,'Dolci'),(13,'Poche calorie'),(14,'Pesce');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_email` varchar(45) NOT NULL,
  `client_password` varchar(255) NOT NULL,
  `client_name` varchar(45) NOT NULL,
  `client_surname` varchar(45) NOT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `client_email` (`client_email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'haldor.rasim@gmail.com','$2y$10$thistringisforsalttesedksZnocIeYFWqF7N42YiEVD3nN4lurW','Haldor','Rasim'),(2,'izz.helga@gmail.com','$2y$10$thistringisforsaltteseYgVq.zjH5kw.PK4VALrtmzuXAyvjJUm','Izz ud-Din','Helga'),(3,'njal.itimad@gmail.com','$2y$10$thistringisforsaltteseaWOuwRELXu9YKf5dZ5iM2lji36.XXgy','Njal','I\'timad'),(4,'stefana.dawood@gmail.com','$2y$10$thistringisforsaltteseC1l1j26Al1NUOfGwYTxF0ItpB6np0Ky','Stefana','Dawood'),(5,'toki.halvor@gmail.com','$2y$10$thistringisforsalttesenibGdpGtbO8/u5DkwW6tXvBKxiletfS','Toki','Halvor'),(6,'benjaminas.khadija@gmail.com','$2y$10$thistringisforsaltteseVnVZW1RLBWoySCL4u//1V7rz9v1KsFu','Benjaminas','Khadija'),(7,'sverrir.ingvildr@gmail.com','$2y$10$thistringisforsaltteseNhwvhIkYizPXGBsdsMBjw2hU9jA9eaC','Sverrir','Ingvildr'),(8,'johanneke.tycho@gmail.com','$2y$10$thistringisforsalttesehzkoHNhmxQ2p8yds7ZQOc6LtHA9aNSC','Johanneke','Tycho'),(9,'fazl.shafaqat@gmail.com','$2y$10$thistringisforsaltteseQVV3fUSGqPdkk/4KtMniX2AoJaz3Jge','Fazl','Shafaqat'),(10,'1@1.1','$2y$10$thistringisforsaltteseLwlFrjHJ8POpCmXJK9.Fi20B1/CCdPO','1','1');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_allergen`
--

DROP TABLE IF EXISTS `client_allergen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_allergen` (
  `client_id` int(11) NOT NULL,
  `allergen_id` int(11) NOT NULL,
  PRIMARY KEY (`client_id`,`allergen_id`),
  KEY `allergen_id` (`allergen_id`),
  CONSTRAINT `client_allergen_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  CONSTRAINT `client_allergen_ibfk_2` FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`allergen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_allergen`
--

LOCK TABLES `client_allergen` WRITE;
/*!40000 ALTER TABLE `client_allergen` DISABLE KEYS */;
INSERT INTO `client_allergen` VALUES (1,4),(1,5),(10,1),(10,4),(10,9),(10,14),(10,16),(10,17);
/*!40000 ALTER TABLE `client_allergen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_order`
--

DROP TABLE IF EXISTS `client_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_order` (
  `client_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`client_id`,`order_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `client_order_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  CONSTRAINT `client_order_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_order`
--

LOCK TABLES `client_order` WRITE;
/*!40000 ALTER TABLE `client_order` DISABLE KEYS */;
INSERT INTO `client_order` VALUES (10,5),(10,6),(10,8),(10,9),(10,10),(10,11),(10,12),(10,13),(10,14),(10,15),(10,16),(10,17),(10,18),(10,19),(10,20),(10,21),(10,22),(10,23),(10,24),(10,25),(10,26),(10,27),(10,28),(10,29),(10,30),(10,31),(10,32),(10,33),(10,34),(10,35),(10,36),(10,37),(10,38),(10,39),(10,40),(10,41);
/*!40000 ALTER TABLE `client_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_provider`
--

DROP TABLE IF EXISTS `client_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_provider` (
  `client_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  PRIMARY KEY (`client_id`,`provider_id`),
  KEY `provider_id` (`provider_id`),
  CONSTRAINT `client_provider_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  CONSTRAINT `client_provider_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_provider`
--

LOCK TABLES `client_provider` WRITE;
/*!40000 ALTER TABLE `client_provider` DISABLE KEYS */;
INSERT INTO `client_provider` VALUES (1,3),(1,5),(2,5),(3,1),(3,2),(4,5),(4,7),(5,1),(5,8),(6,3),(6,7),(7,2),(7,5),(7,6),(7,7),(8,2),(10,1),(10,5),(10,8);
/*!40000 ALTER TABLE `client_provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredient` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_name` varchar(45) NOT NULL,
  `allergen_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ingredient_id`),
  KEY `allergen_id_idx` (`allergen_id`),
  CONSTRAINT `allergen_id` FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`allergen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredient`
--

LOCK TABLES `ingredient` WRITE;
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` VALUES (1,'Alcol',NULL),(2,'Ammoniaca per dolci',NULL),(3,'Coloranti alimentari',NULL),(4,'Caff?¿',NULL),(5,'Cinghiale',NULL),(6,'Fegato',NULL),(7,'Filetto',NULL),(8,'Manzo',NULL),(9,'Petto di pollo',NULL),(10,'Tacchino',NULL),(11,'Vitello',NULL),(12,'Avena',NULL),(13,'Farro',NULL),(14,'Orzo',NULL),(15,'Quinoia',NULL),(16,'Riso',NULL),(17,'Astice',3),(18,'Capesante',3),(19,'Cozze',3),(20,'Cicale di mare',3),(21,'Gamberoni',3),(22,'Polpo',3),(23,'Seppia',3),(24,'Frutti di mare',3),(25,'Miele',NULL),(26,'Caramello',NULL),(27,'Zucchero',NULL),(28,'Zucchero di canna',NULL),(29,'Alloro',NULL),(30,'Erba cipollina',NULL),(31,'Basilico',NULL),(32,'Maggiorana',NULL),(33,'Menta',NULL),(34,'Prezzemolo',NULL),(35,'Origano',NULL),(36,'Rosmarino',NULL),(37,'Timo',NULL),(38,'Farina 0',8),(39,'Farina 00',8),(40,'Farina di canapa',NULL),(41,'Farina di farro',NULL),(42,'Farina di mais',NULL),(43,'Farina integrale',NULL),(44,'Farina di riso',NULL),(45,'Semola',NULL),(46,'Caciocavallo',4),(47,'Caprino',4),(48,'Feta',4),(49,'Cheddar',4),(50,'Emmental',4),(51,'Philadelphia',4),(52,'Gruviera',4),(53,'Grana',4),(54,'Gorgonzola',4),(55,'Parmigiano',4),(56,'Pecorino',4),(57,'Provolone',4),(58,'Arance',NULL),(59,'Banane',NULL),(60,'Fichi',NULL),(61,'Ciliegie',NULL),(62,'Kiwi',NULL),(63,'Limone',NULL),(64,'Frutti di bosco',NULL),(65,'Pesche',19),(66,'More',NULL),(67,'Mirtilli',NULL),(68,'Cocco',NULL),(69,'Papaya',NULL),(70,'Lime',NULL),(71,'Mango',NULL),(72,'Anacardi',7),(73,'Arachidi',7),(74,'Bacche di Goji',7),(75,'Mandorle',7),(76,'Pinoli',7),(77,'Noci',7),(78,'Nocciole',7),(79,'Carote',NULL),(80,'Funghi',NULL),(81,'Funghi porcini',NULL),(82,'Daikon',NULL),(83,'Patate',NULL),(84,'Ravanelli',NULL),(85,'Tartufo',NULL),(86,'Burro',NULL),(87,'Besciamella',NULL),(88,'Latte',NULL),(89,'Latte di mandorla',NULL),(90,'Mozzarella',NULL),(91,'Ricotta',NULL),(92,'Fagiolini',NULL),(93,'Fave',NULL),(94,'Piselli',NULL),(95,'Lenticchie',NULL),(96,'Fagioli',NULL),(97,'Aceto balsamico',NULL),(98,'Ketchup',NULL),(99,'Salsa tartara',NULL),(100,'Maionese',2),(101,'Olio di oliva',NULL),(102,'Tabasco',NULL),(103,'Salsa barbecue',NULL),(104,'Wasabi',NULL),(105,'Salsa di soia',NULL),(106,'Asparagi',NULL),(107,'Cavolfiore',NULL),(108,'Cetrioli',NULL),(109,'Cipolle',NULL),(110,'Aglio',NULL),(111,'Peperoni',NULL),(112,'Zucchine',NULL),(113,'Lasagne',NULL),(114,'Spaghetti',NULL),(115,'Penne',NULL),(116,'Acciughe',3),(117,'Orata',3),(118,'Pesce spada',3),(119,'Pesce persico',3),(120,'Salmone',3),(121,'Tonno',3),(122,'Spigola',3),(123,'Sgombro',3),(124,'Bacon',NULL),(125,'Cotechino',NULL),(126,'Guanciale',NULL),(127,'Salame',NULL),(128,'Pancetta',NULL),(129,'Prosciutto crudo',NULL),(130,'Prosciutto cotto',NULL),(131,'Uova',2),(132,'Curry',NULL),(133,'Paprica',NULL),(134,'Zenzero',NULL),(135,'Wurstel',NULL),(136,'Hamburger',NULL),(137,'Lattuga',NULL),(138,'Pomodoro',NULL),(139,'Pollo',NULL),(140,'Cornflakes',NULL),(141,'Birra',NULL),(143,'Formaggi',NULL),(144,'Mais',NULL),(145,'Avocado',NULL),(146,'Salsa Fuego',NULL),(147,'Tequila',NULL),(148,'Tortilla',NULL);
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `ingredient_by_product`
--

DROP TABLE IF EXISTS `ingredient_by_product`;
/*!50001 DROP VIEW IF EXISTS `ingredient_by_product`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `ingredient_by_product` (
  `product_id` tinyint NOT NULL,
  `ingredient_name` tinyint NOT NULL,
  `allergen_name` tinyint NOT NULL,
  `allergen_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_address` varchar(90) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '4',
  `last_status_update` datetime NOT NULL,
  `creation_timestamp` datetime NOT NULL,
  `rejection_reason` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `status_id_idx` (`status_id`),
  CONSTRAINT `status_id` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (5,'Via Romeo Galli 50',2,'2019-05-24 12:19:46','2019-05-24 12:19:46',NULL),(6,'Via Domenico Martoni 21',3,'2019-06-26 21:34:36','2019-05-24 12:22:48',NULL),(8,'Via Domenico Martoni 21',3,'2019-05-25 12:21:25','2019-05-25 12:21:25',NULL),(9,'Corso della Repubblica 3',2,'2019-06-24 20:42:16','2019-06-24 20:42:16',NULL),(10,'Via Romeo Galli 50',2,'2019-06-26 21:41:50','2019-06-18 16:48:42','aAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'),(11,'Via Romeo Galli 50',3,'2019-06-26 21:42:05','2019-06-18 16:53:36',NULL),(12,'Via Romeo Galli 50',2,'2019-06-26 21:42:00','2019-06-18 16:54:26',''),(13,'Via Romeo Galli 50',2,'2019-06-26 21:41:58','2019-06-18 16:54:26',''),(14,'Via Romeo Galli 50',3,'2019-06-26 21:42:05','2019-06-18 16:54:26',NULL),(15,'Via Romeo Galli 50',2,'2019-06-26 21:42:03','2019-06-18 16:54:27',''),(16,'Via Romeo Galli 50',2,'2019-06-24 20:43:33','2019-06-24 20:43:33',NULL),(17,'Via Romeo Galli 50',3,'2019-06-26 21:35:07','2019-06-24 20:43:36',NULL),(18,'Via Romeo Galli 50',3,'2019-06-26 21:35:22','2019-06-18 17:04:18',NULL),(19,'Via Romeo Galli 50',3,'2019-06-26 21:40:29','2019-06-18 17:04:38',NULL),(20,'Via Romeo Galli 50',3,'2019-06-26 21:40:40','2019-06-18 17:04:47',NULL),(21,'Via Romeo Galli 50',3,'2019-06-26 21:40:45','2019-06-18 17:04:58',NULL),(22,'Via Domenico Martoni 21',2,'2019-06-25 21:42:23','2019-06-18 17:05:27','1234'),(23,'Via Romeo Galli 50',3,'2019-06-24 20:29:15','2019-06-24 20:29:15',NULL),(24,'Via Romeo Galli 50',2,'2019-06-25 21:45:48','2019-06-25 21:37:22','PROVA'),(25,'Via Romeo Galli 50',2,'2019-06-25 21:46:00','2019-06-25 21:37:24',''),(26,'Via Domenico Martoni 21',2,'2019-06-25 21:46:56','2019-06-25 21:45:35','oggi non mangi'),(27,'Via Domenico Martoni 21',3,'2019-06-26 21:49:28','2019-06-25 21:45:35',NULL),(28,'Via Domenico Martoni 21',3,'2019-06-26 21:50:06','2019-06-25 21:45:36',NULL),(29,'Via Romeo Galli 50',2,'2019-06-25 21:51:39','2019-06-25 21:47:18','gfhgfhfhgfhgf'),(30,'Via Romeo Galli 50',3,'2019-06-26 21:31:25','2019-06-26 21:05:46',NULL),(31,'Via Domenico Martoni 21',3,'2019-06-26 21:50:52','2019-06-26 21:05:48',NULL),(32,'1234',3,'2019-06-27 18:32:55','2019-06-26 21:09:45',NULL),(33,'Via Romeo Galli 50',2,'2019-06-26 21:49:23','2019-06-26 21:41:17','NOPE NOPE'),(34,'Piazza saffi',2,'2019-06-26 21:42:46','2019-06-26 21:42:32','test'),(35,'Piazza saffi',3,'2019-06-26 21:42:55','2019-06-26 21:42:49',NULL),(36,'Via Romeo Galli 50',2,'2019-06-26 21:50:41','2019-06-26 21:50:28','aaaa'),(37,'Via Romeo Galli 50',3,'2019-06-27 18:32:56','2019-06-26 21:50:47',NULL),(38,'Via Romeo Galli 50',4,'0000-00-00 00:00:00','2019-06-27 23:24:48',NULL),(39,'Via Romeo Galli 50',4,'0000-00-00 00:00:00','2019-06-27 23:24:52',NULL),(40,'Via Domenico Martoni 21',4,'0000-00-00 00:00:00','2019-06-27 23:26:00',NULL),(41,'Via Romeo Galli 50',4,'0000-00-00 00:00:00','2019-06-27 23:26:53',NULL);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(45) NOT NULL,
  `product_description` varchar(200) DEFAULT NULL,
  `product_price` float NOT NULL,
  `provider_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `provider_id_idx` (`provider_id`),
  CONSTRAINT `provider_id` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Confettura di albicocche 200g',NULL,2.5,2),(2,'Bacon Cheeseburger',NULL,10,1),(3,'Chicken nuggets',NULL,5,1),(4,'Onion rings',NULL,5,1),(5,'Nachos Chips Cheese',NULL,4,1),(6,'New York Dog',NULL,8,1),(7,'Vegan Fajitas',NULL,7,1),(8,'Acqua 0.5L',NULL,0.33,2),(9,'Biscotti 100g',NULL,1,2),(10,'Latte 1L',NULL,1,2),(11,'Baguette',NULL,0.7,2),(12,'Carne macinata di tacchino 300g',NULL,2.5,2),(13,'Involtini di primavera',NULL,0.8,3),(14,'Pollo alle mandorle',NULL,4,3),(15,'Riso alla cantonese',NULL,2,3),(16,'Wanton fritti',NULL,1,3),(17,'Granchio',NULL,5,3),(18,'Pollo al curry',NULL,3.5,3),(19,'Cacio e pepe',NULL,11,4),(20,'Parmigiana di Melanzane',NULL,6,4),(21,'Burg di pollo',NULL,10.5,4),(22,'Contadino',NULL,12,4),(23,'Vagabondo',NULL,11.5,4),(24,'Vegetariano',NULL,9.5,4),(25,'Piadina cotto e fontina',NULL,4,5),(26,'Piadina crudo squacquerone e rucola',NULL,5,5),(27,'Crescione erbe grigliate',NULL,4,5),(28,'Crescione erbe e salsiccia',NULL,3.5,5),(29,'Crescione zucca e patate',NULL,3,5),(30,'Alici gratinate',NULL,11,6),(31,'Il nostro fritto',NULL,19,6),(32,'Gnocchi di zucca',NULL,13,6),(33,'Strozzapreti',NULL,16,6),(34,'Seppia scottata',NULL,13,6),(35,'Serra croccante',NULL,13,6),(36,'Tataki di ricciola',NULL,14,6),(37,'Antipasto dello Chef secondo stagione',NULL,7,7),(38,'Antipasti del giorno senza glutine',NULL,7,7),(39,'Passatelli asciutti di farro con gambuccio di',NULL,9,7),(40,'Mezze lune al baccal?í e patate saltate con g',NULL,12,7),(41,'Sacher vegan con farro e panna fresca vegetal',NULL,5,7),(42,'Mooncake',NULL,1.89,8),(43,'Prosciutto crudo',NULL,1.49,8),(44,'Spaghetti biologici',NULL,0.55,8),(45,'Insalata di tonno',NULL,0.99,8),(46,'Olio extra vergine di oliva',NULL,2.79,8),(47,'Bruschette',NULL,0.75,8),(48,'Lavazza Suerte Caffe\'','',4.89,8);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `product_by_provider`
--

DROP TABLE IF EXISTS `product_by_provider`;
/*!50001 DROP VIEW IF EXISTS `product_by_provider`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `product_by_provider` (
  `provider_id` tinyint NOT NULL,
  `product_id` tinyint NOT NULL,
  `product_name` tinyint NOT NULL,
  `product_price` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `product_ingredient`
--

DROP TABLE IF EXISTS `product_ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_ingredient` (
  `product_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`ingredient_id`),
  KEY `ingredient_id` (`ingredient_id`),
  CONSTRAINT `product_ingredient_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `product_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_ingredient`
--

LOCK TABLES `product_ingredient` WRITE;
/*!40000 ALTER TABLE `product_ingredient` DISABLE KEYS */;
INSERT INTO `product_ingredient` VALUES (2,49),(2,109),(2,124),(2,136),(2,137),(2,138),(3,139),(3,140),(4,109),(4,141),(5,30),(5,42),(5,143),(6,49),(6,108),(6,111),(6,135),(7,30),(7,80),(7,96),(7,109),(7,111),(7,138),(7,144),(7,145),(7,146),(7,147),(7,148);
/*!40000 ALTER TABLE `product_ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_order`
--

DROP TABLE IF EXISTS `product_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_order` (
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `notes` varchar(180) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`order_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `product_order_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `product_order_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_order`
--

LOCK TABLES `product_order` WRITE;
/*!40000 ALTER TABLE `product_order` DISABLE KEYS */;
INSERT INTO `product_order` VALUES (2,10,'',1),(2,11,'',1),(2,12,'',1),(2,13,'',1),(2,14,'',1),(2,15,'',1),(2,34,'no pomodoro',1),(2,35,'no pomodoro',1),(2,41,'',1),(6,38,'',1),(6,39,'',1),(42,5,'23141234',5),(42,16,'',1),(42,17,'',1),(42,18,'',1),(42,19,'',1),(42,20,'',1),(42,23,'testtest',11),(42,24,'',1),(42,25,'',1),(42,26,'',1),(42,27,'',1),(42,28,'',1),(42,32,'test notes',1),(42,33,'AAAAAA',1),(42,36,'1234',1),(42,37,'1234',1),(42,40,'',1),(43,5,'CRUDO',2),(43,21,'',1),(43,22,'',1),(43,30,'',1),(43,31,'',1),(43,32,'',1),(44,6,'SPAGHETTIIIIII',2),(45,22,'',1),(45,29,'',1),(45,30,'',1),(45,31,'',1),(46,9,'',1),(47,8,'wow',3),(47,30,'',1),(47,31,'',1),(48,9,'caffe',2);
/*!40000 ALTER TABLE `product_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider`
--

DROP TABLE IF EXISTS `provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(90) NOT NULL,
  `provider_address` varchar(90) NOT NULL,
  `provider_email` varchar(45) NOT NULL,
  `provider_password` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `opening_hours` time NOT NULL,
  `closing_hours` time NOT NULL,
  PRIMARY KEY (`provider_id`),
  UNIQUE KEY `provider_email` (`provider_email`),
  KEY `type_id_idx` (`type_id`),
  CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider`
--

LOCK TABLES `provider` WRITE;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` VALUES (1,'America Graffiti','Via Costanzo II, 11','americagraffiti@gmail.com','$2y$10$thistringisforsaltteseTyRVZyGf4uaLDDdVmF44hw7qyovSjNG',1,'00:00:00','00:00:00'),(2,'Conad','Via Silvio Corbari, 21','conad@gmail.com','$2y$10$thistringisforsaltteseZLEGPDZM4SctKO0PDAMeIkQKruugh3i',2,'08:00:00','18:00:00'),(3,'Rosticceria Cinese \"Oriente\" di Liu','Viale Domenico Bolognesi, 170','oriente@gmail.com','$2y$10$thistringisforsaltteseBGfhCS7GDJUi1eB0eYZj5aP.cXoCfwO',1,'08:00:00','18:00:00'),(4,'Bio Burg','Via Domenico Martoni, 44','bioburg@gmail.com','$2y$10$thistringisforsaltteseKfxVQPm79FsBMDvwck5ySxIahUcAYS2',1,'08:00:00','18:00:00'),(5,'Piadineria \"Da Nino\"','Piazzale Atleti Azzurri d\'Italia, 1','danino@gmail.com','$2y$10$thistringisforsaltteseIU0WseCBu.k6ywNlu30kocqSCb5lw9q',1,'08:00:00','18:00:00'),(6,'Osteria \"Casa di mare\"','Via Theodoli, 6','casadimare@gmail.com','$2y$10$thistringisforsaltteseCYWssbJZWehzUU3uQryGUJ2MQj4frjS',1,'08:00:00','21:00:00'),(7,'Bistro\' Verdepaglia Forli','Corso Armando Diaz, 14','verdepaglia@gmail.com','$2y$10$thistringisforsalttesee0uaQtxbKI/wLHr5saq/Nti3r.w0MDa',1,'08:00:00','14:00:00'),(8,'Lidl','Via A. Ciani, 1','lidl@gmail.com','$2y$10$thistringisforsalttesecMmjobKHfHbqiXq94XsUvHODoolMity',2,'18:00:00','20:00:00'),(9,'2','Corso della Repubblica, 15','2@2.2','$2y$10$thistringisforsaltteseX0.PUA92W8N.oMNR45fjJ1iWTmR0mTS',2,'16:00:00','02:00:00');
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_category`
--

DROP TABLE IF EXISTS `provider_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_category` (
  `provider_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`provider_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `provider_category_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`),
  CONSTRAINT `provider_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_category`
--

LOCK TABLES `provider_category` WRITE;
/*!40000 ALTER TABLE `provider_category` DISABLE KEYS */;
INSERT INTO `provider_category` VALUES (1,5),(1,6),(3,9),(4,6),(5,3),(5,7),(5,11),(6,1),(6,14),(7,4),(9,14);
/*!40000 ALTER TABLE `provider_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Accettato'),(2,'Rifiutato'),(3,'Concluso'),(4,'In attesa');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'Ristorante'),(2,'Supermercato');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `user_email`
--

DROP TABLE IF EXISTS `user_email`;
/*!50001 DROP VIEW IF EXISTS `user_email`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `user_email` (
  `user_email` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `ingredient_by_product`
--

/*!50001 DROP TABLE IF EXISTS `ingredient_by_product`*/;
/*!50001 DROP VIEW IF EXISTS `ingredient_by_product`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ingredient_by_product` AS select `product`.`product_id` AS `product_id`,`ingredient`.`ingredient_name` AS `ingredient_name`,`allergen`.`allergen_name` AS `allergen_name`,`allergen`.`allergen_id` AS `allergen_id` from ((((`provider` join `product` on((`provider`.`provider_id` = `product`.`provider_id`))) join `product_ingredient` on((`product`.`product_id` = `product_ingredient`.`product_id`))) join `ingredient` on((`product_ingredient`.`ingredient_id` = `ingredient`.`ingredient_id`))) left join `allergen` on((`allergen`.`allergen_id` = `ingredient`.`allergen_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `product_by_provider`
--

/*!50001 DROP TABLE IF EXISTS `product_by_provider`*/;
/*!50001 DROP VIEW IF EXISTS `product_by_provider`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `product_by_provider` AS select `provider`.`provider_id` AS `provider_id`,`product`.`product_id` AS `product_id`,`product`.`product_name` AS `product_name`,`product`.`product_price` AS `product_price` from (`provider` join `product` on((`provider`.`provider_id` = `product`.`provider_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `user_email`
--

/*!50001 DROP TABLE IF EXISTS `user_email`*/;
/*!50001 DROP VIEW IF EXISTS `user_email`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `user_email` AS select `client`.`client_email` AS `user_email` from `client` union all select `provider`.`provider_email` AS `user_email` from `provider` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-28 19:46:23
