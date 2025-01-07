<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class ProfileController extends Controller
{

    public function __construct(UserRepository $UserRepository) {
        $this->UserRepository = $UserRepository;
    }

    public function index() {
        $data = [
            "user" => $this->UserRepository->FetchById(auth()->user()->id)
        ];
        return view('users.profile', $data);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users,email,'.$id,
            'fk_group' => 'required',
            'role' => 'required',
        ]);

        $result = $this->UserRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('profile.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
