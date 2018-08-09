<?php

namespace App\Ldap;

use App\User;
use FreeDSx\Ldap\Entry\Entries;
use Illuminate\Support\Facades\Hash;
use FreeDSx\Ldap\Server\RequestContext;
use FreeDSx\Ldap\Search\Filter\AndFilter;
use FreeDSx\Ldap\Operation\Request\SearchRequest;
use FreeDSx\Ldap\Server\RequestHandler\GenericRequestHandler;

class LdapRequestHandler extends GenericRequestHandler
{
    /**
     * Validates the username/password of a simple bind request
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function bind(string $username, string $password): bool
    {
        $user = User::whereEmail($username)->first();

        if (!$user) {
            return false;
        }

        return Hash::check($password, $user->password);
    }

    /**
     * Override the search request. This must send back an entries object.
     *
     * @param RequestContext $context
     * @param SearchRequest $search
     * @return Entries
     */
    public function search(RequestContext $context, SearchRequest $search): Entries
    {
        $filter = $search->getFilter();

        if ($filter instanceof AndFilter) {
            return $this->buildAndFilter($filter);
        }

        return new Entries();
    }

    private function buildAndFilter(AndFilter $andFilter): Entries
    {
        $query = User::query();

        foreach ($andFilter as $item) {
            $query->where($item->getAttribute(), $item->getValue());
        }

        $users = $query->get();

        $entries = $users->map(function (User $user) {
            return UserEntryResource::make($user);
        });

        return new Entries(
            ...$entries->all()
        );
    }
}
