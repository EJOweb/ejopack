<?php	

final class EJOpack_Settings
{
	//* Holds the instance of this class.
	private static $instance;

	//* Store slug of settings page
	public static $settings_page = 'ejopack-settings';

	//* Plugin setup.
	private function __construct() 
	{
		//* Add Settings page
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

		//* Add stylesheet to settings page
		add_action( 'admin_enqueue_scripts', array( $this, 'add_stylesheet' ) );
	}

	//*
	public function add_settings_page()
	{
		add_menu_page(  
			'EJOpack Instellingen', 
			'EJOpack', 
			'manage_options', 
			self::$settings_page, 
			array( $this, 'settings_page' ),
			'dashicons-screenoptions'
		);
	}

	//*
	public function settings_page()
	{
	?>
		<div class='wrap' style="max-width:960px;">
			<h2>EJOpack Instellingen</h2>
			<p>Lijst maken om modules aan te kunnen vinken en opslaan in options</p>
			<?php

				$columns = 2;				
				$all_modules_table = self::array_to_table( EJOpack::$all_modules, $columns );

				echo '<form action="' . $_SERVER['PHP_SELF'] . ' method="post">';

				echo '<table>';
				echo '<tbody>';

				foreach ($all_modules_table as $module_row) {

					echo '<tr>';

					foreach ($module_row as $module) {
						echo '<td>';
						echo $module;
						echo '</td>';
					}

					echo '</tr>';
				}

				echo '</table>';
				echo '</tbody>';

				echo '</form>';

			?>
		</div>
	<?php
	}

	//* Prepare array for table
	public function array_to_table( $one_dimensional_array, $columns = 2 )
	{
		/**
		 * Process array-lenght to match table of columns
		 */
		$array_length = count($one_dimensional_array);

		//* If count of modules is nicely divided by given columns
		if ( ($array_length % $columns) == 0 ) {
			$new_array_length = $array_length;
		}

		//* If count of modules is smaller than given columns
		elseif ( $array_length < $columns ) {
			$new_array_length = $columns;
		}

		//* Fill array to evenly divide over given columns
		else {
			$modulus = ($array_length % $columns);
			$difference = $columns - $modulus;

			$new_array_length = $array_length + $difference;					
		}

		$one_dimensional_array = array_pad( $one_dimensional_array, $new_array_length, '');

		/**
		 * Put array in table of columns
		 */
		$table_array = array();

		for ( $i=0, $row=0; $i < $new_array_length; $i++ ) {

			//* Get modulus
			$modulus = $i % $columns;

			//* Move to next row
			if ($i != 0 && $modulus == 0)
				$row++;

			//* Write first value of array to table_array
			$table_array[$row][] = array_shift($one_dimensional_array);
		}

		//* Return 2-dimensional array suitable for table-structure
		return $table_array;
	}

	//* Add stylesheets
	public function add_stylesheet()
	{
		//* Settings Page
		if ( isset($_GET['page']) && $_GET['page'] == self::$settings_page ) {
			//* Settings page stylesheet
			wp_enqueue_style( 'ejopack-settings-page', EJOpack::$inc_uri ."css/admin-settings-page.css", array(), EJOpack::$version );
		}
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

}