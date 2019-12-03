<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use EuCheckVatService\CheckVat;

// Full check
print_r(CheckVat::exec('AT', 'U65923833', true));

// Simple Check
var_dump(CheckVat::exec('AT', 'U65923833'));
