<?php

namespace App\Ldap;

use FreeDSx\Ldap\Search\Filter\AndFilter;
use Illuminate\Database\Eloquent\Builder;

class UserLdapRepository
{
    /**
     * @param AndFilter $andFilter
     * @param Builder $builder
     */
    public function andQuery(AndFilter $andFilter, Builder $builder)
    {

    }
}
