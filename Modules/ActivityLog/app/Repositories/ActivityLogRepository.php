<?php

namespace Modules\ActivityLog\Repositories;

use Illuminate\Http\Request;

interface ActivityLogRepository
{
    public function getFilteredActivities(Request $request);
}
