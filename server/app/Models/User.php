<?php

declare(strict_types = 1);

namespace App\Models;

use App\Contracts\JwtSubjectInterface;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $username
 * @property string|null $bio
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
final class User extends Authenticatable implements JwtSubjectInterface
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use Notifiable;
    use Sluggable;

    /**
     * Regular expression for username.
     */
    public const REGEX_USERNAME = '/^[\pL\pM\pN._@-]+$/u';

    public const REGEX_IMAGE = '/\.(jpg|jpeg|png)$/i';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'image',
        'google_id',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * The default attributes value.
     */
    protected $attributes = [
        'bio'   => '',
        'image' => '',
    ];

    public function sluggable(): array
    {

        return [
            'username' => [
                'source'    => ['firstname'],
                'separator' => '@',
            ],
        ];
    }

    public function getFirstNameAttribute(): string
    {
        $name = explode(" ", $this->name);
        $firstname = $name[0];

        if (mb_strlen($firstname) <= 3) {
            return $name[0] . ' ' . $name[1];
        }

        return $firstname;

    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username', 'bio', 'image']) //Caso precise adicionar algum outro parâmetro é aqui
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('User')
            ->setDescriptionForEvent(fn (string $eventName) => $this->getDescriptionForEvent($eventName));
    }

    protected function getDescriptionForEvent(string $eventName): string
    {
        $userName = $this->username ?? 'Desconhecido';

        return match ($eventName) {
            'created' => "Uma nova conta foi criada, com username '{$userName}' e id '{$this->id}'.",
            'updated' => "O usuário '{$userName}' atualizou seu perfil",
            'deleted' => "O usuário '{$userName}' excluiu sua conta",
            default   => "O usuário '{$userName}' realizou uma ação desconhecida (ação/evento: {$eventName})"
        };
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',

        ];
    }

    public function getJwtIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Determine if user is following an author.
     *
     * @param User $author
     * @return bool
     */
    public function following(User $author): bool
    {
        return $this->authors()
            ->whereKey($author->getKey())
            ->exists();
    }

    /**
     * Determine if author followed by a user.
     *
     * @param User $follower
     * @return bool
     */
    public function followedBy(User $follower): bool
    {
        return $this->followers()
            ->whereKey($follower->getKey())
            ->exists();
    }

    /**
     * The authors that the user follows.
     *
     * @return BelongsToMany<User>
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_follower', 'author_id', 'follower_id');
    }

    /**
     * The followers of the author.
     *
     * @return BelongsToMany<User>
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_follower', 'follower_id', 'author_id');
    }

    /**
     * Get the comments of the user.
     *
     * @return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    /**
     * Get user written articles.
     *
     * @return HasMany<Article>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    /**
     * Get user favorite articles.
     *
     * @return BelongsToMany<Article>
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_favorite');
    }
}
