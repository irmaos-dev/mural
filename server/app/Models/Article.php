<?php

declare(strict_types = 1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $author_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favoredUsers
 * @property-read int|null $favored_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\ArticleFactory factory(...$parameters)
 * @method static Builder|Article favoredByUser(string $username)
 * @method static Builder|Article followedAuthorsOf(\App\Models\User $user)
 * @method static Builder|Article havingTag(string $tag)
 * @method static Builder|Article list(int $take, int $skip)
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article ofAuthor(string $username)
 * @method static Builder|Article query()
 * @method static Builder|Article whereAuthorId($value)
 * @method static Builder|Article whereBody($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDescription($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereSlug($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Article extends Model
{
    use HasFactory;
    use LogsActivity;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'body',
        'image',
    ];

    /**
     * The attributes that should be appended to the model.
     */
    protected $appends = [
        'tagList',
    ];

    public function sluggable(): array
    {

        return [
            'slug' => [
                'source'   => ['title'],
                'onUpdate' => true,
            ],
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->LogOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Article')
            ->setDescriptionForEvent(fn (string $eventName) => $this->getDescriptionForEvent($eventName));
    }

    protected function getDescriptionForEvent(string $eventName): string
    {
        $userName = auth()->user()->name ?? 'Desconhecido';
        $userId = auth()->id();
        $userOrAdmin = $this->author_id === $userId ? 'pelo próprio dono do artigo:' : 'pelo admin: ';

        return match ($eventName) {
            'created' => "Um novo artigo foi criado. Id: '{$this->id}'.",
            'updated' => "O artigo '{$this->title}' de id '{$this->id}' foi atualizado {$userOrAdmin} {$userName}.",
            'deleted' => "O artigo '{$this->title}' de id '{$this->id}' foi excluído {$userOrAdmin} {$userName}.",
            default   => "O artigo '{$this->title}' de id '{$this->id}' teve uma ação desconhecida. (ação/evento: {$eventName})"
        };
    }

    /**
     * Determine if user favored the article.
     *
     * @param User $user
     * @return bool
     */
    public function favoredBy(User $user): bool
    {
        return $this->favoredUsers()
            ->whereKey($user->getKey())
            ->exists();
    }

    /**
     * Scope article list.
     *
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param int $take
     * @param int $skip
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeList(Builder $query, int $take, int $skip): Builder
    {
        return $query->latest()
            ->limit($take)
            ->offset($skip);
    }

    /**
     * Scope articles having a tag.
     *
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param string $tag
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeHavingTag(Builder $query, string $tag): Builder
    {
        return $query->whereHas(
            'tags',
            fn (Builder $builder) => $builder->where('name', $tag)
        );
    }

    /**
     * Scope to article author.
     *
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeOfAuthor(Builder $query, string $username): Builder
    {
        return $query->whereHas(
            'author',
            fn (Builder $builder) => $builder->where('username', $username)
        );
    }

    /**
     * Scope articles to favored by a user.
     *
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeFavoredByUser(Builder $query, string $username): Builder
    {
        return $query->whereHas(
            'favoredUsers',
            fn (Builder $builder) => $builder->where('username', $username)
        );
    }

    /**
     * Scope articles to author's of a user.
     *
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeFollowedAuthorsOf(Builder $query, User $user): Builder
    {
        return $query->whereHas(
            'author',
            fn (Builder $builder) => $builder->whereIn('id', $user->authors->pluck('id'))
        );
    }

    /**
     * Attach tags to article.
     *
     * @param array<string> $tags
     */
    public function syncTags(array $tags, array $oldTags = null): void
    {
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate([
                'name' => $tagName,
            ]);

            $tagIds[] = $tag->id;
        }
        $this->tags()->sync($tagIds);

        $properties = [
            'tags' => $tags,
        ];

        if (null !== $oldTags) {
            $properties['old_tags'] = $oldTags;
        }

        activity('ArticleTags')
            ->performedOn($this)
            ->withProperties($properties)
            ->log('Tags anexadas ao artigo de id: ' . $this->id);
    }

    /**
     * Article author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Article tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Tag>
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the comments for the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment>
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get users favored the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function favoredUsers()
    {
        return $this->belongsToMany(User::class, 'article_favorite');
    }

    /**
     * Get the tag list attribute.
     *
     * @return array<string>
     */
    public function getTagListAttribute(): array
    {
        return $this->tags->pluck('name')->toArray();

    }
}
