<?php
$nearbydetail = $nearbydetail_modals= $imageList = $nearbybred = '';

if (defined('HOME_PAGE')) {
    $recRows = Nearby::find_all_active();
    // pr($recRows,1);
    if (!empty($recRows)) {

        foreach($recRows as $recRow){
            if($recRow->image != 'a:0:{}'){
                $unserializedImage = unserialize($recRow->image);

                $file_path = SITE_ROOT . 'images/nearby/' . $unserializedImage[0];
                if(file_exists($file_path)){
                    $imgLink = IMAGE_PATH . 'nearby/' . $unserializedImage[0];
                }else{
                    $imgLink = BASE_URL . 'template/web/assets/images/attractions/ktm.jpg';
                }
            }

            $nearbydetail .= '
                <div class="col-lg-6 col-md-6">
                    <div class="card rts__card no-border is__home__three">
                        <div class="card-body mb-40">
                            <div class="icon"><img src="'. $imgLink .'" alt="'. $recRow->title .'"></div>
                            <a href="#" class="nearbyModalTrigger" aria-label="Sign Up Button" data-bs-toggle="modal" data-bs-target="#signupModal" data-content="'. strip_tags($recRow->content) .'" data-title="'. $recRow->title .'">
                                <h6 class="card-title h6">'.$recRow->title.'</h6>
                            </a>
                            <p class="card-text nearbyDistance" data-src=\''. $recRow->linksrc .'\'>Distance: '. $recRow->distance .' <img src="'.BASE_URL.'template/web/assets/images/icon/arrow-right-short.svg" alt=""></p>
                        </div>
                    </div>
                </div>
            ';
            
        } 
    }
}


$jVars['module:nearby-attractions'] = $nearbydetail;

?>