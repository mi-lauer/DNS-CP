DNS-Webinterface
==================

**DNS webinterface** is powered by [Stricted](https://github.com/Stricted) and [Patschi](https://github.com/patschi) for easy managing your dns server with mysql and PostgreSQL databases. In the feature we've also planned bind9 support with DNSSEC. We're testing our work just on linux (Debian 6/7) machines, so we don't know if it works without problems on Windows machines. Feel free to give us feedback.

### Requirements
---
You may need for a working webinterface:

 * Linux machine (Debian 6+ recommended; windows may work too, but not recommended)
 * Linux knowledge
 * At least php 5 and enabled shell_exec() for more functionality
 * MySQL/PostgreSQL-database
 * working DNS server (only [myDNS](http://mydns.bboy.net) supported so far)
 * some time and basic knowledge about DNS 

### Installation
---
The installation isn't so easy than it will be in the future, when we've have enough time to build a easy and nice installation system. For now, you'll need to import the database structure manually and set up the correct data in the config file. If you're a little bit experienced, it shouldn't be a big problem. Feel free to open a issue, when you need help with the installation process.

 * Clone the git repository: `git clone https://github.com/Stricted/DNS-Webinterface.git`
 * Change the `config.sample.php` file to your needs and import the `db.<DBsystem>.sql` file in your database.
 * Open the page and use the default user and password to login: `admin`

### Screenshots
---
![Screenshot 1](https://raw.github.com/Stricted/DNS-Webinterface/master/github/screenshot1.png "Screenshot 1")

### License
---
This project is licensed under [GNU GENERAL PUBLIC LICENSE](https://github.com/Stricted/DNS-Webinterface/blob/master/COPYING).

### Project page
---
Our project page is currently hosted on github and is available on [stricted.github.io/DNS-Webinterface](http://stricted.github.io/DNS-Webinterface)

### Live Demo
---
Not available yet.

### ToDo
---
 * general improvements
 * bind9 support (and DNSSEC)
 * API (with keys & right controls?)
 * Cronjob for scheduled work (ex: creating zones for bind9)
 * Log-functionality for all users
 * importing general DNS entries from domains
 * possibility to create templates
 * backup current zones and restore them, if the user has permissions for this
 * settings page to customize webinterface: Force HTTPS, white- and blacklist for IPs, domains, ... and more
 * easy installation with step by step
 * error handling with mail support and logging
 * monitoring dns server and execute events on failure (email, sms api, pushover, ...)
 * manage own permission groups for easier managing users
 * version-checker and automated updater (with git?)
 * contact page for contacting the administrator of the webinterface or domain
