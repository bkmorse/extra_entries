<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  /**
  * ExpressionEngine Loop Plugin
  *
  * @package		Title Cat
  * @subpackage	Plugins
  * @category		Plugins
  * @author		  Brad Morse
  * @link			  http://github.com/bkmorse
  */

  $plugin_info = array(
    'pi_name'			    => 'Title Cat',
    'pi_version'	  	=> '1.0.0',
    'pi_author'		    => 'Brad Morse',
    'pi_author_url'	  => 'http://bkmorse.com',
    'pi_description'	=> 'Returns category ids that are assigned to a specific url_title',
    'pi_usage'		    => Title_cat::usage()
  );

  class Title_cat {

    var $return_data;

    // -- Constructor -- //
    function title_cat() {
    // make a local reference to the ExpressionEngine super object
    $this->EE =& get_instance();
    
		//$url_title = $this->EE->TMPL->tagdata;     // all the content you want to add to the extra entries
    $url_title = $this->EE->TMPL->fetch_param('url_title');
    $separator = $this->EE->TMPL->fetch_param('separator');
		$return_data = '';
		
		if($url_title) {
			$this->EE->db->cache_on();
			$ids = $this->EE->db
			->select('C.cat_id')
			->from('exp_channel_titles T')
			->join('exp_category_posts C', 'T.entry_id = C.entry_id', 'left')
			->where('T.url_title', $url_title)
			->get()
			->result_array();
			
			$total = count($ids);
			$count = 1;
			
			foreach($ids as $r):
				$return_data .= $r['cat_id'];
				if($separator) {
					if($total > 1 && $count < $total) {
						$return_data .= $separator;
					}
					$count++;
				}
			endforeach;
		}
	  $this->return_data = $return_data;
  }
  /* END */


  // ----------------------------------------
  //  Plugin Usage
  // ----------------------------------------

  // This function describes how the plugin is used.
  //  Make sure and use output buffering

  function usage() {
    ob_start(); 
    ?>
    Use as follows:

    example: {exp:title_cat url_title="{url_title}" separator="&"}
		
    url_title (required), can manually put in the url_title or use within channel entries tag, and doing something like url_title="{url_title}" 
		separator (optional), breaks up the ids (if there is more than one returned), so if you did separator="&", it'd return 1&2&3
		
    <?php
    $buffer = ob_get_contents();

    ob_end_clean(); 

    return $buffer;
  }
  /* END */


  }
  // END CLASS

  /* End of file pi.link_icon.php */
  /* Location: ./system/expressionengine/third_party/title_cat/pi.title_cat.php */
?>