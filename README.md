# BugReport Tracking

## Setup

1. Clone this project:

```bash
$ git glone https://github.com/thiiagoms/bug-tracking bug-tracking
$ cd bug-tracking
bug-tracking $
```

2. Setup containers:

```bash
bug-tracking $ docker compose up -d
bug-tracking $ docker compose exec app bash
root@14f4a74ddebb:/var/www# composer install -vvv
```

3. Run tests

```bash
root@14f4a74ddebb:/var/www# composer tests
```
