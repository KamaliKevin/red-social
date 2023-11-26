<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityLinkForm;
use App\Models\CommunityLink;
use App\Queries\CommunityLinksQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $links = "";
        if(request()->exists('text')){
            $text = request()->get('text');
            $links = CommunityLinksQuery::getBySearch($text);
        }
        else if(request()->exists('popular')){
            $links = CommunityLinksQuery::getMostPopular();
        }
        else {
            $links = CommunityLinksQuery::getAll();
        }
        return response()->json(['Links' => $links], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityLinkForm $request): \Illuminate\Http\JsonResponse
    {
        if($request->validated()){
            $data = $request->all();
            $data['user_id'] = Auth::id();
            CommunityLink::create($data);

            return response()->json(['message' => "Your link will be reviewed for the administrator before publishing.
            Thank you for your contribution."], 201);
        }
        return response()->json(['message' => "Validation failed for your link. Please, make sure all fields are correct"], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
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
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $communityLink = CommunityLink::findOrFail($id);

        // Check if the authenticated user owns the community link:
        if (auth()->user()->id !== $communityLink->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the resource
        $communityLink->delete();

        return response()->json(['message' => 'Community link deleted successfully'], 200);
    }
}
