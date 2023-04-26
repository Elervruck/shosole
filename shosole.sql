--------TABLAS--------
create table estado_usuarios(
	id_estado_usuario serial primary key not null,
	estado_usuario character varying(30) not null
);
---Si--
create table cargos(
	id_cargo serial primary key not null,
	cargo character varying(50) not null
);

create table generos(
	id_genero serial primary key not null,
	genero character varying (30) not null
);

create table estado_clientes(
    id_estado_cliente serial primary key not null,
    estado_cliente character varying (30) not null
);
---Si--
create table usuarios(
	id_usuario serial primary key not null,
	nombre_usuario character varying(150) not null,
	apellido_usuario character varying(150) not null,
	correo_usuario character varying(100) unique not null,
	alias_usuario character varying(50) unique not null,
	clave_usuario character varying(150) not null,
	id_genero integer not null,
	id_cargo integer not null,
	id_estado_usuario integer not null,
	foto_usuario character varying(100) null,
	intentos smallint null,
	fecha_bloqueo timestamp without time zone null,
	fecha_desbloqueo timestamp without time zone null
);
---Si--

create table modelos(
	id_modelo serial primary key not null,
	modelo character varying(50) not null,
	id_marca integer not null
);

---Si--
create table marcas(
	id_marca serial primary key not null,
	marca character varying(50) not null,
	imagen_marca character varying(50) not null
);

create table condicion_productos(
	id_condicion_producto serial primary key not null,
	condicion_producto character varying(25) not null
);
---Si--
create table productos(
	id_producto serial primary key not null,
	nombre_producto character varying (150) not null,
	descripcion_producto character varying(300) not null,
	imagen_producto character varying(50) not null,
	estado_producto boolean not null,
	id_usuario integer not null,
	id_modelo integer not null,
	id_condicion_producto integer not null
);

---Si---
create table clientes(
	id_cliente serial primary key not null,
	nombre_cliente character varying (100) not null,
	apellido_cliente character varying (150) not null,
	dui_cliente character varying (10) unique not null,
	correo_cliente character varying (100) unique not null,
	telefono_cliente character varying (9) unique not null,
	nacimiento_cliente date not null,
	direccion_cliente character varying (200) not null,
	clave_cliente character varying (100) not null,
	id_estado_cliente integer not null,
	id_genero integer not null,
	foto_cliente character varying(500) null,
	usuario_cliente character varying (100) not null
);

---Si--
create table pedidos(
	id_pedido serial primary key not null,
	estado_pedido character varying (50) not null,
	fecha_pedido date not null,
	direccion_pedido character varying (250) not null,
	id_cliente integer not null
);

create table detalle_pedidos(
	id_detalle_pedido serial primary key not null,
	id_producto integer not null,
	id_pedido integer not null,
	cantidad_producto int not null,
	precio_producto numeric(7,2) not null
);
---Si--
create table valoraciones(
	id_valoracion serial primary key not null,
	calificacion_producto integer not null,
	id_detalle_pedido integer not null,
	comentario_producto character varying (500) null,
	fecha_comentario timestamp without time zone null,
	estado_comentario boolean not null
);
--------TABLAS--------																																																																										

--------LLAVES FORANEAS--------
ALTER TABLE usuarios
ADD CONSTRAINT fk_estado_usuario
FOREIGN KEY (id_estado_usuario)
REFERENCES estado_usuarios(id_estado_usuario);

ALTER TABLE usuarios
ADD CONSTRAINT fk_cargo_usuario
FOREIGN KEY (id_cargo)
REFERENCES cargos(id_cargo);

ALTER TABLE usuarios
ADD CONSTRAINT fk_genero_usuarios
FOREIGN KEY (id_genero)
REFERENCES generos(id_genero);

ALTER TABLE productos
ADD CONSTRAINT fk_usuario_producto
FOREIGN KEY (id_usuario)
REFERENCES usuarios(id_usuario);

ALTER TABLE modelos
ADD CONSTRAINT fk_marca_modelo
FOREIGN KEY (id_marca)
REFERENCES marcas(id_marca);

ALTER TABLE productos
ADD CONSTRAINT fk_modelo_producto
FOREIGN KEY (id_modelo)
REFERENCES modelos(id_modelo);

ALTER TABLE detalle_pedidos
ADD CONSTRAINT fk_producto_detalle
FOREIGN KEY (id_producto)
REFERENCES productos(id_producto);

ALTER TABLE productos
ADD CONSTRAINT fk_condicion_producto
FOREIGN KEY (id_condicion_producto)
REFERENCES condicion_productos(id_condicion_producto);

