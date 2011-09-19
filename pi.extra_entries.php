<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  /**
  * ExpressionEngine Loop Plugin
  *
  * @package		Extra Entries
  * @subpackage	Plugins
  * @category		Plugins
  * @author		  Brad Morse
  * @link			  http://github.com/bkmorse
  */

  $plugin_info = array(
    'pi_name'			    => 'Extra Entries',
    'pi_version'	  	=> '1.0.0',
    'pi_author'		    => 'Brad Morse',
    'pi_author_url'	  => 'http://bkmorse.com',
    'pi_description'	=> 'Adds extra entries to all the entries you have in that channel',
    'pi_usage'		    => Extra_entries::usage()
  );

  class Extra_entries {

    var $return_data;

    // -- Constructor -- //
    function Extra_entries() {
    // make a local reference to the ExpressionEngine super object
    $this->EE =& get_instance();
    $extra_entry_content = $this->EE->TMPL->tagdata;     // all the content you want to add to the extra entries
    $how_many_entries = ($this->EE->TMPL->fetch_param('how_many_entries') !== false) ? $this->EE->TMPL->fetch_param('how_many_entries') : 10;
		$total_results = ($this->EE->TMPL->fetch_param('total_results') !== false) ? $this->EE->TMPL->fetch_param('total_results') : 0;
	
		$return_data = '';
		
		if($total_results < $how_many_entries) {
			$i = 1;
			$extra_entries = $how_many_entries - $total_results;
			
			while($i <= $extra_entries):
				$return_data .= $extra_entry_content;
				$i++;
			endwhile;
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

    {exp:channel:entries}
		{if count==total_results}
			{exp:extra_entries total_results="{total_results}" how_many_entries=""}
			  content you want to show in extra spots
			{/exp:extra_entries}
		{/if}
		{/exp:channel:entries}
		
    total_results (required) = pass total_results tag within this
		how_many_entries (required) = pass the number of how many times you want to loop it thru
		
		the content between the opening and closing tag is the html and/or content you want to display for the extra fields
    <?php
    $buffer = ob_get_contents();

    ob_end_clean(); 

    return $buffer;
  }
  /* END */


  }
  // END CLASS

  /* End of file pi.link_icon.php */
  /* Location: ./system/expressionengine/third_party/link_icon/pi.extra_entries.php */
?>