<?php

namespace App\Http\Controllers;

use App\Deliverer;
use App\Http\Requests\DelivererRequest;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DelivererController extends Controller
{
    protected $deliverer;

    public function __construct(Deliverer $deliverer)
    {
        parent::__construct();
        $this->deliverer = new Repository($deliverer);
        $this->middleware('permission:deliverer-list');
        $this->middleware('permission:deliverer-create', ['only' => ['create','store']]);
        $this->middleware('permission:deliverer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:deliverer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->deliverer->all($items)->total();
        $deliverers = $this->deliverer->all($items);
        return view('admin.deliverer.list', compact('deliverers','items','count'));
    }

    public function create()
    {
        return view('admin.deliverer.create');
    }

    public function store(DelivererRequest $request)
    {
        $deliverers = $this->deliverer->create($request->all());
        return Response::json($deliverers);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $deliverer = $this->deliverer->find($id);
        return view('admin.deliverer.update', compact('deliverer'));

    }

    public function update($id, DelivererRequest $request)
    {
        $deliverers = $this->deliverer->update($id, $request->all());
        return Response::json($deliverers);
    }

    public function destroy($deliver_id)
    {
        $this->deliverer->delete($deliver_id);
        return redirect()->route('deliverer.index')->with('message', 'Delete successfully');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $fieldName = 'deliverer_name';
            $output = "";
            $deliverers = $this->deliverer->search($fieldName, $request->all()['key'])->orWhere('deliverer_phone','like','%' .$request->all()['key']. '%')->get();
            foreach ($deliverers as $key => $deliverer) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-deliverer btn btn-success" data-id= "' . $deliverer->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-deliverer" class="btn btn-danger delete-deliverer" data-id="' . $deliverer->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $deliverer->id . '</td>' .
                    '<td>' . $deliverer->deliverer_name . '</td>' .
                    '<td>' . $deliverer->deliverer_phone . '</td>' .
                    '<td>' . $deliverer->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $deliverer->updated_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }
}
