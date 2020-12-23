FROM larvata/laravel-elite-image:3.1.1

# Composer install
COPY composer.* /tmp/
RUN cd /tmp && composer install --no-dev --no-autoloader

# Copy project
RUN rm -rf /var/www/*
COPY ./ /var/www

RUN rm -rf /var/www/vendor && mv /tmp/vendor/ /var/www && composer dump-autoload
