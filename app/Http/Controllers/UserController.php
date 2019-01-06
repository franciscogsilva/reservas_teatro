<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('front.users.edit')
            ->with('user', Auth::user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {           
        $rules = [
            'name'              =>  'required|string|max:255',
            'email'             =>  'required|string|email|max:255'
        ];

        $this->validate($request, $rules);

        $user =  Auth::user();
        if($user->email != $request->email){            
            $rules = [
                'email'             =>  'required|string|email|max:255|unique:users'
            ];

            $this->validate($request, $rules);
        }

        if ($request->has('password')) {            
            $rules = [
                'password'      =>  'required|string|min:6|confirmed'
            ];

            $this->validate($request, $rules);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->has('password')){            
            $user->password = bcrypt($request->password);
        }
        $user->save();
        
        return redirect()->route('users.edit')
            ->with('session_msg', '¡Usuario actualizado correctamente!');
    }
}
