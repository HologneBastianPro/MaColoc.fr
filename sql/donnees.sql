-- ============================================================
--    suppression des donnees
-- ============================================================

delete from COLOCATIONS;
delete from PERSONNES;
delete from HISTORIQUES;
delete from CAGNOTTES;

commit ;

-- ============================================================
--    creation des donnees
-- ============================================================


-- PERSONNES
insert into PERSONNES values (  1 , 'LADEMIL' , 'Lisa' , 'lisa@orange.fr', '15 rue de la paix', '0610032578'  ) ;
insert into PERSONNES values (  2 , 'LUBON' , 'Valentin' , 'valentin@orange.fr', '17 avenue de la resistence', '0648762522'  ) ;
insert into PERSONNES values (  3 , 'GROGNON' , 'Victor' , 'Victor@orange.fr', '42 rue de la castagne', '0714165789'  ) ;
insert into PERSONNES values (  4 , 'UGUET' , 'Estelle' , 'estelle@orange.fr', '273 route du jardin', '0675456535'  ) ;
insert into PERSONNES values (  5 , 'VERMET' , 'Baptiste' , 'baptiste@orange.fr', '37 rue odd', '0715198483'  ) ;
insert into PERSONNES values (  6 , 'NOLEO' , 'Lois' , 'lois@orange.fr', '3 rue de la finance', '0677768945'  ) ;
insert into PERSONNES values (  7 , 'DUVERNE' , 'Etienne' , 'etienne@orange.fr', '15 rue du vigneron', '0656532979'  ) ;
insert into PERSONNES values (  8 , 'CHERIFI' , 'Hamza' , 'hamza@orange.fr', '20 avenue du BDE', '0689844517'  ) ;
insert into PERSONNES values (  9 , 'DUCQ' , 'Alexianne' , 'alexianne@orange.fr', '136 rue du bob', '0607188365'  ) ;
insert into PERSONNES values (  10 , 'LEGUME' , 'Hector' , 'hector@orange.fr', '14 avenue de la verdure', '0661232887'  ) ;
insert into PERSONNES values (  11 , 'HOLOGNE' , 'Bastian' , 'bastian@orange.fr', '178 rue de la campagne', '0642414978'  ) ;
insert into PERSONNES values (  12 , 'MALET' , 'Lucas' , 'lucas@orange.fr', '19 avenue de Churchill', '0689844299'  ) ;
insert into PERSONNES values (  13 , 'JOUAN' , 'Titouan' , 'titouan@orange.fr', '47 avenue du velo', '0784425757'  ) ;

insert into PERSONNES values (  14 , 'LOMBARDY' , 'Sylvain' , 'sylvain@orange.fr', '118 avenue de Montreuil', '0689828283'  ) ;
insert into PERSONNES values (  15, 'BESSIERE' , 'Paul' , 'paul@orange.fr', '145 rue du développé couché', '0606070101'  ) ;
insert into PERSONNES values (  16 , 'BOUDRIOUA' , 'Asma' , 'asma@orange.fr', '42 rue de la bretagne', '0631389576'  ) ;

insert into PERSONNES values (  17 , 'TESSON' , 'Patrice' , 'patrice@orange.fr', '2735 route du jogging', '0652578774'  ) ;
insert into PERSONNES values (  18 , 'MAXWELL' , 'Jean' , 'jean@orange.fr', '37 rue even', '0791444546'  ) ;

insert into PERSONNES values (  19 , 'DOURTE' , 'Corentin' , 'corentin@orange.fr', '3 rue du crossfit', '0707070707'  ) ;
insert into PERSONNES values (  20 , 'INSHAPE' , 'Tibo' , 'tibo@orange.fr', '157 rue de la blessure', '0656762979'  ) ;

insert into PERSONNES values (  21 , 'ROUDIER' , 'Clair' , 'roudier@orange.fr', '200 rue du collier', '0689844747'  ) ;
insert into PERSONNES values (  22 , 'REVOUDOU' , 'Charline' , 'charline@orange.fr', '7 rue de la demoiselle', '064156765'  ) ;

insert into PERSONNES values (  23 , 'DELCASTILLO' , 'Carla' , 'carla@orange.fr', '148 impasse de la voiture', '0668622887'  ) ;
insert into PERSONNES values (  24 , 'CHEVALIER' , 'Deborah' , 'deborah@orange.fr', '1718 rue du charbon', '0642412424'  ) ;

