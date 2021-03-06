<?php
$captcha = new Captcha();
$captcha->CreateImage();

class Captcha {
	public $width = 250;
	public $height = 70;
	public $resourcesPath = "resources";
	public $minWordLength = 6;
	public $maxWordLength = 7;
	public $session_var = "captcha";
	public $backgroundColor = array(255,255, 255);
	public $colors = array( array(27,78,181), // blue 
							);
	public $shadowColor = null; //array(0, 0, 0);

	/**
	 * Font configuration
	 *
	 * - font: TTF file
	 * - spacing: relative pixel space between character
	 * - minSize: min font size
	 * - maxSize: max font size
	 */
public $fonts = array(
                'Times'    => array('spacing' => 1, 'font' => 'TimesNewRomanBold.ttf')
				);


	/** Wave configuracion in X and Y axes */
	public $Yperiod = 12;
	public $Yamplitude = 4;
	public $Xperiod = 11;
	public $Xamplitude = 5;
	/** letter rotation clockwise */
	public $maxRotation = 0;
	/**
	 * Internal image size factor (for better image quality)
	 * 1: low, 2: medium, 3: high
	 */
	public $scale = 1;
	/**
	 * Blur effect for better image quality (but slower image processing).
	 * Better image results with scale=3
	 */
	public $blur = false;
	public $debug = false;
	/** Image format: jpeg or png */
	public $imageFormat = "png";
	/** GD image */
	public $im;

	public function CreateImage() {
		$ini = microtime(true);
		$this->ImageAllocate();
		$text = $this->GetRandomCaptchaText();
		$fontcfg = $this->fonts[array_rand( $this->fonts )];
		$this->WriteText($text, $fontcfg);
		if ( $this->blur && function_exists("imagefilter") ) {
			imagefilter( $this->im, IMG_FILTER_GAUSSIAN_BLUR );
		}
		$this->ReduceImage();
		if ($this->debug) {
			imagestring($this->im, 1, 1, $this->height - 8, "$text {$fontcfg['font']} " . round( ( microtime( true ) - $ini ) * 1000 ) . "ms", $this->GdFgColor);
		}
		$this->WriteImage();
		$this->Cleanup();
	}
	/**
	 * Creates the image resources
	 */
	protected function ImageAllocate() {
		if (!empty($this->im)) {
			imagedestroy($this->im);
		}
		$this->im = imagecreatetruecolor($this->width * $this->scale, $this->height * $this->scale);
		$this->GdBgColor = imagecolorallocate($this->im, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
		imagefilledrectangle($this->im, 0, 0, $this->width * $this->scale, $this->height * $this->scale, $this->GdBgColor);
		$color = $this->colors[mt_rand(0, sizeof($this->colors ) - 1)];
		$this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);
		if (!empty($this->shadowColor) && is_array($this->shadowColor) && sizeof($this->shadowColor) >= 3) {
			$this->GdShadowColor = imagecolorallocate($this->im, $this->shadowColor[0], $this->shadowColor[1], $this->shadowColor[2]);
		}
	}

    /**
     * Random text generation
     *
     * @return string Text
     */
    protected function GetRandomCaptchaText() {
        $length = rand($this->minWordLength, $this->maxWordLength);
        $words  = "qertzuiopasdfghjklyxcvbn";
        $text  = "";
        for ($i=0; $i<$length; $i++) {
       		$text .= substr($words, mt_rand(0, 24), 1);
        }
        return $text;
    }
	
	/**
     * Text insertion
     */
    protected function WriteText($text, $fontcfg = array()) {
        $fontcfg  = $this->fonts[array_rand($this->fonts)];
        $fontfile = $this->resourcesPath.'/fonts/'.$fontcfg['font'];
		$lettersMissing = $this->maxWordLength-strlen($text);
        $fontSizefactor = 1+($lettersMissing*0.09);
		$x = 20*$this->scale;
        $y = round(($this->height*27/40)*$this->scale);
        $length = strlen($text);
        for ($i=0; $i<$length; $i++) {
            $degree = rand($this->maxRotation*-1, $this->maxRotation);
            $fontsize = 20*$this->scale*$fontSizefactor;
            $letter = substr($text, $i, 1);
			if ($this->shadowColor) {
                $coords = imagettftext($this->im, $fontsize, $degree,
                    					$x+$this->scale, $y+$this->scale,
                    					$this->GdShadowColor, $fontfile, $letter);
            }
            $coords = imagettftext($this->im, $fontsize, $degree,
                $x, $y, $this->GdFgColor, $fontfile, $letter);
            $x += ($coords[2]-$x) + ($fontcfg['spacing']*$this->scale);
        }
    }

    /**
     * Wave filter
     */
    protected function WaveImage() {
        $xp = $this->scale*$this->Xperiod*rand(1,3);
        $k = rand(0, 100);
        for ($i = 0; $i < ($this->width*$this->scale); $i++) {
            imagecopy($this->im, $this->im,
                $i-1, sin($k+$i/$xp) * ($this->scale*$this->Xamplitude),
                $i, 0, 1, $this->height*$this->scale);
        }
        $k = rand(0, 100);
        $yp = $this->scale*$this->Yperiod*rand(1,2);
        for ($i = 0; $i < ($this->height*$this->scale); $i++) {
            imagecopy($this->im, $this->im,
                sin($k+$i/$yp) * ($this->scale*$this->Yamplitude), $i-1,
                0, $i, $this->width*$this->scale, 1);
        }
    }
	
	/**
     * Reduce the image to the final size
     */
    protected function ReduceImage() {
        // Reduzco el tamańo de la imagen
        $imResampled = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($imResampled, $this->im,
            0, 0, 0, 0,
            $this->width, $this->height,
            $this->width*$this->scale, $this->height*$this->scale
        );
        imagedestroy($this->im);
        $this->im = $imResampled;
    }

    /**
     * File generation
     */
    protected function WriteImage() {
        if ($this->imageFormat == 'png' && function_exists('imagepng')) {
            header("Content-type: image/png");
            imagepng($this->im);
        } else {
            header("Content-type: image/jpeg");
            imagejpeg($this->im, null, 80);
        }
    }

    protected function Cleanup() {
        imagedestroy($this->im);
    }
}

?>