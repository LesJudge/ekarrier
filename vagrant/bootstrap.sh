#!/usr/bin/env bash

# Frissítés.
sudo apt-get update
# Szükséges csomagok telepítése.
sudo apt-get install -y python-software-properties
sudo apt-get install -y curl
# Apache telepítése.
sudo apt-get install -y apache2
sudo a2enmod rewrite
sudo apt-get install -y libapache2-mod-php5
# PHP telepítése.
sudo add-apt-repository ppa:ondrej/php5-oldstable
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install -y php-pear php5-cli php5-common php5-curl php5-dev php5-gd php5-mcrypt php5-mysql php5-xdebug
# MySQL telepítése.
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get update
sudo apt-get install -y mysql-server
sudo sed -i "s/bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf 
sudo service mysql restart
sudo mysql -u root -proot --execute "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root' with GRANT OPTION; FLUSH PRIVILEGES;"
sudo service mysql restart
sudo mysql -u root -proot --execute "CREATE DATABASE `ekarrier_production` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci */;"
sudo mysql -u root -proot --execute "CREATE DATABASE `ekarrier_dev` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci */;"
sudo mysql -u root -proot --execute "CREATE DATABASE `ekarrier_test` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci */;"
# Composer telepítése.
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
# NodeJS telepítése.
sudo apt-add-repository ppa:chris-lea/node.js
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install -y nodejs
sudo npm install -g less