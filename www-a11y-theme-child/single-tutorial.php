<?php 
/* Template Name: Tutorial Per Page */

get_header();
$home = home_url();

$tutorial = get_post(get_the_ID(), ARRAY_A);

//$date = get_the_modified_date($format = '', get_the_ID());
$date = get_the_date($format = '', get_the_ID());

$pages = get_post_meta(get_the_ID(), 'pagina', false);

$total_pages = count($pages);

$view = null;
$current_page = null;

if(isset($_GET["pagina"])){
    $current_page = $_GET["pagina"];    
}

if(isset($_GET["view"])){
    $view = $_GET["view"];    
}

$current_page = intval($current_page);
$tutorial_full = 0;

if($view != null){
    $tutorial_full = 1;
}

if($current_page == null || $current_page > $total_pages){
    $current_page = 1;
}

$icon = get_post_meta(get_the_id(),'icon');
?>

<main class="site-main" id="main">
    <div id="page-wrapper" class="wrapper">
        <div id="content" class="container" tabindex="-1">
            <div class="page-header col">
                <nav aria-label="Você está aqui">
                    <ol class="breadcrumb mb-5">
                        <li class="breadcrumb-item">
                            <a href="<?= site_url(); ?>">Início</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= site_url("tutoriais") ?>">Tutoriais</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= the_title(); ?>
                        </li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="<?= site_url("tutoriais")?>" class="version" title="Consulte todos os artigos classificados nesta categoria">Tutoriais</a>
                    </div>
                    <div class="col-12 col-lg-8<?php echo has_excerpt() ? '' : ' align-self-end'; ?>">
                        <h1><?php the_title(); ?></h1>
                        <?php
                        if ( has_excerpt() ) : ?>
                            <div class="excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                        <div class="featured-image">
                            <?php
                                // Verifica se a Publicação tem feature image ou se aplica o ACF do icon de destaque (HTML)
                                if(has_post_thumbnail()) {
                                    the_post_thumbnail();
                                } elseif(get_field('ama_icon_destaque')) {
                                    echo get_field('ama_icon_destaque');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
            <input type="number" value="<?php echo $tutorial_full; ?>" id="full" name="full" hidden/>
        <input type="number" value="<?php echo $current_page; ?>" name="current_page" id="current_page" hidden>        
        <section id="tutorial">
            <div class="container">
                <div class="d-flex justify-content-start gap-5" id="tutorial-content">
                    <div class="index col-12 col-md-4 bg-light p-3 p-lg-4" id="index_tutorial_full">
                        <div class="sticky-top" id="index_sticky">
                            <div class="h3 mb-3">Índice de conteúdos</div>
                            <nav aria-label="índice de conteúdos do tutorial">
                                <ul class="d-lg-block list-unstyled" id="index_pages">
                                    <?php 
                                        $x=1;
                                        foreach ($pages as $page){
                                            if($x == $current_page){ 
                                                if($total_pages > 1){?>
                                                <li class="page page-active" aria-current="true">
                                                    <div class="top">
                                                        <button class="page-title" type="button" aria-expanded="true">
                                                            <span class="page_title_btn">Pág. <?php echo $x; ?>: <?php echo $page['name']; ?></span>
                                                            <span aria-hidden="true" class="icon-arrow-drop d-flex align-items-center"></span>
                                                        </button>
                                                    </div>
                                                    <div class="border-pages"></div>
                                                <?php } 
                                                else{?>
                                                <li>
                                                    <div class="single_page"></div>
                                                <?php } ?>
                                                    <ul class="topics list-unstyled" id="topic_page<?php echo $x; ?>">
                                                        <?php 
                                                            for($y=0;$y<count($page['topico']);$y++){
                                                                if($y==0){ ?>
                                                                    <li class="topic topic-active" aria-current="true">
                                                                        <span><a href="#page<?php echo $current_page;?>_topic_<?php echo $y+1;?>" data-page="<?php echo $x; ?>"><?php echo $page['topico'][$y]['name'];?></a></span>
                                                                    </li>
                                                            <?php }
                                                                else{?>
                                                                    <li class="topic">
                                                                        <span><a href="#page<?php echo $current_page;?>_topic_<?php echo $y+1;?>" data-page="<?php echo $x; ?>"><?php echo $page['topico'][$y]['name'];?></a></span>
                                                                    </li>
                                                            <?php } 
                                                            } 
                                                        ?>
                                                    </ul>
                                                </li>
                                        <?php }
                                            else{ ?>
                                                <li class="page">
                                                    <div class="top">
                                                        <button class="page-title" type="button" aria-expanded="false">
                                                            <span class="page_title_btn">Pág. <?php echo $x; ?>: <?php echo $page['name']; ?></span>
                                                            <span aria-hidden="true" class="icon-arrow-drop d-flex align-items-center"></span>
                                                        </button>
                                                    </div>
                                                    <div class="border-pages"></div>
                                                    <ul class="topics" id="topic_page<?php echo $x; ?>">
                                                        <?php 
                                                            for($y=0;$y<count($page['topico']);$y++){ ?>
                                                                <li class="topic">
                                                                    <span><a href="#page<?php echo $x; ?>_topic_<?php echo $y+1?>" data-page="<?php echo $x; ?>"><?php echo $page['topico'][$y]['name'];?></a></span>
                                                                </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                        <?php }
                                            $x++;
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="col-12 col-md-8" id="tutorial-full">
                    <?php 
                        if($tutorial_full == 0){?>
                            <div class="tutorial_page">
                                <div class="tutorial-text">
                                    <h2><?php echo $pages[$current_page-1]['name']?></h2>
                                    <?php
                                        $topics = $pages[$current_page-1]['topico'];
                                        $count = 1;
                                        foreach($topics as $topic){
                                            //$content = str_replace("&nbsp;", "</p><p>", $topic['conteudo']);
                                            $content = wpautop( $topic['conteudo'] );
                                            //echo $content;
                                            ?>
                                            <h3 id="page<?php echo $current_page;?>_topic_<?php echo $count;?>"><?php echo $topic['name']; ?></h3> 
                                            <?php echo $content; ?>
                                        <?php 
                                            if($count<count($topics)){?>
                                                <hr aria-hidden="true"/> 
                                        <?php }
                                            $count++;
                                        }
                                    ?>
                                </div>
                            </div>
                    <?php } 
                        else{ 
                            $aux = 1;
                            foreach ($pages as $page) { ?>
                                <div class="tutorial_page">
                                    <div class="d-flex justify-content-between align-items-center tutorial_page_top">
                                        <h2 id="page_<?php echo $aux; ?>">Página <?php echo $aux; ?></h2>
                                        <div class="d-fex align-items-center justify-content-between view_per_page" data-page="<?php echo $aux; ?>">
                                        <?php 
                                            if($aux == 1){?>
                                                <span>Ver página a página</span>
                                        <?php } ?>
                                            <div aria-hidden="true" class="icon-pages"></div>
                                        </div>
                                    </div>
                                    <div class="tutorial-text">
                                        <h3><?php echo $page['name'];?></h3>
                                        <?php
                                            $topics = $page['topico'];
                                            $count = 1;
                                            foreach($topics as $topic){
                                                $content = wpautop( $topic['conteudo'] );
                                                ?>
                                                <h4 id="page<?php echo $aux;?>_topic_<?php echo $count;?>"><?php echo $topic['name']; ?></h4>  
                                                <?php echo $content; ?>
                                            <?php 
                                                if($count<count($topics)){?>
                                                    <hr aria-hidden="true"/> 
                                            <?php }
                                                $count++;
                                            }
                                        ?>
                                    </div>
                                </div>
                    <?php $aux++;
                            } 
                        }
                    ?>       
                    <div class="d-block d-sm-flex justify-content-end mt-5">
                        <div class="p2">
                            <span class="d-sm-block d-none">Última atualização:<br class="d-sm-none d-block"/> <?php echo $date; ?></span>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row no-gutters" id="tutorial-pagination">
                <?php 
                    if($tutorial_full == 0){ ?>
                        <div class="col-sm-6" id="previous-page">
                        <?php 
                            if($current_page != 1){?>
                                <span>Página anterior</span><br/>
                                <h2>Página <?php echo $current_page-1; ?>:</h2>
                                <h3><a href="?pagina=<?php echo $current_page-1; ?>"><?php echo $pages[$current_page-2]['name']; ?></a></h3>
                        <?php } ?>
                        </div>
                        <div class="col-sm-6" id="next-page">
                        <?php 
                            if($current_page != $total_pages){?>
                                <span>Página seguinte</span><br/>
                                <h2>Página <?php echo $current_page+1; ?>:</h2>
                                <h3><a href="?pagina=<?php echo $current_page+1; ?>"><?php echo $pages[$current_page]['name']; ?></a></h3>
                        <?php } ?>
                        </div>
                    <?php } ?>
                    <?php
                    if($total_pages > 1){ 
                        if($tutorial_full == 0){?>
                            <button class="btn_tutorial" id="tutorial1" data-action="full" type="button">
                                Ver Tutorial completo
                                <span aria-hidden="true" class="icon-button-list"></span>
                            </button>
                    <?php } 
                      else{?>
                            <button class="btn_tutorial" id="tutorial1" data-action="per_page" type="button">
                                Ver tutorial por página
                                <span aria-hidden="true" class="icon-pages"></span>
                            </button>
                    <?php } 
                    } ?>
                      
                    
                </div>
            </div>
        </section>  
            </div>
        </div>
    </div>
        
        
  
</main>

  
<?php get_footer();?>

    <script>
        $(document).ready(function () {
            app.init();
            app.shareIcons();
            app.tutorialIndex();
            app.tutorialPages();
            //app.highlightTopic();
            app.changeTutorialView();
            app.changeActivePage();
            app.socialSharing();
            app.tableTutorial();
            app.breadcrumbsMobile();
        });     
    </script>

</body>
</html>