<?php

namespace Modules\WorkSession\Services;

use Modules\WorkSession\Repositories\WorkSessionRepository;

class WorkSessionService
{
    public function __construct(
        protected WorkSessionRepository $WorkSessionRepository
    ) {}

    public function start(int $developerId)
    {
        return $this->WorkSessionRepository->startSession($developerId);
    }

    public function end(int $developerId)
    {
        return $this->WorkSessionRepository->endSession($developerId);
    }

    public function getActiveSession(int $developerId)
    {
        return $this->WorkSessionRepository->getActiveSession($developerId);
    }
}
