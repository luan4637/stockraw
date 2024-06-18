# ssh s8
web: http://192.168.100.173:8082
ssh u0_a614@192.168.100.173 -p 8022 / 123456

# run server
php spark serve --port 80 --host codetest.private

# create database
CREATE DATABASE codetest CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'codetest'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON codetest.* TO 'codetest'@'localhost';

ALTER TABLE `transaction` ADD UNIQUE `unique_code_date`(`code`, `date`);

# migration
php spark make:migration [name]
php spark migrate
php spark migrate:rollback

# seed
php spark db:seed Groups
php spark db:seed Codes 
