<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15|unique:users,mobile_number',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => ['user'], // Default role is regular user
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    /**
     * Log in a user and return a token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->identifier;

        // Find user by email or mobile number
        $user = User::where('email', $identifier)
            ->orWhere('mobile_number', $identifier)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'identifier' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get details of the authenticated user.
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Send OTP for Password Reset.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
        ]);

        $user = User::where('email', $request->identifier)
            ->orWhere('mobile_number', $request->identifier)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'identifier' => ['User with this email or mobile number does not exist.'],
            ]);
        }

        // Return a fixed testing OTP (123456)
        $otp = "123456";

        return response()->json([
            'message' => 'OTP code sent successfully.',
            'otp' => $otp
        ]);
    }

    /**
     * Reset Password using OTP.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'otp' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->identifier)
            ->orWhere('mobile_number', $request->identifier)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'identifier' => ['User does not exist.'],
            ]);
        }

        if ($request->otp !== '123456') {
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP code is invalid.'],
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Your password has been reset successfully.'
        ]);
    }

    /**
     * Update User Profile.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'mobile_number' => 'required|string|max:15|unique:users,mobile_number,' . $user->id,
            'roles' => 'nullable|array',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;

        if ($request->has('roles')) {
            $newRoles = $request->roles;
            $currentRoles = $user->roles ?? [];
            $protectedRoles = array_intersect(['admin', 'manager'], $currentRoles);
            $user->roles = array_values(array_unique(array_merge($protectedRoles, $newRoles)));
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }

    /**
     * Update Password.
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided current password does not match.'],
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully.'
        ]);
    }

    /**
     * Delete Account.
     */
    public function deleteAccount(Request $request)
    {
        $user = $request->user();
        
        // Revoke all tokens
        $user->tokens()->delete();
        
        // Delete user record
        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully.'
        ]);
    }

    /**
     * Update User Location.
     */
    public function updateLocation(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'current_location' => 'required|string|max:255',
        ]);

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->current_location = $request->current_location;
        $user->save();

        return response()->json([
            'message' => 'Location updated successfully.',
            'user' => $user
        ]);
    }

    /**
     * Get system config settings.
     */
    public function getConfig()
    {
        $platform = 'leaflet';
        $apiKey = '';

        $filePath = storage_path('app/settings.json');
        if (file_exists($filePath)) {
            $data = json_decode(file_get_contents($filePath), true);
            $platform = $data['maps_platform'] ?? $platform;
            $apiKey = $data['google_maps_api_key'] ?? $apiKey;
        }

        return response()->json([
            'maps_platform' => $platform,
            'google_maps_api_key' => $apiKey,
        ]);
    }

    /**
     * Get stop locations filtered by type and sorted by distance.
     */
    public function getStops(Request $request)
    {
        $lat = $request->query('latitude');
        $lng = $request->query('longitude');
        $type = $request->query('type');

        $query = Stop::where('status', 'active');

        if ($type && $type !== 'All' && $type !== 'all') {
            $query->where('type', strtolower($type));
        }

        $stops = $query->get();

        if ($lat !== null && $lng !== null) {
            $lat = (double)$lat;
            $lng = (double)$lng;
            
            // Load search radius setting
            $searchRadius = 5.0; // Default fallback
            $filePath = storage_path('app/settings.json');
            if (file_exists($filePath)) {
                $data = json_decode(file_get_contents($filePath), true);
                $searchRadius = isset($data['search_radius']) ? (double)$data['search_radius'] : $searchRadius;
            }
            
            $stops = $stops->map(function ($stop) use ($lat, $lng) {
                // Haversine formula
                $earthRadius = 6371; // Kilometers
                
                $latDelta = deg2rad($stop->latitude - $lat);
                $lonDelta = deg2rad($stop->longitude - $lng);
                
                $a = sin($latDelta / 2) * sin($latDelta / 2) +
                     cos(deg2rad($lat)) * cos(deg2rad($stop->latitude)) *
                     sin($lonDelta / 2) * sin($lonDelta / 2);
                     
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                
                $stop->distance = round($earthRadius * $c, 2); // Distance in km
                return $stop;
            })
            ->filter(function ($stop) use ($searchRadius) {
                return $stop->distance <= $searchRadius;
            })
            ->sortBy('distance')
            ->values();
        } else {
            $stops = $stops->map(function ($stop) {
                $stop->distance = null;
                return $stop;
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $stops
        ]);
    }

    /**
     * Create a new stop location.
     */
    public function storeStop(Request $request)
    {
        // 1. Authorize
        if (!$request->user()->hasAdminAccess()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Only Admins or Managers can create stops.'
            ], 403);
        }





        // 2. Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:bus,auto,taxi,parking,train,metro',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|string|in:active,inactive,maintenance',
        ]);

        // 3. Create
        $stop = Stop::create([
            'name' => $request->name,
            'type' => $request->type,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Stop location created successfully.',
            'data' => $stop
        ], 201);
    }
}
