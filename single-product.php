<?php
get_header();
?>

<main class="singleProduct flex">
    <?php
    global $product;
    $productObj = new WC_Product(get_page_by_path( $product, OBJECT, 'product' )->ID);
    ?>
    <figure class="singleProduct__imgWrapper">
        <img class="singleProduct__img" src="<?php echo wp_get_attachment_url( $productObj->get_image_id() ); ?>" />
    </figure>
    <article class="singleProduct__content">
        <section class="singleProduct__firstLine flex">
            <h2 class="singleProduct__title">
                <?php echo $productObj->get_title(); ?>
            </h2>
            <h3 class="singleProduct__price">
                <?php echo $productObj->get_price_html(); ?>
            </h3>
        </section>
        <h4 class="singleProduct__header">
            Opis produktu
        </h4>
        <section class="singleProduct__desc">
            <?php echo $productObj->get_description(); ?>
        </section>
        <?php
        $id = get_the_ID();
        echo do_shortcode( '[add_to_cart id='.$id.']' );
        ?>
    </article>
</main>

<?php
get_footer();
?>
