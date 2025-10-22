# Leaderboard Application

A responsive React leaderboard application that displays top students and universities rankings.

## Laravel Backend Integration Guide

This frontend is ready to connect to your Laravel backend. Follow these steps to integrate:

### 1. Backend API Endpoint

Create an API endpoint in your Laravel backend at:

```
GET /api/leaderboard
```

### 2. Expected Response Format

Your Laravel endpoint should return JSON in this exact format:

```json
{
  "users": [
    {
      "rank": 1,
      "name": "Student Name",
      "university": "University Name",
      "score": 9850,
      "avatar": "https://example.com/avatar.jpg" // optional
    }
    // ... up to 10 users
  ],
  "universities": [
    {
      "rank": 1,
      "name": "University Name",
      "totalScore": 45280,
      "logo": "https://example.com/logo.png" // optional
    }
    // ... up to 4 universities
  ]
}
```

### 3. TypeScript Interfaces

The frontend expects these data structures (defined in `shared/schema.ts`):

```typescript
interface StudentData {
  rank: number;
  name: string;
  university: string;
  score: number;
  avatar?: string;  // optional
}

interface UniversityData {
  rank: number;
  name: string;
  totalScore: number;
  logo?: string;  // optional
}

interface LeaderboardResponse {
  users: StudentData[];
  universities: UniversityData[];
}
```

### 4. CORS Configuration

Make sure your Laravel backend allows requests from your frontend origin. In `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5000')],
'allowed_methods' => ['GET', 'POST'],
'allowed_headers' => ['Content-Type', 'Authorization'],
'supports_credentials' => true,
```

### 5. Laravel Controller Example

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\University;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::with('university')->orderBy('total_user_score', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($users, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $users->name,
                    'university' => $users->university_id ? $users->university->name : 'N/A',
                    'score' => $users->total_user_score,
                    'avatar' => $users->profile_photo ?? null,
                ];
            });

        $universities = University::orderBy('total_score', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($university, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $university->name,
                    'totalScore' => $university->total_score,
                    'logo' => $university->UNI_photo ?? null,
                ];
            });

        return response()->json([
            'users' => $users,
            'universities' => $universities,
        ]);
    }
}
```

### 6. Laravel Route

In `routes/api.php`:

```php
use App\Http\Controllers\Api\LeaderboardController;

Route::get('/leaderboard', [LeaderboardController::class, 'index']);
```

### 7. Frontend Configuration

You have **two options** to configure the Laravel backend URL:

#### Option A: Using Replit Secrets (Recommended for Production)

1. In the Replit workspace, open the **Secrets** panel (🔒 icon in left sidebar)
2. Add a new secret:
   - Key: `VITE_API_URL`
   - Value: Your Laravel backend URL (e.g., `https://your-laravel-backend.com`)
3. Restart the application

#### Option B: Using Config File (Quick Setup)

Edit `client/src/config.ts` and update the `apiBaseUrl`:

```typescript
export const config = {
  apiBaseUrl: 'http://localhost:8000', // Your Laravel backend URL
  endpoints: {
    leaderboard: '/api/leaderboard',
  },
};
```

**Note:** If both are set, the environment variable (`VITE_API_URL`) takes precedence.

#### Same Domain Setup

If your React app and Laravel backend are served from the same domain (e.g., both on `example.com`), leave `apiBaseUrl` empty:

```typescript
apiBaseUrl: '', // Uses relative URLs
```

## Features

- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Dark/Light theme toggle
- ✅ Top 10 students with rankings
- ✅ Top 4 universities with total scores
- ✅ Medal badges for podium positions (1st, 2nd, 3rd)
- ✅ Loading and error states
- ✅ TypeScript type safety
- ✅ Avatar support with fallback initials
- ✅ Authentication integration (Login/Register buttons)
- ✅ Dynamic UI based on auth status

## Authentication Setup

The leaderboard includes Login and Register buttons that integrate with your Laravel authentication.

**See [README_AUTH.md](./README_AUTH.md) for detailed authentication setup instructions.**

Quick summary:
1. Create `/api/auth/check` endpoint in Laravel
2. Configure CORS to support credentials
3. Login and Register buttons automatically redirect to your Laravel pages
4. When authenticated, shows Back button instead

## Development

```bash
npm run dev
```

Visit `http://localhost:5000` to see the application.
