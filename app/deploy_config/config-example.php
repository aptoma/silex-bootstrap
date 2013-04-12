<?php

$config['monolog.level'] = 100;
$config['debug'] = true;

// Meta fields are passed on to Logstash
$config['meta.service'] = 'silex-bootstrap';
$config['meta.customer'] = 'Aptoma';
$config['meta.environment'] = 'production';
