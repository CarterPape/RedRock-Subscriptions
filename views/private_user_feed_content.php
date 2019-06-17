<?php
// This is used strictly by the private_user_feed.php

// We want to make sure nobody influences our results.
remove_all_actions('pre_get_posts');
remove_all_filters('the_excerpt');
remove_all_filters('the_excerpt_rss');

// For the content parse, we want to remove only the memberful part.
remove_filter('the_content', 'memberful_wp_protect_content', -10);

$post_types = array("post");

query_posts(array(
    'post_type'       => apply_filters('memberful_private_rss_post_types', $post_types),
    'posts_per_page'  => get_option('posts_per_rss', 10)
));

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

do_action('rss_tag_pre', 'rss2');
?>
<rss
    version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
    <?php do_action('rss2_ns'); ?>
>
    <channel>
        <title><?php bloginfo_rss('name'); ?> Member Feed</title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss("description") ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <language><?php bloginfo_rss('language'); ?></language>
        <sy:updatePeriod>
<?php
            $duration = 'hourly';
            echo apply_filters('rss_update_period', $duration);
?>
        </sy:updatePeriod>
        <sy:updateFrequency>
<?php
            $frequency = '4';
            echo apply_filters('rss_update_frequency', $frequency);
?>
        </sy:updateFrequency>
<?php
        do_action('rss2_head');

        while (have_posts()) {
            the_post();

            global $more;
            $more = 1;
?>
            <item>
                <title><?php the_title_rss() ?></title>
                <link><?php the_permalink_rss() ?></link>
                <comments><?php comments_link_feed(); ?></comments>
                <pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
                <dc:creator><![CDATA[<?php the_author() ?>]]></dc:creator>
                <?php the_category_rss('rss2') ?>

                <guid isPermaLink="false"><?php the_guid(); ?></guid>
<?php
                if (get_option('rss_use_excerpt')) {
?>
                    <description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
<?php
                }
                else {
?>
                    <description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
<?php
                    $content = get_the_content_feed('rss2');
                    if (strlen($content) > 0) {
?>
                        <content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
<?php
                    }
                    else {
?>
                        <content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
<?php
                    }
                }
?>
                <wfw:commentRss><?php echo esc_url(get_post_comments_feed_link(null, 'rss2')); ?></wfw:commentRss>
                <slash:comments><?php echo get_comments_number(); ?></slash:comments>
                <?php rss_enclosure(); ?>
<?php
                do_action('rss2_item');
?>
            </item>
<?php
        }
?>
    </channel>
</rss>
