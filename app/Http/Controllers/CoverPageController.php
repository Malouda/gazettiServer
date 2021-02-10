<?php

namespace App\Http\Controllers;

use App\CoverPage;
use App\Group;
use App\Publication;
use App\PublicationEditionFrequency;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class CoverPageController extends Controller
{
    private $coverpages;
    private $release_date;
    private $next_release;


    public function coverPages($request,$publicationId=null){
        $user=User::where('id','=',$request->user()->id)->first();
        $userGroup=Group::where('id','=',$user->user_group_id)->first();


        $result=DB::table('coverpage')
            ->join('perspective','coverpage.perspective_id','=','perspective.id')
            ->join('publication','coverpage.publication_id','=','publication.id')
            ->where('publication_id','=',$publicationId!==null?$publicationId:$request->id);

        if($userGroup->user_group_name!='SystemAdmin' &&
            $userGroup->user_group_name!='SuperAdmin' &&
            $userGroup->user_group_name!='Employee'
        ){

            $result->where('cover_page_removed','!=',1)
                ->where('cover_page_blocked','!=',1);
               /* ->where('coverpage.release_date','>=',Carbon::today())
                ->where('coverpage.release_time','<=', Carbon::now()->format('H:i:s'))
                ->whereRaw('coverpage.release_date <= coverpage.next_release')
                ->whereRaw('coverpage.release_time <= coverpage.next_releasetime');*/
                

        }elseif($userGroup->user_group_name='Employee' && 
                $userGroup->user_group_name='SubEmployee' 
         ){
            $result->where('cover_page_removed','!=',1)
            ->where('cover_page_blocked','!=',1);
          /*  ->where('coverpage.release_date','>=',Carbon::today());*/

        }else{

           /* $result->where('coverpage.release_date','>=',Carbon::today());*/
        }


        $data=$result->select('publication.*','perspective.*','coverpage.*')
            ->get();

        $this->coverpages=$data;
    }

    public function create(Request $request){


        $publication=Publication::where('id','=',$request->publication_id)
            ->first();


        if($publication->daily===1){
            $this->release_date= Carbon::tomorrow();
            $this->next_release=Carbon::parse($this->release_date)->addDays(1);

            $publication=Publication::where('id','=',$request->publication_id)
                ->first();

            $numberOfCoverpages=CoverPage::where('publication_id','=',$request->publication_id)
                ->where('release_date','=', $this->release_date)
                ->count();


            if($numberOfCoverpages>=1){

                return response()->json(['error' => 'Sorry Maximum Coverpages reached'], 404);

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

            $publication=Publication::where('id','=',$request->publication_id)->first();
            $selectedDay=$publication->weekly;

            $this->release_date=Carbon::parse('next '.$weeklyDays[$selectedDay])->toDateString();
            $this->next_release=Carbon::parse($this->release_date)->addWeek(1);

            $publication=Publication::where('id','=',$request->publication_id)
                ->first();

            $numberOfCoverpages=CoverPage::where('publication_id','=',$request->publication_id)
                ->where('release_date','=', $this->release_date)
                ->count();


            if($numberOfCoverpages>=1){

                return response()->json(['error' => 'Sorry Maximum Coverpages reached'], 404);

            }


        }else{

            $publicationEditionFrequency=PublicationEditionFrequency::where('publication_id','=',$request->publication_id)
                ->where('edition_dates','>',Carbon::now())
                ->first();

            $this->release_date=$publicationEditionFrequency->edition_dates;

            $publication=Publication::where('id','=',$request->publication_id)
                ->first();

            $numberOfCoverpages=CoverPage::where('publication_id','=',$request->publication_id)
                ->where('release_date','=', $this->release_date)
                ->count();


            if($numberOfCoverpages>=1){

                return response()->json(['error' => 'Sorry Maximum Coverpages reached'], 404);

            }



            $publicationEditionFrequencyNext=PublicationEditionFrequency::where('publication_id','=',$request->publication_id)
                ->where('edition_dates','>',$this->release_date)
                ->first();


            if(!empty($publicationEditionFrequencyNext)){
                $this->next_release=$publicationEditionFrequencyNext->edition_dates;

            }else{
                $this->next_release=$publicationEditionFrequency->edition_dates;

            }

        }



       CoverPage::create([
            'user_id'=>$request->user_id,
            'publication_id'=>$request->publication_id,
            'perspective_id'=>$request->perspective_id==null?$publication->perspective_id:$request->perspective_id,
            'cover_page_url'=>$request->img_url,
            'release_date'=>$this->release_date,
            'release_time'=>$publication->release_date, //this should be release time from publication table remember to change
            'next_release'=>$this->next_release,
            'next_releasetime'=>$publication->release_date //this should be release time from publication table remember to change
        ]);
    }


    public function getAllCoverPages(Request $request){

        $this->coverPages($request);

        return $this->coverpages;

    }

    public function delete(Request $request){

        Log::info($request);

       if($request->unDelete===null){
            CoverPage::find($request->id)
                ->update(["cover_page_removed"=>1]);
        }else{
            CoverPage::find($request->id)
                ->update(["cover_page_removed"=>0]);
        }


        $this->coverPages($request,$request->publication_id);

        return $this->coverpages;
    }

    public function block(Request $request){


        if($request->unBlock===null){
            CoverPage::find($request->id)
                ->update(["cover_page_blocked"=>1]);
        }else{
            CoverPage::find($request->id)
                ->update(["cover_page_blocked"=>0]);
        }


        $this->coverPages($request,$request->publication_id);

        return $this->coverpages;
    }

    public function deleteCoverPageByPublicationId($id){


        CoverPage::where('publication_id','=',$id)
            ->delete();

    }

    public function edit(Request $request){


        CoverPage::find($request->coverPageID)
            ->update(['cover_page_url'=>$request->imgUrl]);
    }
}
