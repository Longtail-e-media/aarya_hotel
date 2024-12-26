<?php
/*
* Contact form
*/
$rescont = $innerbred = '';
$img='';
if (defined('CONTACT_PAGE')) {


    $siteRegulars = Config::find_by_id(1);

    $tellinked = '';
    $telno = explode("/", $siteRegulars->contact_info);
    $lastElement = array_shift($telno);
    $tellinked .= '<a href="tel:' . $lastElement . '" target="_blank">' . $lastElement . '</a>/';
    foreach ($telno as $tel) {
        
        $tellinked .= '<a href="tel:+977-' . $tel . '" target="_blank">' . $tel . '</a>';
        if(end($telno)!= $tel){
        $tellinked .= '/';
        }   
}
$imglink= $siteRegulars->contact_upload ;
if(!empty($imglink)){
    $img= IMAGE_PATH . 'preference/contact/' . $siteRegulars->contact_upload ;
}
else{
    $img='';
}
        // pr($siteRegulars);
    $rescont .= '
        <div class="rts__section section__padding pillar-icon" style="background: #f8f2e2;">
            <div class="section__shape">
                <img src="'. BASE_URL .'template/web/assets/images/pillar.png" alt="pillar">
            </div>
            <div class="container px-5">
                <div class="row g-30 align-items-center">
                    <div class="col-lg-6">
                        <div class="rts__contact">
                            <span class="h5 d-block mb-30">Love to hear from you<br/>
                                Get in touch!</span><br/>
                            <form action="enquery_mail.php" class="rts__contact__form" id="frm_contact">
                                <div class="form-input">
                                    <label for="name">Your Name*</label>
                                    <div class="pr">
                                        <input type="text" id="name" name="name" placeholder="Your Name" required>
                                        <i class="flaticon-user"></i>
                                    </div>
                                </div>
                                <div class="form-input">
                                    <label for="email">Your Email*</label>
                                    <div class="pr">
                                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                                        <i class="flaticon-envelope"></i>
                                    </div>
                                </div>

                                <div class="form-input">
                                    <label for="email">Your Address*</label>
                                    <div class="pr">
                                        <input type="text" id="address" name="address" placeholder="Your Address" required>
                                        <i class="flaticon-marker"></i>
                                    </div>
                                </div>

                                <div class="form-input">
                                    <label for="email">Your Phone No.*</label>
                                    <div class="pr">
                                        <input type="number" id="Phone" name="phone" placeholder="Your Phone" required>
                                        <i class="flaticon-phone-flip"></i>
                                    </div>
                                </div>

                                <div class="form-input">
                                    <label for="msg">Your Message*</label>
                                    <div class="pr">
                                        <textarea id="msg" name="message" placeholder="Message" required></textarea>
                                        <img src="'. BASE_URL .'template/web/assets/images/icon/message.svg" width="20" height="20" alt="">
                                    </div>  
                                </div>
                                <!--<div class="form-input">
                                    <div id="g-recaptcha-response" class="g-recaptcha" data-sitekey="6Lf1CysqAAAAAIgmN0_09HdspdNsgi6359cuvp4j"></div>
                                </div>-->
                                <button type="submit" class="theme-btn btn-style fill w-100"><span>Send Message</span></button>
                            </form>
                            <div class="mt-20 alert alert-success" id="result_msg" style="display:none;" ></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact__map">
                            <iframe src=\''. $siteRegulars->location_map .'\' width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';
}

$jVars['module:contact-us'] = $rescont;

$siteRegulars = Config::find_by_id(1);
// pr($siteRegulars);
$whats = '
    <div class="whats_app">
        <a href="https://wa.me/+'. $siteRegulars->whatsapp_a .'" target="_blank" class="whatsapp">
            <img src="'. BASE_URL .'template/web/assets/images/icon/whatsapp.png">
        </a>
    </div>
';

$jVars['module:whatsapp-float'] = $whats;