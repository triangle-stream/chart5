<div class="container">
  	<div class="row">
	    <% if $Week %>
	      	<% loop $SingleClassifica($Week) %>
	      		<!-- pos {$rank} -->
                <div class="col-12 p-0 m-0 mb-3 chart-row chart-row-n{$rank} <% if $rank == 1 || $genre_rank == 1 %>d-none<% end_if %>"> 

                    <div class="col-2 p-0 m-0 float-start">
                        <div class="col-12 p-0">
                            <div id="chart-actual-position{$rank}" class="chart-position">
                                <% if $genre_rank > 0 %>
			                    	{$genre_rank}
			                  	<% else %>
			                    	{$rank}
			                  	<% end_if %> 
                            </div>
                        </div>
                    </div>

                    <div class="col-10 p-0 m-0 float-start">
                        <div class="col-2 p-0 float-start d-none d-lg-block position-relative">
                        	<% if $genre_rank > 0 %>
						  		<% if $last_week > $genre_rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress up-green"> 
		                                <i class="fa fa-arrow-up fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week < $genre_rank && $last_week != 0 %>
						    		<div id="chart-arrow{$rank}" class="chart-progress down-red"> 
		                                <i class="fa fa-arrow-down fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week == $genre_rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress right-grey"> 
		                                <i class="fa fa-arrow-right fa-x2"></i> 
		                            </div> 
						  		<% else_if $last_week == 0 %>
						    		<div id="chart-new{$rank}" class="chart-new">
		                            	<img data-src="/chart5/img/stella_chart.svg" width="30" height="30" alt="NEW" loading="lazy" class="img-fliud lazyload">
		                            </div>
						  		<% end_if %>
							<% else %>
						  		<% if $last_week > $rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress up-green"> 
		                                <i class="fa fa-arrow-up fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week < $rank && $last_week != 0 %>
						    		<div id="chart-arrow{$rank}" class="chart-progress down-red"> 
		                                <i class="fa fa-arrow-down fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week == $rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress right-grey"> 
		                                <i class="fa fa-arrow-right fa-x2"></i> 
		                            </div> 
							  	<% else_if $last_week == 0 %>
							    	<div id="chart-new{$rank}" class="chart-new">
		                            	<img data-src="/chart5/img/stella_chart.svg" width="30" height="30" alt="NEW" loading="lazy" class="img-fliud lazyload">
		                            </div>
						  		<% end_if %>
							<% end_if %> 

                            <% if $artworkUrl100 %>
	                            <div class="chart-image ci-{$rank}">
	                                <div class="over-image"></div>
	                            	<img data-src="{$artworkUrl100}" title="{$title_single}"  alt="{$title_single}" width="100" height="100" loading="lazy" class="img-fliud lazyload">
	                            </div>
                            <% else %>
	                            <div class="chart-image no-chart-image ci-{$rank}">

	                            </div>
                            <% end_if %>
                        </div>
                        <div class="col-10 float-start pt-0 pb-0 position-relative">
                            <div class="chart-content float-start">
                                <h3 class="chart-song-title">{$title_single}</h3>
                                <h5 class="chart-song-author">{$artist_name}</h5>
                                
		          				<% if $artworkUrl100 %>
	                                <ul class="list-inline listenOn">
	                                    <li class="list-inline-item"><a href="{$trackViewUrl}&at=1010lLa5" class="btn-apple-music" title="Ascolta su Apple Music" target="_blank" rel="noopener"></a></li>
				          				<li class="list-inline-item"><a href="{$trackViewUrl}&at=1010lLa5&app=itunes" class="btn-itunes" title="Compra il brano su iTnues" target="_blank" rel="noopener"></a></li>
	                                </ul>
                                <% end_if %>

                                <div title="Maggiori Info su {$title_single} - {$artist_name}" class="infoChart" data-bs-toggle="collapse" href="#chart-info-{$rank}" data-target="#chart-info-{$rank}" aria-expanded="false" aria-controls="chart-info-{$rank}">
		                  			<i class="fa fa-info-circle fa-fw fa-lg grey"></i>
		                  		</div>

                            </div>
                        </div>
                        <div class="w100"></div>
                    </div> 

                    <div class="w100"></div>
                    <div class="clearfix"></div>

                    <div class="collapse top-shadow col-12 p-0 m-0" id="chart-info-{$rank}">
                        <div class="col-12 mt-3 mb-3 p-0 pt-2 pb-2 chart-moreInfo">
                            <div class="col-4 float-start p-0">
			                  	<ul class="extra-number">
			                    <% if $weeks_on_chart == 1 %>
			                        <li class="extra-num light-grey">
			                            --
			                        </li>
			                        <li class="extra-txt settscor{$rank} light-grey">
			                            Sett. Scorsa
			                        </li> 
			                    <% else %>
			                        <li class="extra-num">
			                          	{$last_week}
			                        </li>
			                        <li class="extra-txt settscor{$rank}">
			                            Sett. Scorsa
			                        </li> 
			                    <% end_if %>
			                  	</ul>
			              	</div>
			              	<div class="col-4 float-start p-0">
			                  	<ul class="extra-number border-right-1 border-left-1">
			                  		<li class="extra-num">
			                        	{$peak_rank}
			                      	</li>
			                      	<li class="extra-txt">
			                        	Pos. migliore
			                      	</li>
			                  	</ul>
			              	</div>
			              	<div class="col-4 float-start p-0">
			                  	<ul class="extra-number">
			                  		<li class="extra-num">
			                        	{$weeks_on_chart}
			                      	</li>
			                      	<li class="extra-txt">
			                          	Sett. in classifica
			                      	</li> 
			                  	</ul>
			              	</div>
			            </div>
                    </div>
                </div> 
                <div class="w100"></div> 
                <!-- end pos {$rank} --> 
	      	<% end_loop %>
	    <% else %>
	      	<% loop $SingleClassificaFirst %>  
	      		<!-- pos {$rank} -->
                <div class="col-12 p-0 m-0 mb-3 chart-row chart-row-n{$rank} <% if $rank == 1 || $genre_rank == 1 %>d-none<% end_if %>"> 

                    <div class="col-2 p-0 m-0 float-start">
                        <div class="col-12 p-0">
                            <div id="chart-actual-position{$rank}" class="chart-position">
                                <% if $genre_rank > 0 %>
			                    	{$genre_rank}
			                  	<% else %>
			                    	{$rank}
			                  	<% end_if %> 
                            </div>
                        </div>
                    </div>

                    <div class="col-10 p-0 m-0 float-start">
                        <div class="col-2 p-0 float-start d-none d-lg-block position-relative">
                        	<% if $genre_rank > 0 %>
						  		<% if $last_week > $genre_rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress up-green"> 
		                                <i class="fa fa-arrow-up fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week < $genre_rank && $last_week != 0 %>
						    		<div id="chart-arrow{$rank}" class="chart-progress down-red"> 
		                                <i class="fa fa-arrow-down fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week == $genre_rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress right-grey"> 
		                                <i class="fa fa-arrow-right fa-x2"></i> 
		                            </div> 
						  		<% else_if $last_week == 0 %>
						    		<div id="chart-new{$rank}" class="chart-new">
		                            	<img data-src="/chart5/img/stella_chart.svg" width="30" height="30" alt="NEW" loading="lazy" class="img-fliud lazyload">
		                            </div>
						  		<% end_if %>
							<% else %>
						  		<% if $last_week > $rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress up-green"> 
		                                <i class="fa fa-arrow-up fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week < $rank && $last_week != 0 %>
						    		<div id="chart-arrow{$rank}" class="chart-progress down-red"> 
		                                <i class="fa fa-arrow-down fa-x2"></i> 
		                            </div>
						  		<% else_if $last_week == $rank %>
						    		<div id="chart-arrow{$rank}" class="chart-progress right-grey"> 
		                                <i class="fa fa-arrow-right fa-x2"></i> 
		                            </div> 
							  	<% else_if $last_week == 0 %>
							    	<div id="chart-new{$rank}" class="chart-new">
		                            	<img data-src="/chart5/img/stella_chart.svg" width="30" height="30" alt="NEW" loading="lazy" class="img-fliud lazyload">
		                            </div>
						  		<% end_if %>
							<% end_if %> 

                            <% if $artworkUrl100 %>
	                            <div class="chart-image ci-{$rank}">
	                                <div class="over-image"></div>
	                            	<img data-src="{$artworkUrl100}" title="{$title_single}" width="100" height="100" alt="{$title_single}" loading="lazy" class="img-fliud lazyload">
	                            </div>
                            <% else %>
	                            <div class="chart-image no-chart-image ci-{$rank}">

	                            </div>
                            <% end_if %>
                        </div>
                        <div class="col-10 float-start pt-0 pb-0 position-relative">
                            <div class="chart-content float-start">
                                <h3 class="chart-song-title">{$title_single}</h3>
                                <h5 class="chart-song-author">{$artist_name}</h5>
                                
		          				<% if $artworkUrl100 %>
	                                <ul class="list-inline listenOn">
	                                    <li class="list-inline-item"><a href="{$trackViewUrl}&at=1010lLa5" class="btn-apple-music" title="Ascolta su Apple Music" target="_blank" rel="noopener"></a></li>
				          				<li class="list-inline-item"><a href="{$trackViewUrl}&at=1010lLa5&app=itunes" class="btn-itunes" title="Compra il brano su iTnues" target="_blank" rel="noopener"></a></li>
	                                </ul>
                                <% end_if %>

                                <div title="Maggiori Info su {$title_single} - {$artist_name}" class="infoChart" data-bs-toggle="collapse" href="#chart-info-{$rank}" data-target="#chart-info-{$rank}" aria-expanded="false" aria-controls="chart-info-{$rank}">
		                  			<i class="fa fa-info-circle fa-fw fa-lg grey"></i>
		                  		</div>  

                            </div>
                        </div>
                        <div class="w100"></div>
                    </div> 

                    <div class="w100"></div>
                    <div class="clearfix"></div>

                    <div class="collapse top-shadow col-12 p-0 m-0" id="chart-info-{$rank}">
                        <div class="col-12 mt-3 mb-3 p-0 pt-2 pb-2 chart-moreInfo">
                            <div class="col-4 float-start p-0">
			                  	<ul class="extra-number">
			                    <% if $weeks_on_chart == 1 %>
			                        <li class="extra-num light-grey">
			                            --
			                        </li>
			                        <li class="extra-txt settscor{$rank} light-grey">
			                            Sett. Scorsa
			                        </li> 
			                    <% else %>
			                        <li class="extra-num">
			                          	{$last_week}
			                        </li>
			                        <li class="extra-txt settscor{$rank}">
			                            Sett. Scorsa
			                        </li> 
			                    <% end_if %>
			                  	</ul>
			              	</div>
			              	<div class="col-4 float-start p-0">
			                  	<ul class="extra-number border-right-1 border-left-1">
			                  		<li class="extra-num">
			                        	{$peak_rank}
			                      	</li>
			                      	<li class="extra-txt">
			                        	Pos. migliore
			                      	</li>
			                  	</ul>
			              	</div>
			              	<div class="col-4 float-start p-0">
			                  	<ul class="extra-number">
			                  		<li class="extra-num">
			                        	{$weeks_on_chart}
			                      	</li>
			                      	<li class="extra-txt">
			                          	Sett. in classifica
			                      	</li> 
			                  	</ul>
			              	</div>
			            </div>
                    </div>
                </div> 
                <div class="w100"></div> 
                <!-- end pos {$rank} --> 
	      	<% end_loop %>
	    <% end_if %> 
  	</div>
</div>