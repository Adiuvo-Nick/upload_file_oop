<?php

class uploadoop {

	/**
	 * upload name
	 *
	 * @var string
	 */
	private $file_name;

	/**
	 * upload type
	 *
	 * @var string
	 */
	private $file_type;

	/**
	 * upload size
	 *
	 * @var int
	 */
	private $file_size;

	/**
	 * upload tmpname
	 *
	 * @var string
	 */
	private $file_tmpname;

	/**
	 * upload error
	 *
	 * @var string
	 */
	private $file_error;

	/**
	 * file count
	 *
	 * @var int
	 */
	private $file_count;

	/**
	 * Random ID
	 *
	 * @var string
	 */
	private $random_id;

	/**
	 * file succes
	 *
	 * @var int
	 */
	private $file_upload_successful;

	/**
	 * errors
	 *
	 * @var string
	 */
	private $size_limit;

	private $file_upload_limit = 'Er kunnen maar 3 bestanden worden geupload';

	private $size_limit_exceed = 'Bestand is te groot';

	private $file_type_match = 'Bestandstype PDF alleen toegestaan';


	// Hier worden alle POST methods opgehaald
	public function __construct() {
		$this->file_name = $_FILES['upload']['name'];
		$this->file_type = $_FILES['upload']['type'];
		$this->file_size = $_FILES['upload']['size'];
		$this->file_tmpname = $_FILES['upload']['tmp_name'];
		$this->file_error = $_FILES['upload']['error'];
		$this->file_count = count($_FILES['upload']['name']);
		$this->size_limit = 1.5 * (1024 * 1024);
		$this->file_upload_successful = 1;
		$this->random_id = uniqid();
	}


	public function run() {
		// 3 bestanden limit
		if ($this->file_count > 3) {
			$this->file_upload_successful = 0;
			echo $this->file_upload_limit;
		}

		//for loop
		for ( $i = 0; $i < $this->file_count; $i ++ ) {

			// File type vergelijken
			$finfo = finfo_open( FILEINFO_MIME_TYPE );

			$mime  = finfo_file( $finfo, $this->file_tmpname [ $i ] );
			switch ( $mime ) {
				case 'application/pdf':
					break;
				default:
					$this->file_upload_successful = 0;
					echo $this->file_type_match;
			}


			// Als filesize groter is dan 1,5 mb
			if ( $this->file_size [ $i ] > $this->size_limit ) {
				$this->file_upload_successful = 0;
				echo $this->size_limit_exceed;
			}

			// Wanneer bestand voldoet aan alle eisen, upload bestand naar map
			if ( $this->file_upload_successful == 1 ) {
				echo $this->file_name[ $i ] . " is geupload</br>";
				if ( ! file_exists( './uploads/' . $this->random_id ) ) {
					mkdir( './uploads/' . $this->random_id, 0777, true );
				}
				$newFilePath = "./uploads/" . $this->random_id . '/' . $this->file_name[ $i ];

				if ( move_uploaded_file( $this->file_tmpname[ $i ], $newFilePath ) ) {
					$myfile = fopen( "uploads.txt", "a" );
					$txt    = 'Date: ' . date( 'Y-m-d \TH:i:s' ) . ' Path: ' . $newFilePath . PHP_EOL;
					fwrite( $myfile, $txt );
					fclose( $myfile );
				}
			}
		}
	}

	public function codeToMessage()
	{
		switch ($this->file_error) {
			case UPLOAD_ERR_INI_SIZE:
				echo "The uploaded file exceeds the upload_max_filesize directive in php.ini";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
				break;
			case UPLOAD_ERR_PARTIAL:
				echo "The uploaded file was only partially uploaded";
				break;
			case UPLOAD_ERR_NO_FILE:
				echo "No file was uploaded";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				echo "Missing a temporary folder";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				echo "Failed to write file to disk";
				break;
			case UPLOAD_ERR_EXTENSION:
				echo "File upload stopped by extension";
				break;
			default:
				echo "Unknown upload error";
				break;
		}
	}
}

$upload = new uploadoop();
echo '<h1>Upload overzicht</h1>';
if($_FILES['upload']['error']['0'] ==0) {
	$upload->run();
}
else {
	$upload->codeToMessage();
}





