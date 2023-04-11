<?php
namespace App\Interface;

use App\Models\Result;

interface ResultInterface{
    function createResult($data): Result|false;
}
