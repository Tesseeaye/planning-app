<?php

use App\Models\Card;
use App\Models\User;
use App\Models\Lists;
use App\Models\Attachment;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AttachmentResource;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs(
        $this->user, [
            'view',
            'create',
            'update',
            'delete',
        ]);
});

test('"Attachment" list can be retrieved', function () {
    Attachment::factory(3)->for(auth('sanctum')->user(), 'author')->create();

    $response = $this->get(route('attachment.index'));

    $response
        ->assertOk()
        ->assertJson([
            'data' => AttachmentResource::collection(Attachment::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get())->resolve()
        ]);

    $responseData = $response->json('data');
    $this->assertCount(3, $responseData);
});

test('"Attachment" can be stored', function () {
    $card = Card::factory()->for(auth('sanctum')->user(), 'author')->create();

    $attachments = Storage::fake('attachments');

    $file = UploadedFile::fake()->image('image.jpg', 64, 64)->size(500);

    $response = $this->post(route('attachment.store'), [
        'file' => $file,
        'alt_text' => 'Lorem Ipsum',
        'card_slug' => $card->slug,
    ]);

    $this->assertDatabaseHas('attachments', [
        'file_name' => $file->hashName(),
        'file_type' => $file->getMimeType(),
        'file_size' => $file->getSize(),
        'alt_text' => 'Lorem Ipsum',
        'user_id' => $this->user->id,
        'card_id' => $card->id,
    ]);

    $attachment = Attachment::where('card_id', $card->id)
        ->where('user_id', auth('sanctum')->user()->getAuthIdentifier())
        ->firstOrFail();

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('attachment.show', $attachment);
});

test('"Attachment" can be shown', function () {
    $attachment = Attachment::factory()->create();

    $response = $this->get(route('attachment.show', $attachment));

    $response
        ->assertStatus(200)
        ->assertJson([
            'data' => (new AttachmentResource($attachment))->resolve()
        ]);
});

test('"Attachment" can be updated', function () {
    $card = Lists::factory()->create();
    $attachment = Attachment::factory()->for($card, 'card')->create([
        'alt_text' => 'Original alt text',
    ]);

    $response = $this->put(route('attachment.update', $attachment), [
        'alt_text' => 'New alt text',
    ]);

    $attachment->refresh();

    expect($attachment->alt_text)->toBe('New alt text');

    $response
        ->assertStatus(302)
        ->assertRedirectToRoute('attachment.show', $attachment);
});

test('"Attachment" can be destroyed', function () {
    $attachment = Attachment::factory()->create();

    $response = $this->delete(route('attachment.destroy', $attachment));

    $this->assertModelMissing($attachment);

    $response
        ->assertOk()
        ->assertJson(['message' => 'Attachment \'' . $attachment->file_name . '\' was deleted successfully.']);
});