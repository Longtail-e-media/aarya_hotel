<?php
/* First Slideshow */
$reslide='';

$vidBanner = Slideshow::getSlideshow_by_mode(2);
$imgBanner = Slideshow::getSlideshow_by_mode(1);
$siteRegulars = Config::find_by_id(1);


// pr($imgBanner,1);

if(!empty($vidBanner)){
    if(!empty($vidBanner[0]->source_vid)){
        $file_path = SITE_ROOT.'images/slideshow/video/'.$vidBanner[0]->source_vid;

        if(file_exists($file_path)){
            $reslide = '
                <div class="header-video">
                    <div id="hero_video">
                        <video autoplay="" height="auto" id="video1" loop="" muted="" width="100%">
                            <source src="'. IMAGE_PATH .'slideshow/video/'. $vidBanner[0]->source_vid .'" type="video/mp4"> does not support 
                        </video>
                    </div>
                </div>
            ';
        }
    }elseif(!empty($vidBanner[0]->source)){
        $reslide = '
            <div class="header-video">
                    <div id="hero_video">
                        <video autoplay="" height="auto" id="video1" loop="" muted="" width="100%">
                            <source src="'. $vidBanner[0]->source .'" type="video/mp4"> does not support 
                        </video>
                    </div>
                </div>
        ';
    }
}
elseif(!empty($imgBanner)){
    $carouselItem = '';

    foreach($imgBanner as $imgItem){
        $file_path1 = SITE_ROOT.'images/slideshow/'.$imgItem->image;
        $file_path2 = SITE_ROOT.'images/slideshow/'.$siteRegulars->other_upload;

        if(file_exists($file_path1)){
            $imgLink = IMAGE_PATH.'slideshow/'.$imgItem->image;
        }elseif(file_exists($file_path2)){
            $imgLink = IMAGE_PATH.'preference/other/'.$siteRegulars->other_upload;
        }else{
            $imgLink = BASE_URL.'template/web/assets/images/banner/slider1.jpg';
        }
        $carouselItem .= '
            <div class="swiper-slide">
                <div class="banner__slider__image">
                    <img src="'. $imgLink .'" alt="'. $imgItem->title .'">
                </div>
                <div class="container-fluid px-3">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="banner__slide__content">
                                <h3>'. $imgItem->title .'</h3>
                                <p class="sub__text">'. strip_tags($imgItem->content) .'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    $reslide = '
        <div class="rts__section banner__area is__home__one banner__height banner__center">
            <div class="banner__slider overflow-hidden">
                <div class="swiper-wrapper">
                '. $carouselItem .'
                </div>
            </div>
        </div>
        <div class="rts__slider__nav">
                <div class="rts__slide">
                    <div class="next">
                        <svg width="40" height="22" viewBox="0 0 40 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.255 9.75546H39.0404C39.7331 9.75546 40.2927 10.3151 40.2927 11.0078C40.2927 11.7005 39.7331 12.2601 39.0404 12.2601H4.28018L11.8803 19.8603C12.3695 20.3495 12.3695 21.1439 11.8803 21.6331C11.3911 22.1223 10.5967 22.1223 10.1075 21.6331L0.366619 11.8923C0.00657272 11.5322 -0.0990982 10.9961 0.0965805 10.5264C0.292259 10.0607 0.750149 9.75546 1.255 9.75546Z" fill="#F1F1F1" />
                            <path d="M11.0077 0.00274277C11.3286 0.00274277 11.6495 0.124063 11.8921 0.370618C12.3813 0.859813 12.3813 1.65426 11.8921 2.14346L2.13955 11.896C1.65036 12.3852 0.855906 12.3852 0.366712 11.896C-0.122483 11.4068 -0.122483 10.6124 0.366712 10.1232L10.1193 0.370618C10.3658 0.124063 10.6868 0.00274277 11.0077 0.00274277Z" fill="#F1F1F1" />
                        </svg>
                    </div>
                </div>
                <div class="rts__slide">
                    <div class="prev">
                        <svg width="40" height="22" viewBox="0 0 40 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M39.0377 12.2445L1.25234 12.2445C0.559636 12.2445 -2.04305e-06 11.6849 -1.92194e-06 10.9922C-1.80082e-06 10.2995 0.559637 9.73987 1.25234 9.73987L36.0125 9.73987L28.4124 2.13974C27.9232 1.65055 27.9232 0.856096 28.4124 0.366901C28.9016 -0.122294 29.6961 -0.122293 30.1853 0.366901L39.9261 10.1077C40.2861 10.4678 40.3918 11.004 40.1961 11.4736C40.0005 11.9393 39.5426 12.2445 39.0377 12.2445Z" fill="#F1F1F1" />
                            <path d="M29.2852 21.9973C28.9643 21.9973 28.6433 21.8759 28.4007 21.6294C27.9115 21.1402 27.9115 20.3457 28.4007 19.8565L38.1533 10.104C38.6425 9.61476 39.4369 9.61476 39.9261 10.104C40.4153 10.5932 40.4153 11.3876 39.9261 11.8768L30.1736 21.6294C29.927 21.8759 29.6061 21.9973 29.2852 21.9973Z" fill="#F1F1F1" />
                        </svg>
                    </div>
                </div>
            </div>
    ';
    
}

$jVars['module:slideshow']= $reslide;
?>