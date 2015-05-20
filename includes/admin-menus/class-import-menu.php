<?php

/**
 * This class handles the import admin menu
 * @since 2.4.0
 * @package Code_Snippets
 */
class Code_Snippets_Import_Menu extends Code_Snippets_Admin_Menu {

	/**
	 * Class constructor
	 */
	function __construct() {
		parent::__construct( 'import',
			__( 'Import', 'code-snippets' ),
			__( 'Import Snippets', 'code-snippets' )
		);

		add_action( 'load-importer-code-snippets', array( $this, 'load' ) );
	}

	/**
	 * Load the admin menu
	 */
	public function load() {
		parent::load();
		$this->process_import_file();
	}

	/**
	 * Process the uploaded import file
	 *
	 * @uses import_snippets() to process the import file
	 * @uses wp_redirect() to pass the import results to the page
	 * @uses add_query_arg() to append the results to the current URI
	 */
	private function process_import_file() {

		/* Ensure the import file exists */
		if ( ! isset( $_FILES['code_snippets_import_file']['tmp_name'] ) ) {
			return;
		}

		/* Import the snippets. The result is the number of snippets that were imported */
		$result = import_snippets( $_FILES['code_snippets_import_file']['tmp_name'], $network );

		/* Send the amount of imported snippets to the page */
		$url = add_query_arg( false === $result ? array( 'error' => true ) : array( 'imported' => $result ) );
		wp_redirect( esc_url_raw( $url ) );
	}
}
