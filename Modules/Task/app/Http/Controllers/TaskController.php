<?php

namespace Modules\Task\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Task\Http\Requests\taskRequest;
use Modules\Task\Models\Task;
use Modules\Task\Services\TaskService;
use Modules\User\Models\User;
use Modules\User\Repositories\UserRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class TaskController extends Controller implements HasMiddleware
{
   public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('superAdmin'), except: ['index','changeStatus']),
        ];
    }
    public function __construct(
        protected TaskService $taskService,
        protected UserRepository $userRepo
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = $this->taskService->getAllTasks($user);

        return view('task::admin\index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $developers = $this->userRepo->getActiveDevelopers();

        return view('task::admin\create', compact('developers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(taskRequest $request)
    {
        try {
            $this->taskService->createTaskWithDevelopers($request->validated());

            return redirect()->route('task.index')->with('success', 'تم إضافة المهمة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function showImage(Media $media)
    {
        $path = $media->getPath();

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function changeStatus(Request $request, Task $task, User $developer)
    {
        try {
            $status = $request->input('status');

            $this->taskService->changeStatus($task, $developer, $status);

            return back()->with('success', 'تم تحديث الحالة  بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Task $task)
    {
        return view('task::admin\show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('task::edit');
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
