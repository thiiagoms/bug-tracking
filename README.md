# Bug Tracking

## Clone

```bash
$ git glone https://github.com/thiiagoms/bug-tracking bug-tracking
$ cd bug-tracking
bug-tracking $
```

## Install

```bash
bug-tracking $ docker compose up -d
bug-tracking $ docker compose exec app bash
root@14f4a74ddebb:/var/www# composer install -vvv
```

## Run

```bash
root@14f4a74ddebb:/var/www# php index.php
```
