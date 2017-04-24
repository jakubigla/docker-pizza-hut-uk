[![Build Status](https://travis-ci.org/jakubigla/docker-pizza-hut-uk.svg?branch=master)](https://travis-ci.org/jakubigla/docker-pizza-hut-uk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Dependency Status](https://www.versioneye.com/user/projects/58fcd57fc2ef4238240d5f71/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58fcd57fc2ef4238240d5f71)

# Docker Pizza Hut

Automate orders from Pizza Hut UK using Selenium, Mink and Docker.

## Dependencies
- docker
- docker-compose
- make (optional)

## Configuration

Copy `config.sample.yml` to `config.yml`. Edit the config file based on example order. If you leave `securityCode` empty, the script will ask for it when it starts executing.


```yaml
delivery:
  postcode: "NW2 6TU"
  name: "Ashford Place"
  phone: "020 8208 8590"
  email: "info@ashfordplace.org.uk"
  addressLine1: "60 Ashford Rd"
  addressLine2: "London"
  driverInstructions: ""

payment:
  cardNumber: "1111222233334444"
  cardholderName: "John Doe"
  expiryMonth: "12"
  expiryYear: "2022"
  securityCode: ""

orders:
  - Pizza:
      type: veg-sizzler
      size: large
      crust: cheesy-garlic
  - PizzaOfTheDay:
      size: large
      crust: italian
  - PizzaOfTheDay:
      size: large
      crust: italian
  - Drink:
      type: pepsi-max-1500ml
  - Drink:
      type: pepsi-regular-1500ml
  - Side:
      type: potato-wedges
      dip: bbq

#
# Pizza:
#   type: margherita, pepperoni-feast, texan-bbq, meat-feast, meaty-one, hawaiian, chicken-supreme, bbq-meatfeast,
#         veg-supreme, super-supreme, chicken-sizzler, farmhouse, veg-sizzler, supreme, beef-sizzler, tuna-melt
#   size: large, medium, small
#   crust: classic, pan, italian, stuffed-crust, cheesy-bites, cheesy-garlic
#

#
# PizzaOfTheDay:
#   size: *
#   crust: *
#

#
# Drink
#   type: pepsi-max-1500ml, pepsi-max-500ml, pepsi-diet-1500ml, 7up-1500ml,
#         pepsi-regular-1500ml, pepsi-regular-500ml, tango-1500ml, water-500ml
#

#
# Side
#   type: cheese-triangles, bbq-wings, chicken-strips-spicy, nachos, macaroni-cheese-bacon, potato-wedges,
#         garlic-bread, cheesy-garlic-bread, loaded-wedges-cheese, loaded-wedges-cheese-jalapenos,
#         loaded-wedges-cheese-bacon, macaroni-cheese, cheesy-garlic-bread-bacon, coleslaw, side-salad
#   dip:  bbq, tomato, chilli, garlic, sour-cream
#
```

## Usage
 
Run:
```bash
make
```

or (if all already built)
```bash
docker-compose run --rm order
```

## Todo
- Add desserts, dips and other deals
- Failures handling
- Replace `sleep` with Mink's `waitFor`

