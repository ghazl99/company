<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Models\User;
use Modules\User\Repositories\UserModelRepository;
use Modules\User\Services\UserService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:superAdmin'),
        ];
    }

    public function __construct(
        protected UserService $userService,
        protected UserModelRepository $userRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = $this->userRepository->getAllDevelopers();

        return view('user::admin\index', compact('developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::admin\create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());

            return redirect()->route('user.index')
                ->with('success', 'تم إضافة المطور/ة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user::admin\edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->userService->update($request->validated(), $user);

            return redirect()->route('user.index')->with('success', 'تم التحديث بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function showCv(Media $media)
    {
        $path = $media->getPath();

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function showImage(Media $media)
    {
        $path = $media->getPath();

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
