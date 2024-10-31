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
$width = $_GET["width"];
$border_size = $_GET["border_size"];
$border_color = $_GET["border_color"];
$image_margin = $_GET["image_margin"];
Header("Content-type: text/css; charset=utf-8");
?>
#retro-<?php echo $hash; ?>, #retro-<?php echo $hash; ?> * {
    margin:0 !important;
    padding:0 !important;
}
#retro-<?php echo $hash; ?> {
    clear:both;
    padding:20px 0 !important;
    width:<?php echo $width; ?>px;
}
#retro-<?php echo $hash; ?> .time {
    position:relative;
    border-bottom:solid 1px #555;
    margin:10px 0 0 0 !important;
    list-style:none;
}
#retro-<?php echo $hash; ?> .time a {
    position:absolute;
    display:block;
    background:#555;
    top:-7px;
    width:15px;
    height:15px;
    border-radius:7px;
    text-decoration:none;
}
#retro-<?php echo $hash; ?> .time a:hover, #retro-<?php echo $hash; ?> .time a:hover * {
    text-decoration:none;
}
#retro-<?php echo $hash; ?> .time a span {
    display:none;
    background:#000;
    color:#fff;
    font:11px sans-serif;
    font-weight:bold;
    padding:3px 0 !important;
    position:absolute;
    bottom:18px;
    text-align:center;
    width:90px;
    z-index:9999;
    left:-37px;
    border-radius:2px;
}
#retro-<?php echo $hash; ?> .time .selected a {
    background:#000;
}
#retro-<?php echo $hash; ?> .time .selected a span {
    background:#000;
    display:block;
}
#retro-<?php echo $hash; ?> .photos {
    overflow:hidden;
    margin:40px 0 20px 0 !important;
}
#retro-<?php echo $hash; ?> .photos * {
    max-width:50000px !important;
}
#retro-<?php echo $hash; ?> .photos ul {
    list-style:none;
    padding-left:<?php echo $width; ?>px !important;
    padding-right:<?php echo $width; ?>px !important;
    width:50000px !important;
}
#retro-<?php echo $hash; ?> .photos a {
    float:left;
    display:block;
    margin-right:<?php echo $image_margin; ?>px !important;
}
#retro-<?php echo $hash; ?> .photos img {
    border:solid <?php echo $border_size; ?>px #000;
    padding:1px !important;
    background:#000;
    opacity:0.4;
}
#retro-<?php echo $hash; ?> .photos .selected img {
    border-color:#<?php echo $border_color; ?>;
    background:#fff;
    opacity:1;
}
#retro-<?php echo $hash; ?> .posts li {
    list-style:none;
    display:none;
}
