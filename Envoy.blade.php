@servers(['web' => '127.0.0.1'])

@task('production')
supervisord -c /etc/supervisord.conf
{{--基本設定--}}
php artisan storage:link
php artisan route:cache
php artisan view:cache
{{--啟動設定--}}
supervisorctl start laravel-php-fpm:*
supervisorctl start laravel-worker:*
supervisorctl start laravel-nginx:*

tail -f /dev/null
@endtask

@task('local')
supervisord -c /etc/supervisord.conf
{{--啟動設定--}}
supervisorctl start laravel-php-fpm:*
supervisorctl start laravel-worker:*
supervisorctl start laravel-nginx:*

tail -f /dev/null
@endtask

@task('laravel-setting')
php artisan migrate
php artisan storage:link
php artisan route:cache
php artisan view:cache
@endtask

@task('php-fpm')
supervisorctl start laravel-nginx:*
@endtask

@task('nginx')
supervisorctl start laravel-nginx:*
@endtask

@task('laravel-swoole')
supervisorctl start laravel-swoole:*
@endtask

@task('laravel-schedule')
php /var/www/artisan schedule:run >> /dev/null 2>&1;
@endtask

@task('laravel-worker')
supervisorctl start laravel-worker:*
@endtask


@task('dev')
{{--下載套件--}}
composer install
yarn --ignore-engines install
{{--基本設定--}}
{{--yarn dev--}}
php artisan migrate
php artisan storage:link
{{--啟動設定--}}
php -S 0.0.0.0:80 -t public
{{--php artisan queue:listen --tries=1--}}
@endtask
