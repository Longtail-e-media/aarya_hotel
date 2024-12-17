<?php
$booking_code = Config::getField('hotel_code', true);


/*
* Home accmodation list
*/
$reshmpkg = '';
$imageList = '';

if (defined('HOME_PAGE')) {
    $acid = Package::get_accommodationId();
    $pkgRec = Package::find_by_id($acid);
    // pr($pkgRec,1);
    $unSerializedImgs = '';
    $homeRooms = $finalPkgSec = $roomNavBlock = '';
    
    if (!empty($pkgRec)) {

        $unSerializedImgs = unserialize($pkgRec->banner_image);
        // pr($unSerializedImgs,1);
        $allIdSlider = '';
        
        foreach($unSerializedImgs as $sliderImg){
            $file_path = SITE_ROOT .'images/package/banner/'.$sliderImg;
    
            if(file_exists($file_path)){
                $imgLink = IMAGE_PATH.'package/banner/'.$sliderImg;
            }else{
                $imgLink = BASE_URL.'template/web/assets/images/room/1.webp';
            }

            $allIdSlider .= '
                <div class="swiper-slide room__wrapper">
                    <div class="room__card is__style__four">
                        <div class="room__card__top">
                            <div class="room__card__image">
                                <a href="#">
                                    <img src="'. $imgLink .'" width="645" height="438" alt="room card">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($pkgRec->content));
        $homeRooms .= '
            <div class="tab-pane fade show active" id="all" role="tabpan    el" aria-labelledby="all">
                <div class="room__card is__style__four">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="room__card__top">
                                <div class="room__slider overflow-hidden wow fadeInUp" data-wow-delay=".5s">
                                    <div class="swiper-wrapper ">
                                        <!-- single room slider -->
                                        '. $allIdSlider .'
                                        <!-- single room slider end -->
                                    </div>
                                </div>
                                <div class="rts__pagination">
                                    <div class="rts-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="room__card__meta">
                                <a href="#" class="room__card__title h4">'. $pkgRec->title .'</a>
                                '. $content[0] .'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';

        $unSerializedImgs = '';

        $subRec = Subpackage::getPackage_limit($acid);
        // pr($subRec,1);

        if (!empty($subRec)) {
            $imglink = '';
            
            foreach($subRec as $key => $subRow){

                if($subRow->image != 'a:0:{}'){
                    $subImageSlider = '';
                    $unSerializedImgs = unserialize($subRow->image);
                    foreach($unSerializedImgs as $uImg){
                        $file_path = SITE_ROOT .'images/subpackage/'.$uImg;

                        if(file_exists($file_path)){
                            $imgLink = IMAGE_PATH.'subpackage/'.$uImg;
                        }else{
                            $imgLink = BASE_URL.'template/web/assets/images/room/1.webp';
                        }

                        $subImageSlider .= '
                            <div class="swiper-slide room__wrapper">
                                <div class="room__card is__style__four">
                                    <div class="room__card__top">
                                        <div class="room__card__image">
                                            <a href="#">
                                                <img src="'. $imgLink .'" width="645" height="438" alt="room card">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }

                // pr($subRow,1);
                $id = '';
                if($subRow->slug == 'presidential-suite'){
                    $id = 'vegan';
                }
                elseif($subRow->slug == 'deluxe'){
                    $id = 'cold';
                }
                elseif($subRow->slug == 'executive-suite'){
                    $id = 'dips';
                }
                elseif($subRow->slug == 'junior-suite'){
                    $id = 'burger';
                }

                $homeRooms .= '
                    <div class="tab-pane fade" id="'. $id .'" role="tabpanel" aria-labelledby="'. $id .'">
                            <div class="room__card is__style__four">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="room__card__top">
                                            <div class="room__slider overflow-hidden wow fadeInUp" data-wow-delay=".5s">
                                                <div class="swiper-wrapper ">
                                                    <!-- single room slider -->
                                                        '. $subImageSlider .'
                                                    <!-- single room slider end -->
                                                </div>
                                            </div>
                                            <div class="rts__pagination">
                                                <div class="rts-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="room__card__meta">
                                            <a href="#" class="room__card__title h4">'. $subRow->title .'</a>
                                            <div class="room__card__meta__info">
                                                <span>'. $subRow->occupancy .' Guests</span>
                                                <span>'. $subRow->room_size .'</span>
                                            </div>
                                            <p class="font-sm pt-4">'. $subRow->detail .'</p>
                                            
                                            <a href="'. $subRow->slug .'" class="room__card__link mt-5">View Details</a>
                                            <br/>

                                            <a href="#" class="theme-btn btn-style sm-btn fill mt-5"><span>Book Now</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
                
                $file_path2 = SITE_ROOT.'images/subpackage/image/'.$subRow->image2;
                if(file_exists($file_path2)){
                    $imgLink2 = IMAGE_PATH.'subpackage/image/'.$subRow->image2;
                }else{
                    $imgLink2 = BASE_URL.'template/web/assets/images/room/1.webp';
                }
                
                $roomNavBlock .= '
                    <div class="col-md-3 nav-link" data-bs-toggle="tab" data-bs-target="#'. $id .'" aria-controls="'. $id .'">
                        <div class="room__card__image">
                            <img src="'. $imgLink2 .'" alt="room card">
                        </div>
                        <h6 class="pt-3">'. $subRow->title .'</h6>
                    </div>
                ';
            }

        }
        
        $finalPkgSec .= '
            <div class="rts__section room-home-page section__padding">
                <div class="container-fluid px-5">
                    <div class="row justify-content-center text-center mb-40">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="section__topbar pb-4">
                                <span class="h6 mx-auto">ELEGANT ROOMS</span>
                                <h4 class="section__title">'. $pkgRec->sub_title .'</h4>
                                <p>'. $pkgRec->detail .'</p>
                            </div>
                        </div>
                    </div>
                    <!-- row end -->
    
                    <div class="row">
                        <div class="col-12">
                            <!-- resturant menu content -->
                            <div class="tab-content mb-50" id="nav-tabContent">
                                '. $homeRooms .'
                            </div>
                            <!-- resturant menu content end -->
    
                            <div class="resturant__menu__list">
                                <div class="nav nav-tabs row" id="nav-tab" role="tablist">
                                    '. $roomNavBlock .'
                                    <button class="nav-link active setame d-none" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    $jVars['module:home-accommodation'] = $finalPkgSec;
}


/*
* Home sub package list
*/
$newpkg = '';

if (defined('HOME_PAGE')) {
//$slug = !empty($_REQUEST['slug'])? addslashes($_REQUEST['slug']) : '';
//$pkgRec = Package::getPackage();
//if (!empty($pkgRec)) {

    /* foreach($pkgRec as $pkgRow) {
        $imglink = '';*/
    /* if ($pkgRow->banner_image != "a:0:{}") {
         $imageList = unserialize($pkgRow->banner_image);
         $file_path = SITE_ROOT . 'images/package/banner/' . $imageList[0];
         if (file_exists($file_path)) {
             $imglink = IMAGE_PATH . 'package/banner/' . $imageList[0];
         }
     } */
    // if(($pkgRow->type)==0) {
    $newpkg .= '<div class="col-sm-6">
                <div class="mosaic_container">
                     <a href="' . BASE_URL . 'page/about-us">
                    <img src="' . BASE_URL . 'template/web/img/mosaic_1.jpg" alt="image" class="img-responsive add_bottom_30"><span class="caption_2">Experience Peninsula</span>
                    </a>
                </div>
            </div>';
    //}else{
    $newpkg .= '<div class="col-sm-6">
         
         <div class="col-xs-12">
                    <div class="mosaic_container">
                        <a href="' . BASE_URL . 'services">
                        <img src="' . BASE_URL . 'template/web/img/mosaic_2.jpg" alt="image" class="img-responsive add_bottom_30"><span class="caption_2">Services & Faciities</span>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="mosaic_container">
                        <a href="' . BASE_URL . 'rooms">
                        <img src="' . BASE_URL . 'template/web/img/room.jpg" alt="rooms" class="img-responsive add_bottom_30"><span class="caption_2">
Accommodation</span>
                        </a>
                    </div>
                </div>
                  <div class="col-xs-6">
                     <a href="' . BASE_URL . 'dining">
                    <div class="mosaic_container">
                        <img src="' . BASE_URL . 'template/web/img/dining.jpg" alt="dining" class="img-responsive add_bottom_30"><span class="caption_2">Dining & Bar</span>
                    </div>
                    </a>
                </div>
                
                  </div>
                ';

    //}
    //}
//}
}
$jVars['module:newpkg'] = $newpkg;


/////
$reshplist = $pakagehometype = '';
$cnt = 1;
if (defined('HOME_PAGE')) {
    $pgkRows = Package::find_by_id(16);
    $pkgRec = Subpackage::getPackage_limits(16,4);

    // pr($pgkRows,1);
    if (!empty($pkgRec)) {
        $subPkgRecreation = '';

        foreach($pkgRec as $key => $pkgRow){
            $marginClass = ($key % 2 == 0) ? '' : 'mt-6';

            $file_path = SITE_ROOT . 'images/subpackage/image/' . $pkgRow->image2;
            if(file_exists($file_path)){
                $imageLink = IMAGE_PATH . 'subpackage/image/' . $pkgRow->image2;
            }else{
                $imageLink = BASE_URL .'template/web/assets/images/offer/4.webp';
            }

            $subPkgRecreation .= '
                <div class="col-lg-3 '. $marginClass .'">
                    <div class="blog__item is__full is__event">
                        <div class="blog__item__thumb">
                            <a href="#">
                                <img src="'. $imageLink .'" alt="'.$pkgRow->title.'">
                            </a>
                        </div>
                        <div class="blog__item__meta">
                            <a href="#" class="blog__item__meta__title">
                                <h5>'. $pkgRow->title .'</h5>
                            </a>
                            <div class="blog__item__meta__list">
                                <p>'. $pkgRow->detail .'</p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        $reshplist = '
             <div class="rts__section blog is__home__three section__padding pillar-icon1" style="background:#f8f2e2;">
                <div class="section__shape">
                    <img src="'. BASE_URL .'template/web/assets/images/pillar2.png" alt="">
                </div>
                <div class="container-fluid px-5">
                    <div class="row justify-content-center text-center mb-40">
                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                            <div class="section__topbar pb-4">
                                <span class="h6 mx-auto">'. $pgkRows->title .'</span>
                                <h4 class="section__title">'. $pgkRows->sub_title .'</h4>
                                <!--<p>'. preg_replace('/<\/?p>/','<br/>',$pgkRows->content) .'</p>-->
                                '. $pgkRows->content .'
                            </div>
                        </div>
                    </div>
                    <!-- row end -->
                    <div class="row align-items-center g-30">
                        '. $subPkgRecreation .'
                    </div>
                </div>
            </div>
        ';

    }
    /* $reshplist.= '</div>
                 </div>
             </div>';*/
}

$jVars['module:home-recreation-Package-list'] = $reshplist;
$jVars['module:home-package-type-list'] = $pakagehometype;


//food and beverage
if(defined('HOME_PAGE')){
    $pkgByIdRow = Package::find_by_id(18);
    
    $restroMainSec = '';

    if(!empty($pkgByIdRow)){
        $subPkgRec = Subpackage::getPackage_limits(18);
        $subRow = '';
        foreach($subPkgRec as $subPkgRow){
            $subPkgRow->id == 55 && $subRow = $subPkgRow;  
        }
        
        $restroSlider = '';

        if(!empty($subPkgRow->image)){
            $unSerializedRestroImgs = unserialize($subRow->image);
            // pr($unSerializedRestroImgs);
            foreach($unSerializedImgs as $restroImg){
                $file_path = SITE_ROOT . 'images/subpackage/' . $restroImg;
                if(file_exists($file_path)){
                    $imgSrc = IMAGE_PATH . 'subpackage/' . $restroImg;
                }else{
                    $imgSrc = BASE_URL . 'template/web/assets/images/restaurant/food1.jpg';
                }
                
                $restroSlider .= '
                    <div class="swiper-slide room__wrapper">
                        <div class="room__card is__style__four">
                            <div class="room__card__top">
                                <div class="room__card__image">
                                    <a href="#">
                                        <img src="'. $imgSrc .'" width="645" height="438" alt="room card">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }else{
            $restroSlider .= '
                <div class="swiper-slide room__wrapper">
                    <div class="room__card is__style__four">
                        <div class="room__card__top">
                            <div class="room__card__image">
                                <a href="#">
                                    <img src="'. BASE_URL . 'template/web/assets/images/restaurant/food1.jpg" width="645" height="438" alt="room card">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        $restroMainSec = '
            <div class="row">
                <div class="col-md-12">
                    <div class="room__card is__style__four">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="room__card__meta">
                                    <a href="#" class="room__card__title h4">'. $subRow->title .'</a>
                                    '. $subRow->content .'
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="room__card__top">
                                    <div class="room__slider overflow-hidden wow fadeInUp" data-wow-delay=".5s">
                                        <div class="swiper-wrapper ">
                                            <!-- single room slider -->
                                            '. $restroSlider .'
                                            <!-- single room slider end -->
                                        </div>
                                    </div>
                                    
                                    <div class="rts__pagination">
                                        <div class="rts-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    $jVars['module:food-and-beverage'] = $restroMainSec;
}


$roomlist = $roombread = '';
$modalpopup='';
$room_package='';
if (defined('PACKAGE_PAGE') and isset($_REQUEST['slug'])) {

    $slug = !empty($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
    
    $pkgRow = Package::find_by_slug($slug);
    // pr($pkgRow,1);
    if($pkgRow->type==1){
    
        $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($pkgRow->content));
        // pr($content,1);
        $roomBanner = '
            <div class="rts__section page__hero__height page__hero__bg">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-12">
                            <div class="page__hero__content mt-120 pt-30">
                                <h3 class="wow fadeInUp">Our Rooms</h3>
                                <p class="px-5 max-750" style="color: #744920de;margin: auto;">'. strip_tags($content[1]) .'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';

        $sql = "SELECT *  FROM tbl_package_sub WHERE status='1' AND type = '{$pkgRow->id}' ORDER BY sortorder DESC ";

        $page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"])) ? $_REQUEST["pageno"] : 1;
        $limit = 200;
        $total = $db->num_rows($db->query($sql));
        $startpoint = ($page * $limit) - $limit;
        $sql .= " LIMIT " . $startpoint . "," . $limit;
        $query = $db->query($sql);
        $pkgRec = Subpackage::find_by_sql($sql);
        // pr($pkgRec);
        
        if (!empty($pkgRec)) {
            

            foreach ($pkgRec as $key => $subpkgRow) {
                $file_path = SITE_ROOT . 'subpackage/image/' . $subpkgRow->image2;
                if(file_exists($file_path)){
                    $imgLink = IMAGE_PATH . 'subpackage/image/' . $subpkgRow->image2;
                }else{
                    $imgLink = BASE_URL . 'template/web/assets/images/room/2.webp';
                }


                $roomlist .= '
                    <div class="col-lg-6 col-xl-4 col-md-6">
                        <div class="room__card">
                            <div class="room__card__top">
                                <div class="room__card__image">
                                    <a href="package.html">
                                        <img src="'. $imgLink .'" width="420" height="310" alt="room card">
                                    </a>
                                </div>
                            </div>
                            <div class="room__card__meta">
                                <a href="package.html" class="room__card__title h6">'. $subpkgRow->title .'</a>
                                <div class="room__card__meta__info">
                                    <span><i class="flaticon-construction"></i>'. $subpkgRow->room_size .'</span>
                                    <span><i class="flaticon-user"></i>'. $subpkgRow->occupancy .' Person</span>
                                </div>
                            </div>
                        </div>
                    </div>
                ';

            }
            $room_package = '
                '.  $roomBanner .'
                <div class="rts__section pb-120 pt-120" style="background: #f8f2e2;">
                    <div class="container-fluid px-5">
                        <div class="row g-30">
                            '. $roomlist .'
                        </div>
                    </div>
                </div>
            ';
            // pr($room_package,1);
        }
    }
    else{
        if($pkgRow->id == 17){

            // $subRec = Subpackage::get_relatedsub_by(17);
            // pr($subRec,1);
            // $hallSliderItem = $hallAmenities = $hallBook = '';
            // $hall_package_banner = '';

            // if($subRec[0]->id == 54){
            //     if($subRec[0]->image != 'a:0:{}'){
            //         $unSerializedImgs = unserialize($pkgRow->banner_image);
    
            //         foreach($unSerializedImgs as $imgs){
            //             $file_path = SITE_ROOT . 'images/package/banner/' . $imgs;
    
            //             if(file_exists($file_path)){
            //                 $imgLink = IMAGE_PATH . 'package/banner/' . $imgs;
            //             }else{
            //                 $imgLink = BASE_URL . 'template/web/assets/images/video/hall1.jpg';
            //             }
    
            //             $hallSliderItem .= '
            //                 <div class="swiper-slide room__wrapper">
            //                     <img src="'. $imgLink .'" alt="room card">
            //                 </div>
            //             ';
            //         }
            //     }
            //     if($subRec[0]->feature != 'a:0:{}'){
            //         $unserializedFeatImg = unserialize($subRec[0]->feature);
                    
            //         foreach($unserializedFeatImg[119][1] as $icons){
                        
            //         }
            //     }
    
            //     $hall_package_banner = '
            //         <div class="rts__section banner__area is__home__one banner__height banner__center">
            //             <div class="room__slider overflow-hidden" style="height: 700px;max-height: 700px;" >
            //                 <div class="swiper-wrapper ">
            //                     <!-- single room slider -->
            //                     '. $hallSliderItem .'
            //                     <!-- single room slider end -->
            //                 </div>
            //                 <div class="rts__slider__nav">
            //                     <div class="rts__slide">
            //                         <div class="next">
            //                             <svg width="40" height="22" viewBox="0 0 40 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            //                                 <path d="M1.255 9.75546H39.0404C39.7331 9.75546 40.2927 10.3151 40.2927 11.0078C40.2927 11.7005 39.7331 12.2601 39.0404 12.2601H4.28018L11.8803 19.8603C12.3695 20.3495 12.3695 21.1439 11.8803 21.6331C11.3911 22.1223 10.5967 22.1223 10.1075 21.6331L0.366619 11.8923C0.00657272 11.5322 -0.0990982 10.9961 0.0965805 10.5264C0.292259 10.0607 0.750149 9.75546 1.255 9.75546Z" fill="#F1F1F1" />
            //                                 <path d="M11.0077 0.00274277C11.3286 0.00274277 11.6495 0.124063 11.8921 0.370618C12.3813 0.859813 12.3813 1.65426 11.8921 2.14346L2.13955 11.896C1.65036 12.3852 0.855906 12.3852 0.366712 11.896C-0.122483 11.4068 -0.122483 10.6124 0.366712 10.1232L10.1193 0.370618C10.3658 0.124063 10.6868 0.00274277 11.0077 0.00274277Z" fill="#F1F1F1" />
            //                             </svg>
            //                         </div>
            //                     </div>
            //                     <div class="rts__slide">
            //                         <div class="prev">
            //                             <svg width="40" height="22" viewBox="0 0 40 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            //                                 <path d="M39.0377 12.2445L1.25234 12.2445C0.559636 12.2445 -2.04305e-06 11.6849 -1.92194e-06 10.9922C-1.80082e-06 10.2995 0.559637 9.73987 1.25234 9.73987L36.0125 9.73987L28.4124 2.13974C27.9232 1.65055 27.9232 0.856096 28.4124 0.366901C28.9016 -0.122294 29.6961 -0.122293 30.1853 0.366901L39.9261 10.1077C40.2861 10.4678 40.3918 11.004 40.1961 11.4736C40.0005 11.9393 39.5426 12.2445 39.0377 12.2445Z" fill="#F1F1F1" />
            //                                 <path d="M29.2852 21.9973C28.9643 21.9973 28.6433 21.8759 28.4007 21.6294C27.9115 21.1402 27.9115 20.3457 28.4007 19.8565L38.1533 10.104C38.6425 9.61476 39.4369 9.61476 39.9261 10.104C40.4153 10.5932 40.4153 11.3876 39.9261 11.8768L30.1736 21.6294C29.927 21.8759 29.6061 21.9973 29.2852 21.9973Z" fill="#F1F1F1" />
            //                             </svg>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     ';


            //     $hallBook = '
            //         <div class="rts__section section__padding blog is__home__three" style="background: #f3e8c8;">
            //             <div class="section__shape">
            //                 <img src="' . BASE_URL . 'template/web/assets/images/pillar.png" alt="' . $subRec->title . '">
            //             </div>
            //             <div class="container">
            //                 <div class="row justify-content-center">
            //                     <div class="col-lg-8">
            //                         <div class="room__details__top">
            //                             <h5>'. $subRec->short_title .'</h5>
            //                             <!-- submit button -->
            //                             <button class="theme-btn btn-style fill no-border search__btn wow fadeInUp" data-wow-delay=".6s">
            //                                 <span>Book Now</span>
            //                             </button>
            //                             <!-- submit button end -->
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     ';
    
            //     $room_package = '

            //     ';
            // }
        }

    // $imglink = BASE_URL . 'template/web/images/default.jpg';
    // $pkgRowImg = $pkgRow->banner_image;
    // if ($pkgRowImg != "a:0:{}") {
    //     $pkgRowList = unserialize($pkgRowImg);
    //     $file_path = SITE_ROOT . 'images/package/banner/' . $pkgRowList[0];
    //     if (file_exists($file_path) and !empty($pkgRowList[0])) {
    //         $imglink = IMAGE_PATH . 'package/banner/' . $pkgRowList[0];
    //     }
    //     else{
    //         $imglink = BASE_URL . 'template/web/images/default.jpg';
    //     }
    // }

    // $roombread .= '
    // <!--================ Breadcrumb ================-->
    // <div class="mad-breadcrumb with-bg-img with-overlay" data-bg-image-src="'.$imglink.'">
    //     <div class="container wide">
    //         <h1 class="mad-page-title">' . $pkgRow->title . '</h1>
    //         <nav class="mad-breadcrumb-path">
    //             <span><a href="index.html" class="mad-link">Home</a></span> /
    //             <span>' . $pkgRow->title . '</span>
    //         </nav>
    //     </div>
    // </div>
    // <!--================ End of Breadcrumb ================-->

    // ';
    
    // $sql = "SELECT *  FROM tbl_package_sub WHERE status='1' AND type = '{$pkgRow->id}' ORDER BY sortorder DESC ";

    // $page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"])) ? $_REQUEST["pageno"] : 1;
    // $limit = 200;
    // $total = $db->num_rows($db->query($sql));
    // $startpoint = ($page * $limit) - $limit;
    // $sql .= " LIMIT " . $startpoint . "," . $limit;
    // $query = $db->query($sql);
    // $pkgRec = Subpackage::find_by_sql($sql);
    
    // // pr($pkgRec);
    
    // if (!empty($pkgRec)) {
        
    //     $count = 1;
        
        
    //     $max_count = count($subpkgRec);

    //     foreach ($pkgRec as $key => $subpkgRow) {
    //         $gallRec = SubPackageImage::getImagelimit_by(3, $subpkgRow->id);
    // $subpkg_caro = '';
    // foreach ($gallRec as $row) {
    //             $file_path = SITE_ROOT.'images/package/galleryimages/'.$row->image;
    //             if(file_exists($file_path) and !empty($row->image)):

    //                            // $active=($count==0)?'active':'';
    //                 $subpkg_caro .= '
    //                 <div class="mad-owl-item">
    //                                     <img src="'.IMAGE_PATH.'package/galleryimages/'.$row->image.'" alt="'.$row->title.'" />
    //                                 </div>

                     
                            
    //                             ';
                                
                   
                    

    //             endif;

            
    //         }
            
    //         $button= '';
    //         $modal='';
    //         $imageList = '';
    //         if ($subpkgRow->image != "a:0:{}") {
    //             $imageList = unserialize($subpkgRow->image);
    //         }
    //         if($pkgRow->id==11){
    //             $button='<a href="contact-us" class="btn">Book Now</a>';
    //             if(!empty($subpkgRow->below_content)){
    //             $modal='<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#'. $subpkgRow->slug .'">
    //             details
    //           </button>';
    //             }
    //             else{
    //                 $modal='';
    //             }
    //         }
    //         else{
    //             $button='<a href="#" class="btn">View Menu</a>';
    //         }
            
    //         if($subpkgRow->type==11){
                
    //             $modalpopup .='
    //     <div class="modal fade" id="'. $subpkgRow->slug .'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    //     <div class="modal-dialog">
    //       <div class="modal-content">
    //         <div class="modal-header">
    //           <h5 class="modal-title" id="exampleModalLabel">'. $subpkgRow->title .' details</h5>
    //           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    //         </div>
    //         <div class="modal-body">
    //         ' . $subpkgRow->below_content . '
    //         </div>
    //       </div>
    //     </div>
    //   </div>';
    //         if($count%2==1){
    //         $roomlist .= '
    //         <div class="mad-section mad-section--stretched mad-colorizer--scheme-color-4">
    //                 <div class="mad-entities style-3 type-4">
    //                     <!--================ Entity ================-->
    //                     <article class="mad-entity">
    //                         <div class="mad-entity-media">
    //                             <div class="owl-carousel mad-simple-slideshow mad-grid with-nav">
    //                                 '. $subpkg_caro .'
    //                             </div>
    //                         </div>

    //                         <div class="mad-entity-content">
    //                             <h2 class="mad-entity-title">'. $subpkgRow->title .'</h2>
    //                             <p>' . strip_tags($subpkgRow->content) . '</p>
    //                             <div class="mad-rest-info">
    //                                 <div class="mad-rest-info-item">
    //                                     <span class="mad-rest-title">Hall Amenities</span>
    //                                     <span>'. $subpkgRow->cocktail .'</span>
    //                                 </div>
    //                                 <div class="mad-rest-info-item">
    //                                     <span class="mad-rest-title">Size</span>
    //                                     <span>'.$subpkgRow->seats.'</span>
    //                                 </div>
    //                             </div>
    //                             '.$button.' '.$modal.'
    //                             </div>


    //                     </article>
    //                     <!--================ End of Entity ================-->
    //                 </div>
    //             </div>

                
    //             ';
                
    //         }
    //         else{
    //             $roomlist .='<div class="mad-section">
    //             <div class="mad-entities mad-entities-reverse type-4">
    //                 <!--================ Entity ================-->
    //                 <article class="mad-entity">
    //                     <div class="mad-entity-media">
    //                         <div class="owl-carousel mad-simple-slideshow mad-grid with-nav">
    //                         '. $subpkg_caro .'
    //                         </div>
    //                     </div>
    //                     <div class="mad-entity-content">
    //                         <h2 class="mad-entity-title">'. $subpkgRow->title .'</h2>
    //                         <p>' . strip_tags($subpkgRow->content) . '</p>
    //                         <div class="mad-rest-info">
    //                         <div class="mad-rest-info-item">
    //                         <span class="mad-rest-title">Hall Amenities</span>
    //                         <span>'. $subpkgRow->cocktail .'</span>
    //                     </div>
    //                     <div class="mad-rest-info-item">
    //                         <span class="mad-rest-title">Size</span>
    //                         <span>'.$subpkgRow->seats.'</span>
    //                     </div>
    //                         </div>
    //                         '.$button.' '.$modal.'
    //                     </div>

    //                 </article>
    //                 <!--================ End of Entity ================-->
    //             </div>
    //         </div>';
    //         }
    //         $count++; 

            
    //     }
        
        
    //     if($subpkgRow->type==12){
    //         if($count%2==1){
    //         $roomlist .= '
    //         <div class="mad-section mad-section--stretched mad-colorizer--scheme-color-4">
    //                 <div class="mad-entities style-3 type-4">
    //                     <!--================ Entity ================-->
    //                     <article class="mad-entity">
    //                         <div class="mad-entity-media">
    //                             <div class="owl-carousel mad-simple-slideshow mad-grid with-nav">
    //                                 '. $subpkg_caro .'
    //                             </div>
    //                         </div>

    //                         <div class="mad-entity-content">
    //                             <h2 class="mad-entity-title">'. $subpkgRow->title .'</h2>
    //                             <p>' . strip_tags($subpkgRow->content) . '</p>
    //                             <div class="mad-rest-info">
    //                                 <div class="mad-rest-info-item">
    //                                     <span class="mad-rest-title">Opening hours</span>
    //                                     <span>'. $subpkgRow->theatre_style .' <br />'. $subpkgRow->class_room_style .'</span>
    //                                 </div>
    //                                 <div class="mad-rest-info-item">
    //                                     <span class="mad-rest-title">Cuisine</span>
    //                                     <span>'.$subpkgRow->shape.'</span>
    //                                 </div>
    //                                 <div class="mad-rest-info-item">
    //                                     <span class="mad-rest-title">Dess Code</span>
    //                                     <span>'.$subpkgRow->round_table.'</span>
    //                                 </div>
    //                             </div>
    //                             '.$button.'
    //                             </div>
    //                     </article>
    //                     <!--================ End of Entity ================-->
    //                 </div>
    //             </div>

                
    //             ';
    //         }
    //         else{
    //             $roomlist .='<div class="mad-section">
    //             <div class="mad-entities mad-entities-reverse type-4">
    //                 <!--================ Entity ================-->
    //                 <article class="mad-entity">
    //                     <div class="mad-entity-media">
    //                         <div class="owl-carousel mad-simple-slideshow mad-grid with-nav">
    //                         '. $subpkg_caro .'
    //                         </div>
    //                     </div>
    //                     <div class="mad-entity-content">
    //                         <h2 class="mad-entity-title">'. $subpkgRow->title .'</h2>
    //                         <p>' . strip_tags($subpkgRow->content) . '</p>
    //                         <div class="mad-rest-info">
    //                             <div class="mad-rest-info-item">
    //                                 <span class="mad-rest-title">Opening hours</span>
    //                                 <span>'. $subpkgRow->theatre_style .'<br />'. $subpkgRow->class_room_style .' </span>
    //                             </div>
    //                             <div class="mad-rest-info-item">
    //                                 <span class="mad-rest-title">Cuisine</span>
    //                                 <span>'.$subpkgRow->shape.'</span>
    //                             </div>
    //                             <div class="mad-rest-info-item">
    //                                 <span class="mad-rest-title">Dess Code</span>
    //                                 <span>'.$subpkgRow->round_table.'</span>
    //                             </div>
    //                         </div>
    //                         '.$button.'
    //                     </div>

    //                 </article>
    //                 <!--================ End of Entity ================-->
    //             </div>
    //         </div>';
    //         }
    //         $count++; 

    //     }
        
    // }
    //     $room_package = '
    //             <!-- Rooms starts -->
    //             <div class="mad-content no-pd">
    //         <div class="container">
    //             <div class="mad-section">
    //                 <div class="row">
    //                     <div class="col-lg-5">
    //                         <div class="mad-pre-title">M.I.C.E</div>
    //                         <h2 class="mad-page-title" style="font-size: 42px;line-height: 46px;">' . $pkgRow->sub_title . '</h2>
    //                     </div>
    //                     <div class="col-lg-7">
    //                         <p class="mad-text-medium">' . $pkgRow->content . '
    //                         </p>
    //                     </div>
    //                 </div>
    //             </div>
    //                             '. $roomlist .'
    //                         </div>
    //                     </div>
                    
                
    //             <!-- Room Ends -->';
    // }
    
}
// if($pkgRow->id >= 14){

//     $room_package = '
//                 <!-- Rooms starts -->
//                 <div class="mad-content no-pd">
//             <div class="container">
//                 <div class="mad-section">
//                     <div class="row">
//                         <div class="col-lg-5">
//                             <div class="mad-pre-title">' . $pkgRow->title . '</div>
//                             <h2 class="mad-page-title" style="font-size: 42px;line-height: 46px;">' . $pkgRow->sub_title . '</h2>
//                         </div>
                        
//                     </div>
//                     <div class="col-lg-7">
//                             <p class="mad-text-medium">' . $pkgRow->content . '
//                             </p>
//                         </div>
//                 </div>
//                             </div>
//                         </div>
                    
                
//                 <!-- Room Ends -->';
// }
}


// if (defined('HOME_PAGE')) {



//     $sql = "SELECT *  FROM tbl_package_sub WHERE status='1' AND type = '1' ORDER BY sortorder DESC ";

//     $page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"])) ? $_REQUEST["pageno"] : 1;
//     $limit = 200;
//     $total = $db->num_rows($db->query($sql));
//     $startpoint = ($page * $limit) - $limit;
//     $sql .= " LIMIT " . $startpoint . "," . $limit;
//     $query = $db->query($sql);
//     $pkgRec = Subpackage::find_by_sql($sql);
    
    
//     // pr($pkgRec);
//     if (!empty($pkgRec)) {

//         foreach ($pkgRec as $key => $subpkgRow) {
//             $gallRec = SubPackageImage::getImagelist_by($subpkgRow->id);
//             $imageList = '';
//             $imagepath='';
//                 $imageList = $gallRec[0];


//                     $file_path = SITE_ROOT.'images/package/galleryimages/'.$imageList->image;
//                     if(file_exists($file_path) and !empty($imageList)):
                        
//                         $imagepath = IMAGE_PATH.'package/galleryimages/'.$imageList->image;
                        
                        
//                     endif;
// // pr($imagepath);

//             $roomlist .= '
//             <div class="mad-col">
//                                 <div class="mad-section with-overlay mad-colorizer--scheme-" data-bg-image-src="' . $imagepath . '" alt="' . $subpkgRow->title . '">
//                                     <!--================ Entity ================-->
//                                     <article class="mad-entity">
//                                         <h3 class="mad-entity-title">'. $subpkgRow->title .'</h3>
//                                         <p>
//                                         ' . strip_tags($subpkgRow->detail) . '
//                                         </p>
//                                         <div class="btn-set justify-content-center">
//                                             <a href="'.BASE_URL.'result.php?hotel_code='. $booking_code .'" class="btn btn-big" target="_blank">Book Now</a>
//                                             <a href="' . BASE_URL . $subpkgRow->slug . '" class="btn btn-big style-2">Details</a>
//                                         </div>
//                                     </article>
//                                     <!--================ End of Entity ================-->
//                                 </div>
//                             </div>

                
//                 ';

//         }
//         $room_package = '
//         <div class="mad-section no-pb mad-section--stretched-content-no-px mad-colorizer--scheme-color-">
//         <div class="mad-title-wrap align-center">
//             <div class="row justify-content-center">
//                 <div class="col-lg-6">
//                     <div class="mad-pre-title">accommodation</div>
//                     <h2 class="mad-page-title">Rooms & Suites</h2>
//                     <p class="mad-text-medium">The hotel offers 68 rooms: Standard, Deluxe, Deluxe premium & Junior suite. The highlight of all the rooms are the spacious private balcony where guests can enjoy the most breathtaking views from the comforts of their own room.</p>
//                 </div>
//             </div>
//         </div>

//         <div class="mad-section no-pd mad-section--stretched-content-no-px mad-colorizer--scheme-">
//             <div class="mad-entities single-entity style-2 mad-grid owl-carousel mad-grid--cols-1 mad-owl-moving nav-size-2 no-dots">
//                                 '. $roomlist .'
//                                 </div>
//                                 </div>
//                             </div>';
//     }
// }





$jVars['module:list-modalpop-up'] = $modalpopup;
$jVars['module:list-package-room'] = $room_package;
$jVars['module:list-package-room-bred'] = $roombread;


/**
 *      Package Record
 */
$resubpkgDetail = $resubpkgbann = $bcont = '';

if (defined('SUBPACKAGE_PAGE') and isset($_REQUEST['slug'])) {

    $id = !empty($_REQUEST['id']) ? addslashes($_REQUEST['id']) : '';
    $slug = !empty($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
    $subpkgRec = Subpackage::find_by_slug($slug);
    $pkgRec = Package::find_by_id($subpkgRec->type);
    //echo "<pre>";print_r($slug);die();
    $gallRec = SubPackageImage::getImagelist_by($subpkgRec->id);
    $otherPacs = Subpackage::get_relatedpkg($subpkgRec->type, $subpkgRec->id, 12);
    
    // pr($subpkgRec,1);

    $subSlider = $roomBooking = $otherRoomDetails = $roomFeat = $amenitiesTitle = $roomFeatGroup = '';
    if (!empty($subpkgRec)) {
        
        if($subpkgRec->image != 'a:0:{}'){
            $unSerializedImgs = unserialize($subpkgRec->image);
            foreach($unSerializedImgs as $img){
                $file_path = SITE_ROOT . 'images/subpackage/'. $img;
                $imgLink = '';
                if(file_exists($file_path)){
                    $imgLink = IMAGE_PATH . 'subpackage/' . $img;
                }else{
                    $imgLink = BASE_URL . 'template/web/assets/images/room/roombanner1.jpg';
                }

                $subSlider .= '
                    <div class="swiper-slide room__wrapper">
                        <img src="'. $imgLink .'" alt="room card">
                    </div>
                ';
            }
        }

        $resubpkgbann .= '
                <div class="rts__section banner__area is__home__one banner__height banner__center">
                    <div class="room__slider overflow-hidden" style="height: 700px;max-height: 700px;" >
                        <div class="swiper-wrapper ">
                            '. $subSlider .'
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
                    </div>
                </div>
            ';



        $pkgType = Package::field_by_id($subpkgRec->type, 'type');

        $subpkgImg = $subpkgRec->image;


        if($subpkgRec->feature != 'a:0:{}'){

            $saveRec = unserialize($subpkgRec->feature);
            if ($saveRec != null) {
                $featureList = $saveRec[119][1];
                $amenitiesTitle =  $saveRec[119][0][0] ;
                // pr($featureList,1);
                if ($featureList) {
                    foreach ($featureList as $key => $fetRow) {
                        $icoRec = Features::get_by_id($fetRow);
                        
                        $roomFeat .= '
                            <div class="single__item">
                                <img src="'. IMAGE_PATH .'features/'. $icoRec->image .'" height="30" width="36" alt="'. $icoRec->title .'">
                                <span>'. $icoRec->title .'</span>
                            </div>
                        ';                        
                    }
    
                }
            }
        }

        $resubpkgDetail .= '
            <div class="rts__section section__padding pillar-icon" style="background: #f8f2e2;">
                <div class="section__shape">
                    <img src="'. BASE_URL .'template/web/assets/images/pillar.png" alt="pillar">
                </div>
                <div class="container px-5">
                    <div class="row g-5 sticky-wrap">
                        <div class="col-xxl-12 col-xl-12">
                            <div class="room__details">
                                <h4 class="room__title">'. $subpkgRec->title .'</h4>
                                '. $subpkgRec->content .'
                    
                                <span class="h4 d-block mb-30 mt-50">'. $amenitiesTitle .'</span>
                                <div class="room__amenity mb-50">
                                <div class="group__row">'. $roomFeat .'</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-5 sticky-item d-none">
                            <div class="rts__booking__form has__background is__room__details">
                                <form action="#" method="post" class="advance__search">
                                    <h5 class="pt-0">Book Your Stay</h5>
                                    <div class="advance__search__wrapper">
                                        <!-- single input -->
                                        <div class="query__input wow fadeInUp">
                                            <label for="check__in" class="query__label">Check In</label>
                                            <div class="query__input__position">
                                                <input type="text" id="check__in" name="check__in" placeholder="15 Jun 2024" required>
                                                <div class="query__input__icon">
                                                    <i class="flaticon-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single input end -->

                                        <!-- single input -->
                                        <div class="query__input wow fadeInUp" data-wow-delay=".3s">
                                            <label for="check__out" class="query__label">Check Out</label>
                                            <div class="query__input__position">
                                                <input type="text" id="check__out" name="check__out" placeholder="15 May 2024" required>
                                                <div class="query__input__icon">
                                                    <i class="flaticon-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single input end -->

                                        <!-- submit button -->
                                        <button class="theme-btn btn-style fill no-border search__btn wow fadeInUp" data-wow-delay=".6s">
                                            <span>Book Your Room</span>
                                        </button>
                                        <!-- submit button end -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    if ($pkgType == 1) {
        $similarRooms = '';
        
        foreach($otherPacs as $others){
            $similarRooms.='
                <div class="col-lg-6 col-xl-4 col-md-6">
                    <div class="room__card">
                        <div class="room__card__top">
                            <div class="room__card__image">
                                <a href="'. $others->slug .'">
                                    <img src="'. IMAGE_PATH .'subpackage/image/'. $others->image2 .'" width="420" height="310" alt="room card">
                                </a>
                            </div>
                        </div>
                        <div class="room__card__meta">
                            <a href="'. $others->slug .'" class="room__card__title h6">'.$others->title.'</a>
                            <div class="room__card__meta__info">
                                <span><i class="flaticon-construction"></i>'. $others->room_size .'</span>
                                <span><i class="flaticon-user"></i>'. $others->occupancy .' Person</span>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        $otherRoomDetails = '
            <div class="rts__section pb-120 pt-120 pillar-icon3" style="background: #f8f2e2;">
                <div class="section__shape">
                    <img src="'. BASE_URL .'template/web/assets/images/pillar2.png" alt="pillar">
                </div>
                <div class="container-fluid px-5">
                    <div class="row justify-content-center text-center mb-40">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="section__topbar">
                                <h4 class="section__title">Similar Rooms</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row g-30">
                        '. $similarRooms .'
                    </div>
                </div>
            </div>
        ';


    }

    $roomBooking = '
        <div class="rts__section section__padding blog is__home__three" style="background: #f3e8c8;">
            <div class="section__shape">
                <img src="'. BASE_URL .'template/web/assets/images/pillar.png" alt="'. $subpkgRec->title .'">
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="room__details__top">
                            <h5>'. $subpkgRec->short_title .'</h5>
                            <!-- submit button -->
                            <button class="theme-btn btn-style fill no-border search__btn wow fadeInUp" data-wow-delay=".6s">
                                <span>Book Your Room</span>
                            </button>
                            <!-- submit button end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';



    $jVars['module:sub-package-booking'] = $roomBooking;
    $jVars['module:similar-rooms'] = $otherRoomDetails;

}
$jVars['module:form-controll'] = $bcont;
$jVars['module:sub-package-banner'] = $resubpkgbann;
$jVars['module:sub-package-detail'] = $resubpkgDetail;








/*
* Sub package 
*/
$resubpkgDetail = '';
$subimg = '';
$imageList = '';

// if (defined('SUBPACKAGE_PAGE') and isset($_REQUEST['slug'])) {
//     $slug = !empty($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
//     $subpkgRec = Subpackage::find_by_slug($slug);
//      $gallRec = SubPackageImage::getImagelist_by($subpkgRec->id);
//      $booking_code = Config::getField('hotel_code', true);
//     if (!empty($subpkgRec)) {
//         if ($subpkgRec->type == 1) {
//             $relPacs = Subpackage::get_relatedpkg(1, $subpkgRec->id, 12);
//             $imglink = '';
//             if (!empty($subpkgRec->image2)) {
//                 $file_path = SITE_ROOT . 'images/subpackage/image/' . $subpkgRec->image2;
//                 if (file_exists($file_path)) {
//                     $imglink = IMAGE_PATH . 'subpackage/image/' . $subpkgRec->image2;
//                 } else {
//                     $imglink = IMAGE_PATH . 'static/default-art-pac-sub.jpg';
//                 }
//             } else {
//                 $imglink = IMAGE_PATH . 'static/default-art-pac-sub.jpg';
//             }
            
//             $pkgRec = Package::find_by_id($subpkgRec->type);
//             $subpkg_carousel = '';
//             foreach ($gallRec as $row) {
//                 $file_path = SITE_ROOT.'images/package/galleryimages/'.$row->image;
//                 if(file_exists($file_path) and !empty($row->image)):

//                     $subpkg_carousel .= '
//                     <div class="mad-col"><img src="'.IMAGE_PATH.'package/galleryimages/'.$row->image.'" alt="'.$row->title.'" /></div>
                              
//                                 ';
                    

//                 endif;

            
//             }

//             $resubpkgDetail .= '
//             <div class="owl-carousel mad-grid mad-grid--cols-1 mad-owl-moving nav-size-2 no-dots mad-gallery-slider">
//             '.$subpkg_carousel.'
//             </div>

            
//             ';

//             // $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($subpkgRec->content));
//             // pr($subpkgRec);


//             $resubpkgDetail .= '
//                 <!-- details starts-->
//                 <div class="mad-content mad-single-content">
//             <div class="container-fluid">
//                 <div class="content-element-main">
//                     <div class="row hr-size-3 vr-size-3 sticky-bar">
//                         <main id="main" class="col-xxl-9 col-lg-8">
//                             <div class="mad-entities mad-single-room content-element-7">
//                                 <div class="mad-single-room-content">';


//             $resubpkgDetail .= '
//                                     <div class="mad-col">
//                                         <h2 class="mad-title" data-hover="Superior Single Room">
//                                         '. $subpkgRec->title .'
//                                         </h2>
//                                         <div class="mad-room-details">
//                                             <span class="mad-room-detail">
//                                                 <img src="template/web/images/icons/cube.png" alt="" class="svg"/>
//                                                 <span>'. $subpkgRec->room_size .'</span>
//                                             </span>

//                                             <span class="mad-room-detail">
//                                                 <img src="template/web/images/icons/king-bed.png" alt="" class="svg"/>
//                                                 <span>' . $subpkgRec->bed .'</span>
//                                             </span>

//                                             <span class="mad-room-detail">
//                                                 <img src="template/web/images/icons/people.png" alt="" class="svg"/>
//                                                 <span>'. $subpkgRec->occupancy .'</span>
//                                             </span>

//                                             <span class="mad-room-detail">
//                                                 <img src="template/web/images/icons/view.png" alt="" class="svg"/>
//                                                 <span>'. $subpkgRec->view .'</span>
//                                             </span>
//                                         </div>
//                                     </div>';



//             $resubpkgDetail .= '
//                             <div class="mad-col">
//                                         <div class="mad-pricing-value content-element-3">
//                                             <span>Starting From</span>
//                                             <span class="mad-pricing-value-num">'. $subpkgRec->currency . $subpkgRec->onep_price .'/
//                                                 <span>night</span>
//                                             </span>
//                                         </div>
//                                     </div>
//                                 </div>
//                             </div>
//                             <!--================ Accordion ================--> ';
          

//             $resubpkgDetail .= '
//             <dl role="presentation" class="mad-panels ">
//                                 <dt class="mad-panels-title ">
//                                     <button id="panel-7-button" type="button" aria-expanded="false" aria-controls="panel-7" aria-disabled="false">
//                                         Description
//                                     </button>
//                                 </dt>

//                                 <dd id="panel-7" class="mad-panels-definition">
//                                     <p class="mad-text-medium">
//                                     '.$subpkgRec->content.'
//                                     </p>
//                                 </dd>';
//                                 if (!empty($subpkgRec->feature)) {
//                                     $ftRec = unserialize($subpkgRec->feature);
//                                     if (!empty($ftRec)) {
//                                         $resubpkgDetail .= '
//                                         <!-- amenities starts -->
//                                         <dt class="mad-panels-title ">
//                                         <button id="panel-8-button" type="button" aria-expanded="true" aria-controls="panel-8" aria-disabled="false">
//                                             Room Amenities
//                                         </button>
//                                     </dt>
//                                     <dd id="panel-8" class="mad-panels-definition">
//                                     <div class="row">';
                    
                    
//                                         $resubpkgDetail .= '        
                                        
//                                         ';
//                                             foreach ($ftRec as $k => $v) {
//                                                 // $resubpkgDetail .= '<h3 class="room_d_title">' . $v[0][0] . '</h3>';
//                                                 if (!empty($v[1])) {
//                                                     $sfetname='';
//                                                     $i=0;
//                                                     $resubpkgDetail .= '';
//                                                     $feature_list ='';
//                                                     foreach ($v[1] as $kk => $vv) {
//                                                         $sfetname = Features::find_by_id($vv);
//                                                         $feature_list .= '
//                                                         <span class="mad-room-detail">
//                                                     <img src="' . BASE_URL . 'images/features/'. $sfetname->image . '" alt="'. $sfetname->title . '" class="svg"/>
//                                                     <span>' . $sfetname->title . '</span>
//                                                     </span>';
//                                                         $i++;
//                                                         if(($i%4 == 0) || (end($v[1]) == $vv)){
//                                                         $resubpkgDetail .= '
//                                                         <div class="col-md-4">
//                                                         <div class="mad-room-details vr-type size-2 style-2">
//                                                                 '. $feature_list .'
//                                                             </div>
//                                                             </div>
                                                        
//                                                             ';
//                                                             $feature_list='';
//                                                     }
//                                                 }
//                                             }                             
//                                     }
                                     
//                                     }
//                                     $resubpkgDetail .= '
                                                                
//                                                                 </div>
//                                                             </dd>
//                                                         </dl>
//                                                         <!--================ End of Accordion ================-->';
//                                 }


           

//             $resubpkgDetail .='                    
//             </main>';



//             $resubpkgDetail .= '
//             <aside id="sidebar" class="col-xxl-3 col-lg-4 mad-sidebar">
//                             <div class="mad-widget">
//                                 <div class="mad-booking-wrap size-2" style="background: #1db263;">
//                                     <h3 class="mad-booking-title">
//                                         <i class="mad-booking-icon">
//                                             <img src="template/web/images/icons/calendar.png" alt="" class="svg" />
//                                         </i><span>Check Availability</span>
//                                     </h3>
//                                     <div class="mad-form-row">
//                                         <div class="mad-form-col">
//                                             <label>Arrival Date</label>
//                                             <div class="mad-datepicker">
//                                                 <div class="mad-datepicker-body">
//                                                     <span class="mad-datepicker-others">
//                                                         <span class="mad-datepicker-month-year">Friday, 15 April</span>
//                                                     </span>
//                                                 </div>

//                                                 <div class="mad-datepicker-select">
//                                                     <div class="calendar_wrap mad-calendar-rendered">
//                                                         <table class="wp-calendar">
//                                                             <caption>
//                                                                 September 2021
//                                                                 <a class="calendar-caption-prev" href="#"><i class="material-icons">keyboard_arrow_left</i></a>
//                                                                 <a class="calendar-caption-next" href="#"><i class="material-icons">keyboard_arrow_right</i></a>
//                                                             </caption>
//                                                             <thead class="div">
//                                                                 <tr>
//                                                                     <th>Sun</th>
//                                                                     <th>Mon</th>
//                                                                     <th>Tue</th>
//                                                                     <th>Wed</th>
//                                                                     <th>Thu</th>
//                                                                     <th>Fri</th>
//                                                                     <th>Sat</th>
//                                                                 </tr>
//                                                             </thead>
//                                                             <tbody>
//                                                                 <tr>
//                                                                     <td class="first">
//                                                                       <div class="marker">30</div>
//                                                                     </td>
//                                                                     <td>
//                                                                       <div class="marker">31</div>
//                                                                     </td>
//                                                                     <td>1</td>
//                                                                     <td>2</td>
//                                                                     <td>3</td>
//                                                                     <td>4</td>
//                                                                     <td>5</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">6</td>
//                                                                     <td>7</td>
//                                                                     <td>8</td>
//                                                                     <td ><a href="#">9</a></td>
//                                                                     <td>10</td>
//                                                                     <td>11</td>
//                                                                     <td>12</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">13</td>
//                                                                     <td>14</td>
//                                                                     <td>15</td>
//                                                                     <td>16</td>
//                                                                     <td>17</td>
//                                                                     <td>18</td>
//                                                                     <td>19</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">20</td>
//                                                                     <td>21</td>
//                                                                     <td>22</td>
//                                                                     <td>23</td>
//                                                                     <td>24</td>
//                                                                     <td>25</td>
//                                                                     <td>26</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">27</td>
//                                                                     <td>28</td>
//                                                                     <td>29</td>
//                                                                     <td>30</td>
//                                                                     <td>
//                                                                       <div class="marker">1</div>
//                                                                     </td>
//                                                                     <td>
//                                                                       <div class="marker">2</div>
//                                                                     </td>
//                                                                     <td>
//                                                                       <div class="marker">3</div>
//                                                                     </td>
//                                                                 </tr>
//                                                             </tbody>
//                                                         </table>
//                                                     </div>
//                                                 </div>
//                                             </div>
//                                         </div>
//                                         <div class="mad-form-col">
//                                             <label>Departure Date</label>
                                            
//                                             <div class="mad-datepicker">
//                                                 <div class="mad-datepicker-body">
//                                                     <span class="mad-datepicker-others">
//                                                         <span class="mad-datepicker-month-year">Wednesday, 27 April</span>
//                                                     </span>
//                                                 </div>
//                                                 <div class="mad-datepicker-select">
//                                                     <div class="calendar_wrap mad-calendar-rendered">
//                                                         <table class="wp-calendar">
//                                                             <caption>
//                                                                 September 2021
//                                                                 <a class="calendar-caption-prev" href="#">
//                                                                     <i class="material-icons">keyboard_arrow_left</i>
//                                                                 </a>
//                                                                 <a class="calendar-caption-next" href="#">
//                                                                     <i class="material-icons">keyboard_arrow_right</i>
//                                                                 </a>
//                                                             </caption>
//                                                             <thead class="div">
//                                                                 <tr>
//                                                                     <th>Sun</th>
//                                                                     <th>Mon</th>
//                                                                     <th>Tue</th>
//                                                                     <th>Wed</th>
//                                                                     <th>Thu</th>
//                                                                     <th>Fri</th>
//                                                                     <th>Sat</th>
//                                                                 </tr>
//                                                             </thead>
//                                                             <tbody>
//                                                                 <tr>
//                                                                     <td class="first">
//                                                                       <div class="marker">30</div>
//                                                                     </td>
//                                                                     <td>
//                                                                       <div class="marker">31</div>
//                                                                     </td>
//                                                                     <td>1</td>
//                                                                     <td>2</td>
//                                                                     <td>3</td>
//                                                                     <td>4</td>
//                                                                     <td>5</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">6</td>
//                                                                     <td>7</td>
//                                                                     <td>8</td>
//                                                                     <td ><a href="#">9</a></td>
//                                                                     <td>10</td>
//                                                                     <td>11</td>
//                                                                     <td>12</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">13</td>
//                                                                     <td>14</td>
//                                                                     <td>15</td>
//                                                                     <td>16</td>
//                                                                     <td>17</td>
//                                                                     <td>18</td>
//                                                                     <td>19</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">20</td>
//                                                                     <td>21</td>
//                                                                     <td>22</td>
//                                                                     <td>23</td>
//                                                                     <td>24</td>
//                                                                     <td>25</td>
//                                                                     <td>26</td>
//                                                                 </tr>
//                                                                 <tr>
//                                                                     <td class="first">27</td>
//                                                                     <td>28</td>
//                                                                     <td>29</td>
//                                                                     <td>30</td>
//                                                                     <td>
//                                                                       <div class="marker">1</div>
//                                                                     </td>
//                                                                     <td>
//                                                                       <div class="marker">2</div>
//                                                                     </td>
//                                                                     <td>
//                                                                       <div class="marker">3</div>
//                                                                     </td>
//                                                                 </tr>
//                                                             </tbody>
//                                                         </table>
//                                                     </div>
//                                                 </div>
//                                             </div>
//                                         </div>

//                                         <div class="mad-form-col">
//                                             <label>Rooms</label>
//                                             <div class="mad-custom-select">
//                                                 <select data-default-text="1 room">
//                                                     <option>2 rooms</option>
//                                                     <option>3 rooms</option>
//                                                     <option>4 rooms</option>
//                                                 </select>
//                                             </div>
//                                         </div>

//                                         <div class="mad-form-col short-col">
//                                             <div class="row">
//                                                 <div class="col-lg-6">
//                                                     <label>Adults</label>
//                                                     <div class="quantity size-2">
//                                                         <input type="text" value="1" readonly="" />
//                                                         <button type="button" class="qty-plus">
//                                                             <i class="material-icons">keyboard_arrow_up</i>
//                                                         </button>
//                                                         <button type="button" class="qty-minus">
//                                                             <i class="material-icons">keyboard_arrow_down</i>
//                                                         </button>
//                                                     </div>
//                                                 </div>

//                                                 <div class="col-lg-6">
//                                                     <label>children</label>
//                                                     <div class="quantity size-2">
//                                                         <input type="text" value="0" readonly="" />
//                                                         <button type="button" class="qty-plus">
//                                                             <i class="material-icons">keyboard_arrow_up</i>
//                                                         </button>
//                                                         <button type="button" class="qty-minus">
//                                                             <i class="material-icons">keyboard_arrow_down</i>
//                                                         </button>
//                                                     </div>
//                                                 </div>
//                                             </div>
//                                         </div>
//                                     </div>
//                                     <button type="submit" class="btn">
//                                         Book Now
//                                     </button>
//                                 </div>
//                             </div>
//                         </aside>
//                     </div>
//                 </div>';
//         $otherroom='';
//         $rooms = Subpackage::get_relatedsub_by($subpkgRec->type,$subpkgRec->id);
            
				
// 				if(!empty($rooms)){
                
                    
// 					foreach($rooms as $room){
//                         if (!empty($room->image)) {
//                             $img123 = unserialize($room->image);
                            
//                             if (file_exists($file_path) && !empty($img123[0])) {
//                                 $imglink = IMAGE_PATH . 'subpackage/' . $img123[0];
//                                 $file_path = SITE_ROOT . 'images/subpackage/' . $img123[0];
//                             } else {
//                                 $imglink = IMAGE_PATH . 'static/static.jpg';
//                             }
//                         } else {
//                             $imglink = IMAGE_PATH . 'static/static.jpg';
//                         }

                      
//     $otherroom .='
//                     <div class="mad-col">
//                         <!--================ Entity ================-->
//                         <article class="mad-entity">
//                             <div class="mad-entity-media">
//                                 <a href="'.BASE_URL.$room->slug.'">
//                                     <img src="'.$imglink.'" alt=""/>
//                                 </a>
//                             </div>
//                             <div class="mad-entity-content">
//                                 <h4 class="mad-entity-title">'.$room->title.'</h4>
//                                 <div class="mad-pricing-value">
//                                     <span>From</span>
//                                     <span class="mad-pricing-value-num">'. $room->currency . $room->onep_price .'/</span>
//                                     <span>night</span>
//                                 </div>
//                                 <div class="mad-entity-footer">
//                                     <div class="btn-set justify-content-center">
//                                         <a href="#" class="btn btn-big">Book Now</a>
//                                         <a href="'.BASE_URL.$room->slug.'" class="btn btn-big style-2">Details</a>
//                                     </div>
//                                 </div>
//                             </div>
//                         </article>
//                         <!--================ End of Entity ================-->
//                     </div>
            
                    
// 			';
            
//         }
//         //$otherroom.='';
//     $resubpkgDetail .='
//     <h2 class="mad-page-title">Related Rooms</h2>
//     <div class="mad-entities with-hover align-center type-3 item-col-3">
//                             '. $otherroom .'
//                             </div>
//                             </div>
//                         </div>
                
//         ';  
// 				}




           
//         }


//         /********For service inner page ***************/
//             else {
//                 $relPacs = Subpackage::get_relatedpkg(1, $subpkgRec->id, 12);
//                 $imglink = '';
//                 if (!empty($subpkgRec->image2)) {
//                     $file_path = SITE_ROOT . 'images/subpackage/image/' . $subpkgRec->image2;
//                     if (file_exists($file_path)) {
//                         $imglink = IMAGE_PATH . 'subpackage/image/' . $subpkgRec->image2;
//                     } else {
//                         $imglink = IMAGE_PATH . 'static/default.jpg';
//                     }
//                 } else {
//                     $imglink = IMAGE_PATH . 'static/default.jpg';
//                 }
                
                
    
                
                    
//                         $resubpkgDetail .= '
//                         <!--================ Breadcrumb ================-->
//         <div class="mad-breadcrumb with-bg-img with-overlay" data-bg-image-src="' . $imglink . '">
//             <div class="container wide">
//                 <h1 class="mad-page-title">' . $subpkgRec->title . '</h1>
//                 <nav class="mad-breadcrumb-path">
//                     <span><a href="home" class="mad-link">Home</a></span> /
//                     <span>' . $subpkgRec->title . '</span>
//                 </nav>
//             </div>
//         </div>
//         <!--================ End of Breadcrumb ================-->
                                                
//                                         ';

                        
//                             $resubpkgDetail .= '
//                             <div class="mad-content no-pd">
//             <div class="container">
//                 <div class="mad-section">
//                     <div class="mad-entities mad-entities-reverse type-4">
//                                 '. $subpkgRec->content .'
//                                 </div>
//                 </div>
//             </div>
//         </div>';
//                             $resubpkgDetail .= $subpkgRec->below_content;
                        

//                         $resubpkgDetail .='';


                        
//         }




//     }
// }

// $jVars['module:sub-package-detail'] = $resubpkgDetail;



/**********        For What;s nearby from package **************/
$resubpkgDetail = '';
$relPacs = Subpackage::get_relatedpkg(10, 0, 12);

                foreach($relPacs as $relPac){
                   
                        $imglink = '';
                        if (!empty($relPac->image)) {
                            $img123 = unserialize($relPac->image);
                            $file_path = SITE_ROOT . 'images/subpackage/' . $img123[0];
                            if (file_exists($file_path)) {
                                $imglink = IMAGE_PATH . 'subpackage/' . $img123[0];
                            } else {
                                $imglink = IMAGE_PATH . 'static/default-art-pac-sub.jpg';
                            }
                        } else {
                            $imglink = IMAGE_PATH . 'static/default-art-pac-sub.jpg';
                        }
                        $resubpkgDetail .= '

                                            <div class="col-lg-3 col-md-6">
                                                <div class="top-hotels-ii">
                                                    <img src="'. $imglink .'" alt=" '. $relPac->title .'"/>
                                                    '. $relPac->content .'
                                                    <div class="pp-details yellow">
                                                        <span class="pull-left">More Info</span>
                                                        <span class="pp-tour-ar">
                                                                <a href="javascript:void(0)"><i class="fa fa-angle-right pad-0"></i></a>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ';

                        

                }

$whats_nearby = '
            <section class="top-hotel">
                <div class="container-xxl px-5">
                    <div class="top-title">
                        <div class="row display-flex">
                            <div class="col-lg-8 mx-auto text-center">
                                <h2>What\'s <span>Nearby</span></h2>
                                <p class="mar-0">
                                    We are located at the heart of Lalitpur. Major shopping outlets, Patan Durbar Square, Hospitals, Banks, UN office, Government offices, etc are
                                    within walking distance.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--Gallery Section-->
                    <div class="row activities-slider">
                        '. $resubpkgDetail .'
                    </div>
                </div>
            </section>';

// pr($whats_nearby);
$jVars['module:whats-nearby'] = $whats_nearby;

                    
                        
                        



