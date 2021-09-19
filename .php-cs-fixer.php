<?php

declare(strict_types=1);

$header = file_get_contents('LICENSE');
$header .= <<<'EOF'

@package	CiFireCMS
@author	Adiman
@license	https://opensource.org/licenses/MIT	MIT License
@link	https://github.com/CiFireCMS/cifirecms
@since	Version 2.0.1
@filesource
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'content',
        'vendor'
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR2' => true,
        'header_comment' => ['header' => $header],
    ])
    ->setFinder($finder);
