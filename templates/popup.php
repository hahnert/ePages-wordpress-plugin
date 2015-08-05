<script type="text/javascript">
  window.ePagesPluginBaseUrl = '<?php echo $epages_plugin_url; ?>';
  window.ePagesShopUrl = '<?php echo $epages_api_url; ?>';

  window.ePagesHttpHeaders = {
    Authorization: '<?php echo $epages_api_http_options["headers"]["Authorization"]; ?>',
    Accept: '<?php echo $epages_api_http_options["headers"]["Accept"]; ?>'
  };
</script>

<div id="epages-popup-content">
  <div class="media-modal wp-core-ui">
    <div class="media-modal-content">
      <a class="media-modal-close" href="#" title="Close"><span class="media-modal-icon"></span></a>
      <div class="media-frame wp-core-ui hide-router">
        <div class="media-frame-menu">
          <div class="media-menu">
            <a href="#" class="media-menu-item" data-content="product-settings">Product settings</a>
            <a href="#" class="media-menu-item" data-content="appearance">Appearance</a>
          </div>
        </div>

        <div class="media-frame-title product-settings">
          <h1>Product settings <span class="dashicons dashicons-arrow-down"></span></h1>
        </div>

        <div class="media-frame-title appearance">
          <h1>Appearance<span class="dashicons dashicons-arrow-down"></span></h1>
        </div>

        <div class="media-frame-content product-settings">
          <h2>Which products do you want to display?</h2>
          <label>
            <input type="radio" name="products" value="all" checked="checked" class="epages-all-products-radio-button">
            Show all products
          </label>
          <label>
            <input type="radio" name="products" value="categories" class="epages-categories-radio-button">
            All products from selected category
            <img src="<?php echo $epages_plugin_url . "/assets/images/spinner.gif"; ?>" class="epages-categories-spinner">
          </label>

          <ol class="epages-categories-container"></ol>
        </div>

        <div class="media-frame-content appearance">
          <p>Appearance ...</p>
        </div>

        <div class="media-frame-toolbar">
          <div class="media-toolbar">
            <div class="media-toolbar-secondary">
              <div class="store-url"><?php echo get_option("epages_api_url"); ?></div>
              <div class="settings-link">
                <a target="_blank" href="admin.php?page=epages_options_page">Plugin settings</a>
              </div>
            </div>

            <div class="media-toolbar-primary add-store">
              <a href="#" id="epages-save-button" class="button media-button button-primary button-large media-button-select">Save</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="media-modal-backdrop"></div>
</div>
