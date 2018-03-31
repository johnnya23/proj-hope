<?php

if (! defined('ABSPATH')) {
    exit;
}

class JMACPTamazon_item
{
    private $options;
    private $amazon_id;
    /*private $settings_base;
    private $settings;
    private $db_option;
    private $page_title;
    private $page_desc;
    private $text_domain;*/

    public function __construct($jmcpt_options_array, $amazon_id)
    {
        $this->options = $jmcpt_options_array;
        $this->amazon_id = $amazon_id;
        echo $this->build_html();
    }

    private function extract_id($id)
    {
        if (substr($id, 0, 4) === "http") {
            $query = parse_url($id);
            $params = explode('/', $query['path']);
            $id = $params[3];
        }
        return $id;
    }

    private function build_api_url($id)
    {
        $options = $this->options;
        // Your Access Key ID, as taken from the Your Account page
        $access_key_id = $options['key'];

        // Your Secret Key corresponding to the above ID, as taken from the Your Account page
        $secret_key = $options['secret'];

        // The region you are interested in
        $endpoint = "webservices.amazon.com";

        $uri = "/onca/xml";

        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemLookup",
            "AWSAccessKeyId" => $options['key'],
            "AssociateTag" => "hopechangesli-20",
            "ItemId" => $id,
            "IdType" => "ASIN",
            "ResponseGroup" => "Images,ItemAttributes,Offers"
        );

        // Set current timestamp if not set
        if (!isset($params["Timestamp"])) {
            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
        }

        // Sort the parameters by key
        ksort($params);

        $pairs = array();

        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
        }

        // Generate the canonical query
        $canonical_query_string = join("&", $pairs);

        // Generate the string to be signed
        $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

        // Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

        // Generate the signed URL
        $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

        return $request_url;
    }
    protected function curl($url)
    {
        $options = $this->options;
        $curl = curl_init($url);

        $whitelist = array('127.0.0.1', "::1");
        if ($options['dev'] && in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//for localhost
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//for localhost
        }

        //curl_setopt($curl, CURLOPT_SSLVERSION,3);//forMAMP
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        $return = json_decode($result, true);
        if (!$return || array_key_exists('error', $return)) {
            if (is_array($return) && array_key_exists('error', $return)) {
                $return = $return['error']['errors'][0]['reason'];
            }//keyInvalid, playlistNotFound, accessNotConfigured, ipRefererBlocked, keyExpired
            else {
                $return = $result;
            }
        }
        $return = simplexml_load_string($result);
        return $return;
    }
    public function build_html()
    {
        $id = $this->extract_id($this->amazon_id);
        $url = $this->build_api_url($id);
        do {
            $api_return = JMACPTamazon_item::curl($url);
        } while (!is_object($api_return->Items->Item));

        $item = $api_return->Items->Item;
        $return = '<a class="tb-thumb-link" href="' . esc_url($item->DetailPageURL) . '" target="_blank">';
        $return .= '<img src="' . esc_url($item->LargeImage->URL) . '" alt="' . $item->ItemAttributes->Title . '"/>';
        $return .= '</a>';
        $return .= '<h2 class="jma-ama-title"><a class="tb-thumb-link" href="' . esc_url($item->DetailPageURL) . '" target="_blank">';
        $return .= esc_html($item->ItemAttributes->Title);
        $return .= '</a></h2>';
        $return .= '<h3 class="jma-ama-subtitle">' . esc_html($item->ItemAttributes->Author) . '</h3>';
        return $return;
    }
}


/*
echo '<div>';
echo '<a href="' . esc_url(get_permalink()) . '">';

    echo '<img src=" ' . esc_url(plugins_url('/default.jpg', __FILE__)) . '"/>';
echo '</a>';
echo $jmcpt_options_array['key'] . '<br/>';
echo $jma_cpt_meta['amazon_id'];

echo '<div class="jma-tax-grid-title"><div>' . get_the_title();
echo '</div></div>';

echo '</div>';

++$i;*/
