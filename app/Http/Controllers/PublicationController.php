<?php

namespace App\Http\Controllers;

use App\Publication;
use App\PublicationEditionFrequency;
use App\Publisher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use  Carbon\Carbon;
use App\Http\Controllers\HeadlineController;
use App\Http\Controllers\CoverPageController;
use App\Http\Controllers\UserController;

class PublicationController extends Controller
{


    public function getAllPublications(Request $request){


        $user=User::where('id','=',$request->user()->id)->first();



        if($user->publication_id!=null){
            return DB::table('publication')
                ->join('type','publication.type_id','type.id')
                ->join('publisher','publication.publisher_id','publisher.id')
                ->join('language','publication.language_id','language.id')
                ->join('perspective','publication.perspective_id','perspective.id')
                ->where('publication.id','=',$user->publication_id)
                ->select('publisher.*','type.*','language.*','perspective.*','publication.*')
                ->get();

        }elseif($user->publisher_id!=null){

            return DB::table('publication')
                ->join('type','publication.type_id','type.id')
                ->join('publisher','publication.publisher_id','publisher.id')
                ->join('language','publication.language_id','language.id')
                ->join('perspective','publication.perspective_id','perspective.id')
                ->where('publication.publisher_id',"=",$user->publisher_id)
                ->select('publisher.*','type.*','language.*','perspective.*','publication.*')
                ->get();
        }else{
            return DB::table('publication')
                ->join('type','publication.type_id','type.id')
                ->join('publisher','publication.publisher_id','publisher.id')
                ->join('language','publication.language_id','language.id')
                ->join('perspective','publication.perspective_id','perspective.id')
                ->select('publisher.*','type.*','language.*','perspective.*','publication.*')
                ->get();

        }


    }

    public function getPublicationForReading(){

        return DB::table('publication')
            ->join('type','publication.type_id','type.id')
            ->join('publisher','publication.publisher_id','publisher.id')
            ->join('language','publication.language_id','language.id')
            ->join('perspective','publication.perspective_id','perspective.id')
            ->select('publisher.*','type.*','language.*','perspective.*','publication.*')
            ->get();
    }

    public function create(Request $request){


        $result=Publication::create([
            'publication_name'=>$request->publicationName,
            'publisher_id'=>$request->publisher,
            'type_id'=>$request->type_id,
            'language_id'=>$request->language_id,
            'perspective_id'=>$request->perspective_id,
            'daily'=>$request->daily? 1:0,
            'weekly'=>$request->weekly? $request->selectedDay:0,
            'description'=>$request->description,
            'maximum_headlines'=>$request->maximumHeadlines,
            'minimum_headlines'=>$request->minimumHeadlines,
            'logo_url'=>$request->logo_url,
            'publication_email'=>$request->notification_email,
            'release_date'=>Carbon::parse($request->time)->toTimeString()
        ]);


        if(!empty($request->otherDates)){
            $otherDates=$request->otherDates;

            foreach ($otherDates as $key=>$otherDate){
                PublicationEditionFrequency::create([
                    'publication_id'=>$result->id,
                    'edition_dates'=>Carbon::parse($otherDates['date0'].' '.$request->time)
                ]);
            }
        }
    }

    public function getPublicationsByPublisherId($id){

        return Publication::where('publisher_id','=',$id)
            ->get();
    }

    public function deletePublicationFromRequest(Request $request,HeadlineController $headlineController,CoverPageController $coverPageController,UserController $usercontroller){

        //first delete all headlines of this publication

        $headlineController->deleteHeadlineByPublicationId($request->publication_id);
        
        //delete all coverpages of this publication

        $coverPageController->deleteCoverPageByPublicationId($request->publication_id);

        //all users of this publication will be deleted

        $usercontroller->deleteUserByPublicationId($request->publication_id);

        //delete the publication
        Log::info('kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk');
        
        $this->deletePublication($request->publication_id);


        return $this->getAllPublications($request);
}

    public function deletePublication($id){

        $publication=Publication::find($id)->delete();
    }

