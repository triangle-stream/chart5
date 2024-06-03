<header id="theme-header-one" class="theme_header__main header-style-one">
    <div class="theme-logo-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="header_panel_nav_wrap">
                        <div class="lv-header-bar-1">
                            <!-- <div class="panel-bar-box">
                                <span class="lv-header-bar-line lv-header-bar-line-1"></span>
                                <span class="lv-header-bar-line lv-header-bar-line-2"></span>
                                <span class="lv-header-bar-line lv-header-bar-line-3"></span>
                            </div> -->
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="logo theme-logo">
                        <a href="{$SiteConfig.LogoLink}" class="logo" sl-processed="1">
                        	<img class="img-fluid billboard-logo" src="{$SiteConfig.LogoURL}" alt="Billboard Italia" width="184" height="38">
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="header-right-content text-end">
                    	<div class="header-three-btn-one">
							<a href="https://billboard.it/login/" sl-processed="1">Accedi</a>
						</div>
						<div class="header-three-btn-two">
							<a href="https://billboard.it/account/livelli/" sl-processed="1">Abbonati</a>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="theme-navigation-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10">
                    <div class="nav-menu-wrapper">
                        <div class="nav-wrapp-one">
                            <div class="mainmenu">
                                <% include Navigation %>
							</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header-socials">  
                        <a href="{$SiteConfig.InstagramLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-instagram"></i></a> 
                        <a href="{$SiteConfig.FacebookLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-facebook"></i></a> 
                        <a href="{$SiteConfig.TikTokLink}" target="_blank" class="social-list__link" title="Seguici sui social" sl-processed="1"><i class="fab fa-tiktok"></i></a> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</header>