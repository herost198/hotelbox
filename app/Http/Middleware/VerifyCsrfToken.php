<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected $addHttpCookie = true;
    protected $except = [
        'api/user/login',
        'api/user/changePassword',
        'api/user/changeAvatar',
        'api/cumphong/update',
        'api/service/delete',
        'api/cumphong/create',
        'api/cumphong/delete',
        'api/phong/create',
        'api/phong/update',
        'api/phong/delete',
        'api/background/delete',
        'api/background/upload',
        'api/service/edit',
        'api/popup/delete',
        'api/popup/upload',
        'api/popup/edit',
    ];
}
