FROM nginx
RUN sed -i 's#\(deb\|security\).debian.org#mirrors.aliyun.com#g' /etc/apt/sources.list \
    && apt-get update -y && apt-get upgrade -y \
    && apt-get install wait-for-it -y --no-install-recommends \
    && apt-get autoremove -y && apt-get clean -y && apt-get autoclean -y
COPY www.conf /etc/nginx/conf.d/default.conf