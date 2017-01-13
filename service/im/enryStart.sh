#! /bin/sh
echo "Hello Enry!"
killall httpd
echo "killall httpd ...stoped"
killall memcached
echo "killall memcached ...stoped"
/usr/local/nginx/sbin/nginx
echo "nginx ...started"
/usr/local/php/sbin/php-fpm -R &
echo "php ...started"
svnserve -d  -r /var/svn/svndata/ --pid-file=/var/svn/svndata/svn.pid
echo "svn started"
service vsftpd start
echo "vsftpd ...startd"
php /htdocs/apistore/service/im/start.php
echo "im ...started"
nohup /usr/local/bin/redis-server /etc/redis/6379.conf
echo "redis ...started"
netstat -lnp