    public function filterPublication(Request $request){

        $result=DB::table('publication')
            ->join('type','publication.type_id','type.id')
            ->join('language','publication.language_id','language.id')
            ->join('perspective','publication.perspective_id','perspective.id')
            ->join('publisher','publication.publisher_id','publisher.id');

        if($request->newspaper==true && $request->magazine==false) {

            $result->where('type.type_name', '=', 'Newspaper');
        }elseif ($request->magazine==true && $request->newspaper==false){
            $result->where('type.type_name','=','Magazine');
        }

        if($request->kiswahili==true && $request->english==false){
            $result->where('language.language_name','=','Swahili');
        }elseif($request->english==true && $request->kiswahili==false){
            $result->where('language.language_name','=','English');
        }

        if($request->politics==true && $request->lifeStyle==false && $request->sports==false && $request->religion==false){
            $result->where('perspective.perspective_name','=','Politics');
        }elseif($request->politics==false && $request->lifeStyle==true && $request->sports==false && $request->religion==false){
            $result->where('perspective.perspective_name','=','Lifestyle');
        }elseif($request->politics==false && $request->lifeStyle==false && $request->sports==true && $request->religion==false){
            $result->where('perspective.perspective_name','=','Sports');
        }elseif($request->politics==false && $request->lifeStyle==false && $request->sports==false && $request->religion==true){
            $result->where('perspective.perspective_name','=','Religion');
        }

        $data=$result->select('type.*','publisher.*','language.*','perspective.*','publication.*')->get();

        return $data;
    }


    public function sortPublication(Request $request){

        $result=DB::table('publication')
            ->join('type','publication.type_id','type.id')
            ->join('language','publication.language_id','language.id')
            ->join('perspective','publication.perspective_id','perspective.id')
            ->join('publisher','publication.publisher_id','publisher.id');


        if($request->priority1!=0 && $request->priority2==0 && $request->priority3==0){

            $result->where('publication.id',$request->priority1);

        }elseif ($request->priority1==0 && $request->priority2!=0 && $request->priority3==0){

            $result->where('publication.id',$request->priority2);

        }elseif ($request->priority1==0 && $request->priority2==0 && $request->priority3!=0){

            $result->where('publication.id',$request->priority3);

        }elseif($request->priority1!=0 && $request->priority2!=0 && $request->priority3==0){

            $result->whereIn('publication.id',[$request->priority1,$request->priority2]);

        }elseif($request->priority1!=0 && $request->priority2==0 && $request->priority3!=0){

            $result->whereIn('publication.id',[$request->priority1,$request->priority3]);

        }elseif($request->priority1==0 && $request->priority2!=0 && $request->priority3!=0){

            $result->whereIn('publication.id',[$request->priority2,$request->priority3]);
        }

        if($request->alphaBetically){
            $result->orderBy('publication_name', 'desc');
        }

        $data=$result->select('type.*','publisher.*','language.*','perspective.*','publication.*')->get();


        return $data;
    }


    public function edit(Request $request){

        Publisher::find($request->publication_id)
            ->update(
                [
                    'publication_name'=>$request->publicationName,
                    'publisher_id'=>$request->publisher,
                    'type_id'=>$request->type_id,
                    'language_id'=>$request->language_id,
                    'perspective_id'=>$request->perspective_id,
                    'daily'=>$request->daily? 1:0,
                    'weekly'=>$request->weekly? $request->selectedDay:0,
                    'description'=>$request->description,
                    'maximum_headlines'=>$request->maximumHeadlines,
                    'minimum_headlines'=>$request->minimumHeadlines,
                    'logo_url'=>$request->logo_url,
                    'publication_email'=>$request->notification_email,
                ]
            );



        if(!empty($request->otherDates)){
            $otherDates=$request->otherDates;

            PublicationEditionFrequency::where('publication_id',$request->publication_id)->delete();

            foreach ($otherDates as $key=>$otherDate){
                PublicationEditionFrequency::create([
                    'publication_id'=>$request->publication_id,
                    'edition_dates'=>Carbon::parse($otherDates['date0'].' '.$request->time)
                ]);
            }
        }
    }
}
