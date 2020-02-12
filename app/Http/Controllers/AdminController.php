<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Session;

use App\User;
use App\Job;
use App\Role;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // The number of users
        $usersNumber = User::count();
        // The number of jobs
        $jobsNumber = Job::count();

        return view('user.admin.index', compact('usersNumber', 'jobsNumber'));
    }


    /**
     * Show all users that are NOT admin nor root
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin')->orWhere('name', 'root');
        })->with('roles')->paginate(10);

        // Get the roles
        $roles = Role::where('name', 'user')->pluck('name', 'id')->all();


        return view('user.admin.users', compact('users', 'roles'));
    }

    /**
     * Get all jobs that doesn't belong to admin nor root
     *
     * @return \Illuminate\Http\Response
     */
    public function jobs()
    {

        // Get jobs
        $jobs = Job::whereHas('user', function ($query) {
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'admin')->orWhere('name', 'root');
            });
        })->paginate(10);


        return view('user.admin.jobs', compact('jobs'));
    }



    /**
     * Delete a job that doesn't belong to admin nor root
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteJob($id)
    {

        try {
            // Find the job or return 404 error
            $job = Job::where('jobs.id', $id)->whereHas('user', function ($query) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('roles.name', 'admin')->orWhere('roles.name', 'root');
                });
            })->delete();

            // Return back with success message
            return back()->with('status', 'Job deleted successfully');
        } catch (Exception $e) {
            return abort(404);
        }
    }


    /**
     * Delete a user that is not admin nor root
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {

        try {
            // Find the user
            $user = User::where('users.id', $id)->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin')->orWhere('name', 'root');
            })->delete();

            // Return back with success message
            return back()->with('status', 'User deleted successfully');
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function search(Request $request)
    {

        $request->validate([
            'search'    => 'required|min:2',
            'type'  => [
                'required', 'regex:/^(user)|(job)$/'
            ]
        ]);

        $searchTerm = $request->search;

        if ($request->type == 'user') {

            // Selelect All users
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin')->orWhere('name', 'root');
            })->where(function ($query) use ($searchTerm) {
                $query->where('first', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('last', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('works_as', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('tags', 'LIKE', '%' . $searchTerm . '%');
            })->with('roles')->paginate(10);



            // Get the roles
            $roles = Role::where('name', 'user')->pluck('name', 'id')->all();


            return view('user.admin.search-users', compact('users', 'roles', 'searchTerm'));
        } else {


            // Selelect All users
            $jobs = Job::whereHas('user', function ($query) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'admin')->orWhere('name', 'root');
                });
            })->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('tags', 'LIKE', '%' . $searchTerm . '%');
            })->paginate(10);


            return view('user.admin.search-jobs', compact('jobs', 'searchTerm'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            // Validate the request
            $request->validate([
                'roles'  => 'array',
            ]);


            // Find the user
            $user = User::where('id', $id)->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin')->orWhere('name', 'root');
            })->with('roles')->firstOrFail();


            // Get avaliable roles
            $roles = Role::where('name', 'user')->get();


            foreach ($roles as $role) {
                if (in_array($role->name, $request->roles ?? [])) {
                    if (!$user->hasRole($role->name)) {
                        $user->roles()->attach($role->id);
                    }
                } else {
                    if ($user->hasRole($role->name)) {
                        $user->roles()->detach($role->id);
                    }
                }
            }


            return back()->with('status', 'Data updated successfully');
        } catch (Exception $e) {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
