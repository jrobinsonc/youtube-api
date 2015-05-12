<?php

namespace jrobinsonc;

/**
 * @author JoseRobinson.com
 * @link https://github.com/jrobinsonc/youtube-api
 * @see Youtube API reference: https://developers.google.com/youtube/v3/docs/
 * @version 0.1.0
 */
class Youtube_API {

    /**
     * API key.
     * 
     * @see https://code.google.com/apis/console
     * @var string
     */
    private $key = '';

    /**
     * API URL.
     * 
     * @var string
     */
    private $apiUrl = 'https://www.googleapis.com/youtube/v3/';

    /**
     * __construct
     * 
     * @param string $key
     * @return void
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @todo Need documentation.
     */
    public function api($method, $part, $params = array())
    {
        $params['key'] = $this->key;
        $params['part'] = $part;

        $result = file_get_contents($this->apiUrl . $method . '?' . http_build_query($params));

        if (false === $result)
            return false;

        $result_json = json_decode($result, true);

        if (null === $result_json)
            return false;

        return $result_json;
    }

    ####################################################
    # GENERIC METHODS
    ####################################################

    /**
     * @todo Need documentation.
     */
    public function getPlaylistsByUsername($username)
    {
        $result = $this->api('channels', 'contentDetails', array(
            'forUsername' => $username
        ));

        if (false === $result)
            return false;

        return $result['items'][0]['contentDetails']['relatedPlaylists'];
    }

    /**
     * @todo
     */
    public function getVideoThumb($videoId)
    {
    }

    /**
     * @todo
     */
    public function getVideoThumbnails($videoId)
    {
    }

    /**
     * @todo Need documentation.
     */
    function parseVideoURL($videoUrl)
    {
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $match))
            $videoId = $match[1];
        else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $videoUrl, $match))
            $videoId = $match[1];
        else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $videoUrl, $match))
            $videoId = $match[1];
        else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $match))
            $videoId = $match[1];
        else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $videoUrl, $match))
            $videoId = $match[1];
        else
            $videoId = false;
        
        return $videoId;
    }
}
