FROM larvata/laravel-elite-image:3.1.4

# Composer install
COPY composer.* /tmp/
RUN cd /tmp && composer install --no-dev --no-autoloader

# Copy project
COPY ./ /var/www
RUN rm -rf /var/www/vendor && mv /tmp/vendor/ /var/www && composer dump-autoload
