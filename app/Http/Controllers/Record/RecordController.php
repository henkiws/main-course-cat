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

    public function index(Request $request) {
        $pagination = $request->get('show')??10;
        $search = [];
        if( !empty($request->get('q')) ) {
            $search['title'] = $request->get('q');
        }

        $user_group = $this->UserRepository->getUserGroup(10);
        $data = [
            "list" => $this->ModuleRecordsRepository->getPaginate($pagination,$search,$user_group),
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'filepath' => 'required|mimes:jpeg,png,jpg,gif,svg,zip,doc,docx,xls,xlsx,ppt,pptx,pdf,chm|max:2048',
            'date_class' => 'required',
            'tutor' => 'required',
            'position' => 'required',
        ]);
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
        $validate = [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'date_class' => 'required',
            'tutor' => 'required',
            'position' => 'required',
        ];
        if($request->hasFile('filepath')) {
            $validate['filepath']='required|mimes:jpeg,png,jpg,gif,svg,zip,doc,docx,xls,xlsx,ppt,pptx,pdf,chm|max:2048';
        }
        $this->validate($request, $validate);

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
