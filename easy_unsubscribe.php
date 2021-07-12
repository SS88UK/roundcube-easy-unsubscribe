<?php

class easy_unsubscribe extends rcube_plugin
{	
	private $message_headers_done = false;
	private $unsubscribe_img;

	function init()
	{
		$rcmail = rcmail::get_instance();
		$layout = $rcmail->config->get('layout');

		$this->add_hook('message_headers_output', array($this, 'message_headers'));
		$this->add_hook('storage_init', array($this, 'storage_init'));
		
		$this->include_stylesheet('easy_unsubscribe.css');

		$this->add_texts('localization/');
	}
	
	public function storage_init($p)
	{
		$p['fetch_headers'] = trim($p['fetch_headers'] . ' ' . strtoupper('List-Unsubscribe'));
		return $p;
	}
	
	public function message_headers($p)
	{		
		if($this->message_headers_done===false)
		{
			$this->message_headers_done = true;

			$ListUnsubscribe = $p['headers']->others['list-unsubscribe'];
			if ( preg_match_all('/<(.+)>/mU', $ListUnsubscribe, $items, PREG_PATTERN_ORDER) ) {
                                foreach ( $items[1] as $uri ) {
                                        $this->unsubscribe_img .= '<a class="easy_unsubscribe_link tooltip-right" data-tooltip="' . $this->gettext('click_to_unsubscribe') . '" href="'. htmlentities($uri) .'" target="_blank" onclick="return confirm(\'' . $this->gettext('confirm') . '\');"><img src="plugins/easy_unsubscribe/icon.png" alt="' . $this->gettext('unsubscribe') . '" /></a>';
                                }
                        }
		}

		if(isset($p['output']['subject']))
		{
			$p['output']['subject']['value'] = $p['output']['subject']['value'] . $this->unsubscribe_img;
			$p['output']['subject']['html'] = 1;
		}

		return $p;
	}
}