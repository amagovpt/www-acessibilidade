<?php
  /**
   * AMA Card Template.
   *
   * @var  array  $attributes Block attributes.
   * @var  array  $block Block data.
   * @var  string $context Preview context [editor,frontend].
   */
 
  add_filter( $block["slug"]."/frontend_allow_wrapper", "__return_false" );
  $svg = file_get_contents($attributes["icon"]["url"]);

  $attributesOfSvg = ['stroke','fill', 'height', 'width'];

  foreach ($attributesOfSvg as $attr) {
    $pattern = '/\s*' . preg_quote($attr, '/') . '\s*=\s*(".*?"|\'.*?\'|[^"\'>\s]+)/i';
    $svg = preg_replace($pattern, '', $svg);
  }

  $svg = preg_replace('/\s{2,}/', ' ', $svg);

// Card BODY classes
  $card_text_classes = [];
  $card_bg_classes = [];
  $tag="div";
  if(empty($attributes["html_tag"])) {
      $tag = "div";
  }
  ?>
<div class="step-card-container">               
    <div class="step-card-icon-container <?= $attributes["card_color"]["value"] ?>">
        <?= $svg ?>
    </div>
    <h3 class="h4"><a href="<?=$attributes["link"];?>"><?= $attributes["title"]; ?></a></h3>
</div>
     

 

