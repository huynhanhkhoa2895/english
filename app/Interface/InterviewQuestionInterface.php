<?php
namespace App\Interface;

use App\Models\InterviewQuestion;
use Illuminate\Support\Collection;

interface InterviewQuestionInterface{
    function getList(): Collection;
    function textToSpeach(InterviewQuestion $interviewQuestion): string|false;
}
