<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Storage;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged 
        if(Auth::check()){
            return $this->loggedIndex();
        } else {
            return view('home');
        }
    }
    
    /**
     * Display the home page for logged in users.
     *
     * @return \Illuminate\Http\Response
     */
    public function loggedIndex(){
        // User must be logged in to reach here
        
        // Get logged in user
        $user = Auth::user();

        $tags = $user->tags;
        $query = Job::query();


        foreach($tags as $tag){
                $query->orWhere('title', 'LIKE', '%' . $tag . '%')
                ->orWhere('description', 'LIKE', '%' . $tag . '%')
                ->orWhere('email', 'LIKE', '%' . $tag . '%')
                ->orWhere('tags', 'LIKE', '%' . $tag . '%');
        }
        
        $jobs = $query->paginate();
        
        return view('user.jobs', compact('user', 'jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|min:5|max:255',
            'email' => 'required|email',
            'address'   => 'nullable|min:5|max:255',
            'phone'     => 'nullable|regex:/^[0-9\-]{10,20}$/',
            'work_address' => 'required|min:5|max:255',
            'salary'    => 'required|regex:/^[a-z0-9 ]+/i',
            'tags'  => 'required|array|min:1|max:3',
            'tags.*'    => [
                'min:2', 'max:20', 'regex:/^[^, ;|\-#]+$/i'
            ],
            'description'   => 'nullable|min:20|max:500',
            'details'   => 'required|min:10|max:5000',
            'pic'   =>  'nullable|image|max:2048'
        ]);

        if(Auth::user()->jobs()->count() >= 10){
            return back()->with('status', 'You have reached maximum number of jobs');
        }


        // Upload the image
        $path = null;   // The path for uploaded cover
        if($request->pic){
            $path = $request->pic->store('images');
        }


        // Create a job
        $job = Job::create([
            'title' => $request->title,
            'address'   => $request->address,
            'phone'     => $request->phone,
            'work_address' => $request->work_address,
            'salary'    => $request->salary,
            'email'    => $request->email,
            'tags'  => strtolower(implode(',', $request->tags)),
            'description'   => $request->description,
            'details'   => $request->details,
            'pic'   =>  $path,
            'user_id' => Auth::user()->id
        ]);


        // Success method
        Session::flash('status', 'Job created successfully');

        // Redirect to the job view with new one's id
        return redirect()->route('job.show', $job->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try{
            // Find the job
            $job = Job::where('slug', $slug)->firstOrFail();

            return view('jobs.show', compact('job'));
        } catch(Exception $e) {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        try{
            // Find the job
            $job = Job::where('user_id', Auth::user()->id)->where('slug', $slug)->firstOrFail();

            return view('jobs.edit', compact('job'));
        } catch(Exception $e) {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$slug)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|min:5|max:255',
            'email' => 'required|email',
            'address'   => 'nullable|min:10|max:255',
            'phone'     => 'nullable|regex:/^[0-9\-]{10,20}$/',
            'work_address' => 'required|min:10|max:255',
            'salary'    => 'required|regex:/^[a-z0-9 ]+/i',
            'tags'  => 'required|array|min:1|max:3',
            'tags.*'    => [
                'min:2', 'max:20', 'regex:/^[^, ;|\-#]+$/i'
            ],
            'description'   => 'nullable|min:20|max:500',
            'details'   => 'required|min:10|max:5000',
            'pic'   =>  'nullable|image|max:2048'
        ]);
        
        try{
            
            // Find the job
            $job = Job::where('user_id', Auth::user()->id)->where('slug', $slug)->firstOrFail();
            
            
            // Delete old cover
            if($request->delete_pic && $job->pic && ! $request->pic){
                Storage::delete($job->pic);
            }

            // Upload the image
            $path = null;   // The path for uploaded cover
            if($request->pic){
                $path = $request->pic->store('images');
                // Delete old cover
                Storage::delete($job->pic);
            } else {
                $path = $job->pic;
            }

            // Update
            $job->update([
                'title' => $request->title,
                'address'   => $request->address,
                'phone'     => $request->phone,
                'work_address' => $request->work_address,
                'salary'    => $request->salary,
                'email'    => $request->email,
                'tags'  => strtolower(implode(',', $request->tags)),
                'description'   => $request->description,
                'details'   => $request->details,
                'pic'   =>  $path,
            ]);


            Session::flash('status', 'Job has been updated successfully');

            return redirect()->route('job.show', $job->slug);
        } catch (Exception $e){
            dd($e);
            return abort(404);
        }

    }

    public function controllSearch(Request $request){
        if(Auth::check()){
            return $this->search($request);
        } else {
            return $this->searchGuest($request);
        }
    }

     
    /**
     * Search
     * 
     * @return response
     */
     public function search(Request $request){

        $request->validate([
            'search'    => 'required|min:2',
            'type'  => [
                'required', 'regex:/^(user)|(job)$/'
            ]
        ]);

        $searchTerm = $request->search;

        if($request->type == 'user'){


            // Selelect All users
            $users = User::where('first', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('last', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('works_as', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('tags', 'LIKE', '%' . $searchTerm . '%')->paginate(10);


            return view('search-users', compact('users'));
        } else {


            // Selelect All users
            $jobs = Job::where('title', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('tags', 'LIKE', '%' . $searchTerm . '%')->paginate(10);

            return view('search-jobs', compact('jobs'));
        }

     }
    /**
     * Search
     * 
     * @return response
     */
     public function searchGuest(Request $request){

        $request->validate([
            'search'    => 'required|min:2',
        ]);

        $searchTerm = $request->search;


        // Selelect All users
        $jobs = Job::where('title', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('tags', 'LIKE', '%' . $searchTerm . '%')->paginate(10);


        return view('search-jobs', compact('jobs'));

     }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $job = Job::where('id', $id)->where('user_id', Auth::user()->id)->delete();

            Session::flash('status', 'Job deleted successfully');

            return redirect()->route('profile');
        } catch (Exception $e) {
            return abort(404);
        }
    }
}
