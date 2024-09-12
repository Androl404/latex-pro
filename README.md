# LaTeX-pro

This is LaTeX-pro, an online LaTeX editor which is providing multiple functionalities for managing users and LaTeX projets.

# About the projet

## **WARNING**

> [!WARNING] 
> **THIS SOFTWARE IS UNFINISHED AND MIGHT CONTAIN DANGEROUS SECURITY ISSUES. DO NOT USE IT IN PRODUCTION!!! I am not responsible for anything that might happen to you and your data!**


## Motivations

I am a huge LaTeX person and I wanted to self-host an online LaTeX editor in order to collaborate in multiple projects. I tried Overleaf (in its self-hosted version) and I was chocked about how goddamn stupid this piece of software is, and the pain in the ass to install it in a virtual machine (took me literally a week-end).

I then decided that I shall take my revenge and I wrote LaTeX-pro during the 2024 summer.

## About the code

I am warning you, what you are about to see is some low quality PHP and JavaScript code which can be heavily improved. My goal was to make this software work, whitout really 

# How to install/use

First of all, you need to clone this repository on a server with `apache2` and `PHP 8.*` installed. Make sure you also have a LaTeX distribution fully installed with all the packages and add it in the `www-data` user PATH.

You will also need an SQL databse and I recommand using MariaDB. Create a database for LaTeX-pro as well as a user with permissions on read and write only for this database.

Back to the folder you've cloned LaTeX-pro in, you will need to go to the `config` folder and copy `config.php.blank` to `config.php` and `database.php.blank` to `database.php` while adding the informations to connect to the database in the `database.php` file.

Then, you'll have to create your website in Apache, create your configuration file in `/etc/apache2/sites-available/latex-pro.conf` for instance. **This is an important step**, because I hate `.htaccess` files and you will have to make several modifications to that file. Here is an example of how your config file should look:

```apache
<VirtualHost *:80>
     DocumentRoot "/var/www/latex-pro"
     ServerName domain
     ServerAlias alias_domain
     ServerAdmin admin@domain
     DirectoryIndex index.html index.php index.htm welcome.html

     <Directory /var/www/latex-pro>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
        RewriteEngine On
     </Directory>

     <Directory /var/www/latex-pro/latex-pro/config>
        Redirect 404
     </Directory>

     <Directory /var/www/latex-pro/latex-pro/projects>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} -f
        RewriteRule ^(.*)$ /latex-pro/check_access.php?file=projects/$1 [QSA,L]
     </Directory>

     <Directory /var/www/latex-pro/latex-pro/archives>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} -f
        RewriteRule ^(.*)$ /latex-pro/check_access.php?file=archives/$1 [QSA,L]
     </Directory>

     TransferLog /var/log/apache2/latex-pro_access.log
     ErrorLog /var/log/apache2/latex-pro_error.log

     ErrorDocument 400 /latex-pro/http_error/400.html
     ErrorDocument 401 /latex-pro/http_error/401.html
     ErrorDocument 403 /latex-pro/http_error/403.html
     ErrorDocument 404 /latex-pro/http_error/404.html
     ErrorDocument 500 /latex-pro/http_error/500.html
     ErrorDocument 501 /latex-pro/http_error/501.html
     ErrorDocument 502 /latex-pro/http_error/502.html
     ErrorDocument 503 /latex-pro/http_error/503.html
</VirtualHost>
```

The last step is about creating the `projects` and `archives` folder. Make sure to use `projects` and `archives` as folder's name and not mispell them. Make sure then the user `www-data` has full access to these two folders in order to be able to create and modify LaTeX projets.

> [!INFO]
> Don't forget to add your LaTeX distribution installation to the `www-data` PATH in the file `/etc/apache2/envvars`. More about that is this [StackOverflow answer](https://askubuntu.com/questions/204159/add-path-to-path-environment-variable-for-www-data).

# Reporting issues and contributing

Any issues and pull requests are welcome in order to improve LaTeX-pro, feel free to contribute while providing infos about the problem you are facing if you are opening an issue, or the change you want to add if you are opening a pull request.
