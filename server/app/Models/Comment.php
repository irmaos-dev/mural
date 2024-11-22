<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $article_id
 * @property int $author_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Article $article
 * @property-read User $author
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Comment extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'article_id',
        'author_id',
        'body',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->LogOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Comment')
            ->setDescriptionForEvent(fn (string $eventName) => $this->getDescriptionForEvent($eventName));
    }

    protected function getDescriptionForEvent(string $eventName): string
    {
        $userName = auth()->user()->name ?? 'Desconhecido';
        $userId = auth()->id();
        $userOrAdmin = $this->author_id === $userId ? 'pelo próprio dono do artigo:' : 'pelo admin: ';

        return match ($eventName) {
            'created' => "Um novo comentário foi criado no artigo '{$this->article->title}' de id '{$this->article_id}'. Id do comentário : '{$this->id}'.",
            'updated' => "O comentário de id '{$this->id}', do artigo de id '{$this->article_id}' foi atualizado {$userOrAdmin} {$userName}.",
            'deleted' => "O comentário de id '{$this->id}', do artigo de id '{$this->article_id}' foi excluído {$userOrAdmin} {$userName}.",
            default   => "O comentário de id '{$this->id}', do artigo de id '{$this->article_id}' teve uma ação desconhecida. (ação/evento: {$eventName})"
        };
    }

    /**
     * Comment's article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Article, self>
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Comment's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
