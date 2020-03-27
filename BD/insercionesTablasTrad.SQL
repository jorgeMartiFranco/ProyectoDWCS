
USE gestionmovilidades;

INSERT INTO `PAISES` VALUES (null, 'AT', 'Austria');
INSERT INTO `PAISES` VALUES (null, 'BE', 'Belgium');
INSERT INTO `PAISES` VALUES (null, 'BG', 'Bulgaria');
INSERT INTO `PAISES` VALUES (null, 'HR', 'Croatia');
INSERT INTO `PAISES` VALUES (null, 'CY', 'Cyprus');
INSERT INTO `PAISES` VALUES (null, 'CZ', 'Czech Republic');
INSERT INTO `PAISES` VALUES (null, 'DK', 'Denmark');
INSERT INTO `PAISES` VALUES (null, 'EE', 'Estonia');
INSERT INTO `PAISES` VALUES (null, 'FI', 'Finland');
INSERT INTO `PAISES` VALUES (null, 'FR', 'France');
INSERT INTO `PAISES` VALUES (null, 'DE', 'Germany');
INSERT INTO `PAISES` VALUES (null, 'GR', 'Greece');
INSERT INTO `PAISES` VALUES (null, 'HU', 'Hungary');
INSERT INTO `PAISES` VALUES (null, 'IE', 'Ireland');
INSERT INTO `PAISES` VALUES (null, 'IT', 'Italy');
INSERT INTO `PAISES` VALUES (null, 'LV', 'Latvia');
INSERT INTO `PAISES` VALUES (null, 'LT', 'Lithuania');
INSERT INTO `PAISES` VALUES (null, 'LU', 'Luxembourg');
INSERT INTO `PAISES` VALUES (null, 'MT', 'Malta');
INSERT INTO `PAISES` VALUES (null, 'NL', 'Netherlands');
INSERT INTO `PAISES` VALUES (null, 'PL', 'Poland');
INSERT INTO `PAISES` VALUES (null, 'PT', 'Portugal');
INSERT INTO `PAISES` VALUES (null, 'RO', 'Romania');
INSERT INTO `PAISES` VALUES (null, 'SK', 'Slovakia');
INSERT INTO `PAISES` VALUES (null, 'SI', 'Slovenia');
INSERT INTO `PAISES` VALUES (null, 'ES', 'Spain');
INSERT INTO `PAISES` VALUES (null, 'SE', 'Sweden');




INSERT INTO ROL_USUARIOS  (tipo,descripcion) VALUES ('ADMIN','User with administration permissions, user changing roles, register specialties and institution or companies types.');
INSERT INTO ROL_USUARIOS (tipo,descripcion) VALUES('REGISTERED','User who can register students, companies, institutions and generate mobilities.');
INSERT INTO ROL_USUARIOS (tipo,descripcion) VALUES('ANONYMOUS','Not registered user that can only look for simple searches.');

INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('DEFICIT','Minimun score a partner can have on his own.',-30);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('REGISTER','Default score when an account is registered.',10);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('COMPANY REGISTER','Score given to a partner when register a company.',20);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('STUDENT ACCOMMODATION','Score given to a partner when he manages the student accommodation.',15);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('MOBILITY','Score removed from a partner when a mobility its done.',-20);

INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('REQUESTED','Request send but it hasnt been revised by the partner in question.');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('IN PROCCESS','Accepted request and been processed.');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('SOLVED','Request checked and solved by the partner in question.');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('CANCELED','Request canceled by the partner in question.');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('DECLINED','Request declined by the partner in question.');



INSERT INTO TIPOS_INSTITUCION (`ID_TIPO_INSTITUCION`, `TIPO`, `DESCRIPCION`) VALUES (NULL, 'High School', 'This is a high school'), 
								(NULL, 'University', 'This is an university');


INSERT INTO TIPOS_EMPRESA(TIPO,DESCRIPCION) VALUES('IT','Informática');



INSERT INTO TIPOS_EMPRESA(TIPO,DESCRIPCION) VALUES('Programación web','Programación');









