<?php

namespace App\Service;

use App\Entity\Worktime;
use App\Repository\WorktimeRepository;

class Evaluation
{
 public function __construct(WorktimeRepository $worktimeRepository)
 {
     $this->worktimeRepository = $worktimeRepository;
 }

 public function calculateDays(Worktime $worktime)
 {
     $days = date_diff($worktime->getEndTime(),$worktime->getStartTime());
     return $days;
 }
}