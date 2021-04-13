<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
      $is_admin = Auth::user()->is_admin ? 'admin' : 'user';

      return $request->wantsJson()
              ? response()->json(['two_factor' => false])
              : redirect()->intended(route($is_admin . '.dashboard'));
    }

}
