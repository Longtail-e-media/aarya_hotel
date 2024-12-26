<?php
$resinndetail = $imageList = $innerbred = $t = '';
$homearticle = mservices::find_by_id(22);
if (!empty($homearticle)) {
    if ($homearticle->image != "a:0:{}") {
        $imageList = unserialize($homearticle->image);
        $imgno = array_rand($imageList);
        $file_path = SITE_ROOT . 'images/mservices/' . $imageList[$imgno];
        if (file_exists($file_path)) {
            $imglink = IMAGE_PATH . 'mservices/' . $imageList[$imgno];
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

if (defined('HOME_PAGE') ) {
    // $slug = addslashes($_REQUEST['slug']);
    // $recRow = mservices::find_by_slug($slug);
    $recInn = mservices::homepageArticle();
    
    $servicecont = '';
    foreach($recInn as $mServiceRow){
        if($mServiceRow->homepage == 1){
            $unserializedImg = unserialize($mServiceRow->image);
            $file_path = SITE_ROOT .'images/mservices/'. $unserializedImg[0];
            if(file_exists($file_path)){
                $mServImgLink = IMAGE_PATH . 'mservices/' . $unserializedImg[0];
            }else{
                $mServImgLink = BASE_URL . 'template/web/assets/images/offer/5.webp';
            }

            $servicecont .= '
                <div class="swiper-slide room__wrapper">
                    <div class="blog__item is__full is__event">
                        <div class="blog__item__thumb">
                            <a>
                                <img src="'. $mServImgLink .'" alt="'. $mServiceRow->title .'">
                            </a>
                        </div>
                        <div class="blog__item__meta">
                            <a class="blog__item__meta__title">
                                <h5>'. $mServiceRow->title .'</h5>
                            </a>
                            <div class="blog__item__meta__list">
                                '. $mServiceRow->content .'
                            </div>
                        </div>
                    </div>
                </div>
            '; 
        }
    }
    $mainMServiceCont = '
        <div class="rts__section blog is__home__three section__padding" style="background: #f8f2e2;">
            <div class="section__shape">
                <img src="'. BASE_URL .'template/web/assets/images/pillar.png" alt="pillar">
            </div>
            <div class="container-fluid px-5">
                <div class="row align-items-center g-30">
                    <div class="col-lg-3">
                        <div class="d-flex position-relative">
                            <div class="section__content__left">
                                <span class="h6 mx-auto">Crafted Deals</span>
                                <h4 class="content__title">Curated experiences for every need</h4>
                                <p>We pride ourselves on offering genuine Nepalese hospitality, welcoming you with warm smiles and attentive service. Our luxurious offers facilities are designed to rejuvenate your senses, providing the perfect escape after a day of exploring the city.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="main__room__slider overflow-hidden wow fadeInUp" data-wow-delay=".5s">
                            <div class="swiper-wrapper ">
                                '. $servicecont .'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';
    
    $jVars['module:home-mainservice'] = $mainMServiceCont;
}
    



/**
 *      Inner page detail
 */




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