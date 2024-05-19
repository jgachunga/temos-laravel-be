<?php

namespace App\Exports;

use App\Models\Auth\User as AuthUser;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AuthUser::all();
    }
}
