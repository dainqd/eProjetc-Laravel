<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Services\FeedbackService;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    private FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function store(FeedbackRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $this->feedbackService->store($data);
        return redirect()->route('feedbacks.create')->with('success', 'We have received your feedback. Thank you!');
    }

    public function create()
    {
        return view('pages.feedbacks.form');
    }

    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $limit = request()->query('limit') ?? 25;
        return view('pages.feedbacks.list', [
            'data' => $this->feedbackService->list($limit)
        ]);
    }

    public function show(Feedback $feedback)
    {
        $this->authorize('view', $feedback);
        return view('pages.feedbacks.show', [
            'data' => $this->feedbackService->find($feedback->id)
        ]);
    }

    public function destroy(Feedback $feedback)
    {
        $this->authorize('delete', $feedback);
        $this->feedbackService->destroy($feedback);
        return redirect()->route('feedbacks.index')->with('success', 'Feedback removed from class');
    }
}
