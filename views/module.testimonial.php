<?php

/*
* Testimonial List Home page
*/
$restst = $ratingStars = '';
$tstRec = Testimonial::get_alltestimonial(9);
// pr($tstRec,1);
$totalTestimonial = 0;
$totalRating = 0;
if (!empty($tstRec)) {
    $totalTestimonial = sizeof($tstRec);
    foreach ($tstRec as $tstRow) {
        $totalRating += intval($tstRow->rating);
    }

    $avgRating = round(($totalRating / $totalTestimonial), 1);
}
for ($i = 0; $i < ceil($avgRating); $i++) {
    $ratingStars .= '
        <i class="fa fa-star checked"></i>
    ';
}
for ($i = 0; $i < (5 - ceil($avgRating)); $i++) {
    $ratingStars .= '
        <i class="fa fa-star"></i>
    ';
}

$result_last = '
    <div class="position-relative  wow fadeInUp animated text-center" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
        <h6 class="mb-1">' . $avgRating . ' out of 5</h6>
        <div class="de-rating-ext fs-18" style="background-size: cover; background-repeat: no-repeat;">
            <span class="d-stars">
                ' . $ratingStars . '
            </span>
        </div>
        <span class="d-block fs-14 mb-0">Based on ' . $totalTestimonial . '+ reviews</span>
    </div>
';
// pr($result_last,1);
$jVars['module:testimonialList123'] = $result_last;


/*
* Testimonial Header Title
*/
$tstHtitle = '';

if (defined('HOME_PAGE')) {
    $tstHtitle .= '<section class="promo_full">
    <div class="promo_full_wp">
        <div>
            <h3>What Guest say</h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="carousel_testimonials">';
    $tstRec = Testimonial::get_alltestimonial();
    if (!empty($tstRec)) {
        foreach ($tstRec as $tstRow) {
            $tstHtitle .= '<div>
                                <div class="box_overlay">
                                    <div class="pic">
                                        <figure><img src="' . IMAGE_PATH . 'testimonial/' . $tstRow->image . '" alt="' . $tstRow->name . '" class="img-circle"></figure>
                                        <h4>' . $tstRow->name . '</h4>
                                    </div>
                                    <div class="comment">
                                       ' . strip_tags($tstRow->content) . '
                                    </div>
                                </div><!-- End box_overlay -->
                            </div>';
        }
        $tstHtitle .= '</div><!-- End carousel_testimonials -->
                    </div><!-- End col-md-8 -->
                </div><!-- End row -->
            </div><!-- End container -->
        </div><!-- End promo_full_wp -->
    </div><!-- End promo_full -->
    </section><!-- End section -->';
    }
}
$jVars['module:testimonial-title'] = $tstHtitle;


/*
* Testimonial Rand
*/
$tstHead = '';

$tstRand = Testimonial::get_by_rand();
if (!empty($tstRand)) {
    $tstHead .= '<!-- Quote | START -->
	<div class="section quote fade">
		<div class="center">
	    
	        <div class="col-1">
	        	<div class="thumb"><img src="' . IMAGE_PATH . 'testimonial/' . $tstRand->image . '" alt="' . $tstRand->name . '"></div>
	            <h5><em>' . strip_tags($tstRand->content) . '</em></h5>
	            <p><span><strong>' . $tstRand->name . ', ' . $tstRand->country . '</strong> (Via : ' . $tstRand->via_type . ')</span></p>
	        </div>
	        
	    </div>
	</div>
	<!-- Quote | END -->';
}

$jVars['module:testimonial-rand'] = $tstHead;


/*
* Testimonial List
*/
$restst = '';
$tstRec = Testimonial::get_alltestimonial();
if (!empty($tstRec)) {
    foreach ($tstRec as $tstRow) {
        $img = BASE_URL . 'template/web/assets/images/author/3.webp';
        $file_path = SITE_ROOT . 'images/testimonial/' . $tstRow->image;
        if(file_exists($file_path)){
            $img = IMAGE_PATH . 'testimonial/' . $tstRow->image;
        }

        $slink = !empty($tstRow->linksrc) ? $tstRow->linksrc : 'javascript:void(0);';
        $target = !empty($tstRow->linksrc) ? 'target="_blank"' : '';

        $restst .= '
            <div class="comment__item mb-30">
                <div class="comment__item__author">
                    <div class="author__img">
                        <img class="rounded-1" src="' . $img . '" width="60" height="60" alt="' . $tstRow->name . '">
                    </div>
                    <div class="author__info">
                        <h6 class="font-20 mb-0">' . $tstRow->name . '</h6>
                        <span>' . $tstRow->via_type . '</span>
                    </div>
                </div>
                <div class="comment__text">
                    <p>' . strip_tags($tstRow->content) . '</p>
                </div>
            </div>
        ';
    }
}

$jVars['module:testimonial:list'] = $restst;
?>