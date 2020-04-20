<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlideRequest;
use App\Repositories\Repository;
use App\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlideController extends Controller
{
    protected $slide;

    public function __construct(Slide $slide)
    {
        parent::__construct();
        $this->slide = new Repository($slide);
        $this->middleware('permission:slide-list');
        $this->middleware('permission:slide-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:slide-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:slide-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->slide->all($items)->total();
        $slides = $this->slide->all($items);
        return view('admin.slide.list', compact('slides', 'count', 'items'));
    }

    public function create()
    {
        return view('admin.slide.create');
    }

    public function store(SlideRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $image = time() . $file->getClientOriginalName();
            $file->move('images', $image);
            $data['image'] = $image;
        }
        $slides = $this->slide->create($data);
        return response()->json($slides);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $slide = $this->slide->find($id);
        return view('admin.slide.update', compact('slide'));

    }

    public function update($id, SlideRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $image = time() . $file->getClientOriginalName();
            $file->move('images', $image);
            $data['image'] = $image;
        }
        $slide = $this->slide->update($id, $data);
        return response()->json($slide);
}

    public function destroy($id)
    {
        $this->slide->delete($id);
        return redirect()->route('slide.index')->with('message', 'Delete successfully');
    }

    public function showImage($id)
    {
        $slide = $this->slide->find($id);
        return view('admin.slide.show_image', compact('slide'));
    }
}
