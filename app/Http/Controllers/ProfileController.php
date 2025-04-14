<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();

        $file = $request->file('photo');
        $filename = null;

        if (!empty($file)) {
            $filename = $user->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/img/photo/', $filename);
        }

        $updateData = [];

        if (!empty($data['email'])) {
            $updateData['email'] = $data['email'];
        }
        if (!empty($data['name'])) {
            $updateData['name'] = $data['name'];
        }
        if ($filename) {
            $updateData['photo'] = '/storage/img/photo/' . $filename;
        }

        $user->update($updateData);

        return redirect(route('profile.index'));
    }

    public function index()
    {
        $myComments = Comment::where('user_id', Auth::id())->get();
        return view('profile', compact('myComments'));
    }

    public function checkMyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
        ]);

        $user = Auth::user();

        if (Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['error' => 'Incorrect password'], 401);
        }
    }

    public function changeMyPassword(UpdatePasswordRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'status' => 'Incorrect password',
            ], 400);
        }

        $user->password = bcrypt($data['new_password']);
        $user->save();

        return response()->json([
            'success' => 'Password was successfully changed',
        ], 200);
    }
}
