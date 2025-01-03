<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserGroup;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;

class UserRepository
{
    
    public function getAll() {
        return User::with(['data_user_group.data_group'])->get();
    }

    public function getDropdown($is_premium=0) {
        return User::pluck('name','id');
    }

    public function getPaginate($paginate = 10) {
        return User::with(['data_user_group.data_group'])->paginate(10);
    }

    public function FetchById($id) {
        return User::findOrFail($id);
    }

    public function create($request) {
        $data   = [
            "name"      => $request->get('name'),
            'email'     => $request->get('email'),
            'email_verified_at'     => Carbon::now(),
            'password'  => Hash::make($request->get('password')),
            'remember_token' => Str::random(40)
        ];

        $User   = User::create($data);

        $User->assignRole($request->get('role'));

        UserGroup::create([
            "fk_user" => $User->id,
            "fk_group" => $request->get('fk_group')
        ]);
       
        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function update($id, $request)
    {
        $data   = [
            "name"      => $request->get('name'),
            'email'     => $request->get('email')
        ];

        if( !empty($request->get('password')) ) {
            $data['password'] = $request->get('password');
        }

        $User   = User::find($id);
        $User->update($data);

        $User->assignRole($request->get('role'));

        UserGroup::updateOrCreate(
            [
                "fk_user" => $User->id,
            ],
            [
                "fk_group" => $request->get('fk_group')
            ]
        );

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        User::destroy($id);
        UserGroup::where('fk_user',$id)->delete();
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}