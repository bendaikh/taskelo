<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetWorkspace
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If user doesn't have a current workspace, set one
            if (!$user->current_workspace_id) {
                $workspace = $user->workspaces()->first();
                
                if ($workspace) {
                    $user->update(['current_workspace_id' => $workspace->id]);
                } else {
                    // Default to business workspace (administrator workspace should be business)
                    // First user (administrator) gets business, others can be personal or business
                    $workspaceType = 'business';
                    
                    // Create a default workspace if user has none
                    $workspace = \App\Models\Workspace::create([
                        'name' => $user->name . "'s Workspace",
                        'type' => $workspaceType,
                        'description' => 'Default workspace',
                        'owner_id' => $user->id,
                        'is_active' => true,
                    ]);
                    
                    $workspace->users()->attach($user->id, ['role' => 'owner']);
                    $user->update(['current_workspace_id' => $workspace->id]);
                }
            }
            
            // Share the current workspace with all views
            view()->share('currentWorkspace', $user->currentWorkspace);
        }

        return $next($request);
    }
}

