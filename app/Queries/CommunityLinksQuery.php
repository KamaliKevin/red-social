<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    /**
     * Consigue los enlaces según el canal
     * @param Channel $channel El canal por el que filtrar
     */
    public static function getByChannel(Channel $channel): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $channel->communityLinks()->where('approved', 1)
            ->latest('updated_at')->paginate(25);
    }

    /**
     * Consigue todos los enlaces
     */
    public static function getAll()
    {
        return CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
    }

    /**
     * Consigue los links más populares (orden descendiente).
     * Da la posibilidad de filtrar también por canal
     * @param Channel|null $channel El canal por el que filtrar
     */
    public static function getMostPopular(Channel $channel = null)
    {
        if($channel){
            return $channel->communityLinks()->where('approved', 1)->withCount('users')
                ->orderBy('users_count', 'desc')
                ->latest('updated_at')->paginate(25);
        }
        else {
            return CommunityLink::where('approved', 1)->withCount('users')
                ->orderBy('users_count', 'desc')
                ->latest('updated_at')->paginate(25);
        }
    }
}
