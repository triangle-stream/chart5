<div class="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center p-0 mt-2">
				<a href="https://music.apple.com/subscribe?itsct=music_box_badge&amp;itscg=30200&amp;at=1010lLa5&amp;app=music&amp;ls=1" style="display: inline-block; overflow: hidden; border-radius: 0px; width: 728px; height: 90px;"><img src="https://tools.applemediaservices.com/api/badges/apple-music-banner/iphone-gradient-single-title-v4/it-it?size=728x90" alt="Try Apple Music" style="border-radius: 0px; width: 728px; height: 90px;"></a>
                <div class="clearfix"></div>
			</div>
			<div class="col-8 mt-2 float-start">
				<div class="theme-breadcrumb__Wrapper theme-breacrumb-area mb-3 mt-0">
			        <div class="container">
			            <div class="row justify-content-center">
			                <div class="col-lg-12 p-0"> 
								<h1 class="theme-breacrumb-title text-start">
									{$MenuTitle.XML}
								</h1>
			                </div>
			            </div>
			        </div>
			    </div>
			    <div class="desc-category">
			    	$Content
			    </div>
			    <div class="main-content-inner category-layout-one theme-post-block-three-wrapper theme-post-block-blog-wrapper">
			    <% loop $Menu(1) %>
			    	<article class="post-block-three-wrap post-{$Pos} type-post format-standard has-post-thumbnail hplink">
						<div class="post-block-item-three">
							<div class="news-post-grid-thumbnail">
								<a href="{$Link}" class="news-post-grid-thumbnail-wrap">
									<img src="{$Image.ResizedImage(387,218).AbsoluteURL}" alt="{$Image.Title}" title="{$Image.Title}" class="img-fluid">
								</a>
							</div>
							<div class="grid-content-top post-block-item-three-inner has-fblog">
								<div class="blog-post-meta-items post-block-meta-top"> 
									<h2 class="post-title">
										<a href="{$Link}" sl-processed="1">Scopri la classifica <br />{$Title}</a>
									</h2> 
								</div>
							</div>
					</article>
			    <% end_loop %>
			    </div>
		    	<%-- <div class="content">
		    		$Content
					$Form
					$CommentsForm
			    </div> --%>
			</div> 
		    <div class="col-4 mt-2 float-start">
		    	<% include SideBar %>
		    </div>
		</div>
	</div>
</div>