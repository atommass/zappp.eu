<?php

use App\Models\Link;
use App\Models\User;

test('qr routes require authentication', function () {
    $user = User::factory()->create();
    $link = Link::factory()->for($user)->create();

    $this->get(route('qr.show', $link->slug))
        ->assertRedirect('/login');

    $this->get(route('qr.download', $link->slug))
        ->assertRedirect('/login');
});

test('user can view qr code page for own link', function () {
    $user = User::factory()->create();
    $link = Link::factory()->for($user)->create(['slug' => 'abc123']);

    $this->actingAs($user)
        ->get(route('qr.show', $link->slug))
        ->assertOk()
        ->assertSee('<svg', false);
});

test('user cannot view qr code for someone elses link', function () {
    $owner = User::factory()->create();
    $attacker = User::factory()->create();
    $link = Link::factory()->for($owner)->create(['slug' => 'private123']);

    $this->actingAs($attacker)
        ->get(route('qr.show', $link->slug))
        ->assertNotFound();
});

test('user can download qr code png for own link', function () {
    if (! extension_loaded('gd')) {
        $this->markTestSkipped('GD extension is required for PNG QR generation.');
    }

    $user = User::factory()->create();
    $link = Link::factory()->for($user)->create(['slug' => 'png123']);

    $response = $this->actingAs($user)
        ->get(route('qr.download', $link->slug));

    $response->assertOk();
    $response->assertHeader('content-type', 'image/png');
    $response->assertHeader('content-disposition', 'attachment; filename="qr-'.$link->slug.'.png"');

    expect(strlen($response->getContent()))->toBeGreaterThan(0);
});
