<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
      微博删除策略
      微博作者与当前用户一致时，允许删除微博
     */
    public function destroy(User $currentUser, Status $status)
    {
        return $currentUser->id === $status->user_id;
    }
}
