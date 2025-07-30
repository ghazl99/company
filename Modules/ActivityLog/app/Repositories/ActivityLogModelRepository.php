<?php

namespace Modules\ActivityLog\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ActivityLogModelRepository implements ActivityLogRepository
{
    public function getFilteredActivities(Request $request)
    {
        $activities = Activity::with('causer');

        if ($request->from) {
            $activities->whereDate('created_at', '>=', $request->from);
        }

        if ($request->to) {
            $activities->whereDate('created_at', '<=', $request->to);
        }

        if ($request->search) {
            $search = $request->search;
            $activities->where(function ($query) use ($search) {
                $query->where('event', 'like', "%$search%")
                    ->orWhere(
                        DB::raw("LOWER(CONCAT(description, ' by ', log_name))"),
                        'like',
                        '%'.strtolower($search).'%'
                    )
                    ->orWhere('id', 'like', "%$search%");
            });
        }

        return $activities->orderBy('created_at', 'desc')->paginate(10);
    }
}
