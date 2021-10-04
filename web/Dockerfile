FROM wordpress:php7.4

# Copy PHP custom settings file
COPY ./custom.php.ini $PHP_INI_DIR/conf.d/

# Install SSH sync necessary packages
RUN apt-get update \
  && apt-get install -y ssh sshpass rsync mariadb-server mariadb-client

# Pass key from secrets
RUN mkdir /root/.ssh/ && ln -s /run/secrets/host_ssh_key /root/.ssh/id_rsa
RUN touch /root/.ssh/known_hosts
RUN mkdir /root/.ssh/socket/
RUN echo "StrictHostKeyChecking no" >> /etc/ssh/ssh_config

# Install PHP YAML support to parse remote.sites.yml
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions yaml
COPY ./code/config/yaml_to_env.php /opt/yaml_to_env.php
RUN mkdir /opt/remote

# Install WP CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
  && chmod +x wp-cli.phar \
  && mv wp-cli.phar /usr/local/bin/wp \
  && wp --info

WORKDIR /var/www/html
