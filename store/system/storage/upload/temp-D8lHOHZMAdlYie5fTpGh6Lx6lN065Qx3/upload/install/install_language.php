<?php
/**
 * @version		$Id: install_language.php 4466 2016-10-11 13:53:40Z mic $
 * @package		Postinstaller Translation
 * @author		mic - https://osworx.net
 * @copyright	2016 OSWorX - https://osworx.net
 * @license		OCL OSWorX Commercial License - https://osworx.net
 */

$pi = new \PostInstaller();
$pi->init();
$pi->installLanguage();
$pi->translateTables();
$pi->removeFiles();
$pi->writeLog();
$pi->finish();

class PostInstaller
{
	public $_version	= '1.0.0';
	private $msg		= array();
	private $lng		= 'de-DE';
	private $lang;
	private $language_id;

	/**
	 * initialize the module
	 * because file can be called from several places,
	 * LANGUAGE_POST_INSTALL is defined when integrated installer is used
	 */
	public function init() {
		if( !defined( 'LANGUAGE_POST_INSTALL' ) ) {
			include( '../config.php' );
			include( '../system/library/db.php' );
			include( '../system/library/db/mysqli.php' );
		}

		if( !defined( 'DIR_APPLICATION' ) ) {
			die('..');
		}

		$this->getShopVersion();
		$this->getLang();

		$this->db = new \DB( 'mysqli', DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT );

		$this->addMsg( sprintf( $this->lang['text_init'], $this->lng ) );
	}

	/**
	 * install new language into DB
	 * check first if it is not installed
	 */
	public function installLanguage() {
		$sql = '
		SELECT
			`language_id`
		FROM
			`' . DB_PREFIX . 'language`
		WHERE
			`code` = \'de-de\'';

		$result = $this->db->query( $sql );

		if( !$result->num_rows ) {
			$sql = '
			INSERT INTO
				`' . DB_PREFIX . 'language`
			SET
				`name` = \'Deutsch\',
				`code` = \'de-DE\',
				`locale` = \'de,de-DE,de_DE,de-de,german,de_DE.UTF-8\',
				`image` = \'de.png\',
				`directory` = \'de-DE\',
				`sort_order` = \'2\',
				`status` = \'1\'';

			$this->db->query( $sql );

			$this->language_id = $this->db->getLastId();

			$msg = sprintf( $this->lang['text_install_success'], $this->lng );
		}else{
			$this->language_id = $result->row['language_id'];
			$msg = sprintf( $this->lang['text_already_installed'], $this->lng );
		}

		$this->addMsg( $msg );
	}

