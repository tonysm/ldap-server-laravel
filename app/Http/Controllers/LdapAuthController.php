<?php

namespace App\Http\Controllers;

use FreeDSx\Ldap\LdapClient;
use Illuminate\Http\Request;
use FreeDSx\Ldap\Exception\BindException;

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

            return response()->json([
                'success' => true,
            ]);
        } catch (BindException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