ALTER TABLE clientes
ADD CONSTRAINT fk_genero_cliente
FOREIGN KEY (id_genero)
REFERENCES generos(id_genero);  

ALTER TABLE clientes
ADD CONSTRAINT fk_estado_cliente
FOREIGN KEY (id_estado_cliente)
REFERENCES estado_clientes(id_estado_cliente);

ALTER TABLE pedidos
ADD CONSTRAINT fk_cliente_pedido
FOREIGN KEY (id_cliente)
REFERENCES clientes(id_cliente);

ALTER TABLE detalle_pedidos
ADD CONSTRAINT fk_pedido_detalle
FOREIGN KEY (id_pedido)
REFERENCES pedidos(id_pedido);

ALTER TABLE valoraciones
ADD CONSTRAINT fk_detalle_valoracione
FOREIGN KEY (id_detalle_pedido)
REFERENCES detalle_pedidos(id_detalle_pedido);
--------LLAVES FORANEAS--------


-----Consultas------
select * from estado_usuarios
select * from cargos
select * from generos
select * from estado_clientes
select * from usuarios
select * from modelos
select * from marcas
select * from condicion_productos
select * from productos
select * from clientes
select * from pedidos
select * from detalle_pedidos
select * from valoraciones
-----Consultas------

----COMANDOS DML INSERT----
insert into estado_usuarios(id_estado_usuario, estado_usuario)
values (default, 'Activo'),
       (default, 'Inactivo'),
       (default, 'Eliminado');
	
insert into cargos(id_cargo, cargo)
values (default, 'Administrador'),
       (default, 'Root');	
	   
insert into generos(id_genero, genero)
values (default, 'Masculino'),
       (default, 'Femenino');
     

insert into estado_clientes(id_estado_cliente, estado_cliente)
values (default, 'Activo'),
       (default, 'Inactivo'),
       (default, 'Eliminado');
       
insert into marcas (id_marca, marca, imagen_marca)
values (default, 'Sony','Sony.jpg'),
        (default, 'Nintendo','Nintendo.jpg'),
        (default, 'Microsoft','Microsoft.jpg'),
        (default, 'Sega','Sega.jpg'),
        (default, 'Atari','Atari.jpg'),
        (default, 'Micro_Genius ','Micro_Genius.jpg'),
        (default, 'Bandai','Bandai.jpg'),
        (default, 'Mattel','Mattel.jpg'),
        (default, 'Tectoy','Tectoy.jpg'),
        (default, 'Nokia','Nokia.jpg');
       
insert into condicion_productos (id_condicion_producto, condicion_producto)
values (default, 'Nuevo'),
         (default, 'Usado'),
         (default, 'Recondicionado');


insert into usuarios (id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, id_genero, id_cargo, id_estado_usuario, intentos)
values (default, 'Christian Sebastián', 'Ellerbrock Barahona', '20210089@ricaldone.edu.sv', 'EllerBarah025', 'Eller20_23', 1, 1, 1, 3 ),
       (default,'Luis Alfredo', 'Castillo Monterroza', '20210482@ricaldone.edu.sv', 'LuAlfredo482','LuiMonte45', 1, 2, 2, 3),
       (default, 'Eduardo Alfonso', 'Barahona Vasquéz', '20210451@ricaldone.edu.sv', 'EduBaraho065', 'VasAlfonso02', 1, 3, 3, 3),
       (default, 'Melissa Arely', 'Sandoval  Muñoz', '20210678@ricaldone.edu.sv', 'MelSandoval', 'SandoArely08', 2, 2, 1, 3),
       (default, 'Keila Raquel', 'Cáceres García', '20210228@ricaldone.edu.sv', 'KeiRaq013', 'RaquelGar534', 2, 2, 1, 3),
       (default, 'Gabriel Guillermo', 'Aparicio García', '20190211@ricaldone.edu.sv', 'GAparicio89', 'Apagabri62', 1, 3, 2, 3),
       (default, 'Camila Gabriela', 'García Vasquéz', '20210574@ricaldone.edu.sv', 'CamGarcía', 'Gabriela20_21', 2, 2, 2, 3),
	   (default,'Daniel Stanley', 'Carranza Miguel', 'daniel_carranza@ricaldone.edu.sv', 'DCarranza', 'Stanley20_23', 1, 1, 1, 3),
	   (default,'Dayana Fiorella', 'Pérez Mejía', 'dayana_perez@ricaldone.edu.sv', 'FiorellaD', 'Dayana/6543', 2, 1, 2, 3),
	   (default,'Allan Fernando', 'Cárcamo Martínez', 'allan_carcamo@ricaldone.edu.sv', 'AMartinez', 'AllanFernan/20', 1, 2, 2, 3);
	   
	   
