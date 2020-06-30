<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //dd($photo. 'elimina foto');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function view(User $user, Photo $photo)
    {
        dd($photo. 'vedere  foto');
        return $user->id === $photo->$album->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(Photo $user)
    {
        return true; //NON POSSO PASSARGLI L'ALBUM
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function update(User $user, Photo $photo)
    {
        dd($photo. 'modifica foto');
        return $user->id === $photo->$album->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function delete(User $user, Photo $photo)
    {
        dd($photo. 'elimina foto');

        return $user->id === $photo->$album->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function restore(User $user, Photo $photo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function forceDelete(User $user, Photo $photo)
    {
        //
    }
}
