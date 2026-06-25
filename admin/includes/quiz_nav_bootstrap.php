<?php
/**
 * Map legacy $quizActiveNav to $adminNavActive for quiz pages.
 */
if (!isset($adminNavActive) && isset($quizActiveNav) && $quizActiveNav !== '') {
    $map = [
        'settings' => 'quiz_settings',
        'categories' => 'quiz_categories',
        'questions' => 'quiz_questions',
        'results' => 'quiz_results',
        'attempts' => 'quiz_attempts',
    ];
    $adminNavActive = $map[$quizActiveNav] ?? 'quiz_' . $quizActiveNav;
}
