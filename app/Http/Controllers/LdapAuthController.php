<?php

namespace App\Http\Controllers;

use FreeDSx\Ldap\LdapClient;
use Illuminate\Http\Request;
use FreeDSx\Ldap\Search\Filters;
use FreeDSx\Ldap\Exception\BindException;
use FreeDSx\Ldap\Operation\Request\SearchRequest;

class LdapAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $ldapClient = new LdapClient([
            'servers' => [$request->get('host')],
            'port' => $request->get('port'),
        ]);

        try {
            $ldapClient->bind($request->get('username'), $request->get('password'));

            $filter = Filters::and(
                Filters::equal('email', $request->get('username'))
            );

            $searchRequest = new SearchRequest($filter, 'dc=local');
            $entries = $ldapClient->search($searchRequest->base($request->get('host')));
            $entry = $entries->first();

            return response()->json([
                'success' => true,
                'user' => array_map(function ($entry) {
                    return $entry[0];
                }, $entry->toArray()),
            ]);
        } catch (BindException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
