<?php

declare( strict_types=1 );

use Isolated\Symfony\Component\Finder\Finder;

// You can do your own things here, e.g. collecting symbols to expose dynamically
// or files to exclude.
// However beware that this file is executed by PHP-Scoper, hence if you are using
// the PHAR it will be loaded by the PHAR. So it is highly recommended to avoid
// to auto-load any code here: it can result in a conflict or even corrupt
// the PHP-Scoper analysis.

return [
	// The prefix configuration. If a non null value is be used, a random prefix
	// will be generated instead.
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#prefix
	'prefix'                  => 'WPMUDEV_Analytics_Vendor',

	// By default when running php-scoper add-prefix, it will prefix all relevant code found in the current working
	// directory. You can however define which files should be scoped by defining a collection of Finders in the
	// following configuration key.
	//
	// This configuration entry is completely ignored when using Box.
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#finders-and-paths
	'finders'                 => [
		Finder::create()
		      ->files()
		      ->ignoreVCS( true )
		      ->notName( '/LICENSE|.*\\.md|.*\\.dist|.*\\.yml|Makefile|.gitignore|composer\\.json|MobileDetect\\.json|composer\\.lock/' )
		      ->exclude( [
			      'doc',
			      'docs',
			      'test',
			      'tests',
			      'examples',
		      ] )
		      ->in( [
			      'vendor/mixpanel/mixpanel-php',
		      ] ),
	],

	// List of excluded files, i.e. files for which the content will be left untouched.
	// Paths are relative to the configuration file unless if they are already absolute
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
	'exclude-files'           => [
		/*'src/a-whitelisted-file.php',*/
	],

	// When scoping PHP files, there will be scenarios where some of the code being scoped indirectly references the
	// original namespace. These will include, for example, strings or string manipulations. PHP-Scoper has limited
	// support for prefixing such strings. To circumvent that, you can define patchers to manipulate the file to your
	// heart contents.
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
	'patchers'                => [
		static function ( string $filePath, string $prefix, string $content ): string {
			$class_names = array(
				'ConsumerStrategies_AbstractConsumer',
				'ConsumerStrategies_FileConsumer',
				'ConsumerStrategies_CurlConsumer',
				'ConsumerStrategies_SocketConsumer',
				'Producers_MixpanelBaseProducer',
				'Producers_MixpanelEvents',
				'Producers_MixpanelGroups',
				'Producers_MixpanelPeople',
			);
			$pattern     = '~([\'"])(' . join( '|', $class_names ) . ')\1~';

			return preg_replace( $pattern, '$1WPMUDEV_Analytics_Vendor\\\$2$1', $content );
		},
	],

	// List of symbols to consider internal i.e. to leave untouched.
	//
	// For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#excluded-symbols
	'exclude-namespaces'      => [
		// 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
		// '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
		// '~^$~',                        // The root namespace only
		// '',                            // Any namespace
	],
	'exclude-classes'         => [
		// 'ReflectionClassConstant',
	],
	'exclude-functions'       => [
		// 'mb_str_split',
	],
	'exclude-constants'       => [
		// 'STDIN',
	],

	// List of symbols to expose.
	//
	// For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#exposed-symbols
	'expose-global-constants' => true,
	'expose-global-classes'   => false,
	'expose-global-functions' => true,
	'expose-namespaces'       => [
		// 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
		// '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
		// '~^$~',                        // The root namespace only
		// '',                            // Any namespace
	],
	'expose-classes'          => [],
	'expose-functions'        => [],
	'expose-constants'        => [],
];