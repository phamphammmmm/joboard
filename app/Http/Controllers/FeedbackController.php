<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function view()
    {
        $totalFeedback = Feedback::count();
        $totalStars =Feedback::sum('rating');
        $averageRating = $totalFeedback > 0 ? $totalStars / $totalFeedback : 0;

        $feedback = Feedback::with('user')->get();
        return view('client.feedback', [
            'feedback' => $feedback,
            'totalFeedback' => $totalFeedback,
            'averageRating' => $averageRating,
        ]);

    }

    public function show()
    { 
        $totalFeedback = Feedback::count();
        $totalStars =Feedback::sum('rating');
        $averageRating = $totalFeedback > 0 ? $totalStars / $totalFeedback : 0;

        $feedback = Feedback::with('user')->get();
        return view('admin.feedback', [
            'feedback' => $feedback,
            'totalFeedback' => $totalFeedback,
            'averageRating' => $averageRating,
        ]);
    }

    public function display()
    {
        $feedbacks = Feedback::with('user')->get(); 
    
        return view('admin.feedback-detail', compact('feedbacks'));
    }
    
    public function search(Request $request)
{
    $name = $request->input('name');
    $dateRange = $request->input('dateRange');
    $rating = $request->input('rating');
    $sortOrder = $request->input('sortOrder');

    $feedbacks = Feedback::where(function($query) use ($name) {
        if($name) {
            $query->whereHas('user', function($query) use ($name) {
                $query->where('name', 'LIKE', "%$name%");
            });
        }
    })
    ->when($dateRange, function($query, $dateRange) {
        return $query->where('created_at', '>=', now()->subDays($dateRange));
    })
    ->when($rating, function($query, $rating) {
        return $query->where('rating', $rating);
    })
    ->when($sortOrder, function($query, $sortOrder) {
        return $query->orderBy('created_at', $sortOrder);
    })
    ->get();

    // Lưu các điều kiện tìm kiếm vào session
    $request->session()->put('feedback_search', [
        'name' => $name,
        'dateRange' => $dateRange,
        'rating' => $rating,
        'sortOrder' => $sortOrder,
    ]);

    return view('admin.feedback-detail', compact('feedbacks'));
}

    
    public function showAll()
    { 
        $totalFeedback = Feedback::count();
        $totalStars =Feedback::sum('rating');
        $averageRating = $totalFeedback > 0 ? $totalStars / $totalFeedback : 0;

        $feedback = Feedback::with('user')->get();
        return view('admin.feedback-detail', [
            'feedback' => $feedback,
            'totalFeedback' => $totalFeedback,
            'averageRating' => $averageRating,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        $feedback = new Feedback();
        $feedback->user_id = auth()->user()->id; 
        $feedback->rating = $request->rating;
        $feedback->comment = $request->comment;
        $feedback->save();

        return redirect()->back()->with('success', 'Feedback sent successfully.');
    }

    public function delete($id)
    {
        $feedback = Feedback::find($id);

        if ($feedback) {
            $feedback->delete();
            return redirect()->back()->with('success', 'feedback deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'feedback not found.');
        }
    }

    public function getFeedbackData()
    {
        $feedback = Feedback::orderBy('created_at', 'asc')->get();
        return response()->json($feedback);
    }

    public function getFeedbackById($id)
    {
        $feedback = Feedback::with('user:id,name,major,email,path')->find($id);

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        return response()->json([
            'name' => $feedback->user->name,
            'major' => $feedback->user->major,
            'email' => $feedback->user->email,
            'path' => $feedback->user->path,
            'rating' => $feedback->rating,
            'comment' => $feedback->comment,
            'created_at' => $feedback->created_at,
            'updated_at' => $feedback->updated_at
        ]);
    }

    

}