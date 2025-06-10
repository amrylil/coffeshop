<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  /**
   * Display a listing of the users.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::all();
    return view('pages.admin.users.index', ['users' => $users]);
  }

  /**
   * Show the form for creating a new user.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.admin.users.create');
  }

  /**
   * Store a newly created user in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email_222297'         => 'required|email|unique:users_222297',
      'name_222297'          => 'required|string|max:255',
      'password_222297'      => 'required|string|min:8',
      'gender_222297'        => 'required|in:male,female',
      'role_222297'          => 'required|string',
      'address_222297'       => 'nullable|string',
      'phone_222297'         => 'nullable|string',
      'birth_date_222297'    => 'nullable|date',
      'profile_photo_222297' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $userData                    = $request->all();
    $userData['password_222297'] = Hash::make($request->password_222297);

    // Handle profile photo upload if exists
    if ($request->hasFile('profile_photo_222297')) {
      $file     = $request->file('profile_photo_222297');
      $filename = time() . '.' . $file->getClientOriginalExtension();
      $file->storeAs('public/profile_photos', $filename);
      $userData['profile_photo_222297'] = $filename;
    }

    User::create($userData);

    return redirect()
      ->route('admin.users.index')
      ->with('success', 'User created successfully');
  }

  /**
   * Display the specified user.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
    return view('pages.admin.users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified user.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::findOrFail($id);
    return view('pages.admin.users.edit', compact('user'));
  }

  /**
   * Update the specified user in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
      'email_222297'         => 'required|email|unique:users_222297,email_222297,' . $id . ',email_222297',
      'name_222297'          => 'required|string|max:255',
      'gender_222297'        => 'required|in:male,female',
      'role_222297'          => 'required|string',
      'address_222297'       => 'nullable|string',
      'phone_222297'         => 'nullable|string',
      'birth_date_222297'    => 'nullable|date',
      'profile_photo_222297' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $userData = $request->except(['_token', '_method', 'password_222297']);

    // Update password only if provided
    if ($request->filled('password_222297')) {
      $userData['password_222297'] = Hash::make($request->password_222297);
    }

    // Handle profile photo upload if exists
    if ($request->hasFile('profile_photo_222297')) {
      $file     = $request->file('profile_photo_222297');
      $filename = time() . '.' . $file->getClientOriginalExtension();
      $file->storeAs('public/profile_photos', $filename);
      $userData['profile_photo_222297'] = $filename;
    }

    $user->update($userData);

    return redirect()
      ->route('admin.users.index')
      ->with('success', 'User updated successfully');
  }

  /**
   * Remove the specified user from storage.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()
      ->route('admin.users.index')
      ->with('success', 'User deleted successfully');
  }

  /**
   * Change user role.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function changeRole(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
      'role_222297' => 'required|string',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $user->update([
      'role_222297' => $request->role_222297
    ]);

    return redirect()
      ->route('users.index')
      ->with('success', 'User role updated successfully');
  }
}
