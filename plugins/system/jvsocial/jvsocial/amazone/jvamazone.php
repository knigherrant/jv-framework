<?php
class JVAmazone {
    public $params;
    function __construct($params){
        $this->params = $params;
    }

    public function getLatestHTML(){

        $AmazoneTrackingId  = $this->params->get('amazon_tracking_id', 'fullmotivation-20');
        $AmazoneCategory    = $this->params->get('amazon_category', 'books');
        $AmazoneBehavior    = $this->params->get('amazon_behavior', '_top');
        $AmazonePrices      = $this->params->get('amazon_price_options', '');
        $AmazoneDomain      = $this->params->get('amazon_domain', 'us');

        $AmazoneBgColor     = $this->params->get('amazon_bg_colour', '080808');
        $AmazoneTextColor   = $this->params->get('amazon_text_colour', 'FFFFFF');
        $AmazoneLinkColor   = $this->params->get('amazon_link_colour', '3366FF');

        // Get banner code
        $AmazoneBannerCode  = JString::trim($this->params->get('amazon_bannercode'));
        if(!empty($AmazoneBannerCode) AND (strcmp("it", $AmazoneDomain) == 0)) {
            $AmazoneBannerCode = "&amp;banner=".$AmazoneBannerCode;
        } else {
            $AmazoneBannerCode = "";
        }

        // Get align
        $AmazoneAlign       = $this->params->get('amazon_align', 'center');
        if(!empty($AmazoneAlign)) {
            $AmazoneAlign = "itp_va_".$AmazoneAlign;
        }

        // Get size
        $AmazoneSize        = $this->params->get('amazon_size', 8);
        $AmazoneSize        = self::getSize($AmazoneDomain, $AmazoneSize);
        $phrase            = self::getPhrases($this->params);
        $domainOptions     = self::getDomainOptions($AmazoneDomain);
        $price             = self::getPrice($AmazonePrices);
        $sizeParameters    = self::getSizeParameters($AmazoneSize);

        ob_start();
        ?>
        <iframe
            src="<?php echo $domainOptions["domain"];?>/e/cm?t=<?php echo $AmazoneTrackingId;?><?php echo $price;?>&amp;o=<?php echo $domainOptions["o"];?>&amp;p=<?php echo $AmazoneSize;?>&amp;l=st1&amp;mode=<?php echo $domainOptions["domain_prefix"].$AmazoneCategory.$domainOptions["domain_suffix"];?>&amp;search=joomla&amp;fc1=<?php echo $AmazoneTextColor;?>&amp;lt1=<?php echo $AmazoneBehavior;?>&amp;lc1=<?php echo $AmazoneLinkColor;?>&amp;bg1=<?php echo $AmazoneBgColor;?>&amp;f=ifr<?php echo $AmazoneBannerCode;?>"
            marginwidth="0"
            marginheight="0"
            border="0"
            frameborder="0"
            style="border:none;"
            scrolling="no"
            <?php echo $sizeParameters;?>
            ></iframe>
        <?php
        return ob_get_clean();

    }

    public static function getPhrases($params) {

        // Prepare phrases
        $phrase         = "";
        $AmazoneFilter   = $params->get('amazon_filter',1);

        switch ( $AmazoneFilter ){
            // Keywords in meta tag
            case 1:
                $doc           =   JFactory::getDocument();
                $keywords      =   $doc->getMetaData("keywords");
                if ( !empty( $keywords ) ) {
                    $keywords      =   explode(",",$keywords);

                    if ( !empty( $keywords ) ) {
                        $phrase   =   $keywords[array_rand($keywords)];
                    }
                }
                break;

            // Title
            case 2:

                $app       =   JFactory::getApplication();
                $phrase    =   $app->getPageTitle();

                break;

            // Your keywords
            default:

                $keywords  = $params->get('amazon_keywords','joomla');
                if ( !empty( $keywords ) ) {
                    $keywords      =   explode(",",$keywords);

                    if ( !empty( $keywords ) ) {
                        $phrase   =   $keywords[array_rand($keywords)];
                    }
                }
                break;
        }

        $phrase = JString::trim($phrase);
        $phrase = JString::strtolower($phrase);

        return $phrase;

    }

