<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Attachment;
use App\Http\Resources\AttachmentResource;
use App\Http\Requests\StoreAttachmentRequest;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AttachmentResource::collection(Attachment::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttachmentRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['file', 'alt_text', 'card_slug']);

        $card = Card::findBySlugOrFail($validated['card_slug']);
        $file = $validated['file'];

        $file->store('attachments');

        $data = [
            'file_name' => $file->hashName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'user_id' => auth('sanctum')->user()->getAuthIdentifier(),
            'card_id' => $card->id,
        ];

        if (isset($validated['alt_text'])) {
            $data['alt_text'] = $validated['alt_text'];
        }

        $attachment = Attachment::create($data);

        return redirect()->route('attachment.show', $attachment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        return new AttachmentResource($attachment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttachmentRequest $request, Attachment $attachment)
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['alt_text']);

        $attachment->update([
            'alt_text' => $validated['alt_text'],
        ]);

        return redirect()->route('attachment.show', $attachment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        $file = $attachment->file_name;

        $attachment->delete($attachment);

        return response()->json([
            'message' => 'Attachment \'' . $file . '\' was deleted successfully.'
        ]);
    }
}
