-- Ejecutar como superusuario (postgres):
--   CREATE USER sitio_user WITH PASSWORD 'ELIGE_UNA_CLAVE';
--   CREATE DATABASE sitio_db OWNER sitio_user ENCODING 'UTF8';
--
-- Luego, conectado como sitio_user a sitio_db:
 
CREATE TABLE IF NOT EXISTS mensajes (
    id         BIGSERIAL PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    mensaje    TEXT         NOT NULL,
    creado_en  TIMESTAMPTZ  NOT NULL DEFAULT now()
);
