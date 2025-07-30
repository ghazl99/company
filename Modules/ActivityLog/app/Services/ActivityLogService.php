<?php

namespace Modules\ActivityLog\Services;

use Illuminate\Http\Request;
use Modules\ActivityLog\Repositories\ActivityLogRepository;
use Spatie\Activitylog\Models\Activity;

class ActivityLogService
{
    public function __construct(
        protected ActivityLogRepository $activityRepo
    ) {}

    public function getActivities(Request $request)
    {
        return $this->activityRepo->getFilteredActivities($request);
    }

    public function findByIdWithCauser($id)
    {
        return Activity::with('causer')->findOrFail($id);
    }
}
