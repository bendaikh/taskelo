<?php

return [
	// Directories that hold your Blade templates
	'paths' => [
		resource_path('views'),
	],

	// Where compiled Blade templates are stored
	'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
];


