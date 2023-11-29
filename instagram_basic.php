<?php
//this folder is for instagram basic api only
	class Instagrambasic{
        
        public $appid='ur app-id';
        
        public $appSecret='ur app secret';
        
        public $redirecturl='ur redirect url';
        
        public $code='';
        
        public $apiBaseUrl = 'https://api.instagram.com/';
        
		public $graphBaseUrl = 'https://graph.instagram.com/';
        
        public $userId ='';
        
        public $longaccesstoken='';
      
        public $shortlivedaccesstoken='';
        
        
        function getcode(){//get the code that use to bring access token
            $para=array(
            "app_id"=>$this->appid,
            "redirect_uri"=>$this->redirecturl,
            "scope"=>"user_profile,user_media",
            "response_type"=>'code'
            );
            
            $urlcode=$this->apiBaseUrl.'oauth/authorize?'.http_build_query($para);
            
            return $urlcode;
            
            
        }




        function getshortlivedaccesstoken(){
        $postData = [
            'client_id' => $this->appid,
            'client_secret' => $this->appSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirecturl,
            'code' => $this->code
        ];
    
        // Initialize cURL session
        $ch = curl_init();
    
        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl."oauth/access_token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
          
        // Execute the cURL request
        $response = curl_exec($ch);
            
            $responseData = json_decode($response, true);
    
            // Extract the access token
            if(array_key_exists('error_type',$responseData)!=1){
            $this->shortlivedaccesstoken=$responseData['access_token'];
            print("SHORT ACCESS TOKEN <br>".$responseData['access_token']."<br>");
    
            $this->userId=$responseData['user_id'];
            print("USER_ID: <br>".$responseData['user_id']."<br><br---------------------");
            $this->getusermetadata();
            }
            
            else{
            print("an error has accourd <br> the error is:{$responseData['error_message']}");
            }
            
        curl_close($ch);
    }
        
        
        
        function getusermetadata(){
            $fildes="fields=account_type,id,media_count,username";
          
            $ch = curl_init();
        
            // Set the cURL options
            curl_setopt($ch, CURLOPT_URL,"https://graph.instagram.com/v18.0/6424237544358801?fields=account_type,id,media_count,username&access_token={$this->shortlivedaccesstoken}");
            // curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            
            // Execute the cURL request
            $response = curl_exec($ch);
        
            
                $responseData = json_decode($response, true);
        
                print("----------<br><br>"."acc_type:"."<br>".$responseData['account_type']."<br><br>")   ;
                print("id:"."<br>".$responseData['id']."<br><br>")  ;
                print("media_count:"."<br>".$responseData['media_count']."<br><br>")   ;
                print("username:"."<br>".$responseData['username']."<br><br>")   ;

            // Close the cURL session
            curl_close($ch);
            
            
            
            
        }
        
      
    }
    
    
    
    

    
    ?>
