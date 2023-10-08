<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $links = CommunityLink::where('approved', 1)->paginate(25);
        $channels = Channel::orderBy('title','asc')->get();
        return view('community/index', compact("links", "channels"));
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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'link' => 'required|unique:community_links|url|max:255',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $data['user_id'] = Auth::id();

        $approved = (bool)Auth::user()->isTrusted();
        $data['approved'] = $approved;

        // $data['channel_id'] = 1;

        CommunityLink::create($data);

        if($data['approved']){
            // If the link is approved, we should show a successful message:
            return back()->with('success', 'Your link has been created and published');
        }
        else {
            // If the link is not approved, we should show a warning message:
            return back()->with('warning', 'Your link has been created,
            but you need to wait until our admin approves it to be published');
        }
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
