<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\GroupRepository;

class UserController extends Controller
{
    public function __construct(UserRepository $UserRepository,
                                RoleRepository $RoleRepository,
                                GroupRepository $GroupRepository) {
        $this->UserRepository = $UserRepository;
        $this->RoleRepository = $RoleRepository;
        $this->GroupRepository = $GroupRepository;

        $this->middleware(['role:admin']);
    }

    public function index(Request $request) {
        $pagination = $request->get('show')??10;
        $search = [];
        if( !empty($request->get('q')) ) {
            $search['name'] = $request->get('q');
        }
        $data = [
            "list" => $this->UserRepository->getPaginate($pagination,$search),
        ];
        return view('users.index', $data);
    }

    public function create() {
        $data = [
            "opt_role" => $this->RoleRepository->getDropdown(),
            "opt_group" => $this->GroupRepository->getDropdown(),
        ];
        return view('users.form', $data);
    }

    public function edit($id) {
        $user   = $this->UserRepository->FetchById($id);

        $data   = [
            "user"  => $user,
            "opt_role" => $this->RoleRepository->getDropdown(),
            "opt_group" => $this->GroupRepository->getDropdown(),
        ];
        return view('users.form', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|min:6',
            'fk_group' => 'required',
            'role' => 'required',
        ]);

        $result = $this->UserRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('users.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
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
            return redirect()->route('users.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->UserRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('users.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
