<!DOCTYPE html>
<!--[if !IE]><!--><html lang="{$ContentLocale}" prefix="og: http://ogp.me/ns#"><!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
  	<head> 
	    <meta charset="utf-8">
	    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=0.86" /> 
	    <% if ForceIE8 %>
		    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" >
		<% end_if %>
	    <% base_tag %>
	    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - $SiteConfig.Title $SiteConfig.Tagline</title>
		<% if $MetaDescription %><meta name="description" content="$MetaDescription"><% else %><meta name="description" content="$Content.Summary().LimitCharacters(150, ...)"><% end_if %>
		<meta name="robots" content="index,follow" /> 
		
		<link rel="dns-prefetch" href="https://connect.facebook.net">
		<link rel='dns-prefetch' href='https://www.google.com' />
		<link rel='dns-prefetch' href='https://www.google.it' />
		<link rel='dns-prefetch' href='https://www.google-analytics.com' />
		<link rel='dns-prefetch' href='https://stats.g.doubleclick.net' />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

	    <meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="theme-color" content="#000000">
		<link rel="apple-touch-icon" sizes="57x57" href="/chart5/icons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/chart5/icons/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/chart5/icons/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/chart5/icons/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/chart5/icons/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/chart5/icons/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/chart5/icons/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/chart5/icons/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/chart5/icons/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="/chart5/icons/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="512x512" href="/chart5/icons/android-icon-512x512.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/chart5/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/chart5/icons/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/chart5/icons/favicon-16x16.png">
		<%-- <link rel="manifest" href="/manifest.json">  --%>
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/chart5/icons/ms-icon-144x144.png"> 

	    <meta property="fb:app_id" content="{$SiteConfig.FbAppId}" />
	    <meta property="og:type" content="website" />
		<meta property="og:title" content="{$Title} || {$SiteConfig.Title}" /> 
		<meta property="og:description" content="{$MetaDescription}" /> 
		<meta property="og:url" content="{$AbsoluteLink}" />
		<meta property="og:site_name" content="{$SiteConfig.Title}" /> 
		<meta property="og:image" content="{$ImmaginePagina.AbsoluteLink}" /> 
		<meta property="og:image:alt" content="{$ImmaginePagina.AbsoluteLink}" /> 
		<meta property="og:locale" content="it_IT" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="{$SiteConfig.TwCreator}" />
		<meta name="twitter:title" content="{$Title} || {$SiteConfig.Title}" />
		<meta name="twitter:description" content="{$MetaDescription}" />
		<meta name="twitter:image" content="{$ImmaginePagina.AbsoluteLink}" />

		<!-- Google Tag Manager -->
		<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','{$SiteConfig.GoogleAnalytics}');
		</script>
        <!-- End Google Tag Manager -->
    
  	</head>