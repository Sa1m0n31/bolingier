<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

function bolingier_scripts() {
    wp_enqueue_style( 'css-mobile', get_template_directory_uri() . '/mobile.css', array(), _S_VERSION );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array('aos-js', 'siema-js'), _S_VERSION, true );
    wp_enqueue_script( 'siema-js', get_template_directory_uri() . '/assets/js/siema.js', array('aos-js'), _S_VERSION, true );

    /* AOS */
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js');
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css');

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'bolingier_scripts' );

/* Header */
function remove_header_actions() {
    remove_all_actions('storefront_header');
    remove_all_actions('storefront_content_top');
}
add_action('wp_head', 'remove_header_actions');

function bolingier_header() {
    ?>
    <aside class="topBar flex">
            <?php
                echo get_field('gorna_belka', 12);
            ?>
    </aside>
    <div class="contentBolingier">
    <nav class="topNav flex">
        <nav class="topNav__languages flex d-desktop">
            <span>
                Wybierz język
            </span>
            <?php
                echo do_shortcode('[language-switcher]');
            ?>
        </nav>

        <a class="topNav__logoWrapper" href="<?php echo get_home_url(); ?>">
            <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo.png'; ?>" alt="bolingier" />
        </a>

        <section class="topNav__right flex d-desktop">
            <a class="topBar__right__btn flex" href="/sklep">
                <img class="topBar__right__btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/search.svg'; ?>" alt="szukaj" />
                Wyszukiwarka
            </a>
            <a class="topBar__right__btn flex" href="<?php echo wc_get_cart_url(); ?>">
                <img class="topBar__right__btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="koszyk" />
                Koszyk (<?php echo WC()->cart->get_cart_contents_count(); ?>)
            </a>
        </section>
    </nav>
    <menu class="topMenu--mobile d-mobile">
        <button class="topMenu--mobile__item" onclick="openMobileMenu()">
            <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/menu.svg'; ?>" alt="menu" />
        </button>
        <a class="topMenu--mobile__item" href="/koszyk">
            <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="menu" />
        </a>
        <a class="topMenu--mobile__item" href="/sklep">
            <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/search.svg'; ?>" alt="menu" />
        </a>
    </menu>
    <nav class="menuMobile d-mobile">
        <main class="menuMobile__inner">
            <header class="menuMobile__header">
                <h4 class="menuMobile__header__h">
                    Kategorie
                </h4>
            </header>
            <div class="flex">
                <button class="menuMobile__closeBtn" onclick="closeMobileMenu()">
                    <img class="icon__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="zamknij-menu" />
                    Wróć
                </button>
                <nav class="topNav__languages flex">
                    <button class="topNav__languages--mobile" onclick="polish()">
                        <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/poland.svg'; ?>" alt="polski" />
                    </button>
                    <button class="topNav__languages--mobile" onclick="english()">
                        <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/united-states.svg'; ?>" alt="polski" />
                    </button>
                </nav>
            </div>
            <main class="shop__categories__menu">
                <?php
                function hierarchical_term_tree_main_menu($category = 0)
                {
                    $r = '';

                    if($category == 0) {
                        $args = array(
                            'parent' => $category,
                            'slug' => array('dla-niej', 'dla-niego'),
                            'orderby' => 'name',
                            'order' => 'DESC'
                        );
                    }
                    else {
                        $args = array(
                            'parent' => $category
                        );
                    }

                    $next = get_terms('product_cat', $args);

                    if ($next) {
                        $r .= '<ul>';

                        foreach ($next as $cat) {
                            $r .= '<li><a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s"), $cat->name) . '" ' . '>' . $cat->name . '</a>';
                            $r .= $cat->term_id !== 0 ? hierarchical_term_tree_main_menu($cat->term_id) : null;
                        }
                        $r .= '</li>';

                        $r .= '</ul>';
                    }

                    return $r;
                }
                    echo hierarchical_term_tree_main_menu();
                ?>
            </main>
        </main>
    </nav>



    <menu class="topMenu d-desktop">
        <ul class="topMenu__list flex">
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="<?php echo get_home_url(); ?>">
                    Strona główna
                </a>
            </li>
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="<?php echo get_page_link(get_page_by_title('O nas')->ID); ?>">
                    O nas
                </a>
            </li>
            <li class="topMenu__list__item topMenu__list__item--shop" onmouseenter="showSubmenu()" onmouseleave="hideSubmenu()">
                <a class="topMenu__list__item__link flex"
                   href="/sklep">
                    Sklep <img class="topMenu__list__item__link__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-down.svg'; ?>" alt="rozwin" />
                </a>
                <menu class="topMenu__submenu flex">
                    <img class="topMenu__submenu__img topMenu__submenu__img--male" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/male.svg'; ?>" alt="meskie" />
                    <img class="topMenu__submenu__img topMenu__submenu__img--famale" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/famale.svg'; ?>" alt="damskie" />

                    <menu class="shop__categories__menu">
                        <?php
                        echo hierarchical_term_tree_main_menu();
                        ?>
                    </menu>
                </menu>
            </li>
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="<?php echo get_page_link(get_page_by_title('Informacje')->ID); ?>">
                    Informacje
                </a>
            </li>
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="<?php echo get_page_link(get_page_by_title('Kontakt')->ID); ?>">
                    Kontakt
                </a>
            </li>
        </ul>
    </menu>
<?php
}

