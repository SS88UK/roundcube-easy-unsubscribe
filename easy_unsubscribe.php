<?php

class easy_unsubscribe extends rcube_plugin
{	
	function init()
	{
		$rcmail = rcmail::get_instance();
		$layout = $rcmail->config->get('layout');

		$this->add_hook('message_headers_output', array($this, 'message_headers'));
		$this->add_hook('storage_init', array($this, 'storage_init'));
		
		$this->include_stylesheet('easy_unsubscribe.css');
	}
	
    public function storage_init($p)
    {
        $p['fetch_headers'] = trim($p['fetch_headers'] . ' ' . strtoupper('List-Unsubscribe'));
        return $p;
    }
	
    public function message_headers($p)
    {		
		$ListUnsubscribe = $p['headers']->others['list-unsubscribe'];
		preg_match('/<(.*?)>/', $ListUnsubscribe, $rVal);
		if($rVal[1]!='')
			$O = '<a class="easy_unsubscribe_link" title="Unsubscribe" href="'.$rVal[1].'" target="_blank" onclick="return confirm(\'Are you sure you want to unsubscribe?\');"><img src="plugins/easy_unsubscribe/icon.png" alt="Unsubscribe" /></a>';
		else
		{
			preg_match('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $ListUnsubscribe, $rVal);
			if($rVal[0]!='')
				$O = '<a class="easy_unsubscribe_link" title="Unsubscribe" href="'.$rVal[0].'" target="_blank" onclick="return confirm(\'Are you sure you want to unsubscribe?\');"><img src="plugins/easy_unsubscribe/icon.png" alt="Unsubscribe" /></a>';
		}

        $p['output']['subject']['value'] = $p['output']['subject']['value'] . $O;
        $p['output']['subject']['html'] = true;

        return $p;
    }
}
