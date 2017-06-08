<?php
/**
 *Begin merge of the customized cpf code: http://www.exportfeed.com/documentation/additional-product-fields/
 */
//Simple Product Hooks
// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'cpf_custom_general_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'cpf_save_custom_general_fields' );

//Variable Product Hooks
//Display Fields (both actions below should work)
add_action( 'woocommerce_product_after_variable_attributes', 'cpf_custom_variable_fields', 10, 3 );
//add_action( 'woocommerce_variation_options', 'cpf_custom_variable_fields', 10, 3 );

//Save variation fields
//add_action( 'woocommerce_process_product_meta_variable', 'cpf_save_custom_variable_fields', 10, 1 );
//As of WooCommerce 2.4.4:
//woocommerce_process_product_meta_variable no longer works, and it must be changed to woocommerce_save_product_variation
add_action( 'woocommerce_save_product_variation', 'cpf_save_custom_variable_fields', 10, 1 ); 

function cpf_custom_general_fields()
{	
	global $woocommerce, $post;

	echo '<div id="cpf_attr" class="options_group">';
	//ob_start();

	//Vendor field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_cpf_vendor', 
			'label'       => __( 'Vendor', 'woocommerce' ), 
			'desc_tip'    => 'true',
			//'type'        => 'text',
			'value' 	  =>  get_post_meta( $post->ID, '_cpf_vendor', true ),
			'description' => __( 'Enter the product Vendor here.', 'woocommerce' )				
		)
	);
	
	//Brand field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_cpf_brand', 
			'label'       => __( 'Brand', 'woocommerce' ), 
			'desc_tip'    => 'true',
			//'type'        => 'text',
			'value' 	  =>  get_post_meta( $post->ID, '_cpf_brand', true ),
			'description' => __( 'Enter the product Brand here.', 'woocommerce' )				
		)
	);

	//  Valid field
	woocommerce_wp_select(
		array( 
			'id'          => '_cpf_valid', 
			'label'       => __( 'Valid', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Select False to exclude this entire product from the feed', 'woocommerce' ),
			'value'       => get_post_meta( $post->ID, '_cpf_valid', true ),
			'options'    => array(
				'true'   => __( 'True', 'woocommerce' ),
				'false'  => __( 'False', 'woocommerce' ),				
			)
		)
	);

	// Condition Field
	woocommerce_wp_select(
		array( 
			'id'          		=> '_cpf_condition', 
			'label'       		=> __( 'Condition', 'woocommerce' ), 
			'desc_tip'    		=> 'true',
			'description' 		=> __( 'Select the condition of this product', 'woocommerce' ),
			'value'       		=> get_post_meta( $post->ID, '_cpf_condition', true ),
			'options'    		=> array(
				'new'   		=> __( 'New', 'woocommerce' ),
				'used'  		=> __( 'Used', 'woocommerce' ),				
				'refurbished'  	=> __( 'Refurbished', 'woocommerce' ),				
			)
		)
	);

	// Category Field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_cpf_category', 
			'label'       => __( 'Category', 'woocommerce' ), 
			'desc_tip'    => 'true',
			//'type'        => 'text',
			'value' 	  =>  get_post_meta( $post->ID, '_cpf_category', true ),
			'description' => __( 'Enter the product category here.', 'woocommerce' )				
		)
	);

	echo '</div>';
	echo '<div id="cpf_attr" class="options_group show_if_simple show_if_external">';
	// woocommerce_wp_text_input
	// ( 
	// 	array
	// 	(	'id'          => '_cpf_map', 
	// 		'label'       => __( 'MAP', 'woocommerce' ), 
	// 		'desc_tip'    => 'true',
	// 		'description' => __( 'Enter the supplier\'s MAP here.', 'woocommerce' ),
	// 		'type'        => 'number',
	// 	     'custom_attributes' => array(
	// 								'step' 	=> 'any',
	// 								'min'	=> '0'
	// 							)
	// 	)
	// );

	//MPN Field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_cpf_mpn', 
			'label'       => __( 'MPN', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the manufacturer product number', 'woocommerce' ),
		)
	);
	
	//UPC Field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_cpf_upc', 
			'label'       => __( 'UPC', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
		)
	);
	
	//UPC Field
	woocommerce_wp_text_input(
		array(	
			'id'          => '_cpf_ean', 
			'label'       => __( 'EAN', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the product EAN here.', 'woocommerce' ),
		)
	);

	// //Valid Field
	// woocommerce_wp_select( 
	// 		array( 
	// 			'id'          => '_cpf_valid', 
	// 			'label'       => __( 'Valid', 'woocommerce' ), 
	// 			'desc_tip'    => 'true',
	// 			'description' => __( 'Select False to exclude this product/variation from the feed', 'woocommerce' ),
	// 			'options' 	  => array(
	// 				'true'    => __( 'True', 'woocommerce' ),
	// 				'false'   => __( 'False', 'woocommerce' ),				
	// 			)
	// 		)
	// );
	
	// woocommerce_wp_text_input(
	// 	array(	
	// 		'id'          => '_cpf_valid', 
	// 		'label'       => __( 'Valid', 'woocommerce' ), 
	// 		'desc_tip'    => 'true',
	// 		'description' => __( 'Valid (True | False)', 'woocommerce' ),
	// 	)
	// );

	// Cost Field
	// woocommerce_wp_text_input
	// (
	// 	array
	// 	(
	// 		'id'          => '_cpf_item_cost', 
	// 		'label'       => __( 'Item Cost', 'woocommerce' ), 
	// 		'desc_tip'    => 'true',
	// 		'description' => __( 'Enter the cost of this item.', 'woocommerce' ),
	// 		'type'        => 'number',
	// 				'custom_attributes' => array(
	// 								'step' 	=> 'any',
	// 								'min'	=> '0'
	// 							)
	// 	)
	// );

	//Shipping Cost Field
	// woocommerce_wp_text_input
	// (
	// 	array
	// 	( 
	// 		'id'          => '_cpf_shipping_cost', 
	// 		'label'       => __( 'Shipping Cost', 'woocommerce' ), 
	// 		'desc_tip'    => 'true',
	// 		'description' => __( 'Enter the cost of shipping charged to DN', 'woocommerce' ),
	// 		'type'        => 'number',
	// 		'custom_attributes' => array(
	// 								'step' 	=> 'any',
	// 								'min'	=> '-1'
	// 						)
	// 	)
	// );

	// Notes about this prodcut
	// woocommerce_wp_textarea_input
	// (
	// 	array
	// 	( 
	// 		'id'          => '_cpf_notes', 
	// 		'label'       => __( 'Notes', 'woocommerce' ), 
	// 		'placeholder' => '', 
	// 		'description' => __( 'Enter any notes about this product.', 'woocommerce' ),
	// 	)
	// );

//$additional_fields = ob_get_contents();
	
	//ob_end_clean();
	echo '</div>';	
}

