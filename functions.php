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

    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array('aos-js'), _S_VERSION, true );

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
        <h5 class="topBar__header">
            <b>RABAT 15%</b> tylko do 30.11.2021! Użyj kodu <b>EROTIC10</b>.
        </h5>
    </aside>
    <div class="content">
    <nav class="topNav flex">
        <nav class="topNav__languages">

        </nav>

        <a class="topNav__logoWrapper">
            <img class="btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo.png'; ?>" alt="bolingier" />
        </a>

        <section class="topNav__right flex">
            <button class="topBar__right__btn flex">
                <img class="topBar__right__btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/search.svg'; ?>" alt="szukaj" />
                Wyszukiwarka
            </button>
            <button class="topBar__right__btn flex">
                <img class="topBar__right__btn__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="koszyk" />
                Koszyk (0 PLN)
            </button>
        </section>
    </nav>
    <menu class="topMenu">
        <ul class="topMenu__list flex">
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="/">
                    Strona główna
                </a>
            </li>
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="/">
                    O nas
                </a>
            </li>
            <li class="topMenu__list__item topMenu__list__item--shop" onmouseenter="showSubmenu()" onmouseleave="hideSubmenu()">
                <a class="topMenu__list__item__link flex"
                   href="/">
                    Sklep <img class="topMenu__list__item__link__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/arrow-down.svg'; ?>" alt="rozwin" />
                </a>
                <menu class="topMenu__submenu flex">
                    <img class="topMenu__submenu__img topMenu__submenu__img--male" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/male.svg'; ?>" alt="meskie" />
                    <img class="topMenu__submenu__img topMenu__submenu__img--famale" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/famale.svg'; ?>" alt="damskie" />

                    <section class="topMenu__submenu__section">
                        <h3 class="topMenu__submenu__section__header">
                            Dla niej
                        </h3>
                        <main class="topMenu__submenu__section__main flex">
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                        </main>
                    </section>
                    <section class="topMenu__submenu__section">
                        <h3 class="topMenu__submenu__section__header">
                            Dla niego
                        </h3>
                        <main class="topMenu__submenu__section__main flex">
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                            <section class="topMenu__submenu__category">
                                <a class="topMenu__submenu__category__link" href="">
                                    Hard
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Kombinezony
                                </a>
                                <a class="topMenu__submenu__subcategory__link" href="">
                                    Body
                                </a>
                            </section>
                        </main>
                    </section>
                </menu>
            </li>
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="/">
                    Informacje
                </a>
            </li>
            <li class="topMenu__list__item">
                <a class="topMenu__list__item__link" href="/">
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
            <source src="<?php echo get_bloginfo('stylesheet_directory') . '/img/video.webm'; ?>" type="video/mp4">
        </video>
    </main>
    <section class="homepage__products">
        <header class="homepage__products__header">
            <h2 class="homepage__products__header__h flex">
                Polecane produkty
            </h2>
        </header>
        <main class="homepage__products__main flex">
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
        </main>
    </section>

    <section class="homepage__products">
        <header class="homepage__products__header">
            <h2 class="homepage__products__header__h flex">
                Promocje
            </h2>
        </header>
        <main class="homepage__products__main flex">
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
            <section class="homepage__product">
                <figure class="homepage__product__imgWrapper">
                    <img class="homepage__product__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="tytul" />
                </figure>
                <h3 class="homepage__product__title">
                    Tytuł produktu
                </h3>
                <h4 class="homepage__product__subtitle">
                    Podtytuł produktu (max. 40 znaków)
                </h4>
                <h5 class="homepage__product__price">
                    199 PLN
                </h5>
                <button class="homepage__product__addToCart flex">
                    <img class="homepage__product__addToCart__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/shopping-bag.svg'; ?>" alt="dodaj-do-koszyka" />
                    Dodaj do koszyka
                </button>
            </section>
        </main>
    </section>
    </div>
    <section class="homepage__fullWidth flex">
        <article class="homepage__fullWidth__left">
            <h3 class="homepage__fullWidth__left__header">
                Odzież erotyczna - dodaj życiu odrobinę rozkoszy
            </h3>
            <p class="homepage__fullWidth__left__text">
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
            </p>
            <a class="homepage__fullWidth__left__btn flex" href="/">
                Zobacz wszystkie produkty
                <img class="homepage__fullWidth__left__btn__icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="produkty" />
            </a>
        </article>
        <figure class="homepage__fullWidth__right">
            <img class="homepage__fullWidth__right__img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="bolingier" />
        </figure>
    </section>

    <div class="content">
        <section class="homepage__products">
            <header class="homepage__products__header">
                <h2 class="homepage__products__header__h flex">
                    Bolingier.com
                </h2>
            </header>
            <main class="homepage__bottomContent">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sodales, urna quis dignissim malesuada, risus elit laoreet dolor, quis ornare lorem dui non lacus. Aliquam elementum et augue in dignissim. Integer in elit mauris. Etiam luctus mauris eu leo luctus, vitae congue erat sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed ultricies risus dolor, in sagittis magna ullamcorper in. Cras ut velit sapien. Pellentesque sodales interdum eros ut malesuada. Nullam ut rhoncus ligula, quis efficitur dui. Etiam quis dignissim massa, vel lobortis dolor. Vestibulum sit amet lacus sem. Sed fringilla imperdiet molestie. Nam sed purus sed sapien ullamcorper mollis ac quis nisi.
                    <br/><br/>
                    Curabitur ultrices quam nec leo malesuada, sed molestie nulla porttitor. Aenean magna lectus, ultrices in dolor sed, blandit ornare leo. Integer et enim feugiat, tristique orci ut, fringilla lacus. Aliquam rhoncus dui at mollis commodo. Pellentesque molestie augue vel leo lobortis, eu tristique nisl interdum. Vestibulum vel erat tellus. In nec rutrum lacus. Nunc orci leo, fermentum vitae condimentum id, convallis sit amet nibh. Curabitur sit amet risus ut purus malesuada pellentesque eget non diam. Maecenas vel ante tempor, suscipit elit eu, aliquam dolor.
                    <br/><br/>
                    Maecenas blandit nunc sit amet ligula convallis scelerisque. Phasellus ut nulla fringilla, dapibus leo eu, consequat urna. Integer fringilla libero vitae felis accumsan, eu aliquet libero tincidunt. Pellentesque lobortis pharetra posuere. Donec at justo porttitor, molestie quam at, elementum lectus. Donec pellentesque sem ut tincidunt dignissim. Curabitur finibus mi ac ante cursus convallis et id leo. Donec pretium aliquam semper. In ut sem mattis, porttitor justo et, pellentesque enim. Vivamus in lorem a quam porta ullamcorper quis vitae mi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    <br/><br/>
                    Donec placerat laoreet venenatis. Duis feugiat quam at ligula sollicitudin rhoncus. Ut magna libero, eleifend vel finibus eu, ultricies sit amet velit. Mauris ligula elit, iaculis ut blandit ut, lacinia vel ligula. Nullam vitae ornare velit, et auctor tellus. Morbi tincidunt ut nisl sed aliquam. Phasellus urna mauris, posuere vel gravida eu, pharetra at ligula. Suspendisse ut dolor nec neque placerat rhoncus id nec eros. Aliquam semper risus diam, in gravida erat feugiat sed. Mauris mollis, odio nec faucibus consectetur, nulla nibh facilisis lorem, et interdum est urna ut mi. Suspendisse dapibus iaculis velit. Ut semper porta tellus, in sagittis neque placerat at. Aliquam feugiat nunc elit, et commodo turpis rhoncus id.
                    <br/><br/>
                    Morbi ullamcorper ultrices turpis sed venenatis. Maecenas efficitur consequat porttitor. Aliquam ultricies neque augue, et vehicula elit egestas non. Morbi gravida venenatis dui, et luctus risus tempor at. Donec mollis orci a ante fermentum, in cursus purus egestas. Suspendisse consequat est vitae dictum egestas. Nullam nec velit vitae dui faucibus lobortis. Curabitur lorem eros, condimentum at dolor eu, placerat sagittis orci. Proin blandit nec felis vitae pulvinar. Nulla ullamcorper commodo consectetur. Proin nec placerat felis. Mauris nec facilisis nulla.
                </p>
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
                        <img class="points__item__img" src=".<?php echo get_bloginfo('stylesheet_directory') . '/img/diamond.svg'; ?>" alt="prezent" />
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
                            <a class="footer__list__item__link" href="">
                                Regulamin sklepu
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Polityka prywatności
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Zwroty
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Dostawa i płatność
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
                            <a class="footer__list__item__link" href="">
                                Informacje o sklepie
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Kontakt
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Produkty damskie
                    </h5>
                    <ul class="footer__list">
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Hard
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Soft
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Obuwie
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Akcesoria
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Produkty męskie
                    </h5>
                    <ul class="footer__list">
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Hard
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Soft
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Obuwie
                            </a>
                        </li>
                        <li class="footer__list__item">
                            <a class="footer__list__item__link" href="">
                                Akcesoria
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__col">
                    <h5 class="footer__header">
                        Dane firmy
                    </h5>
                    <p class="footer__text">
                        BOLINGIER FASHION STYLE<br/><br/>
                        ul. Szeroka 54, 42-700 Lubliniec<br/><br/>
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