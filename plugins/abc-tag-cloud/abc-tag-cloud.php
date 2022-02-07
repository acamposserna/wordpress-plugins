<?php
/*
Plugin Name:  ABC Tag Cloud Shortcode
Plugin URI:   http://www.antoniocampos.es/plugins/abc-tag-cloud/
Description:  This shortcode shows the tag cloud with an alphabet for direct access by the first letter of the tag.
Version:      1.0
Author:       Antonio Campos Serna
Author URI:   http://www.antoniocampos.es/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  abc-tag-cloud
Domain Path:  /languages

ABC Tag Cloud Shortcode is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
ABC Tag Cloud Shortcode is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with ABC Tag Cloud Shortcode. If not, see https://www.gnu.org/licenses/gpl-2.0.html
*/

function abc_tag_cloud_shortcodes_init() {
	
    function abc_tag_cloud_shortcode() {
        $abc = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        $html = "";
        $current_letter = "";
        $current_index = -1;
        /*
        $html .= "<p align='center'>";
		for ($i = 0; $i < count($abc); $i++) {
            if ($i == 0)
                $html .= "<a href='#" . $abc[$i] . "_bands'>" . $abc[$i] . "</a>";
            else
                $html .= " | <a href='#" . $abc[$i] . "_bands'>" . $abc[$i] . "</a>";
        }
		$html .= "</p>";
        */
        $tags = get_tags();
        foreach ($tags as $tag) {
            $tag_link = get_tag_link($tag->term_id);
			$tag_name = $tag->name;
            $tag_first_letter = strtoupper(substr($tag_name, 0, 1));
            
            while ($current_letter != $tag_first_letter) {
                $current_index++;
				if ($current_index > 0) $html .= "</p>";
                $html .= "<p><h2>" . $abc[$current_index] . "</h2>";
                $html .= "<a name='" . $abc[$current_index] . "_bands'></a></p><p>";
                $current_letter = $abc[$current_index];
            }
            $html .= "<a href='" . $tag_link . "'  title='" .$tag->name . "' style='font-weight: bold; color: #000000'>";
            $html .= $tag->name . " (" . $tag->count . ")</a>&nbsp;&nbsp;&nbsp;";
        }

		while ($current_index < count($abc)) {
			$current_index++;
			if ($current_index > 1) $html .= "</p>";
            $html .= "<p><h2>" . $abc[$current_index] . "</h2>";
            $html .= "<a name='" . $abc[$current_index] . "_bands'></a></p><p>";			
		}
		
        return $html;
    }
    add_shortcode('abc-tag-cloud', 'abc_tag_cloud_shortcode');
}
add_action('init', 'abc_tag_cloud_shortcodes_init');
?>
