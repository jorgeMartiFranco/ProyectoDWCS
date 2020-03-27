
USE GESTIONMOVILIDADES;

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




/*INSERT INTO ROL_USUARIOS  (tipo,descripcion) VALUES ('ADMINISTRADOR','Usuario con permisos de administración, cambio de roles de los usuarios gestores, alta de especialidades, tipos de institución y tipos de empresa');
INSERT INTO ROL_USUARIOS (tipo,descripcion) VALUES('REGISTRADO','Usuario con permisos de alta a alumnos, empresas, instituciones, generar movilidades');
INSERT INTO ROL_USUARIOS (tipo,descripcion) VALUES('ANÓNIMO','Usuario no registrado que solamente tiene permisos de búsqueda básicas');


INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('DEFICIT','Puntuación mínima exigible para ejecutar operaciones que consuman puntuación',-30);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('REGISTRO','Puntuación que se suma por defecto al crear una cuenta',10);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('ALTA DE EMPRESA','Puntuación que se suma al socio que da de alta una empresa',20);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('GESTIÓN DE ALOJAMIENTO','Puntuación que se suma a un socio que se encarga de la gestión de alojamiento de una movilidad ',15);
INSERT INTO TIPOS_PUNTUACION(TIPO,DESCRIPCION,VALOR) VALUES('ALTA DE MOVILIDAD','Puntuación que se resta al socio al dar de alta una movilidad de un alumno',-20);


INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('SOLICITADO','Se ha enviado la solicitud pero no ha sido revisada por el socio a la que fue solicitado');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('EN TRÁMITE','La solicitud ha sido aceptada por el socio y está en proceso de tramitación');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('RESUELTO','La solicitud ha sido revisada y solucionada por el socio al que le fue solicitada');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('CANCELADA','La solicitud ha sido cancelada por el socio que la solicitó');
INSERT INTO ESTADOS (ESTADO,DESCRIPCION) VALUES('RECHAZADA','La solicitud ha sido rechazada por el socio a la que fue solicitado');*/


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













