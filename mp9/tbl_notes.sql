create table notes(
    id        int auto_increment,
    note      varchar(255) not null,
    date_time datetime     not null,
    constraint id
        primary key (id)
);