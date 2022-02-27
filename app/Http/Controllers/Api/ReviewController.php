<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ItemReview;
use App\Model\ItemReviewImage;

class ReviewController extends Controller
{
    public function makeReview(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'item_id' => 'required|numeric|exists:items,id',
            'review' => 'nullable|string|max:350',
            'fixedRate' => 'required|numeric|min:1|max:5',
            'reviewImages' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()], 403);
        }

        $validatedData = $validator->validate();
        $review = ItemReview::create([
            'item_id' => $validatedData['item_id'],
            'user_id' => auth()->id() ?? null,
            'review' => $validatedData['review'],
            'rate' => $validatedData['fixedRate'],
        ]);
        foreach ($validatedData['reviewImages'] as $image) {
            $originalSize = null;
            $custom_compressed = null;
            $thumbs = null;

            if ($image) {
                $colorImage = imageMove($image, $folderName = 'styleImage', $imageStoreTypes = ['originalSize', 'custom_compressed', 'thumbs'], $customWidth = 300);
                $originalSize = $colorImage['originalSize'];
                $custom_compressed = $colorImage['custom_compressed'];
                $thumbs = $colorImage['thumbs'];
            }
            ItemReviewImage::create([
                'review_id' => $review->id,
                'image_path' => $originalSize,
                'compressed_image_path' => $custom_compressed,
                'thumbs_image_path' => $thumbs,
            ]);
        }
        $review->load('images');
        return response()->json(['success' => true, 'review' => $review], 200);
    }
    public function getReviews(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'item_id' => 'required|numeric|exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' =>false , 'errors'=>$validator->messages()], 403);
        }

        $validatedData = $validator->validate();
        $reviews = ItemReview::with('user', 'images')->where('item_id', $validatedData['item_id'])->orderBy('created_at', 'desc')->paginate(3);
        $totalReviews = ItemReview::where('item_id', $validatedData['item_id'])->count();
        $rate = ItemReview::where('item_id', $validatedData['item_id'])->avg('rate');
        $rate = number_format((float)$rate, 2, '.', '');
        return response()->json(['success' => true, 'reviews' => $reviews, 'totalReviews' => $totalReviews, 'rate' => $rate], 200);
    }
}
