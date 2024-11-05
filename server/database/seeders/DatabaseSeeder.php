<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public static $usersCount = 20;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        /** @var array<User>|\Illuminate\Database\Eloquent\Collection<User> $users */

        $users = User::factory()->count(self::$usersCount)->create();

        foreach ($users as $user) {
            $user->followers()->attach($users->random(rand(0, 5)));
        }

        /** @var array<Article>|\Illuminate\Database\Eloquent\Collection<Article> $articles */
        $articles = Article::factory()
            ->count(30)
            ->state(new Sequence(fn () => [
                'author_id' => $users->random(),
            ]))
            ->create();

        /** @var array<Tag>|\Illuminate\Database\Eloquent\Collection<Tag> $tags */
        $tags = Tag::factory()->count(20)->create();

        foreach ($articles as $article) {
            $article->tags()->attach($tags->random(rand(0, 6)));
            $article->favoredUsers()->attach($users->random(rand(0, 8)));
        }

        Comment::factory()
            ->count(60)
            ->state(new Sequence(fn () => [
                'article_id' => $articles->random(),
                'author_id'  => $users->random(),
            ]))
            ->create();

        $this->call([PermissionSeeder::class]);
    }
}
