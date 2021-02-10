<?php

use Illuminate\Database\Seeder;

class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups=\App\Group::all();

        $system_admin=\App\Group::where('user_group_name','=','SystemAdmin')->first();
        $super_admin=\App\Group::where('user_group_name','=','SuperAdmin')->first();
        $Employee=\App\Group::where('user_group_name','=','Employee')->first();
        $SubEmployee=\App\Group::where('user_group_name','=','SubEmployee')->first();
        $Agent=\App\Group::where('user_group_name','=','Agent')->first();
        $Vendors=\App\Group::where('user_group_name','=','Vendors')->first();
        $Reader=\App\Group::where('user_group_name','=','Reader')->first();

        foreach ($groups as $group){

            if($group->user_group_name!='SuperAdmin'){

                DB::table('groupuser')->insert([
                    'group_id' => $super_admin->id,
                    'invited_groups_id'=>$group->id
                ]);
            }
        }

        foreach ($groups as $group){

            if($group->user_group_name!='SuperAdmin' && $group->user_group_name!='SystemAdmin'){

                DB::table('groupuser')->insert([
                    'group_id' => $Employee->id,
                    'invited_groups_id'=>$group->id
                ]);
            }
        }

        foreach ($groups as $group){

            if($group->user_group_name!='SuperAdmin' && $group->user_group_name!='SystemAdmin'){

                DB::table('groupuser')->insert([
                    'group_id' => $system_admin->id,
                    'invited_groups_id'=>$group->id
                ]);
            }
        }

        foreach ($groups as $group){

            if($group->user_group_name!='SuperAdmin' && $group->user_group_name!='SystemAdmin' && $group->user_group_name!='Employee'){

                DB::table('groupuser')->insert([
                    'group_id' => $SubEmployee->id,
                    'invited_groups_id'=>$group->id
                ]);
            }
        }


        foreach ($groups as $group){

            if($group->user_group_name!='SuperAdmin'
                && $group->user_group_name!='SystemAdmin'
                && $group->user_group_name!='Employee'
                && $group->user_group_name!='SubEmployee'){

                DB::table('groupuser')->insert([
                    'group_id' => $Agent->id,
                    'invited_groups_id'=>$group->id
                ]);
            }
        }

        foreach ($groups as $group){

            \Illuminate\Support\Facades\Log::info($group->user_group_name);
            if($group->user_group_name!='SuperAdmin'
                && $group->user_group_name!='SystemAdmin'
                && $group->user_group_name!='Employee'
                && $group->user_group_name!='SubEmployee'
                && $group->user_group_name!='Agent'
            ){

                DB::table('groupuser')->insert([
                    'group_id' => $Vendors->id,
                    'invited_groups_id'=>$group->id
                ]);
            }
        }



    }
}
