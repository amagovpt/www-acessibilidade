  <?php
  /**
   * AMA Card Template.
   *
   * @var  array  $attributes Block attributes.
   * @var  array  $block Block data.
   * @var  string $context Preview context [editor,frontend].
   */

  add_filter( $block["slug"]."/frontend_allow_wrapper", "__return_false" );

  $wrapper_classes = $attributes["className"] . " " . $attributes["blockUniqueClass"];

  if(array_key_exists("card_height", $attributes) && $attributes["card_height"] !== "") {
      $wrapper_classes .= " ".$attributes["card_height"];
  }


  $card_top_classes = [];

  // Card TOP background color
  if(!empty($attributes["card_top_bg_color"])) {
      $card_top_classes[] = "has-background";
      $card_top_classes[] = "has-".$attributes["card_top_bg_color"]["slug"]."-background-color";
  }

  // Card TOP background color
  if(!empty($attributes["card_top_txt_color"])) {
      $card_top_classes[] = "has-text-color";
      $card_top_classes[] = "has-".$attributes["card_top_txt_color"]["slug"]."-color";
  }

  // Use image as card top background
  if($attributes["card-background"]) {
      $card_top_classes[] = "with-img-bg";
  }

  $card_top_classes = implode(" ", $card_top_classes);

  // Card BODY classes
  $card_body_classes = [];

  // Card BODY background color
  if(!empty($attributes["card_body_bg_color"])) {
      $card_body_classes[] = "has-background";
      $card_body_classes[] = "has-".$attributes["card_body_bg_color"]["slug"]."-background-color";
  }

  // Card BODY text color
  if(!empty($attributes["card_body_txt_color"])) {
      $card_body_classes[] = "has-text-color";
      $card_body_classes[] = "has-".$attributes["card_body_txt_color"]["slug"]."-color";
  }

  $card_body_classes = implode(" ", $card_body_classes);

  // Card FOOTER classes
  $card_footer_classes = [];

  // Card FOOTER background color
  if(!empty($attributes["card_footer_bg_color"])) {
      $card_footer_classes[] = "has-background";
      $card_footer_classes[] = "has-".$attributes["card_footer_bg_color"]["slug"]."-background-color";
  }

  // Card FOOTER text color
  if(!empty($attributes["card_footer_txt_color"])) {
      $card_footer_classes[] = "has-text-color";
      $card_footer_classes[] = "has-".$attributes["card_footer_txt_color"]["slug"]."-color";
  }

  $card_footer_classes = implode(" ", $card_footer_classes);

  // Tamanho de imagem

  // Adiciona o atributo width na tag <img> conforme o tamanho da imagem selecionado no bloco(defaults do WordPress).
  $width = "";
  if(array_key_exists("tamanho_imagem", $attributes) && $attributes["tamanho_imagem"] !== "") {
      switch ($attributes['tamanho_imagem']) {
          case '60':
              $width = 'width="60"';
              break;
          case '80':
              $width = 'width="80"';
              break;
          case '100':
              $width = 'width="100"';
              break;
          case '150':
              $width = 'width="150"';
              break;
          case '300':
              $width = 'width="300"';
              break;
          case '1024':
              $width = 'width="1024"';
              break;
          default:
              $width = '';
              break;
      }
  }

  ?>
  <div class="ama-card wp-block-lazyblock-ama-card <?= $wrapper_classes; ?>">
      <div class="card-top <?= $card_top_classes ?>">
          <?php
          if(array_key_exists("card_image", $attributes) && array_key_exists('card-background', $attributes)) { ?>
              <img decoding="async" alt="<?= ( (! array_key_exists('imagem_alt', $attributes) && $attributes['imagem_alt'] !== '') ? $attributes['imagem-alt'] : '') ?>" src="<?= $attributes["card_image"]["url"]?>" class="img-fluid"<?= (($attributes["card-background"]) ? "" : " ".$width) ?>>
          <?php } ?>

          <?php
          // Card title
            if(array_key_exists("title", $attributes) && $attributes["title"] !== "" && $attributes["card-background"]) { ?>
                <h3><?= $attributes["title"]; ?></h3>
          <?php } ?>
      </div>
      <div class="card-body <?= $card_body_classes; ?>">
          <InnerBlocks />
      </div>
    <?php

    // Ligação
    if(
        (array_key_exists("link_url", $attributes) && $attributes["link_url"]!== "")
        &&
        (array_key_exists("link_text", $attributes) && $attributes["link_text"]!== "" )
    ) { ?>
      <div class="card-footer <?= $card_footer_classes; ?>">
        <a href="<?= $attributes["link_url"]; ?>" class="ama btn btn-primary mx-auto">
            <?= $attributes["link_text"]; ?>
            <span aria-hidden="true" class="icon-arrow-bullets"></span>
        </a>
      </div>
            <?php } ?>
  </div>

