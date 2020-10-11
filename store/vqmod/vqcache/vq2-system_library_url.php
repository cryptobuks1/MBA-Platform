<?php
class Url {
	private $url;
	private $ssl;
	private $rewrite = array();

	public function __construct($url, $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}
	
	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}

	public function link($route, $args = '', $secure = false) {
		if ($this->ssl && $secure) {
			
                
                    if (strpos($route,'account/') !== false && (strcmp("account/forgotten", $route) === 0 || strcmp("account/success", $route) === 0 || strcmp("account/package", $route) === 0)) {
                            $url = dirname($this->ssl) . '/backoffice';
                    } else {
                        $url = $this->ssl . 'index.php?route=' . $route;
                    }
                
            
		} else {
			
                
                    if (strpos($route,'account/') !== false && (strcmp("account/login", $route) === 0 || strcmp("account/forgotten", $route) === 0 || strcmp("account/success", $route) === 0 || strcmp("account/package", $route) === 0 || strcmp("account/register", $route) === 0)) {
                            $url = dirname($this->url) . '/backoffice';
                    } else {
                        $url = $this->url . 'index.php?route=' . $route;
                    }
                
            
		}
		
		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
		}
		
		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}
		
		
                
                    if(DEMO_STATUS == 'yes') {
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            $db_prefix = $_GET['id'] . "_oc_";
                        }
                        elseif (isset($_COOKIE['oc_table_prefix'])) {
                            $db_prefix = $_COOKIE['oc_table_prefix'];
                        }
                        else {
                            $db_prefix = '';
                        }
                        return $url . '&id=' . str_replace("_oc_", "", $db_prefix); 
                    }
                    else {
                        return $url; 
                    }
                
             
	}
}