<?php

use App\Models\User;
use App\Models\Post;
// use Illuminate\Foundation\Testing\RefreshDatabase;

function sum($a, $b)
{
  return $a + $b;
}

test('sum', function () {
  $result = sum(1, 2);

  expect($result)->toBe(3);
});

test('user can create post', function () {

  $response = $this->post(route('post.store', Post::factory()->create()));

  $response->assertStatus(302);

  $this->assertEquals(Post::all(), 1);
});
