<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Repositories\Repository;
use App\Status;
use Illuminate\Support\Facades\Response;

class StatusController extends Controller
{

    protected $status;

    public function __construct(Status $status)
    {
        parent::__construct();
        $this->status = new Repository($status);
        $this->middleware('permission:status-list');
        $this->middleware('permission:status-create', ['only' => ['create','store']]);
        $this->middleware('permission:status-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:status-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->status->all($items)->total();
        $statuses = $this->status->all($items);
        return view('admin.status.list', compact('statuses','count','items'));
    }

    public function create()
    {
        return view('admin.status.create');
    }

    public function store(StatusRequest $request)
    {
        $statuses = $this->status->create($request->all());
        return Response::json($statuses);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $status = $this->status->find($id);
        return view('admin.status.update', compact('status'));

    }

    public function update($id, StatusRequest $request)
    {
        $statuses = $this->status->update($id, $request->all());
        return Response::json($statuses);
    }

    public function destroy($id)
    {
        $this->status->delete($id);
        return redirect()->route('status.index')->with('message', 'Delete successfully');
    }
}
