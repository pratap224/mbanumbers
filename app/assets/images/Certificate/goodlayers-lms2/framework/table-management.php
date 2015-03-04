<?php
	/*	
	*	Goodlayers Table Management File
	*/
	
	// create new table upon plugin activation
	function gdlr_lms_create_user_table(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		
		// for online course
		$table_name = $wpdb->prefix . 'gdlrquiz';
		$sql = "CREATE TABLE $table_name (
			id bigint(20) unsigned NOT NULL auto_increment,
			course_id bigint(20) unsigned DEFAULT NULL,
			quiz_id bigint(20) unsigned DEFAULT NULL,
			student_id bigint(20) unsigned DEFAULT NULL,
			quiz_answer longtext DEFAULT NULL,
			quiz_score longtext DEFAULT NULL,
			quiz_status varchar(20) DEFAULT NULL,
			retake_times bigint(20) unsigned DEFAULT 0,
			PRIMARY KEY (id)
		);";
		dbDelta( $sql );
		
		// for payment transaction
		$table_name = $wpdb->prefix . 'gdlrpayment';
		$sql = "CREATE TABLE $table_name (
			id bigint(20) unsigned NOT NULL auto_increment,
			course_id bigint(20) unsigned DEFAULT NULL,
			student_id bigint(20) unsigned DEFAULT NULL,
			author_id bigint(20) unsigned DEFAULT NULL,
			payment_info longtext DEFAULT NULL,
			price decimal(19,4) DEFAULT NULL,
			payment_status varchar(20) DEFAULT NULL,
			payment_date datetime DEFAULT NULL,
			attachment longtext DEFAULT NULL,
			attendance datetime DEFAULT NULL,
			attendance_section bigint(20) unsigned DEFAULT NULL,
			PRIMARY KEY (id)
		);";
		dbDelta( $sql );		
	}	
	
	// change data type to match with sql table
	class gdlr_lms_quiz{
		public $quiz = array();
		
		function __construct($quiz){
			$this->quiz = $quiz;
		}	
	}
	
	class gdlr_lms_payment{
		public $payment = array();
		
		function __construct($payment){
			$this->payment = $payment;
		}			
	}	
	
?>