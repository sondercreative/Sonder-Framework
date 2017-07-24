
          <div class='tweetWrap'>
            <p class="iconHead"><i class="ion-social-twitter"></i></p>
              <?php
              $siteUrl = get_bloginfo('url');
              include("twitterfeed/twitterPull.php");
              foreach ($data as $tweet){
                $text= $tweet['text'];
                $ent = $tweet['entities'];
                $id =$tweet['id'];
                $text= str_replace("#","",$text);
                $text= str_replace("@","",$text);
                if($ent['hashtags']!=''){
                  foreach ($ent['hashtags'] as $hash){
                    $hashTag = $hash['text'];
                    $hashUrl = "https://twitter.com/hashtag/".$hash['text'];
                    $text = preg_replace("~\b$hashTag\b~"," <a href='$hashUrl' target='_blank'>#$hashTag</a>",$text);
                    //$text = str_replace('#'.$hashTag,"<a href='$hashUrl' taget='_blank'>#$hashTag</a>",$text);
                  }
                }
                if($ent['user_mentions']!=''){
                  foreach ($ent['user_mentions'] as $user){
                    $userName = $user['screen_name'];
                    $userUrl = "https://twitter.com/@".$userName;
                    $text = preg_replace("~\b$userName\b~"," <a href='$userUrl' target='_blank'>@$userName</a>",$text);
                  }
                }
                if($ent['urls']!=''){
                  foreach ($ent['urls'] as $urls){
                    $link = $urls['url'];
                    $text = preg_replace("~\b$link\b~"," <a href='$link' target='_blank'>$link</a>",$text);
                  }
                }

                if($ent['media']!=''){
                  foreach ($ent['media'] as $media){
                    $link = $media['url'];
                    $text = preg_replace("~\b$link\b~"," <a href='$link' target='_blank'>$link</a>",$text);
                  }
                }
                $posted = $tweet['created_at'];
                $postedTime = strtotime($posted);
                $timeToday = time();
                $timeDifference = $timeToday - $postedTime;
                $minutesPast =floor($timeDifference/60);
                $hoursPast = floor($timeDifference/3600);
                $daysPast = floor($timeDifference/86400);
                 if($daysPast !=0){
                  $ago = $daysPast."d ago";
                 }else if($hoursPast!=0){
                  $ago = $hoursPast.'h ago';
                 }else{
                  $ago = $minutesPast.'m ago';
                 }

                  echo "<p>$text <span> - $ago</span></p>
                  <div class='twitter-ui'>
                      <a href='https://twitter.com/intent/tweet?in_reply_to=$id' target='_blank'><span class='ion-reply'></span></a>
                      <a href='https://twitter.com/intent/retweet?tweet_id=$id' target='_blank'><span class='ion-loop'></span></a>
                      <a href='https://twitter.com/intent/like?tweet_id=$id' target='_blank'><span class='ion-heart'></span></a>
                  </div>
                  <p><a href='https://twitter.com/yeghealthcity'>@ufinancialyeg</a></p>
                  ";

              }
              ?>

</div>