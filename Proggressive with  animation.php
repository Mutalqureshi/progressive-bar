Proggressive with  animation   

Postype create and fetch code=>
###########################
function my_post(){
    register_post_type( 'skills_hobbies',
        array(
            'labels' => array(
                'name' => __( 'skills_hobbies' ),
                'singular_name' => __( 'Skills & Hobbies' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')

            )
        );
    }
add_action( 'init', 'my_post' );

function custom_taxonomy() {
    $labels = array(
    'name'              => _x( 'skills_hobbies_Category', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'skills_hobbies_Category', 'taxonomy singular name', 'textdomain' ),
    'search_items'      => __( 'Search skills_hobbies', 'textdomain' ),
    'all_items'         => __( 'All skills_hobbies', 'textdomain' ),
    'parent_item'       => __( 'Parent Client', 'textdomain' ),


    'parent_item_colon' => __( 'Parent skills_hobbies:', 'textdomain' ),
    'edit_item'         => __( 'Edit skills_hobbies', 'textdomain' ),
    'update_item'       => __( 'Update skills_hobbies', 'textdomain' ),
    'add_new_item'      => __( 'Add New skills_hobbies Category', 'textdomain' ),
    'new_item_name'     => __( 'New skills_hobbies Name', 'textdomain' ),
    'menu_name'         => __( 'skills_hobbies Category', 'textdomain' ),
);

$args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
);

register_taxonomy( 'skills_hobbies_tax', array( 'skills_hobbies' ), $args );

}
add_action('init','custom_taxonomy');
 
// =------- SKills and hobbies


function skills(){
$html="";
$html .='<section class="skill">'; 
        $args = array(
            'post_type' => 'skills_hobbies',
            'numberposts' => -1,
            'order'    => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'skills_hobbies_tax',//taxonomy ka name ayga category ka nhi
                    'field'    => 'skills',//category slug call hoga
                    'terms'    => array( '6' ), 
                ),
         )
    );
        $loop = new WP_Query($args);
        while($loop->have_posts()){ $loop->the_post();
            $html .='<div class="skill_section pdlf col-10">';

            // $html .=  "<div class='ex_year'><div class='year_text'><i class='far fa-calendar'> </i>" . get_field('education_year') ."</div></div>";

                $html .=  "<h4>" . get_the_title() ."</h4>";
                $html .=  "<p>" . get_the_content() ."<p>";
               
                $html .= '<div class="progress-bar" data-percentage="' . get_field('progress').'">';
                    $html .= '<div class="red bar"><span></span></div>';
                    $html .= '<div class="label"></div>';
                $html .= '</div>';

               


            $html .='</div>'; 
        }                  
$html .='</section>';
    return $html;
}
add_shortcode("skills","skills");


css=>
###########################################


.skill_section h4{
    font-size: 20px;
    margin-top: 33px;
    color: #ff7200;
}

.skill_section p{
    font-family: oswald !important;
    margin-bottom: 18px;
    font-size: 16px;
    color: #333333;
}

/* Main Progress Bar Container */
.progress-bar {
    position: relative;
    display: block;
    width: 100%;
    height: 10px;
    border-radius: 50px;
    background: #333333;
}

/* Set Bar Colors */
 .bar.yellow {
    background: #FCB31C;
}
.bar.red {
    background: #ff7200;
}

/* Set Bar Properties */
.bar {
    position: absolute;
    display: block;
    height: 100%;
    background: #ff7200;
    border-radius: 4px;
    /* jQuery uses the .progress-bar data-percentage attribute to modify the .bar width property */
    width: 0%;
}

/* Set Label Properties*/
.label {
    position: absolute;
    display: block;
    font-size: 16px;
    text-align: center;
    top: -56px;
    color: #fff;
    white-space: nowrap;
    width: 46px;
    height: 46px;
    line-height: 42px !important;
    border-radius: 40px;
    font-family: oswald !important;
    /*padding-left: 8px;*/
    background: #ff7200;
    border: 0 !important;
    opacity: 0;
    margin-left: -23px;
    /* jQuery animates the opacity property to fade in the label*/
    /* 
    left:/right: properties are set by jQuery.
    They depend on data-percentage attributes of each .progress-bar <div>
    */
}
.label {
}

/* 
Set Arrow Properties
(arrows are attached to <span> tag within .bar <div>) 
*/
.bar span:after {
    transition: all .5s linear;
    position: absolute;
    display: block;
    content: "";
    width: 20px;
    height: 10px;
    clip-path: polygon(50% 0%, 92% 0, 50% 100%, 9% 0);
    background:#ff7200;
    top: -12px;
    right: -10px;
}
.pdlf{
    padding-left: 0;
}
.vc_row-fluid.over_hide{
    overflow-x: hidden;
}











js=>
###########################

// jQuery(window).scroll(function () {

//   if(jQuery(window).scrollTop() > 2000) {

jQuery(function() {
        jQuery('.progress-bar').scrolling(); 
        
        jQuery('.progress-bar').on('scrollin', function(){


    // alert('ok');
if(!jQuery(".label-text").is(":visible")){

    jQuery('.progress-bar').each(function () {
        var t = jQuery(this);
        var barPercentage = t.data('percentage');        // add a div for the label text
        t.children('.label').append('<div class="label-text"></div>');        // add some "gimme" percentage when data-percentage is <2
        if (parseInt((t.data('percentage')), 10) < 2) barPercentage = 2;        // set up the left/right label flipping    
        t.find('.label-text').text(t.attr('data-percentage') + '%');
        t.children('.bar').animate({
            width: barPercentage + '%'
        }, 1000);
        t.children('.label').animate({
            opacity: 1,
            left: barPercentage + '%'
        }, 1000);           
             });

}
   

        });
        jQuery('.progress-bar').on('scrollout', function(){
            // alert('ok')
          // jQuery(this).animate({opacity: 0}, 200);
        });
    });


//           }
// });
