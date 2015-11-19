<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Depotwarehouse\SoDoge\Model\User;
use Depotwarehouse\Toolbox\DataManagement\Validation\ValidationException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class Users extends Controller
{

    protected $users;
    protected $auth;

    public function __construct(User $users, Guard $auth)
    {
        $this->users = $users;
        $this->auth = $auth;
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('user.login');
    }

    public function auth(Request $request)
    {
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (!$this->auth->attempt($credentials)) {
            return redirect()->route('user.login')
                ->withErrors(new MessageBag([
                    'errors' => 'access much denied. shibe police on way'
                ]));
        }

        return redirect('user.show', $this->auth->user()->id);
    }

    /**
     * Logs out a user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home.index');
    }

    /**
     * Show the register form
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('user.register');
    }


    /**
     * Creates a new User.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $attributes = $request->only($this->users->getFillable());
        $attributes['password_confirmation'] = $request->input('password_confirmation');

        try {
            $user = $this->userRepository->create($attributes);
            $this->auth->login($user);
            return redirect()->route('user.show', $user->id);
        } catch (ValidationException $exception) {
            return redirect()->route('user.register')
                ->withErrors($exception->get())
                ->withInput();
        }
    }

    /**
     * Shows a User's profile.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $user = $this->userRepository->find($id);
            $shibes = $this->userRepository->getShibesForUser($id);

            return view('user.show')
                ->with('user', $user)
                ->with('shibes', $shibes);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            App::abort(404, "Could not find the specified user");
            return 1;
        }
    }
}
