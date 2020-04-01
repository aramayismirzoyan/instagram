<?php 

require __DIR__.'/vendor/autoload.php';
\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
$ig = new \InstagramAPI\Instagram(); // Create new object Instagram API

$username = "";
$password = "";

$ig->login($username, $password); // Login in Instagram

$direct = $ig->direct->getInbox(); // Get direct messages
$threads = $direct->getInbox()->getThreads();
?>

<style>
    .message-link {
        color: #000;
        text-decoration: none;
        background-color: #f3f3f3;
        display: block;
    }

    .message-link:hover {
        opacity: .7;
    }
</style>

<h1>Сообщения</h1>

<?php foreach($threads as $thread):?>
<a href="messages.php?thread_id=<?php echo $thread->getThreadId();?>" class="message-link">
    <h2>
        Имя отправителя: <?php echo $thread->getInviter()->getFullName(); ?><br>
        Логин: <?php echo $thread->getInviter()->getUsername(); ?>
    </h2>

    <h2>
        Тело сообщения:
    </h2>

    <p>
        <?php
            $threadItems = $thread->getItems();

            foreach($threadItems as $threadItem) {
                if ($threadItem->getText() !== null) { // If text is sent
                   echo $threadItem->getText();
                } else if($threadItem->getMedia() != null) { // If image or video is sent
                    $media = $threadItem->getMedia();
                    $mediaType = $media->getMedia_type();
                    switch ($mediaType) {
                        case 1:
                            echo "<img src='".$media->getImage_versions2()->getCandidates()[0]->getUrl()."'>";
                            break;
                        case 2:
                            echo '<video width="600" height="400" controls>
                                      <source src="'.$media->getVideo_versions()[0]->getUrl().'" type="video/mp4">							  
                                    </video>';
                            break;
                    }
                } else {  // If sent audio message
                    echo '<audio controls>
                      <source src="'.$threadItem->getVoiceMedia()['media']['audio']['audio_src'].'" type="audio/mpeg">
                    Your browser does not support the audio element.
                    </audio>';
                }
            }
        ?>
    </p>
    <hr>
</a>
<?php endforeach;?>






