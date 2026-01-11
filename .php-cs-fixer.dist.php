<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'docker',
        'frontend',
        'public',
        'resources',
        'storage',
        'vendor',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'fully_qualified_strict_types' => true,
        'object_operator_without_whitespace' => true,
        'operator_linebreak' => [
            'position' => 'beginning',
        ],

        // phpdoc
        'align_multiline_comment' => [
            'comment_type' => 'all_multiline',
        ],
        'no_superfluous_phpdoc_tags' => true,
        'phpdoc_align' => [
            'align' => 'vertical',
        ],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,

        // return_notation
        'return_assignment' => true,

        // semicolon
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],

        // string_notation
        'explicit_string_variable' => true,
        'single_quote' => true,

        // whitespace
        'array_indentation' => true,
        'method_chaining_indentation' => true,
        'no_extra_blank_lines' => true,
    ])
    ->setFinder($finder)
;

