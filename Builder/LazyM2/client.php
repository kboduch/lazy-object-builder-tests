<?php

use App\Builder\LazyM2\ClientBuilder;

require_once __DIR__ . '/../../../../vendor/autoload.php';

//$b = \App\Builder\LazyM2\ClientBuilder::default()->withNameShort('asd')->build();
//$b2 = \App\Builder\LazyM2\ClientBuilder::default()->withNameShort(fn():string=>'asd')->build();
$b2 = ClientBuilder::default()->withNameShort(static fn () => 'asd')->build();
$b3 = ClientBuilder::default()->withNameShort(static fn () => 1)->build();
