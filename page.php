<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

        <?php
            if(get_the_title() == 'O nas') {
                ?>

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
        ?>



	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
