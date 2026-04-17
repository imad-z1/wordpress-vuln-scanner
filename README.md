# wordpress-vuln-scanner
This scanner uses WordFence database vulnerability to check a db table that contain vulnerable plugins or themes it can be used internaly 

if you are looking to test the scanner consider running the pull_db python file to build your wordpress_db.sql not you can change how many plugins and themes to pull from WordPress API 
```bash
python pull_db.py

Make sure you have database called wordpress_db and run this SQL Query to create table for storing the wordpress plugins and themes

```sql
CREATE TABLE `wordpress_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `source` enum('wordpress.org','codecanyon') DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
```
to run the scanner you simply navigate to the directory where you downloaded the repo and run command

```bash
php scanner.php
```
expected resuls in terminal
**Result:**
```bash
==================================================
Vulnerabilities Scanner for WordPress Plugins and Themes
==================================================
==================================================
loading wordfence_db
total entries (36765)
==================================================
scanning db with wordfence vulnerabilities
WooCommerce;plugin;9.1;medium;4.4;CVE-2025-49042;https://www.cve.org/CVERecord?id=CVE-2025-49042;consider to disable and wait for update.;
WPForms Lite;plugin;1.9;medium;4.4;CVE-2024-7056;https://www.cve.org/CVERecord?id=CVE-2024-7056;consider to disable and wait for update.;
Slider Revolution;plugin;6.6;medium;6.5;CVE-2025-9217;https://www.cve.org/CVERecord?id=CVE-2025-9217;consider to disable and wait for update.;
Essential Grid;plugin;3.0;medium;6.1;CVE-2023-47684;https://www.cve.org/CVERecord?id=CVE-2023-47684;consider to disable and wait for update.;
UberMenu;plugin;3.8;medium;6.4;CVE-2024-4710;https://www.cve.org/CVERecord?id=CVE-2024-4710;consider to disable and wait for update.;
Smush;plugin;3.16;low;2.7;CVE-2025-22288;https://www.cve.org/CVERecord?id=CVE-2025-22288;consider to disable and wait for update.;
Really Simple SSL;plugin;7.0;critical;9.8;CVE-2024-10924;https://www.cve.org/CVERecord?id=CVE-2024-10924;consider to disable and wait for update.;
TablePress;plugin;2.3;medium;6.4;CVE-2025-12324;https://www.cve.org/CVERecord?id=CVE-2025-12324;consider to disable and wait for update.;
Broken Link Checker;plugin;2.2;high;7.1;CVE-2024-8981;https://www.cve.org/CVERecord?id=CVE-2024-8981;consider to disable and wait for update.;
SureForms Contact Form, Payment Form &amp Other Custom Form Builder;plugin;1.7.3;medium;4.3;CVE-2025-10732;https://www.cve.org/CVERecord?id=CVE-2025-10732;consider to disable and wait for update.;
==================================================
total vulnerable items found (10)
==================================================
writing report to current directory filename report.csv
==================================================
```
a new file will be created called report.csv which conains all the vulnerable plugins and themes

**TODO**
* integrate Wordfence database API to build a fresh wordfence_vulnerabilites.json with cronjob setup

**Note**
you need to build your own wordfence_vulnerabilites.json using API key [read more](https://www.wordfence.com/help/wordfence-intelligence/v3-accessing-and-consuming-the-vulnerability-data-feed/)


