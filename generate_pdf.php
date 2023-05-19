<?php
require_once('tcpdf/tcpdf.php');
$root_directory = str_replace('path/to/theme', '', dirname(__DIR__));
require_once $root_directory . '\wp-load.php';

// http://localhost/PHP-Project/

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('TechyTrion');
$pdf->SetAuthor('TechyTrion');
$pdf->SetTitle('TechyTrion');
$pdf->SetSubject('TechyTrion');
$pdf->SetKeywords('TCPDF, TechyTrion, print, page, body, content');

// Add a page
$pdf->AddPage();

$post_id = $_GET['post_ID'];
$logoUrl = $_GET['logo'];

$main_title = get_the_title($post_id);
$header_cus_pdf = '<div class="Main-header-pdf">
<div class="Main-header-pdf-img"><img src="'.$logoUrl.'"></img></div>
<div class="Main-header-pdf-title">'.$main_title.'</div>
</div>';

$post_type = 'custom_post_type_name';
$image_field_name = 'uploaded_images';
$description_field_name = 'description';

$post = get_post($post_id);
if ($post && $post->post_type === $post_type) {
    $uploaded_images = get_field($image_field_name, $post_id);
    $description = get_field($description_field_name, $post_id);
    // $post_title = get_the_title($post_id);
    // $portfolio_title = '<div class="elementor-widget-container pdf-content-heading"><h2 class="elementor-heading-title elementor-size-default">'.$post_title.'</h2></div>';
    $portfolio_images = '';
    $portfolio_images2 = '';
    if ($uploaded_images) {
        $counter = 1;
        foreach ($uploaded_images as $image) {
            if( $counter < 4){
                $portfolio_images .= '<div class="single-img-port imgone"><img src="' . $image['url'] . '" alt="' . $image['alt'] . '"></div>';
            }else{
                $portfolio_images2 .= '<div class="single-img-port imgtwo"><img src="' . $image['url'] . '" alt="' . $image['alt'] . '"></div>';
            }
            $counter++;
        }
    }
    $portfolio_description = '<div class="elementor-widget-container right-inner-content-pdf">';
    if ($description) {
        $portfolio_description .= $description;
    }
    $portfolio_description .= '</div>';
}

$category_title = '<div class="elementor-widget-container pdf-categpry-heading"><h3 class="elementor-heading-title elementor-size-default">Categories</h3></div>';

$project_attributes = 'project_attributes';

$project_attributes_terms = get_terms(array( 'taxonomy' => $project_attributes, 'hide_empty' => false,));

if (!empty($project_attributes_terms) && !is_wp_error($project_attributes_terms)) {
    $state = '<h4>State</h4><div class="question-answer">';
    $counter = 1;
    foreach ($project_attributes_terms as $project_attributes_term) {
        $project_attributes_term_count = $project_attributes_term->count;
        $state_value = $project_attributes_term->name . ' (' . $project_attributes_term_count . ')';
        $state .= '<div><input type="radio" value="none" id="radio_'.$counter.'"  name="State_'.$counter.'"/><label class="sf-label-checkbox" for="radio_'.$counter.'" class="radio"><span>'.$state_value.'</span></label></div>';
    $counter++;
    }
    $state .= '</div>';
}

$property_role = 'property_role';

$property_role_terms = get_terms(array( 'taxonomy' => $property_role, 'hide_empty' => false,));

if (!empty($property_role_terms) && !is_wp_error($property_role_terms)) {
    $role = '<h4>Role</h4><div class="question-answer">';
    $Role_counter = 1;
    foreach ($property_role_terms as $property_role_term) {
        $property_role_term_count = $property_role_term->count;
        $role_value = $property_role_term->name . ' (' . $property_role_term_count . ')';
        $role .= '<div><input type="checkbox" value="none" id="Role_'.$Role_counter.'" name="Role_'.$Role_counter.'"/><label class="sf-label-checkbox" for="Role_'.$Role_counter.'" class="checkbox"><span>'.$role_value.'</span></label> </div>';
    $Role_counter++;
    }
    $role .= '</div>';
}


$project_type = 'project_type';

$project_type_terms = get_terms(array( 'taxonomy' => $project_type, 'hide_empty' => false,));

