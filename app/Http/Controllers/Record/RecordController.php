<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ModuleRecordsRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

class RecordController extends Controller
{
    public function __construct(ModuleRecordsRepository $ModuleRecordsRepository,
                                GroupRepository $GroupRepository,
                                UserRepository $UserRepository) {
        $this->ModuleRecordsRepository = $ModuleRecordsRepository;
        $this->GroupRepository = $GroupRepository;
        $this->UserRepository = $UserRepository;

        $this->middleware(['role:admin'], ['except' => ['index','show']]);
    }

    public function index() {
        $user_group = $this->UserRepository->getUserGroup();
        $data = [
            "list" => $this->ModuleRecordsRepository->getPaginate(10,$user_group),
        ];
        return view('records.index', $data);
    }

    public function create() {
        $data   = [
            "opt_group" => $this->GroupRepository->getDropdown(),
        ];

        return view('records.form', $data);
    }

    public function show($id) {
        $data   = [
            "record" => $this->ModuleRecordsRepository->FetchById($id)
        ];

        return view('records.show', $data);
    }

    public function edit($id) {
        $record   = $this->ModuleRecordsRepository->FetchById($id);
        $groups   = $this->ModuleRecordsRepository->getByRecords($id);

        $data   = [
            "record"    => $record,
            "groups"    => $groups,
            "opt_group" => $this->GroupRepository->getDropdown(),
        ];
        return view('records.form', $data);
    }

    public function store(Request $request) {
        $result = $this->ModuleRecordsRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('records.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $result = $this->ModuleRecordsRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('records.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->ModuleRecordsRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('records.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
