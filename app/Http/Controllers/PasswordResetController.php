<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del email no es válido',
            'email.exists' => 'No existe una cuenta con este email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user has made too many reset requests
        $email = $request->email;
        $key = 'password_reset_attempts:' . $email;

        if (cache()->has($key) && cache()->get($key) >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Has excedido el límite de solicitudes de recuperación. Intenta de nuevo en 1 hora.',
                'code' => 'TOO_MANY_REQUESTS'
            ], 429);
        }

        // Increment attempts counter
        cache()->put($key, (cache()->get($key, 0) + 1), 3600); // 1 hour

        // Generate reset token
        $token = Str::random(64);
        $expiresAt = Carbon::now()->addMinutes(60);

        // Store token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
                'expires_at' => $expiresAt
            ]
        );

        // Send email (in a real application, you would send an actual email)
        // For now, we'll just return the token for testing
        return response()->json([
            'success' => true,
            'message' => 'Se ha enviado un enlace de recuperación a tu email',
            'token' => $token, // Remove this in production
            'expires_at' => $expiresAt->toISOString()
        ]);
    }

    /**
     * Reset password with token
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string|size:64',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:128',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ],
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del email no es válido',
            'email.exists' => 'No existe una cuenta con este email',
            'token.required' => 'El token es obligatorio',
            'token.size' => 'El token debe tener 64 caracteres',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una mayúscula, un número y un símbolo especial',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find valid reset token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido o expirado',
                'code' => 'INVALID_TOKEN'
            ], 400);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Clear reset attempts cache
        cache()->forget('password_reset_attempts:' . $request->email);

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada exitosamente'
        ]);
    }

    /**
     * Verify reset token
     */
    public function verifyToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string|size:64',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido o expirado',
                'code' => 'INVALID_TOKEN'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token válido',
            'expires_at' => $resetRecord->expires_at
        ]);
    }
}