add_action('storefront_before_content', 'bolingier_header', 10);
add_action('wp_head', 'remove_homepage');

function bolingier_homepage() {
    ?>
    <main class="video">
        <video style="width: 100%;" autoplay loop muted playsinline>
            <source src="<?php echo get_bloginfo('stylesheet_directory') . '/img/video.mp4'; ?>" type="video/mp4">
        </video>
    </main>
    <section class="homepage__products">
        <header class="homepage__products__header">
            <button class="homepage__products__header__btn homepage__products__header__btn--prev d-mobile" onclick="prevSlider1()">
                <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-long.svg'; ?>" alt="poprzedni" />
            </button>
            <h2 class="homepage__products__header__h flex">
                Polecane produkty
            </h2>
            <button class="homepage__products__header__btn d-mobile" onclick="nextSlider1()">
                <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-long.svg'; ?>" alt="poprzedni" />
            </button>
        </header>
        <main class="homepage__products__main flex d-desktop" data-aos="fade-in">
            <?php
            $i = 0;
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'polecane'
                    )
                )
            ));
            if($loop->have_posts()) {
                while($loop->have_posts()) {
                    $loop->the_post();
                    global $product;
                    if($i < 4) {
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
                    $i++;
                }
                wp_reset_postdata();
            }
            ?>
        </main>
        <main class="homepage__products__main--mobile1 d-mobile" data-aos="fade-in">
            <?php
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'polecane'
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
    </section>

    <section class="homepage__products">
        <header class="homepage__products__header">
            <button class="homepage__products__header__btn homepage__products__header__btn--prev d-mobile" onclick="prevSlider2()">
                <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-long.svg'; ?>" alt="poprzedni" />
            </button>
            <h2 class="homepage__products__header__h flex">
                Promocje
            </h2>
            <button class="homepage__products__header__btn d-mobile" onclick="nextSlider2()">
                <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-long.svg'; ?>" alt="poprzedni" />
            </button>
        </header>
        <main class="homepage__products__main flex d-desktop" data-aos="fade-in">
            <?php
            $i = 0;
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'promocje'
                    )
                )
            ));
            if($loop->have_posts()) {
                while($loop->have_posts()) {
                    $loop->the_post();
                    global $product;
                    if($i < 4) {
                        ?>
                        <section class="homepage__productWrapper">
                            <a class="homepage__product" href="<?php echo get_permalink( $product->get_id() ); ?>">
                                <figure class="homepage__product__imgWrapper">
                                <span class="homepage__product__imgWrapper__onsale">
                                    Promocja!
                                </span>
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
                    $i++;
                }
                wp_reset_postdata();
            }
            ?>
        </main>
        <main class="homepage__products__main--mobile2 d-mobile" data-aos="fade-in">
            <?php
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'promocje'
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
                                <span class="homepage__product__imgWrapper__onsale">
                                    Promocja!
                                </span>
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
    </section>
    </div>
    </div>
    </div>
    <section class="homepage__fullWidth flex">
        <article class="homepage__fullWidth__left" data-aos="fade-in">
            <h3 class="homepage__fullWidth__left__header">
                <?php echo get_field('naglowek', 12); ?>
            </h3>
            <p class="homepage__fullWidth__left__text">
               <?php echo get_field('tekst', 12); ?>
            </p>
            <a class="homepage__fullWidth__left__btn flex" href="<?php echo get_permalink(wc_get_page_id( 'shop' )); ?>">
                Zobacz wszystkie produkty
                <img class="homepage__fullWidth__left__btn__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="produkty" />
            </a>
        </article>
        <figure class="homepage__fullWidth__right" data-aos="fade-in">
            <img class="homepage__fullWidth__right__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="bolingier" />
        </figure>
    </section>

    <div class="contentBolingier">
        <section class="homepage__products" data-aos="fade-in">
            <header class="homepage__products__header">
                <h2 class="homepage__products__header__h flex">
                    Bolingier.com
                </h2>
            </header>
            <main class="homepage__bottomContent">
                <?php
                    $your_query = new WP_Query( 'pagename=o-nas' );
                    while ( $your_query->have_posts() ) : $your_query->the_post();
                        the_content();
                    endwhile;
                    wp_reset_postdata();
                ?>
            </main>
        </section>

        <section class="points">
            <h3 class="points__header">
                Jesteśmy wyjątkowi, poznaj nasze zalety
            </h3>
            <main class="points__main flex" data-aos="fade-in">
                <section class="points__item flex">
                    <figure class="points__item__imgWrapper flex">
                        <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/gift.svg'; ?>" alt="prezent" />
                    </figure>
                    <h4 class="points__item__header">
                        Dyskretna wysyłka
                    </h4>
                    <p class="points__item__text">
                        Gwarantujemy maksymalną dyskrecję przy wysyłanych przez nas paczkach.
                    </p>
                </section>
                <section class="points__item flex">
                    <figure class="points__item__imgWrapper flex">
                        <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/satisfied.svg'; ?>" alt="prezent" />
                    </figure>
                    <h4 class="points__item__header">
                        Satysfakcja
                    </h4>
                    <p class="points__item__text">
                        Oferujemy produkty wysokiej jakości, które są gwarancją pełnej satysfakcji.
                    </p>
                </section>
                <section class="points__item flex">
                    <figure class="points__item__imgWrapper flex">
                        <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/diamond.svg'; ?>" alt="prezent" />
                    </figure>
                    <h4 class="points__item__header">
                        Modne komplety
                    </h4>
                    <p class="points__item__text">
                        Nasze kreacje i komplety dostosowujemy do aktualnej mody.
                    </p>
                </section>
                <section class="points__item flex">
                    <figure class="points__item__imgWrapper flex">
                        <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/decision-making.svg'; ?>" alt="prezent" />
                    </figure>
                    <h4 class="points__item__header">
                        Doradztwo
                    </h4>
                    <p class="points__item__text">
                        Jeśli masz problem z wyborem, jesteśmy do Twojej dyspozycji. Chętnie doradzamy!
                    </p>
                </section>
            </main>
        </section>
        <?php
}

