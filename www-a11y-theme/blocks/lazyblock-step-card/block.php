<?php
  /**
   * AMA Step Card Template.
   *
   * @var  array  $attributes Block attributes.
   * @var  array  $block Block data.
   * @var  string $context Preview context [editor,frontend].
   */

  add_filter( $block["slug"]."/frontend_allow_wrapper", "__return_false" );

  // O SVG é lido do disco (anexo da biblioteca de média), nunca de um URL remoto.
  $svg       = '';
  $icon      = $attributes["icon"] ?? [];
  $icon_path = !empty($icon["id"]) ? get_attached_file((int) $icon["id"]) : '';

  if (!$icon_path && !empty($icon["url"])) {
    $uploads = wp_get_upload_dir();
    if (str_starts_with($icon["url"], $uploads["baseurl"] . '/')) {
      $icon_path = $uploads["basedir"] . substr($icon["url"], strlen($uploads["baseurl"]));
    }
  }

  if ($icon_path && str_ends_with(strtolower($icon_path), '.svg') && is_readable($icon_path) && !str_contains($icon_path, '..')) {
    $svg = (string) file_get_contents($icon_path);
  }

  // Remove scripts, eventos e links javascript: do SVG
  $svg = preg_replace('#<(script|foreignObject)\b[^>]*>.*?</\1\s*>#is', '', $svg);
  $svg = preg_replace('#\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $svg);
  $svg = preg_replace('#(href\s*=\s*["\']?)\s*javascript:[^"\'\s>]*#i', '$1#', $svg);

  $attributesOfSvg = ['stroke','fill', 'height', 'width'];

  foreach ($attributesOfSvg as $attr) {
    $pattern = '/\s*' . preg_quote($attr, '/') . '\s*=\s*(".*?"|\'.*?\'|[^"\'>\s]+)/i';
    $svg = preg_replace($pattern, '', $svg);
  }

  $svg = preg_replace('/\s{2,}/', ' ', $svg);
  ?>
<div class="step-card-container">
    <div class="step-card-icon-container <?= esc_attr($attributes["card_color"]["value"] ?? '') ?>">
        <?= $svg ?>
    </div>
    <h3 class="h4"><a href="<?= esc_url($attributes["link"] ?? ''); ?>"><?= esc_html($attributes["title"] ?? ''); ?></a></h3>
</div>
