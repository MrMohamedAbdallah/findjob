<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Carbon\Carbon;  // For dates

use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Validator;   // Validator
use Illuminate\Support\Facades\Storage;

use App\Job;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get authed user
        $user = Auth::user();


        // Profile page
        return view('user.profile', compact('user'));
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
    public function show($slug)
    {
        
        try{
            $user = User::where('slug', $slug)->firstOrFail();
            
            return view('user.profile')->with('user', $user);
        } catch (Exception $e) {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Get authed user
        $user = Auth::user();

        return view('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Get Authed user
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'first' => 'required|min:3|max:30',
            'last' => 'required|min:3|max:30',
            'works_as' => 'nullable|min:4|max:50',
            'level' => 'nullable|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|regex:/^[0-9\-]{10,20}$/',
            'birth_date' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d') . '',
            'details' => 'nullable|min:10|max:5000',
            'tags' => 'nullable|array|max:10',
            'tags.*' => [
                'min:2', 'max:20', 'regex:/^[^, ;|\-#]+$/i'
            ],
        ]);

        // Format tags


        // dd($request->only([
        //     'first', 'last', 'email', 'works_as', 'level', 'phone', 'birth_date', 'details', 'tags', 'active'
        // ]));

        // Update
        $user->update([
            'first'  => $request->first,
            'last'  => $request->last,
            'email'  => $request->email,
            'works_as'  => $request->works_as,
            'level'  => $request->level,
            'phone'  => $request->phone,
            'birth_date'  => $request->birth_date,
            'details'  => $request->details,
            'tags'  => strtolower(implode(',', $request->tags)),
            'active'  => $request->active ? 1 : 0,
        ]);

        // $user->save();


        // Success message
        Session::flash('status', 'Your information updated successfully');

        // The view
        return redirect()->route('profile');
    }

    /**
     * Change profile picture
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function profilePic(Request $request)
    {

        // Validate the request
        $result = Validator::make($request->all(), [
            'pic'   => 'required|image|max:2048'
        ]);

        if ($result->fails()) {
            return response()->json([
                'errors'    => $result->errors()->all()
            ]);
        }

        // Get authed user
        $user = Auth::user();

        // Delete the user pic if it exists
        if ($user->pic) {
            Storage::delete($user->pic);
        }

        // Save the image
        $path = $request->pic->store('images');

        // Update user info
        $user->update([
            'pic' => $path
        ]);

        // Sent the image path with JSON response
        return response()->json([
            'errors'    => [],
            'path'   => 'http://' . Storage::url($path)
        ]);
    }


    /**
     * Upload resume
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function resume(Request $request)
    {

        // Validate the request
        $result = Validator::make($request->all(), [
            'resume'   => 'required|file|mimes:pdf,docx|max:2048'
        ]);

        if ($result->fails()) {
            return response()->json([
                'errors'    => $result->errors()->all()
            ]);
        }

        // Get authed user
        $user = Auth::user();

        // Delete the user resume if it exists
        if ($user->resume) {
            Storage::delete($user->resume);
        }

        // Save the image
        $path = $request->resume->store('files');

        // Update user info
        $user->update([
            'resume' => $path
        ]);

        // Sent the image path with JSON response
        return response()->json([
            'errors'    => [],
            'path'   => 'http://' . Storage::url($path)
        ]);
    }

    /**
     * Apply to jobs
     * 
     * @var Request
     * @var int
     * 
     * @return response
     */
    public function apply(Request $request, $id){

        try{

            // Get authed user
            $user = Auth::user();

            // Find the job that does not belong to the authed user
            $job = Job::where('user_id', '!=', $user->id)->where('id', $id)->firstOrFail();

            $job->users()->attach($user->id);

            return back()->with('status', 'You applied successfully');
        } catch (Exception $e) {
            return abort(404);
        }

    }

    /**
     * Unapply to applied job
     * 
     * @var Request
     * @var int
     * 
     * @return response
     */
    public function unapply(Request $request, $id){

        try{

            // Get authed user
            $user = Auth::user();

            $user->applies()->detach($id);

            return back()->with('status', 'You unaplied successfully');
        } catch (Exception $e) {
            return abort(404);
        }

    }


    /**
     * Download the user's resume
     * 
     * @var int
     * 
     * @return downlaod response
     */
    // public function downloadResume($id)
    // {
    //     try {
    //         // Get the user
    //         $user = User::findOrFail($id);

    //         if ($user->resume) {
    //             return Storage::download($user->resume, $user->first . '_' . $user->last . '_' . 'resume');
    //         }
    //         throw "Not found";
    //     } catch (Exception $e) {
    //         return abort(404);
    //     }
    // }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { }
}
