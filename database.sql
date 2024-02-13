CREATE DATABASE IF NOT EXISTS projekt CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE projekt;

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `userName` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `fullName` varchar(255) NOT NULL,
    `email` varchar(100) NOT NULL,
    `dateOfBirth` datetime NOT NULL,
    `dateOfRegistration` datetime NOT NULL,
    `status` int(1) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `userName`
(`userName`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `logged_in_users` ( `sessionId` varchar(100) NOT NULL,
`userId` int(11) NOT NULL,
`lastUpdate` datetime NOT NULL,
PRIMARY KEY (`sessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    `userId` int(11) NOT NULL,
    `submissionDate` datetime NOT NULL,
    `description` varchar(250) NOT NULL,
    `content` varchar(1000) NOT NULL,
    `photoName` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- example data
INSERT INTO `users` (`id`, `userName`, `password`, `fullName`, `email`, `dateOfBirth`, `dateOfRegistration`, `status`) VALUES
(1, 'admin', '$2y$10$D3vRgvRh3PoxiginyNlAEO/rz3nPmDmC2yumcCPZw.RaxPmRFS/pS', 'Jan Kowalski', 'email@example.com', '1999-01-01 00:00:00', '2023-01-10 00:00:00', 2),
(9, 'adam', '$2y$10$Nl0bl2dKbzjeRv9yhDf2UuD9O975cyZ7I8CExaP5Ar6J85SberOzy', 'Adam Nowak', 'email@test.pl', '1999-01-01 00:00:00', '2023-01-23 00:00:00', 1);

INSERT INTO `posts` (`id`, `title`, `userId`, `submissionDate`, `description`, `content`, `photoName`) VALUES
(3, 'Ateny', 1, '2023-01-18 06:50:00', 'Partenon – świątynia poświęcona Atenie Partenos (pol. Atenie Dziewicy) na akropolu ateńskim, wzniesiona w połowie V w. p.n.e. według planów Iktinosa i Kallikratesa pod nadzorem Fidiasza, który wykonał również elementy rzeźbiarskie.', 'Partenon (gr. Παρθενών, Parthenṓn) – świątynia poświęcona Atenie Partenos (pol. Atenie Dziewicy) na akropolu ateńskim, wzniesiona w połowie V w. p.n.e. według planów Iktinosa i Kallikratesa pod nadzorem Fidiasza, który wykonał również elementy rzeźbiarskie. Zbudowana z białego marmuru pentelickiego w zgodzie z porządkiem doryckim, uważana za najdoskonalszy jego przykład.&#34;&#13;&#10;&#13;&#10;Świątynia została wzniesiona z inicjatywy ateńskiego polityka i stratega Peryklesa (ok. 495–429 p.n.e.) w ramach jego programu udekorowania imperialnych Aten finansowanego z budżetu Związku Morskiego. Gmach zastąpił wcześniejszą świątynię zniszczoną przez Persów w 480 roku p.n.e., która z kolei stała w miejscu pierwszego Partenonu z ok. 570 roku p.n.e. w południowo-wschodniej części Akropolu.', 'img_63c8317e7eda0.png'),
(4, 'Capri', 1, '2023-01-18 06:53:00', 'Niewielka, o wydłużonym kształcie, górzysta wyspa zbudowana jest ze skał wapiennyc. Jej powierzchnia wynosi 10,4 km² a obwód 17,0 km, najwyższe wzniesienie to Monte Solaro (596 m n.p.m.), na którym znajdują się ruiny zamku.', 'Capri – włoska wyspa na Morzu Tyrreńskim w Zatoce Neapolitańskiej, część archipelagu Wysp Kampańskich. Położona jest w pobliżu półwyspu Sorrento, oddzielona od niego cieśniną Piccola. Nazwa wyspy pochodzi od słowa Kapros (grec. – dzik) lub Capra (łac. – koza).&#13;&#10;&#13;&#10;Najstarsze ślady bytności człowieka na wyspie pochodzą z okresu paleolitu, natrafiono na nie podczas budowy cesarskiej willi w dolinie Tragara. W VII wieku p.n.e. skolonizowali ją Grecy, a od 29 p.n.e. znalazła się w granicach Cesarstwa Rzymskiego. Była jednym z ulubionych miejsc pobytu cesarzy Oktawiana Augusta i Tyberiusza, który zbudował na niej 12 willi nazwanych imionami olimpijskich bogów (Tyberiusz mieszkał na wyspie w latach 27–37). Rzymianie opuścili wyspę w II wieku. Od IX wieku wchodziła w skład republiki Amalfi. W 1860 roku została włączona w granice zjednoczonego Królestwa Włoch.', 'img_63c8320c7685c.png'),
(5, 'Florencja', 1, '2023-01-18 06:55:00', 'Most Złotników – najstarszy z florenckich mostów, na rzece Arno. ', 'Most został zbudowany z ciosów kamiennych w latach 1335–1345 według projektu Neriego di Fioravante i Taddeo Gaddi w tym samym miejscu, w którym postawiono pierwszy, drewniany most już w okresie starożytnego Rzymu. Zbudowane w czasach późniejszych kolejne dwa mosty zostały zniszczone w wyniku powodzi w latach 1117 i 1333. Zatem jest to czwarta konstrukcja spinająca brzegi rzeki w tym samym miejscu.&#13;&#10;&#13;&#10;Konstrukcja mostu złożona jest z trzech przęseł o rozpiętości: 28, 30 i 27 metrów, podpartych masywnymi filarami, które podtrzymują płytę o szerokości 32 metrów. Dwie środkowe podpory znajdują się w nurcie rzeki. Po obu stronach mostu już w XIV wieku zbudowano niewielkie budynki nad dwiema skrajnymi arkadami. Początkowo mieściły się w nich jatki rzeźników. W XVI wieku zamieniono je na warsztaty i kramiki innych rzemieślników, wśród których przeważały sklepiki złotników. Wystające elementy wsparte są na kroksztynach', 'img_63c8327f10db9.png'),
(6, 'Paestum', 1, '2023-01-18 10:45:00', 'Paestum (gr. Posejdonia, łac. Paestum) – w starożytności kolonia grecka miasta Sybaris. Obecnie dzielnica miasta Capaccio w regionie Kampania, w prowincji Salerno. Położone jest na południe od Neapolu na wybrzeżu Morza Tyrreńskiego', 'Miasto założyli Grecy w VII wieku p.n.e. jako Posejdonię, było jednym z miast Wielkiej Grecji. Jego założycielami byli mieszkańcy starszej, bogatej achajskiej kolonii Sybaris, której mieszkańcy byli znani z zamiłowania do luksusu (sybaryci), położonej nad zatoką Tarencką (data przypuszczalnego jej założenia to połowa VII wieku p.n.e.). Osadnicy z Sybaris pragnęli rzucić wyzwanie eubejskiej kolonii Kume (łac. Cumae, gr. Kymai) na północ od Neapolu, która odgrywała dominującą rolę w handlu z Etruskami.', 'img_63d07e2a81dbe.jpeg'),
(10, 'G&oacute;ry Stołowe', 9, '2023-01-23 02:56:00', 'Góry Stołowe – pasmo górskie w łańcuchu Sudetów Środkowych. Wypiętrzone przed 30 milionami lat są jednymi z nielicznych w Europie gór płytowych.', 'Góry Stołowe stanowią centralną część niecki śródsudeckiej. Obejmują też niewielkie fragmenty granitoidowej jednostki Kudowy-Olešnic oraz metamorfiku orlicko-kłodzkiego (tu: bystrzycko-orlickiego). Największy obszar w Górach Stołowych zajmują górnokredowe (cenoman, turon, koniak) skały osadowe niecki śródsudeckiej, w północno-zachodniej części leżące prawie poziomo, w północno-wschodniej zapadające lekko ku południowi.', 'img_63ce921fed04b.jpeg'),
(11, 'Gdynia - Orłowo', 9, '2023-01-23 03:34:00', 'Klif Orłowski – stromy brzeg morski Kępy Redłowskiej w Gdyni, znajdujący się w granicach dzielnicy Redłowo, a najlepiej dostrzegalny ze znajdującej się w bezpośrednim sąsiedztwie dzielnicy Orłowo.', 'Na plaży znajdują się również ciemnobrunatne warstwy piasku, które stanowią skupisko minerałów ciężkich (m.in. magnetyt, mangan, cyrkon, tytan). Źródłem ich są zniszczone skały magmowe i metamorficzne. U podnóża klifu występują także warstwy węgla brunatnego.&#13;&#10;&#13;&#10;Natomiast Cypel Orłowski, składa się głównie z utworów gliniastych i ma charakter obrywowy. Część południowa klifu charakteryzuje się przewagą procesów osypiskowych, a północna – osuwiskowych.', 'img_63ce9ae13b472.jpeg');
