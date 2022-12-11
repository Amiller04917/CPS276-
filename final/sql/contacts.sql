create table contacts
(
    id       int auto_increment,
    name     varchar(255) not null,
    address  varchar(255) not null,
    city     varchar(255) not null,
    state     varchar(255) not null,
    phone    varchar(255) not null,
    email    varchar(255) not null,
    dob      varchar(255) not null,
    contacts varchar(255) not null,
    age      varchar(255) not null,
    constraint id
        primary key (id)
);