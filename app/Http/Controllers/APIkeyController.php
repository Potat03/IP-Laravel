<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\APIKey;

class APIkeyController extends Controller
{

    public function listKey() {
        // Check if got logged in
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::guard('admin')->user();

        //use guard to check if allowed
        if ($user->role !== 'manager' || $user->status !== 'active') {
            return redirect()->route('admin.main');
        }
        $keys = APIKey::all();

        return view('admin.api_management', ['keys' => $keys]);
    }
    


    public function createKey(Request $request) {

        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Please login to continue'], 403);
            }

            $user = Auth::guard('admin')->user();

            //use guard to check if allowed
            if ($user->role !== 'manager' || $user->status !== 'active') {
                return response()->json(['success' => false, 'info' => 'You account is allowed to do this.'], 403);
            }

            //validate note
            $request->validate([
                'note' => 'required|string|max:255',
            ]);

            // Create API key
            $key = APIKey::create([
                'note' => $request->note,
                'api_key' => bin2hex(random_bytes(32)),
            ]);

            $this->listKey();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }


    public function deleteKey(Request $request) {
        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Please login to continue'], 403);
            }

            $user = Auth::guard('admin')->user();

            //use guard to check if allowed
            if ($user->role !== 'manager' || $user->status !== 'active') {
                return response()->json(['success' => false, 'info' => 'You account is allowed to do this.'], 403);
            }

            //validate key
            $request->validate([
                'key' => 'required|string|max:255',
            ]);

            // Delete API key
            $key = APIKey::where('api_key', $request->key)->first();

            if ($key) {
                $key->delete();
                $this->listKey();
            } else {
                return response()->json(['success' => false, 'info' => 'API key not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

}