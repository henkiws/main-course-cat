<?php

namespace App\Repositories\CAT;

use App\Models\CAT\CATTestUser;
use DB;

class CATTestUserRepository
{

    public function getAll() {
        return CATTestUser::get();
    }

    public function getCount() {
        return CATTestUser::count();
    }

    public function getPaginate($paginate = 10, $cbt) {
        $cbt = json_decode($cbt);
        $CATTestUser =  CATTestUser::with(['data_cbt_user'])
                        ->whereIn('tesuser_tes_id',$cbt)
                        ->where('tesuser_status',4)
                        ->groupBy('tesuser_user_id')
                        ->join('main_users','main_users.fk_cbt_student','=','cbt_tes_user.tesuser_user_id')
                        ->select('main_users.*','cbt_tes_user.*')
                        ->paginate($paginate);

        return $CATTestUser;
    }

    public function FetchById($id) {
        return CATTestUser::where('tes_user_id',$id)->first();
    }
    
}