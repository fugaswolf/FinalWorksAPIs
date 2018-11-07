<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlesFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $article = factory(Article::class)->make();

        $this->postJson('/api/articles/', [
            'title' => $article->title,
            'author' => $article->author,
            'department' => $article->department
        ])->assertStatus(201);

        $this->assertDatabaseHas('articles', $article->toArray());
    }

    public function testUpdate()
    {
        $article = factory(Article::class)->create();

        $this->putJson('api/articles/' . $article->id, $newData = [
            'title' => str_random(),
            'author' => str_random(),
            'department' => str_random()
        ])->assertStatus(200);

        $this->assertDatabaseHas('articles', $newData + [
            'id' => $article->id
        ]);
    }

    public function testShowById()
    {
        $article = factory(Article::class)->create();

        $this->getJson('/api/articles/' . $article->id)
            ->assertStatus(200)
            ->assertJsonFragment($article->toArray());

    }

    public function testShowByTitle()
    {
        $article = factory(Article::class)->create();

        $this->getJson('/api/articles/by_title/' . $article->title)
            ->assertStatus(200)
            ->assertJsonFragment($article->toArray());
    }

    // welke was er nog?
    // update/edit? & destroy werkt normaal gezien
    // edit is in principe niet nodig want het is een api (er is geen view voor te updaten)
    // destroy nog
    public function testDestroy()
    {
        $article = factory(Article::class)->create();

        $this->deleteJson('/api/articles/' . $article->id)
            ->assertStatus(200)
            ->assertJson(['message' => 'Success.']);

        $this->assertDatabaseMissing('articles', $article->toArray());
    }

    public function testFetchAll()
    {
        $article = factory(Article::class)->create();

        $this->getJson('/api/articles')
            ->assertStatus(200)
            ->assertJsonFragment($article->toArray());
    }
}
