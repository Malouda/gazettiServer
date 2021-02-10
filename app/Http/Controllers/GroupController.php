<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{


    public function getAllUserGroups(Request $request){

        $user=$request->user();
        $mygroupId=$user->user_group_id;

        Log::info($user);

        return DB::table('groupuser')
            ->where('groupuser.group_id',$mygroupId)
            ->join('user_groups','user_groups.id','groupuser.invited_groups_id')
            ->get();

    }
}
