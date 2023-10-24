<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommunityLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'channel_id', 'title', 'link', 'approved'
    ];

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_link_users');
    }

    /**
     * Gets data of the specified link (if it does exist)
     */
    public function getExistingLinkData($link)
    {
        if($data = static::where('link', $link)->first()){
            // The link exists, so we return the data:
            return $data;
        }
        // The link does NOT exist, so we do not return anything:
        return null;
    }

    /**
     * Check if the link has been sent before
     */
    public function hasAlreadyBeenSubmitted($link): bool
    {
        $exists = static::getExistingLinkData($link);
        if ($exists) {
            return true;
        }
        return false;
    }


    /**
     * Check if the link has been approved before
     */
    public function hasAlreadyBeenApproved($link): bool
    {
        if(static::hasAlreadyBeenSubmitted($link)){
            // The link exists:
            if($data = static::getExistingLinkData($link)){
                // Data for the link are retrieved:
                if($data['approved'] == 1){
                    // The link has been approved before:
                    return true;
                }
                // The link has NOT been approved before:
                return false;
            }
            // Data for the link cannot be retrieved:
            return false;
        }
        // The link does NOT exist:
        return false;
    }

    /**
     * Sends a fitting flash message for the link form result
     */
    public function sendLinkFormResult($link, $linkWasSubmitted, $userIsTrusted, $linkWasApproved, $data = null):
    \Illuminate\Http\RedirectResponse
    {
        if($linkWasSubmitted){
            $data = static::getExistingLinkData($link);

            // The link was sent before, so we don't create it and handle the case accordingly:
            if($userIsTrusted){
                // If the link was approved before, we should show a warning message:
                $data->touch(); // We update the link's update timestamp
                $data->save(); // We save the new link's update timestamp
                return back()->with('warning', 'This link has already been created and published before.
                We updated the link\'s update timestamp.');
            }
            else {
                if($linkWasApproved){
                    // If the link was not approved before, we should show an error message:
                    return back()->with('error', 'This link has already been created and published');
                }
                else {
                    // If the link was not approved before, we should show a warning message:
                    $data->touch(); // We update the link's update timestamp
                    $data->save(); // We save the new link's update timestamp
                    return back()->with('warning', 'This link has already been created, but not published.
                    Publication still needs our admin\'s approval. We updated the link\'s update timestamp.');
                }
            }
        }
        else {
            // The link is new, so we create it:
            static::create($data);

            if($userIsTrusted){
                // If the link is approved, we should show a successful message:
                return back()->with('success', 'Your link has been created and published.');
            }
            else {
                // If the link is not approved, we should show a warning message:
                return back()->with('warning', 'Your link has been created,
                but you need to wait until our admin approves it to be published.');
            }
        }
    }
}
