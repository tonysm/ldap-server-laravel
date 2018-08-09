<?php

namespace App\Console\Commands;

use FreeDSx\Ldap\LdapServer;
use Illuminate\Console\Command;

class LdapServerRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldap:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the LDAP server.';

    /**
     * Execute the console command.
     *
     * @param LdapServer $ldapServer
     * @return mixed
     */
    public function handle(LdapServer $ldapServer)
    {
        $this->info('Starting the LDAP server...');
        $config = config('ldap');
        $this->info(sprintf('Listening at %s:%s', $config['ip'], $config['port']));
        $ldapServer->run();
    }
}
