<?php

namespace App\Ldap;

use App\User;
use FreeDSx\Ldap\Entry\Entry;

class UserEntryResource
{
    /**
     * @param User $user
     * @return Entry
     */
    public static function make(User $user)
    {
        $commonName = collect(explode(' ', $user->name))->first();
        $organizationalUnit = 'B. OS Unit 1';
        $domainComponent = 'local';

        return Entry::create("cn={$commonName},dc={$organizationalUnit},dc={$domainComponent}", [
            'cn' => $commonName,
            'sn' => collect(explode(' ', $user->name))->last(),
            'givenName' => $commonName,
        ]);
    }
}
