<?php 
/**
 * Checkfront Widget 
 * PHP 5 
 *
 * @package     CheckfrontWidget
 * @version     2.2
 * @author      Checkfront <code@checkfront.com>
 * @copyright   2008-2012 Checkfront Inc 
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @link        http://www.checkfront.com/developers/
 * @link        https://github.com/Checkfront/PHP-Widget
 *
 *
 * This makes use of the Checkfront embeddable widgets. It allows you
 * to embed a booking widget into any website, allows you to customize 
 * the look and feel, and takes care of sizing, caching etc.
 *
 * If the booking page is hosted under SSL and e-commerce is enabled
 * the customer will stay on your site for the duration of the booking
 * unless your are using Paypal or Google Checkout.
 *
 *
 * This class is designed to provide a quick way of integrating Checkfront
 * into a website.  If you wish to further extend the platform, consider
 * using the Checkfront SDK and API instead:
 * https//www.checkfront.com/developers/api/ 
 *  
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * o Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * o Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 * o The names of the authors may not be used to endorse or promote
 *   products derived from this software without specific prior written
 *   permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class CheckfrontWidget {

	public $version = '2.2';
	public $interface = 'v1'; //v2 recommended
	public $interface_build = '7';
	public $host= '';
	public $src = '';
	public $plugin_url = '';
	public $legacy_mode='inline';

	public $book_url = '';
	public $api_url = '';

	public $load_msg = 'Searching Availability';
	public $continue_msg = 'Continue to Secure Booking System';
	public $offline_msg= 'Bookings not yet available here.';

	public $arg = array(); 


	function __construct($cnf) {

		if(isset($cnf['host'])) $this->set_host($cnf['host']);
		if(isset($cnf['pipe_url'])) $this->set_pipe($cnf['pipe_url']);
		if(isset($cnf['plugin_url'])) $this->set_plugin_url($cnf['plugin_url']);
		$this->interface = (isset($cnf['interface'])) ? $cnf['interface'] : 'v1';
		$this->provider = (isset($cnf['provider'])) ? $cnf['provider'] : 'php';

		if($cnf['load_msg']) $this->load_msg = strip_tags($cnf['load_msg']);
		if($cnf['continue_msg']) $this->continue_msg = strip_tags($cnf['continue_msg']);
	}

    /**
     * set the url base for the widget.  should be an absolute url local to the site
     * eg: http://www.mysite.com/checkfront-plugin -- must also match the current schema (http:// | https://)
     * @param string $url
     * @return bool
    */
	function set_plugin_url($url) {
		$this->plugin_url = preg_replace('|/$|','',$url);
	}


    /**
     * set location of the pipe file.  most be located on the same server.
     * @param string $url
     * @return bool
    */
	function set_pipe($url) {
		$this->pipe_url = preg_replace('|/$|','',$url);
	}

    /**
     * sets the checkfront host
     *
     * @param string $host
     * @return bool
    */
	private function set_host($host) {
		$this->host = $host;
		$this->url = "//{$this->host}";

		// v1 only
		$this->api_url = "{$this->url}/api/2.0";
		return true;
	}

    /**
     * set valid host
     *
     * @param string $host
     * @return string $host  
    */
	public function valid_host($value) {
		if(!preg_match('~^http://|https://~',$value)) $value = 'https://' . $value;
		if($uri = parse_url($value)) {
			if($uri['host']) {
				$host= $uri['host'];
			}
		}
		return $host;
	}


    /**
     * display error when plugin is not yet configured
     *
     * @param void
     * @return string $html formatted message
    */
	public function error_config() {
		return '<p style="padding: .5em; border: solid 1px red;">' . $this->offline_msg .'</p>';
	}

    /**
     * render booking widget
     *
     * @param array $cnf shortcode paramaters
     * @return string $html rendering code
    */
	public function render($cnf) {
		$cnf = $this->clean($cnf);
		if($this->interface == 'v1') {
			return $this->v1_interface($cnf);
		} else {
			return $this->v2_interface($cnf);
		}
	}

    /**
     * clean short code params
     *
     * @param array $cnf shortcode paramaters
     * @return array $cnf formatted paramaters
    */
	private function clean($cnf) {
		foreach($cnf as $cnf_id => $data) {
			$data = preg_replace("/\#|'|>|</",'',strip_tags($data));
			$cnf[$cnf_id] = $data;
		}
		return $cnf;   
	}

    /**
     * render v1 legacy mode
     *
     * @param array $cnf shortcode paramaters
     * @return string $html rendering code
    */
	private function v1_interface($cnf) {
		$set = array();
		if($cnf['item_id'] >0) {
			$set[] = "item_id: '{$cnf['item_id']}'";
		}
		if($cnf['category_id'] >0) {
			$set[] = "category_id: '{$cnf['category_id']}'";
		}
		if(empty($this->host)) return $this->error_config();
		if($this->legacy_mode == 'framed') {
			$html = '<iframe src="//' . $this->host . '/www/client/?wp" style="border: 0; width: 100%; height: 800px"></iframe>';
		} else {
			$html = $this->droplet($set);
		}
		return $html;
	}

    /**
     * set the category and item id filters
     *
     * @param strong $ids 
     * @return string $ids eg 1,2,5
    */
	private function set_ids($ids) {
		return preg_replace("/[^0-9,]/",'',$ids);
	}


    /**
     * render v2 interface
     *
     * @param array $cnf shortcode paramaters
     * @return string $html rendering code
    */
	private function v2_interface($arg=array()) {

		$cnf = array(
			'widget_id'=>'',
			'item_id'=>'',
			'category_id'=>'',
			'theme'=>'',
			'layout'=>'',
			'tid'=>'',
			'options'=>'',
			'date'=>'',
			'style'=>''
		);

		if(count($arg)) {
			$cnf = array_merge($cnf,$arg);
		}

		$cnf['widget_id'] = (isset($cnf['widget_id']) and $cnf['widget_id'] > 0) ? $cnf['widget_id'] : '01';
		$html = "\n<!-- CHECKFRONT BOOKING PLUGIN v{$this->interface_version}-->\n";
		$html .= '<div id="CHECKFRONT_WIDGET_' . $cnf['widget_id'] . '"><p id="CHECKFRONT_LOADER" style="background: url(\'//' . $this->host . '/images/loader.gif\') left center no-repeat; padding: 5px 5px 5px 20px">' . $this->load_msg . '...</p></div>';
		$html .= "\n<script type='text/javascript'>\nnew CHECKFRONT.Widget ({\n";
		$html .= "host: '{$this->host}',\n";
		$html .= "pipe: '{$this->pipe_url}',\n";
		$html .= "target: 'CHECKFRONT_WIDGET_{$cnf['widget_id']}',\n";

		// optional, or default items.  can be sku or category_id
		if($cnf['item_id']) {
			$cnf['item_id'] = $this->set_ids($cnf['item_id']);
			$html .= "item_id: '{$cnf['item_id']}',\n";
		}
		//optional category_id(s)
		if($cnf['category_id']) {
			$cnf['category_id'] = $this->set_ids($cnf['category_id']);
			$html .= "category_id: '{$cnf['category_id']}',\n";
		}	
		if($cnf['theme']) $html .= "theme: '{$this->theme}',\n";
		if($cnf['width'] and $cnf['width'] > 0)  $html .= "width: '{$cnf['width']}',\n";
		if($cnf['layout'])  $html .= "layout: '{$cnf['layout']}',\n";
		if($cnf['tid'])  $html .= "tid: '{$cnf['tid']}',\n";
		if($cnf['options'])  $html.= "options: '{$cnf['options']}',\n";
		if($cnf['date'])  $html.= "date: '{$cnf['date']}',\n";
		if($cnf['style'])  $html .= "style: '{$cnf['style']}',\n";
		$html .= "provider: '{$this->provider}'\n";
		$html .="}).render();\n</script>\n";
		$html .= '<noscript><a href="https://' . $this->host . '/reserve/" style="font-size: 16px">' . $this->continue_msg . ' &raquo;</a></noscript>' . "\n";
		return $html;
	}	

    /**
     * legacy droplet settings
     *
     * @param array $set 
     * @return string $html 
    */
	public function droplet_set($set=array()) {
		$cnf = '';
		if(count($set)) {
			$cnf = '<input type="hidden" id="CF_set" value="{' . implode(',',$set) . '}" />';
		}
		if($this->book_url) {
			$cnf .= '<input type="hidden" id="CF_src" value="' . $this->book_url .'" />';
		}
		return $cnf ;
	}


    /**
     * v1 droplet
     *
     * @param array $cff
     * @return string html id
    */
	function droplet($set) {
		return '<div id="CF" class="' . $this->host . '"><p id="CF_load" class="CF_load">' . $this->load_msg . $this->droplet_set($set) . '</div>';
	}
}
?>
