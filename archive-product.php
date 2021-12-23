<?php
get_header();
?>
<div class="breadcrumb">
    <?php woocommerce_breadcrumb(); ?>
</div>

<?php
$cate = get_queried_object();
$category = $cate->name;
$categorySlug = $cate->slug;
?>
<main class="shop__mainWrapper">
    <?php
    if(is_search()) {
        ?>
        <header class="homepage__products__header">
            <h2 class="homepage__products__header__h flex">
                Wyniki wyszukiwania
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
            <main class="shop__main">
                <?php
                $loop = new WP_Query( array(
                    'post_type' => 'product',
                    's' => get_search_query(),
                    'post_status' => 'publish'
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
                                    <img class="homepage__product__img homepage__product__img--2" src="<?php echo get_field('drugie_zdjecie'); ?>" />
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
            <?php
            get_sidebar();
            ?>
            <nav class="pagination">
                <?php
                echo paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $loop->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'type'         => 'plain',
                    'end_size'     => 2,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Poprzednia strona', 'text-domain' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Następna strona', 'text-domain' ) ),
                    'add_args'     => false,
                    'add_fragment' => '',
                ) );
                ?>
            </nav>
        </main>
            <?php
    }
    else if($category == 'product') {
        ?>
        <header class="homepage__products__header">
            <h2 class="homepage__products__header__h flex" onclick="openMobileMenuOnMobile()">
                Sklep
                <img class="d-mobile icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-down.svg'; ?>" alt="rozwin" />
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
            <main class="shop__main">
                <?php
                $loop = new WP_Query( array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
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
                                    <img class="homepage__product__img homepage__product__img--2" src="<?php echo get_field('drugie_zdjecie'); ?>" />
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
            <?php
            get_sidebar();
            ?>
            <nav class="pagination">
                <?php
                echo paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $loop->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'type'         => 'plain',
                    'end_size'     => 2,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Poprzednia strona', 'text-domain' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Następna strona', 'text-domain' ) ),
                    'add_args'     => false,
                    'add_fragment' => '',
                ) );
                ?>
            </nav>
        </main>
        <?php
    }
    else {
    ?>
    <header class="homepage__products__header">
        <h2 class="homepage__products__header__h flex" onclick="openMobileMenuOnMobile()">
            <?php echo $category; ?>
            <img class="d-mobile icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-down.svg'; ?>" alt="rozwin" />
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
    <?php
        ?>
        <main class="shop__main">
            <?php
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $categorySlug
                    )
                )
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
                                <img class="homepage__product__img homepage__product__img--2" src="<?php echo get_field('drugie_zdjecie'); ?>" />
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
        <?php
        get_sidebar();
        ?>
        <nav class="pagination">
            <?php
            echo paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $loop->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => 2,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf( '<i></i> %1$s', __( 'Poprzednia strona', 'text-domain' ) ),
                'next_text'    => sprintf( '%1$s <i></i>', __( 'Następna strona', 'text-domain' ) ),
                'add_args'     => false,
                'add_fragment' => '',
            ) );
            ?>
        </nav>
        <?php
    }
        ?>
    </main>
<?php
    get_footer();
?>
