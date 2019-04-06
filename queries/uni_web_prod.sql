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
  `address_info` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
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
INSERT INTO `allergen` VALUES (1,'Shellfish'),(2,'Eggs'),(3,'Fish'),(4,'Milk'),(5,'Peanuts'),(6,'Soy'),(7,'Nuts'),(8,'Wheat'),(9,'Gluten'),(10,'Buckwheat'),(11,'Lupin'),(12,'Seafood'),(13,'Mustard'),(14,'Sesame'),(15,'Sulfites'),(16,'Propolis'),(17,'Royal Jelly'),(18,'Mango'),(19,'Peach'),(20,'Pork'),(21,'Tomato'),(22,'Natural Rubber Latex');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Osteria'),(2,'Pub'),(3,'Piadineria'),(4,'Aperto tardi'),(5,'Colazione'),(6,'Hamburgeria'),(7,'Vegetariano'),(8,'Vegano'),(9,'Orientale'),(10,'Sushi'),(11,'Tradizione locale'),(12,'Dolci'),(13,'Poche calorie');
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
  `client_password` varchar(45) NOT NULL,
  `client_name` varchar(45) NOT NULL,
  `client_surname` varchar(45) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'haldor.rasim@gmail.com','haldor','Haldor','Rasim'),(2,'izz.helga@gmail.com','izz','Izz ud-Din','Helga'),(3,'njal.itimad@gmail.com','njal','Njal','I\'timad'),(4,'stefana.dawood@gmail.com','stefana','Stefana','Dawood'),(5,'toki.halvor@gmail.com','toki','TÃ³ki','Halvor'),(6,'benjaminas.khadija@gmail.com','benjaminas','Benjaminas','Khadija'),(7,'sverrir.ingvildr@gmail.com','sverrir','Sverrir','Ingvildr'),(8,'johanneke.tycho@gmail.com','johanneke','Johanneke','Tycho'),(9,'fazl.shafaqat@gmail.com','fazl','Fazl','Shafaqat');
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
/*!40000 ALTER TABLE `client_order` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredient`
--

LOCK TABLES `ingredient` WRITE;
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` VALUES (1,'Alcol',NULL),(2,'Ammoniaca per dolci',NULL),(3,'Coloranti alimentari',NULL),(4,'Caffè',NULL),(5,'Cinghiale',NULL),(6,'Fegato',NULL),(7,'Filetto',NULL),(8,'Manzo',NULL),(9,'Petto di pollo',NULL),(10,'Tacchino',NULL),(11,'Vitello',NULL),(12,'Avena',NULL),(13,'Farro',NULL),(14,'Orzo',NULL),(15,'Quinoia',NULL),(16,'Riso',NULL),(17,'Astice',NULL),(18,'Capesante',NULL),(19,'Cozze',NULL),(20,'Cicale di mare',NULL),(21,'Gamberoni',NULL),(22,'Polpo',NULL),(23,'Seppia',NULL),(24,'Frutti di mare',NULL),(25,'Miele',NULL),(26,'Caramello',NULL),(27,'Zucchero',NULL),(28,'Zucchero di canna',NULL),(29,'Alloro',NULL),(30,'Erba cipollina',NULL),(31,'Basilico',NULL),(32,'Maggiorana',NULL),(33,'Menta',NULL),(34,'Prezzemolo',NULL),(35,'Origano',NULL),(36,'Rosmarino',NULL),(37,'Timo',NULL),(38,'Farina 0',NULL),(39,'Farina 00',NULL),(40,'Farina di canapa',NULL),(41,'Farina di farro',NULL),(42,'Farina di mais',NULL),(43,'Farina integrale',NULL),(44,'Farina di riso',NULL),(45,'Semola',NULL),(46,'Caciocavallo',NULL),(47,'Caprino',NULL),(48,'Feta',NULL),(49,'Cheddar',NULL),(50,'Emmental',NULL),(51,'Philadelphia',NULL),(52,'Gruviera',NULL),(53,'Grana',NULL),(54,'Gorgonzola',NULL),(55,'Parmigiano',NULL),(56,'Pecorino',NULL),(57,'Provolone',NULL),(58,'Arance',NULL),(59,'Banane',NULL),(60,'Fichi',NULL),(61,'Ciliegie',NULL),(62,'Kiwi',NULL),(63,'Limone',NULL),(64,'Frutti di bosco',NULL),(65,'Pesche',NULL),(66,'More',NULL),(67,'Mirtilli',NULL),(68,'Cocco',NULL),(69,'Papaya',NULL),(70,'Lime',NULL),(71,'Mango',NULL),(72,'Anacardi',NULL),(73,'Arachidi',NULL),(74,'Bacche di Goji',NULL),(75,'Mandorle',NULL),(76,'Pinoli',NULL),(77,'Noci',NULL),(78,'Nocciole',NULL),(79,'Carote',NULL),(80,'Funghi',NULL),(81,'Funghi porcini',NULL),(82,'Daikon',NULL),(83,'Patate',NULL),(84,'Ravanelli',NULL),(85,'Tartufo',NULL),(86,'Burro',NULL),(87,'Besciamella',NULL),(88,'Latte',NULL),(89,'Latte di mandorla',NULL),(90,'Mozzarella',NULL),(91,'Ricotta',NULL),(92,'Fagiolini',NULL),(93,'Fave',NULL),(94,'Piselli',NULL),(95,'Lenticchie',NULL),(96,'Fagioli',NULL),(97,'Aceto balsamico',NULL),(98,'Ketchup',NULL),(99,'Salsa tartara',NULL),(100,'Maionese',NULL),(101,'Olio di oliva',NULL),(102,'Tabasco',NULL),(103,'Salsa barbecue',NULL),(104,'Wasabi',NULL),(105,'Salsa di soia',NULL),(106,'Asparagi',NULL),(107,'Cavolfiore',NULL),(108,'Cetrioli',NULL),(109,'Cipolle',NULL),(110,'Aglio',NULL),(111,'Peperoni',NULL),(112,'Zucchine',NULL),(113,'Lasagne',NULL),(114,'Spaghetti',NULL),(115,'Penne',NULL),(116,'Acciughe',NULL),(117,'Orata',NULL),(118,'Pesce spada',NULL),(119,'Pesce persico',NULL),(120,'Salmone',NULL),(121,'Tonno',NULL),(122,'Spigola',NULL),(123,'Sgombro',NULL),(124,'Bacon',NULL),(125,'Cotechino',NULL),(126,'Guanciale',NULL),(127,'Salame',NULL),(128,'Pancetta',NULL),(129,'Prosciutto crudo',NULL),(130,'Prosciutto cotto',NULL),(131,'Uova',NULL),(132,'Curry',NULL),(133,'Paprica',NULL),(134,'Zenzero',NULL);
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_address` varchar(90) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `order_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`status_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `order_status_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  CONSTRAINT `order_status_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
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
INSERT INTO `product` VALUES (1,'Confettura di albicocche 200g',NULL,2.5,2),(2,'Bacon Cheeseburger',NULL,10,1),(3,'Chicken nuggets',NULL,5,1),(4,'Onion rings',NULL,5,1),(5,'Nachos Chips Cheese',NULL,4,1),(6,'New York Dog',NULL,8,1),(7,'Vegan Fajitas',NULL,7,1),(8,'Acqua 0.5L',NULL,0.33,2),(9,'Biscotti 100g',NULL,1,2),(10,'Latte 1L',NULL,1,2),(11,'Baguette',NULL,0.7,2),(12,'Carne macinata di tacchino 300g',NULL,2.5,2),(13,'Involtini di primavera',NULL,0.8,3),(14,'Pollo alle mandorle',NULL,4,3),(15,'Riso alla cantonese',NULL,2,3),(16,'Wanton fritti',NULL,1,3),(17,'Granchio',NULL,5,3),(18,'Pollo al curry',NULL,3.5,3),(19,'Cacio e pepe',NULL,11,4),(20,'Parmigiana di Melanzane',NULL,6,4),(21,'Burg di pollo',NULL,10.5,4),(22,'Contadino',NULL,12,4),(23,'Vagabondo',NULL,11.5,4),(24,'Vegetariano',NULL,9.5,4),(25,'Piadina cotto e fontina',NULL,4,5),(26,'Piadina crudo squacquerone e rucola',NULL,5,5),(27,'Crescione erbe grigliate',NULL,4,5),(28,'Crescione erbe e salsiccia',NULL,3.5,5),(29,'Crescione zucca e patate',NULL,3,5),(30,'Alici gratinate',NULL,11,6),(31,'Il nostro fritto',NULL,19,6),(32,'Gnocchi di zucca',NULL,13,6),(33,'Strozzapreti',NULL,16,6),(34,'Seppia scottata',NULL,13,6),(35,'Serra croccante',NULL,13,6),(36,'Tataki di ricciola',NULL,14,6),(37,'Antipasto dello Chef secondo stagione',NULL,7,7),(38,'Antipasti del giorno senza glutine',NULL,7,7),(39,'Passatelli asciutti di farro con gambuccio di',NULL,9,7),(40,'Mezze lune al baccalá e patate saltate con gl',NULL,12,7),(41,'Sacher vegan con farro e panna fresca vegetal',NULL,5,7),(42,'Mooncake',NULL,1.89,8),(43,'Prosciutto crudo',NULL,1.49,8),(44,'Spaghetti biologici',NULL,0.55,8),(45,'Insalata di tonno',NULL,0.99,8),(46,'Olio extra vergine di oliva',NULL,2.79,8),(47,'Bruschette',NULL,0.75,8),(48,'Lavazza Suerte Caffé',NULL,4.89,8);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

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
  `provider_password` varchar(45) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`provider_id`),
  KEY `type_id_idx` (`type_id`),
  CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider`
--

LOCK TABLES `provider` WRITE;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` VALUES (1,'America Graffiti','Via Costanzo II, 11','americagraffiti@gmail.com','americagraffiti',1),(2,'Conad','Via Silvio Corbari, 21','conad@gmail.com','conad',2),(3,'Rosticceria Cinese \"Oriente\" di Liu','Viale Domenico Bolognesi, 170','oriente@gmail.com','oriente',1),(4,'Bio Burg','Via Domenico Martoni, 44','bioburg@gmail.com','bioburg',1),(5,'Piadineria \"Da Nino\"','Piazzale Atleti Azzurri d\'Italia, 1','danino@gmail.com','danino',1),(6,'Osteria \"Casa di mare\"','Via Theodoli, 6','casadimare@gmail.com','casadimare',1),(7,'Bistro\' Verdepaglia Forli','Corso Armando Diaz, 14','verdepaglia@gmail.com','verdepaglia',1),(8,'Lidl','Via A. Ciani, 1','lidl@gmail.com','lidl',2);
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-06 12:43:46