	/**
	 * function will go through several tables
	 * and copy the original english values to the new language fields
	 */
	public function translateTables() {
		$new = false;

		// single tables, only name
		$tables = array(
			'attribute_group_description'	=> array(
				'fields'	=> array( 'name', 'attribute_group_id' ),
				'msg'		=> $this->lang['text_log_attribute_group']
			),
			'custom_field_description'		=> array(
				'fields'	=> array( 'name', 'custom_field_id' ),
				'msg'		=> $this->lang['text_log_custom_field']
			),
			'download_description'			=> array(
				'fields'	=> array( 'name', 'download_id' ),
				'msg'		=> $this->lang['text_log_download']
			),
			'filter_group_description'		=> array(
				'fields'	=> array( 'name', 'filter_group_id' ),
				'msg'		=> $this->lang['text_log_filter_group']
			),
			'order_status'	=> array(
				'fields'	=> array( 'name', 'order_status_id' ),
				'msg'		=> $this->lang['text_log_order_status']
			),
			'option_description'	=> array(
				'fields'	=> array( 'name', 'option_id' ),
				'msg'		=> $this->lang['text_log_option_description']
			),
			'recurring_description'			=> array(
				'fields'	=> array( 'name', 'recurring_id' ),
				'msg'		=> $this->lang['text_log_recurring']
			),
			'return_action'					=> array(
				'fields'	=> array( 'name', 'return_action_id' ),
				'msg'		=> $this->lang['text_log_return_action']
			),
			'return_reason'					=> array(
				'fields'	=> array( 'name', 'return_reason_id' ),
				'msg'		=> $this->lang['text_log_return_reason']
			),
			'return_status'					=> array(
				'fields'	=> array( 'name', 'return_status_id' ),
				'msg'		=> $this->lang['text_log_return_status']
			),
			'stock_status'					=> array(
				'fields'	=> array( 'name', 'stock_status_id' ),
				'msg'		=> $this->lang['text_log_stock_status']
			),
			'voucher_theme_description'		=> array(
				'fields'	=> array( 'name', 'voucher_theme_id' ),
				'msg'		=> $this->lang['text_log_voucher_theme']
			)
		);

		foreach( $tables as $k => $value ) {
			$new = false;

			if( $result = $this->getTableEntries( $k ) ) {
				foreach( $result as $row ) {
					if( !$this->fieldExist( $k, $value['fields'], 'name', $row['name'] ) ) {
						$new = true;
						$this->insertNew( $k, $row, $value['fields'] );
					}
				}

				if( $new ) {
					$this->addMsg( $value['msg'] );
				}
			}
		}

		/** multi field entries */
		$tables = array(
			'category_description'		=> array(
				'search'	=> 'name',
				'fields'	=> array( 'name', 'description', 'category_id' ),
				'msg'		=> $this->lang['text_log_category']
			),
			'product_description'				=> array(
				'search'	=> 'name',
				'fields'	=> array( 'name', 'description', 'product_id' ),
				'msg'		=> $this->lang['text_log_product']
			),
			'information_description'			=> array(
				'search'	=> 'title',
				'fields'	=> array( 'title', 'description', 'information_id' ),
				'msg'		=> $this->lang['text_log_information']
			),
			'customer_group_description'	=> array(
				'search'	=> 'name',
				'fields'	=> array( 'name', 'description', 'customer_group_id' ),
				'msg'		=> $this->lang['text_log_customer_group']
			),
			'custom_field_value_description'	=> array(
				'search'	=> 'name',
				'fields'	=> array( 'custom_field_id', 'name', 'custom_field_value_id' ),
				'msg'		=> $this->lang['text_log_custom_field_value']
			),
			'length_class_description'	=> array(
				'search'	=> 'title',
				'fields'	=> array( 'title', 'unit', 'length_class_id' ),
				'msg'		=> $this->lang['text_log_length_class']
			),
			'option_value_description'	=> array(
				'search'	=> 'name',
				'fields'	=> array( 'option_id', 'name', 'option_value_id' ),
				'msg'		=> $this->lang['text_log_option_value']
			),
			'weight_class_description'	=> array(
				'search'	=> 'title',
				'fields'	=> array( 'title', 'unit', 'weight_class_id' ),
				'msg'		=> $this->lang['text_log_weight_class']
			)
		);

		foreach( $tables as $k => $value ) {
			$new = false;

			if( $result = $this->getTableEntries( $k ) ) {
				foreach( $result as $row ) {
					if( !$this->fieldExist( $k, $value['fields'], $value['search'], $row[$value['search']] ) ) {
						$new = true;
						$this->insertNew( $k, $row, $value['fields'] );
					}
				}

				if( $new ) {
					$this->addMsg( $value['msg'] );
				}
			}
		}
	}

	/**
	 * remove not needed dirs and files
	 */
	public function removeFiles() {
		$this->addMsg( sprintf( $this->lang['text_log_remove_dir_files'], VERSION ) );

		$toRemove = array(
			'2.2' => array(
				'dirs' => array(
					'admin' => array(
						'extension/analytics', 'extension/captcha', 'extension/dashboard',
						'extension/extension', 'extension/feed', 'extension/fraud',
						'extension/module', 'extension/openbay', 'extension/payment',
						'extension/shipping', 'extension/theme', 'extension/total'
					),
					'catalog' => array(
						'extension',
					)
				),
				'files' => array(
					'admin' => array(
						'extension/event', 'extension/extension', 'extension/store',
						'report/customer_search'
					)
				)
			),
			'2.3' => array(
				'dirs' => array(
					'admin' => array(
						'analytics', 'captcha', 'dashboard', 'feed', 'fraud', 'module', 'openbay',
						'payment', 'shipping', 'theme', 'total'
					),
					'catalog' => array(
						'captcha', 'credit_card', 'module', 'openbay', 'payment', 'shipping', 'total'
					)
				),
				'files' => array(
					'admin' => array(
						'common/menu', 'common/stats',
						'extension/analytics', 'extension/captcha', 'extension/feed',
						'extension/fraud', 'extension/module', 'extension/payment',
						'extension/shipping', 'extension/theme', 'extension/total',
						'sale/custom_field', 'sale/customer', 'sale/customer_ban_ip',
						'sale/customer_field', 'sale/customer', 'sale/customer_ban_ip',
						'sale/customer_group',
						'report/affiliate_commision',
						'tool/about', 'tool/error_log'
					),
					'catalog' => array(
						'checkout/coupon', 'checkout/reward', 'checkout/shipping',
						'checkout/voucher'
					)
				)
			)
		);

		if( version_compare( VERSION, '2.3', '<' ) ) {
			$files = $toRemove['2.2'];
		}else{
			$files = $toRemove['2.3'];
		}

		$root = str_replace( 'admin/', '', DIR_APPLICATION );

		foreach( $files['files'] as $k => $value ) {
			foreach( $value as $v ) {
				$file = $root . $k . '/language/' . $this->lng . '/' . $v . '.php';

				if( file_exists( $file ) ) {
					if( is_file( $file ) ) {
						unlink( $file );
						$this->addMsg( 'F [' . $file . ']' );
					}elseif( is_dir( $file ) ) {
						rmdir( $file );
						$this->addMsg( '** D [' . $file . ']' );
					}
				}
			}
		}

		clearstatcache();

		foreach( $files['dirs'] as $k => $value ) {
			foreach( $value as $v ) {
				$this->rrmdir( $root . $k . '/language/' . $this->lng . '/' . $v );
			}
		}

		clearstatcache();
	}

