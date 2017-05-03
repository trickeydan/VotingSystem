<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Vote;

class VoteController extends Controller
{
    /**
     * Cast a vote
     *
     * @return View
     */
    public function vote(){
        $user = Auth::User();
        $category = $user->getVoteCategory();
        $votes = Vote::whereUserId($user->id)->get();
        if($category === false) return view('vote',compact('category','votes'));

        $list = $category->getVotableArray();
        return view('vote',compact('category','list'));
    }

    public function votePost(VoteRequest $request){
        $user = Auth::User();
        if(Vote::whereCategoryId($request->category)->whereUserId($user->id)->count() > 0) return redirect(route('vote'))->withErrors('You have already voted in that category!');
        if(User::find($request->chosen)->admin) return redirect(route('vote'))->withErrors('You cannot vote for an administrator!');
        //Todo: Check if is nominee
        Vote::create([
            'user_id' => $user->id,
            'votee_id' => $request->chosen,
            'category_id' => $request->category,
        ]);
        return redirect(route('vote'));
    }
}
