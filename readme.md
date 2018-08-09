# Example App of an LDAP server using Laravel

With this example application, you are able to create an LDAP server, and use it to authenticate using the users stored in your Laravel application.

## Setup

* Clone it
* Run `cp .env.example .env`
* Create the database and configure your `.env` file to use it
* Run `php artisan key:generate` and `php artisan migrate`
* Install the assets and compile them `yarn && yarn dev`
* Start your LDAP server using `php artisan ldap:serve` (this will give you the host and port to connect to)
* Start your Laravel serve `php artisan serve`
* Register on it, and use the form inside the application to  test what comes back from the LDAP, try creating other users and authenticating.

## Relevant links

* You can tweak the LDAP server configuration at [config/ldap.php](./config/ldap.php)
* All LDAP connections are handled by [app/Ldap/LdapRequestHandler.php](app/Ldap/LdapRequestHandler.php)
* We authenticate using an LDAP client here [app/Http/Controllers/LdapAuthController.php](app/Http/Controllers/LdapAuthController.php)
