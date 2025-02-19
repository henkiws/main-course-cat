<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ModuleFilesRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

class FileController extends Controller
{
    public function __construct(ModuleFilesRepository $ModuleFilesRepository,
                                GroupRepository $GroupRepository,
                                UserRepository $UserRepository) {
        $this->ModuleFilesRepository = $ModuleFilesRepository;
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

        $user_group = $this->UserRepository->getUserGroup();
        $data = [
            "list" => $this->ModuleFilesRepository->getPaginate($pagination, $search, $user_group),
        ];
        return view('files.index', $data);
    }

    public function create() {
        $data   = [
            "opt_group" => $this->GroupRepository->getDropdown(),
        ];
        return view('files.form', $data);
    }

    public function show($id) {
        $file   = $this->ModuleFilesRepository->FetchById($id);
        return response()->file(base_path('public').'/'.$file->filepath);
    }

    public function edit($id) {
        $file   = $this->ModuleFilesRepository->FetchById($id);
        $groups   = $this->ModuleFilesRepository->getByModuleFile($id);

        $data   = [
            "file"    => $file,
            "groups" => $groups,
            "opt_group" => $this->GroupRepository->getDropdown(),
        ];
        return view('files.form', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'date_class' => 'required',
            'tutor' => 'required',
            'position' => 'required',
            'fk_group' => 'required',
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,zip,doc,docx,xls,xlsx,ppt,pptx,pdf,chm|max:2048',
        ]);
        $result = $this->ModuleFilesRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('files.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $validate = [
            'title' => 'required',
            'description' => 'required',
            'date_class' => 'required',
            'tutor' => 'required',
            'position' => 'required',
            'fk_group' => 'required',
        ];
        if($request->hasFile('file')) {
            $validate['file']='required|mimes:jpeg,png,jpg,gif,svg,zip,doc,docx,xls,xlsx,ppt,pptx,pdf,chm|max:2048';
        }
        $this->validate($request, $validate);
        $result = $this->ModuleFilesRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('files.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->ModuleFilesRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('files.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
