<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Facades\LogActivity;
use Illuminate\Database\Eloquent\Model;

class LogUserActions
{
    public function handle(Request $request, Closure $next, $guard)
    {
        // Exclude GET requests from logging
        if ($request->isMethod('get')) {
            return $next($request);
        }

        // Determine the authenticated guard
        //$guard = auth()->getDefaultDriver(); // e.g., 'web', 'api'

        // Get the authenticated user
        $user = auth($guard)->user();

        // Capture old values before request execution
        $oldValues = $this->getOldValues($request);

        // Process the request
        $response = $next($request);

        if ($user) {
            $this->logChanges($request, $user, $guard, $oldValues);
        }

        return $response;
    }

    private function getOldValues(Request $request)
    {
        $modelClass = $this->getModelFromRoute($request);
        if ($modelClass && class_exists($modelClass)) {
            $id = $request->route()->parameter('id') ?? $request->route()->parameter('uuid'); // Handle both ID and UUID
            if ($id) {
                return $modelClass::find($id)?->getOriginal();
            }
        }
        return [];
    }

    private function logChanges(Request $request, $user, $guard, $oldValues)
    {
        $modelClass = $this->getModelFromRoute($request);

        if ($modelClass && class_exists($modelClass)) {
            activity($guard)
                ->causedBy($user)
                ->withProperties([
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'old' => $oldValues,
                    'new' => $request->except(['password', 'password_confirmation']), // Exclude sensitive data
                ])
                ->log("User {$request->method()} on {$request->path()}");
        }
    }

    private function getModelFromRoute(Request $request)
    {
        // Extract model name from route and dynamically resolve the model class
        $routeSegments = explode('/', $request->path());

        foreach ($routeSegments as $segment) {
            $modelClass = 'App\\Models\\' . ucfirst(Str::singular($segment)); // Converts 'posts' -> 'Post'
            if (class_exists($modelClass)) {
                return $modelClass;
            }
        }

        return null;
    }
}
