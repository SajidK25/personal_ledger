<?php

require_once 'Category.php';
require_once 'Entry.php';
require_once 'Ledger.php';
require_once 'CLI.php';

$ledger = new Ledger('data.json');
$cli = new CLI($ledger);
$cli->run();
