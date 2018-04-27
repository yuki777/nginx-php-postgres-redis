# Install docker and docker-compose
- https://docs.docker.com/compose/install/

# Middlewares
- Nginx    1.13.5
- PHP      7.2.*
- Postgres 9.6.8
- Redis    3.2.11

# Install
```
mkdir -p ~/apps
git clone git@github.com:yuki777/nginx-php-postgres-redis.git ~/apps/nginx-php-postgres-redis
cd ~/apps/nginx-php-postgres-redis

docker-compose up

docker exec -it nginx-php-postgres-redis_php_1 sh
php composer.phar -vvv install
```

# URLs
- http://localhost/
- https://localhost/

# Links
- https://tech.recruit-mp.co.jp/infrastructure/post-12795/
