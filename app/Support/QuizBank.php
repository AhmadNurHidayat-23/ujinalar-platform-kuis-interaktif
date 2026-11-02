<?php

namespace App\Support;

use Illuminate\Support\Arr;

class QuizBank
{
    public function categories(): array
    {
        return collect(config('quiz'))->map(fn (array $category, string $slug) => [
            ...Arr::except($category, 'questions'),
            'slug' => $slug,
            'count' => count($category['questions']),
        ])->all();
    }

    public function category(string $slug): array
    {
        abort_unless(array_key_exists($slug, config('quiz')), 404);

        return [...config('quiz')[$slug], 'slug' => $slug];
    }

    public function questionsForDisplay(array $category): array
    {
        return array_map(
            fn (array $question) => Arr::only($question, ['id', 'text', 'options']),
            $category['questions'],
        );
    }
}
