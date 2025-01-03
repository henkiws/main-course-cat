<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    public function __construct(RoleRepository $RoleRepository) {
        $this->RoleRepository = $RoleRepository;
    }

    public function index() {
        $data = [
            "list" => $this->RoleRepository->getPaginate(),
        ];
        return view('roles.index', $data);
    }

    public function create() {
        return view('roles.form');
    }

    public function edit($id) {
        $music   = $this->RoleRepository->FetchById($id);

        $data   = [
            "id"    => $id,
            "name"  => $music->name,
        ];
        return view('roles.form', $data);
    }

    public function store(Request $request) {
        $result = $this->RoleRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('roles.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $result = $this->RoleRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('roles.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->RoleRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('roles.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
