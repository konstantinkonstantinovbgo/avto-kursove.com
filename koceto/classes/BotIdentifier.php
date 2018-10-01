<?php
class BotIdentifier {

    protected $arrstrBotMatches;

    function __construct() {

        //array of bots/spiders
        //You can add bots that are hitting your site see your apache servers log.
        $arrstrBots = array (
             'googlebot'        => '/Googlebot/',
             'msnbot'           => '/MSNBot/',
             'slurp'            => '/Inktomi/',
             'yahoo'            => '/Yahoo/',
             'askjeeves'        => '/AskJeeves/',
             'fastcrawler'      => '/FastCrawler/',
             'infoseek'         => '/InfoSeek/',
             'lycos'            => '/Lycos/',
             'yandex'           => '/YandexBot/',
             'geohasher'        => '/GeoHasher/',
             'gigablast'        => '/Gigabot/',
             'baidu'            => '/Baiduspider/',
             'spinn3r'          => '/Spinn3r/'        //add comma seprated bots here
        );

        //check if bot request
        if( true == isset( $_SERVER['HTTP_USER_AGENT'] )) {

            $this->arrstrBotMatches = preg_filter( $arrstrBots, array_fill( 1, count( $arrstrBots ), '$0' ), array( trim( $_SERVER['HTTP_USER_AGENT'] )));
        }
    }

    function getBot() {

        //check if bot request and return the identified bot.
        return ( true == is_array( $this->arrstrBotMatches ) && 0 < count( $this->arrstrBotMatches )) ? $this->arrstrBotMatches[0] : 'Not a bot request';
    }

    //isBot() can be used to check if the request is bot request before incrementing the visit count.
    function isBot() {
        //check if bot request.
        return ( true == is_array( $this->arrstrBotMatches ) && 0 < count( $this->arrstrBotMatches )) ? 1 : 0;
    }
}
?>