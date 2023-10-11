FROM nginx:alpine

ARG NGINXGROUP
ARG NGINXUSER

ENV NGINXGROUP=${NGINXGROUP}
ENV NGINXUSER=${NGINXUSER}

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

ADD ./default.conf /etc/nginx/conf.d/

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}; exit 0

RUN mkdir /var/www

RUN chown -R ${NGINXUSER}:${NGINXGROUP} /var/www
