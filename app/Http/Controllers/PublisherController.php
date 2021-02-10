<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use  Carbon\Carbon;

class PublisherController extends Controller
{

    public function create(Request $request){


        Log::info($request);

        Publisher::create([
            'publisher_name'=>$request->publisher_name,
            'location_id'=>$request->location_id,
            'email'=>$request->publisher_email,
            'publisher_phone'=>$request->publisher_phone,
            'maximum_employees'=>$request->maximum_employees,
            'account_expiry'=>Carbon::parse($request->expiryDate),
            'status'=>$request->account_status,
            'logo_url'=>$request->logo_url,
        ]);
    }

    public function getAllPublishers(){
        return DB::table('publisher')
            ->join('location','location.id','=','publisher.location_id')
            ->select('location.*','publisher.*')
            ->get();
    }


    public function edit(Request $request){

        Publisher::find($request->publisher_id)
            ->update([
                'publisher_name'=>$request->publisher_name,
                'location_id'=>$request->location_id,
                'email'=>$request->publisher_email,
                'publisher_phone'=>$request->publisher_phone,
                'maximum_employees'=>$request->maximum_employees,
                'account_expiry'=>Carbon::parse($request->expiryDate),
                'status'=>$request->account_status,
                'logo_url'=>$request->logo_url,
            ]);

        return $this->getAllPublishers();

    }


    public function delete(Request $request,PublicationController $publicationController,HeadlineController $headlineController,CoverPageController $coverPageController){

        $publications=$publicationController->getPublicationsByPublisherId($request->publisher_id);

        foreach ($publications as $publication){

            Log::info($publication->id);
            //delete all headlines of this publication
            $headlineController->deleteHeadlineByPublicationId($publication->id);

            //delete all coverpages of this publication
            $coverPageController->deleteCoverPageByPublicationId($publication->id);

        }

        Publisher::find($request->publisher_id)->delete();


        return $this->getAllPublishers();
    }
}
