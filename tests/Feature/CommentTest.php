<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_comments_on_blog_post(): void
    {
        $post = Post::factory()->create(['is_published' => true]);
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'is_approved' => true,
            'author_name' => 'John Doe',
            'content' => 'Great post!'
        ]);

        $response = $this->get(route('blog.show', $post));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Great post!');
        $response->assertSee('Comments (1)');
    }

    public function test_can_post_comment(): void
    {
        $post = Post::factory()->create(['is_published' => true, 'allow_comments' => true]);

        $commentData = [
            'author_name' => 'Test User',
            'author_email' => 'test@example.com',
            'content' => 'This is a test comment.'
        ];

        $response = $this->post(route('comments.store', $post), $commentData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'author_name' => 'Test User',
            'author_email' => 'test@example.com',
            'content' => 'This is a test comment.',
            'is_approved' => true
        ]);
    }

    public function test_can_reply_to_comment(): void
    {
        $post = Post::factory()->create(['is_published' => true, 'allow_comments' => true]);
        $parentComment = Comment::factory()->create([
            'post_id' => $post->id,
            'is_approved' => true
        ]);

        $replyData = [
            'author_name' => 'Reply User',
            'author_email' => 'reply@example.com',
            'content' => 'This is a reply.',
            'parent_id' => $parentComment->id
        ];

        $response = $this->post(route('comments.store', $post), $replyData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'parent_id' => $parentComment->id,
            'author_name' => 'Reply User',
            'content' => 'This is a reply.'
        ]);
    }

    public function test_comment_validation_required_fields(): void
    {
        $post = Post::factory()->create(['is_published' => true, 'allow_comments' => true]);

        $response = $this->post(route('comments.store', $post), []);

        $response->assertSessionHasErrors(['author_name', 'author_email', 'content']);
    }

    public function test_comment_validation_email_format(): void
    {
        $post = Post::factory()->create(['is_published' => true, 'allow_comments' => true]);

        $response = $this->post(route('comments.store', $post), [
            'author_name' => 'Test User',
            'author_email' => 'invalid-email',
            'content' => 'Test content'
        ]);

        $response->assertSessionHasErrors(['author_email']);
    }
}
