<?php

namespace App\Service;

use App\Entity\Worktime;
use App\Repository\WorktimeRepository;

class DateService
{
 public function __construct(WorktimeRepository $worktimeRepository)
 {
     $this->worktimeRepository = $worktimeRepository;
 }

 public function calculateWorktimes($id)
 {
        $worktimes = $this->worktimeRepository->findWorktimesByUser($id);
        $date = new \DateTime();
        $dateNow = new \DateTime();

        foreach($worktimes as $worktime) {
            $interval = $worktime['endTime']->diff($worktime['startTime']);
            $date->add($interval);
        }
        return $date->diff($dateNow);

 }
}