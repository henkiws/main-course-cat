<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ChapterVideosRepository;
use App\Repositories\ChaptersRepository;

class ChapterVideoController extends Controller
{
    public function __construct(ChapterVideosRepository $ChapterVideosRepository,
                                ChaptersRepository $ChaptersRepository) {
        $this->ChapterVideosRepository = $ChapterVideosRepository;
        $this->ChaptersRepository = $ChaptersRepository;
    }

    public function index(Request $request) {
        $data = [
            "list" => $this->ChapterVideosRepository->getPaginateByChapter($request->get('fk_chapter')),
            "chapter" => $this->ChaptersRepository->FetchById($request->get('fk_chapter')),
            "fk_chapter" => $request->get('fk_chapter')
        ];
        return view('video.index', $data);
    }

    public function create(Request $request) {
        $data = [
            "chapter" => $this->ChaptersRepository->FetchById($request->get('fk_chapter')),
            "fk_chapter" => $request->get('fk_chapter')
        ];
        return view('video.form', $data);
    }

    public function edit(Request $request, $id) {
        $video   = $this->ChapterVideosRepository->FetchById($id);

        $data   = [
            "chapter" => $this->ChaptersRepository->FetchById($request->get('fk_chapter')),
            "fk_chapter" => $request->get('fk_chapter'),
            "video" => $video
        ];
        return view('video.form', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'date_class' => 'required',
            'tutor' => 'required',
            'position' => 'required',
        ]);

        $result = $this->ChapterVideosRepository->create($request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('videos.index',['fk_chapter='.$request->get('fk_chapter')]);
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'date_class' => 'required',
            'tutor' => 'required',
            'position' => 'required',
        ]);

        $result = $this->ChapterVideosRepository->update($id, $request);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('videos.index',['fk_chapter='.$request->get('fk_chapter')]);
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id) {
        $result = $this->ChapterVideosRepository->delete($id);
        if( $result['status'] == "success" ) {
            session()->flash('success', $result['msg']);
            return redirect()->route('videos.index',['fk_chapter='.$request->get('fk_chapter')]);
        }else{
            session()->flash('error', $result['msg']);
            return redirect()->back()->withInput();
        }
    }
}
