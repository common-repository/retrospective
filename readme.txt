=== Retrospective ===
Contributors: tmadeira
Donate link: http://blog.tiagomadeira.com/
Tags: archive, category, javascript, jquery, shortcode, style, template
Requires at least: 3.3.1
Tested up to: 3.3.1
Stable tag: trunk

Retrospective plugin displays last posts or posts from a specific category in
a nice-looking "retrospective" way using a shortcode.

== Description ==

The website of the brazilian newspaper O Estado de São Paulo has a nice way to
display news in a retrospective-style (check [this
screenshot](http://blog.tiagomadeira.com/wp-content/uploads/2012/01/estadao.jpg)
or [this link](http://www.estadao.com.br/especiais/choque-nas-ruas,158638.htm)
— Flash required).

Wouldn’t it be nice if we could display WordPress posts in our pages and
categories in the same way just by using a shortcode? The possibilities are
many. That’s why I wrote the Retrospective plugin for WordPress.

It has at least two advantages over the version you just saw:

* Does not require Flash (its implementation uses only CSS and jQuery)
* Has a option to respect the (time-)scale of the posts.

See *Installation* for more info on how to use it.

== Installation ==

Upload the Retrospective plugin to your blog, activate it, then it's
installed!

Its use is very simple. Wherever you add the shortcode *[retrospective]* the
plugin will draw that cool retrospective. The shortcode supports several
attributes:

* *count* — limit the number of posts to be displayed (default = 10; use -1 to
display all)
* *cat* — display posts with category IDs comma-separated (default =
display all posts)
* *width* — the width of the timeline in pixels (default = 600)
* *delay* — the time of the focus change animation in milisseconds (default =
1000)
* *scale* — if set, respect the time scale in the distances between the points
in the timeline (default = false)
* *image_width*, *image_height* — the dimensions of the thumbnail images in pixels
(default = 300×180)
* *image_border_size* — the size of the image’s border in pixels (default = 7)
* *image_border_color* — the color of the image’s border in hexa RGB (default =
000000)
* *image_margin* — the space between the images (default = 5)
* *date_format* — the date format in PHP format (default = d/m/Y)

== Frequently Asked Questions ==

= How to style retrospectives? =

The generated HTML is very easy to style (but just be careful with margins and
paddings, they’re set with !important attribute — I did it to try not to break
with any theme). Here is a sample:

    <div id="retro-uniquehash" class="retrospective">
        <!-- TIMELINE -->
        <ul class="time">
            <li rel="0"><a href="permalink" style="left:0px;"><span>date</span></a></li>
            <li rel="1"><a href="permalink" style="left:300px;"><span>date</span></a></li>
            <li rel="2"><a href="permalink" style="left:600px;"><span>date</span></a></li>
        </ul>
     
        <!-- PHOTOS -->
        <div class="photos">
            <ul>
                <li rel="0"><a href="permalink" title="title">
                    <img src="file" class="wp-post-image" /></a></li>
                <li rel="1"><a href="permalink" title="title">
                    <img src="file" class="wp-post-image" /></a></li>
                <li rel="2"><a href="permalink" title="title">
                    <img src="file" class="wp-post-image" /></a></li>
            </ul>
        </div>
     
        <!-- POSTS -->
        <ul class="posts">
            <li rel="0"><a href="permalink" title="title"><h2>Title <span>(date)</span></h2>
                <p>Excerpt</p></a></li>
            <li rel="1"><a href="permalink" title="title"><h2>Title <span>(date)</span></h2>
                <p>Excerpt</p></a></li>
            <li rel="2"><a href="permalink" title="title"><h2>Title <span>(date)</span></h2>
                <p>Excerpt</p></a></li>
        </ul>
    </div>

= How to style a specific retrospective? =

The generated hash takes in consideration all the attributes sent to the
shortcode and also how many retrospectives appeared before in the parsing of
the actual page. I made it that way to allow users to set up two exactly equal
retrospectives in the same page. Because of that, I don’t recommend setting
styles for *#retro-uniquehash*. I think a reasonable solution for this issue is
to make something like

    <div id="something_that_makes_sense">[retrospective]</div>

when inserting the shortcode and then styling *#something_that_makes_sense
.retrospective*.

== Screenshots ==

1. Retrospective plugin in http://juntos.org.br/juntos/internet/
2. Retrospective plugin in a fresh WordPress install using a pure TwentyEleven
theme

