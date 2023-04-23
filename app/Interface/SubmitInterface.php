<?php
namespace App\Interface;

use App\Models\PracticeStudentSubmit;

interface SubmitInterface{
    function submitPractice($dataResult): bool;
}
