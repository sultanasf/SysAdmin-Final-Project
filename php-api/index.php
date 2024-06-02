<?php
require './vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

$adapter = new InMemory();
$registry = new CollectorRegistry($adapter);

// Create a histogram to track request durations
$histogram = $registry->getOrRegisterHistogram(
    'myapp',
    'request_duration_seconds',
    'Histogram of request durations',
    ['method', 'endpoint'],
    [0.1, 0.5, 1, 1.5, 2, 5]
);

// Start the timer
$start = microtime(true);

// Your application logic here
$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_SERVER['REQUEST_URI'];

// Simulate processing time
usleep(rand(100, 1000) * 1000);

// End the timer
$duration = microtime(true) - $start;

// Observe the duration
$histogram->observe($duration, [$method, $endpoint]);

// Expose metrics
if ($_SERVER['REQUEST_URI'] === '/metrics') {
    $renderer = new RenderTextFormat();
    $metrics = $registry->getMetricFamilySamples();
    header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
    echo $renderer->render($metrics);
    exit;
}

// Your usual response
echo json_encode(['message' => 'Hello World!']);
