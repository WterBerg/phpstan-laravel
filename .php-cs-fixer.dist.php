<?php

declare(strict_types=1);

/**
 * This file is part of the WterBerg/PHPStan-Laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__])
    ->append([
        __DIR__ . '/.php-cs-fixer.dist.php',
    ])
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true);

$headerComment = <<<'EOF'
This file is part of the WterBerg/PHPStan-Laravel package.

This source file is subject to the license that is
bundled with this source code in the LICENSE.md file.
EOF;

$aliasRules = [
    'no_alias_language_construct_call' => true,
    'no_mixed_echo_print'              => [
        'use' => 'echo',
    ],
];

$arrayRules = [
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_trailing_comma_in_singleline_array'       => true,
    'no_whitespace_before_comma_in_array'         => [
        'after_heredoc' => true,
    ],
    'normalize_index_brace'           => true,
    'trim_array_spaces'               => true,
    'whitespace_after_comma_in_array' => true,
];

$basicRules = [
    'braces' => [
        'allow_single_line_anonymous_class_with_empty_body' => true,
        'allow_single_line_closure'                         => true,
        'position_after_functions_and_oop_constructs'       => 'next',
        'position_after_control_structures'                 => 'same',
        'position_after_anonymous_constructs'               => 'same',
    ],
    'encoding'       => true,
    'octal_notation' => true,
];

$casingRules = [
    'constant_case' => [
        'case' => 'lower',
    ],
    'integer_literal_case'                    => true,
    'lowercase_keywords'                      => true,
    'lowercase_static_reference'              => true,
    'magic_constant_casing'                   => true,
    'magic_method_casing'                     => true,
    'native_function_casing'                  => true,
    'native_function_type_declaration_casing' => true,
];

$castNotationRules = [
    'cast_spaces' => [
        'space' => 'single',
    ],
    'lowercase_cast'     => true,
    'no_short_bool_cast' => true,
    'no_unset_cast'      => true,
    'short_scalar_cast'  => true,
];

$classNotationRules = [
    'class_attributes_separation' => [
        'elements' => [
            'const'        => 'one',
            'method'       => 'one',
            'property'     => 'one',
            'trait_import' => 'none',
        ],
    ],
    'class_definition' => [
        'multi_line_extends_each_single_line' => true,
        'single_item_single_line'             => true,
        'single_line'                         => true,
        'space_before_parenthesis'            => true,
    ],
    'no_blank_lines_after_class_opening' => true,
    'no_null_property_initialization'    => true,
    'ordered_class_elements'             => [
        'order' => [
            'use_trait',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public_static',
            'property_protected_static',
            'property_private_static',
            'property_public_readonly',
            'property_public',
            'property_protected_readonly',
            'property_protected',
            'property_private_readonly',
            'property_private',
            'method_public_abstract_static',
            'method_public_static',
            'method_protected_abstract_static',
            'method_protected_static',
            'method_private_static',
            'construct',
            'destruct',
            'magic',
            'phpunit',
            'method_public_abstract',
            'method_public',
            'method_protected_abstract',
            'method_protected',
            'method_private',
        ],
        'sort_algorithm' => 'none',
    ],
    'protected_to_private'               => true,
    'self_static_accessor'               => true,
    'single_class_element_per_statement' => [
        'elements' => [
            'const',
            'property',
        ],
    ],
    'single_trait_insert_per_statement' => true,
    'visibility_required'               => [
        'elements' => [
            'property',
            'method',
            'const',
        ],
    ],
];

$classUsageRules = [
];

$commentRules = [
    'header_comment' => [
        'header'       => $headerComment,
        'comment_type' => 'PHPDoc',
        'location'     => 'after_declare_strict',
        'separate'     => 'both',
    ],
    'multiline_comment_opening_closing' => false,
    'no_empty_comment'                  => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_line_comment_style'         => [
        'comment_types' => [
            'asterisk',
            'hash',
        ],
    ],
];

$constantNotationRules = [
];

$controlStructureRules = [
    'control_structure_continuation_position' => [
        'position' => 'same_line',
    ],
    'elseif'          => true,
    'empty_loop_body' => [
        'style' => 'braces',
    ],
    'empty_loop_condition' => [
        'style' => 'while',
    ],
    'include'               => true,
    'no_alternative_syntax' => [
        'fix_non_monolithic_code' => true,
    ],
    'no_break_comment' => [
        'comment_text' => 'No break.',
    ],
    'no_superfluous_elseif'           => true,
    'no_trailing_comma_in_list_call'  => true,
    'no_unneeded_control_parentheses' => [
        'statements' => [
            'break',
            'clone',
            'continue',
            'echo_print',
            'return',
            'switch_case',
            'yield',
            'yield_from',
        ],
    ],
    'no_unneeded_curly_braces' => [
        'namespaces' => true,
    ],
    'no_useless_else'                => true,
    'simplified_if_return'           => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space'              => true,
    'switch_continue_to_break'       => true,
    'trailing_comma_in_multiline'    => [
        'after_heredoc' => true,
        'elements'      => [
            'arrays',
        ],
    ],
    'yoda_style' => [
        'equal'                => true,
        'identical'            => true,
        'less_and_greater'     => null,
        'always_move_variable' => true,
    ],
];

$doctrineAnnotationRules = [
];

$functionNotationRules = [
    'function_declaration' => [
        'closure_function_spacing' => 'none',
    ],
    'function_typehint_space' => true,
    'lambda_not_used_import'  => true,
    'method_argument_space'   => [
        'keep_multiple_spaces_after_comma' => false,
        'on_multiline'                     => 'ensure_fully_multiline',
        'after_heredoc'                    => true,
    ],
    'no_spaces_after_function_name'                    => true,
    'nullable_type_declaration_for_default_null_value' => [
        'use_nullable_type_declaration' => true,
    ],
    'return_type_declaration' => [
        'space_before' => 'none',
    ],
    'single_line_throw' => false,
];

$importRules = [
    'fully_qualified_strict_types' => true,
    'global_namespace_import'      => [
        'import_constants' => true,
        'import_functions' => true,
        'import_classes'   => true,
    ],
    'group_import'            => false,
    'no_leading_import_slash' => true,
    'no_unused_imports'       => true,
    'ordered_imports'         => [
        'sort_algorithm' => 'alpha',
        'imports_order'  => [
            'const',
            'function',
            'class',
        ],
    ],
    'single_import_per_statement' => true,
    'single_line_after_imports'   => true,
];

$languageConstructRules = [
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'declare_equal_normalize'    => [
        'space' => 'none',
    ],
    'declare_parentheses'          => true,
    'explicit_indirect_variable'   => true,
    'single_space_after_construct' => [
        'constructs' => [
            'abstract',
            'as',
            'attribute',
            'break',
            'case',
            'catch',
            'class',
            'clone',
            'comment',
            'const',
            'const_import',
            'continue',
            'do',
            'echo',
            'else',
            'elseif',
            'enum',
            'extends',
            'final',
            'finally',
            'for',
            'foreach',
            'function',
            'function_import',
            'global',
            'goto',
            'if',
            'implements',
            'include',
            'include_once',
            'instanceof',
            'insteadof',
            'interface',
            'match',
            'named_argument',
            'namespace',
            'new',
            'open_tag_with_echo',
            'php_doc',
            'php_open',
            'print',
            'private',
            'protected',
            'public',
            'readonly',
            'require',
            'require_once',
            'return',
            'static',
            'switch',
            'throw',
            'trait',
            'try',
            'use',
            'use_lambda',
            'use_trait',
            'var',
            'while',
            'yield',
            'yield_from',
        ],
    ],
];

$listNotationRules = [
    'list_syntax' => [
        'syntax' => 'short',
    ],
];

$namespaceNotationRules = [
    'blank_line_after_namespace'         => true,
    'clean_namespace'                    => true,
    'no_blank_lines_before_namespace'    => false,
    'no_leading_namespace_whitespace'    => true,
    'single_blank_line_before_namespace' => true,
];

$namingRules = [
];

$operatorRules = [
    'assign_null_coalescing_to_coalesce_equal' => false,
    'binary_operator_spaces'                   => [
        'default'   => 'align_single_space',
        'operators' => [],
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
    'increment_style' => [
        'style' => 'pre',
    ],
    'new_with_braces'                    => true,
    'no_space_around_double_colon'       => true,
    'not_operator_with_space'            => false,
    'not_operator_with_successor_space'  => false,
    'object_operator_without_whitespace' => true,
    'operator_linebreak'                 => [
        'only_booleans' => true,
        'position'      => 'beginning',
    ],
    'standardize_increment'      => true,
    'standardize_not_equals'     => true,
    'ternary_operator_spaces'    => true,
    'ternary_to_null_coalescing' => true,
    'unary_operator_spaces'      => true,
];

$phpTagRules = [
    'blank_line_after_opening_tag' => true,
    'echo_tag_syntax'              => [
        'format'                         => 'long',
        'long_function'                  => 'echo',
        'shorten_simple_statements_only' => false,
    ],
    'full_opening_tag'            => true,
    'linebreak_after_opening_tag' => true,
    'no_closing_tag'              => true,
];

$phpUnitRules = [
    'php_unit_fqcn_annotation' => true,
    'php_unit_internal_class'  => [
        'types' => [
            'normal',
            'final',
            'abstract',
        ],
    ],
    'php_unit_method_casing' => [
        'case' => 'camel_case',
    ],
];

$phpDocRules = [
    'align_multiline_comment' => [
        'comment_type' => 'all_multiline',
    ],
    'general_phpdoc_annotation_remove' => [
        'annotations' => [
            'author',
        ],
    ],
    'general_phpdoc_tag_rename' => [
        'fix_annotation' => true,
        'fix_inline'     => true,
        'replacements'   => [
            'inheritDoc'  => 'inheritdoc',
            'inheritDocs' => 'inheritdoc',
        ],
        'case_sensitive' => false,
    ],
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_phpdoc'             => true,
    'no_superfluous_phpdoc_tags'  => [
        'allow_mixed'         => false,
        'remove_inheritdoc'   => false,
        'allow_unused_params' => false,
    ],
    'phpdoc_add_missing_param_annotation' => [
        'only_untyped' => false,
    ],
    'phpdoc_align' => [
        'tags' => [
            'param',
            'property',
            'property-read',
            'property-write',
            'return',
            'throws',
            'type',
            'var',
            'method',
        ],
        'align' => 'vertical',
    ],
    'phpdoc_annotation_without_dot' => true,
    'phpdoc_indent'                 => true,
    'phpdoc_inline_tag_normalizer'  => [
        'tags' => [
            'example',
            'id',
            'internal',
            'inheritdoc',
            'inheritdocs',
            'link',
            'source',
            'toc',
            'tutorial',
        ],
    ],
    'phpdoc_line_span' => [
        'const'    => 'multi',
        'property' => 'multi',
        'method'   => 'multi',
    ],
    'phpdoc_no_access'    => true,
    'phpdoc_no_alias_tag' => [
        'replacements' => [
            'property-read'  => 'property',
            'property-write' => 'property',
            'type'           => 'var',
            'link'           => 'see',
        ],
    ],
    'phpdoc_no_empty_return'       => true,
    'phpdoc_no_package'            => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_order'                 => true,
    'phpdoc_return_self_reference' => [
        'replacements' => [
            'this'    => '$this',
            '@this'   => '$this',
            '$self'   => 'self',
            '@self'   => 'self',
            '$static' => 'static',
            '@static' => 'static',
        ],
    ],
    'phpdoc_scalar' => [
        'types' => [
            'boolean',
            'callback',
            'double',
            'integer',
            'real',
            'str',
        ],
    ],
    'phpdoc_separation'              => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary'                 => true,
    'phpdoc_tag_type'                => [
        'tags' => [
            'api'        => 'annotation',
            'author'     => 'annotation',
            'copyright'  => 'annotation',
            'deprecated' => 'annotation',
            'example'    => 'annotation',
            'global'     => 'annotation',
            'inheritDoc' => 'inline',
            'internal'   => 'annotation',
            'license'    => 'annotation',
            'method'     => 'annotation',
            'package'    => 'annotation',
            'param'      => 'annotation',
            'property'   => 'annotation',
            'return'     => 'annotation',
            'see'        => 'annotation',
            'since'      => 'annotation',
            'throws'     => 'annotation',
            'todo'       => 'annotation',
            'uses'       => 'annotation',
            'var'        => 'annotation',
            'version'    => 'annotation',
        ],
    ],
    'phpdoc_to_comment' => [
        'ignored_tags' => [],
    ],
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_trim'                                   => true,
    'phpdoc_types'                                  => [
        'groups' => [
            'simple',
            'alias',
            'meta',
        ],
    ],
    'phpdoc_types_order' => [
        'sort_algorithm'  => 'none',
        'null_adjustment' => 'always_first',
    ],
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_var_without_name'             => true,
];

$returnRules = [
    'no_useless_return'      => true,
    'return_assignment'      => true,
    'simplified_null_return' => true,
];

$semicolonRules = [
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'no_empty_statement'                         => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'semicolon_after_instruction'                => true,
    'space_after_semicolon'                      => [
        'remove_in_empty_for_expressions' => true,
    ],
];

$strictRules = [
];

$stringNotationRules = [
    'simple_to_complex_string_variable' => true,
    'single_quote'                      => [
        'strings_containing_single_quote_chars' => true,
    ],
    'explicit_string_variable' => true,
    'heredoc_to_nowdoc'        => true,
    'no_binary_string'         => true,
];

$whitespaceRules = [
    'array_indentation'           => true,
    'blank_line_before_statement' => [
        'statements' => [
            'break',
            'continue',
            'declare',
            'return',
            'throw',
            'try',
        ],
    ],
    'compact_nullable_typehint'   => true,
    'indentation_type'            => true,
    'line_ending'                 => true,
    'method_chaining_indentation' => true,
    'no_extra_blank_lines'        => [
        'tokens' => [
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
            'use_trait',
        ],
    ],
    'no_spaces_around_offset' => [
        'positions' => [
            'inside',
            'outside',
        ],
    ],
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_whitespace'       => true,
    'no_whitespace_in_blank_line'  => true,
    'single_blank_line_at_eof'     => true,
    'types_spaces'                 => [
        'space' => 'none',
    ],
];

return (new PhpCsFixer\Config('WterBerg/PHP'))
    ->setRules(array_merge(
        $aliasRules,
        $arrayRules,
        $basicRules,
        $casingRules,
        $castNotationRules,
        $classNotationRules,
        $classUsageRules,
        $commentRules,
        $constantNotationRules,
        $controlStructureRules,
        $doctrineAnnotationRules,
        $functionNotationRules,
        $importRules,
        $languageConstructRules,
        $listNotationRules,
        $namespaceNotationRules,
        $namingRules,
        $operatorRules,
        $phpTagRules,
        $phpUnitRules,
        $phpDocRules,
        $returnRules,
        $semicolonRules,
        $strictRules,
        $stringNotationRules,
        $whitespaceRules,
    ))
    ->setFinder($finder);
