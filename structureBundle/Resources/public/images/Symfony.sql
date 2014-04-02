-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 02 Avril 2014 à 06:08
-- Version du serveur :  5.5.36-MariaDB-log
-- Version de PHP :  5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `Symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE `adresse` (
  `idAdresse` int(11) NOT NULL,
  `voie` text,
  `voieSuite` text,
  `cp` int(5) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `tag` varchar(20) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idAdresse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adresse`
--

INSERT INTO `adresse` (`idAdresse`, `voie`, `voieSuite`, `cp`, `ville`, `tag`, `telephone`) VALUES
(301, 'quartier jean-blanc', NULL, 40280, 'Bretagne de marsan', 'domicile', '05.58.71.00.92');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artId` int(11) DEFAULT NULL,
  `artTitle` varchar(80) CHARACTER SET utf8 NOT NULL,
  `artContent` text CHARACTER SET utf8 NOT NULL,
  `artPngId` int(11) DEFAULT NULL,
  `artDate` date DEFAULT NULL,
  `artPageId` int(11) DEFAULT NULL,
  `artImgUrl` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `artSource` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `artLien` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `tagName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artId` (`artId`),
  KEY `art-png-id` (`artPngId`),
  KEY `art-page-id` (`artPageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id`, `artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`, `tagName`) VALUES
(6, 10201, 'Mon Site Web', '<h2>Présentation<br></h2><p>Mon premier projet est le site internet sur lequel vous vous trouvez et que j''ai développé avec le framework Symfony 2.</p><p>Il a pour but de proposer une plateforme qui permette à d''éventuels clients de pouvoir suivre l''avancement de la construction de leur site web.</p><p>J''ai developpé le coeur de l''application comme une base où je peut greffer les différents sites tout en permettant une mise en production avec un minimum d''intervention dans le code.</p><p>Il propose aussi une interface d''administration simple et&nbsp; conviviale, grâce notamment à JQuery UI et AJAX.<br></p><p><br></p><h3>Démonstration :<br></h3><p>Vous pouvez vous connecter à l''espace client avec les identifiants par défault afin d''essayer (une partie seulement pour l''instant) de l''interface d''administration implémenté sur le site.<br></p><p><br></p><h3>Code source :<br></h3><p>Présentation made in moi : <a href="code_source/lit">mon code source</a>. <br></p><p>Présentation depuis GitHub.com : <a href="code_source_git">code source git</a>.</p><br>', 6, '2013-12-10', 102, NULL, NULL, NULL, NULL),
(8, 10301, 'Code Source', '', 3, NULL, 103, NULL, NULL, NULL, NULL),
(9, 6, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 0, NULL, NULL, NULL, NULL),
(14, 10401, 'Mon C.V.', '<p><br></p><p>Vous trouverez mon C.V. ci-dessous !</p>', 4, '2013-12-16', 104, 'embed', NULL, NULL, NULL),
(58, 40201, 'Notre sélection de marques', '<p>Nous sélectionnons pour vous tout un panel de marques afin de vous proposer la meilleur qualité aux mailleurs prix!</p><p>Confort, durabilité et ergonomie sont autant de critères de choix de notre part !</p><p>Découvrez-les dès à présent !</p>', NULL, NULL, 402, NULL, NULL, NULL, NULL),
(60, 40101, 'Des petits prix et des conseils', '<p>Euro Literie vous propose un large choix de sommiers, matelats, lits électriques...</p><p>Nous mettons un point d''honneur à ce que le client reparte satisfait et surtout avec le produit qui lui convienne.</p><p>C''est pourquoi nous sommes à votre écoute car, pour nous, un bon conseil est primordial !</p><p>Mais Euro Literie c''est aussi l''assurance d''avoir des produits de qualité à des prix minis !</p><p>\nN''hésitez plus et venez <a href="contact#googleMap">nous rencontrer</a> afin de profiter de notre expertise dans la literie !</p>', NULL, NULL, 401, NULL, NULL, NULL, NULL),
(106, 40301, 'Plan d''accès', '', NULL, NULL, 403, NULL, NULL, NULL, 'map'),
(107, 40302, '', '<p>Euro Literie</p><p>1859 Avenue du Maréchal Juin</p><p>40 000 MONT DE MARSAN</p>', NULL, NULL, 403, NULL, NULL, NULL, 'adresse_courrier'),
(111, 40304, 'Nos Horaires', '<p>Notre magasin est heureux de vous accueillir à ses heures d''ouverture :</p>', NULL, NULL, 403, NULL, NULL, NULL, 'horaire'),
(112, 40305, 'Nous contacter', '<p>Pour nous contacter par e-mail veuillez remplir le formulaire ci dessous :</p>', NULL, NULL, 403, NULL, NULL, NULL, 'formulaire'),
(113, 40303, '', '<p>05.58.05.94.46</p>', NULL, NULL, 403, NULL, NULL, NULL, 'adresse_phone'),
(128, 0, 'Le gouvernement va faire des efforts en matière d’e-administration', '<p class="actu_chapeau"><span>D&rsquo;ici la fin du premier semestre 2014, chaque ministre devra avoir pr&eacute;sent&eacute; &agrave; Matignon un &laquo;&nbsp;plan d&rsquo;actions&nbsp;&raquo; visant &agrave; assurer le d&eacute;veloppement des services publics num&eacute;riques. C&rsquo;est en effet ce qu&rsquo;a exig&eacute; Jean-Marc Ayrault aux membres de son gouvernement, avec dans l&rsquo;espoir de faire d&rsquo;internet &laquo;<em>&nbsp;le mode d&rsquo;acc&egrave;s pr&eacute;f&eacute;r&eacute; des Fran&ccedil;ais pour leurs contacts avec l&rsquo;administration</em>&nbsp;&raquo; d&rsquo;ici 2016.</span></p>', 1, '2013-12-27', 101, 'http://static.pcinpact.com/images/bd/dedicated/85112.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/85112-le-gouvernement-va-faire-efforts-en-matiere-d-e-administration.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(129, 1, 'Listes électorales : bientôt une inscription généralisée en ligne ?', '<p class="actu_chapeau"><span>Pourra-t-on bient&ocirc;t s&rsquo;inscrire sur les listes &eacute;lectorales depuis son domicile, gr&acirc;ce &agrave; Internet ? Si un tel service en ligne est d&eacute;j&agrave; propos&eacute; aux habitants de certaines villes, tous les Fran&ccedil;ais n&rsquo;y ont encore pas droit. Pour favoriser la participation &eacute;lectorale, la fondation Terra Nova propose donc de g&eacute;n&eacute;raliser cette proc&eacute;dure.&nbsp;</span></p>', 1, '2013-12-27', 101, 'http://static.pcinpact.com/images/bd/dedicated/85105.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/85105-listes-electorales-bientot-inscription-generalisee-en-ligne.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(130, 2, 'Le Conseil d’État rejette les recours de Free et FDN contre des décrets Hadopi', '<p class="actu_chapeau"><span>Le verdict est finalement tomb&eacute; hier : le Conseil d&rsquo;&Eacute;tat a rejet&eacute; les recours introduits par Free et l''association French Data Network (FDN) contre deux d&eacute;crets d&rsquo;application de la loi &laquo; Cr&eacute;ation et Internet &raquo; de 2009, celle instituant la Hadopi. Explications.</span></p>', 2, '2013-12-27', 101, 'http://static.pcinpact.com/images/bd/dedicated/85113.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/85113-le-conseil-d-etat-rejette-recours-free-et-fdn-contre-decrets-hadopi.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(131, 3, '[MàJ] Google lève sa censure vis-à-vis de l’hébergeur de fichiers Rapidgator', '<p class="actu_chapeau"><span>La page d&rsquo;accueil de Rapidgator, l&rsquo;un des sites les plus utilis&eacute;s au monde pour s&rsquo;&eacute;changer des fichiers en t&eacute;l&eacute;chargement direct <span>(films, musique, photos,...)</span>, vient d&rsquo;&ecirc;tre d&eacute;r&eacute;f&eacute;renc&eacute;e par Google. Cette d&eacute;cision, qui fait suite &agrave; une demande &eacute;manant d&rsquo;un ayant droit, est cependant contest&eacute;e par l&rsquo;h&eacute;bergeur de fichiers, qui ne comprend pas pourquoi cette page manifestement licite n&rsquo;appara&icirc;trait plus au sein des r&eacute;sultats du c&eacute;l&egrave;bre moteur de recherche.&nbsp;</span></p>', 2, '2013-12-27', 101, 'http://static.pcinpact.com/images/bd/dedicated/85083.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/85083-telechargement-direct-google-censure-l-hebergeur-fichiers-rapidgator.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(132, 4, 'Christiane Taubira a déposé son projet de loi sur la géolocalisation', '<p class="actu_chapeau"><span>Lundi, la Garde des Sceaux Christiane Taubira a d&eacute;pos&eacute; devant le S&eacute;nat un <a href="http://www.senat.fr/dossier-legislatif/pjl13-257.html" target="_blank">projet de loi relatif &agrave; la g&eacute;olocalisation</a>. Ce texte sera examin&eacute; &agrave; la rentr&eacute;e par le Parlement dans le cadre d&rsquo;une proc&eacute;dure acc&eacute;l&eacute;r&eacute;e. Et pour cause : il fait suite &agrave; deux arr&ecirc;ts rendus au mois d&rsquo;octobre par la Cour de cassation, qui ont fait figure de v&eacute;ritables coups de tonnerre juridiques. Explications.&nbsp;</span></p>', 1, '2013-12-26', 101, 'http://static.pcinpact.com/images/bd/dedicated/85085.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/85085-christiane-taubira-a-depose-son-projet-loi-sur-geolocalisation.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(133, 5, 'Près de 200 000 demandes d''interceptions de données de connexion en 2012', '<p class="actu_chapeau"><span>La Commission nationale de contr&ocirc;le des interceptions de s&eacute;curit&eacute; (<a href="http://fr.wikipedia.org/wiki/Commission_nationale_de_contr%C3%B4le_des_interceptions_de_s%C3%A9curit%C3%A9" target="_blank">CNCIS</a>), qui v&eacute;rifie la l&eacute;galit&eacute; des demandes d&rsquo;interception formul&eacute;es par les services de police ou de renseignement, a remis la semaine derni&egrave;re &agrave; Matignon son rapport d&rsquo;activit&eacute; correspondant &agrave; l&rsquo;ann&eacute;e 2012. C&rsquo;est en tout cas ce qu&rsquo;affirme <a href="http://lexpansion.lexpress.fr/high-tech/collecte-de-donnees-les-chiffres-du-renseignement-francais-en-2012_421574.html#xtor=AL-241" target="_blank">L&rsquo;Express</a>, qui r&eacute;v&egrave;le diff&eacute;rentes informations contenues dans ce document. Explications.</span></p>', 1, '2013-12-26', 101, 'http://static.pcinpact.com/images/bd/dedicated/85098.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/85098-pres-200-000-demandes-dinterceptions-donnees-connexion-en-2012.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(134, 200000, 'Bienvenue', '<p>Choississez un site :</p>', 0, NULL, 200, NULL, NULL, NULL, 'liste_projets'),
(135, 200001, 'Ouvrir un ticket', '<p>Clicker ici pour ouvrir un ticket !</p>', 0, NULL, 200, NULL, NULL, NULL, 'ticket_projet');

-- --------------------------------------------------------

--
-- Structure de la table `articleTest`
--

DROP TABLE IF EXISTS `articleTest`;
CREATE TABLE `articleTest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artId` int(100) NOT NULL,
  `artTitle` varchar(80) COLLATE utf8_bin NOT NULL,
  `artContent` text COLLATE utf8_bin NOT NULL,
  `artPngId` int(11) DEFAULT NULL,
  `artDate` date DEFAULT NULL,
  `artPageId` int(11) DEFAULT NULL,
  `artImgUrl` varchar(70) COLLATE utf8_bin DEFAULT NULL,
  `artSource` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `artLien` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `token` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `art-png-id` (`artPngId`),
  KEY `art-page-id` (`artPageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `articleTest`
