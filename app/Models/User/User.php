<?php

namespace App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Models\User\SocialCredential;
use App\Models\Song\RepertoireItem;
use App\Models\Song\SetList;
use App\Models\Song\SongTag;
use App\Models\Song\Song;
use Storage;
use Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function boot()
    {

        parent::boot();

        static::created(function(User $user) {

            if (! $user->avatar) $user->generateDefaultAvatar();

        });

    }



    public function socialCredentials()
    {
        return $this->hasMany(SocialCredential::class);
    }


    public function repertoireItems()
    {
        return $this->hasMany(RepertoireItem::class);
    }


    public function generateDefaultAvatar()
    {

        $img = (new InitialAvatar())
            ->name($this->name)
            ->length(2)
            ->size(256)
            ->fontName('sans-serif')
            ->fontSize(0.5)
            ->background('#4B4B4B')
            ->color('F5F6FA')
            ->rounded()
            ->smooth()
            ->gd()
            ->generate();

        $img = $img->encode('png');

        $path = 'public/images/user/avatars/' . Str::random(20) . '.png';

        if (Storage::exists($this->avatar)) Storage::delete($this->avatar);

        Storage::put($path, $img->__toString());

        return self::update(['avatar' => $path]);

    }


    public function getAvatarAttribute()
    {

        $avatar = isset($this->attributes['avatar']) ? $this->attributes['avatar'] : false;

        if (! $avatar) return false;

        if (Str::contains($avatar, ['http://', 'https://'])) {
            $avatar = $avatar;
        } else {
            $avatar = Storage::url($avatar);
        }

        return $avatar;

    }


    public function artists()
    {

        $songs = $this->repertoireItems()
                      ->join('songs', 'repertoire_items.song_id', '=', 'songs.id')
                      ->select('songs.artist')
                      ->groupBy('songs.artist')
                      ->get();

        $artists = [];

        foreach ($songs as $song) $artists[] = $song->artist;

        return $artists;

    }


    public function tags()
    {
        return $this->hasMany(SongTag::class);
    }


    public function tagList(bool $toLower = false)
    {

        $tags = $this->tags()->get();
        $arr = [];

        foreach ($tags as $t) {

            if ($toLower) {
                $arr[] = strtolower($t->name);
            } else {
                $arr[] = $t->name;
            }

        }

        return $arr;

    }

    public function setLists()
    {
        return $this->hasMany(SetList::class);
    }

}
