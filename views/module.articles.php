<?php
$resinndetail = $imageList = $innerbred = $t = '';
$homearticle = Article::find_by_id(22);
if (!empty($homearticle)) {
    if ($homearticle->image != "a:0:{}") {
        $imageList = unserialize($homearticle->image);
        $imgno = array_rand($imageList);
        $file_path = SITE_ROOT . 'images/articles/' . $imageList[$imgno];
        if (file_exists($file_path)) {
            $imglink = IMAGE_PATH . 'articles/' . $imageList[$imgno];
        } else {
            $imglink = BASE_URL . 'template/web/img/mosaic_2.jpg';
        }
    } else {
        $imglink = BASE_URL . 'template/cms/img/mosaic_2.jpg';
    }
    $t .= ' <div class="col-xs-12">
                     <a href="' . BASE_URL . 'page/' . $homearticle->slug . '">
                    <div class="mosaic_container">
                        <img src="' . $imglink . '" alt="' . $homearticle->title . '" class="img-responsive add_bottom_30"><span class="caption_2"> ' . $homearticle->title . '</span>
                    </div>
                    </a>
                </div>';


}

$jVars['module:aboutarticle'] = $t;

/**
 *      Home page
 */
$resinnh = '';

if (defined('HOME_PAGE')) {
    $recInn = Article::homepageArticle();

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
        <div class="position-relative  wow fadeInUp animated text-center" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
            <h6 class="mb-1">'. $avgRating .' out of 5</h6>
            <div class="de-rating-ext fs-18" style="background-size: cover; background-repeat: no-repeat;">
                <span class="d-stars">
                    '. $ratingStars .'
                </span>
            </div>
            <span class="d-block fs-14 mb-0">Based on '.$totalTestimonial.'+ reviews</span>
        </div>
    ';
    // pr($recInn,1);
    if (!empty($recInn)) {
        foreach ($recInn as $innRow) {
            // $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($innRow->content));
            // $readmore = '';
            // if (!empty($innRow->linksrc)) {
            //     $linkTarget = ($innRow->linktype == 1) ? ' target="_blank" ' : '';
            //     $linksrc = ($innRow->linktype == 1) ? $innRow->linksrc : BASE_URL . $innRow->linksrc;
            //     $readmore = '<a href="' . $linksrc . '" title="">see more</a>';
            // } else {
            //     $readmore = (count($content) > 1) ? '<a href="' . BASE_URL . 'page/' . $innRow->slug . '" title="">Read more...</a>' : '';
            // }
            $resinnh .= '
                <div class="about__wrapper">
                    <div class="content">
                        <span class="h6  d-block wow fadeInUp">'. $innRow->sub_title .'</span>
                        <h2 class="content__title wow fadeInUp">'. $innRow->title .'</h2>
                        <p class="content__subtitle wow fadeInUp" data-wow-delay=".3s">'. preg_replace('/<\/?p>/','',$innRow->content) .'</p>
                    </div>

                    <div class="image">
                        '. $ratings .'
                    </div>
                </div>
            ';
        }
    }

    $jVars['module:home-article'] = $resinnh;
}


/**
 *      Inner page detail
 */

$aboutdetail = $imageList = $aboutbred = '';

