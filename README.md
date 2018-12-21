# shijia
中国工业设计协会

2014年的一个项目
部署
liunx
nginx
php5.6
mysql
thinkphp3.2


NGINX配置
server {
          listen 80;
          root /var/www/shijia;

          # Add index.php to the list if you are using PHP
          # index index.html index.htm index.php;

          server_name localhost;
          location / {
          index index.html index.htm index.php;
                    if (!-e $request_filename) {
                    rewrite ^/index.php(.*)$ /index.php?s=$1 last;
                    rewrite ^(.*)$ /index.php?s=$1 last;
                    break;
                    }
          }
          location ~ \.php$ {
          include /etc/nginx/fastcgi_params;
          #fastcgi_pass 127.0.0.1:9000;
          fastcgi_pass unix:/var/run/php5-fpm.sock;
          fastcgi_index index.php;
          #fastcgi_param SCRIPT_FILENAME /var/www/nginx-default$fastcgi_script_name;
          }
}
