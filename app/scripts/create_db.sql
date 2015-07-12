DROP ROLE IF EXISTS vgpg_user;
DROP DATABASE IF EXISTS vgpg_cms;

create user "vgpg_user" with encrypted password 'q1w2e3';
create database vgpg_cms;
grant all on database vgpg_cms to vgpg_user;
