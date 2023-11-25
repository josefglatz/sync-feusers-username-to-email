<?php

declare(strict_types=1);

return \Symfony\Component\Finder\Finder::create()
    ->files()
    ->in(__DIR__)
    ->ignoreVCSIgnored(true)
    ->exclude([
        'Resources/Public/Css',
        'Resources/Public/JavaScript',
    ]);
