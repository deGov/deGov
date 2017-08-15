[![Stories in Ready](https://badge.waffle.io/deGov/deGov.png?label=ready&title=Ready)](https://waffle.io/deGov/deGov)

# deGov - Drupal 8 for Government


## Notes

deGov is the first Drupal 8 distribution focussing on the needs of (German) governmental organisations. It uses Acquia Lightning as a basis and extends this it with valueable functions to meet the use cases for different scenarios:

- Websites for governmental organisations from all levels (federal, regional, local) to publish information
- Service-oriented E-Government portals to close the gap between citizens and your administration
- Citizen Engagement portals to discuss and decide online
- Open311 portals for civic issue tracking
- Open data portals to publish and create communities around data
- Intranet/Extranet for government employees

Sounds interesting? Then go for it and install the first Drupal 8 distribution for government!

## Prerequisites

- Webserver (Apache2, Nginx, Hiawatha, Microsoft IIS)
- PHP >= 5.5.9+ | Memory >= 64MB
- RDMS (MySQL => 5.5.3, MariaDB => 5.5.20, Percona Server => 5.5.8)
- Mailserver (Postfix, exim, etc.)
- [Composer](https://getcomposer.org/download/ "https://getcomposer.org/download/")

## Installing deGov

**BEFORE YOU INSTALL:** please read the [prerequisites](#prerequisites)

First your need to **clone** the deGov repository.
```
git clone https://github.com/deGov/deGov.git
```

Change your **working directory** into deGov
```
$ cd deGov
```

After a successfully clone you need to run **Composer** to install all deGov dependencies.
```bash
$ composer install
```

Visit the **deGov-Domain** to start the installation process.
```
http://[YOUR_SITE]/
```
Follow the Installer instructions to successfully finish the installation process.

## Usage
Visit the following page to log into your deGov Installation with your previously created User to administer your deGov Installation.
```
http://[YOUR_SITE]/user/login/
``` 

## License
[**GNU GENERAL PUBLIC LICENSE v2**](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html "visit GPLv2 website")
