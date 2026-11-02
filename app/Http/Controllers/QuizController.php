<?php

namespace App\Http\Controllers;

use App\Support\QuizBank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(QuizBank $bank): View
    {
        return view('home', ['categories' => $bank->categories()]);
    }

    public function show(string $category, QuizBank $bank): View
    {
        $quiz = $bank->category($category);

        return view('quiz', [
            'category' => collect($quiz)->except('questions')->all(),
            'questions' => $bank->questionsForDisplay($quiz),
        ]);
    }

    public function submit(Request $request, string $category, QuizBank $bank): View
    {
        $quiz = $bank->category($category);
        $questions = $quiz['questions'];
        $ids = array_column($questions, 'id');
        $rules = ['answers' => ['required', 'array:'.implode(',', $ids), 'size:'.count($ids)]];

        foreach ($questions as $question) {
            $rules['answers.'.$question['id']] = [
                'required', 'string', Rule::in(array_keys($question['options'])),
            ];
        }

        $answers = $request->validate($rules, [
            'answers.required' => 'Jawab seluruh pertanyaan sebelum menyelesaikan kuis.',
            'answers.array' => 'Daftar jawaban tidak valid. Pilih jawaban dari pilihan yang tersedia.',
            'answers.size' => 'Lengkapi tepat '.count($ids).' jawaban untuk kategori ini.',
            'answers.*.required' => 'Pilih satu jawaban untuk pertanyaan ini.',
            'answers.*.string' => 'Pilih satu jawaban yang valid.',
            'answers.*.in' => 'Jawaban tidak valid. Pilih salah satu pilihan yang tersedia.',
        ])['answers'];

        $reviews = array_map(function (array $question) use ($answers): array {
            $selected = $answers[$question['id']];

            return [
                ...$question,
                'selected' => $selected,
                'correct' => $selected === $question['answer'],
            ];
        }, $questions);
        $correct = count(array_filter($reviews, fn (array $review) => $review['correct']));
        $total = count($questions);

        return view('result', [
            'category' => collect($quiz)->except('questions')->all(),
            'reviews' => $reviews,
            'correct' => $correct,
            'wrong' => $total - $correct,
            'total' => $total,
            'score' => $correct / $total * 100,
        ]);
    }
}
