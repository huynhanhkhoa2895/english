<?php
namespace App\Interface;

use App\Models\PracticeStudentResult;

interface ResultInterface{
    function createResult($data): bool;
}
