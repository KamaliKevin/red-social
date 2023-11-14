<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    /**
     * Consigue todos los enlaces
     */
    public static function getAll()
    {
        return CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
    }

    /**
     * Consigue los enlaces según el término de búsqueda
     * @param $searchQuery - Valor del término de búsqueda
     */
    public static function getBySearch($searchQuery){
        $trimmedSearchQuery = trim($searchQuery);

        return CommunityLink::where('approved', 1)
            ->where(function ($query) use ($trimmedSearchQuery) {
                $query->where('title', 'like', "%$trimmedSearchQuery%")
                    ->orWhere('link', 'like', "%$trimmedSearchQuery%");
            })
            ->latest('updated_at')->paginate(25);
    }

    /**
     * Consigue los enlaces según el canal
     * @param Channel $channel - El canal por el que filtrar
     */
    public static function getByChannel(Channel $channel): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $channel->communityLinks()->where('approved', 1)
            ->latest('updated_at')->paginate(25);
    }

    /**
     * Consigue los links más populares (orden descendiente), incluso en una búsqueda.
     * Da la posibilidad de filtrar también por canal
     * @param Channel|null $channel - El canal por el que filtrar
     */
    public static function getMostPopular(Channel $channel = null)
    {
        if(request()->exists('searchQuery')){
            $searchQuery = request()->get('searchQuery');
            if($channel){
                return $channel->communityLinks()->where('approved', 1)
                    ->where(function ($query) use ($searchQuery) {
                        $query->where('title', 'like', "%$searchQuery%")
                            ->orWhere('link', 'like', "%$searchQuery%");
                    })
                    ->withCount('users')
                    ->orderBy('users_count', 'desc')
                    ->latest('updated_at')->paginate(25);
            }
            else {
                return CommunityLink::where('approved', 1)
                    ->where(function ($query) use ($searchQuery) {
                        $query->where('title', 'like', "%$searchQuery%")
                            ->orWhere('link', 'like', "%$searchQuery%");
                    })
                    ->withCount('users')
                    ->orderBy('users_count', 'desc')
                    ->latest('updated_at')->paginate(25);
            }
        }
        else if($channel){
            return $channel->communityLinks()->where('approved', 1)
                ->withCount('users')
                ->orderBy('users_count', 'desc')
                ->latest('updated_at')->paginate(25);
        }
        else {
            return CommunityLink::where('approved', 1)
                ->withCount('users')
                ->orderBy('users_count', 'desc')
                ->latest('updated_at')->paginate(25);
        }
    }
}
