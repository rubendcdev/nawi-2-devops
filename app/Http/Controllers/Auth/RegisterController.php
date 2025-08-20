<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function register(Request $request)
{
    $this->validator($request->all())->validate();

    // Guardar archivos
    $licenciaPath = $request->file('licencia')->store('documentos');
    $tarjetaPath = $request->file('tarjeta_circulacion')->store('documentos');

    // Crear el usuario
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'licencia' => $licenciaPath,
        'tarjeta_circulacion' => $tarjetaPath,
        'activo' => false
    ]);

    $this->guard()->login($user);

    return redirect($this->redirectPath());
}
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'telefono' => ['required', 'numeric', 'digits:10'],
        'direccion' => ['required', 'string'],
        'licencia' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        'tarjeta_circulacion' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        'terminos' => ['accepted']
    ], [
        'telefono.required' => 'El teléfono es obligatorio.',
        'telefono.numeric' => 'El teléfono solo debe contener números.',
        'telefono.digits' => 'El teléfono debe tener exactamente 10 números.'
    ]);
}



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'licencia' => $request->file('licencia')->store('documentos'),
        'tarjeta_circulacion' => $request->file('tarjeta_circulacion')->store('documentos'),
        'activo' => false, // Activación manual posterior
]);
    }
}
