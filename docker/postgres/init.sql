create role dockeruser login password 'dockerpass';
create database dockerdb;
grant all privileges on database dockerdb to dockeruser;
