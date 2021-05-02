With `visudo` command, add lines below
```
www-data ALL=(ALL) NOPASSWD: /usr/sbin/grub-reboot
www-data ALL=(ALL) NOPASSWD: /sbin/reboot
www-data ALL=(ALL) NOPASSWD: /sbin/shutdown
```

Install nginx
```
sudo apt update
sudo apt install nginx
```

Clone repo at good place
```
sudo git clone https://git.hexanyn.fr/servers/yann4/www/grub.git /var/www/
```

Create file at `/etc/nginx/sites-enabled/grub.conf`
```
server {
	listen 42666;

	charset utf-8;
	index index.html index.php;
	client_max_body_size 10M;

	access_log /var/log/nginx/grub-access.log combined;
	error_log /var/log/nginx/grub-error.log error;

	root /var/www/grub;

	include /etc/nginx/conf.d/php.conf;

	location / {
		index index.htm index.html index.php;
	}

	location ~ ^/(conf|share)/(.+)$ {
		deny all;
	}
}
```
