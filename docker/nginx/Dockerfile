FROM nginx:latest

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=backend:latest /var/www/app /var/www/app

WORKDIR /var/www/app

EXPOSE 8080 443