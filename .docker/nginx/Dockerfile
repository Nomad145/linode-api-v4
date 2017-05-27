FROM nginx

MAINTAINER Michael Phillips <michael.phillips@manpow.com>

COPY bin/entrypoint.sh /usr/local/bin
RUN chmod +x /usr/local/bin/entrypoint.sh
COPY conf/vhost_dev.conf /etc/nginx/nginx.conf.dev
COPY conf/vhost_prod.conf /etc/nginx/nginx.conf.prod
ENV ENVIRONMENT dev

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
