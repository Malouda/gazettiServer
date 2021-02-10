<?php

namespace App\Http\Controllers;

use App\HeadlineRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{


    public function rate(Request $request){


        $comment=HeadlineRating::where('headline_id','=',$request->headline_id)
            ->where('user_id','=',$request->user_id)->first();

        if(empty($comment)){
            HeadlineRating::create([
                'user_id'=>$request->user_id,
                'headline_id'=>$request->headline_id,
                'like'=>$request->likeit,
                'mixedThoughts'=>$request->mixed,
                'dontLike'=>$request->nolike
            ]);

        }else{
            HeadlineRating::where('headline_id','=',$request->headline_id)
                ->update([
                    'user_id'=>$request->user_id,
                    'headline_id'=>$request->headline_id,
                    'like'=>$request->likeit,
                    'mixedThoughts'=>$request->mixed,
                    'dontLike'=>$request->nolike
                ]);
        }

    }
}
