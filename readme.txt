Sur free

cette ip 192.168.0.80
pour l'addr mac : 74:86:7a:6d:37:fd

pour l'extérieur : http://78.248.20.90/comgocom.pw

------------------------------------------------------------------------

dans /etc/apache2/sites-available

nano comgocom.pw.conf

    ------------/etc/apache2/sites-available/comgocom.pw.conf--------------
        <VirtualHost *:80>
                ServerName comgocom.pw

                ServerAdmin webmaster@localhost
                DocumentRoot /home/nathalie/www/comgocom.pw/

                <Directory /home/nathalie/www/comgocom.pw/>
                require all granted
                AllowOverride All
                </Directory>

                LogLevel info

                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined

        </VirtualHost>
    -------------------------------------------------------------------------

nano /etc/hosts

    -------------------------- /etc/hosts -------------------------
        127.0.0.1       localhost
        127.0.1.1       Eve
        192.168.0.18    comgocom.pw

        # The following lines are desirable for IPv6 capable hosts
        ::1     localhost ip6-localhost ip6-loopback
        ff02::1 ip6-allnodes
        ff02::2 ip6-allrouters

    ------------------------------------------------------------------


chown -R nathalie:www-data /home/nathalie/www/


ln -s /home/nathalie/www/comgocom.pw/ /var/www/comgocom.pw

chown -R root:www-data /var/www/

chmod -R 2750 /var/www/

[2 +750] => pour droit SETGID 

a2ensite comgocom.pw.conf 

systemctl reload apache2