insert into modelos (id_modelo, modelo, id_marca)
values ( default, 'PlayStation_4',1),
        ( default, 'Nintendo 64 ',2),
        ( default, 'Xbox 360 ',3),
        ( default, 'Sega Mega Drive',4),
        ( default, 'Atari 2600',5),
        ( default, 'Dendy',6),
        ( default, 'WonderSwan',7),
        ( default, 'Intellivision','8'),
        ( default, ' Mega Drive',9),
        ( default, 'N-Gage',10);
		
	
insert into productos (id_producto, nombre_producto, descripcion_producto, imagen_producto, estado_producto, id_usuario, id_modelo, id_condicion_producto)
values (default, 'Play4', 'es la cuarta videoconsola del modelo PlayStation. Es la segunda consola de Sony en ser diseñada por Lucmanwar y forma parte de las videoconsolas de octava generación. Fue anunciada oficialmente el 20 de febrero de 2013 en el evento PlayStation Meeting 2013','Play.jpg','true', 1, 1, 1 ),
        (default, 'Nintendo 64','Nintendo 64 es la cuarta videoconsola de sobremesa descontinuada producida por Nintendo, desarrollada para suceder a la Super Nintendo. Fue la primera consola concebida para dar el salto del 2D al 3D. Compitió en el mercado de la quinta generación con Saturn de Sega y PlayStation','Nintendo.jpg','true', 2, 2, 1 ),
        (default, 'Xbox 360','Xbox 360 es la segunda videoconsola de sobremesa de la marca Xbox producida por Microsoft. Fue desarrollada en colaboración con IBM y ATI (AMD) y lanzada en América del Sur, América del Norte, Japón, Europa y Australia entre 2005 y 2006. Su servicio Xbox Live (el cual es de pago','Xbox360.jpg','true', 3, 3, 1),
        (default, 'Sega Mega Drive','Mega Drive, conocida en diversos territorios de América como Genesis, es una videoconsola de sobremesa de 16 bits desarrollada por Sega Enterprises, Ltd. Mega Drive fue la tercera consola de Sega y la sucesora de la Master System.','MegaDrive.jpg','true', 4, 4, 1 ),
        (default, 'Atari 2600','La Atari 2600 es una videoconsola lanzada al mercado en 1977 bajo el nombre de Atari VCS (Video Computer System), convirtiéndose en el primer sistema de videojuegos en tener gran éxito, e hizo popular los cartuchos intercambiables.','Atari200.jpg','true', 5, 5, 1 ),
        (default, 'Dendy','Esta pieza de arte es elegante y seductora gracias a su acertada mezcla de colores y texturas. Los trazos verdes presentan un aspecto aterciopelado gracias a sus bordes difuminados, extendidos sobre una sólida estructura de elementos blancos y negros.','Dendy.jpg','true', 6, 6, 1),
        (default, 'WonderSwan','WonderSwan Color, una consola de juegos portátil japonesa lanzada a fines de 2000. WonderSwan Color fue la continuación del WonderSwan monocromático original de Bandai que se lanzó el año anterior. La nueva computadora de mano ahora podía mostrarse','WonderSwan.jpg','true', 7, 7, 1),
        (default, 'Intellivision','La Intellivision fue desarrollada por Mattel Electronics, una subsidiaria formada expresamente para el desarrollo de juegos electrónicos. La consola fue probada en Fresno, California, en 1979 con un total de cuatro juegos disponibles,','Intellivision.jpg','true', 8, 8, 1 ),
        (default, 'Mega Drive','Mega Drive, conocida en diversos territorios de América como Genesis, es una videoconsola de sobremesa de 16 bits desarrollada por Sega Enterprises, Ltd. Mega Drive fue la tercera consola de Sega y la sucesora de la Master System.','MegaDrive.jpg','true', 9, 9, 1),
        (default, 'N-Gage','En 2003, Nokia ingresó en el mercado de las consolas de juegos lanzando el terminal portátil N-Gage, ofreciendo Reproductor MP3 y radio FM integrados, reproducción de vídeo, así como telefonía móvil, juego multijugador','N-Gage.jpg','true', 10, 10, 1);

	insert into clientes (id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, clave_cliente, id_estado_cliente,id_genero, usuario)
	values (default,'Eduardo Alfonso','Barahona Vasquez','06850497-1','eduardobarahoa973@gamil.com','78682132','2005/03/02','San Ramon de los altos','messiesgrande', 1, 1, 'barahona753'),
		(default,'Luis Alfredo','Castillo Monterrosa','06850497-2','l.alfredo37009@gmail.com','70614882','2004/11/09','San Marcos','12345', 1, 1, 'Alfrediño2024'),
		(default,'David Andres','Flores Valles','06850497-3','david05messisex@ricaldone.edu.sv','78682252','2002/05/01','Mejicanos','452342', 1, 1, 'David05'),
		(default,'Guillermo José','Barahona Hernandez','48930258-9','Guiellermo3023@gamil.com','712819834','2002/05/02','Los planes de Renderos','563565', 1, 1, 'Guillero_34'),
		(default,'Fatima Maria',' Gonsalez Coto','13243456-4','Gonsaaalez@gamil.com','35631452','2004/12/03','San José de cuerbo','375534', 1, 2,'FatimaGon'),
		(default,'Dayana Sofia','Lopez Cacerez ','78948746-2','Sofialopez769@gamil.com','23407594','2003/02/01','San lorenzo ','546345', 1, 2, 'Dayana_402'),
		(default,'Santiado Cristian','Carabajal Martinez','23450958-3','Matinezzz@gamil.com','53632131','2003/04/12','Porticos de buenos aires','12984132', 1, 1, 'Santi_323'),
		(default,'Sergui Alberto ','Flamenco Castillo','43298052-2','Flamencoser@gamil.com','23424325','2002/04/01','colonia los angeles','3133214', 1, 1, 'Sergui_223'),
		(default,'Sean Roberto','Durán Hernandez','24350987-3','Robertomaldonado@gamil.com','23433523','2003/04/06','Urbanisacion los proceres','432524', 1, 1, 'Roberto503'),
		(default,'Gustavo Jorge','Merino Flores','09883214-2','FloresDuran@gamil.com','32526575','2004/05/02','Avenida Bernal','245343526', 1, 1, 'Gustavo_777');
		
