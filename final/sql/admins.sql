create table admins
(
    id       int auto_increment,
    name     varchar(255) not null,
    email    varchar(255) not null,
    password      varchar(255) not null,
    status varchar(255) not null,
    constraint id
        primary key (id)
);