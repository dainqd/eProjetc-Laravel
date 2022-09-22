## OS: Ubuntu 20.04

# STEP 1:

Install Nginx

- https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04

```
sudo apt update

sudo apt install nginx
```

Managing nginx process

```
sudo systemctl enable nginx

sudo systemctl start nginx

sudo systemctl restart nginx
```

# STEP 2:

Install Nodejs (v16.x)

- https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04

```
cd ~
curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh

sudo bash nodesource_setup.sh

sudo apt install nodejs
```

# STEP 3:

Install MariaDB

- https://www.digitalocean.com/community/tutorials/how-to-install-mariadb-on-ubuntu-20-04

```
sudo apt update

sudo apt install mariadb-server

sudo mysql_secure_installation
```

- Current password: Enter
- Set root password: N
- Subsequent prompts: Y

Create admin user

```
sudo mariadb

GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;

FLUSH PRIVILEGES;

exit
```

Create database

```
sudo mariadb -u admin -p

CREATE DATABASE aptech_estudiez CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

exit
```

# STEP 4:

Install PHP v8.1

- https://www.cloudbooklet.com/how-to-install-or-upgrade-php-8-1-on-ubuntu-20-04/

```
sudo apt install php-fpm php-mysql php-common php-opcache php-cli php-pear php-pdo php-mysqlnd php-pgsql php-gd php-mbstring php-xml php-curl
```

Restart php-fpm

```
sudo service php8.1-fpm restart
```

# STEP 5:

Configure nginx

- https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-20-04

```
sudo mkdir /var/www/coder9tuoi.fpt-aptech.com

sudo chown -R root:root /var/www/coder9tuoi.fpt-aptech.com

sudo nano /etc/nginx/sites-available/coder9tuoi.fpt-aptech.com
```

Paste the following:

```
server {
    listen 80;
    server_name coder9tuoi.fpt-aptech.com;
    root /var/www/coder9tuoi.fpt-aptech.com/public;

    index index.html index.htm index.php;

    location / {
	    try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
     }

    location ~ /\.ht {
        deny all;
    }

}
```

```
sudo ln -s /etc/nginx/sites-available/coder9tuoi.fpt-aptech.com /etc/nginx/sites-enabled/

sudo unlink /etc/nginx/sites-enabled/default

sudo nginx -t

sudo systemctl reload nginx
```

# STEP 6:

Install Composer

- https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04

```
sudo apt update

cd ~

curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php

sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

# STEP 7:

Set up and clone repo from Gitlab

- https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-20-04

```
git config --global user.name "Your Name"

git config --global user.email "youremail@domain.com"

cd /var/www/coder9tuoi.fpt-aptech.com

git init

git remote add origin https://github.com/quando213/aptech-techwiz-estudiez.git

git pull origin main
```

# STEP 8:

Change permissions for logs

```
sudo chmod -R 775 storage

sudo chmod -R 775 public

sudo chmod -R 775 bootstrap/cache

sudo chmod -R ugo+rw public/images/upload

sudo chmod -R ugo+rw storage
```

# STEP 9:

Install dependencies

```
composer i

npm i
```

# STEP 11:

Copy env file

```
cp .env.example .env
```

Update database credentials

# STEP 12:

Run migration and seeder

```
php artisan key:generate

php artisan migrate:fresh --seed
```

# STEP 13:

Setup SSL

- https://www.digitalocean.com/community/tutorials/how-to-secure-nginx-with-let-s-encrypt-on-ubuntu-20-04

```
sudo apt install certbot python3-certbot-nginx

sudo certbot --nginx -d coder9tuoi.fpt-aptech.com
```

Restart Nginx

```
sudo systemctl restart nginx
```

# STEP 14:

Hooray you have finished. Here's the login credentials (admin/password):

- Student: quan.admin@gmail.com / coder9tuoi
- Parent: quan.parent@gmail.com / coder9tuoi
- Teacher: quan.teacher@gmail.com / coder9tuoi
- Admin: quan.admin@gmail.com / coder9tuoi
