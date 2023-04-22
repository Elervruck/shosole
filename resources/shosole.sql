
create table estado_usuarios(
	id_estado_usuario serial primary key not null,
	estado_usuario character varying(30) not null
);

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

create table usuarios(
	id_usuario serial primary key not null,
	nombre_usuario character varying(150) not null,
	apellido_usuario character varying(150) not null,
	correo_usuario character varying (100) not null,
	alias_usuario character varying(50) not null,
	clave_usuario character varying(150) not null,
	id_genero integer not null,
	id_cargo integer not null,
	id_estado_usuario integer not null,
	foto_usuario character varying(100) null,
	intentos smallint null,
	fecha_bloqueo timestamp without time zone null,
	fecha_desbloqueo timestamp without time zone null
);

create table modelos(
	id_modelo serial primary key not null,
	modelo character varying(50) not null,
	id_marca integer not null
);


create table marcas(
	id_marca serial primary key not null,
	marca character varying(50) not null,
	imagen_marca character varying(50) not null
);

create table condicion_productos(
	id_condicion_producto serial primary key not null,
	condicion_producto character varying(25) not null
);

create table productos(
	id_producto serial primary key not null,
	nombre_producto character varying (150) not null,
	descripcion_producto character varying(300) not null,
	imagen_producto character varying(50) not null,
	estado_producto character varying (50) not null,
	id_usuario integer not null,
	id_modelo integer not null,
	id_condicion_producto integer not null
);

create table clientes(
	id_cliente serial primary key not null,
	nombre_cliente character varying (100) not null,
	apellido_cliente character varying (150) not null,
	dui_cliente character varying (10) not null,
	correo_cliente character varying (100) not null,
	telefono_cliente character varying (9) not null,
	nacimiento_cliente date not null,
	direccion_cliente character varying (200) not null,
	clave_cliente character varying (100) not null,
	id_estado_cliente integer not null,
	id_genero integer not null,
	usuario character varying (100) not null
);

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

create table valoraciones(
	id_valoracion serial primary key not null,
	calificacion_producto integer not null,
	id_detalle_pedido integer not null,
	comentario_producto character varying (500) null,
	fecha_comentario timestamp without time zone null,
	estado_comentario character varying null
);
																																																																										
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


			