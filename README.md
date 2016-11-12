## deGov

Be part of deGov and help us making deGov great! 

deGov is the first German Drupal 8 distribution - expecially programmed for the German Government.

This distribution is developed according to the needs of government portals, ministries, authorities and municipalities.

As a content management framework, it supports providing digital information systems on the Internet (citizens will be able to receive several information such as activities, the main focus of the governmantal insitution, news and many other helpfull information)

The Government is able to: 

- inform about their work, 
- initiatives
- strategies
- publish press releases and set up notifications for press representatives etc.

Over and above that they can make use of editorial workflows for publishing articles and use existing and coordinated content elements to put teir content in a different and special way. All that can be reached by usiny an existing, professional basic layout for the governmentral websites. 

Of course this can be customized according to their CI and supports mobile devices such as smartphones and tablets.
Last but not least they can choose from a modular kit system the functions according to their need in order to get their unique portal.

Sounds interesting? Then go for it and install the first Drupal 8 distribution for the German Goverment - of course Open Source! 

## Note

xxx

## Prerequisites

- Webserver (Apache2, Nginx, Hiawatha, Microsoft IIS)
- PHP >= 5.5.9+ | Memory >= 64MB
- RDMS (MySQL => 5.5.3, MariaDB => 5.5.20, Percona Server => 5.5.8)
- Mailserver (Postfix, exim, etc.)
- [Composer](https://getcomposer.org/download/ "https://getcomposer.org/download/")

## Table of Contents

* [Installing deGov](#installing-degov)
* [Usage](#usage)
* [License](#license)

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
[**GPLv2**](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html "visit GPLv2 website")
