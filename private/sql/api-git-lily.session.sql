CREATE table users(
    id int(10) primary key not null Auto_increment,
    lname varchar (50),
    fname varchar (50),
    mname varchar (50),
    username varchar (50),
    password varchar (50)
)
-- @block

insert into users(
    lname,
    fname,
    mname, 
    username,
    password
) values (
    "Cruz",
    "Juan",
    "dela",
    "JuandelaCruz000",
    "00000"
)