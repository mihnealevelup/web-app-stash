-- seed data for the cinema-forge demo catalogue
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE film_talent;
TRUNCATE TABLE films;
TRUNCATE TABLE talents;
TRUNCATE TABLE news;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO films (id, title, slug, synopsis, release_year, genre, poster, trailer_url, status) VALUES
(1, 'Ultima Iarnă la Sinaia', 'ultima-iarna-la-sinaia', 'Un fost dirijor se întoarce în orașul copilăriei pentru a vinde casa părintească și descoperă partitura pierdută a tatălui său. O dramă despre memorie, familie și muzica ce leagă generațiile.', 2023, 'Dramă', 'https://picsum.photos/seed/cf-sinaia/400/600', 'https://www.youtube.com/embed/eRsGyueVLvQ', 'released'),
(2, 'București Underground', 'bucuresti-underground', 'Un documentar filmat timp de trei ani în scena muzicală subterană a Capitalei, urmărind cinci formații care refuză compromisul comercial.', 2024, 'Documentar', 'https://picsum.photos/seed/cf-underground/400/600', 'https://www.youtube.com/embed/R6MlUcmOul8', 'released'),
(3, 'Codrii de Aramă', 'codrii-de-arama', 'Într-un sat izolat din Apuseni, o tânără cartografă descoperă că pădurea își schimbă forma noaptea. Un basm vizual inspirat din mitologia românească.', 2022, 'Fantastic', 'https://picsum.photos/seed/cf-codrii/400/600', 'https://www.youtube.com/embed/aqz-KE-bpKQ', 'released'),
(4, 'Linia Ferată 7', 'linia-ferata-7', 'Trenul de noapte Timișoara-Iași nu ajunge niciodată la destinație. Un inspector CFR reconstituie ultimele patruzeci de minute din viața a optzeci de pasageri.', 2024, 'Thriller', 'https://picsum.photos/seed/cf-linia7/400/600', 'https://www.youtube.com/embed/_cMxraX_5RE', 'released'),
(5, 'Vals pe Dâmbovița', 'vals-pe-dambovita', 'Doi profesori de dans rivali sunt obligați să împartă aceeași sală de repetiții cu o săptămână înainte de campionatul național.', 2021, 'Romantic', 'https://picsum.photos/seed/cf-vals/400/600', 'https://www.youtube.com/embed/WhWc3b3KhnY', 'released'),
(6, 'Ecoul Munților', 'ecoul-muntilor', 'O echipă de salvamontiști pornește în ultima misiune a sezonului, pe o vreme care se închide mai repede decât prevăzuse oricine.', 2023, 'Aventură', 'https://picsum.photos/seed/cf-ecoul/400/600', 'https://www.youtube.com/embed/mN0zPOpADL4', 'released'),
(7, 'Fabrica de Vise', 'fabrica-de-vise', 'O echipă de figuranți dintr-un studio de film din anii nouăzeci decide să producă propriul lungmetraj folosind decorurile abandonate.', 2022, 'Comedie', 'https://picsum.photos/seed/cf-fabrica/400/600', 'https://www.youtube.com/embed/pKmSdY56VtY', 'released'),
(8, 'Noaptea Lupilor', 'noaptea-lupilor', 'O echipă de biologi rămâne blocată într-o cabană de cercetare din Carpați, iar semnalele GPS ale animalelor monitorizate se apropie din toate direcțiile.', 2025, 'Horror', 'https://picsum.photos/seed/cf-lupilor/400/600', NULL, 'post-production'),
(9, 'Simfonia Deltei', 'simfonia-deltei', 'Un an în Delta Dunării, înregistrat exclusiv cu microfoane subacvatice și camere termice. Documentarul sonor al unui ecosistem în schimbare.', 2025, 'Documentar', 'https://picsum.photos/seed/cf-delta/400/600', NULL, 'production'),
(10, 'Orizont Pierdut', 'orizont-pierdut', 'La bordul primei stații orbitale românești, un inginer descoperă că transmisiile primite de la sol au fost înregistrate cu unsprezece ani în urmă.', 2026, 'SF', 'https://picsum.photos/seed/cf-orizont/400/600', NULL, 'development');

