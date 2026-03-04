# Authentication Integration Guide

The leaderboard now includes Login, Register, and Back buttons that integrate with your Laravel authentication system.

## How It Works

### 1. When User is NOT Authenticated
- Shows **Login** button (redirects to Laravel `/login` page)
- Shows **Register** button (redirects to Laravel `/register` page)

### 2. When User IS Authenticated
- Shows **Back** button (returns to previous page)
- Hides Login and Register buttons

## Laravel Backend Setup

### Step 1: Create Auth Check Endpoint

Create a new API endpoint to check if the user is authenticated:

**File:** `app/Http/Controllers/Api/AuthController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function check(Request $request)
    {
        if (auth()->check()) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => auth()->user()->id,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }
}
```

### Step 2: Add Route

**File:** `routes/api.php`

```php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeaderboardController;

Route::get('/leaderboard', [LeaderboardController::class, 'index']);
Route::get('/auth/check', [AuthController::class, 'check']);
```

### Step 3: Configure Session Handling

Make sure your Laravel API supports session-based authentication. In `config/cors.php`:

```php
return [
    'paths' => ['api/*'],
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5000')],
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'supports_credentials' => true, // Important for sessions!
];
```

In `config/sanctum.php` (if using Sanctum):

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,localhost:5000,127.0.0.1,127.0.0.1:8000,::1',
    env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
))),
```

### Step 4: Update Laravel Routes for Login/Register

Make sure your Laravel app has these routes (they should exist by default):

```php
// In routes/web.php
Auth::routes(); // This creates /login and /register routes
```

Or if using Laravel Breeze/Jetstream, the routes are already configured.

## Frontend Configuration

The frontend is already configured! It will:
1. Check authentication status from `/api/auth/check`
2. Show Login/Register buttons that link to your Laravel pages
3. After successful login/register, Laravel should redirect users back to the leaderboard

### Redirect After Login

In your Laravel `LoginController`, set the redirect path:

**File:** `app/Http/Controllers/Auth/LoginController.php`

```php
protected $redirectTo = '/leaderboard'; // or wherever your React app is mounted

// Or use a method for more control:
protected function redirectTo()
{
    return env('FRONTEND_URL', 'http://localhost:5000');
}
```

## Testing the Flow

1. **Not Authenticated:**
   - Visit leaderboard → See Login and Register buttons
   - Click Login → Redirected to Laravel login page
   - Enter credentials → Redirected back to leaderboard
   - Now see Back button instead

2. **Already Authenticated:**
   - Visit leaderboard → See Back button only
   - Click Back → Returns to previous page

## Important Notes

- The auth check endpoint must support **credentials/cookies** to work with sessions
- Make sure CORS is properly configured to allow credentials
- The Login and Register buttons perform full page redirects (not SPA navigation)
- After login, Laravel handles the redirect back to your React app

## Expected API Response

**Endpoint:** `GET /api/auth/check`

**When authenticated:**
```json
{
  "authenticated": true,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

**When not authenticated:**
```json
{
  "authenticated": false
}
```
