<?php

/**
 * See https://github.com/FreeDSx/LDAP/blob/master/docs/Server/Configuration.md for more options.
 */
return [
    'ip' => '0.0.0.0',
    'port' => 33389,
    'request_handler' => \App\Ldap\LdapRequestHandler::class,
];
