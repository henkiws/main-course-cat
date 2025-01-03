<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ModulesRepository;

class ModuleController extends Controller
{
    public function __construct(ModulesRepository $ModulesRepository) {
        $this->ModulesRepository = $ModulesRepository;
    }

    public function index() {
        $data = [
            "list" => $this->ModulesRepository->getPaginate(),
        ];
        return view('modules.index', $data);
    }

    public function create() {
        return view('modules.form');
    }

    public function edit($id) {
        $module   = $this->ModulesRepository->FetchById($id);

        $data   = [
            "module"  => $module
        ];
        return view('modules.form', $data);
    }

    public function store(Request $request) {
        $result = $this->ModulesRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('modules.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $result = $this->ModulesRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('modules.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->ModulesRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('modules.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
