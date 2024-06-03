<footer class="theme-footer-wrapper theme_footer_Widegts hav-footer-topp">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer-top-wrapper">
                        <div class="footer-top-logo">
                            <a href="{$SiteConfig.LogoLink}" class="logo" sl-processed="1">
                                <img alt="Billboard Italia" width="184" height="38" data-src="{$SiteConfig.LogoURL}" class="img-fluid ls-is-cached lazyloaded" src="{$SiteConfig.LogoURL}">
                            </a>
                        </div>         
                        <div class="footer-socials">                           
                            <a href="{$SiteConfig.InstagramLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-instagram"></i></a>                             
                            <a href="{$SiteConfig.TikTokLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-tiktok"></i></a>                           
                            <a href="{$SiteConfig.YoutubeLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-youtube"></i></a>          
                            <a href="{$SiteConfig.FacebookLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-facebook"></i></a>          
                            <a href="{$SiteConfig.FlipboardLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-flipboard"></i></a>          
                            <a href="{$SiteConfig.GoogleNewsLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-google"></i></a>
                            <a href="{$SiteConfig.TwitchLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-twitch"></i></a>
                            <a href="{$SiteConfig.SpotifyLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-spotify"></i></a>
                            <a href="{$SiteConfig.PinterestLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-pinterest"></i></a>
                            <a href="{$SiteConfig.TelegramLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-telegram"></i></a>
                            <a href="{$SiteConfig.TwitterLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-x-twitter"></i></a>
                            <a href="{$SiteConfig.LinkedinLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-linkedin"></i></a>                      
                        </div> 
                    </div>
                </div>
                        
                <div class="col-lg-6 col-md-6"> </div>
                    
            </div>
        </div>
    </div>

    <div class="footer-border"></div>
        
    <div class="footer-main">
        <div class="container">
            <div class="row custom-gutter">
                <div class="col-lg-2 col-md-6 col-sm-6 footer_one_Widget">
                    <div id="block-17" class="footer-widget widget widget_block widget_media_image">
                        <figure class="wp-block-image size-full is-style-default">
                            <a href="https://billboard.it/prenota-la-tua-copia/" sl-processed="1">
                                <img width="178" height="242" alt="{$SiteConfig.Copertina.Title}" data-src="{$SiteConfig.Copertina.AbsoluteLink}" src="{$SiteConfig.Copertina.AbsoluteLink}" class="img-fluid ls-is-cached lazyloaded">
                            </a>
                        </figure>
                    </div>               
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 footer_two_Widget">
                    <div id="nav_menu-4" class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-title">BILLBOARD</h4>
                        <div class="menu-billboard-footer-nav-container">
                            <ul id="menu-billboard-footer-nav" class="menu">
                                <li id="menu-item-112024" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-112024"><a href="https://billboard.it/category/news/" sl-processed="1">News</a></li>
                                <li id="menu-item-130625" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-130625"><a href="https://billboard.it/category/top-story/" sl-processed="1">Top Story</a></li>
                                <li id="menu-item-112025" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-112025"><a href="https://billboard.it/category/musica/" sl-processed="1">Musica</a></li>
                                <li id="menu-item-128408" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-128408"><a href="https://billboard.it/category/interviste/" sl-processed="1">Interviste</a></li>
                                <li id="menu-item-112026" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-112026"><a href="https://billboard.it/category/eventi/" sl-processed="1">Eventi</a></li>
                                <li id="menu-item-112027" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-112027"><a href="https://billboard.it/category/cultura/" sl-processed="1">Cultura</a></li> 
                                <li id="menu-item-112029" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-112029"><a href="https://billboard.it/category/english/" sl-processed="1">English</a></li>
                            </ul>
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 footer_three_Widget">
                    <div id="nav_menu-7" class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-title">CHARTS</h4>
                        <div class="menu-classifiche-container">
                            <ul id="menu-classifiche" class="menu">
                                <% loop $Menu(1) %>
                                <li class="pb-1 flink">
                                    <% if $isCurrent %>
                                    <a href="{$Link}" class="current">{$MenuTitle.XML}</a>
                                    <% else %>
                                    <a href="{$Link}" class="footer-link-{$Pos}">{$MenuTitle.XML}</a>
                                    <% end_if %>
                                </li>
                                <% end_loop %>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 footer_four_Widget">
                    <div id="nav_menu-8" class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-title">PRO</h4>
                        <div class="menu-pro-nav-container">
                            <ul id="menu-pro-nav" class="menu">
                                <li id="menu-item-128409" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-128409"><a href="https://billboard.it/category/magazine/" sl-processed="1">Magazine</a></li>
                                <li id="menu-item-128410" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-128410"><a href="https://billboard.it/category/pro/" sl-processed="1">Articoli PRO</a></li>
                                <li id="menu-item-111160" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-111160"><a href="https://billboard.it/login/" sl-processed="1">Accedi</a></li>
                                <li id="menu-item-111161" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-111161"><a href="https://billboard.it/account/" sl-processed="1">Iscriviti</a></li>
                                <li id="menu-item-111162" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-111162"><a href="https://billboard.it/account/il-tuo-profilo/" sl-processed="1">Il tuo profilo</a></li>
                                <li id="menu-item-111163" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-111163"><a href="https://billboard.it/account/livelli/" sl-processed="1">Abbonamenti</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 footer_five_Widget">
                    <div id="nav_menu-2" class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-title">INFO</h4>
                        <div class="menu-footer-container">
                            <ul id="menu-footer" class="menu">
                                <li id="menu-item-100546" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-100546"><a href="https://billboard.it/newsletter/" sl-processed="1">Newsletter</a></li>
                                <li id="menu-item-20468" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20468"><a href="https://billboard.it/contattaci/" sl-processed="1">Contattaci</a></li>
                                <li id="menu-item-38261" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-38261"><a rel="privacy-policy" href="https://billboard.it/privacy/" sl-processed="1">Privacy Policy</a></li>
                                <li id="menu-item-38260" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38260"><a href="https://billboard.it/tos/" sl-processed="1">Termini di servizio</a></li>
                            </ul>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 text-center">
                    <p class="copyright-text">
                       2017 - {$Now.Year} {$SiteConfig.FooterText.RAW}                       
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>