insert into pedidos(id_pedido, estado_pedido, fecha_pedido, direccion_pedido, id_cliente)
values (default, 'true', '2023/03/12','San Vicente', 1),
		(default, 'true', '2023/03/14','San Miguel', 2),
		(default, 'true', '2023/03/19','San Salvador', 3),
		(default, 'true', '2023/03/24','Morazan', 4),
		(default, 'true', '2023/03/14','Ahuachapan', 5),
		(default, 'true', '2023/03/11','Antiguo coscatlan', 6),
		(default, 'true', '2023/03/04','Santa elena', 7),
		(default, 'true', '2023/03/07','San Marcos', 8),
		(default, 'true', '2023/03/22','Soyapango', 9),
		(default, 'true', '2023/03/20','Apopa', 10);
		
insert into detalle_pedidos (id_detalle_pedido, id_producto, id_pedido, cantidad_producto, precio_producto)
values  (default,  1, 1, 1, 499.99 ),
		(default, 2, 3, 2, 300.99 ),
        (default,  3, 2, 1,200.50 ),
        (default,  4, 1, 3,99.99 ),
        (default,  5, 5, 4,199.29 ),
        (default, 6, 3, 2,609.39 ),
        (default,  7, 1, 1,999.10 ),
        (default,  8, 2, 2,399.00 ),
        (default,  9, 3, 1,292.10 ),
        (default,  10, 1, 3,500.99 ),
		(default,  2, 2, 1, 150.33 ),
		(default, 6, 1, 1, 303.30),
		(default, 1,2,2, 150.33 ),
		(default, 10, 5, 3, 500.22 ),
		(default, 4,1, 3, 890.70),
		(default, 2, 1, 3, 600.11 ),
		(default, 8, 4, 4, 700.23),
		(default, 6, 2, 1, 800.19),
		(default, 9, 8, 2, 600.21),
		(default, 7, 4, 4, 346.21);

insert into valoraciones (id_valoracion, calificacion_producto, id_detalle_pedido, comentario_producto, fecha_comentario, estado_comentario)
values (default, 5, 1, 'No sirve la consola', '2023/03/21', 'true'),
		(default, 5, 2, 'No sirve la consola', '2023/03/20', 'true'),
		(default, 1, 3, 'No sirve la consola', '2023/03/21', 'true'),
		(default, 6, 4, 'No sirve la consola', '2023/03/12', 'true'),
		(default, 4, 5, 'No sirve la consola', '2023/03/15', 'true'),
		(default, 2, 6, 'No sirve la consola', '2023/03/28', 'true'),
		(default, 8, 7, 'si sirve', '2023/03/24', 'true'),
		(default, 9, 8, 'si sirve', '2023/03/27', 'true'),
		(default, 5, 9, 'No sirve la consola', '2023/03/20', 'true'),
		(default, 1, 10, 'No sirve la consola', '2023/03/17', 'true');
