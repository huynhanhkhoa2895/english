<?php
namespace App\Interface;

use Illuminate\Support\Collection;

interface InterviewQuestionInterface{
    function getList(): Collection;
}
