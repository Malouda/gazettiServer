<?php

namespace App\Http\Controllers;

use App\Group;
use App\Headline;
use App\Publication;
use App\PublicationEditionFrequency;
use App\Publisher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HeadlineController extends Controller
{
    private $release_date;
    private $next_release;
    private $headlines;




    public function headlines($request,$publicationId=null){

        $user=User::where('id','=',$request->user()->id)->first();
        $userGroup=Group::where('id','=',$user->user_group_id)->first();

        $result=DB::table('headlines')
            ->leftjoin('headlinesrating',function ($join) use($request){
                $join->on('headlines.id','headlinesrating.headline_id')
                    ->where('headlinesrating.user_id','=',$request->user()->id);
            })
            ->join('perspective','headlines.perspective_id','=','perspective.id')
            ->join('publication','headlines.publication_id','=','publication.id');

        if($request->id==null && $publicationId==null){

        }else{
            $result->where('publication_id','=',$publicationId!==null?$publicationId:$request->id);
        }


        //if user is system admin or superadmin show results even deleted or blocked
        if($userGroup->user_group_name!='SystemAdmin' &&
            $userGroup->user_group_name!='SuperAdmin' &&
            $userGroup->user_group_name!='Employee'  &&
            $userGroup->user_group_name!='SubEmployee'
        ){
            Log::info('blocked1');
            $result->where('headline_removed','!=',1)
                ->where('headline_blocked','!=',1);
                /*->where('headlines.release_date','=',Carbon::today())
                ->where('headlines.release_time','<=',Carbon::now()->format('H:i:s'))
                ->whereRaw('headlines.release_date <= headlines.next_release')
                ->whereRaw('headlines.release_time <= headlines.next_releasetime');*/
                

        }elseif(
            $userGroup->user_group_name='Employee' || 
            $userGroup->user_group_name='SubEmployee' 
            ){

                Log::info('blocked2');

            $result->where('headline_removed','!=',1)
                    ->where('headline_blocked','!=',1);
                   /* ->where('headlines.release_date','>=',Carbon::today())
                    ->whereRaw('headlines.release_date <= headlines.next_release')
                    ->whereRaw('headlines.release_time <= headlines.next_releasetime');*/
                    
        }else{
            Log::info('blocked3');
           /* $result->where('headlines.release_date','>=',Carbon::today())
            ->whereRaw('headlines.release_date <= headlines.next_release')
            ->whereRaw('headlines.release_time <= headlines.next_releasetime');*/
        }


        $data=$result->select('publication.*','perspective.*','headlinesrating.*','headlines.*','headlines.release_date as headlineRelease')
            ->get();

        $this->headlines=$data;

    }



    public function create(Request $request){

        $publication=Publication::where('id','=',$request->publication_id)
            ->first();


        if($publication->daily===1){

            $this->release_date= Carbon::tomorrow()->setTimeFromTimeString($publication->release_date);

            $this->next_release=Carbon::parse($this->release_date)->addDays(1);


            $numberOfHeadlines=Headline::where('publication_id','=',$request->publication_id)
                ->where('release_date','=', $this->release_date)
                ->count();


            if($numberOfHeadlines>=$publication->maximum_headlines){

                return response()->json(['error' => 'Sorry Maximum headlines reached'], 404);

            }


        }elseif($publication->weekly!=0){
            $weeklyDays=[
                '1'=>'sunday',
                '2'=>'monday',
                '3'=>'tuesday',
                '4'=>'wednesday',
                '5'=>'thursday',
                '6'=>'friday',
                '7'=>'saturday'
            ];

            $selectedDay=$publication->weekly;

            $this->release_date=Carbon::parse('next '.$weeklyDays[$selectedDay])->setTimeFromTimeString($publication->release_date);
            $this->next_release=Carbon::parse($this->release_date)->addWeek(1);

            $numberOfHeadlines=Headline::where('publication_id','=',$request->publication_id)
                ->where('release_date','=',$this->release_date)
                ->count();


            if($numberOfHeadlines>=$publication->maximum_headlines){

                return response()->json(['error' => 'Sorry Maximum headlines reached'], 404);

            }

        }else{

            $publicationEditionFrequency=PublicationEditionFrequency::where('publication_id','=',$request->publication_id)
                ->where('edition_dates','>',Carbon::now())
                ->first();

            $this->release_date=$publicationEditionFrequency->edition_dates;


            $publicationEditionFrequencyNext=PublicationEditionFrequency::where('publication_id','=',$request->publication_id)
                ->where('edition_dates','>',$this->release_date)
                ->first();

            $numberOfHeadlines=Headline::where('publication_id','=',$request->publication_id)
                ->where('release_date','=',$this->release_date)
                ->count();


            if($numberOfHeadlines>=$publication->maximum_headlines){

                return response()->json(['error' => 'Sorry Maximum headlines reached'], 404);

            }


            if(!empty($publicationEditionFrequencyNext)){
                $this->next_release=$publicationEditionFrequencyNext->edition_dates;

            }else{
                //if no next release date put the release date as next-release date
                $this->next_release=$publicationEditionFrequency->edition_dates;

            }

        }

        Log::info($request->release_date);

        Headline::create([
            'user_id'=>$request->user_id,
            'publication_id'=>$request->publication_id,
            'perspective_id'=>$request->perspective_id,
            'section_id'=>$request->section_id,
            'heading'=>$request->heading,
            'subheading'=>$request->sub_heading,
            'briefnote'=>$request->note,
            'image_url'=>$request->image_url,
            'release_date'=>$this->release_date,
            'release_time'=>$publication->release_date,//this is release time comes from publication db
            'next_release'=>$this->next_release,
            'next_releasetime'=>$publication->release_date//this is release time comes from publication db
        ]);
    }

    public function getAllHeadlines(Request $request){

        $this->headlines($request);
        return $this->headlines;
    }

    public function delete(Request $request){



     Headline::where('id','=',$request->headline_id)
            ->where('user_id','=',$request->user_id)
            ->where('publication_id','=',$request->publication_id)
            ->update(['headline_removed'=>1]);


     $this->headlines($request,$request->publication_id);

    return $this->headlines;



    }

    public function block(Request $request){


        if($request->unblock==null){

            Headline::where('id','=',$request->headline_id)
                ->where('publication_id','=',$request->publication_id)
                ->update(['headline_blocked'=>1]);
        }else{

            Headline::where('id','=',$request->headline_id)
                ->where('publication_id','=',$request->publication_id)
                ->update(['headline_blocked'=>0]);
        }



        $this->headlines($request,$request->publication_id);

        return $this->headlines;
    }

    public function deleteHeadlineByPublicationId($id){

        Headline::where('publication_id','=',$id)
            ->delete();
    }

    public function test(){

        return Carbon::tomorrow();
    }

    public function edit(Request $request){


       

        $result=Headline::where('id','=',$request->headline_id)
            ->update([
                'user_id'=>$request->user_id,
                'publication_id'=>$request->publication_id,
                'perspective_id'=>$request->perspective_id,
                'section_id'=>$request->section_id,
                'heading'=>$request->heading,
                'subheading'=>$request->sub_heading,
                'briefnote'=>$request->note,
                'image_url'=>$request->image_url,
            ]);

            $updatedData=Headline::where('id','=',$request->headline_id)
            ->first();

            return $updatedData;
    }
}
