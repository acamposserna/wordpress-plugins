<?php
/*
Plugin Name:  Subcategories List
Plugin URI:   https://github.com/acamposserna/wordpress-plugins/blob/main/plugins/subcategories-list/
Description:  This shortcode shows the subcategories list of one category with an alphabet for direct access
              by the first letter of the name of the subcategory.
Version:      1.0
Author:       Antonio Campos Serna
Author URI:   http://www.antoniocampos.es/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  subcategories-list
Domain Path:  /languages

Subcategories List Shortcode is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Subcategories List Shortcode is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Subcategories List Shortcode. If not, see https://www.gnu.org/licenses/gpl-2.0.html
*/

function subcategories_list_shortcodes_init() {
	
    function subcategories_list_shortcode($atts = '') {
        $abc = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        $html = "";
        $current_letter = "";
        $current_index = -1;
        $attributes = shortcode_atts(['category_id' => '1', 'style' => '', ], $atts);
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
        $categories = get_the_category();
        foreach ($categories as $category) {
            if ($category->parent == $attributes['category_id']) {
                $category_link = get_category_link($category);
                $category_name = $category->name;
                $category_first_letter = strtoupper(substr($category_name, 0, 1));
                $category_count = $category->count;
                
                while ($current_letter != $category_first_letter) {
                    $current_index++;
                    if ($current_index > 0) $html .= "</p>";
                    $html .= "<p><h2>" . $abc[$current_index] . "</h2>";
                    $html .= "<a name='" . $abc[$current_index] . "_subcategories'></a></p><p>";
                    $current_letter = $abc[$current_index];
                }
                $html .= "<a href='" . $category_link . "'  title='" . $category_name . "'";
                if ($attributes['style'] != '') $html .= " style='" . $attributes['style'] . "'";
                $html .= ">";
                $html .= $category_name . " (" . $category_count . ")</a>&nbsp;&nbsp;&nbsp;";
            }
        }

		while ($current_index < count($abc)) {
			$current_index++;
			if ($current_index > 1) $html .= "</p>";
            $html .= "<p><h2>" . $abc[$current_index] . "</h2>";
            $html .= "<a name='" . $abc[$current_index] . "_subcategories'></a></p><p>";			
		}
		
        return $html;
    }
    add_shortcode('subcategories-list', 'subcategories_list_shortcode');
}
add_action('init', 'subcategories_list_shortcodes_init');
?>
