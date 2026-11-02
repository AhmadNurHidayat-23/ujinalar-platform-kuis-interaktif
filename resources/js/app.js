const form = document.querySelector('[data-quiz-form]');

if (form) {
    const progress = document.getElementById('answer-progress');
    const updateProgress = () => {
        const total = form.querySelectorAll('fieldset').length;
        const answered = form.querySelectorAll('input[type="radio"]:checked').length;
        progress.textContent = `${answered} dari ${total} terjawab`;
    };
    form.addEventListener('change', updateProgress);
    window.addEventListener('pageshow', updateProgress);
    updateProgress();
}

document.querySelector('.validation-summary')?.focus();
