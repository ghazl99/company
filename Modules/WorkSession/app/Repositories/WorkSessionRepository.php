<?php

namespace Modules\WorkSession\Repositories;

interface WorkSessionRepository
{
    public function startSession(int $developerId);

    public function endSession(int $developerId);

    public function getActiveSession(int $developerId);
}
