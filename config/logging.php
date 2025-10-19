<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Monolog\Processor\PsrLogMessageProcessor;

return [
	'default' => env('LOG_CHANNEL', 'stack'),

	'deps' => [
		// register processors used by channels
		'processors' => [
			PsrLogMessageProcessor::class,
		],
	],

	'channels' => [
		'stack' => [
			'driver' => 'stack',
			'channels' => ['single'],
			'ignore_exceptions' => false,
		],

		'single' => [
			'driver' => 'single',
			'path' => storage_path('logs/laravel.log'),
			'level' => env('LOG_LEVEL', 'debug'),
			'replace_placeholders' => true,
		],

		'null' => [
			'driver' => 'monolog',
			'handler' => NullHandler::class,
			'level' => 'debug',
			'replace_placeholders' => true,
		],

		'daily' => [
			'driver' => 'daily',
			'path' => storage_path('logs/laravel.log'),
			'level' => env('LOG_LEVEL', 'debug'),
			'days' => 14,
			'replace_placeholders' => true,
		],
	],
];