	/**
	 * display summary (HTML) - only if called during the installation process
	 * @return string
	 */
	public function finish() {
		if( defined( 'LANGUAGE_POST_INSTALL' ) ) {
			return;
		}

		$tpl = '<!DOCTYPE html>
<html lang="' . $this->lang['lang'] . '">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>' . $this->lang['header_title'] . ']</title>
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen" />
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="view/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.js"></script>
<style>
	body { background: url(view/image/intro-bg.jpg) no-repeat center; background-color: #535D66; }
	.box { height: 260px; }
	.txt { height: 190px; }
	@media (max-width: 992px) {
		.box { height: auto; }
		.txt { height: auto; }
	}
	.inactive { display: none; }
</style>
</head>
<body>
<div class="container">
	<div class="row">
	    <div class="col-lg-12">
	        <h2 class="page-header">' . $this->lang['heading_title'] . '</h2>
	    </div>
	    <div id="detail-view" class="inactive">
			<div class="col-md-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">' . $this->lang['text_report_header'] . '</div>
		        	<div class="panel-body">'
						. implode( '<br />', $this->msg ). '
		        		<div style="margin: 20px 0 0 0;">
							<button id="closeReport" class="btn btn-primary" /> ' . $this->lang['btn_close'] . '</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	    <div class="col-md-4">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h4><i class="fa fa-fw fa-check"></i> ' . $this->lang['text_section_installation'] . '</h4>
	            </div>
	            <div class="panel-body box">
	                <div class="txt">' . $this->lang['text_success'] . '</div>
    				<a id="details" class="btn btn-default">' . $this->lang['btn_details'] . '</a>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-4">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h4><i class="fa fa-fw fa-gift"></i> ' . $this->lang['text_section_free'] . '</h4>
	            </div>
	            <div class="panel-body box">
	                <div class="txt">' . $this->lang['text_free'] . '</div>
	                <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7APD3NEMJENWG" target="_blank" class="btn btn-primary">' . $this->lang['btn_yes'] . '</a>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-4">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h4><i class="fa fa-fw fa-compass"></i> ' . $this->lang['text_section_service'] . '</h4>
	            </div>
	            <div class="panel-body box">
	                <div class="txt">' . $this->lang['text_service'] . '</div>
	                <a href="https://osworx.net?ref=language-install" target="_blank" class="btn btn-success">' . $this->lang['btn_more'] . '</a>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<div class="container">
	<div style="margin: 20px auto; text-align: center; padding: 10px;">
	    <div class="col-lg-12">
	        <a href="../" class="btn btn-default" style="margin: 10px;" title="' . $this->lang['text_title_shop'] . '">' . $this->lang['btn_shop'] . '</a> <a href="../admin/" class="btn btn-default" style="margin: 10px;" title="' . $this->lang['text_title_admin'] . '">' . $this->lang['btn_admin'] . '</a>
	    </div>
	</div>
</div>
<footer>
	<div class="container">
		&copy ' . date('Y') . ' <a href="https://osworx.net" target="_blank">OSWorX</a>
    </div>
</footer>
<script>
	$(\'#details\').on(\'click\',function(){
		if( $(\'#detail-view\').hasClass(\'active\') ) {
			$(\'#detail-view\').hide(400).removeClass(\'active\').addClass(\'inactive\');
		}else{
			$(\'#detail-view\').show(400).removeClass(\'inactive\').addClass(\'active\');
		}
	});
	$(\'#closeReport\').on(\'click\',function(){
		$(\'#details\').trigger(\'click\');
	});
</script>
</body>
</html>';

		echo $tpl;
	}

	/**
	 * write all messages at once into logfile
	 */
	public function writeLog() {
		$content = implode( "\n", $this->msg );
		$content = strip_tags( $content );
		$fh = fopen( DIR_LOGS . 'error.log', 'wb' );
		fwrite( $fh, date( 'Y-m-d H:i:s' ) . " ** " . $this->lang['text_log_header'] . "\n" );
		fwrite( $fh, $content );
		fclose( $fh );
	}

	/**
	 * read entire index.php and get version
	 */
	private function getShopVersion() {
		if( !defined( 'VERSION' ) ) {
			$version = '2.0.0.0';
			$content = file( '../index.php' );

			foreach( $content as $line ) {
				if( strpos( $line, 'VERSION' ) !== false ) {
					$version = preg_replace( '/[^0-9.]/', '', $line );
					break;
				}
			}

			define( 'VERSION', $version );
		}
	}

	/**
	 * get language strings
	 */
	private function getLang() {
		$default	= '../install/language/en-gb/install/install_language.php';
		$custom		= '../install/language/' . $this->lng . '/install/install_language.php';

		if( file_exists( $default ) ) {
			require_once( $default );
		}

		if( file_exists( $custom ) ) {
			require_once( $custom );
		}

		$this->lang = $_;
	}

	/**
	 * get all entries for the speicified table
	 * @return array
	 */
	private function getTableEntries( $table ) {
		$sql = '
		SELECT
			*
		FROM
			`' . DB_PREFIX . $table . '`
		WHERE
			`language_id` = \'1\'';

		$result = $this->db->query( $sql );

		if( $result->num_rows ) {
			return $result->rows;
		}

		return false;
	}

	/**
	 * cehck if defined field with that language does exist
	 * @param string	$table
	 * @param string	$field	standard [name]
	 * @return bool
	 */
	private function fieldExist( $table, $values, $field, $search ) {
		$sql = '
		SELECT
			`' . implode( '`,`', $values ) . '`
		FROM
			`' . DB_PREFIX . $table . '`
		WHERE
			`' . $field . '` = \'' . $this->db->escape( $search ) . '\'
		AND
			`language_id` = \'' . (int) $this->language_id . '\'';

		$result = $this->db->query( $sql );

		if( !$result->num_rows ) {
			return false;
		}

		return true;
	}

	/**
	 * add new value(s)
	 * @param string	$table
	 * @param array		$row
	 * @param array		$values
	 */
	private function insertNew( $table, $row, $values ) {
		$fields = array();

		$sql = '
		INSERT IGNORE INTO
			`' . DB_PREFIX . $table . '`
		SET
			`language_id` = \'' . (int) $this->language_id . '\',';

			foreach( $values as $value ) {
				$fields[] = '`' . $value . '` = \'' . $this->db->escape( $row[$value] ) . '\'';
			}

		$sql .= implode( ',', $fields );

		$this->db->query( $sql );
	}

	/**
     * remove recursively a complete directory incl subfolders and files
     * @param string    $dir
     * @return bool
     * @see funtion removeDir()
     */
    private function rrmdir( $dir ) {
        $dir = $dir . '/';

        if( file_exists( $dir ) ) {
			$files	= array_diff( scandir( $dir ), array( '.', '..' ) );

			if( $files ) {
				foreach( $files as $file ) {
					if( !is_dir( $dir . $file ) ) {
						chmod( $dir .  $file, 0777 ); // because if WIN* used
						unlink( $dir . $file );
						$this->addMsg( 'F [' . $dir . $file . ']' );
					}else{
						$this->rrmdir( $dir . '/' . $file );
					}
				}
			}

	        clearstatcache();

	        if( is_dir( $dir ) ) {
				@rmdir( $dir );
				$this->addMsg( '** D [' . $dir . ']' );
	        }

	        return true;
		}

		return false;
	}

	/**
	 * ad a single msg to array
	 * @param string	$msg
	 */
	private function addMsg( $msg ) {
		$this->msg[] = $msg;
	}
}