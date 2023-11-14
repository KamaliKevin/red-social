<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\CommunityLink;
use App\Http\Requests\CommunityLinkForm;
use App\Queries\CommunityLinksQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Channel $channel = null):
    \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|
    \Illuminate\Contracts\Foundation\Application
    {
        $links = "";
        if(request()->exists('searchQuery')){
            $searchQuery = request()->get('searchQuery');
            if(request()->exists('popular')){
                if($channel){
                    $links = CommunityLinksQuery::getMostPopular($channel);
                }
                else {
                    $links = CommunityLinksQuery::getMostPopular();
                }
            }
            else {
                $links = CommunityLinksQuery::getBySearch($searchQuery);
            }
        }
        else if (request()->exists('popular')) {
            if($channel){
                $links = CommunityLinksQuery::getMostPopular($channel);
            }
            else {
                $links = CommunityLinksQuery::getMostPopular();
            }
        }
        else {
            if($channel){
                $links = CommunityLinksQuery::getByChannel($channel);
            }
            else {
                $links = CommunityLinksQuery::getAll();
            }
        }

        $channels = Channel::orderBy('title','asc')->get();

        return view('community/index', compact("links", "channels", "channel"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityLinkForm $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();

        $approved = (bool)Auth::user()->isTrusted();
        $data['approved'] = $approved;


        // Send the flash message:
        $communityLink = new CommunityLink;

        $linkWasSubmitted = $communityLink->hasAlreadyBeenSubmitted($data['link']);
        $linkWasApproved = $communityLink->hasAlreadyBeenApproved($data['link']);

        return $communityLink->sendLinkFormResult($data['link'], $linkWasSubmitted,
        $approved, $linkWasApproved, $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
