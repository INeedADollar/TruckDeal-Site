<?php 
	abstract class ColorType {
		const DARK = 1;
		const LIGHT = 2;	
	}
	
	function get_color_type($rgb_color) {
		$luminance = sqrt(0.241 
		   * pow($rgb_color['r'], 2) + 0.691 * pow($rgb_color['g'], 2) +  0.068 
		   * pow($rgb_color['b'], 2));
		
		return $luminance <= 150 ? ColorType::DARK : ColorType::LIGHT;
	}
	
	function generate_rgb() {
		$rgbColor = array();

		foreach(array('r', 'g', 'b') as $color){
			$rgbColor[$color] = mt_rand(0, 255);
		}
		
		return $rgbColor;
	}
	
	function generate_user_icon($character, $image_file_name) {
		if(extension_loaded("gd")) {
			$image = imagecreatetruecolor(64, 64);
			imagesavealpha($image, true);
			
			$alpha = imagecolorallocatealpha($image, 0, 0, 0, 127);
			imagefill($image, 0, 0, $alpha);
			
			$rand_rgb = generate_rgb();
			$background_color = imagecolorallocate($image, $rand_rgb['r'], $rand_rgb['g'], $rand_rgb['b']);
			imagefilledellipse($image, 32, 32, 64, 64, $background_color);
			
			$text_color = imagecolorallocate($image, 0, 0, 0);
			if(get_color_type($rand_rgb) == ColorType::DARK)
				$text_color = imagecolorallocate($image, 255, 255, 255);
			
			$text_bounding_box = imageftbbox(32, 0, "fonts/arial.ttf", $character);
			$text_x_position = (61 - (abs($text_bounding_box[2]) - abs($text_bounding_box[0]))) / 2;
			$text_y_position = (64 + (abs($text_bounding_box[5]) - abs($text_bounding_box[3]))) / 2;
			imagettftext($image, 32, 0, $text_x_position, $text_y_position, $text_color, "fonts/arial.ttf", $character);
			
			$image_out = imagecreatetruecolor(32, 32);
			imagesavealpha($image_out, true);
			imagealphablending($image_out, false );
			
			imagecopyresampled($image_out, $image, 0, 0, 0, 0, 32, 32, 64, 64);
			imagepng($image_out, $image_file_name);
			
			imagedestroy($image);
			imagedestroy($image_out);
			
			return 1;
		}

		return 0;
	}
?>