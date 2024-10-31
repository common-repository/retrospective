<?php
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

$hash = $_GET["hash"];
$leftA = intval($_GET["leftA"]);
$leftB = intval($_GET["leftB"]);
$leftC = intval($_GET["leftC"]);
$delay = $_GET["delay"];
Header("Content-type: text/javascript; charset=utf-8");
?>
var $jQuery = jQuery.noConflict();

function set_focus_<?php echo $hash; ?>(n) {
    var retro = $jQuery("#retro-<?php echo $hash; ?>");

    retro.find(".time li").removeClass("selected");
    retro.find(".time li[rel='"+n+"']").addClass("selected");

    retro.find(".photos li").removeClass("selected");
    retro.find(".photos li[rel='"+n+"']").addClass("selected");
    var left = <?php echo $leftA; ?> + parseInt(n) * <?php echo $leftB; ?> + <?php echo $leftC; ?>;
    retro.find(".photos").stop();
    retro.find(".photos").animate({ scrollLeft: left }, <?php echo $delay; ?>);

    retro.find(".posts li").hide();
    retro.find(".posts li[rel='"+n+"']").show();
}

$jQuery(document).ready(function() {
    $jQuery("#retro-<?php echo $hash; ?> .time a").hover(function() {
        if (!$jQuery(this).parent().hasClass("selected")) set_focus_<?php echo $hash; ?>($jQuery(this).parent().attr("rel"));
    });
    $jQuery("#retro-<?php echo $hash; ?> .photos a").hover(function() {
        if (!$jQuery(this).parent().hasClass("selected")) set_focus_<?php echo $hash; ?>($jQuery(this).parent().attr("rel"));
    });
    set_focus_<?php echo $hash; ?>(0);
});