/**
 * Save new fields for simple products
 *
*/
function cpf_save_custom_general_fields($post_id)
{	
	//$woocommerce_supplier_title	=	$_POST['_cpf_supplier_title'];
	//$woocommerce_map			=	$_POST['_cpf_map'];
	//$woocommerce_upc			=	$_POST['_cpf_upc'];
	//$woocommerce_item_cost		=	$_POST['_cpf_item_cost'];
	//$woocommerce_shipping_cost	=	$_POST['_cpf_shipping_cost'];
	//$woocommerce_dropship_fee	=	$_POST['_cpf_dropship_fee'];
	//$woocommerce_notes			=	$_POST['_cpf_notes'];
	  
	$woocommerce_vendor = $_POST['_cpf_vendor'];
	$woocommerce_brand = $_POST['_cpf_brand'];
	$woocommerce_upc = $_POST['_cpf_upc'];	  
	$woocommerce_mpn = $_POST['_cpf_mpn'];
	$woocommerce_ean = $_POST['_cpf_ean'];
	$woocommerce_valid = $_POST['_cpf_valid'];
	$woocommerce_condition = $_POST['_cpf_condition'];
	$woocommerce_category = $_POST['_cpf_category'];


	if(isset($woocommerce_vendor))
		update_post_meta( $post_id, '_cpf_vendor', esc_attr($woocommerce_vendor));

	if(isset($woocommerce_brand))
		update_post_meta( $post_id, '_cpf_brand', esc_attr($woocommerce_brand));

	if(isset($woocommerce_mpn))
		update_post_meta( $post_id, '_cpf_mpn', esc_attr($woocommerce_mpn));
	
	if(isset($woocommerce_upc))
		update_post_meta( $post_id, '_cpf_upc', esc_attr($woocommerce_upc));

	if(isset($woocommerce_ean))
		update_post_meta( $post_id, '_cpf_ean', esc_attr($woocommerce_ean));

	if(isset($woocommerce_valid))
		update_post_meta( $post_id, '_cpf_valid', esc_attr($woocommerce_valid));

	if(isset($woocommerce_condition))
		update_post_meta( $post_id, '_cpf_condition', esc_attr($woocommerce_condition));

	if(isset($woocommerce_category))
		update_post_meta( $post_id, '_cpf_category', esc_attr($woocommerce_category));
}

