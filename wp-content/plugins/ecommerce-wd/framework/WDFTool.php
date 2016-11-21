<?php

class WDFTool {
  
	public static function get_tools($where_query = array()) {
		$tools = WDFDb::get_rows('tools', $where_query);
		$all_tools = array();
    if ($tools) {
      foreach ($tools as $tool) {
        $all_tools[] = $tool->name;
      }
    }
		return $all_tools;
	}

	public static function rmdir_recursive($dir) {
		foreach (scandir($dir) as $file) {
			if ('.' === $file || '..' === $file) {
				continue;
      }
			if (is_dir("$dir/$file")) {
				self::rmdir_recursive("$dir/$file");
      }
			else {
				unlink("$dir/$file");
      }
		}
    rmdir($dir);
	}
	////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////	
	////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}