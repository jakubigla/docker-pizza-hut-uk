[![Build Status](https://travis-ci.org/jakubigla/docker-pizza-hut-uk.svg?branch=master)](https://travis-ci.org/jakubigla/docker-pizza-hut-uk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Dependency Status](https://www.versioneye.com/user/projects/58fcd57fc2ef4238240d5f71/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58fcd57fc2ef4238240d5f71)

# Docker Pizza Hut

Automate orders from Pizza Hut UK using Selenium, Mink and Docker.

## Dependencies
- docker
- docker-compose
- make (optional)

## Usage

Copy `config.sample.yml` to `config.yml`. Edit the config file based on example order. If you leave `securityCode` empty, the script will ask for it when it starts executing.
 
Run:
```bash
    make
```

or (if all already built)
```bash
docker-compose run --rm order
```
