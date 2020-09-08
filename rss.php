<?php
    // error_reporting(E_ALL & ~( E_NOTICE | E_STRICT | E_DEPRECATED )); 
    // ini_set('display_errors', 0);
    
    $varUrl = "https://www.nu.nl/rss/Sport";

    // Suggesting this Class for feed parser, As our company rates feeds are built.
    /*
        require_once('libs/rayfeedreader.php');
        $objFeeder  = RayFeedReader::getInstance();
        $argOptions = array('url' => $varUrl);
        $results = $reader1->setOptions($argOptions)->parse()->getData();
        echo  "<pre>"; print_r($results); echo  "</pre>"; 
    */

    // Suggesting to follow uploading files in numeric format of folder based on Data/ID (Quick search, Loading, Structured)
    /*     
    function makedir($dirpath, $mode=0777) {
        return is_dir($dirpath) || mkdir($dirpath, $mode, true);
    }
    $varfolder = "uploads";
    if (makedir($varfolder)) {
        for ($a=0;$a<=9;$a++) {
            if(makedir($varfolder.$a)) {
                for ($b=0;$b<=9;$b++) {
                    makedir($varfolder.$a."/".$b);
                }
            }
        }
    } */

    function parseFeeds($feed, $today = false) {
        
        $results = array();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($feed);

        if ($xml === false) {
            $msg = "Failed to load XML...\n";
            foreach (libxml_get_errors() as $error) {
                $msg .= "\n" . $error->message;
            }
            libxml_clear_errors();
            $results['status'] = "error";
            $results['response'] = $msg;
        }

        if(is_object($xml)) {
            $feedContents = new stdClass;
            // $items = $xml->xpath("/rss/channel/item");
            if (!empty($xml->channel->item)) {
                $feedContents->feedUrl = $feed;
                $feedContents->feedTitle = $xml->channel->title . '';
                $feedContents->feedLink = $xml->channel->link . '';
                $feedContents->feedPubDate = $xml->channel->pubDate . '';
                $feedContents->feedDescription = $xml->channel->description. '';
                foreach ($xml->channel->item as $item) {
                    $tmp = array();
                    $categories = array();
                    foreach ($item->children() as $child) {
                        if ($child->getName() == 'category') {
                            $categories[] = (string) $child;
                        }
                    }
                    $tmp["title"] = $item->title . '';
                    $tmp["link"] = $item->link . '';
                    $tmp["description"] = $item->description . '';
                    $tmp["date"] = $item->pubDate . ''; 
                    $tmp["category"] =  $categories;
                    $tmp["image"] = $item->enclosure->attributes()->url . '';

                    //Only Today Feeds
                    $published = date("j", strtotime((string)$item->pubDate));
                    if($today) {
                        if(date("j") == $published) $feedContents->feedItems[] = $tmp;
                    } else {
                        $feedContents->feedItems[] = $tmp;
                    }
                }
            }
            $results['status'] = "success";
            $results['response'] = $feedContents;            
        }
        return $results;
    }

    function wordsTruncate ($string, $wordcount) {
        $string     = strip_tags($string);
        $arrString  = array_slice(explode(' ', $string), 0, $wordcount);
        $string     = implode(' ', $arrString);
        return $string ."...";
    }

    function getRss($rssURI, $today = false) {

        //Call to Get Feeds
        $varResults = parseFeeds($rssURI, $today);
        // echo  "<pre>"; print_r($varResults['response']); echo  "</pre>"; exit;

        $arrJsonRes = array();
        if($varResults['status'] == "success") {
            // $index = 1;
            foreach ($varResults['response']->feedItems as $item) {
                //Get Folder & Filename
                $varID = date("j", strtotime($item["date"]));
                list($folder1, $folder2) = str_split(substr($varID, -2));
                $varFile = pathinfo($item["image"]);
                $varFileExtn = $varFile['extension'];
                // $varFileExtn = strtolower(substr(strrchr(basename($item["image"]), '.'), 1));
                $varOFilename = md5($varFile['filename']).".".$varFileExtn;
                $varFilename = "uploads/".$folder1."/".$folder2."/".$varOFilename;

                //Get connection to download
                if (!file_exists($varFilename)) {
                    // $ch = curl_init();
                    $ch = curl_init($item["image"]); 
                    $fp = fopen( $varFilename, "w+");
                    // curl_setopt($ch, CURLOPT_URL, $item["image"]); 
                    curl_setopt($ch, CURLOPT_FILE, $fp); 
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            
                    $data = curl_exec($ch); 
                    curl_close($ch); 
                    // fputs($fp, $data); 
                    fclose($fp);
                }

                $arrJsonRes[] = array(
                                $item["title"] => array(
                                    $varFilename, 
                                    wordsTruncate($item["description"], 20), 
                                    $item["link"]
                                )
                            );
                // if($index==1) break; $index++;
            }

            //Content type Specification for JSON
            header("Content-type: application/json");
            return json_encode( $arrJsonRes );
            
        } else {
            return $varResults['response'];
        }
    }

    //Calling Logic for RSS
    $results = getRss($varUrl, true);
    echo  "<pre>"; echo $results; echo  "</pre>";