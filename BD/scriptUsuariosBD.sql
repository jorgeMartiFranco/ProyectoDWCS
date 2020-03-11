CREATE USER IF NOT EXISTS 'movilidades_login'@'localhost' IDENTIFIED WITH mysql_native_password USING PASSWORD('abc123.');
CREATE USER IF NOT EXISTS 'movilidades_admin'@'localhost' IDENTIFIED WITH mysql_native_password USING PASSWORD('abc123.');
CREATE USER IF NOT EXISTS 'movilidades_registered'@'localhost' IDENTIFIED WITH mysql_native_password USING PASSWORD('abc123.');
GRANT SELECT ON GESTIONMOVILIDADES.SOCIOS TO 'movilidades_login'@'localhost';
GRANT SELECT ON GESTIONMOVILIDADES.PAISES TO 'movilidades_login'@'localhost';
GRANT SELECT ON GESTIONMOVILIDADES.TIPOS_INSTITUCION TO 'movilidades_login'@'localhost';
GRANT INSERT ON GESTIONMOVILIDADES.SOCIOS TO 'movilidades_login'@'localhost';
GRANT INSERT ON GESTIONMOVILIDADES.INSTITUCIONES TO 'movilidades_login'@'localhost';
GRANT UPDATE (INSTITUCION) ON GESTIONMOVILIDADES.SOCIOS TO 'movilidades_login'@'localhost';