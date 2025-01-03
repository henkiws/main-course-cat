<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ModuleFilesRepository;
use App\Repositories\GroupRepository;

class FileController extends Controller
{
    public function __construct(ModuleFilesRepository $ModuleFilesRepository,
                                GroupRepository $GroupRepository) {
        $this->ModuleFilesRepository = $ModuleFilesRepository;
        $this->GroupRepository = $GroupRepository;
    }

    public function index() {
        $data = [
            "list" => $this->ModuleFilesRepository->getPaginate(),
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
        return response()->file($file->filepath);
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
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        ];
        if($request->file('file')) {
            $validate['file']='required|mimes:jpeg,png,jpg,gif,svg|max:2048';
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
