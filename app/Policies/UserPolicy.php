<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
/*    public function __construct()
    {
        //
    }*/


    /**
      用户编辑更新策略
      未登录用户可以访问 edit 和 update 动作；
      登录用户可以更新其它用户的个人信息；
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
      用户删除策略
      管理员用户可以删除其它用户的个人信息；
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }


    /**
      用户关注策略
      用户不能关注自己；
     */
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
