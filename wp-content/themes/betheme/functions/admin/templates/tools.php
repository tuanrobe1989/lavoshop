<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}
?>

<div id="mfn-dashboard" class="wrap about-wrap">

	<?php include_once get_theme_file_path('/functions/admin/templates/parts/header.php'); ?>

	<div class="dashboard-tab tools">

		<div class="col col-fw">

			<h3 class="primary"><?php esc_html_e( 'Tools', 'mfn-opts' ); ?></h3>

			<div class="row">

				<div class="label">
					<h4>Regenerate CSS</h4>
				</div>

				<div class="content">
					<a data-nonce="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>" href="#" class="button button-secondary mfn-regenerate-css">Regenerate files</a>
				</div>

				<div class="description">
					<p>Some Builder styles are saved in CSS files in the uploads folder and database. Recreate those files and settings.</p>
				</div>

			</div>

		</div>

	</div>

</div>
