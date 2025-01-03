<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GroupRepository;

class GroupController extends Controller
{
    public function __construct(GroupRepository $GroupRepository) {
        $this->GroupRepository = $GroupRepository;
    }

    public function index() {
        $data = [
            "list" => $this->GroupRepository->getPaginate(),
        ];
        return view('group.index', $data);
    }

    public function create() {
        $data = [
            
        ];
        return view('group.form', $data);
    }

    public function edit($id) {
        $user   = $this->GroupRepository->FetchById($id);

        $data   = [
            
        ];
        return view('group.form', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        $result = $this->GroupRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('groups.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        $result = $this->GroupRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('groups.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->GroupRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('groups.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
