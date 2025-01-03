<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ChaptersRepository;
use App\Repositories\ModulesRepository;
use App\Repositories\ChapterVideosRepository;

class ChapterController extends Controller
{
    public function __construct(ChaptersRepository $ChaptersRepository,
                                ModulesRepository $ModulesRepository,
                                ChapterVideosRepository $ChapterVideosRepository) {
        $this->ChaptersRepository = $ChaptersRepository;
        $this->ModulesRepository = $ModulesRepository;
        $this->ChapterVideosRepository = $ChapterVideosRepository;
    }

    public function index(Request $request) {
        $data = [
            "list" => $this->ChaptersRepository->getPaginate(),
        ];
        return view('chapters.index', $data);
    }

    public function show($fk_module) {
        $data = [
            "module" => $this->ModulesRepository->FetchById($fk_module),
            "list" => $this->ChaptersRepository->getPaginateByModule($fk_module),
        ];
        return view('chapters.show', $data);
    }

    public function details($id) {
        $data = [
            "chapter" => $this->ChaptersRepository->FetchById($id),
            "chapter_videos" => $this->ChapterVideosRepository->getPaginateByChapter($id,1)
        ];
        return view('chapters.details', $data);
    }

    public function create(Request $request) {
        $data = [
            "module" => $this->ModulesRepository->FetchById($request->get('module')),
            "fk_module" => $request->get('module')
        ];
        return view('chapters.form', $data);
    }

    public function edit($id) {
        $chapter   = $this->ChaptersRepository->FetchById($id);

        $data   = [
            "chapter"  => $chapter
        ];
        return view('chapters.form', $data);
    }

    public function store(Request $request) {
        $result = $this->ChaptersRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('chapters.show',[$request->get('fk_module')]);
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $result = $this->ChaptersRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('chapters.show',[$request->get('fk_module')]);
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->ChaptersRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('chapters.show',[$request->get('fk_module')]);
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
