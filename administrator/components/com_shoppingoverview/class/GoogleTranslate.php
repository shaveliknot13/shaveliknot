<?php


class GoogleTranslate
{

    public static function translate($source, $target, $text)
    {
        // Request translation
        $response = self::requestTranslation($source, $target, $text);

        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }


    protected static function requestTranslation($source, $target, $text)
    {

        // Google translate URL
        $url = "https://translation.googleapis.com/language/translate/v2?key=AIzaSyCqYDAYCdeNk8Fg4dgw1M7Za5UA5p2Z9L8";

        $fields = array(
            'source' => urlencode($source),
            'target' => urlencode($target),
            'format' => 'text',
            'q' => urlencode($text)
        );

        if(mb_strlen($fields['q'], 'UTF-8') >= 100000){
            return '';
        }

        // URL-ify the data for the POST
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        rtrim($fields_string, '&');

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }

    /**
     * Dump of the JSON's response in an array
     *
     * @param string $json
     *            The JSON object returned by the request function
     *
     * @return string A single string with the translation
     */
    protected static function getSentencesFromJSON($json)
    {
        $sentencesArray = json_decode($json, true);

        if(isset($sentencesArray['error'])){
            return "";
        }

        if(isset($sentencesArray['data']['translations'][0]['translatedText'])){
            return $sentencesArray['data']['translations'][0]['translatedText'];
        }else{
            return "";
        }
    }
}