if (defined('INNER_PAGE') and isset($_REQUEST['slug'])) {
    $slug = addslashes($_REQUEST['slug']);
    $recRow = Article::find_by_slug($slug);
    // pr($recRow,1);

    if (!empty($recRow)) {

        // $imglink = BASE_URL . 'template/web/images/default.jpg';
        // if ($recRow->image != "a:0:{}") {
        //     $imageList = unserialize($recRow->image);
        //     $imgno = array_rand($imageList);
        //     $file_path = SITE_ROOT . 'images/articles/' . $imageList[$imgno];
        //     if (file_exists($file_path)) {
        //         $imglink = IMAGE_PATH . 'articles/' . $imageList[$imgno];
        //     }
        //     else{
        //         $imglink = BASE_URL . 'template/web/images/default.jpg';
        //     }
        // }

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
            <div class="position-relative  wow fadeInUp animated text-center" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                <h6 class="mb-1">'. $avgRating .' out of 5</h6>
                <div class="de-rating-ext fs-18" style="background-size: cover; background-repeat: no-repeat;">
                    <span class="d-stars">
                        '. $ratingStars .'
                    </span>
                </div>
                <span class="d-block fs-14 mb-0">Based on '.$totalTestimonial.'+ reviews</span>
            </div>
        ';
        
       if($recRow->id == 17) {
            $aboutdetail = '
                <div class="container">
                    <div class="row">
                        <div class="about__wrapper">
                            <div class="content">
                                <span class="h6  d-block wow fadeInUp">Welcome To Aarya hotel & spa</span>
                                <h2 class="content__title wow fadeInUp">'. $recRow->sub_title .'</h2>
                                <p class="content__subtitle wow fadeInUp">'. preg_replace('/<\/?p>/','',$recRow->content) .'</p>
                            </div>

                            <div class="image ">
                                '. $ratings .'
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container-fluid px-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="'. BASE_URL .'template/web/assets/images/about/2.webp" alt="about us image" class="mt-6">
                        </div>
                        <div class="col-md-4">
                            <img src="'. BASE_URL .'template/web/assets/images/about/3.webp" alt="about us image" class="mt-7">
                        </div>
                        <div class="col-md-4">
                            <img src="'. BASE_URL .'template/web/assets/images/about/6.webp" alt="about us image" class="mt-4">
                        </div>
                    </div>
                </div>
            ';
        }else{
            $aboutdetail = '
                <div class="container">
                    <div class="row">
                        <div class="about__wrapper">
                            <div class="content">
                                <h2 class="content__title wow fadeInUp">'. $recRow->sub_title .'</h2>
                                <p class="content__subtitle wow fadeInUp">'. preg_replace('/<\/?p>/','',$recRow->content) .'</p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
         

    } else {
        redirect_to(BASE_URL);
    }
}

$jVars['module:inner-about-detail'] = $aboutdetail;
$jVars['module:inner-about-bread'] = $innerbred;


$restyp = '';

$typRow = Article::get_by_type();
if (!empty($typRow)) {
    $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($typRow->content));
    $readmore = '';
    if (!empty($typRow->linksrc)) {
        $linkTarget = ($typRow->linktype == 1) ? ' target="_blank" ' : '';
        $linksrc = ($typRow->linktype == 1) ? $typRow->linksrc : BASE_URL . $typRow->linksrc;
        $readmore = '<a class="text-link link-direct" href="' . $linksrc . '">see more</a>';
    } else {
        $readmore = (count($content) > 1) ? '<a href="' . BASE_URL . $typRow->slug . '">Read more...</a>' : '';
    }
    $restyp .= '<h3 class="h3 header-sidebar">' . $typRow->title . '</h3>
	<div class="home-content">
		' . $content[0] . ' ' . $readmore . '
	</div>';

}

$jVars['module:article_by_type'] = $restyp;



/*
    Why Choose Us
*/
$resinnh1 = '';

if (defined('HOME_PAGE')) {

    $resinnh1 .= '';

// pr($resinnh1);
    $recInn1 = Article::find_by_id(2);
    if (!empty($recInn1)) {
            $resinnh1 .= $recInn1->content;

        
    }

}

$jVars['module:home_article'] = $resinnh1;


/*
    HomePage Facilities
*/
$resinnh1 = '';

if (defined('HOME_PAGE')) {

    $resinnh1 .= '';


    $recInn1 = Article::find_by_id(3);

    if (!empty($recInn1)) {

            $resinnh1 .= $recInn1->content;

        
    }

}

$jVars['module:home_facilities'] = $resinnh1;

?>