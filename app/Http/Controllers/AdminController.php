<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    protected $admin;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->admin = Auth::user();
            view()->share([ 'admin' => $this->admin ]);
            return $next($request);
        });
        $this->middleware('permission:show-admin', ['only' => ['index','show']]);
        $this->middleware('permission:create-admin', ['only' => ['create','store']]);
        $this->middleware('permission:edit-admin', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy-admin', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
