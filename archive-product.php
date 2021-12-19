<?php
get_header();
?>
<?php
$cate = get_queried_object();
$category = $cate->name;
?>
<main class="shop__mainWrapper">
    <?php
    if($category == 'product') {
        ?>
        <header class="homepage__products__header">
            <h2 class="homepage__products__header__h flex">
                Sklep
            </h2>
        </header>
        <main class="shop flex">
            <nav class="shop__categories">
                <h3 class="shop__categories__header flex">
                    Kategorie
                </h3>
                <menu class="shop__categories__menu">
                    <?php
                    function hierarchical_term_tree($category = 0)
                    {
                        $r = '';

                        $args = array(
                            'parent' => $category,
                        );

                        $next = get_terms('product_cat', $args);

                        if ($next) {
                            $r .= '<ul>';

                            foreach ($next as $cat) {
                                $r .= '<li><a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s"), $cat->name) . '" ' . '>' . $cat->name . '</a>';
                                $r .= $cat->term_id !== 0 ? hierarchical_term_tree($cat->term_id) : null;
                            }
                            $r .= '</li>';

                            $r .= '</ul>';
                        }

                        return $r;
                    }

                    echo hierarchical_term_tree();
                    ?>
                </menu>
            </nav>
            <main class="shop__main flex">
                <?php
                $loop = new WP_Query( array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 100
                ));
                if($loop->have_posts()) {
                    while($loop->have_posts()) {
                        $loop->the_post();
                        global $product;
                        ?>
                        <section class="homepage__productWrapper">
                            <a class="homepage__product" href="<?php echo get_permalink( $product->get_id() ); ?>">
                                <figure class="homepage__product__imgWrapper">
                                    <img class="homepage__product__img" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" />
                                </figure>
                                <h3 class="homepage__product__title">
                                    <?php echo the_title(); ?>
                                </h3>
                                <section class="homepage__product__subtitle">
                                    <?php echo $product->get_short_description(); ?>
                                </section>
                                <h4 class="homepage__product__price">
                                    <?php echo $product->get_price_html(); ?>
                                </h4>
                            </a>
                            <?php woocommerce_template_loop_add_to_cart($loop->post, $product); ?>
                        </section>
                        <?php
                    }
                    wp_reset_postdata();
                }
                ?>
            </main>
        </main>
        <?php
    }
    else {
    ?>
    <h2 class="section__header">
        <?php echo $category; ?>
    </h2>
    <?php
    if($category == 'E-booki') {
        ?>
        <main class="section__ebooks flex">
            <?php
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 100,
                'product_cat' => 'e-booki'
            ));
            if($loop->have_posts()) {
                while($loop->have_posts()) {
                    $loop->the_post();
                    global $product;
                    ?>
                    <section class="section__ebooks__item">
                        <a class="section__ebooks__item__inner" href="<?php echo get_permalink( $product->get_id() ); ?>">
                            <figure class="section__ebooks__item__imgWrapper">
                                <img class="section__ebooks__item__img" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" />
                            </figure>
                            <h3 class="section__ebooks__item__title">
                                <?php echo the_title(); ?>
                            </h3>
                            <section class="section__ebooks__item__text">
                                <?php echo $product->get_short_description(); ?>
                            </section>
                            <h4 class="section__ebooks__item__price">
                                <?php echo $product->get_price_html(); ?>
                            </h4>
                        </a>
                        <?php woocommerce_template_loop_add_to_cart($loop->post, $product); ?>
                    </section>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </main>
        <?php
    }
    }
        ?>
    </main>
<?php
    get_footer();
?>
