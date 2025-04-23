create database proyectoiglesiaBD;
use proyectoiglesia;
create table cargo(
    id int not null AUTO_INCREMENT,
    nombre varchar(100) not null,
    descripcion varchar(255) not null,
    PRIMARY KEY(id)
);

create table usuario(
    id int not null AUTO_INCREMENT,
    idCargo int,
    nombres varchar(100) not null,
    apellidos varchar(100),
    email varchar(100) not null,
    pwd varchar(100) not null,
    primary key(id),
    FOREIGN KEY(idCargo) references cargo(id) ON DELETE SET NULL ON UPDATE CASCADE 
);

create table tipoEvento(
    id int not null AUTO_INCREMENT,
    nombre varchar(100) not null,
    frecuencia varchar(255) not null,
    descripcion varchar(255) not null,
    PRIMARY KEY(id)
);

create table ministerio(
    id int not null AUTO_INCREMENT,
    nombre varchar(100) not null,
    mision text not null,
    vision text not null,
    fechaCreacion date not null,
    activo boolean DEFAULT 1,
    idLider int null,
    PRIMARY KEY(id),
    foreign key (idLider) references usuario(id) ON DELETE SET NULL
);

create table miembro(
    idUsuario int not null,
    idMinisterio int not null,
    fechaIncorpporacion date not null,
    idRol varchar(100),
    PRIMARY KEY (idUsuario, idMinisterio),
    FOREIGN KEY (idMinisterio) REFERENCES ministerio(id) ON DELETE CASCADE,
    FOREIGN KEY (idUsuario) REFERENCES usuario(id) ON DELETE CASCADE
);