----COMANDOS DML INSERT----

		 
----COMANDOS DML UPDATE----		 
		update pedidos set direccion_pedido = 'San Jacinto'
		where direccion_pedido = 'San Vicente'

		update clientes set nombre_cliente = 'Eduardo Sergio'
		where id_cliente = 1

		update clientes set apellido_cliente = 'Barahona Vasquez'
		where id_cliente = 3

		update productos set imagen_producto = 'PlayStation.jpg'
		where id_producto = 1

		update usuarios set alias_usuario = 'Barasex'
		where id_usuario = 3
----COMANDOS DML UPDATE----
		 
select * from detalle_pedidos		 
		 
----COMANDOS DML DELETE----
		delete from valoraciones
		where id_valoracion = 1

		delete from detalle_pedidos
		where id_detalle_pedido = 1
		 
		delete from valoraciones
		where id_valoracion = 2
		 		 
		delete from valoraciones
		where id_valoracion = 3
		 
		delete from detalle_pedidos
		where id_detalle_pedido = 3 
----COMANDOS DML DELETE----
	

----COMANDOS JOINS ----
		select id_modelo, modelo, marcas.marca from modelos
		inner join marcas
		on modelos.id_marca = marcas.id_marca
		
		select id_pedido, direccion_pedido, clientes.nombre_cliente, clientes.apellido_cliente from pedidos
		inner join clientes
		on pedidos.id_cliente = clientes.id_cliente
		 
		select id_producto, nombre_producto, modelos.modelo from productos
		inner join modelos
		on productos.id_modelo = modelos.id_modelo
----COMANDOS JOINS ----	

----CONSULTAS CON GROUP BY ----
		 select id_genero, count(nombre_cliente) cliente_con_generos
		 from clientes
		 group by id_genero
		 
		 select id_cargo, count(nombre_usuario) Usuarios_con_cargos
		 from usuarios
		 group by id_cargo
		 
		 select id_genero, count(nombre_usuario) Usuarios_con_generos
		 from usuarios
		 group by id_genero
----CONSULTAS CON GROUP BY ----

		 
----CONSULTAS CON ORDER BY ----
		 select * from clientes order by id_cliente asc

		 select * from clientes order by id_cliente desc
		 
		 select * from usuarios order by id_usuario asc		 
----CONSULTAS CON ORDER BY ----		 
		 
----FUNCION  ----			 
		 create function BuscarConsola(integer) returns numeric
		 as
		 $$
		 select precio_producto from detalle_pedidos
		 where id_detalle_pedido = $1
		 $$
		 language SQL
		 select BuscarConsola(2)
----FUNCIONES ----	
		 
		 
----OPERADORES ARITMETICOS ----	
		 select id_detalle_pedido, precio_producto-(precio_producto*0.1)
		 from  detalle_pedidos
----OPERADORES ARITMETICOS ----	
		 
				 
----OPERADORES LOGICOS ----	
		 select * from detalle_pedidos
		 where (cantidad_producto=1) and (id_producto=6)
		 
		 select * from detalle_pedidos
		 where (cantidad_producto=15) or (id_pedido=3 and cantidad_producto=1)
		 
		 select * from usuarios 
		 where foto_usuario is not null;
----OPERADORES LOGICOS ----	
		 
		 
----FUNCION DE AGREGACION-----		
----FUNCION DE AGREGACION-----		


----REPORTE CON PARAMETROS-----	
	select * from pedidos
	where id_pedido = 1
	
	select * from usuarios
	where id_usuario = 2
	
	select * from usuarios
	where id_genero = 1
	
	select * from usuarios
	where id_genero = 2
	
	select * from modelos
	where id_marca = 1
----REPORTE CON PARAMETROS-----	


----REPORTE CON RANGO DE FECHAS-----	

	select * from valoraciones 
	where fecha_comentario 
	between '2023/03/12' and '2023/03/17'
	
	select * from pedidos
	where fecha_pedido
	between '2023/03/07' and '2023/03/19'
	
	select * from pedidos
	where fecha_pedido
	between '2023/03/04' and '2023/03/10'
	
----REPORTE CON RANGO DE FECHAS-----	