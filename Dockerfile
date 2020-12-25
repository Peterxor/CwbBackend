FROM larvata/laravel-elite-image:3.1.1
RUN apk update && apk add --no-cache \
    nodejs \
    npm \
    yarn

# Yarn install
COPY package.json yarn.* /tmp/
RUN cd /tmp && yarn --ignore-engines install
RUN yarn global add laravel-echo-server

# Composer install
COPY composer.* /tmp/
RUN cd /tmp && composer install --no-dev --no-autoloader

# Copy project
RUN rm -rf /var/www/*
COPY ./ /var/www
RUN rm -rf /var/www/node_modules && mv /tmp/node_modules/ /var/www
RUN rm -rf /var/www/vendor && mv /tmp/vendor/ /var/www && composer dump-autoload
