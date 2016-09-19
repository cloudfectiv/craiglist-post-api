<?php
/******************************************
 * CloudFectiv - www.cloudfectiv.com
 * Date  : 2015
 * Author: Donnovan Wint Sr. - Principal Cloud Architect
 * Phone : 215-302-7242
 * Email : dwint@cloudfectiv 
 ******************************************/
$post_status;
$headers      = [];
$user_agent   = null;

// ENABLE HTTP POST
$username_email = "nomail@cloudfectiv.com";
$user_passwd    = "%$%$%$18YTYT";
$account_id     = 99999999999;

// could be read from a database

$image_data     = file_get_contents('cloudfectiv_logo.jpg');
$b64_image_data = base64_encode($image_data);    

$location_code  = 'rea';
$user_data      = '
        Cloud computing allows everyone to take advantage of the latest technologies without spending a small fortune 
        on infrastructure or software and IT specialists. Whether you are a fortune 100 company or a "mom and pop" 
        neighborhood business, you now have access to the same computing resources.
        <br><br>
        A cloud service is any resource that is provided over the Internet. The most common cloud service resources are 
        Software as a Service (SaaS), Platform as a Service (PaaS) and Infrastructure as a Service (IaaS).
        <br><br>
        We are CLOUDFECTIV, Headquartered in Suburban Philadelphia, USA, but with a global reach, we are one of the 
        leaders in our field who have been breaking much ground in bringing the benefits of Cloud Computing to a 
        marketplace that has been forgotten by "many" in the Cloud Computing world.
        This forgotten market are the "Small to Medium" size businesses.
        <br><br>
        Whether you are starting off with one(1) server or application, to hundreds of server instances and applications, 
        we are here to guide you through that journey. You can stay focus on your business, and we will do the heavy 
        lifting for you.

        If you are a "Small to Medium" size business, and want to reap the benefits of the CLOUD, 
        visit us at http://www.cloudfectiv.com.
    ';
       
$xml_data_array = [
    "username_email"=>$username_email, 
       "user_passwd"=>$user_passwd,  
        "account_id"=>$account_id, 
     "location_code"=>$location_code, 
    "b64_image_data"=>$b64_image_data, 
         "user_data"=>$user_data
];





function post($url, $data) {
    $headers[]  = 'Connection: Keep-Alive';
    // $headers[]  = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
    $headers[]  = 'Content-type: application/x-www-form-urlencoded;charset=iso-8859-1';
    $user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
    
    $process = curl_init($url);
    curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($process, CURLOPT_HEADER, 1);
    curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_POSTFIELDS, $data);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($process, CURLOPT_POST, 1);
    $return = curl_exec($process);
    $info   = curl_getinfo($process);
    curl_close($process);
    
   // return both array of result the excc and the getinfo processes
    $return_array =[
        'info'=>$info,
        'return'=>$return,
    ];
    return $return_array;
}


function xml_data($xml_data_array){
        
        // could pull this from a database, etc
        $ad_category = "sad"; 
        $replyEmail  = "nnoemail@clounfectiv.com";
        $ad_title    = "CLOUD COMPUTING FOR EVERYONE";
        /////////////////////////////////////////////
        
        
        $postdata =
        '<?xml version="1.0" encoding="utf-8"?>
        <rdf:RDF xmlns="http://purl.org/rss/1.0/"
                 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                 xmlns:cl="http://www.craigslist.org/about/cl-bulk-ns/1.0">
                 
          <channel>
            <items>
                 <rdf:li rdf:resource="ComputerSvcCloudCompute"/>
            </items>
            <cl:auth username="'.$xml_data_array['username_email'].'"'.
                   ' password="'.$xml_data_array['user_passwd'].'"'.
                  ' accountID="'.$xml_data_array['account_id'].'"'. '/>
          </channel>
          

          <item rdf:about="ComputerSvcCloudCompute">
            <cl:category>'.$ad_category.'</cl:category>
            <cl:area>'.$xml_data_array['location_code'].'</cl:area>
            <cl:replyEmail privacy="C" outsideContactOK="1">'.$replyEmail.'</cl:replyEmail>
            <cl:image position="1">'.$xml_data_array['b64_image_data'].'</cl:image>
            <title>'.$ad_title.'</title>
            <description><![CDATA['
              .$xml_data_array['user_data'].
            ']]></description>
          </item>
          
        </rdf:RDF>'; 
        
        return $postdata;
}

$post_url    = 'https://post.craigslist.org/bulk-rss/post';
$post_data   = xml_data($xml_data_array);

$post_status = post($post_url, $post_data); 

print_r($post_status['return']);
echo "\n\n<br>";
print_r($post_status['info']);


