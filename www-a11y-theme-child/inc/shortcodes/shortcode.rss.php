<?php
function get_rss($atts): ?string
{
    setlocale(LC_TIME, 'pt_PT', 'pt_PT.utf-8', 'pt_PT.utf-8', 'portuguese');
    $i=0;
    $result = '';
    $url = strval($atts["url"]);
    $rss_name = $atts["rss_name"];

    // Suppress libxml errors
    libxml_use_internal_errors(true);

    // Read XML file
    $feeds = simplexml_load_file($url);

    // Error parsing
    if(!$feeds) {
        return '';
    }

    if(!empty($feeds)){
        $result .= '<ul class="list-group no-gutters press_list d-lg-block collapse" lang="en">';
        if(is_array($feeds)) {
            if(array_key_exists('channel', $feeds)){
                foreach($feeds->channel->item as $item) {
                    $title = $item->title;
                    $link = $item->link;
                    $postDate = $item->pubDate;
                    $pubDate = strftime('%d de %B de %Y', strtotime($postDate));
                    $new_date = get_string_between($pubDate, "de ", " ");
                    if($i>=3) break;
                    $result .= '<li class="list-group-item border-0">';
                    $result .= '<div class="icon-arrow-bullets list_arrow_link" aria-hidden="true"></div>';
                    $result .= '<div class="list_link">
								<a class="d-block" target="_blank" href="'.$link.'"><em lang="en">'.$title.'</em></a>
								<span><em lang="en">'.$rss_name.'</em>, '.$new_date.'</span>
							</div>';
                    $result .= '</li>';
                    $i++;
                }
            }
            if(array_key_exists('entry', $feeds)){
                foreach($feeds->entry as $item) {
                    $title = $item->title;
                    $link = $item->id;
                    $postDate = $item->published;
                    $pubDate = strftime('%d de %B de %Y', strtotime($postDate));
                    $new_date = get_string_between($pubDate, "de ", " ");
                    if($i>=3) break;
                    $result .= '<li class="list-group-item border-0">';
                    $result .= '<div class="icon-arrow-bullets list_arrow_link" aria-hidden="true"></div>';
                    $result .= '<div class="list_link">
								<a class="d-block" target="_blank" href="'.$link.'"><em lang="en">'.$title.'</em></a>
								<span><em lang="en">'.$rss_name.'</em>, '.$new_date.'</span>
							</div>';
                    $result .= '</li>';
                    $i++;
                }
            }
        }

    }
    $result .= '</ul>';
    return $result;
}
add_shortcode('rss', 'get_rss');