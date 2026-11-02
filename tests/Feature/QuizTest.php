<?php

namespace Tests\Feature;

use App\Support\QuizBank;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class QuizTest extends TestCase
{
    public static function categories(): array
    {
        return [['pengetahuan-umum'], ['teknologi'], ['sains']];
    }

    protected function answers(string $slug): array
    {
        return array_column(config('quiz')[$slug]['questions'], 'answer', 'id');
    }

    public function test_home_lists_all_categories_without_solutions(): void
    {
        $response = $this->get('/')->assertOk()->assertSee('Uji')->assertSee('Pengetahuanmu.');
        $response->assertSee('Pengetahuan Umum')->assertSee('Teknologi')->assertSee('Sains');
        foreach (config('quiz') as $category) {
            foreach ($category['questions'] as $question) {
                $response->assertDontSee($question['explanation']);
            }
        }
    }

    #[DataProvider('categories')]
    public function test_category_displays_eight_questions_without_answers(string $slug): void
    {
        $response = $this->get('/kuis/'.$slug)->assertOk()->assertSee('Selesaikan Kuis');
        $questions = config('quiz')[$slug]['questions'];
        $this->assertCount(8, $questions);
        $display = app(QuizBank::class)->questionsForDisplay(config('quiz')[$slug]);
        foreach ($questions as $index => $question) {
            $response->assertSee($question['text']);
            $response->assertDontSee($question['explanation']);
            $this->assertArrayNotHasKey('answer', $display[$index]);
            $this->assertArrayNotHasKey('explanation', $display[$index]);
            $this->assertCount(4, $question['options']);
        }
        $this->assertSame(32, substr_count($response->getContent(), 'type="radio"'));
        $this->assertSame(8, substr_count($response->getContent(), '<fieldset'));
    }

    #[DataProvider('categories')]
    public function test_perfect_score_and_review_for_every_category(string $slug): void
    {
        $response = $this->post('/kuis/'.$slug.'/hasil', ['answers' => $this->answers($slug)]);
        $response->assertOk()->assertViewHas('correct', 8)->assertViewHas('wrong', 0);
        $response->assertViewHas('score', 100)->assertSee('100%')->assertSee('Hasil Kuis');
        foreach (config('quiz')[$slug]['questions'] as $question) {
            $response->assertSee($question['explanation']);
        }
        $response->assertSee('Jawabanmu')->assertSee('Jawaban benar');
    }

    public function test_mixed_score_is_calculated_on_server_despite_forged_score(): void
    {
        $answers = $this->answers('sains');
        $answers['sains-01'] = 'a';
        $this->post('/kuis/sains/hasil', [
            'answers' => $answers, 'score' => 100, 'correct' => 8,
        ])->assertOk()->assertViewHas('correct', 7)->assertViewHas('wrong', 1)
            ->assertViewHas('score', 87.5)->assertSee('87,5%');
    }

    public function test_zero_score_and_wrong_answers_are_displayed(): void
    {
        $answers = array_map(fn ($answer) => $answer === 'a' ? 'b' : 'a', $this->answers('sains'));
        $this->post('/kuis/sains/hasil', ['answers' => $answers])->assertOk()
            ->assertViewHas('correct', 0)->assertViewHas('wrong', 8)->assertViewHas('score', 0);
    }

    public function test_empty_answers_are_rejected_with_indonesian_message(): void
    {
        $this->from('/kuis/sains')->post('/kuis/sains/hasil', [])->assertRedirect('/kuis/sains')
            ->assertSessionHasErrors(['answers' => 'Jawab seluruh pertanyaan sebelum menyelesaikan kuis.']);
        $this->withCookie(config('session.cookie'), session()->getId())
            ->get('/kuis/sains')->assertSee('Periksa kembali jawabanmu.')
            ->assertDontSee(config('quiz.sains.questions.0.explanation'));
    }

    public function test_partial_answers_are_rejected_and_valid_choice_is_preserved(): void
    {
        $this->from('/kuis/sains')->post('/kuis/sains/hasil', ['answers' => ['sains-01' => 'b']])
            ->assertRedirect('/kuis/sains')->assertSessionHasErrors('answers.sains-02');
        $this->withCookie(config('session.cookie'), session()->getId())
            ->get('/kuis/sains')->assertSee('Periksa kembali jawabanmu.')->assertSee('value="b" checked', false);
    }

    public function test_unknown_choices_nested_values_and_cross_category_ids_are_rejected(): void
    {
        foreach (['z', ['b'], '<script>alert(1)</script>', 1, null] as $invalid) {
            $answers = $this->answers('sains');
            $answers['sains-01'] = $invalid;
            $this->from('/kuis/sains')->post('/kuis/sains/hasil', ['answers' => $answers])
                ->assertRedirect('/kuis/sains')->assertSessionHasErrors('answers.sains-01');
        }
        $answers = $this->answers('sains');
        $answers['teknologi-01'] = 'a';
        $this->post('/kuis/sains/hasil', ['answers' => $answers])->assertSessionHasErrors('answers');
        $this->post('/kuis/sains/hasil', ['answers' => 'invalid'])->assertSessionHasErrors('answers');
    }

    public function test_repeat_starts_with_no_selected_answers(): void
    {
        $this->post('/kuis/sains/hasil', ['answers' => $this->answers('sains')])
            ->assertSee(route('quiz.show', 'sains'))->assertSee('Ulangi Kuis');
        $this->get('/kuis/sains')->assertOk()->assertDontSee(' checked', false);
    }

    public function test_invalid_categories_and_get_results_do_not_reveal_results(): void
    {
        $this->get('/kuis/tidak-ada')->assertNotFound()->assertSee('Halaman tidak ditemukan');
        $this->post('/kuis/tidak-ada/hasil')->assertNotFound();
        $this->get('/kuis/sains/hasil')->assertStatus(405)->assertDontSee('Jawaban benar');
    }

    public function test_csrf_token_is_present_and_untrusted_post_is_rejected(): void
    {
        $this->get('/kuis/sains')->assertSee('name="_token"', false);
        // CSRF is normally bypassed in tests; enable its actual runtime branch.
        $this->app->instance('env', 'local');
        $this->post('/kuis/sains/hasil', ['answers' => $this->answers('sains')])
            ->assertStatus(419)->assertSee('Sesi telah berakhir');
    }

    public function test_question_bank_has_unique_ids_and_valid_options(): void
    {
        $ids = [];
        foreach (config('quiz') as $slug => $category) {
            foreach ($category['questions'] as $question) {
                $ids[] = $question['id'];
                $this->assertSame($slug, $question['category']);
                $this->assertSame(['a', 'b', 'c', 'd'], array_keys($question['options']));
                $this->assertArrayHasKey($question['answer'], $question['options']);
                $this->assertNotEmpty($question['explanation']);
            }
        }
        $this->assertCount(24, array_unique($ids));
    }

    public function test_untrusted_text_is_escaped_and_no_inline_assets_are_used(): void
    {
        config(['quiz.sains.questions.0.text' => '<script>alert("x")</script>']);
        $this->get('/kuis/sains')->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert(', false);
        foreach (File::allFiles(resource_path('views')) as $file) {
            $this->assertDoesNotMatchRegularExpression('/<style|style=|<script(?![^>]*src=)|\\bon(?:click|change|submit)=/i', $file->getContents());
        }
    }
}
