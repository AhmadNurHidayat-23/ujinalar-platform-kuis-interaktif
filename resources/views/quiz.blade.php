@extends('layouts.app')
@section('title', $category['name'])

@section('content')
    <div class="reading-column">
        <a class="back-link" href="{{ route('home') }}#kategori"><span aria-hidden="true">←</span> Semua kategori</a>
        <header class="page-heading">
            <p class="eyebrow">Kuis / {{ $category['name'] }}</p>
            <h1>{{ $category['name'] }}</h1>
            <p>Luangkan waktu, baca dengan saksama, dan pilih satu jawaban untuk setiap soal.</p>
        </header>
        <div class="quiz-status"><span>{{ count($questions) }} soal · Tanpa batas waktu</span><span id="answer-progress" aria-live="polite">0 dari {{ count($questions) }} terjawab</span></div>
        @if($errors->any())
            <div class="validation-summary" role="alert" tabindex="-1">
                <h2>Periksa kembali jawabanmu.</h2>
                <p>{{ $errors->first() }}</p>
                <p>Jawaban yang valid tetap terpilih. Lengkapi atau perbaiki soal di bawah ini.</p>
            </div>
        @endif
        <form method="POST" action="{{ route('quiz.submit', $category['slug']) }}" data-quiz-form>
            @csrf
            @foreach($questions as $question)
                <fieldset class="question" id="soal-{{ $question['id'] }}" @error('answers.'.$question['id']) aria-describedby="error-{{ $question['id'] }}" @enderror>
                    <legend><span class="question-number">SOAL {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="question-title">{{ $question['text'] }}</span></legend>
                    <div class="options">
                        @foreach($question['options'] as $key => $option)
                            <label class="option">
                                <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ $key }}" @checked(old('answers.'.$question['id']) === $key) required>
                                <span class="option-letter">{{ strtoupper($key) }}</span><span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('answers.'.$question['id'])<p class="field-error" id="error-{{ $question['id'] }}">{{ $message }}</p>@enderror
                </fieldset>
            @endforeach
            <div class="submit-row"><p>Sudah yakin? Lihat hasil dan pelajari pembahasannya.</p><button class="button" type="submit">Selesaikan Kuis <span aria-hidden="true">↗</span></button></div>
        </form>
    </div>
@endsection
