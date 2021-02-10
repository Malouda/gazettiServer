<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Mail\CommentSendToPublisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CommentController extends Controller
{

    public function create(Request $request){

        Comment::create([
           'user_id'=>$request->user_id,
           'headline_id'=>$request->headline_id,
           'comment'=>$request->comment
        ]);

        return $this->getComments($request->headline_id);
    }

    public function getComments($headlineId){

        $result=DB::table('comments')
            ->join('users','comments.user_id','users.id')
            ->join('user_groups','users.user_group_id','user_groups.id')
            ->join('headlines','comments.headline_id','headlines.id')
            ->join('publication','publication.id','headlines.publication_id')
            ->where('headline_id',$headlineId)
            ->select('users.fname','users.lname','user_groups.*','publication.*','headlines.*','headlines.publication_id as publicationID','comments.*')
            ->get();

            Log::info($result);

            return $result;
    }

    public function getCommentsFromRequest(Request $request){


       return $this->getComments($request->headline_id);
    }

    public function sendCommentsToPublisher(){

        // $result=\Maatwebsite\Excel\Facades\Excel::create('comments', function($excel) {

        //     $excel->sheet('comments', function($sheet) {
        //         $sheet->setOrientation('landscape');
        //     });

        // })->store('xls',storage_path('exports/comments'),true);

        // $email=new CommentSendToPublisher($result['full']);

        // Mail::to('deomwilanga@gmail.com')->send($email);

        return Carbon::now()->format('H:i');
    }
}