add_action('storefront_homepage', 'bolingier_homepage', 10);

function bolingier_footer() {
    ?>

    <footer class="footer">
            <section class="footer__main flex">
                <a class="footer__logo">
                    <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo.png'; ?>" alt="bolingier" />
                </a>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Informacje
                    </h5>
                    <ul class="footer__list">
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="<?php echo get_page_link(get_page_by_title('Regulamin')->ID); ?>">
                                Regulamin sklepu
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="<?php echo get_page_link(get_page_by_title('Polityka prywatności')->ID); ?>">
                                Polityka prywatności
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="<?php echo get_page_link(get_page_by_title('Tabela rozmiarów')->ID); ?>">
                                Tabela rozmiarów
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="<?php echo get_page_link(get_page_by_title('Wysyłka')->ID); ?>">
                                Wysyłka
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__col">
                    <h5 class="footer__header">
                        O nas
                    </h5>
                    <ul class="footer__list">
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="<?php echo get_page_link(get_page_by_title('Informacje')->ID); ?>">
                                Informacje o sklepie
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="<?php echo get_page_link(get_page_by_title('Kontakt')->ID); ?>">
                                Kontakt
                            </a>
                        </li>
                    </ul>
                </section>
                <?php
                    function get_subcategories($category)
                    {
                        $args = array(
                            'parent' => $category,
                        );

                        $next = get_terms('product_cat', $args);

                        if ($next) {
                            foreach ($next as $cat) {
                                ?>
                                <li class="footer__list__item">
                                    <a class="footer__list__item__link" href="<?php echo get_term_link($cat->slug, $cat->taxonomy); ?>">
                                        <?php echo $cat->name; ?>
                                    </a>
                                </li>
                                    <?php
                            }
                        }
                    }
                ?>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Produkty damskie
                    </h5>
                    <ul class="footer__list">
                        <?php
                            $category = get_term_by( 'slug', 'dla-niej', 'product_cat' );
                            $cat_id = $category->term_id;
                            get_subcategories($cat_id);
                        ?>
                    </ul>
                </section>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Produkty męskie
                    </h5>
                    <ul class="footer__list">
                        <?php
                        $category = get_term_by( 'slug', 'dla-niego', 'product_cat' );
                        $cat_id = $category->term_id;
                        get_subcategories($cat_id);
                        ?>
                    </ul>
                </section>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Dane firmy
                    </h5>
                    <p class="footer__text">
                        BOLINGIER FASHION STYLE<br/>
                        <span class="d-desktop"><br/></span>
                        ul. Szeroka 54, 42-700 Lubliniec<br/>
                        <span class="d-desktop"><br/></span>
                        NIP: 5751318248<br/>
                        REGON: 240543571<br/>
                        Bank SA<br/>
                        1010 1010 1010 10101010101
                    </p>
                </section>
            </section>
           <aside class="footer__bottom flex">
                <h6 class="footer__bottom__header">
                    &copy; 2021 BOLINGIER.com Wszelkie prawa zastrzeżone<br/>
                    Sklep przeznaczony jest wyłącznie dla osób pełnoletnich
                </h6>
               <h6 class="footer__bottom__header">
                   Projekt i realizacja
                   <a class="footer__bottom__link" href="https://skylo.pl" target="_blank" rel="noreferrer">
                       Skylo.pl - Agencja Interaktywna
                   </a>
               </h6>
           </aside>
       </footer>
    </div>
        <?php
}

