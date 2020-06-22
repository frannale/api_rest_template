# API REST TEMPLATE

SE REQUIERE XAMPP 7.4

- clonar repositorio

- composer install

- configurar archivo C:\xampp7.4\apache\conf\extra\httpd-vhosts

Esto configura en la url 127.0.0.1:80 para levantar nuestro servidor, autorizando las peticciones HTTP con authorization. 

<VirtualHost 127.0.0.1:80>
    DocumentRoot "C:/xampp7.4/htdocs/DEV/public"
    DirectoryIndex index.php

    <Directory "C:/xampp7.4/htdocs/DEV/public">
        AllowOverride None
        Order Allow,Deny
        Allow from All

        FallbackResource /index.php
    </Directory>
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
</VirtualHost>

- Para ver la documentacion y ver como interactuar con la API : 127.0.0.1/api/doc 


