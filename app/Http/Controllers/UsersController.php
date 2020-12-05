<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        // dd($user);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        $data['resource'] = User::findOrFail($id);

        return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resource = User::findOrFail($id);
        $resource->update([
            'email' => $request['email'],
            'name' => $request['name']
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = User::findOrFail($id);
        $resource->delete();

        return redirect()->back();
    }

    /**
     * AJAX | POST
     * route: users.list
     * url: users-list
     */
    public function list(Request $request)
    {
        $data = User::where('name', 'like', "%{$request['keyword']}%")->get();

        return response()->json($data);
    }

    /**
     * AJAX | POST
     * route: users.datatable
     * url: users-datatable
     */
    public function datatable(Request $request)
    {
        $limit = $request['length'];
        $offset = $request['start'];

        $datatable_query = "
            SELECT COUNT(*) as count FROM users
        ";
        $count_query = DB::select(DB::raw($datatable_query))[0];

        $data_query = "
            SELECT id, name, email FROM users
            ORDER BY name
            LIMIT {$offset}, {$limit}
        ";
        $data = DB::select(DB::raw($data_query));

        foreach ($data as $index => $resource) {
            $data[$index]->actions = '<a href="'.route('users.edit', $resource->id).'" class="btn btn-success px-3">Edit</button>';
        }

        return json_encode([
            'draw' => $request['draw'],
            'recordsTotal' => $count_query->count,
            'recordsFiltered' => $count_query->count,
            'data' => $data,
        ]);
    }
}
