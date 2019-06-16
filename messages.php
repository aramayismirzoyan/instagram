<?php 

require __DIR__.'/vendor/autoload.php';
\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
$ig = new \InstagramAPI\Instagram(); // Create new object Instagram API

$username = "maramayis1";
$password = "";

$ig->login($username, $password); // Login in Instagram

$threadId = $_GET['thread_id'];
$messages = $ig->direct->getThread($threadId);
$threadItems = $messages->getThread()->getItems();?>

<style>
    .message-single {
        width: 100%;
        height: auto;
        margin-bottom:15px;
    }
</style>

<?php foreach ($threadItems as $threadItem):?>
	<div class="message-single">
        <?php if ($threadItem->getText() !== null) {
           echo $threadItem->getText();
        } else if($threadItem->getMedia() != null) {
            $media = $threadItem->getMedia();
            $mediaType = $media->getMedia_type(); // Image or video

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
        } else {

            echo '<audio controls>
              <source src="'.$threadItem->getVoiceMedia()['media']['audio']['audio_src'].'" type="audio/mpeg">
            Your browser does not support the audio element.
            </audio>';
        } ?>
	</div>
<?php endforeach;?>