--

INSERT INTO `articleTest` (`id`, `artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`, `token`) VALUES
(108, 1, 'Mon Titre', '<p>Ceci est un article</p>', 4, '2014-04-02', 152, NULL, NULL, NULL, 27),
(109, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 151, NULL, NULL, NULL, 27);

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

DROP TABLE IF EXISTS `compteur`;
CREATE TABLE `compteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nbVisites` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

DROP TABLE IF EXISTS `groupes`;
CREATE TABLE `groupes` (
  `idGroup` int(11) NOT NULL AUTO_INCREMENT,
  `nomGroupe` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idGroup`),
  KEY `idGroup` (`idGroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `groupes`
--

INSERT INTO `groupes` (`idGroup`, `nomGroupe`) VALUES
(2, 'visiteur'),
(100, 'administrateur'),
(400, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

DROP TABLE IF EXISTS `marques`;
CREATE TABLE `marques` (
  `idMarque` int(11) NOT NULL AUTO_INCREMENT,
  `nomMarque` varchar(70) DEFAULT NULL,
  `pngUrl` varchar(70) DEFAULT NULL,
  `content` text,
  `marqueLien` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idMarque`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `marques`
--

INSERT INTO `marques` (`idMarque`, `nomMarque`, `pngUrl`, `content`, `marqueLien`) VALUES
(1, 'Amiel', 'epeda.jpg', 'La société AMIEL est une entreprise familiale installée sur TOULOUSE depuis 1946, par ses compétences techniques et sa qualité de travail, la société a su gagner la confiance d''un grand nombre de distributeurs spécialisés dans le domaine de la literie.\r\nInitialement spécialiste de la fabrication de sommiers à lattes, Amiel complète dès la fin des année 1990 son offre par un gamme étendue de matelas et d''accessoires à l''usage des professionnels de la literie et des collectivités sur l''ensemble du Sud ouest de la France.\r\nTous les sommiers Amiel sont fabriqués en France et sont de grande qualité, quand aux matelas et accessoires, ils viennent d''un peu partout en Europe ( Espagne, Allemagne...)', 'www.amiel.fr'),
(2, 'Epeda', 'epeda.jpg', 'Depuis des générations et pour toutes les générations Epéda innove sans cesse pour améliorer votre sommeil et faire de chaque matin un pur moment de bonheur.\r\nEpéda, fabricant française de literie, est une des plus grandes marques de literie française, offrant différentes solutions de repos, avec une exigence élevée de qualité.\r\nGrâce à ses innovations technologiques, devenues des références indiscutables en matière de confort et d’ergonomie du sommeil, Epéda possède un statut particulier dans l’univers de la literie.', 'www.epeda.fr'),
(3, 'Onrev', 'onrev.jpg', 'Onrev, expert en sommeil depuis 1928 : plus de 80 ans d’expérience.\r\nOnrev, c’est l’alliance d’un savoir-faire hérité d’une longue tradition artisanale française, et de la recherche permanente des technologies les plus abouties et des meilleurs matériaux pour rester à la pointe du confort et de la qualité.\r\nC’est également la volonté que des bons produits soient aussi des beaux produits, par la qualité des coutils stretch, la finition impeccable et l’utilisation des techniques parfaitement maîtrisées comme le capitonnage intérieur.', 'www.onrev.fr'),
(4, 'TDR', 'TDR.png', 'Depuis la création de l''entreprise par Fernand De Giorgi leur objectif est l''entière satisfaction de leurs clients.\r\nLeur unité de production est moderne et dotée des dernières technologies dans le tournage du bois, des finitions et de l''emballage.\r\nDes milliers d''articles sont produits chaque jour dans le respect\r\nde l''environnement.\r\nL''essence principalement employée est le hêtre français.\r\nIls contribuent à la vie de nos forêts.', 'www.tdr-tournerie.com'),
(5, 'Duvivier', 'duvivier.jpg', 'Fort de plus de 80 ans d''expérience, Duvivier a développé, sur un site industriel de plusieurs hectares une fabrication moderne de matelas, sommiers et cadres à lattes, en alliant savoir-faire et innovation.\r\nPourquoi choisir un matelas Duvivier ?\r\nUn matelas naturellement aéré : aération facilitée par les grands aérateurs Duvivier AirSystem®. Des matériaux naturels, facilement recyclables (coton, feutre, acier…)\r\nUne plus grande longévité (garantie jusqu''à 7 ans !)', 'www.literie-duvivier.fr'),
(6, 'Résistub', 'resistub.jpg', 'L''histoire a commencé avec celle d''un homme, GEORGES RAIMBAUD son créateur.\r\nForgeron, il a démarré son activité dans une petite forge de Vendée. Pionnier, curieux, il s''est très vite détourné du métier classique de forgeron pour exercer ses capacités vers d''autres domaines, ...\r\nDepuis plus de 50 ans, RESISTUB conçoit à partir de son métier d''origine,le travail du métal, les meubles et les objets de votre vie.\r\nArtisan forgeron, hier, Industriel à vocation européenne aujourd''hui, RESISTUB, et ses différentes collections sans cesse renouvelées, propose des produits qui appartiennent à toutes les tendances de la décoration...', 'www.resistub.com'),
(12, 'Wifor', 'wifor.jpg', 'Du texte', 'www.wifor.fr');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `position` bit(1) NOT NULL,
  `site` int(50) DEFAULT NULL,
  PRIMARY KEY (`idMenu`),
  KEY `site` (`site`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`idMenu`, `path`, `name`, `position`, `site`) VALUES
(100, 'yomaah_accueil', 'Accueil', b'0', NULL),
(101, 'yomaah_cv', 'C.V.', b'0', NULL),
(102, 'yomaah_projets', 'Mes Projets', b'0', NULL),
(103, 'yomaah_login', 'Espace Client', b'1', NULL),
(401, 'literie_accueil', 'Accueil', b'0', 1),
(402, 'literie_marques', 'Nos Marques', b'0', 1),
(403, 'literie_magasin', 'Notre Magasin', b'0', 1),
(404, 'literie_contact', 'Nous Trouver', b'0', 1);

-- --------------------------------------------------------

--
-- Structure de la table `menuTest`
--

DROP TABLE IF EXISTS `menuTest`;
CREATE TABLE `menuTest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `position` bit(1) NOT NULL,
  `token` int(110) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `menuTest`
--

INSERT INTO `menuTest` (`id`, `path`, `name`, `position`, `token`) VALUES
(48, 'accueil', 'Accueil', b'0', 27);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `pageId` int(11) NOT NULL,
  `pageUrl` varchar(50) NOT NULL,
  `idSite` int(11) DEFAULT NULL,
  `keywords` varchar(300) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pageId`),
  KEY `page_ibfk_1` (`idSite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`pageId`, `pageUrl`, `idSite`, `keywords`, `position`) VALUES
(0, 'default', NULL, NULL, NULL),
(101, 'yomaah_accueil', NULL, NULL, NULL),
(102, 'yomaah_projets', NULL, NULL, NULL),
(103, 'yomaah_code_source', NULL, NULL, NULL),
(104, 'yomaah_cv', NULL, NULL, NULL),
(200, 'espace_client_accueil', NULL, NULL, NULL),
(401, 'literie_accueil', 1, 'toto,lolo, momo', 'Accueil'),
(402, 'literie_marques', 1, 'Epeda, Wifor, TDR, amiel', 'Nos Marques'),
(403, 'literie_contact', 1, '', 'Nous contacter'),
(404, 'literie_magasin', 1, NULL, 'Notre Magasin');

-- --------------------------------------------------------

--
-- Structure de la table `pageTest`
--

DROP TABLE IF EXISTS `pageTest`;
CREATE TABLE `pageTest` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageUrl` varchar(50) COLLATE utf8_bin NOT NULL,
  `token` int(100) DEFAULT NULL,
  PRIMARY KEY (`pageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `pageTest`
--

INSERT INTO `pageTest` (`pageId`, `pageUrl`, `token`) VALUES
(135, 'default', 19),
(136, 'accueil', 19),
(137, 'default', 20),
(138, 'accueil', 20),
(139, 'default', 21),
(140, 'accueil', 21),
(141, 'default', 22),
(142, 'accueil', 22),
(143, 'default', 23),
(144, 'accueil', 23),
(145, 'default', 24),
(146, 'accueil', 24),
(147, 'default', 25),
(148, 'accueil', 25),
(149, 'default', 26),
(150, 'accueil', 26),
(151, 'default', 27),
(152, 'accueil', 27);

-- --------------------------------------------------------

--
-- Structure de la table `png`
--

DROP TABLE IF EXISTS `png`;
CREATE TABLE `png` (
  `pngId` int(11) NOT NULL,
  `pngUrl` varchar(200) COLLATE utf8_bin NOT NULL,
  `pngCategory` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pngId`),
  KEY `png-url` (`pngUrl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `png`
--

INSERT INTO `png` (`pngId`, `pngUrl`, `pngCategory`) VALUES
(0, 'link.png', NULL),
(1, 'loi.png', 'Loi'),
(2, 'justice.png', 'Justice'),
(3, 'fichierTitre.png', ''),
(4, 'cv.png', NULL),
(6, 'link.png', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promoId` int(11) DEFAULT NULL,
  `tag` varchar(20) NOT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `PromoDesc` varchar(300) NOT NULL DEFAULT 'Entête',
  `promoPrix` double DEFAULT NULL,
  `promoInfo` varchar(500) NOT NULL DEFAULT 'Description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `promotions`
--

INSERT INTO `promotions` (`id`, `promoId`, `tag`, `dateDebut`, `dateFin`, `PromoDesc`, `promoPrix`, `promoInfo`) VALUES
(3, NULL, 'periode', '2014-03-20', '2014-03-29', '150%', NULL, 'Promotion valable sur les sommiers !'),
(4, NULL, 'periode', '2014-03-01', '2014-03-20', 'Sommier à 2 euro !!!', NULL, 'Promotion valable pour l''achat d''un godemichet !'),
(6, NULL, 'periode', '2014-03-28', '2014-04-04', 'Tout à - 90% !!', NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `idSite` int(11) NOT NULL AUTO_INCREMENT,
  `nomSite` varchar(50) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idSite`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `site`
--

INSERT INTO `site` (`idSite`, `nomSite`, `idUser`, `tag`) VALUES
(1, 'literie', 400, 'EuroLiterie');

-- --------------------------------------------------------

--
-- Structure de la table `sousMenu`
--

DROP TABLE IF EXISTS `sousMenu`;
CREATE TABLE `sousMenu` (
  `idSousMenu` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(30) COLLATE utf8_bin NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `idMenu` int(11) NOT NULL,
  PRIMARY KEY (`idSousMenu`),
  KEY `idMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `sousMenu`
--

INSERT INTO `sousMenu` (`idSousMenu`, `path`, `name`, `idMenu`) VALUES
(10201, 'yomaah_code_source', 'Code Source', 102),
(10202, 'yomaah_code_source_git', 'Code Source Git', 102),
(40401, 'googleMap', 'Plan', 404),
(40402, 'horaires', 'Nos Horaires', 404),
(40403, 'email', 'Nous Contacter', 404);

-- --------------------------------------------------------

--
-- Structure de la table `user_page`
--

DROP TABLE IF EXISTS `user_page`;
CREATE TABLE `user_page` (
  `idPage` int(11) NOT NULL,
  `nbClic` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `idVisite` int(11) NOT NULL,
  PRIMARY KEY (`idPage`,`idVisite`),
  KEY `idVisite` (`idVisite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE `utilisateur` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `idGroup` int(11) NOT NULL,
  `userFirstName` varchar(30) NOT NULL,
  `userLastName` varchar(30) NOT NULL,
  `idAdresse` int(10) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `login` (`login`),
  KEY `idGroup` (`idGroup`),
  KEY `foreign` (`idAdresse`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUser`, `login`, `password`, `idGroup`, `userFirstName`, `userLastName`, `idAdresse`) VALUES
(2, 'test', 'xSr7r5rEPjstSyTI0LzlvqdHAtMeq4sYvpKjywW4r+k=', 2, '', '', NULL),
(100, 'yoshi', '/9TFMXP/znbk1FbvArLhLnmTtesU77x9/IZz/8mf/C8=', 100, '', '', NULL),
(400, 'alex', '/9TFMXP/znbk1FbvArLhLnmTtesU77x9/IZz/8mf/C8=', 400, 'Alexandre', 'Tachon', 301);

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

DROP TABLE IF EXISTS `visites`;
CREATE TABLE `visites` (
  `idVisite` int(11) NOT NULL AUTO_INCREMENT,
  `adresseIp` varchar(25) CHARACTER SET utf8 NOT NULL,
  `dateConnexion` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idVisite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `visites`
--

INSERT INTO `visites` (`idVisite`, `adresseIp`, `dateConnexion`, `idUser`) VALUES
(8, '::1', '2013-11-06 20:27:55', 1),
(9, '::1', '2013-12-18 20:33:11', 1),
(10, '192.168.1.32', '2013-12-04 22:50:51', 1),
(11, '::1', '2013-12-18 22:55:32', 1),
(12, '192.168.1.32', '2013-12-18 23:11:14', 1),
(13, '::1', '2013-12-19 16:22:34', 1),
(14, '::1', '2013-12-20 06:37:29', 1),
(15, '192.168.1.50', '2013-12-21 11:07:27', 1),
(16, '192.168.1.53', '2013-12-21 12:15:45', 1),
(17, '::1', '2013-12-21 22:52:00', 1),
(18, '192.168.1.53', '2013-12-22 01:48:50', 1),
(19, '192.168.1.53', '2013-12-23 00:27:55', 1),
(20, '::1', '2013-12-23 00:31:10', 3),
(21, '192.168.1.53', '2013-12-23 16:00:48', 0),
(22, '::1', '2013-12-23 17:09:41', 0),
(23, '192.168.1.26', '2013-12-24 03:58:28', 0),
(24, '192.168.1.53', '2013-11-06 06:35:47', 0),
(25, '::1', '2013-12-24 08:13:40', 1),
(26, '::1', '2013-12-25 15:48:00', 1),
(27, '::1', '2013-12-26 08:03:10', 0),
(28, '::1', '2013-12-27 14:35:35', 1),
(29, '::1', '2013-12-28 07:38:30', 1),
(30, '::1', '2014-01-23 13:00:37', 1),
(31, '::1', '2014-02-28 17:38:58', 0),
(32, '::1', '2014-03-01 16:46:53', 0),
(33, '::1', '2014-03-02 15:09:52', 0),
(34, '::1', '2014-03-12 16:24:06', 1),
(35, '::1', '2014-03-13 13:45:24', 1),
(36, '::1', '2014-03-14 19:25:33', 0),
(37, '::1', '2014-03-15 13:43:00', 0),
(38, '::1', '2014-03-16 11:30:28', 0),
(39, '::1', '2014-03-17 13:22:57', 0),
(40, '::1', '2014-03-18 02:46:07', 0),
(41, '::1', '2014-03-19 16:56:18', 1),
(42, '::1', '2014-03-27 00:57:58', 1),
(43, '::1', '2014-03-27 16:00:11', 1),
(44, '::1', '2014-03-28 12:49:15', 1),
(45, '::1', '2014-03-31 16:05:07', 1),
(46, '::1', '2014-04-01 13:16:15', 100),
(47, '::1', '2014-04-02 01:33:11', 100);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`artPageId`) REFERENCES `page` (`pageId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `article_png` FOREIGN KEY (`artPngId`) REFERENCES `png` (`pngId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `articleTest`
--
ALTER TABLE `articleTest`
  ADD CONSTRAINT `articleTest_png` FOREIGN KEY (`artPngId`) REFERENCES `png` (`pngId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pageTest_article` FOREIGN KEY (`artPageId`) REFERENCES `pageTest` (`pageId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`site`) REFERENCES `site` (`idSite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`idSite`) REFERENCES `site` (`idSite`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `site_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `sousMenu`
--
ALTER TABLE `sousMenu`
  ADD CONSTRAINT `sousMenu_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_page`
--
ALTER TABLE `user_page`
  ADD CONSTRAINT `user_page_ibfk_1` FOREIGN KEY (`idVisite`) REFERENCES `visites` (`idVisite`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `user_page_ibfk_2` FOREIGN KEY (`idPage`) REFERENCES `page` (`pageId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `User_adresse_fk` FOREIGN KEY (`idAdresse`) REFERENCES `adresse` (`idAdresse`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idGroup`) REFERENCES `groupes` (`idGroup`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