insert into PERSONNES values (  25 , 'MARTIN' , 'Soukeina' , 'sousou@orange.fr', '23 rue camille claudel', '0689844299'  ) ;
insert into PERSONNES values (  26 , 'HARICOT' , 'Maeva' , 'maeva@orange.fr', '473 avenue de barouillet', '0782225757'  ) ;

-- COLOCATIONS

insert into COLOCATIONS values (  1 , 'SuperColoc'     , '42 rue Marcel Pagnol'       , 6, 'photo1.jpg'  ) ;
insert into COLOCATIONS values (  2 , 'LesRelous'     , '3 avenue Foch'       , 3, 'photo2.webp'  ) ;
insert into COLOCATIONS values (  3 , 'BDEgang'     , '15 rue de la paix'       , 8, 'photo3.jpg'  ) ;
insert into COLOCATIONS values (  4 , 'LesBretons'     , '18 rue de la crepe'       , 4, 'photo4.jpg'  ) ;
insert into COLOCATIONS values (  5 , 'Chill'     , '67 rue de Borda'       , 2, 'photo5.jpg'  ) ;
insert into COLOCATIONS values (  6 , 'Les Devs'     , '1 avenue Georges V'       , 11, 'photo6.jpg'  ) ;

insert into COLOCATIONS values (  7 , 'Correcteur'     , '1 avenue des prof'       , 14, 'photo7.jpg'  ) ;
insert into COLOCATIONS values (  8 , 'LesPhysiciens'     , '3 avenue des lumières'       , 17, 'photo8.jpg'  ) ;
insert into COLOCATIONS values (  9 , 'BDSgang'     , '12 avenue des sports'       , 20, 'photo9.jpg'  ) ;
insert into COLOCATIONS values (  10 , 'Las Chicas'     , '82 rue de la playa'       , 22, 'photo10.jpg'  ) ;
insert into COLOCATIONS values (  11 , 'Les Soeurettes'     , '96 rue des lilas'       , 23, 'photo11.jpg'  ) ;
insert into COLOCATIONS values (  12 , 'Les Bordelaises'     , '1200 cours de la somme'       , 25, 'photo12.jpg'  ) ;


-- HISTORIQUES

insert into HISTORIQUES values (1 , SYSDATE(), NULL, 1,2) ;
insert into HISTORIQUES values (2 , SYSDATE(), NULL, 3,2) ;
insert into HISTORIQUES values (3 , SYSDATE(), NULL, 10,2) ;
insert into HISTORIQUES values (4 , SYSDATE(), NULL, 6,1) ;
insert into HISTORIQUES values (5 , SYSDATE(), NULL, 7,1) ;
insert into HISTORIQUES values (6 , SYSDATE(), NULL, 9,3) ;
insert into HISTORIQUES values (7 , SYSDATE(), NULL, 8,3) ;
insert into HISTORIQUES values (8 , SYSDATE(), NULL, 2,5) ;
insert into HISTORIQUES values (9 , SYSDATE(), NULL, 13,5) ;
insert into HISTORIQUES values (10 , SYSDATE(), NULL, 5,4) ;
insert into HISTORIQUES values (11 , SYSDATE(), NULL, 4,4) ;
insert into HISTORIQUES values (12 , SYSDATE(), NULL, 11,6) ;
insert into HISTORIQUES values (13 , SYSDATE(), NULL, 12,6) ;
insert into HISTORIQUES values (14 , SYSDATE(), NULL, 14,7) ;
insert into HISTORIQUES values (15 , SYSDATE(), NULL, 15,7) ;
insert into HISTORIQUES values (16 , SYSDATE(), NULL, 16,7) ;
insert into HISTORIQUES values (17 , SYSDATE(), NULL, 17,8) ;
insert into HISTORIQUES values (18 , SYSDATE(), NULL, 18,8) ;
insert into HISTORIQUES values (19 , SYSDATE(), NULL, 19,9) ;
insert into HISTORIQUES values (20 , SYSDATE(), NULL, 20,9) ;
insert into HISTORIQUES values (21 , SYSDATE(), NULL, 21,10) ;
insert into HISTORIQUES values (22 , SYSDATE(), NULL, 22,10) ;
insert into HISTORIQUES values (23 , SYSDATE(), NULL, 23,11) ;
insert into HISTORIQUES values (24 , SYSDATE(), NULL, 24,11) ;
insert into HISTORIQUES values (25 , SYSDATE(), NULL, 25,12) ;
insert into HISTORIQUES values (26 , SYSDATE(), NULL, 26,12) ;