add_action('storefront_footer', 'bolingier_footer', 14);

function bolingier_before_add_to_cart_form() {
    ?>
        <h4 class="singleProduct__description__header">
            Opis produktu
        </h4>
    <p class="singleProduct__description__main">
        <?php
            global $product;
            echo $product->get_description();
        ?>
    </p>
<?php
}

add_action('woocommerce_before_add_to_cart_form', 'bolingier_before_add_to_cart_form');


function bolingier_single_variation() {
    ?>
    <span class="singleProduct__links">
        Nie wiesz jaki rozmiar wybrać? <a class="link" href="<?php echo get_page_link(get_page_by_title('Tabela rozmiarów')->ID);  ?>">
            Sprawdź tabelę rozmiarów
        </a>
    </span>
    <span class="singleProduct__links">
        <a class="link" href="<?php echo get_page_link(get_page_by_title('Wysyłka')->ID); ?>">
            Informacje o przesyłkach (wysyłamy również za granicę)
        </a>
    </span>
<?php
}

add_action('woocommerce_single_variation', 'bolingier_single_variation');

function bolingier_after_single_product() {
    ?>
    <section class="homepage__products">
        <header class="homepage__products__header">
            <button class="homepage__products__header__btn homepage__products__header__btn--prev d-mobile" onclick="prevSlider1()">
                <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-long.svg'; ?>" alt="poprzedni" />
            </button>
            <h2 class="homepage__products__header__h flex">
                Polecane produkty
            </h2>
            <button class="homepage__products__header__btn d-mobile" onclick="nextSlider1()">
                <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-long.svg'; ?>" alt="poprzedni" />
            </button>
        </header>
        <main class="homepage__products__main flex d-desktop">
            <?php
            $i = 0;
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'polecane'
                    )
                )
            ));
            if($loop->have_posts()) {
                while($loop->have_posts()) {
                    $loop->the_post();
                    global $product;
                    if($i < 4) {
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
                    $i++;
                }
                wp_reset_postdata();
            }
            ?>
        </main>
        <main class="homepage__products__main--mobile1 d-mobile">
            <?php
            $loop = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'polecane'
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
    </section>
    <section class="points">
        <h3 class="points__header">
            Jesteśmy wyjątkowi, poznaj nasze zalety
        </h3>
        <main class="points__main flex">
            <section class="points__item flex">
                <figure class="points__item__imgWrapper flex">
                    <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/gift.svg'; ?>" alt="prezent" />
                </figure>
                <h4 class="points__item__header">
                    Dyskretna wysyłka
                </h4>
                <p class="points__item__text">
                    Gwarantujemy maksymalną dyskrecję przy wysyłanych przez nas paczkach.
                </p>
            </section>
            <section class="points__item flex">
                <figure class="points__item__imgWrapper flex">
                    <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/satisfied.svg'; ?>" alt="prezent" />
                </figure>
                <h4 class="points__item__header">
                    Satysfakcja
                </h4>
                <p class="points__item__text">
                    Oferujemy produkty wysokiej jakości, które są gwarancją pełnej satysfakcji.
                </p>
            </section>
            <section class="points__item flex">
                <figure class="points__item__imgWrapper flex">
                    <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/diamond.svg'; ?>" alt="prezent" />
                </figure>
                <h4 class="points__item__header">
                    Modne komplety
                </h4>
                <p class="points__item__text">
                    Nasze kreacje i komplety dostosowujemy do aktualnej mody.
                </p>
            </section>
            <section class="points__item flex">
                <figure class="points__item__imgWrapper flex">
                    <img class="points__item__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/decision-making.svg'; ?>" alt="prezent" />
                </figure>
                <h4 class="points__item__header">
                    Doradztwo
                </h4>
                <p class="points__item__text">
                    Jeśli masz problem z wyborem, jesteśmy do Twojej dyspozycji. Chętnie doradzamy!
                </p>
            </section>
        </main>
    </section>
<?php
}

add_action('woocommerce_after_single_product', 'bolingier_after_single_product');