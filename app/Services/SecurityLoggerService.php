<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityLoggerService
{
    /**
     * Log security events
     */
    public function logSecurityEvent(string $event, array $data = []): void
    {
        if (!config('security.logging.security_events', true)) {
            return;
        }

        $logData = array_merge([
            'event' => $event,
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => Auth::id(),
        ], $data);

        Log::channel('security')->info('Security Event', $logData);
    }

    /**
     * Log failed login attempts
     */
    public function logFailedLogin(string $email, string $reason = 'Invalid credentials'): void
    {
        if (!config('security.logging.failed_login_attempts', true)) {
            return;
        }

        $this->logSecurityEvent('failed_login', [
            'email' => $email,
            'reason' => $reason,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Log successful login
     */
    public function logSuccessfulLogin(int $userId, string $email): void
    {
        $this->logSecurityEvent('successful_login', [
            'user_id' => $userId,
            'email' => $email,
        ]);
    }

    /**
     * Log password reset request
     */
    public function logPasswordResetRequest(string $email): void
    {
        $this->logSecurityEvent('password_reset_request', [
            'email' => $email,
        ]);
    }

    /**
     * Log password reset success
     */
    public function logPasswordResetSuccess(int $userId, string $email): void
    {
        $this->logSecurityEvent('password_reset_success', [
            'user_id' => $userId,
            'email' => $email,
        ]);
    }

    /**
     * Log suspicious activity
     */
    public function logSuspiciousActivity(string $activity, array $data = []): void
    {
        if (!config('security.logging.suspicious_activity', true)) {
            return;
        }

        $this->logSecurityEvent('suspicious_activity', array_merge([
            'activity' => $activity,
        ], $data));
    }

    /**
     * Log rate limit exceeded
     */
    public function logRateLimitExceeded(string $endpoint, int $attempts): void
    {
        $this->logSecurityEvent('rate_limit_exceeded', [
            'endpoint' => $endpoint,
            'attempts' => $attempts,
        ]);
    }

    /**
     * Log invalid token usage
     */
    public function logInvalidToken(string $tokenType, string $reason = 'Invalid or expired'): void
    {
        $this->logSecurityEvent('invalid_token', [
            'token_type' => $tokenType,
            'reason' => $reason,
        ]);
    }

    /**
     * Log data validation failures
     */
    public function logValidationFailure(array $errors, array $input = []): void
    {
        $this->logSecurityEvent('validation_failure', [
            'errors' => $errors,
            'input_keys' => array_keys($input),
        ]);
    }

    /**
     * Log API access
     */
    public function logApiAccess(string $endpoint, string $method, int $statusCode): void
    {
        $this->logSecurityEvent('api_access', [
            'endpoint' => $endpoint,
            'method' => $method,
            'status_code' => $statusCode,
        ]);
    }
}
