<?php

namespace App\Http\Controllers\Cert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CertificateRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\CAT\CATTestRepository;

class CertificateController extends Controller
{
    public function __construct(CertificateRepository $CertificateRepository,
                                GroupRepository $GroupRepository,
                                CATTestRepository $CATTestRepository,
                                UserRepository $UserRepository) {
        $this->CertificateRepository = $CertificateRepository;
        $this->GroupRepository = $GroupRepository;
        $this->CATTestRepository = $CATTestRepository;
        $this->UserRepository = $UserRepository;

        $this->middleware(['role:admin'], ['except' => ['index','show']]);
    }

    public function index() {
        $user_group = $this->UserRepository->getUserGroup();
        $data = [
            "list" => $this->CertificateRepository->getPaginate(10,$user_group),
        ];
        return view('cert.index', $data);
    }

    public function create() {
        $data   = [
            "opt_cbt_test" => $this->CATTestRepository->getDropdown(),
        ];

        return view('cert.form', $data);
    }

    public function show($id) {
        $data   = [
            "record" => $this->CertificateRepository->FetchById($id)
        ];

        return view('cert.show', $data);
    }

    public function edit($id) {
        $cert   = $this->CertificateRepository->FetchById($id);

        $data   = [
            "cert" => $cert,
            "opt_cbt_test" => $this->CATTestRepository->getDropdown(),
        ];
        return view('cert.form', $data);
    }

    public function store(Request $request) {
        $result = $this->CertificateRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('cert.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $result = $this->CertificateRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('cert.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->CertificateRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('cert.index');
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
