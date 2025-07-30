<?php

namespace Modules\ActivityLog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ActivityLog\Services\ActivityLogService;

class ActivityLogController extends Controller
{
    public function __construct(
        protected ActivityLogService $activityService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activities = $this->activityService->getActivities($request);

        return view('activitylog::admin\index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activitylog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $activity = $this->activityService->findByIdWithCauser($id);

        return view('activitylog::admin\show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('activitylog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