-- CAGNOTTES

insert into CAGNOTTES values (1 , 1050, 1,'CagnotteColoc') ;
insert into CAGNOTTES values (2 , 1100, 2,'Egalite') ;
insert into CAGNOTTES values (3 , 350, 4, 'BeurreSale') ;


-- APPORTS

insert into APPORTS values (1 , 300, SYSDATE(), 6, 1) ;
insert into APPORTS values (2 , 350, SYSDATE(), 7, 1) ;
insert into APPORTS values (3 , 300, SYSDATE(), 6, 1) ;
insert into APPORTS values (4 , 100, SYSDATE(), 6, 1) ;
insert into APPORTS values (5 , 150, SYSDATE(), 4, 3) ;
insert into APPORTS values (6 , 200, SYSDATE(), 5, 3) ;
insert into APPORTS values (7 , 150, SYSDATE(), 10, 2) ;
insert into APPORTS values (8 , 200, SYSDATE(), 3, 2) ;
insert into APPORTS values (9 , 300, SYSDATE(), 10, 2) ;
insert into APPORTS values (10 , 100, SYSDATE(), 10, 2) ;
insert into APPORTS values (11 , 150, SYSDATE(), 1, 2) ;
insert into APPORTS values (12 , 200, SYSDATE(), 3, 2) ;


-- LOGINS
insert into LOGINS values (1 , 'Lisa_Lademil', 'Lisa_Lademil', 'Lisa.jpg', 1) ;
insert into LOGINS values (2 , 'bhologne', 'bhologne', 'Bastian.jpeg', 11) ;
insert into LOGINS values (3 , 'lmalet', 'lmalet', 'Lucas.jpeg', 12) ;
insert into LOGINS values (4 , 'vgrognon', 'vgrognon', 'Victor.jpg', 3) ;
insert into LOGINS values (5 , 'vlubon', 'vlubon', 'default.png', 2) ;
insert into LOGINS values (6 , 'euguet', 'euguet', 'default.png', 4) ;
insert into LOGINS values (7 , 'bvermet', 'bvermet', 'default.png', 5) ;
insert into LOGINS values (8 , 'lnoleo', 'lnoleo', 'default.png', 6) ;
insert into LOGINS values (9 , 'eduverne', 'eduverne', 'default.png', 7) ;
insert into LOGINS values (10 , 'hcherifi', 'hcherifi', 'default.png', 8) ;
insert into LOGINS values (11 , 'aducq', 'aducq', 'default.png', 9) ;
insert into LOGINS values (12 , 'hlegume', 'hlegume', 'default.png', 10) ;
insert into LOGINS values (13 , 'tjouan', 'tjouan', 'default.png', 13) ;



-- ACHATS
insert into ACHATS values (1 , 'Course semaine 12', SYSDATE(), 50, 1, 2) ;
insert into ACHATS values (2 , 'Course semaine 11', SYSDATE(), 70, 1, 2) ;
insert into ACHATS values (3 , 'Course semaine 10', SYSDATE(), 50, 10, 2) ;
insert into ACHATS values (4 , 'Course semaine 9', SYSDATE(), 33, 3, 2) ;
insert into ACHATS values (5 , 'Course semaine 8', SYSDATE(), 50, 1, 2) ;
insert into ACHATS values (6 , 'Course semaine 7', SYSDATE(), 42, 3, 2) ;
insert into ACHATS values (7 , 'Course semaine 6', SYSDATE(), 50, 10, 2) ;
insert into ACHATS values (8 , 'Course semaine 5', SYSDATE(), 49.50, 10, 2) ;


-- VERSEMENTS
insert into VERSEMENTS values (1 , 1, 10, 50, SYSDATE()) ;
insert into VERSEMENTS values (2 , 1, 10, 50, SYSDATE()) ;
insert into VERSEMENTS values (3 , 3, 1, 50, SYSDATE()) ;
insert into VERSEMENTS values (4 , 10, 3, 50, SYSDATE()) ;
insert into VERSEMENTS values (5 , 12, 11, 50, SYSDATE()) ;


commit ;
