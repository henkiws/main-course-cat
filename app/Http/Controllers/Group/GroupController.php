<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

class GroupController extends Controller
{
    public function __construct(GroupRepository $GroupRepository,
                            UserRepository $UserRepository) {
        $this->GroupRepository = $GroupRepository;
        $this->UserRepository = $UserRepository;

        $this->middleware(['role:admin']);
    }

    public function index(Request $request) {
        $pagination = $request->get('show')??10;
        $search = [];
        if( !empty($request->get('q')) ) {
            $search['name'] = $request->get('q');
        }

        $data = [
            "list" => $this->GroupRepository->getPaginate($pagination, $search),
        ];
        return view('group.index', $data);
    }

    public function create() {
        $data = [
            "opt_user" => $this->UserRepository->getDropdown()
        ];
        return view('group.form', $data);
    }

    public function edit($id) {
        $group   = $this->GroupRepository->FetchById($id);

        $data   = [
            "opt_user" => $this->UserRepository->getDropdown(),
            "groups" => $this->GroupRepository->getByGroup($id),
            "group" => $group
        ];
        return view('group.form', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'fk_user' => 'required',
        ]);

        $result = $this->GroupRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('groups.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withErrors($result['msg']);
        }
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'fk_user' => 'required',
        ]);

        $result = $this->GroupRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('groups.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withErrors($result['msg']);
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
