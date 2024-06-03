<div class="head-chart page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 p-0 position-relative">
                <h1 id="chart-name" class="position-relative">
                    {$Title}                
                </h1>
                <ul class="title-chart"> 
                    <% if $Week %>
                    <li class="week">
                        La settimana del
                    </li>
                    <li id="week-chart" class="week-date">
                        $firstDayOfWeek($WeekNumber)
                    </li>
                    <% else %>
                    <li class="week">
                        La settimana del
                    </li>
                    <li id="week-chart" class="week-date">
                    <% with $SingleClassificaFirstWeek %>
                        $firstDayOfWeek($WeekNumber)
                    <% end_with %>
                    </li>
                    <% end_if %>
                </ul>
                <ul class="selectDateChart float-end">
                    <li class="date-chart">
                        {$WeekSelectForm}
                    </li>
                    <li>
                        <a class="btn btn-outline-light btn-sm position-absolute" type="button" data-bs-toggle="collapse" data-bs-target="#howItWorks" aria-expanded="false" aria-controls="howItWorks">
                            <i class="fa-solid fa-info"></i> Come funziona?
                        </a>
                    </li>
                </ul>
                <div class="col-12 how-it-works text-center"> 
                    <div class="collapse" id="howItWorks">
                        <div class="card card-body small"> 
                            Le classifiche (<i>Charts</i>) di Billboard Italia <b>Hot 100 Italia</b>, <b>Italian Top 50</b>, <b>Hip-Hop Top 50</b>, <b>Rock Top 50</b> e la <b>Elettronica Top 50</b> sono elaborate sui dati <b>Fimi/Gfk</b> riguardanti i download (<i>a pagamento</i>) della singola traccia, del singolo video, del singolo in bundle (<i>più versioni della stessa canzone</i>), del mixed set single (<i>traccia audio e videoclip</i>), radio edit e audio streaming. La metodologia di conversione degli audio streaming prevede l'attribuzione di 1 download digitale ogni 130 ascolti in streaming. Fino al 31/12/2017 ai fini delle classifiche sono inclusi gli streaming premium (<i>effettuati da abbonamenti a pagamento</i>) e gli streaming ad-supported (<i>effettuati da utenti non paganti</i>). Sono escluse le tracce streaming con durata inferiore a 30 secondi, gli streaming via radio e gli ascolti su piattaforme di video streaming. Dal 1° gennaio 2018 verranno solo considerati gli streaming premium mentre rimane invariato il fattore di conversione. I dati Fimi/Gfk sono, in Italia, gli unici dati di vendita utilizzati dall'industria discografica e rappresentano valori condivisi non solo dalle major ma anche dalle etichette indipendenti. Billboard Italia verifica costantemente le metodologie applicate e dialoga con tutti i principali player della industry per fornire una visione del mercato aderente ai principi che da sempre ne garantiscono l'autorevolezza. <b>Le classifiche di genere vengono elaborate secondo la metodologia indicata utilizzando le prime 1000 posizioni assolute in modo da rappresentare un numero maggiore di artisti.</b>
                        </div>
                    </div> 
                </div> 
            </div>
            <% if $Week %>
                <% loop $SingleClassifica($Week).Limit(1) %>
                <div class="chart-one mb-3 mt-3 w-100">
                    <div class="col-1 float-start p-0 phone-none"></div>
                    <div class="col-4 float-start pl-0"> 
                        <% if $artworkUrl100 %>
                        <div class="chart-image big-image chart-1">
                            <div class="over-image"></div>
                            <img src="{$artworkUrl100}" title="{$title_single} - {$artist_name}" alt="{$title_single}" width="300" class="img-fliud">
                        </div>
                        <% else %>
                        <div class="chart-image no-chart-image big-image"></div>
                        <% end_if %>  
                    </div>
                    <div class="col-7 float-start pr-0">
                        <div class="col-2 float-start">
                            <div class="chart-position chart-actual-position1"> 
                            <% if $genre_rank > 0 %>
                                {$genre_rank}
                            <% else %>
                                {$rank}
                            <% end_if %>  
                            </div>
                        </div>
                        <div class="col-10 float-start p-0">
                            <div class="col-4 float-start p-0 m-1 ml-3 mr-0 box-pos-1 box-pos-1-sx"> 
                                <ul class="extra-number">  
                                    <% if $last_week == 0 %>
                                    <li class="new-p1">
                                        <img src="/chart5/img/stella_chart.svg" class="img-fliud badge-new" alt="Brano Nuovo" title="New">
                                    </li>
                                    <% else %>
                                    <li id="extra-num-lw1" class="extra-num light-grey">
                                        {$last_week}
                                    </li> 
                                    <li class="extra-txt settscor1 light-grey">
                                        Sett. Scorsa
                                    </li>
                                    <% end_if %> 
                                </ul>
                            </div>
                            <div class="col-4 float-start p-0 m-1 mr-0 box-pos-1 phone-none"> 
                                <ul class="extra-number"> 
                                    <li id="extra-num-wksoc1" class="extra-num light-grey">
                                        {$weeks_on_chart}
                                    </li>
                                    <li class="extra-txt light-grey">
                                        Sett. in classifica
                                    </li>
                                </ul> 
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-12 float-start mt-3">
                            <div class="ps-3">
                                <h3 id="song-title1" class="chart-song-title">{$title_single}</h3>
                                <h5 id="song-author1" class="chart-song-author">{$artist_name}</h5>
                                <div class="clearfix"></div>
                                <div class="col-9 p-0 m-0 text-left float-start phone-none" >
                                    <% if $artworkUrl100 %>
                                    <ul class="list-inline listenOn mt-3 mb-0 text-white phone-none">
                                        <li class="list-inline-item pr-2">ASCOLTA IL BRANO SU: </li> 
                                        <li class="list-inline-item">
                                            <a href="{$trackViewUrl}&at=1010lLa5" class="btn-apple-music" title="Ascolta su Apple Music" target="_blank" rel="noopener"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{$trackViewUrl}&at=1010lLa5&app=itunes" class="btn-itunes" title="Compra il brano su iTnues" target="_blank" rel="noopener"></a>
                                        </li> 
                                    </ul>
                                    <% else %>
                                         
                                    <% end_if %>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <% end_loop %>
            <% else %>
                <% loop $SingleClassificaFirst.Limit(1) %>
                <div class="chart-one mb-3 mt-3 w-100">
                    <div class="col-1 float-start p-0 phone-none"></div>
                    <div class="col-4 float-start pl-0">  
                        <% if $artworkUrl100 %>
                        <div class="chart-image big-image chart-1">
                            <div class="over-image"></div>
                            <img src="{$artworkUrl100}" title="{$title_single} - {$artist_name}" alt="{$title_single}" width="300" class="img-fliud">
                        </div>
                        <% else %>
                        <div class="chart-image no-chart-image big-image"></div>
                        <% end_if %> 
                    </div>
                    <div class="col-7 float-start pr-0">
                        <div class="col-2 float-start">
                            <div class="chart-position chart-actual-position1"> 
                            <% if $genre_rank > 0 %>
                                {$genre_rank}
                            <% else %>
                                {$rank}
                            <% end_if %>  
                            </div>
                        </div>
                        <div class="col-10 float-start p-0">
                            <div class="col-4 float-start p-0 m-1 ml-3 mr-0 box-pos-1 box-pos-1-sx"> 
                                <ul class="extra-number">  
                                <% if $last_week == 0 %>
                                    <li class="new-p1">
                                        <img src="/chart5/img/stella_chart.svg" class="img-fliud badge-new" alt="Brano Nuovo" title="New">
                                    </li>
                                <% else %>
                                    <li id="extra-num-lw1" class="extra-num light-grey">
                                        {$last_week}
                                    </li> 
                                    <li class="extra-txt settscor1 light-grey">
                                        Sett. Scorsa
                                    </li>
                                <% end_if %> 
                                </ul>
                            </div>
                            <div class="col-4 float-start p-0 m-1 mr-0 box-pos-1 phone-none"> 
                                <ul class="extra-number"> 
                                    <li id="extra-num-wksoc1" class="extra-num light-grey">
                                        {$weeks_on_chart}
                                    </li>
                                    <li class="extra-txt light-grey">
                                        Sett. in classifica
                                    </li>
                                </ul> 
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-12 float-start mt-3">
                            <div class="ps-3">
                                <h3 id="song-title1" class="chart-song-title">{$title_single}</h3>
                                <h5 id="song-author1" class="chart-song-author">{$artist_name}</h5>
                                <div class="clearfix"></div>
                                <div class="col-9 p-0 m-0 text-left float-start phone-none" >
                                <% if $artworkUrl100 %>
                                    <ul class="list-inline listenOn mt-3 mb-0 text-white phone-none">
                                        <li class="list-inline-item pr-2">ASCOLTA IL BRANO SU: </li>
                                        <li class="list-inline-item">
                                            <a href="{$trackViewUrl}&at=1010lLa5" class="btn-apple-music" title="Ascolta su Apple Music" target="_blank"rel="noopener"rel="noopener"></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{$trackViewUrl}&at=1010lLa5&app=itunes" class="btn-itunes" title="Compra il brano su iTnues" target="_blank"rel="noopener"rel="noopener"></a>
                                        </li> 
                                    </ul>
                                <% else %>
                                     
                                <% end_if %>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <% end_loop %>
            <% end_if %>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="page-wrapper">
    <div class="container single-container">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="col-md-12 text-center p-0">
                        <div class="clearfix"></div>
                        <a href="https://music.apple.com/subscribe?itsct=music_box_badge&amp;itscg=30200&amp;at=1010lLa5&amp;app=music&amp;ls=1" style="display: inline-block; overflow: hidden; border-radius: 0px; width: 728px; height: 90px;"><img src="https://tools.applemediaservices.com/api/badges/apple-music-banner/iphone-gradient-single-title-v4/it-it?size=728x90" alt="Try Apple Music" style="border-radius: 0px; width: 728px; height: 90px;"></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>  
            <div class="col-sm-12 col-md-8 col-lg-8 mt-2" id="br1">
                <% include Classifica %>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 mt-2">
                <% include SideBar %>
            </div>
            <div class="clearfix"></div>  
            <div class="col-12">
                <div class="container">
                    <div class="col-md-12 text-center p-0">
                        <div class="clearfix"></div>
                        <a href="https://music.apple.com/subscribe?itsct=music_box_badge&amp;itscg=30200&amp;at=1010lLa5&amp;app=music&amp;ls=1" style="display: inline-block; overflow: hidden; border-radius: 0px; width: 728px; height: 90px;"><img src="https://tools.applemediaservices.com/api/badges/apple-music-banner/iphone-gradient-single-title-v4/it-it?size=728x90" alt="Try Apple Music" style="border-radius: 0px; width: 728px; height: 90px;"></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>