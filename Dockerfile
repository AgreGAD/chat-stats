FROM composer as builder

WORKDIR /usr/src/app
COPY . /usr/src/app
RUN composer install


FROM php:8.1-cli

WORKDIR /usr/src/app
COPY --from=builder /usr/src/app /usr/src/app

ENTRYPOINT ["make"]
CMD ["demo"]
