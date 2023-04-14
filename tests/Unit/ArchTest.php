<?php

declare(strict_types=1);

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump'])
    ->each->not->toBeUsed();
