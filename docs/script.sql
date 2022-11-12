CREATE TABLE public.tbusuario (
	usucodigo serial NOT NULL,
	usunome varchar(50) NOT NULL,
	usuemail varchar(60) not NULL,
	ususenha varchar(200) not NULL,
	usutoken text NULL,
	usuativo int2 NOT NULL DEFAULT 1,
	CONSTRAINT usuario_pkey PRIMARY KEY (usucodigo)
);

CREATE TABLE public.tbpessoa (
	pescodigo serial4 NOT NULL,
	pesnome varchar(200) NOT NULL,
	pesendereco varchar(200) NOT NULL,
	pescpf varchar(20) NOT NULL,
	CONSTRAINT pk_tbpessoa PRIMARY KEY (pescodigo)
);

INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(1, 'joao da silva', 'Estrada Sao Jose', '237.511.490-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(2, 'maria da silva', 'Estrada Sao Jose', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(3, 'pedro', 'Estrada Sao Jose', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(4, 'Felipe', 'Estrada Sao Jose', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(6, 'Gelvazio', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(7, 'Bruno', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(8, 'Yasmim', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(9, 'Amanda', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(10, 'Rick', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(11, 'Matheus', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(5, 'Aldo Rosario', '7 de Setembro', '237.511.230-66');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(17, 'joao da silva', 'Estrada Sao Jose', '237.511.490-11');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(18, 'joao da silva', 'Estrada Sao Jose', '237.511.490-11');
INSERT INTO public.tbpessoa
(pescodigo, pesnome, pesendereco, pescpf)
VALUES(19, 'joana da silva', 'Estrada Sao Jose 123', '237.511.490-11');

-- Usuarios
insert into tbusuario(usunome,usuemail,ususenha,usutoken,usuativo)
values (1, 'admin','admin@email.com','admin123',null,1);

insert into tbusuario(usunome,usuemail,ususenha,usutoken,usuativo)
values ('senac','senac@email.com','senac123',null,1);

insert into tbusuario(usunome,usuemail,ususenha,usutoken,usuativo)
values ('aluno','aluno@email.com','aluno123',null,1);


















