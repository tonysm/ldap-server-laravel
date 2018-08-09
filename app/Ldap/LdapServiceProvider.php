<?php

namespace App\Ldap;

use FreeDSx\Ldap\LdapServer;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LdapServer::class, function () {
            $config = config('ldap');

            return new LdapServer($config);
        });
    }
}