INSERT INTO talents (id, name, role_type, bio, photo) VALUES
(1, 'Andrei Vasilescu', 'director', 'Regizor format la UNATC, cunoscut pentru stilul documentarist și lucrul cu actori neprofesioniști. A semnat trei lungmetraje selectate în competiții internaționale.', 'https://picsum.photos/seed/cf-t01/300/300'),
(2, 'Ioana Petrescu', 'actor', 'Actriță de teatru și film, absolventă a Universității Naționale de Artă Teatrală. Colaborează constant cu Teatrul Bulandra din anul 2016.', 'https://picsum.photos/seed/cf-t02/300/300'),
(3, 'Mihai Dobrescu', 'actor', 'Actor cu formație clasică, remarcat pentru rolurile de compoziție. A jucat în peste douăzeci de producții de televiziune și film.', 'https://picsum.photos/seed/cf-t03/300/300'),
(4, 'Elena Marinescu', 'producer', 'Producător executiv cu experiență în coproducții europene. A coordonat finanțarea a nouă lungmetraje prin fonduri CNC și Eurimages.', 'https://picsum.photos/seed/cf-t04/300/300'),
(5, 'Radu Constantinescu', 'writer', 'Scenarist și dramaturg. Scrie preponderent despre comunități mici și despre tensiunea dintre tradiție și modernitate.', 'https://picsum.photos/seed/cf-t05/300/300'),
(6, 'Cristina Ionescu', 'actor', 'Actriță tânără, descoperită într-un casting deschis. Rolul de debut i-a adus premiul pentru interpretare feminină la Gopo.', 'https://picsum.photos/seed/cf-t06/300/300'),
(7, 'Tudor Apostol', 'director', 'Regizor de documentar, specializat în filmare observațională de lungă durată. Preferă echipele reduse și filmarea fără scenariu prestabilit.', 'https://picsum.photos/seed/cf-t07/300/300'),
(8, 'Alexandra Barbu', 'actor', 'Actriță și dansatoare, cu pregătire în teatru fizic. A colaborat cu companii independente din București și Cluj.', 'https://picsum.photos/seed/cf-t08/300/300'),
(9, 'Ștefan Munteanu', 'writer', 'Scenarist de gen, pasionat de thriller și science fiction. A publicat două volume de proză scurtă înainte de a trece la scenariu.', 'https://picsum.photos/seed/cf-t09/300/300'),
(10, 'Diana Neagu', 'producer', 'Producător de linie, responsabilă cu logistica filmărilor în locații dificile. Coordonează echipe de peste o sută de persoane.', 'https://picsum.photos/seed/cf-t10/300/300'),
(11, 'Victor Stancu', 'actor', 'Actor de film și voce, activ din 2005. Recunoscut pentru rolurile secundare memorabile din cinematografia recentă.', 'https://picsum.photos/seed/cf-t11/300/300'),
(12, 'Ruxandra Fieraru', 'director', 'Regizoare de ficțiune, interesată de naratiuni feminine și de reconstituirea istorică. Primul ei lungmetraj a fost selectat la Berlinale Forum.', 'https://picsum.photos/seed/cf-t12/300/300');

INSERT INTO film_talent (film_id, talent_id, character_name) VALUES
(1, 1, NULL), (1, 2, 'Ana Dumitrescu'), (1, 3, 'Dirijorul Vlad'), (1, 4, NULL), (1, 5, NULL),
(2, 7, NULL), (2, 10, NULL),
(3, 12, NULL), (3, 6, 'Cartografa Miruna'), (3, 11, 'Bătrânul pădurar'), (3, 9, NULL),
(4, 1, NULL), (4, 3, 'Inspectorul Barbu'), (4, 8, 'Martora din vagonul 3'), (4, 9, NULL),
(5, 12, NULL), (5, 2, 'Profesoara Sanda'), (5, 11, 'Profesorul Emil'), (5, 4, NULL),
(6, 7, NULL), (6, 3, 'Salvamontistul Luca'), (6, 6, 'Medicul Irina'), (6, 10, NULL),
(7, 1, NULL), (7, 11, 'Figurantul Gicu'), (7, 8, 'Machieuza Dora'), (7, 5, NULL),
(8, 12, NULL), (8, 6, 'Biologa Carmen'), (8, 9, NULL),
(9, 7, NULL), (9, 10, NULL),
(10, 1, NULL), (10, 2, 'Inginera Lia'), (10, 9, NULL);

INSERT INTO news (id, title, slug, content, excerpt, source, external_url, published_at) VALUES
(1, 'Ultima Iarnă la Sinaia intră în selecția oficială de la Cluj', 'ultima-iarna-selectie-cluj', 'Lungmetrajul regizat de Andrei Vasilescu a fost inclus în competiția națională a festivalului. Proiecția de gală va avea loc în prezența întregii echipe, urmată de o sesiune de întrebări și răspunsuri cu publicul.', 'Lungmetrajul intră în competiția națională a festivalului de la Cluj.', 'internal', NULL, '2026-06-14 10:00:00'),
(2, 'Au început filmările pentru Simfonia Deltei', 'filmari-simfonia-deltei', 'Echipa a instalat primele microfoane subacvatice în zona Caraorman. Filmările vor continua pe parcursul a douăsprezece luni, pentru a surprinde toate cele patru anotimpuri ale ecosistemului deltaic.', 'Primele microfoane subacvatice au fost instalate în zona Caraorman.', 'internal', NULL, '2026-07-02 09:30:00'),
(3, 'Cinema Forge deschide un studio de post-producție la Bucuresti', 'studio-postproductie-bucuresti', 'Noul spațiu include două cabine de mixaj, o sală de colorizare și un studio de foley complet echipat. Investiția permite finalizarea integrală a proiectelor în țară.', 'Noul spațiu include cabine de mixaj, colorizare și un studio de foley.', 'internal', NULL, '2026-08-21 14:15:00'),
(4, 'Fondul cinematografic european își mărește bugetul pentru 2027', 'fond-european-buget-2027', 'Sursă externă preluată prin fluxul RSS al asociației producătorilor. Bugetul destinat coproducțiilor din Europa de Est crește cu optsprezece procente față de exercițiul precedent.', 'Bugetul pentru coproducțiile est-europene crește cu 18 procente.', 'external', 'https://www.europeanfilmacademy.org/', '2026-08-28 08:00:00'),
(5, 'Tendințe în distribuția independentă la nivel global', 'tendinte-distributie-independenta', 'Articol preluat automat din sursele externe monitorizate de redacție. Platformele de streaming au început să achiziționeze titluri direct de la festivaluri, scurtând semnificativ lanțul clasic de distribuție.', 'Platformele achiziționează titluri direct de la festivaluri.', 'external', 'https://www.screendaily.com/', '2026-08-30 11:45:00'),
(6, 'Casting deschis pentru Orizont Pierdut', 'casting-orizont-pierdut', 'Producția caută actori cu vârste între douăzeci și cinci și patruzeci de ani pentru rolurile echipajului. Înscrierile se fac exclusiv online, prin formularul de contact al studioului.', 'Producția caută actori pentru rolurile echipajului stației orbitale.', 'internal', NULL, '2026-09-01 16:00:00');
