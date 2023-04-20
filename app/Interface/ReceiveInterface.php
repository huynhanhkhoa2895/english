<?php
namespace App\Interface;

use App\Models\PracticeStudentReceive;

interface ReceiveInterface{
    function receivePractice($dataResult): bool;
}
