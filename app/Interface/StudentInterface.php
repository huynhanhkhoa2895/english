<?php
namespace App\Interface;

use App\Http\Resources\StudentResource;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface StudentInterface{
    function getList(): Collection;
    function handle(Request $request,string $id): mixed;
}