    public static function getDomainOptions($AmazoneDomain) {

        $domainOptions = array(
            "domain" => "",
            "o"=>0,
            "domain_prefix" =>"",
            "domain_suffix" =>""
        );

        switch ( $AmazoneDomain ) {

            case "uk":

                $domainOptions["domain"] = 'http://rcm-uk.amazon.co.uk';
                $domainOptions["domain_suffix"] = "-uk";
                $domainOptions["o"] = 2;

                break;

            case "de":

                $domainOptions["domain"] = 'http://rcm-de.amazon.de';
                $domainOptions["domain_suffix"] = "-de";
                $domainOptions["o"] = 3;

                break;

            case "fr":

                $domainOptions["domain"] = 'http://rcm-fr.amazon.fr';
                $domainOptions["domain_suffix"] = "-fr";
                $domainOptions["o"] = 8;
                break;

            case "jp":

                $domainOptions["domain"] = 'http://rcm-jp.amazon.co.jp';
                $domainOptions["domain_suffix"] = "-jp";
                $domainOptions["o"] = 5;

                break;

            case "ca":

                $domainOptions["domain"] = 'http://rcm-ca.amazon.ca';
                $domainOptions["domain_suffix"] = "-ca";
                $domainOptions["o"] = 15;

                break;

            case "it":

                $domainOptions["domain"] = 'http://rcm-it.amazon.it';
                $domainOptions["domain_prefix"] = "it_";
                $domainOptions["o"] = 29;
                break;

            // United State
            default:
                $domainOptions["domain"] = 'http://rcm.amazon.com';
                $domainOptions["domain_suffix"] = "";
                $domainOptions["o"] = 1;
                break;

        }

        return $domainOptions;
    }

    public static function getPrice($AmazonePrice) {
        $price = "";
        switch ( $AmazonePrice ) {
            case "nou":
                $price = "&amp;nou=1";
                break;
            case "npa":
                $price = "&amp;npa=1";
                break;
            default:
                break;
        }
        return $price;
    }

    public static function getSize($AmazoneDomain, $AmazoneSize) {
        switch($AmazoneDomain) {
            case "it":
                $p = array(13=>26, 11=>29);
                if(array_key_exists($AmazoneSize, $p)) {
                    $AmazoneSize = JArrayHelper::getValue($p, $AmazoneSize, 0);
                }
                break;

            case "co.uk":
                $p = array(13=>26);
                $AmazoneSize = JArrayHelper::getValue($p, $AmazoneSize, 0);
                break;
            default: // .com

                break;
        }
        return $AmazoneSize;
    }

    public static function getSizeParameters($AmazoneSize) {
        $sizes = array(
            6  => ' width="120" height="150" ',
            8  => ' width="120" height="240" ',
            9  => ' width="180" height="150" ',
            10 => ' width="120" height="450" ',
            11 => ' width="120" height="600" ',
            12 => ' width="300" height="250" ',
            13 => ' width="468" height="60" ',
            14 => ' width="160" height="600" ',
            15 => ' width="468" height="240" ',
            16 => ' width="468" height="336" ',
            20 => ' width="120" height="90" ', // it
            31 => ' width="120" height="212" ', // co.uk, de
            32 => ' width="180" height="450" ', // de
            33 => ' width="150" height="170" ', // co.uk, de
            36 => ' width="600" height="520" ', // co.uk
            37 => ' width="120" height="170" ', // de
            42 => ' width="728" height="90" ', // it
            48 => ' width="728" height="90" ',
            286 => ' width="200" height="200" ', // co.uk, de, fr

        );
        $sizeParameters = JArrayHelper::getValue($sizes, $AmazoneSize, ' width="160" height="600" ');
        return $sizeParameters;
    }
}