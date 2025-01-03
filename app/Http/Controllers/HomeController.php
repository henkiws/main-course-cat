<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ModulesRepository;
use App\Repositories\ModuleRecordsRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

class HomeController extends Controller
{
   
    public function __construct(ModulesRepository $ModulesRepository,
                                ModuleRecordsRepository $ModuleRecordsRepository,
                                UserRepository $UserRepository,
                                GroupRepository $GroupRepository) {
        $this->ModulesRepository = $ModulesRepository;
        $this->ModuleRecordsRepository = $ModuleRecordsRepository;
        $this->UserRepository = $UserRepository;
        $this->GroupRepository = $GroupRepository;
    }

    public function index()
    {
        $user_group = $this->UserRepository->getUserGroup();
        $data = [
            "count_module" => $this->ModulesRepository->getCount(),
            "count_record" => $this->ModuleRecordsRepository->getCount($user_group),
            "count_user" => $this->UserRepository->getCount(),
            "count_group" => $this->GroupRepository->getCount(),
        ];
        return view('home.index',$data);
    }
}
