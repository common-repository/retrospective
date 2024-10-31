<?php
/*
Plugin Name: Retrospective
Plugin URI: https://wordpress.org/extend/plugins/retrospective/
Description: Retrospective displays last posts or posts from a specific category in a <em>nice-looking "retrospective" way</em> wherever you use the <tt>[retrospective]</tt> shortcode.
Version: 1.0.0
Author: Tiago Madeira
Author URI: http://blog.tiagomadeira.com/
License: GPL3
*/

/*
 *  Copyright 2012 Tiago Madeira (tmadeira@gmail.com)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 3, as 
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define('DEFAULT_COUNT', 10);
define('DEFAULT_DATE_FORMAT', 'd/m/Y');
define('DEFAULT_DELAY', 1000);
define('DEFAULT_IMAGE_BORDER_COLOR', "000000");
define('DEFAULT_IMAGE_BORDER_SIZE', 7);
define('DEFAULT_IMAGE_HEIGHT', 180);
define('DEFAULT_IMAGE_MARGIN', 5);
define('DEFAULT_IMAGE_WIDTH', 300);
define('DEFAULT_TIMELINE_WIDTH', 600);

$retrospective_count = 0;
$retrospective_styles = Array();

function retrospective_make_excerpt($excerpt, $content) {
    if ($excerpt != "") return $excerpt;
    $content = preg_replace('/<[^>]*>/s', '', $content);
    $a = str_split($content, 320);
    return $a[0] . " ...";
}

function retrospective_shortcode($atts) {
    global $retrospective_count, $retrospective_styles;
    $retrospective_count++;

    /* Define arguments */
    extract(shortcode_atts(array(
        'cat' => '',
        'width' => DEFAULT_TIMELINE_WIDTH,
        'delay' => DEFAULT_DELAY,
        'count' => DEFAULT_COUNT,
        'scale' => false,
        'image_width' => DEFAULT_IMAGE_WIDTH,
        'image_height' => DEFAULT_IMAGE_HEIGHT,
        'image_border_size' => DEFAULT_IMAGE_BORDER_SIZE,
        'image_border_color' => DEFAULT_IMAGE_BORDER_COLOR,
        'image_margin' => DEFAULT_IMAGE_MARGIN,
        'date_format' => DEFAULT_DATE_FORMAT
    ), $atts));

    $query = ($cat != "" ? "cat=$cat&" : "") . "posts_per_page=$count";
    $hash = hash("md5", serialize($argv)."-".$retrospective_count);

    /* Fetch posts, reverse them and define their positions in the timeline */
    $A = Array();
    $n = 0;
    $query = new WP_Query($query);
    $posts = $query->get_posts();
    foreach ($posts as $p) {
        $id = $p->ID;
        $timeU = get_the_time("U", $id);
        $timeD = get_the_time($date_format, $id);
        $permalink = get_permalink($id);
        $title = get_the_title($id);
        $excerpt = retrospective_make_excerpt($p->post_excerpt, $p->post_content);
        $thumb = get_the_post_thumbnail($id, array($image_width, $image_height), Array("title" => $title));
        $A[$n++] = Array($timeU, $timeD, $permalink, $title, $excerpt, $thumb);
    }
    $A = array_reverse($A);
    if ($n > 1) {
        if ($scale) {
            $start = $A[0][0];
            $end = $A[$n-1][0];
            $time_width = $end - $start;
            $div = $time_width / $width;
            for ($i = 0; $i < $n; $i++) {
                $A[$i][0] = floor(($A[$i][0] - $start) / $div);
            }
        } else {
            for ($i = 0; $i < $n; $i++) {
                $A[$i][0] = floor($i * $width / ($n - 1));
            }
        }
    } else {
        $A[0][0] = floor(TIMELINE_WIDTH / 2);
    }

    /* CSS */
    $css = plugins_url("css.php?hash=$hash&width=$width&border_size=$image_border_size&image_margin=$image_margin&border_color=$image_border_color", __FILE__);
    $retrospective_styles[] = $css;

    /* JavaScript */
    $leftA = floor($width / 2);
    $leftB = $image_width + 2 * $image_border_size + $image_margin + 2;
    $leftC = floor($image_width / 2);
    wp_enqueue_script("retro-$hash", plugins_url("js.php?hash=$hash&delay=$delay&leftA=$leftA&leftB=$leftB&leftC=$leftC", __FILE__), array('jquery'), 1.0, true);

    /* HTML */
    $time = "";
    $photos = "";
    $posts = "";
    for ($i = 0; $i < $n; $i++) {
        $left = $A[$i][0];
        $date = $A[$i][1];
        $permalink = $A[$i][2];
        $title = $A[$i][3];
        $excerpt = $A[$i][4];
        $photo = $A[$i][5];
        $time.= "\t\t<li rel=\"$i\"><a href=\"$permalink\" style=\"left:{$left}px;\"><span>$date</span></a></li>\n";
        $photos.= "\t\t\t<li rel=\"$i\"><a href=\"$permalink\" title=\"$title\">$photo</a></li>\n";
        $posts.= "\t\t<li rel=\"$i\"><a href=\"$permalink\" title=\"$title\"><h2>$title <span>($date)</span></h2> <p>$excerpt</p></a></li>\n";
    }

    return "
<div id=\"retro-$hash\" class=\"retrospective\">
    <!-- TIMELINE -->
    <ul class=\"time\">
$time
    </ul>
    <!-- PHOTOS -->
    <div class=\"photos\">
        <ul>
$photos
        </ul>
    </div>
    <!-- POSTS -->
    <ul class=\"posts\">
$posts
    </ul>
</div>
";
}

function retrospective_print_styles() {
    global $retrospective_styles;
    if (count($retrospective_styles)) {
        echo "<style type=\"text/css\">\n";
        foreach ($retrospective_styles as $style) {
            echo "\t@import url(\"$style\");\n";
        }
        echo "</style>\n";
    }
}

add_shortcode('retrospective', 'retrospective_shortcode');
add_action('wp_footer', 'retrospective_print_styles');
?>
