<?php
require_once __DIR__ . '/../wp-config.php';
require_once __DIR__ . '/../wp-includes/class-wpdb.php';

global $wpdb;

//create a new db connection

$new_db = new wpdb('root', '', 'wordpress_db', 'localhost');

// get all plugins and themes from db table wordpress_items

$results = $new_db->get_results("SELECT * FROM wordpress_items");

echo PHP_EOL.str_repeat("=",50) . PHP_EOL;

echo "Vulnerabilities Scanner for WordPress Plugins and Themes".PHP_EOL;

echo str_repeat("=",50) . PHP_EOL;

echo str_repeat("=",50) . PHP_EOL;

echo "loading wordfence_db ".PHP_EOL;

$db_file_name = 'wordfence_vulnerabilities.json';

$wordfence_db = file_get_contents($db_file_name);

$data = json_decode( $wordfence_db, true );

if ( json_last_error() === JSON_ERROR_NONE ) {

 	$db = $data;

}else{

	die("something wrong with wordfence_vulnerabilities");

}
echo "total entries (".count($db) .")".PHP_EOL;

echo str_repeat("=",50) . PHP_EOL;

echo "scanning db with wordfence vulnerabilities ".PHP_EOL;

$report = 'item vulnerable;type;version;severity;score;cve;cve_link;action;'.PHP_EOL;

$vulnerable_count= 0;

foreach ($results as $row) {

	$key = array_search($row->slug, array_column($db, 'slug'));

	if($key != false){

		$item = $db[$key];
		if(version_compare($row->version , $item['to_version'], '<=') ){
			$name = str_replace(';','',$row->name);
			$line = sprintf('%s;%s;%s;%s;%s;%s;%s;%s;',$name,$item['type'],$row->version,$item['severity'],$item['cvss_score'],$item['cve'],$item['cve_link'],'consider to disable and wait for update.') . PHP_EOL;
			$report .= $line;
			echo $line;
			$vulnerable_count+=1;
		}
	}
}

echo str_repeat("=",50) . PHP_EOL;

echo "total vulnerable items found (".$vulnerable_count.")".PHP_EOL;

echo str_repeat("=",50) . PHP_EOL;

echo "writing report to current directory filename report.csv ".PHP_EOL;

file_put_contents('report.csv',$report);

echo str_repeat("=",50) . PHP_EOL;


