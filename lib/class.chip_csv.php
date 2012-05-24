<?php
/*
|-----------------
| Author:	Life.Object
| E-Mail:	life.object@gmail.com
| Website:	http://www.tutorialchip.com/
| Help:		http://www.tutorialchip.com/php-csv-parser-class/
| Version:	1.0
| Released: January 10, 2011
| Updated: January 10, 2011
|------------------
*/

class Chip_csv {
	
	/*
	|---------------------------
	| Properties
	|---------------------------
	*/
	
	private $args = array (
						'csv_file'			=>	NULL,
						'csv_delimiter'		=>	",",
						'csv_fields_num'	=>	TRUE,
						'csv_head_read'		=>	TRUE,
						'csv_head_label'	=>	TRUE,				
						'csv_write_array'	=>	NULL,
					);

	/*
	|---------------------------
	| Constructor
	|
	| @public
	|
	|---------------------------
	*/
	
	public function __construct() {
	}
	
	/*
	|---------------------------
	| Print variable in readable format
	|
	| @public
	| @param string|array|object $var
	|
	|---------------------------
	*/
	
	public function chip_print( $var ) { 
		
		echo "<pre>";
    	print_r($var);
   	 	echo "</pre>";
	
	}
	
	/*
	|---------------------------
	| Update default arguments
	| It will update default array of class i.e $args
	|
	| @private
	| @param array $args - input arguments
	| @param array $defatuls - default arguments 
	| @return array
	|
	|---------------------------
	*/
	
	private function chip_parse_args( $args = array(), $defaults = array() ) { 
		return array_merge( $defaults, $args );	 
	}
	
	/*
	|---------------------------
	| Set default arguments
	| It will set default array of class i.e $args
	|
	| @private
	| @param array $args
	| @return 0
	|
	|---------------------------
	*/
	
	private function set_args( $args = array() ) { 
		
		$defaults = $this->get_args();
		$args = $this->chip_parse_args( $args, $defaults );
		$this->args = $args;	 
	}
	
	/*
	|---------------------------
	| Get default arguments
	| It will get default array of class i.e $args
	|
	| @public
	| @return array
	|
	|---------------------------
	*/
	
	public function get_args() { 
		return $this->args;	 
	}
	
	/*
	|---------------------------
	| Set Read
	| It will read CSV file.
	|
	| @private
	! @return array
	|
	|---------------------------
	*/
	
	public function set_read( $args ) { 
		
		/* Arguments */
		$this->set_args( $args );
		$args = $this->get_args();
		//$this->chip_print( $args );
		extract( $args );
		
		/* Temporary Array */
		$temp = array();		
		$temp['csv_file_read']			= FALSE;
		$temp['csv_file_read_status']	= "Unknown Error";
		$temp['csv_file']				= $csv_file;
		
		/* CSV File Validation: Readability */
		
		if( !is_readable( $csv_file ) ) {
			$temp['csv_file_read_status']	= "CSV File is not Readable";
			return $temp;
		}
		
		/* CSV Data Array */
		$csv_file_data = array();
		
		/* CSV Head Label Logic */
		$csv_head_label_array = array();
		
		
		/* CSV Read Algorithm */
		$row = 1;
		$handle = fopen( $csv_file, "r" );
		while ( ( $data = fgetcsv( $handle, 1000, $csv_delimiter ) ) !== FALSE ) {
			
			/* CSV First Row: Assumed as Head */
			if( $csv_head_read  == FALSE && $row == 1 ) {
				
				/* Next Row */
				$row++;
				/* Skip Head */
				continue;				
			
			}
			
			/* CSV Fields in Current Row */
			$num = count($data);			
			
			/* Should We Take Fields Info */
			if( $csv_fields_num == TRUE ) {
				$csv_file_data[$row]['fields'] = $num;
			}
			
			/* Read CSV Fields in Current Row */			
			for ( $c = 0; $c < $num; $c++ ) {				
				
				/* CSV Standard Read */
				$csv_file_data[$row][$c] = $data[$c];
				
				/* CSV Head Label Logic */
				if( $csv_head_read  == TRUE && $csv_head_label == TRUE ) {					
					$head_label = strtolower ( $csv_file_data[1][$c] );
					$csv_file_data[$row][$head_label] = $data[$c];					
				}
			}
			
			/*  Next Row */
			$row++;
		}
		fclose($handle);
		
		/* Ready to Return */
		$temp['csv_file_read'] = TRUE;
		$temp['csv_file_read_status']	= "CSV File Read Successfully";
		$temp['csv_file_data'] = $csv_file_data;		
		
		
		return $temp;
			 
	}
	
	/*
	|---------------------------
	| Get Read
	| It will convert CSV data into Array.
	|
	| @public
	! @return array
	|
	|---------------------------
	*/
	
	public function get_read( $args = array() ) { 
		return $this->set_read( $args );	 
	}
	
	/*
	|---------------------------
	| Set Write
	| It will write CSV file.
	|
	| @private
	! @return array
	|
	|---------------------------
	*/
	
	public function set_write( $args ) { 
		
		/* Arguments */
		$this->set_args( $args );
		$args = $this->get_args();
		//$this->chip_print( $args );
		extract( $args );
		
		/* Temporary Array */
		$temp = array();		
		$temp['csv_file_write']			= FALSE;
		$temp['csv_file_write_status']	= "Unknown Error";
		$temp['csv_file']				= $csv_file;
		
		/* File Opening: Validation */
		if ( !$handle = fopen( $csv_file, 'w' ) ) {
			 $temp['csv_file_write_status'] = "Cannot Open File";
			 return $temp;
		}
		
		/* CSV Write Array: Validation */
		if( !( is_array( $csv_write_array ) && count( $csv_write_array ) >= 1 ) ) {
			 $temp['csv_file_write_status'] = "Unable to Process CSV Write Array";
			 return $temp;
		}
		
		/* Prepare Data to Write */
		$data = "";
		foreach( $csv_write_array as $val ) {
			
			$data_temp = '';
			foreach( $val as $val2 ) {
				$data_temp .= $val2 . $csv_delimiter;
			}
			
			$data .= rtrim( $data_temp, $csv_delimiter ) . "\r\n";
		}	
		
		/* Write Data */
		if ( fwrite( $handle, $data ) === FALSE ) {
			$temp['csv_file_write_status'] = "Cannot Write to File";
			 return $temp;
		}
		
		else {
			
			$temp['csv_file_write']			= TRUE;
			$temp['csv_file_write_status'] = "CSV File Written Successfully";
		
		}
		
		return $temp;
			 
	}
	
	/*
	|---------------------------
	| Get Write
	| It will write CSV file from PHP Array
	|
	| @public
	! @return array
	|
	|---------------------------
	*/
	
	public function get_write( $args = array() ) { 
		return $this->set_write( $args );	 
	}

	/*
	|---------------------------
	| Destructor
	|---------------------------
	*/
	
	public function __destruct() {
	}
}
?>