/**
 * Create new fields for variations
 *
*/
function cpf_custom_variable_fields( $loop, $variation_id, $variation ) {

		//Added <br>s to the labels to correct a spacing issue that put the labels on the wrong input boxes -2015-05:KH

		// Variation Vendor field
		woocommerce_wp_text_input( 
			array( 
				'id'       => '_cpf_variable_vendor['.$loop.']', 
				'label'       => __( '<br>Vendor', 'woocommerce' ), 
				'placeholder' => 'Parent Vendor',
				//'desc_tip'    => 'true',
				//'description' => __( 'Enter the product Vendor here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_cpf_vendor', true),
				'wrapper_class' => 'form-row-first',
			)
		);



		// Variation Brand field
		woocommerce_wp_text_input( 
			array( 
				'id'       => '_cpf_variable_brand['.$loop.']', 
				'label'       => __( '<br>Brand', 'woocommerce' ), 
				'placeholder' => 'Parent Brand',
				//'desc_tip'    => 'true',
				//'description' => __( 'Enter the product Brand here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_cpf_brand', true),
				'wrapper_class' => 'form-row-first',
			)
		);
	
		// Variation MPN field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_cpf_variable_mpn['.$loop.']', 
				'label'       => __( '<br>MPN', 'woocommerce' ),
				'placeholder' => 'Manufacturer Product Number',
				//'desc_tip'    => 'true',
				//'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_cpf_mpn', true),
				'wrapper_class' => 'form-row-last',
			)
		);
		// Variation UPC field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_cpf_variable_upc['.$loop.']', 
				'label'       => __( '<br>UPC', 'woocommerce' ),
				'placeholder' => 'UPC',
				//'desc_tip'    => 'true',
				//'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_cpf_upc', true),
				'wrapper_class' => 'form-row-first',
			)
		);
		
		// Variation EAN field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_cpf_variable_ean['.$loop.']', 
				'label'       => __( '<br>EAN', 'woocommerce' ),
				'placeholder' => 'EAN',
				//'desc_tip'    => 'true',
				//'description' => __( 'Enter the product EAN here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_cpf_ean', true),
				'wrapper_class' => 'form-row-last',
			)
		);

		//  Variation Valid field
		woocommerce_wp_select(
			array( 
				'id'          => '_cpf_variable_valid['.$loop.']', 
				'label'       => __( 'Valid<br>', 'woocommerce' ), 
				'desc_tip'    => 'true',
				'description' => __( 'Select False to exclude this variation from the feed', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_cpf_valid', true),
				'wrapper_class' => 'form-row-first',
				'options'    => array(
					''		 => __( '', 'woocommerce'),
					'true'   => __( 'True', 'woocommerce' ),
					'false'  => __( 'False', 'woocommerce' ),				
				)
			)
		);
	
		//  Variation: Notes about this product
		woocommerce_wp_textarea_input(
			array( 
				'id'          => '_cpf_variable_description['.$loop.']', 
				'label'       => __( '<br>Description', 'woocommerce' ), 
				//'placeholder' => '', 
				'desc_tip'    => 'true',
				'wrapper_class' => 'form-row-full',
				'description' => __( 'Enter variant description (will override post-content)', 'woocommerce' ),
		 		'value'       => get_post_meta($variation->ID, '_cpf_description', true),
			)
		);

		// Condition Field
		woocommerce_wp_select(
			array( 
				'id'          		=> '_cpf_variable_condition', 
				'label'       		=> __( '<br>Condition', 'woocommerce' ), 
				'desc_tip'    		=> 'true',
				'description' 		=> __( 'Select the condition of this product', 'woocommerce' ),
				'value'       		=> get_post_meta( $post->ID, '_cpf_condition', true ),
				'options'    		=> array(
					'new'   		=> __( 'New', 'woocommerce' ),
					'used'  		=> __( 'Used', 'woocommerce' ),				
					'refurbished'  	=> __( 'Refurbished', 'woocommerce' ),				
				)
			)
		);

		// Category Field
		woocommerce_wp_text_input( 
			array(	
				'id'          => '_cpf_variable_category', 
				'label'       => __( '<br>Category', 'woocommerce' ), 
				'desc_tip'    => 'true',
				//'type'        => 'text',
				'value' 	  =>  get_post_meta( $post->ID, '_cpf_brand', true ),
				'description' => __( 'Enter the product category here.', 'woocommerce' )				
			)
		);
		

}

