FROM php:8.1-cli

COPY . /usr/src/app
WORKDIR /usr/src/app

ENTRYPOINT ["make"]
CMD ["demo"]
