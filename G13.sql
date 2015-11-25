drop database if exists grupo13;
create database grupo13 default character set utf8 default collate utf8_spanish_ci;
/*drop user 'adminG13'@'localhost';*/
create user 'adminG13'@'localhost' identified by 'abc123.';
grant usage on *.* to 'adminG13'@'localhost';
grant all on grupo13.* to 'adminG13'@'localhost';

use grupo13;

create table usuario (
	usuario varchar(20) not null,
	nombre varchar(60) not null,
	contrasenha varchar(20) not null,
	primary key (usuario)
) engine=innodb;

create table pregunta (
	codPre int(8) not null,
	titulo varchar(60) not null,
	texto longtext not null,
	fecha date not null,
	etiquetas set ('PHP', 'JAVA', 'Html', 'CSS', 'Python', 'Jquery','C','C++','Ruby','SQL','JavaScript','Flex','Android','ASP','XML','PASCAL') not null,
	autor varchar(20) not null,
	primary key (codPre),
	foreign key (autor) references usuario(usuario) on delete cascade on update cascade
) engine=innodb;

create table respuesta (
	codPre int(8) not null,
	codRes int(8) not null,
	texto varchar(1000) not null,
	fecha date not null,
	autor varchar(20),
	likesPos int(8) not null,
	likesNeg int(8) not null,
	primary key (codPre, codRes),
	foreign key (codPre) references pregunta (codPre) on delete cascade on update cascade,
	foreign key (autor) references usuario(usuario) on delete cascade on update cascade
) engine=innodb;

create table usuario_vota_respuesta (
  respuesta_codPre int(8) not null,
  respuesta_codRes int(8) not null,
  usuario_usuario varchar(20) not null,
  votado tinyint(1) null default '0',
  primary key (respuesta_codPre, respuesta_codRes, usuario_usuario),
  foreign key (respuesta_codPre, respuesta_codRes) references respuesta (codPre, codRes) on delete cascade on update cascade,
  foreign key (usuario_usuario) references usuario(usuario) on delete cascade on update cascade
) engine=InnoDB;
 

insert into usuario values('admin','administrador','abc123.');
INSERT INTO `usuario`(`usuario`, `nombre`, `contrasenha`) VALUES ('dnfernandez','diego','abc123.');
INSERT INTO `usuario`(`usuario`, `nombre`, `contrasenha`) VALUES ('aleks','Alex','abc123.');
/*INSERT INTO `pregunta`(`codPre`, `titulo`, `texto`, `fecha`, `etiquetas`, `autor`) VALUES ('p100','How to increment a JavaScript variable using a button press event','Can I create a javascript variable and increment that variable when I press a button (not submit the form). Thanks!',CURRENT_TIMESTAMP,'JavaScript','aleks');

INSERT INTO `respuesta`(`codPre`, `codRes`, `texto`, `fecha`, `autor`, `likesPos`, `likesNeg`) VALUES ('p100','r100','Me parece que esto lo soluciona<script type="text/javascript">
var counter = 0;
</script>',CURRENT_TIMESTAMP,'dnfernandez','5','2');*/



