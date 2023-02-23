FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
  cron

RUN echo "* * * * * root php /var/www/html/cron.php >> /var/log/cron.log 2>&1" >> /etc/crontab

RUN chmod 0644 /etc/crontab

RUN crontab /etc/crontab

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

CMD bash -c "cron && php-fpm"