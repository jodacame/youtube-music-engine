FROM mysql:5.7
ARG userid=1000
ENV DOCKER_UID $userid

COPY ./my.cnf /etc/mysql/conf.d/

RUN apt update
RUN apt install -y sudo

RUN usermod -u $DOCKER_UID www-data \
    && groupmod -g $DOCKER_UID www-data \
    && chsh -s /bin/bash www-data \
    && echo "www-data ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/90-www-data

RUN chown -R $DOCKER_UID /var/lib/mysql
USER $DOCKER_UID
