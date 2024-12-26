<?php
$siteRegulars = Config::find_by_id(1);
$lastElement='';
$phonelinked='';
$whatsapp='';
$tellinked = '';
    $telno = explode(",", $siteRegulars->contact_info);
    $lastElement = array_shift($telno);
    $tellinked .= '<a href="tel:' . $lastElement . '" target="_blank" aria-label="footer__contact"> ' . $lastElement . '</a> ,';
    foreach ($telno as $tel) {
        
        $tellinked .= '<a href="tel:+977-' . $tel . '" target="_blank" aria-label="footer__contact"> ' . $tel . '</a>';
        if(end($telno)!= $tel){
        $tellinked .= '/';
        }   
}
$phoneno = explode("/", $siteRegulars->whatsapp);
$lastElement = array_shift($phoneno);
$phonelinked .= '<a href="tel:+977-' . $lastElement . '" target="_blank">' . $lastElement. '</a>/';
foreach ($phoneno as $phone) {
    
    $phonelinked .= '<a href="tel:+977-' . $phone . '" target="_blank">' . $phone . '</a>';
    if(end($phoneno)!= $phone){
    $phonelinked .= '/';
    }   
}



 $ratingStars = '';   
$tstRec = Testimonial::get_alltestimonial(9);
// pr($tstRec,1);
$totalTestimonial = 0;
$totalRating = 0;
if (!empty($tstRec)) {
    $totalTestimonial = sizeof($tstRec);
    foreach ($tstRec as $tstRow) {
        $totalRating += intval($tstRow->rating);
    }
    
    $avgRating = round(($totalRating / $totalTestimonial),1);
}
for($i = 0; $i < ceil($avgRating); $i++){
    $ratingStars .= '
        <i class="flaticon-star checked"></i>
    ';
}
for($i = 0; $i < (5-ceil($avgRating)); $i++){
    $ratingStars .= '
        <i class="flaticon-star"></i>
    ';
}

$ratings ='
    <div class="position-relative  wow fadeInUp animated text-left" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
        <h6 class="mb-1">'. $avgRating .' out of 5</h6>
        <div class="de-rating-ext fs-18" style="background-size: cover; background-repeat: no-repeat;">
            <span class="d-stars" style="color:#F2B827;">
                '. $ratingStars .'
            </span>
        </div>
        <a class="d-block fs-14 mb-0" style="font-size:14px;color:var(--rts-para);" href="' . BASE_URL . 'reviews" >Based on '.$totalTestimonial.'+ reviews</a>
    </div>
';

$footer = '
    <footer class="rts__section rts__footer is__common__footer footer__background">
        <div class="container-fluid px-5">
            <hr style="padding-bottom: 80px;color: #000;">
            <div class="row">
                <div class="footer__newsletter">
                    <div class="rts__widget mb-40">
                        <a href="' . BASE_URL .'home"><img class="footer__logo text-center" src="'. IMAGE_PATH .'preference/'. $siteRegulars->second_logo .'" alt="footer logo" width="149" height="138"></a>
                    </div>
                    <span class="h4 mb-40"> Get the latest updates<br/> Subscribe now!</span>
                    <div class="rts__form mt-4">
                        <form action="#" method="post">
                            <input type="email" name="email" id="subscription" placeholder="Enter Email address" required>
                            <button type="submit">Sign up now</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="footer__widget__wrapper">
                    <div class="rts__widget">
                        <span class="widget__title">Contact Us</span>
                        <ul>
                            <li>Narsingha  Chowk, Thamel, Kathmandu, Nepal</li>
                            <li>Tel.:  '.$tellinked.'</li>
                            <li>Email:   <a aria-label="footer__contact" href="mailto:'. $siteRegulars->email_address .'"> '. $siteRegulars->email_address .'</a></li>
                        </ul>
                        <div class="footer__social__link mt-15">
                            ' . $jVars['module:socilaLinkbtm'] . '
                        </div>
                    </div>

                    <div class="rts__widget">
                        '. $jVars['module:footer-rooms-menu'] .'
                    </div>

                    <div class="rts__widget">
                        '. $jVars['module:footer-information-menu'] .'
                    </div>
                    
                    <div class="rts__widget">
                        <span class="widget__title">Reviews</span>
                        '. $ratings .'
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright__text">
            <div class="container-fluid px-5">
                <div class="row">
                    <div class="copyright__wrapper">
                        <!--<p class="mb-0">© Copyright 2024. All Rights Reserved. Developed by <a href="https://www.longtail.info/" target="_blank">Longtail e-media</a>. For further detail information contact us at <a href="mailto:info@aaryahotel.com">info@aaryahotel.com</a></p>-->
                        '. $jVars['site:copyright'] .'
                    </div>
                </div>
            </div>
        </div>
    </footer>
';
           

$jVars['module:footer'] = $footer;

if(!empty($siteRegulars->whatsapp_a)){
$whatsapp='
<div class="messenger">
<a href="'.$siteRegulars->whatsapp_a.'" target="_blank"><img src="'.BASE_URL.'template/web/images/whatsapp.png"></a>
</div>';
}
else{
    $whatsapp='';
}

$jVars['module:footer-whatsapp'] = $whatsapp;