/**
 * Save new fields for variations
 *
*/
function cpf_save_custom_variable_fields( $post_id ) {
	
	if (isset( $_POST['variable_sku'] ) ) {

		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];
		
		$max_loop = max( array_keys( $_POST['variable_post_id'] ) );

		for ( $i = 0; $i <= $max_loop; $i++ ) {

	        if ( ! isset( $variable_post_id[ $i ] ) ) {
	          continue;
	        }

		// Vendor Field
		$_vendor = $_POST['_cpf_variable_vendor'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_vendor[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_vendor', stripslashes( $_vendor[$i]));				
			}
		//endfor;


		// Brand Field
		$_brand = $_POST['_cpf_variable_brand'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_brand[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_brand', stripslashes( $_brand[$i]));				
			}
		//endfor;
		
		// MPN Field
		$_mpn = $_POST['_cpf_variable_mpn'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_mpn[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_mpn', stripslashes( $_mpn[$i]));
			}
		//endfor;
		
		// UPC Field
		$_upc = $_POST['_cpf_variable_upc'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_upc[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_upc', stripslashes( $_upc[$i]));
			}
		//endfor;

		// EAN Field
		$_ean = $_POST['_cpf_variable_ean'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_ean[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_ean', stripslashes( $_ean[$i]));
			}

		// description Field
		$_descr = $_POST['_cpf_variable_description'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_descr[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_description', stripslashes( $_descr[$i]));
			}

		// Valid Field
		$_valid = $_POST['_cpf_variable_valid'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_valid[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_valid', stripslashes( $_valid[$i]));
				//update_post_meta( $variation_id, '_cpf_valid', "aha");
			}
		// Condition Field
		$_condition = $_POST['_cpf_variable_condition'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_condition[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_condition', stripslashes( $_condition[$i]));
				//update_post_meta( $variation_id, '_cpf_valid', "aha");
			}

		// Category Field
		$_category = $_POST['_cpf_variable_category'];
		//for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_category[$i] ) ) {
				update_post_meta( $variation_id, '_cpf_category', stripslashes( $_category[$i]));
				//update_post_meta( $variation_id, '_cpf_valid', "aha");
			}
		
		}
		
	}
		
}