if (!empty($project_type_terms) && !is_wp_error($project_type_terms)) {
    $type = '<h4>Type</h4><div class="question-answer">';
    $Type_counter = 1;
    foreach ($project_type_terms as $project_type_term) {
        $project_type_term_count = $project_type_term->count;
        $type_value = $project_type_term->name . ' (' . $project_type_term_count . ')';
        $type .= '<div><input type="checkbox" value="none" id="type_'.$Type_counter.'" name="type_'.$Type_counter.'"/><label class="sf-label-checkbox" for="type_'.$Type_counter.'" class="checkbox"><span>'.$type_value.'</span></label> </div>';
    $Type_counter++;
    }
    $type .= '</div>';
}

$portfolio_category = 'portfolio_category';

$portfolio_category_terms = get_terms(array( 'taxonomy' => $portfolio_category, 'hide_empty' => false,));

if (!empty($portfolio_category_terms) && !is_wp_error($portfolio_category_terms)) {
    $cats = '<h4>Category</h4><div class="question-answer">';
    $Cats_counter = 1;
    foreach ($portfolio_category_terms as $portfolio_category_term) {
        $portfolio_category_term_count = $portfolio_category_term->count;
        $cats_value = $portfolio_category_term->name . ' (' . $portfolio_category_term_count . ')';
        $cats .= '<div><input type="checkbox" value="none" id="cats_'.$Cats_counter.'" name="cats_'.$Cats_counter.'"/><label class="sf-label-checkbox" for="cats_'.$Cats_counter.'" class="checkbox"><span>'.$cats_value.'</span></label> </div>';
    $Cats_counter++;
    }
    $cats .= '</div>';
}

$pdf_style = '<style>.Right-side-pdf-content li {padding: 6px 0;}.Left-side-pdf h3{margin: 15px 0 0px 0;}.Left-side-pdf h4 {margin: 10px 0px 3px 1px;}.question-answer input {margin: 5px -20px 0px 20px;}.question-answer {padding-right: 7rem; width: 100%;}label.radio, label.checkbox {position: relative;display: inline-block;margin: 5px 20px 15px 0;cursor: pointer;}.question span {margin-left: 30px;}label.radio:before, label.checkbox:before{content: ""; position: absolute;left: 0;width: 17px;height: 17px;border-radius: 50%;border: 2px solid #ccc;}label.checkbox:before{ border-radius: 5px}input[type=radio]:checked + label:before, label.radio:hover:before,input[type=checkbox]:checked + label:before, label.chekbox:hover:before {border: 2px solid #3263cd;}label.radio:after, label.checkbox:after {content: "";position: absolute;top: 6px;left: 5px;width: 8px;height: 4px;border: 3px solid #3263cd;border-top: none;border-right: none;transform: rotate(-45deg);opacity: 0;}input[type=radio]:checked + label:after, input[type=checkbox]:checked + label:after {opacity: 1;}.PDF-outer-page{display:flex;}.single-img-port{padding: 0px 5px 0px 10px;}.single-img-port img {width: 250px;height: 180px;}.Right-side-pdf{padding: 1rem 1rem 0px 0rem;}.Right-side-pdf-images{display:flex;}.Main-header-pdf-img img{width: 100px;}.Main-header-pdf {display: flex;justify-content: space-between;align-items: center;}.Main-header-pdf-title {font-size: 24px;font-weight: 700;text-transform: capitalize;padding: 10px 20px 0px 20px;}.single-img-port.imgtwo img {width: 100%;height: 180px;}.single-img-port.imgtwo {padding-top: 15px;}</style>';

$bodyContent = $header_cus_pdf.'
<div class="PDF-outer-page">
    <div class="question Left-side-pdf">
    '.$category_title.'
    '.$state.'
    '.$role.'
    '.$type.'
    '.$cats.'
  </div>
  <div class="Right-side-pdf">
    <div class="Right-side-pdf-title"></div>
    <div class="Right-side-pdf-images">'.$portfolio_images.'</div>
    <div class="Right-side-pdf-images">'.$portfolio_images2.'</div>
    <div class="Right-side-pdf-content">'.$portfolio_description.'</div>
  </div>
</div>'.$pdf_style;

/* print_r($bodyContent); */

$pdf->writeHTML($bodyContent, true, false, true, false, '');

$pdf->Output('page_content.pdf', 'I');

exit;
?>
