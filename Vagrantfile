# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  config.vm.box = "xenji/ubuntu-17.04-server"
  config.vm.synced_folder ".", "/var/www/project",  mount_options: ["dmode=777,fmode=777"]

  config.vm.network "private_network", ip: "33.33.33.33"

   config.vm.provision "shell", inline: <<-SHELL

debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

apt-get update
apt-get install -y vim curl apache2 mysql-server php php-mysql php-cli php-curl php-xml openjdk-8-jdk

mkdir -p /usr/local/bin

#Install elasticsearch
url -L -O https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-5.4.2.tar.gz

#Install symfony
curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
chmod a+x /usr/local/bin/symfony

#Install composer
curl -LsS https://getcomposer.org/download/1.4.2/composer.phar -o /usr/local/bin/composer
chmod a+x /usr/local/bin/composer

#Install adminer.php
wget https://github.com/vrana/adminer/releases/download/v4.3.1/adminer-4.3.1-en.php -O adminer.php

cat > /etc/apache2/sites-available/onpage.org.conf<<EOF
  <VirtualHost *:80>
    ServerName domain.tld
    ServerAlias www.domain.tld
    Alias /adminer.php /var/www/project/adminer.php
    DocumentRoot /var/www/project/web
    <Directory /var/www/project/web>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/apache2/project_error.log
    CustomLog /var/log/apache2/project_access.log combined
  </VirtualHost>
EOF
a2ensite onpage.org
a2enmod rewrite
systemctl reload apache2
echo 'cd /var/www/project' >> /home/vagrant/.bashrc
   SHELL
end
