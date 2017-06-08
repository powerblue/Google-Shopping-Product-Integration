<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
    xmlns:g="http://base.google.com/ns/1.0"
    <?php do_action('rss2_ns'); ?>
>

<channel>
    <title><![CDATA[<?php wp_title_rss(); ?>]]></title>
    <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
    <link><?php bloginfo_rss('url') ?></link>
    <description><?php bloginfo_rss( 'description' ) ?></description>
    <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
    <language><?php bloginfo_rss( 'language' ); ?></language>
    <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
    <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
    <?php do_action('rss2_head'); ?>
    <?php
    $args = array( 'post_type' => 'product', 'posts_per_page' => 20000 );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    ?>
    <item>
        <title><![CDATA[<?php the_title_rss() ?>]]></title>
        <link><?php the_permalink_rss() ?></link>
        <g:image_link><?php echo wp_get_attachment_url( get_post_thumbnail_id() ) ?></g:image_link>
        <g:price><?php echo ( $product->price . ' ' . get_option('woocommerce_currency') ); ?></g:price>
        <g:shipping_weight><?php echo $product->weight ?></g:shipping_weight>
        <g:condition><?php echo get_post_meta( get_the_ID(), '_cpf_condition', true ); ?></g:condition>
        <g:id><?php echo $id; ?></g:id>
        <g:availability><?php echo($product->is_in_stock() ? 'in stock' : 'out of stock'); ?></g:availability>
        <g:google_product_category><?php echo htmlspecialchars ( get_post_meta( get_the_ID(), '_cpf_category', true ) ); ?></g:google_product_category>
        <g:gtin><?php echo get_post_meta( get_the_ID(), '_cpf_upc', true ); ?></g:gtin>
        <g:brand><![CDATA[<?php echo get_post_meta( get_the_ID(), '_cpf_brand', true ); ?>]]></g:brand>
<?php if ( get_the_excerpt(  ) ) : ?>
        <g:description><![CDATA[<?php the_excerpt_rss() ?>]]></g:description>
<?php else : ?>
        <g:description><![CDATA[<?php the_title_rss() ?>]]></g:description>
<?php endif; ?>

<?php rss_enclosure(); ?>
    <?php do_action('rss2_item'); ?>
    </item>
    <?php endwhile; ?>
</channel>
</rss>