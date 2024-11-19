--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.25
-- Dumped by pg_dump version 9.5.25

-- Started on 2024-06-03 18:32:48

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12355)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 2 (class 3079 OID 16552)
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 185 (class 1259 OID 16472)
-- Name: carpeta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carpeta (
    idcarpeta integer NOT NULL,
    nombre character varying(45) NOT NULL,
    numfotos integer NOT NULL,
    descripcion character varying(45) NOT NULL,
    fecha date NOT NULL,
    idusuario integer NOT NULL
);


ALTER TABLE public.carpeta OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16504)
-- Name: carpeta_foto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carpeta_foto (
    idcarpeta integer NOT NULL,
    idfoto integer NOT NULL
);


ALTER TABLE public.carpeta_foto OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16470)
-- Name: carpeta_idcarpeta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carpeta_idcarpeta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.carpeta_idcarpeta_seq OWNER TO postgres;

--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 184
-- Name: carpeta_idcarpeta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carpeta_idcarpeta_seq OWNED BY public.carpeta.idcarpeta;


--
-- TOC entry 187 (class 1259 OID 16485)
-- Name: foto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.foto (
    idfoto integer NOT NULL,
    nombre character varying(45) NOT NULL,
    descripcion character varying(45) NOT NULL,
    fecha date,
    idusuario integer NOT NULL,
    idcarpeta integer,
    ruta bytea NOT NULL
);


ALTER TABLE public.foto OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16483)
-- Name: foto_idfoto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.foto_idfoto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.foto_idfoto_seq OWNER TO postgres;

--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 186
-- Name: foto_idfoto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.foto_idfoto_seq OWNED BY public.foto.idfoto;


--
-- TOC entry 190 (class 1259 OID 16521)
-- Name: reporte; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reporte (
    idreporte integer NOT NULL,
    descripcion character varying(45) NOT NULL,
    idusuario integer NOT NULL
);


ALTER TABLE public.reporte OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 16519)
-- Name: reporte_idreporte_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reporte_idreporte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reporte_idreporte_seq OWNER TO postgres;

--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 189
-- Name: reporte_idreporte_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reporte_idreporte_seq OWNED BY public.reporte.idreporte;


--
-- TOC entry 183 (class 1259 OID 16464)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    idusuario integer NOT NULL,
    tipo_usuario integer NOT NULL,
    nombre character varying(45) NOT NULL,
    username character varying(45) NOT NULL,
    password character varying(200) NOT NULL,
    edad date NOT NULL,
    email character varying(200) NOT NULL,
    numero bigint NOT NULL,
    estado smallint DEFAULT 1
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 16462)
-- Name: usuarios_idusuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_idusuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_idusuario_seq OWNER TO postgres;

--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 182
-- Name: usuarios_idusuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_idusuario_seq OWNED BY public.usuarios.idusuario;


--
-- TOC entry 2044 (class 2604 OID 16475)
-- Name: idcarpeta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta ALTER COLUMN idcarpeta SET DEFAULT nextval('public.carpeta_idcarpeta_seq'::regclass);


--
-- TOC entry 2045 (class 2604 OID 16488)
-- Name: idfoto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.foto ALTER COLUMN idfoto SET DEFAULT nextval('public.foto_idfoto_seq'::regclass);


--
-- TOC entry 2046 (class 2604 OID 16524)
-- Name: idreporte; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reporte ALTER COLUMN idreporte SET DEFAULT nextval('public.reporte_idreporte_seq'::regclass);


--
-- TOC entry 2042 (class 2604 OID 16467)
-- Name: idusuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN idusuario SET DEFAULT nextval('public.usuarios_idusuario_seq'::regclass);


--
-- TOC entry 2054 (class 2606 OID 16508)
-- Name: carpeta_foto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta_foto
    ADD CONSTRAINT carpeta_foto_pkey PRIMARY KEY (idcarpeta, idfoto);


--
-- TOC entry 2050 (class 2606 OID 16477)
-- Name: carpeta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta
    ADD CONSTRAINT carpeta_pkey PRIMARY KEY (idcarpeta);


--
-- TOC entry 2052 (class 2606 OID 16493)
-- Name: foto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.foto
    ADD CONSTRAINT foto_pkey PRIMARY KEY (idfoto);


--
-- TOC entry 2056 (class 2606 OID 16526)
-- Name: reporte_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reporte
    ADD CONSTRAINT reporte_pkey PRIMARY KEY (idreporte);


--
-- TOC entry 2048 (class 2606 OID 16469)
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (idusuario);


--
-- TOC entry 2061 (class 2606 OID 16509)
-- Name: carpeta_foto_idcarpeta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta_foto
    ADD CONSTRAINT carpeta_foto_idcarpeta_fkey FOREIGN KEY (idcarpeta) REFERENCES public.carpeta(idcarpeta) ON DELETE CASCADE;


--
-- TOC entry 2062 (class 2606 OID 16514)
-- Name: carpeta_foto_idfoto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta_foto
    ADD CONSTRAINT carpeta_foto_idfoto_fkey FOREIGN KEY (idfoto) REFERENCES public.foto(idfoto) ON DELETE CASCADE;


--
-- TOC entry 2057 (class 2606 OID 16478)
-- Name: carpeta_idusuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta
    ADD CONSTRAINT carpeta_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES public.usuarios(idusuario) ON DELETE CASCADE;


--
-- TOC entry 2063 (class 2606 OID 16537)
-- Name: fk_carpeta_has_foto_carpeta1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta_foto
    ADD CONSTRAINT fk_carpeta_has_foto_carpeta1 FOREIGN KEY (idcarpeta) REFERENCES public.carpeta(idcarpeta);


--
-- TOC entry 2064 (class 2606 OID 16542)
-- Name: fk_carpeta_has_foto_foto1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta_foto
    ADD CONSTRAINT fk_carpeta_has_foto_foto1 FOREIGN KEY (idfoto) REFERENCES public.foto(idfoto);


--
-- TOC entry 2058 (class 2606 OID 16532)
-- Name: fk_carpeta_usuarios1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carpeta
    ADD CONSTRAINT fk_carpeta_usuarios1 FOREIGN KEY (idusuario) REFERENCES public.usuarios(idusuario);


--
-- TOC entry 2066 (class 2606 OID 16547)
-- Name: fk_reporte_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reporte
    ADD CONSTRAINT fk_reporte_usuarios FOREIGN KEY (idusuario) REFERENCES public.usuarios(idusuario);


--
-- TOC entry 2060 (class 2606 OID 16499)
-- Name: foto_idcarpeta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.foto
    ADD CONSTRAINT foto_idcarpeta_fkey FOREIGN KEY (idcarpeta) REFERENCES public.carpeta(idcarpeta) ON DELETE SET NULL;


--
-- TOC entry 2059 (class 2606 OID 16494)
-- Name: foto_idusuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.foto
    ADD CONSTRAINT foto_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES public.usuarios(idusuario) ON DELETE CASCADE;


--
-- TOC entry 2065 (class 2606 OID 16527)
-- Name: reporte_idusuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reporte
    ADD CONSTRAINT reporte_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES public.usuarios(idusuario) ON DELETE CASCADE;


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 7
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2024-06-03 18:32:49

--
-- PostgreSQL database dump complete
--

