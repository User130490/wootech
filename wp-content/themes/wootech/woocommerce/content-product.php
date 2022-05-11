<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
<div class="max-w-sm bg-white rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
		<a href="<?php echo $product->get_permalink(); ?>">
			<?php
				echo 
				$product->get_image(
					$size = 'woocommerce_thumbnail', 
					$attr = array(
						'class' => 'w-full',
						'alt' => $product->name
					), 
					$placeholder = true
				);
			?>
		</a>
		<div class="px-6 py-4">
			<a href="<?php echo $product->get_permalink(); ?>">
				<h5 class="font-bold text-xl mb-2"><?php echo $product->name; ?></h5>
			</a>
			<p class="text-gray-700 text-base py-2 mb-4">
			<?php echo $product->short_description; ?>
			</p>
			<div class="flex justify-between items-center">
				<span class="text-4xl font-bold text-gray-900 dark:text-white"><?php echo $product->get_price('view').get_woocommerce_currency_symbol(); ?></span>
				<a href="<?php echo $product->add_to_cart_url(); ?>"
					class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
					to cart</a>
			</div>
			<div class="pt-4 pb-2">
			<?php 
				$product_tags = explode(",", $product->get_tags()); 
				foreach ($product_tags as $product_tag){
					if($product_tag != ''){
			?>
					<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><?php echo '#'.$product_tag; ?></span>
			<?php
					}
				}
			?>
			</div>
		</div>
	</div>
</li>
