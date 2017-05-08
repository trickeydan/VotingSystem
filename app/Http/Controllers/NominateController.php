<?php

namespace App\Http\Controllers;

use App\Http\Requests\NominateRequest;
use App\Nomination;
use App\System;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class NominateController extends Controller
{
    /**
     * Nominate someone for a category.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nominate(){
        $user = Auth::User();
        $category = $user->getNominationCategory();
        $list = System::getNominatableArray();
        $nominations = Nomination::whereUserId($user->id)->get();
        return view('nominate',compact('category','list','nominations'));
    }

    /**
     * Perform a nomination
     *
     * @param NominateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function nominatePost(NominateRequest $request){
        $user = Auth::User();
        if(Nomination::whereCategoryId($request->category)->whereUserId($user->id)->count() > 0) return redirect(route('nominate'))->withErrors('You have already nominated someone for that category!');
        if(User::find($request->chosen)->admin) return redirect(route('nominate'))->withErrors('You cannot nominate an administrator!');
        Nomination::create([
            'user_id' => $user->id,
            'nominee_id' => $request->chosen,
            'category_id' => $request->category,
        ]);
        return redirect(route('nominate'));
    }
}
