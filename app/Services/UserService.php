<?php

namespace App\Services;

use App\User;

class UserService
{

    public function createUser($request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'phone' => $request->get('phonenumber'),
            'password' => bcrypt($request->get('password')),
        ]);

        return $user;
    }

    // $user -> Eloquent Model
    // $data -> Request Data for update ($request->all())
    public function updateData($user, $allData)
    {
        // get model attributes
        $attributes = $user->only([
            'name', 'lastname', 'phone', 'cellphone', 'address'
        ]);

        // update data in the model
        foreach ($allData as $key => $data) {
            if (array_key_exists($key, $attributes))
                $user->setAttribute($key, $data);
        }
        $user->save();

        return $user;

    }
}